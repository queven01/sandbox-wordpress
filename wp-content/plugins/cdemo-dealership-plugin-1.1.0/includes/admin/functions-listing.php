<?php
/**
 * Functions for managing listing post types.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Append custom status options
add_action( 'admin_footer-post.php',     'cdemo\append_custom_status_options' );
add_action( 'admin_footer-post-new.php', 'cdemo\append_custom_status_options' );

// Override new post link
add_filter( 'admin_url', 'cdemo\set_new_post_link', 10, 2 );


/**
 * Override default the link for creating new listing post types.
 *
 * @filter admin_url
 *
 * @param $url
 * @param $path
 *
 * @since 1.0.0
 * @return string
 */
function set_new_post_link( $url, $path ) {

    if ( strpos( $path, 'post-new.php' ) !== false ) {

        $post_types = active_listing_types();

        foreach ( $post_types as $type ) {

            if ( strpos( $path, "post_type=$type" ) !== false ) {
                return 'admin.php?page=cdemo-new-listing';
            }

        }

    }

    return $url;

}


/**
 * Append custom status options to the publish post box.
 *
 * @action admin_footer-post.php
 * @action admin_footer-post-new.php
 *
 * @since 1.0.0
 * @return void
 */
function append_custom_status_options() {

    if ( in_array( get_post_type(), active_listing_types() ) ) {

        $options = '';
        $display = '';

        foreach ( listing_custom_statuses() as $status => $args ) {

            $selected = selected( get_post_status(), $status, false );
            $options .= "<option{$selected} value='{$status}'>{$args['label']}</option>";

            if ( $selected ) {
                $display = $args['label'];
            }

        }

        ?><script type="text/javascript">

            jQuery( document ).ready( function( $ ) {

                <?php if ( !empty( $display ) ) : ?>

                $( '#post-status-display' ).html( '<?php echo $display; ?>' );

                <?php endif; ?>

                $( '#post-status-select' ).find( 'select' ).append( "<?php echo $options; ?>" );

            } );

        </script><?php

    }

}
