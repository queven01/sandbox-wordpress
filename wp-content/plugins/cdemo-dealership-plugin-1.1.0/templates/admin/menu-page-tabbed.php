<?php

namespace cdemo;?>

<div class="wrap cdemo-admin-page">

    <?php do_action( 'cdemo_admin_header', $page ); ?>

    <?php settings_errors(); ?>

    <h2 class="nav-tab-wrapper">

        <?php foreach( $tabs as $tab => $title ) : ?>

            <a href="<?php echo add_query_arg( 'tab', $tab, $baseurl ); ?>"
               class="nav-tab <?php echo $active == $tab ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( $title ); ?></a>

        <?php endforeach; ?>

    </h2>

    <div id="cdemo-settings-wrapper">
        <div class="tabs-content">

            <?php do_menu_page_tab( $page, $active ); ?>

        </div>

        <div class="cdemo-admin-sidebar">
            <?php get_template( 'admin/settings-sidebar.php') ?>
        </div>

    </div>
    
</div>
