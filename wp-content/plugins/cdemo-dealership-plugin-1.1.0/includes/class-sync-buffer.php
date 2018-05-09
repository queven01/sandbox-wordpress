<?php
/**
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Builds and maintains an internal pointer to the current records buffer to be synchronized from the API.
 *
 * @package cdemo
 * @since 1.0.0
 */
class SyncBuffer {

    use Data;


    /**
     * Transient key prefix for chunks.
     */
    const TRANSIENT_CHUNK_PREFIX = 'cdemo_sync_chunk';


    /**
     * Transient key for the buffer header.
     */
    const TRANSIENT_HEADER = 'cdemo_sync_header';


    /**
     * TTL for the buffer header and chunks.
     */
    const TRANSIENT_TTL = 3600;


    /**
     *
     * @param string|int $total_or_serialized
     * @param int        $chunk_size
     *
     * @since 1.0.0
     */
    public function __construct( $total_or_serialized, $chunk_size = 0 ) {

        if ( is_serialized( $total_or_serialized ) ) {
            $this->unserialize( $total_or_serialized );

        // Initialize buffer header
        } else {

            // Initialize the buffer header
            $this->data = array(

                /**
                 * The total number of chunks in the buffer.
                 *
                 * @since 1.0.0
                 * @var int
                 */
                'chunks' => ceil( $total_or_serialized / $chunk_size ),


                /**
                 * The maximum size of a chunk.
                 *
                 * @since 1.0.0
                 * @var int
                 */
                'chunk_size' => $chunk_size,


                /**
                 * The position of the buffer's internal pointer.
                 *
                 * @since 1.0.0
                 * @var int
                 */
                'pointer' => 0,


                /**
                 * Whether or not the buffer has reached its max number of chunks.
                 *
                 * @since 1.0.0
                 * @var bool
                 */
                'closed' => false,


                /**
                 * Unique ID linking the chunks to the current sync.
                 *
                 * @since 1.0.0
                 * @var int
                 */
                'id' => time()

            );

        }

    }


    /**
     * Write a chunk to the buffer. Returns a \WP_Error if the the size of the chunk exceeds the maximum or false if the
     * buffer has reached its maximum limit.
     *
     * @param array $data
     *
     * @since 1.0.0
     * @return bool|\WP_Error
     */
    public function write_chunk( $data ) {

        // Add records if the buffer isn't maxed out
        if ( !$this->is_closed() ) {

            // Error out if the number of records exceeds our max chunk size
            if ( count( $data ) > $this->get( 'chunk_size' ) ) {
                return new \WP_Error( 'chunk_max_size_exceeded', __( 'Chunk max size exceeded', 'cdemo') );
            }

            // Move pointer to the next chunk
            $pointer = absint( $this->get( 'pointer' ) ) + 1;
            $chunks  = absint( $this->get( 'chunks'  ) );

            // If we still have room to add records
            if ( $pointer <= $chunks ) {

                // Save the chunk to a transient
                if ( set_transient( $this->chunk_name( $pointer ), $data, self::TRANSIENT_TTL ) ) {
                    $header = "pointer=$pointer";

                    // If we are at the max number of chunks, close the buffer and reset the pointer
                    if ( $pointer === $chunks ) {
                        $header = "pointer=0&closed=1";
                    }

                    // Update our buffer header
                    return !!$this->write_header( $header );

                }

            // If we don't have room, close the buffer and reset the pointer
            } else {
                $this->write_header( 'closed=1&pointer=0' );
            }

        }

        // Buffer is closed or no operation could be done
        return false;

    }


    /**
     * If the buffer has closed and we aren't past the last chunk, records will be available for retrieval.
     *
     * @since 1.0.0
     * @return bool
     */
    public function have_records() {
        return $this->is_closed() && $this->get( 'pointer' ) < $this->get( 'chunks' );
    }


    /**
     * Retrieve the next chunk of records from the buffer.
     *
     * @since 1.0.0
     * @return false|array
     */
    public function next_chunk() {

        // Move to the next chunk
        $pointer = absint( $this->get( 'pointer' ) ) + 1;
        $records = get_transient( $this->chunk_name( $pointer ) );

        // Save our position and return the records
        if ( $records ) {
            $this->write_header( "pointer=$pointer" );
            return $records;
        }

        return false;

    }


    /**
     * Check to see if records can still be added to the buffer.
     *
     * @since 1.0.0
     * @return bool
     */
    public function is_closed() {
        return !!$this->get( 'closed' );
    }


    /**
     * Save the buffer in whatever state its currently in.
     *
     * @since 1.0.0
     * @return bool
     */
    public function save() {
        return !!$this->write_header();
    }


    /**
     * Delete the header and all related chunks.
     *
     * @since 1.0.0
     * @return void
     */
    public function clear() {

        // Loop through and cleanup the buffer
        for ( $ctr = 1; $ctr <= $this->get( 'chunks' ); $ctr++ ) {
            delete_transient( $this->chunk_name( $ctr ) );
        }

        // Delete the current buffer header
        delete_transient( self::TRANSIENT_HEADER );

    }


    /**
     * Fetch an initialized buffer.
     *
     * @since 1.0.0
     * @return bool|SyncBuffer
     */
    public static function fetch() {

        $header = get_transient( self::TRANSIENT_HEADER );

        if ( !empty( $header ) ) {
            return new self( $header );
        }

        return false;

    }


    /**
     * Return the chunk name for a chunk ID.
     *
     * @param $id
     *
     * @since 1.0.0
     * @return string
     */
    private function chunk_name( $id ) {
        return strcat( self::TRANSIENT_CHUNK_PREFIX, '-', $this->get( 'id' ), '_', $id );
    }


    /**
     * Unserialize the headers.
     *
     * @since 1.0.0
     * @param $serialized
     */
    private function unserialize( $serialized ) {

        $data = unserialize( $serialized );

        if ( $data ) {
            $this->data = array_merge( $this->data, $data );
        }

    }


    /**
     * Updates the buffer and then saves its state to the transient.
     *
     * @param array $header
     *
     * @since 1.0.0
     * @return false|mixed
     */
    private function write_header( $header = array() ) {

        // Merge arguments with the current header
        $data = array_merge( $this->data, wp_parse_args( $header ) );

        // If updated, update our copy of the headers
        if ( set_transient( self::TRANSIENT_HEADER, serialize( $data ), self::TRANSIENT_TTL ) ) {
            return $this->data = $data;

        }

        return false;

    }

}
