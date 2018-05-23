<?php
    $top_bar = get_theme_mod( 'top_bar' );
    $phone_number = get_theme_mod( 'phone_number' );
    $address = get_theme_mod( 'address' );
    $fixed = get_theme_mod( 'fixed' );
	$transparent = get_theme_mod( 'transparent' );?>

<header id="masthead" class="site-header header-four <?php if ($fixed == true): echo "fixed-top"; endif;?>">

	<?php
    if ($top_bar == true): ?>
        <div class="top-bar">
            <span><?php echo $address; ?></span>
            <span><?php echo $phone_number; ?></span>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
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
            <div class="col-md-9">
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

<?php if ($transparent == true && $fixed == false): ?>

	<style>
		header.site-header, .top-bar{
			background-color: transparent;

		}
		header.site-header {
			position: absolute;
			z-index: 10;
			width: 100%;
		}
	</style>

<?php endif; ?>

<?php if ($fixed == true && $transparent == true): ?>

	<script>
            $(window).scroll(function() {
                if($(this).scrollTop() > 50)  /*height in pixels when the navbar becomes non opaque*/
                {
                    $('header.site-header').addClass('scroll');
                    $('.top-bar').addClass('scroll');
                } else {
                    $('header.site-header').removeClass('scroll');
                    $('.top-bar').removeClass('scroll');
                }
            });
		</script>
		<style>
			header.site-header, .top-bar{
				background-color: transparent;

			}
			header.site-header::after{
				content: "";
				position: absolute;
				top: 0;
				left: 0;
				display: block;
				width: 100%;
				height: 100%;
				z-index: -2;
				background-color: #000;
				-webkit-transform: scaleY(.3);
				transform: scaleY(.3);
				opacity: 0;
				transition: all .3s
			}
			.top-bar::after{
				content: "";
				position: absolute;
				top: 0;
				left: 0;
				display: block;
				width: 100%;
				height: 27px;
				z-index: -1;
				background-color: #000;
				-webkit-transform: scaleY(.3);
				transform: scaleY(.3);
				opacity: 0;
				transition: all .3s
			}
			/*======= Button 2 =======*/
			header.site-header.scroll::after{
				opacity: 1;
				background: <?php echo get_theme_mod( 'header_background' ); ?>;
				-webkit-transform: scaleY(1);
				transform: scaleY(1);
				transition: -webkit-transform .6s cubic-bezier(.08, .35, .13, 1.02), opacity .2s;
				transition: transform .6s cubic-bezier(.08, .35, .13, 1.02), opacity
			}
			header.site-header .top-bar.scroll::after {
				background:<?php echo get_theme_mod( 'top_bar_background' ); ?>;
				opacity: 1;
				-webkit-transform: scaleY(1);
				transform: scaleY(1);
				transition: -webkit-transform .6s cubic-bezier(.08, .35, .13, 1.02), opacity .2s;
				transition: transform .6s cubic-bezier(.08, .35, .13, 1.02), opacity

			}
		</style>

<?php endif;?>

