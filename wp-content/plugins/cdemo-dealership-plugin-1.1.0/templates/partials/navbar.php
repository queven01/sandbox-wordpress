<?php

namespace cdemo;

$navbar = array(
    'menu'              => 'header',
    'theme_location'    => 'cdemo_header',
    'depth'             => 2,
    'menu_class'        => 'nav navbar-nav',
    'fallback_cb'       => 'cdemo\BootstrapNavWalker::fallback',
    'walker'            => new BootstrapNavWalker()
);


$category = get_post_type_object( is_single() ? get_post_type() : $the_query->get( 'vehicle_category' ) );

?>

<div class="container-fluid wrapper">

    <div class="row">

        <nav class="navbar navbar-default">

            <div class="navbar-header">
                <div class="v-center-table">
                    <div class="v-center">
                        <a href="<?php echo esc_url( home_url() ); ?>">
                            <img class="navbar-logo img-responsive" src="<?php echo esc_url( get_option( Options::COMPANY_LOGO ) ); ?>">
                        </a>
                    </div>
                </div>

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#cdemo-header-navbar" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <div id="cdemo-header-navbar" class="collapse navbar-collapse">

                <?php $types = active_listing_types(); ?>

                <div>

                    <ul class="nav navbar-nav">

                        <li class="dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span><?php esc_html_e( !empty( $category ) ? $category->label : __( 'Categories', 'cdemo' ) ); ?></span> <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">

                                <?php foreach ( $types as $type ) : $type = get_post_type_object( $type ); ?>

                                    <li class="<?php echo !empty( $category ) && $category->name == $type->name ? 'active' : ''; ?>">

                                        <a href="<?php echo esc_url( search_url( "?vehicle_category=$type->name" ) ); ?>">
                                            <?php esc_html_e( $type->label ); ?>
                                        </a>

                                    </li>

                                <?php endforeach; ?>

                            </ul>

                        </li>

                    </ul>

                </div>

                <?php wp_nav_menu( $navbar ); ?>

            </div>

        </nav>

    </div>

</div>
