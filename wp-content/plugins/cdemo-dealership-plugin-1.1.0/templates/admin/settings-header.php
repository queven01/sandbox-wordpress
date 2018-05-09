<?php
/**
 * Template for settings page header
 * 
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;

?>

<div id="cdemo-header-wrapper">
    
    <div class="cdemo-table">
        
        <div class="cdemo-logo">
            <img src="<?php echo resolve_url( 'assets/images/cdemo-logo.png' ); ?>" />
        </div>

        <div class="cdemo-title">
            <?php _e( 'cDemo - Vehicle Inventory Management System' , 'cdemo' ); ?>
            <span class="small version-number"><?php echo VERSION; ?></span>
        </div>
        
    </div>

    <ul class="cdemo-links">
        <li>
            <a href="<?php echo esc_url( DOCS_URL  );?>"><?php _e( 'Documentation', 'cdemo' ) ?></a>
        </li>
        |
        <li>
            <a href="<?php echo esc_url( PIM_URL  );?>"><?php _e( 'cDemo PIM', 'cdemo' ) ?></a>
        </li>
        |
        <li>
            <a href="<?php echo esc_url( SUPPORT_URL  );?>"><?php _e( 'Get Support', 'cdemo' ) ?></a>
        </li>
    </ul>
    
</div>

<h2 style="display: none"></h2>