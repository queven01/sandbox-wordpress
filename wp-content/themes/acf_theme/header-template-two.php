<header id="masthead" class="site-header header-two">
    <?php
    $top_bar = get_theme_mod( 'top_bar' );
    $phone_number = get_theme_mod( 'phone_number' );
    $address = get_theme_mod( 'address' );

    if ($top_bar == true): ?>
		<div class="top-bar">
			<span><?php echo $address; ?></span>
			<span><?php echo $phone_number; ?></span>
		</div>
    <?php endif; ?>
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-12">
				<div class="site-branding d-flex justify-content-center">
                    <?php
                    if ( has_custom_logo() ) : ?>
						<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php the_custom_logo(); ?></a></div>
                    <?php else : ?>
						<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
                    <?php
                    endif;
                    ?>
				</div><!-- .site-branding -->
			</div>
			<div class="col-md-12">
				<nav id="site-navigatio" class="main-navigation">
					<div class="d-flex justify-content-center">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'acf_theme' ); ?></button>
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                        ) );
                        ?>
					</div>
				</nav><!-- #site-navigation -->
			</div>
		</div>
	</div>
</header><!-- #masthead -->

<!---->
<!--$description = get_bloginfo( 'description', 'display' );-->
<!--            if ( $description || is_customize_preview() ) : ?>-->
<!--                <p class="site-description">--><?php //echo $description; /* WPCS: xss ok. */ ?><!--</p>-->
<!--            --><?php
//            endif; ?>


