<?php
/**
 * Template for general settings page sections.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo; ?>

<ul class="subsubsub">
    
    <?php foreach ( $sections as $section => $title ) : ?>

        <a href="<?php echo esc_url( add_query_arg( 'section', $section, $baseurl ) ); ?>"
           <?php echo $current === $section ? 'class="current"': ''; ?>>

            <?php esc_html_e( $title ); ?>

        </a>

        <?php if ( $title !== end( $sections ) ) : ?> | <?php endif; ?>

    <?php endforeach; ?>
    
</ul>

<div class="clear"></div>

<?php do_menu_page_section( $page, $current ); ?>
