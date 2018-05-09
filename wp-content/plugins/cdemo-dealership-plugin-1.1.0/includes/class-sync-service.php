<?php
/**
 *
 * @since 1.0.0
 * @package ccdemo
 */
namespace cdemo;


// Process some records on every request
add_action( 'init', 'cdemo\get_sync_instance', 100 );


/**
 * API Sync provider.
 *
 * @singleton
 * @since 1.0.0
 */
class SyncService {

    use Singleton;


    /**
     * API Client.
     *
     * @access private
     * @since 1.0.0
     * @var DataDriverClient
     */
    private $client = false;


    /**
     * Current records buffer.
     *
     * @access private
     * @since 1.0.0
     * @var bool|SyncBuffer
     */
    private $buffer = false;


    /**
     * The maximum number of records to group in a chunk.
     */
    const MAX_CHUNK_SIZE = 5;


    /**
     * Transient for pausing the sync.
     */
    const TRANSIENT_PAUSED = 'cdemo_sync_paused';


    /**
     * Initialize the object instance.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function initialize() {

        // Start the API client
        $this->start_client();

        // Try to catch the current sync buffer
        $this->buffer = SyncBuffer::fetch();


        // If we have a record buffer in progress
        if ( $this->buffer ) {

            if ( $this->buffer->is_closed() ) {
                $this->process_records();

            } else {
                $this->buffer_records();
            }

        }

    }


    /**
     * Start our API client.
     *
     * @since 1.0.0
     * @return void
     */
    private function start_client() {
        $this->client = new DataDriverClient();
    }


    /**
     * Process records in the queue.
     *
     * @since 1.0.0
     * @return void
     */
    private function process_records() {

        if ( $this->buffer->have_records() ) {

            if ( !$this->is_paused() ) {
                $chunk = $this->buffer->next_chunk();

                if ( $chunk ) {

                    // Loop through the group of records and synchronize each one
                    foreach ( $chunk as $record ) {
                        sync_record( $record );
                    }

                }

            }

        // Update the last sync date and clear the buffer
        } else {
            $this->set_sync_timestamp();
            $this->buffer->clear();
        }

    }


    /**
     * Fetch records from the cDemo API and store them for future processing.
     *
     * @since 1.0.0
     * @return void
     */
    private function buffer_records() {

        $buffer = $this->buffer;

        // Initialize a new buffer
        if ( empty( $buffer ) ) {

            $exclude = array(
                'chrome_equipments',
                'chrome_packages',
                'chrome_consumer_info'
            );

            $args = array(
                'page_size'          => self::MAX_CHUNK_SIZE,
                'exclude_fields'     => implode( ',', $exclude ),
                'last_mod_date_from' => $this->get_last_sync_timestamp(),
//                'product_id'         => 1061,
                'status'             => 1
            );

            // Get the first set of records from the API
            $records = $this->client->get_records( $args );

            if ( $records ) {
                $paginate = $records['pagination'];
                $this->buffer = new SyncBuffer( $paginate['total'], self::MAX_CHUNK_SIZE );

                if ( $this->buffer->save() ) {
                    // Save the link to the next record page in the buffer header
                    $this->buffer->set( 'next', $paginate['next'] );
                    // Write the group of records
                    $this->buffer->write_chunk( $records['records'] );
                }

            }

        } else {

            // If there is still room to add records
            if ( !$buffer->is_closed() ) {
                $records = $this->client->get_records( $buffer->get( 'next' ) );

                if ( $records ) {
                    // Save the link to the next record page in the buffer header
                    $this->buffer->set( 'next', $records['pagination']['next'] );
                    // Write the group of records
                    $this->buffer->write_chunk( $records['records'] );
                }

            }

        }

    }


    /**
     * Set the last sync timestamp
     *
     * @since 1.0.0
     * @return void
     */
    private function set_sync_timestamp() {
        update_option( Options::LAST_SYNC, gmdate( 'Y-m-d', time() ) );
    }


    /**
     * Get the time sync the last sync completed.
     *
     * @return false|string
     */
    private function get_last_sync_timestamp() {
        return get_option( Options::LAST_SYNC );
    }


    /**
     * Check if the sync operation is paused.
     *
     * @since 1.0.0
     * @return bool
     */
    public function is_paused() {
        return $this->buffer->have_records() && get_transient( self::TRANSIENT_PAUSED );
    }


    /**
     * Start a sync operation. If there is already a sync in progress, the status of the current sync will be returned.
     *
     * @since 1.0.0
     * @return array
     */
    public function start() {

        // Start buffering records
        if ( !$this->buffer ) {
            $this->buffer_records();

        // Resume an already in progress sync
        } else if ( $this->is_paused() ) {
            $this->resume();
        }

        return $this->state();

    }


    /**
     * Try to resume syncing, returns true on success or false on failure or if the sync was already paused.
     *
     * @since 1.0.0
     * @return bool
     */
    public function resume() {

        if ( $this->is_paused() ) {
            return delete_transient( self::TRANSIENT_PAUSED );
        }

        return false;

    }


    /**
     * Pause the current sync operation.
     *
     * @since 1.0.0
     * @return bool
     */
    public function pause() {

        if ( !$this->is_paused() ) {
            return set_transient( self::TRANSIENT_PAUSED, true );
        }

        return false;

    }


    /**
     * Get information about the current sync operation. Details include the status, progress and message.
     *
     * @since 1.0.0
     * @return array
     */
    public function state() {

        $state = array(
            'progress' => 0,
            'status'   => 'idle',
            'message'  => __( 'Not syncing', 'cdemo' )
        );

        if ( $this->buffer ) {
            $chunks   = absint( $this->buffer->get( 'chunks',  0 ) );
            $position = absint( $this->buffer->get( 'pointer', 0 ) );

            if ( $chunks > 0 ) {
                $state['progress'] = ceil( $position / $chunks * 100 );
            }

            if ( $this->is_paused() ) {
                $state['status']  = 'paused';
            } else if ( !$this->buffer->is_closed() ) {
                $state['status']  = 'buffering';
                $state['message'] = __( 'Fetching PIM records', 'cdemo' );
            } else {
                $state['status']  = 'started';
                $state['message'] = __( 'Synchronizing records', 'cdemo' );
            }

        }

        return $state;

    }

}
