<?php
/**
 * Functions for handling admin metaboxes.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Update meta locks
add_action( 'save_post', 'cdemo\set_meta_locks', 10, 3 );

// Automatically save meta when the metabox is saved
add_action( 'save_post', 'cdemo\save_metabox', 10, 3 );


/**
 * Dynamically save registered meta fields.
 *
 * @action save_post
 *
 * @param int      $post_id
 * @param \WP_Post $post
 * @param bool     $update
 *
 * @since 1.0.0
 * @return void
 */
function save_metabox( $post_id, $post, $update ) {

    $fields = get_registered_meta( $post->post_type );

    if ( $update && $fields && check_metabox_nonce( $post->post_type ) ) {

        foreach ( $fields as $key => $field ) {

            if ( isset( $_POST[ $key ] ) ) {
                $data = $_POST[ $key ];

                // If we are handling meta arrays
                if ( is_array( $_POST[ $key ] ) && !$field['single'] ) {
                    update_meta_array( $post_id, $key, $data );

                // If we are handling single keys
                } else if ( $field['single'] ) {
                    update_post_meta( $post_id, $key, $data, get_post_meta( $post_id, $key, true ) );
                }

            }

        }

    }

}


/**
 * Set meta field locks when metabox is saved.
 *
 * @action save_post
 *
 * @param int      $post_id
 * @param \WP_Post $post
 * @param bool     $update
 *
 * @since 1.0.0
 * @return void
 */
function set_meta_locks( $post_id, $post, $update ) {

    $fields = get_registered_meta( $post->post_type );

    if ( $update && $fields && check_metabox_nonce( $post->post_type ) ) {

        foreach ( $fields as $key => $field ) {

            if ( $field['lockable'] ) {
                set_meta_lock( $post, $key, (bool) pluck( $_POST, "{$key}_locked" ) );
            }

        }

    }

}


/**
 * Register metaboxes for listing post types.
 *
 * @since 1.0.0
 * @return void
 */
function register_listing_metaboxes() {

    $type = get_post_type();

    $args = array(
        'post_type' => $type
    );

    add_meta_box(
        "cdemo-$type", __( 'Vehicle Information', 'cdemo' ), 'cdemo\render_listing_metabox', null, 'advanced', 'default', $args );

}


/**
 * Render the listing metabox.
 *
 * @param $post
 * @param $metabox
 *
 * @since 1.0.0
 * @return void
 */
function render_listing_metabox( $post, $metabox ) {

    // Get the template for the metabox
    if ( get_template( 'admin/metabox-' . $metabox['args']['post_type'] ) ) {
        meta_fields( $post->post_type );
    }

}


/**
 * Output the lead metabox.
 *
 * @since 1.0.0
 * @return void
 */
function render_lead_metabox() {
    get_template( 'admin/metabox-lead' );
}


/**
 * Output the nonce for custom meta fields to be saved. Meta fields must be registered with register_post_meta().
 *
 * @param $post_type
 *
 * @since 1.0.0
 * @return void
 */
function meta_fields( $post_type ) {
    wp_nonce_field( "cdemo_save_$post_type", 'cdemo_metabox_nonce' );
}


/**
 * Check to see if the save post request is valid.
 *
 * @param string $type
 *
 * @since 1.0.0
 * @return false|int
 */
function check_metabox_nonce( $type ) {
    return check_request_nonce( 'cdemo_metabox_nonce', "cdemo_save_$type" );
}


/**
 * Output the meta field lock for a post.
 *
 * @param string            $field
 * @param null|int|\WP_Post $post
 *
 * @since 1.0.0
 * @return bool
 */
function meta_field_lock( $field, $post = null ) {

    $post = get_post( $post );

    if ( $post && is_meta_field_lockable( $post, $field ) ) { ?>

        <input type="checkbox"
               class="cdemo-metafield-lock"
               id="<?php esc_attr_e( "{$field}_lock" ); ?>"
               name="<?php esc_attr_e( "{$field}_locked" ); ?>"

            <?php checked( true, is_meta_locked( $post, $field ) ); ?> />

        <label class="meta-field-tooltip"
               for="<?php esc_attr_e( "{$field}_lock" ); ?>"
               title="<?php _e( 'Prevent field from being overwritten', 'cdemo' ); ?>">
        </label>

    <?php } else {
        return false;
    }

    return true;

}