<?php
/**
 * Template for common fields in the listing metabox.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;

?>

<!-- pricing -->
<div id="pricing" class="metabox-section">

    <div class="metabox-group listing_currency">

        <div class="form-field">

            <label class="label" for="cdemo-listing-currency">
                <?php _e( 'Listing Currency', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'listing_currency' ); ?>
                </div>

                <select name="listing_currency"
                        class="meta-field"
                        id="cdemo-listing-currency">

                    <?php $code = get_metadata( 'listing_currency' ); ?>

                    <option value="cad"
                        <?php selected( 'cad', $code ); ?>><?php _e( 'Canadian Dollars', 'cdemo' ); ?>
                    </option>

                    <option value="cad"
                        <?php selected( 'usd', $code ); ?>><?php _e( 'United States Dollars', 'cdemo' ); ?>
                    </option>

                    <option value="cad"
                        <?php selected( '', $code ); ?>><?php _e( 'Global Default', 'cdemo' ); ?>
                    </option>

                </select>

            </div>

        </div>

    </div>

    <div class="metabox-group listing_prices">

        <div class="form-field">

            <label class="label" for="cdemo-msrp">
                <?php _e( 'MSRP', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'msrp' ); ?>
                </div>

                <input name="msrp"
                       id="cdemo-msrp"
                       class="meta-field"
                       type="number"
                       step="0.01"
                       placeholder="$"
                       value="<?php esc_attr_e( get_metadata( 'msrp' ) ); ?>" />

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-listing-price">
                <?php _e( 'Listing Price', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'listing_price' ); ?>
                </div>

                <input name="listing_price"
                       id="cdemo-listing-price"
                       class="meta-field"
                       type="number"
                       step="0.01"
                       placeholder="$"
                       value="<?php esc_attr_e( get_metadata( 'listing_price' ) ); ?>" />

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-sale-price">
                <?php _e( 'Sale Price', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'sale_price' ); ?>
                </div>

                <input name="sale_price"
                       id="cdemo-sale-price"
                       class="meta-field"
                       type="number"
                       step="0.01"
                       placeholder="$"
                       value="<?php esc_attr_e( get_metadata( 'sale_price' ) ); ?>" />

            </div>

        </div>

    </div>

    <div class="metabox-group sale">

        <div class="form-field">

            <label class="label" for="cdemo-sale-price-start-dt">
                <?php _e( 'Start Date', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'sale_price_start_dt' ); ?>
                </div>

                <input id="cdemo-sale-price-start-dt"
                       name="sale_price_start_dt"
                       class="meta-field ui-datepicker"
                       type="date"
                       value="<?php esc_attr_e( get_metadata( 'sale_price_start_dt' ) ); ?>" />

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-sale-price-end-dt">
                <?php _e( 'End Date', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'sale_price_end_dt' ); ?>
                </div>

                <input id="cdemo-sale-price-end-dt"
                       name="sale_price_end_dt"
                       class="meta-field ui-datepicker"
                       type="date"
                       value="<?php esc_attr_e( get_metadata( 'sale_price_end_dt' ) ); ?>" />

            </div>

        </div>

    </div>

    <div class="metabox-group misc">

        <div class="form-field">

            <label class="label">
                <?php _e( 'Misc Price 1', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'misc_price_1' ); ?>
                </div>

                <input id="cdemo-misc-price-1"
                       name="misc_price_1"
                       class="meta-field"
                       type="number"
                       step="0.01"
                       placeholder="$"
                       value="<?php esc_attr_e( get_metadata( 'misc_price_1' ) ); ?>" />

            </div>

        </div>

        <div class="form-field">

            <label class="label">
                <?php _e( 'Misc Price 2', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'misc_price_2' ); ?>
                </div>

                <input id="cdemo-misc-price-2"
                       name="misc_price_2"
                       class="meta-field"
                       type="number"
                       step="0.01"
                       placeholder="$"
                       value="<?php esc_attr_e( get_metadata( 'misc_price_2' ) ); ?>" />

            </div>

        </div>

        <div class="form-field">

            <label class="label">
                <?php _e( 'Misc Price 3', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'misc_price_3' ); ?>
                </div>

                <input id="cdemo-misc-price-3"
                       name="misc_price_3"
                       class="meta-field"
                       type="number"
                       step="0.01"
                       placeholder="$"
                       value="<?php esc_attr_e( get_metadata( 'misc_price_3' ) ); ?>" />

            </div>

        </div>

    </div>


</div><!-- /pricing -->


<!-- financing -->
<div id="financing" class="metabox-section">

    <div class="metabox-group enable_financing">

        <div class="form-field">

            <label for="cdemo-financing-enabled" class="label">
                <?php _e( 'Financing Options', 'cdemo' ); ?>
            </label>

            <input type="hidden" name="financing_enabled" value="off" />


            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'financing_enabled' ); ?>
                </div>

                <div class="meta-field">

                    <input type="checkbox"
                           id="cdemo-financing-enabled"
                           name="financing_enabled"
                        <?php checked( 'on', get_metadata( 'financing_enabled' ) ); ?> />

                    <label for="cdemo-financing-enabled">
                        <?php _e( 'Allow payments for this vehicle to be financed', 'cdemo' ); ?>
                    <label>

                </div>

            </div>

        </div>

    </div>

    <div class="metabox-group calculation_values">

        <div class="form-field">

            <label class="label" for="cdemo-financing-price">

                <?php _e( 'Financing Price', 'cdemo' ); ?>

                <span class="cdemo-help"
                      title="<?php _e( 'Select the price that you want to be used as the \'Selling Price\' for which the financial calculations will be based on', 'cdemo' ); ?>">
                </span>

            </label>


            <div id="cdemo-finance-price-field" class="meta-field">

                <div class="pull-left">

                    <div class="input-group">

                        <div class="input-group-addon">
                            <?php meta_field_lock( 'financing_price' ); ?>
                        </div>

                        <select id="cdemo-financing-price" name="financing_price">

                            <?php $base = get_metadata( 'financing_price' ); ?>

                            <option value="listing_price"
                                <?php selected( 'listing_price', $base ); ?>><?php _e( 'Selling Price', 'cdemo' ); ?>
                            </option>

                            <option value="sale_price"
                                <?php selected( 'sale_price', $base ); ?>><?php _e( 'Sale Price', 'cdemo' ); ?>
                            </option>

                        </select>

                    </div>

                </div>

                <input type="text" id="cdemo-finance-price-preview" class="pull-right" readonly />

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-down-payment">

                <?php _e( 'Down Payment', 'cdemo' ); ?>

                <span class="cdemo-help"
                      title="<?php _e( 'Enter amount that will be subtracted from the \'Selling Price\' for which the financial calculations will be based on', 'cdemo' ); ?>">
                </span>

            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'down_payment' ); ?>
                </div>

                <input id="cdemo-down-payment"
                       class="meta-field"
                       name="down_payment"
                       step="0.01"
                       type="number"
                       placeholder="%"
                       min="0"
                       max="100"
                       value="<?php esc_attr_e( get_metadata( 'down_payment' ) ); ?>" />

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-monthly-period">

                <?php _e( 'Term Length', 'cdemo' ); ?>

                <span class="cdemo-help"
                      title="<?php _e( 'Enter the Term as the number of months to be used for financial calculations', 'cdemo' ); ?>">
                </span>

            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'monthly_period' ); ?>
                </div>

                <select id="cdemo-monthly-period"
                        name="monthly_period"
                        class="meta-field">

                    <?php $months = get_metadata( 'monthly_period' ); ?>

                    <option value="12"
                        <?php selected( 12, $months ); ?>><?php _e( '12 Months', 'cdemo' ); ?>
                    </option>

                    <option value="24"
                        <?php selected( 24, $months ); ?>><?php _e( '24 Months', 'cdemo' ); ?>
                    </option>

                    <option value="36"
                        <?php selected( 36, $months ); ?>><?php _e( '36 Months', 'cdemo' ); ?>
                    </option>

                    <option value="48"
                        <?php selected( 48, $months ); ?>><?php _e( '48 Months', 'cdemo' ); ?>
                    </option>

                    <option value="60"
                        <?php selected( 60, $months ); ?>><?php _e( '60 Months', 'cdemo' ); ?>
                    </option>

                    <option value="72"
                        <?php selected( 72, $months ); ?>><?php _e( '72 Months', 'cdemo' ); ?>
                    </option>

                    <option value="84"
                        <?php selected( 84, $months ); ?>><?php _e( '84 Months', 'cdemo' ); ?>
                    </option>

                    <option value="96"
                        <?php selected( 96, $months ); ?>><?php _e( '96 Months', 'cdemo' ); ?>
                    </option>

                </select>

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-percent-apr">

                <?php _e( 'Interest Rate', 'cdemo' ); ?>

                <span class="cdemo-help"
                      title="<?php _e( 'Enter the Annual Percentage Rate (APR) that will be used for financial calculations', 'cdemo' ); ?>">
                </span>

            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'percent_apr' ); ?>
                </div>

                <input id="cdemo-percent-apr"
                       name="percent_apr"
                       class="meta-field"
                       type="number"
                       step="0.01"
                       min="0"
                       max="100"
                       placeholder="%"
                       value="<?php esc_attr_e( get_metadata( 'percent_apr' ) ); ?>" />

            </div>

        </div>

    </div>

    <div class="metabox-group calc_payments">

        <div class="form-field">

            <label class="label">
                <?php _e( 'Calculate Payments', 'cdemo' ); ?>
            </label>

            <button id="cdemo-calc-payments"
                    class="button-primary"
                    type="button"><?php _e( 'Refresh Payments', 'cdemo' ); ?></button>

        </div>

    </div>

    <div class="metabox-group payment_values">

        <div class="form-field">

            <label class="label" for="cdemo-monthly-finance-price">

                <?php _e( 'Monthly Payment', 'cdemo' ); ?>

                <span class="cdemo-help"
                      title="<?php _e( 'This is the Monthly Payment Amount as calculated using the above details', 'cdemo' ); ?>">
                </span>

            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'monthly_finance_price' ); ?>
                </div>

                <input id="cdemo-monthly-finance-price"
                       name="monthly_finance_price"
                       class="meta-field"
                       type="text"
                       value="<?php esc_attr_e( get_metadata( 'monthly_finance_price' ) ); ?>" readonly />

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-bi-weekly-finance-price">

                <?php _e( 'Bi-weekly Payment', 'cdemo' ); ?>

                <span class="cdemo-help"
                      title="<?php _e( 'This is the Bi-Weekly Payment Amount as calculated using the above details', 'cdemo' ); ?>">
                </span>

            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock('bi_weekly_finance_price' ); ?>
                </div>

                <input id="cdemo-bi-weekly-finance-price"
                       name="bi_weekly_finance_price"
                       class="meta-field"
                       type="text"
                       value="<?php esc_attr_e( get_metadata( 'bi_weekly_finance_price' ) ); ?>" readonly />

            </div>

        </div>

        <div class="form-field">

            <label class="label" for="cdemo-weekly-finance-price"><?php _e( 'Weekly Payment', 'cdemo' ); ?>
                <span class="cdemo-help" title="<?php _e( 'This is the Weekly Payment Amount as calculated using the above details', 'cdemo' ); ?>"></span>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'weekly_finance_price' ); ?>
                </div>

                <input id="cdemo-weekly-finance-price"
                       name="weekly_finance_price"
                       class="meta-field"
                       type="text"
                       value="<?php esc_attr_e( get_metadata( 'weekly_finance_price' ) ); ?>" readonly />

            </div>

        </div>

    </div>

    <div class="metabox-group finance_disclaimer">

        <div class="form-field">

            <label class="label" for="cdemo-financing-disclaimer">
                <?php _e( 'Financing Disclaimer', 'cdemo' ); ?>
            </label>

            <div class="input-group">

                <div class="input-group-addon">
                    <?php meta_field_lock( 'financing_disclaimer' ); ?>
                </div>

                <textarea id="cdemo-financing-disclaimer"
                          name="financing_disclaimer"
                          class="meta-field"
                          rows="5"><?php echo esc_textarea( get_metadata( 'financing_disclaimer' ) ); ?></textarea>

            </div>

        </div>

    </div>

</div><!-- /financing -->


<!-- media -->
<div id="media" class="metabox-section">

    <div class="cdemo-media">

        <ul class="ui-sortable">

            <li class="add-media">
                <div class="upload-label">
                    <button class="upload-media button"><?php _e( 'Upload', 'cdemo' ); ?></button>
                </div>
            </li>

            <?php foreach ( get_listing_media() as $media ) : ?>

                <li class="sortable">

                    <span class="remove dashicons dashicons-trash"></span>

                    <input name="media[]" value="<?php echo esc_url( $media ); ?>" type="hidden" />
                    <div class="media-thumbnail" style="background: url(<?php echo esc_url( $media ); ?>)"></div>

                </li>

            <?php endforeach; ?>

        </ul>

        <div class="clear"></div>

    </div>

</div><!-- /media -->

