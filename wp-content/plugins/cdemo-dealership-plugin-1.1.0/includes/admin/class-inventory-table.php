<?php

namespace cdemo;


class InventoryTable extends ListTable {


	public function __construct() {

		$args = array(
			'singular' => __( 'Item', 'cdemo' ),
			'plural'   => __( 'Items', 'cdemo' ),
			'ajax'     => false
		);

		parent::__construct( $args );

	}


	public function get_columns() {

		$columns = array(
			'cb'                => '<input type="checkbox />',
			'title'             => __( 'Title', 'cdemo' ),
			'vin'               => __( 'VIN', 'cdemo' ),
			'stock_no'          => __( 'Stock #', 'cdemo' ),
			'vehicle_type'      => __( 'Vehicle Type', 'cdemo' ),
			'year_manufactured' => __( 'Year', 'cdemo' ),
			'make'              => __( 'Make', 'cdemo' ),
			'model'             => __( 'Model', 'cdemo' ),
			'price'             => __( 'Price', 'cdemo' ),
			'special'           => __( 'Special', 'special' ),
			'vdp_views'         => __( 'VDP Views', 'cdemo' )
		);

		return $columns;

	}


	public function get_sortable_columns() {

		$sortable = array(
			'title'             => array( 'title', true ),
			'vehicle_type'      => array( 'vehicle_type', true ),
			'year_manufactured' => array( 'year', true ),
			'make'              => array( 'make', true ),
			'model'             => array( 'model', true ),
			'price'             => array( 'price', true ),
			'special'           => array( 'special', true ),
			'vdp_views'         => array( 'vdp_views', true )
		);

		return $sortable;

	}


	public function get_bulk_actions() {

		$actions = array(
			'bulk-delete' => __( 'Delete', 'cdemo' )
		);

		if ( isset( $_GET['post_status'] ) && $_GET['post_status'] == 'trash' ) {
			$actions['bulk-restore'] = __( 'Restore', 'cdemo' );
		}

		return $actions;

	}


	public function prepare_items() {

		$redirect = $this->process_bulk_action();

		if ( $redirect ) {
			wp_safe_redirect( $redirect );
			exit();
		} else if ( isset( $_REQUEST['_wp_http_referer'] ) ) {
			wp_safe_redirect( remove_query_arg( array( '_wp_http_referer', '_wpnonce' ) ) );
			exit();
		}

		$screen   = get_current_screen();
		$option   = $screen->get_option( 'per_page', 'option' );
        $per_page = get_user_meta( get_current_user_id(), $option, true);

        if ( empty( $per_page ) || $per_page < 1 ) {
            $per_page = $screen->get_option( 'per_page', 'default' );
        }

		$current     = $this->get_pagenum();
		$total_items = $this->record_count( !empty( $_GET['post_status'] ) ? $_GET['post_status'] : 'all' );

		$paginate_args = array(
			'total_items' => $total_items,
			'per_page'    => $per_page
		);

		$this->set_pagination_args( $paginate_args );

		$this->items = $this->get_items( $per_page, $current );
		$this->_column_headers = array( $this->get_columns(), array(), $this->get_sortable_columns() );

	}


	private function get_items( $per_page, $page_number = 1 ) {

		$args = array(
			'paged'          => $page_number,
			'posts_per_page' => $per_page,
			'post_type'      => active_listing_types()
		);

		$q = new \WP_Query( array_merge( $args, $_GET ) );

		return $q->posts;

	}


	private function record_count( $status = 'publish' ) {

		$total = 0;

		foreach ( active_listing_types() as $type ) {

		    if ( $status == 'all' ) {

		        $statuses = array(
                    'publish',
                    'draft',
                    'hidden',
                    'sold',
                    'pending',
                    'private'
                );

		        foreach ( $statuses as $stat ) {
                    $total += wp_count_posts( $type )->$stat;
                }

            } else {
                $total += wp_count_posts( $type )->$status;
            }


		}

		return $total;

	}


	private function delete_item( $id ) {

		$items = $this->get_items_by_id( $id );

		foreach( $items->posts as $post ) {

			if ( $post->post_status !== 'trash' ) {
				wp_trash_post( $post->ID );
			} else {
				wp_delete_post( $post->ID, true );
			}

		}

	}


	private function restore_item( $id ) {

		$items = $this->get_items_by_id( $id );

		foreach( $items->posts as $post ) {

			if ( $post && $post->post_status == 'trash' ) {
				wp_untrash_post( $post->ID );
			}

		}

	}


	private function empty_trash() {

		$args = array(
			'post_type'      => active_listing_types(),
			'posts_per_page' => -1,
			'post_status'    => 'trash'
		);

		$q = new \WP_Query( $args );


		foreach ( $q->posts as $post ) {
			wp_delete_post( $post->ID, true );
		}

	}


	private function get_items_by_id( $id ) {

		$q = array(
			'post__in'       => is_array( $id ) ? $id : array( $id ),
			'post_type'      => active_listing_types(),
			'posts_per_page' => -1,
			'post_status'    => 'all'
		);

		return new \WP_Query( $q );

	}


	private function process_bulk_action() {

		$action   = $this->current_action();
		$redirect = wp_get_referer();

		if ( $action ) {

			switch ( $action ) {

				case 'delete':

					if ( check_admin_referer( 'delete_item' ) && isset( $_GET['item'] ) ) {
						$this->delete_item( $_GET['item'] );
					}

					break;

				case 'untrash':

					if ( check_admin_referer( 'restore_item' ) && isset( $_GET['item'] ) ) {
						$this->restore_item( $_GET['item'] );
					}

					break;

				case 'bulk-delete':

					if (check_admin_referer( 'bulk-' . $this->_args['plural'] ) ) {
						$this->delete_item( $_GET['bulk-action'] );
					}

					break;

				case 'bulk-restore':

					if ( check_admin_referer( 'bulk-' . $this->_args['plural'] ) ) {
						$this->restore_item( $_GET['bulk-action'] );
					}

					break;

				case 'empty_trash':

					if ( check_admin_referer( 'bulk-' . $this->_args['plural'] ) ) {
						$this->empty_trash();
					}

					break;

			}


			if ( $this->record_count( 'trash' ) == 0 ) {
				$redirect = '?page='. esc_attr( $_GET['page'] );
			}


			return $redirect;

		}

		return false;

	}


	public function column_cb( $item ) {

		return sprintf(
			'<input type="checkbox" name="bulk-action[]" value="%s" />', $item->ID
		);

	}

	public function column_title( $item ) {

		$delete_nonce  = wp_create_nonce( 'delete_item' );
		$restore_nonce = wp_create_nonce( 'restore_item' );

		if ( isset( $_GET['post_status'] ) && $_GET['post_status'] == 'trash' ) {

			$actions = array(
				'restore' => sprintf(
					'<a href="?page=%s&action=untrash&item=%s&_wpnonce=%s">%s</a>',
					esc_attr( $_GET['page'] ), $item->ID,$restore_nonce,  __( 'Restore', 'cdemo' )
				),
				'delete' => sprintf(
					'<a href="?page=%s&action=delete&item=%s&_wpnonce=%s">%s</a>',
					esc_attr( $_GET['page'] ), $item->ID, $delete_nonce,  __( 'Delete Permanently', 'cdemo' )
				)
			);

			$title = sprintf(
				'<strong>%s</strong>', $item->post_title
			);

		} else {

			$actions = array(
				'edit' => sprintf(
					'<a href="post.php?post=%s&action=edit">%s</a>', $item->ID, __( 'Edit', 'cdemo' )
				),
				'delete' => sprintf(
					'<a href="?page=%s&action=delete&item=%s&_wpnonce=%s">%s</a>',
					esc_attr( $_REQUEST['page'] ), absint( $item->ID ), $delete_nonce, __( 'Trash', 'cdemo' )
				),
				'view' => sprintf(
					'<a href="%s">%s</a>', get_permalink( $item ), __( 'View', 'cdemo' )
				)
			);

			$title = sprintf(
				'<strong><a href="post.php?post=%s&action=edit">%s</a></strong>', $item->ID, $item->post_title
			);

		}

		return $title . $this->row_actions( $actions );

	}


	public function column_vehicle_type( $item ) {

		return get_post_type_object( $item->post_type )->labels->singular_name;

	}

    public function column_price( $item ) {

        return $this->format_currency( $item, get_post_meta( $item->ID, 'listing_price', true ) ?: 0 );

    }

    public function column_special( $item ) {

        return $this->format_currency( $item, get_post_meta( $item->ID, 'sale_price', true ) ?: 0 );

    }

    private function format_currency( $item, $value ) {

	    return format_currency( $value, get_listing_currency( $item ) ) ?: '–';


    }

	public function column_default( $item, $column_name ) {

		$meta = get_post_meta( $item->ID, $column_name, true );

		if ( !empty( $meta ) ) {
			return $meta;
		}

		return '-';

	}


	public function no_items() {

		_e( 'No Listings found.', 'cdemo' );

	}

	public function get_views() {

		$views = array(
			'all' => sprintf( '<a href="?page=%s" class="%s">%s <span class="count">(%s)</span></a>',
				$_GET['page'], empty( $_GET['post_status'] ) ? 'current' : '', __( 'All', 'cdemo' ), $this->record_count( 'all' )
			)
		);

        $custom = array(
            'publish' => __( 'Published', 'cdemo' ),
            'sold'    => __( 'Sold', 'cdemo' ),
            'hidden'  => __( 'Hidden', 'cdemo' ),
            'trash'   => __( 'Trash', 'cdemo' )
        );

        foreach ( $custom as $status => $title ) {

            $count = $this->record_count( $status );

            if ( $count > 0 ) {
                $views[ $status ] = sprintf( '<a href="?page=%s&post_status=%s" class="%s">%s <span class="count">(%s)</span></a>',
                    $_GET['page'], $status, isset( $_GET['post_status'] ) && $_GET['post_status'] == $status ? 'current' : '', $title, $count );
            }

        }

		return $views;

	}


	public function extra_tablenav( $which ) {

		if ( $which == 'top' ) {

			echo '<div class="alignleft actions">';

			if ( isset( $_GET['post_status'] ) && $_GET['post_status'] == 'trash' && !empty( $this->items ) ) {
				echo '<button name="action" id="delete_all" class="button apply" value="empty_trash">' . __( 'Empty Trash', 'cdemo' ) . '</button>';
			}

			echo '</div>';

		}

	}

}
