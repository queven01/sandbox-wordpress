<?php

namespace cdemo;

?>

<div class="wrap">

	<h1 class="wp-heading-inline"><?php _e( 'Inventory', 'cdemo' ); ?></h1>
	<a href="<?php echo esc_url( admin_url( 'admin.php?page=cdemo-new-listing' ) ); ?>" class="page-title-action"><?php _e( 'Add New', 'cdemo' ); ?></a>

    <?php if ( !empty( $_GET['s'] ) ) : ?>

        <span class="subtitle"><?php _e( 'Search results for ', 'cdemo' ); ?> “<?php esc_attr_e( $_GET['s'] ); ?>”</span>

    <?php endif; ?>

    <hr class="wp-header-end">

    <?php $table->views(); ?>

    <form id="items-filter" action="?">

        <p class="search-box">
            <input type="search" id="post-search-input" name="s" value="<?php echo isset( $_GET['s'] ) ? esc_attr( $_GET['s'] ) : ''; ?>">
            <input type="submit" id="search-submit" class="button" value="<?php _e( 'Search Inventory', 'cdemo' ); ?>">
        </p>

	    <?php $table->display(); ?>

        <input type="hidden" name="inventory_page">
        <input type="hidden" name="page" value="<?php esc_attr_e( $_GET['page'] ); ?>">

        <?php if ( !empty( $_GET['post_status'] ) ) : ?>

            <input type="hidden" name="post_status" value="<?php esc_attr_e( $_GET['post_status'] ); ?>">

        <?php endif; ?>

    </form>

</div>
