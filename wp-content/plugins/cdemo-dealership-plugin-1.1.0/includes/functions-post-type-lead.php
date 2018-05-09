<?php
/**
 * Functions for managing the lead post type.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Register the lead post type
add_action( 'init', 'cdemo\register_lead_post_type' );

// Handle contact form submit
add_action( 'cdemo_contact_form_submit', 'cdemo\create_lead', 10, 3 );

// Display custom columns
add_action( 'manage_lead_posts_custom_column', 'cdemo\manage_lead_posts_column', 10, 2 );


// Add custom row actions
add_filter( 'post_row_actions', 'cdemo\lead_row_actions', 10, 2 );

// Add custom columns
add_filter( 'manage_lead_posts_columns', 'cdemo\manage_lead_custom_columns' );

// Set sortable columns
add_filter( 'manage_edit-lead_sortable_columns', 'cdemo\manage_lead_sortable_columns' );


/**
 * Register the lead post type.
 *
 * @action init
 *
 * @since 1.0.0
 * @return void
 */
function register_lead_post_type() {

    $labels = array(
        'name'               => _x( 'Leads', 'post type general name', 'cdemo' ),
        'singular_name'      => _x( 'Lead', 'post type singular name', 'cdemo' ),
        'add_new'            => _x( 'Add New', 'lead', 'cdemo' ),
        'add_new_item'       => __( 'Add New Lead', 'cdemo' ),
        'new_item'           => __( 'New Lead', 'cdemo' ),
        'edit_item'          => __( 'Edit Lead', 'cdemo' ),
        'view_item'          => __( 'View Lead', 'cdemo' ),
        'all_items'          => __( 'Leads', 'cdemo' ),
        'search_items'       => __( 'Search Leads', 'cdemo' ),
        'not_found'          => __( 'No leads found.', 'cdemo' ),
        'not_found_in_trash' => __( 'No leads found in Trash.', 'cdemo' ),
        'archives'           => __( 'Lead Archives', 'cdemo' ),
        'attributes'         => __( 'Lead Attributes', 'cdemo' )
    );

    $args = array(
        'labels'               => $labels,
        'public'               => false,
        'capability_type'      => 'post',
        'show_ui'              => true,
        'show_in_menu'         => false,
        'show_in_admin_bar'    => true,
        'supports'             => array( 'editor' ),
        'register_meta_box_cb' => function () {
            add_meta_box( 'cdemo-lead', __( 'Lead Details', 'cdemo' ), 'cdemo\render_lead_metabox' );
        }
    );

    register_post_type( 'lead', $args );

}


/**
 * Create a new lead when the contact form is submitted.
 *
 * @action cdemo_contact_form_submit
 *
 * @param $type
 * @param $id
 * @param $contact
 *
 * @since 1.0.0
 * @return void
 */
function create_lead( $type, $id, $contact ) {

    $lead = array(
        'post_author'   => is_user_logged_in() ? wp_get_current_user()->ID : 0,
        'post_content'  => !empty( $contact['comments'] ) ? $contact['comments'] : '',
        'post_type'     => 'lead',
        'post_status'   => 'publish',
        'meta_input'    => array(
            'listing_id' => absint( $id ),
            'type'       => sanitize_text_field( $type ),
            'name'       => sanitize_text_field( $contact['name'] ),
            'preferred'  => sanitize_text_field( $contact['preferred'] ),
            'phone'      => sanitize_text_field( $contact['phone'] ),
            'email'      => sanitize_email( $contact['email'] )
        )
    );

    if ( $type == 'test_drive' ) {
        $lead['meta_input']['requested_time'] = date( 'Y-m-d h:i A', strtotime( $contact['time'] ) );
    }

    $id = wp_insert_post( $lead, true );

    if ( !is_wp_error( $id ) ) {
        do_action( 'cdemo_lead_created', $id, $lead['meta_input'] );
    }

}


/**
 * Add custom row actions to the lead posts table.
 *
 * @filter post_row_actions
 *
 * @param $actions
 * @param $post
 *
 * @since 1.0.0
 * @return array
 */
function lead_row_actions( $actions, $post ) {

    if ( $post->post_type == 'lead' ) {

        $custom  = array();
        $listing = get_post( $post->post_parent );

        if ( isset( $actions['edit'] ) ) {
            $custom['edit'] = $actions['edit'];
        }

        if ( $listing ) {
            $custom['view-listing'] = sprintf( '<a href="%s">%s</a>', get_edit_post_link( $listing->ID ), __( 'Listing', 'cdemo' ) );
        }

        $actions = array_merge( $custom, $actions );

    }

    return $actions;

}


/**
 * Add custom columns to the lead posts table
 *
 * @filter manage_lead_posts_columns
 *
 * @param $columns
 *
 * @since 1.0.0
 * @return array
 */
function manage_lead_custom_columns( $columns ) {

    $custom = array(
        'cb'        => $columns['cb'],
        'listing'   => __( 'For Listing', 'cdemo' ),
        'type'      => __( 'Type', 'cdemo' ),
        'name'      => __( 'Name', 'name' ),
        'preferred' => __( 'Preferred Contact', 'cdemo' ),
        'email'     => __( 'Email', 'cdemo' ),
        'phone'     => __( 'Phone', 'cdemo' ),
    );

    unset( $columns['title'] );

    return array_merge( $custom, $columns );

}


/**
 * Set lead posts table sortable columns.
 *
 * @filter manage_edit-lead_sortable_columns
 *
 * @param $columns
 *
 * @since 1.0.0
 * @return array
 */
function manage_lead_sortable_columns( $columns ) {

    $sortable = array(
        'listing'    => array( 'listing_id', true ),
        'preferred'  => array( 'preferred', true ),
        'name'       => array( 'name', true ),
        'email'      => array( 'email', true ),
        'phone'      => array( 'phone', true ),
        'type'       => array( 'type', true ),
    );

    return array_merge( $columns, $sortable );

}


/**
 * Output lead posts table custom columns.
 *
 * @action manage_lead_posts_custom_column
 *
 * @param $column
 * @param $post_id
 *
 * @since 1.0.0
 * @return void
 */
function manage_lead_posts_column( $column, $post_id ) {

    switch( $column ) {

        case 'listing':

            $listing_title = '-';
            $listing_id    = get_post_meta( $post_id, 'listing_id', true );

            if ( $listing_id ) {

                $listing = get_post( $listing_id );

                if ( $listing ) {
                    $listing_title = $listing->post_title;
                }

            }

            echo $listing_title;

            break;

        case 'email':

            esc_attr_e( get_post_meta( $post_id, $column, true ) ?: '-' );

            break;

        case 'type':

            $type = get_post_meta( $post_id, $column, true );

            if ( $type == 'contact' ) {
                _e( 'Contact', 'cdemo' );
            } else if ( $type == 'test_drive' ) {
                _e( 'Test Drive', 'cdemo' );
            } else {
                echo '-';
            }

            break;

        case 'phone':

            $phone = get_post_meta( $post_id, $column, true );

            if ( $phone ) {

                $code  = substr( $phone, 0, 3 );
                $exch  = substr( $phone, 3, 3 );
                $sub   = substr( $phone, 6, 4 );

                echo "($code) $exch-$sub";

            }

            break;

        default :

            esc_attr_e( ucwords( get_post_meta( $post_id, $column, true ) ) ?: '-' );

            break;

    }

}
