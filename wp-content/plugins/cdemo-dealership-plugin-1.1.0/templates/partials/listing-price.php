<?php 

/**
 * 
 * Template for listing price
 * Used in the search result cards
 * 
 * @since 1.0.0
 */

namespace cdemo; 

$pricing  = get_listing_prices( $listing->ID );
$currency = get_listing_currency();

?>

<h5 class="listing-price <?php echo $pricing['sale_price'] > 0 ? 'has-promo' : ''; ?>">

    <?php if ( $pricing['listing_price'] > 0 ) : ?>

        <span class="regular-price cdemo-primary-color <?php echo $pricing['sale_price'] > 0 ? 'strike-through' : ''; ?>">
            <?php echo esc_html_e( format_currency( $pricing['listing_price'], $currency ) ); ?>
        </span>

    <?php endif; ?>

    <?php if ( $pricing['sale_price'] > 0 ) : ?>

        <span class="sale-price cdemo-primary-color">
            <?php esc_html_e( format_currency( $pricing['sale_price'], $currency ) ); ?>
        </span>
    
    <?php endif; ?>

</h5>
