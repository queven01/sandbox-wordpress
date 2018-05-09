<?php

namespace cdemo;

$navbar =  array(
	'menu'              => 'footer',
	'theme_location'    => 'cdemo_footer',
	'depth'             => 2,
	'container'         => 'div',
	'container_id'      => 'cdemo-footer-navbar',
	'menu_class'        => 'nav navbar-nav',
	'fallback_cb'       => 'cdemo\BootstrapNavWalker::fallback',
	'walker'            => new BootstrapNavWalker()
);

?>
            </div><!-- End Page Wrapper -->

            <?php do_action( 'cdemo_footer', $args ); ?>

            <?php if ( sanitize_checkbox( get_option( Options::SHOW_FOOTER ) ) ) : ?>

                <div class="container-fluid">

                    <div class="row">

                        <footer class="footer">

                            <div class="col-sm-6 footer-left">
                                <nav class="navbar navbar-default">
                                    <p class="navbar-text copyright"><?php echo esc_html( get_option( Options::COPYRIGHT ) ); ?></p>
                                </nav>
                            </div>
                            <div class="col-sm-6 footer-right">
                                <nav class="navbar navbar-default">

                                    <?php wp_nav_menu( $navbar ); ?>

                                </nav>
                            </div>

                        </footer>

                    </div>

                </div>

            <?php endif; ?>

        </div><!-- End Page Container -->

<?php if ( sanitize_checkbox( get_option( Options::USE_THEME_HEADER ) ) ) : ?>

    <?php \get_footer(); ?>

<?php else : ?>

        <?php wp_footer(); ?>

        </body><!-- End Body -->
    </html><!-- End Document -->

<?php endif; ?>
