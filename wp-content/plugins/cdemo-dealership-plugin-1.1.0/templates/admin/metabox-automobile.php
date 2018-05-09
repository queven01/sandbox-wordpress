<?php
/**
 * Template for automobile metabox.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;

?>

<div class="cdemo-tabs cdemo-metabox">

    <ul>

        <li data-tab="overview">
            <a href="#overview">
                <span class="dashicons dashicons-admin-tools"></span>
                <span class="title"><?php _e( 'Overview', 'cdemo' ); ?></span>
            </a>
        </li>

        <li data-tab="details">
            <a href="#details">
                <span class="dashicons dashicons-list-view"></span>
                <span class="title"><?php _e( 'Details', 'cdemo' ); ?></span>
            </a>
        </li>

        <li data-tab="pricing">
            <a href="#pricing">
                <span class="dashicons dashicons-tag"></span>
                <span class="title"><?php _e( 'Pricing', 'cdemo' ); ?></span>
            </a>
        </li>

        <li data-tab="financing">
            <a href="#financing">
                <span class="dashicons dashicons-clock"></span>
                <span class="title"><?php _e( 'Financing', 'cdemo' ); ?></span>
            </a>
        </li>

        <li data-tab="features">
            <a href="#features">
                <span class="dashicons dashicons-feedback"></span>
                <span class="title"><?php _e( 'Features', 'cdemo' ); ?></span>
            </a>
        </li>

        <li data-tab="media">
            <a href="#media">
                <span class="dashicons dashicons-admin-media"></span>
                <span class="title"><?php _e( 'Media', 'cdemo' ); ?></span>
            </a>
        </li>

    </ul>

    <!-- overview -->
    <div id="overview" class="metabox-section">

        <div class="metabox-group identification">

            <div class="form-field">

                <label class="label" for="cdemo-vin">
                    <?php _e( 'VIN', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'vin' ); ?>
                    </div>

                    <input id="cdemo-vin"
                           name="vin"
                           type="text"
                           class="meta-field"
                           value="<?php esc_attr_e( get_metadata( 'vin' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-stocknumber">
                    <?php _e( 'Stock #', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'stocknumber' ); ?>
                    </div>

                    <input id="cdemo-stocknumber"
                           name="stocknumber"
                           type="text"
                           class="meta-field"
                           value="<?php esc_attr_e( get_metadata( 'stocknumber' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group condition">

            <div class="form-field">

                <label class="label" for="cdemo-condition">
                    <?php _e( 'Condition', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'condition' ); ?>
                    </div>

                    <select id="cdemo-condition"
                            name="condition"
                            class="meta-field">

                        <?php $condition = get_metadata( 'condition' ); ?>

                        <option value="new"
                                <?php selected( 'new', $condition ); ?>><?php _e( 'New', 'cdemo' ); ?>
                        </option>

                        <option value="used"
                            <?php selected( 'used', $condition ); ?>><?php _e( 'Used', 'cdemo' ); ?>
                        </option>

                        <option value="certified_pre-owned"
                            <?php selected( 'certified_pre-owned', $condition ); ?>><?php _e( 'Certified Pre-Owned', 'cdemo' ); ?>
                        </option>

                    </select>

                </div>

            </div>

        </div>

        <div class="metabox-group make">

            <div class="form-field">

                <label class="label" for="cdemo-year-manufactured">
                    <?php _e( 'Year', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'year_manufactured' ); ?>
                    </div>

                    <input id="cdemo-year-manufactured"
                           name="year_manufactured"
                           class="meta-field"
                           type="number"
                           min="1901"
                           max="<?php esc_attr_e( date( 'Y' ) + 1 ); ?>"
                           value="<?php esc_attr_e( get_metadata( 'year_manufactured' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-make">
                    <?php _e( 'Make', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'make' ); ?>
                    </div>

                    <input id="cdemo-make"
                           name="make"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'make' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-model">
                    <?php _e( 'Model', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'model' ); ?>
                    </div>

                    <input id="cdemo-model"
                           name="model"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#cdemo-make,#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'model' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group trim">

            <div class="form-field">

                <label class="label" for="cdemo-trim-level">
                    <?php _e( 'Trim Level', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'trim_level' ); ?>
                    </div>

                    <input id="cdemo-trim-level"
                           name="trim_level"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'trim_level' ) ); ?>" />

                </div>

            </div>

        </div>

    </div><!-- /overview -->

    <!-- details -->
    <div id="details" class="metabox-section">

        <div class="metabox-group body">

            <div class="form-field">

                <label class="label" for="cdemo-body-type">
                    <?php _e( 'Body Type', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'body_type' ); ?>
                    </div>

                    <input id="cdemo-body-type"
                           name="body_type"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'body_type' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group colors">

            <div class="form-field">

                <label class="label" for="cdemo-interior-color">
                    <?php _e( 'Interior Color', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'interior_color' ); ?>
                    </div>

                    <input id="cdemo-interior-color"
                           name="interior_color"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'interior_color' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-exterior-color">
                    <?php _e( 'Exterior Color', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'exterior_color' ); ?>
                    </div>

                    <input id="cdemo-exterior-color"
                           name="exterior_color"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'exterior_color' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group capacity">

            <div class="form-field">

                <label class="label" for="cdemo-seating-capacity">
                    <?php _e( 'Seating Capacity', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'seating_capacity' );  ?>
                    </div>

                    <input id="cdemo-seating-capacity"
                           name="seating_capacity"
                           class="meta-field"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'seating_capacity' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-number-passenger-doors">
                    <?php _e( 'Doors', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'number_passenger_doors' ); ?>
                    </div>

                    <input id="cdemo-number-passenger-doors"
                           name="number_passenger_doors"
                           class="meta-field"
                           type="number"
                           value="<?php esc_attr_e( get_metadata( 'number_passenger_doors' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group mileage">

            <div class="form-field">

                <label class="label" for="cdemo-odometer-reading">
                    <?php _e( 'Odometer Reading', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'odometer_reading' ); ?>
                    </div>

                    <input id="cdemo-odometer-reading"
                           name="odometer_reading"
                           class="meta-field"
                           type="number"
                           value="<?php esc_attr_e( get_metadata( 'odometer_reading' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group engine">

            <div class="form-field">

                <label class="label" for="cdemo-engine">
                    <?php _e( 'Engine', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'engine' ); ?>
                    </div>

                    <input id="cdemo-engine"
                           name="engine"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'engine' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-engine-disp">
                    <?php _e( 'Displacement', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'engine_disp' ); ?>
                    </div>

                    <input id="cdemo-engine-disp"
                           name="engine_disp"
                           class="meta-field"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'engine_disp' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-cylinders">
                    <?php _e( 'Cylinders', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'cylinders' ); ?>
                    </div>

                    <input id="cdemo-cylinders"
                           name="cylinders"
                           class="meta-field"
                           type="number"
                           value="<?php esc_attr_e( get_metadata( 'cylinders' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-horse-power">
                    <?php _e( 'Horse Power', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'horse_power' ); ?>
                    </div>

                    <input id="cdemo-horse-power"
                           name="horse_power"
                           class="meta-field"
                           type="number"
                           step="0.1"
                           value="<?php esc_attr_e( get_metadata( 'horse_power' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group drive">

            <div class="form-field">

                <label class="label" for="cdemo-drive-type">
                    <?php _e( 'Drive Type', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'drivetrain' ); ?>
                    </div>

                    <input id="cdemo-drive-type"
                           name="drivetrain"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'drivetrain' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-transmission">
                    <?php _e( 'Transmission', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'transmission' ); ?>
                    </div>

                    <input id="cdemo-transmission"
                           name="transmission"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'transmission' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group fuel">

            <div class="form-field">

                <label class="label" for="cdemo-fuel-type">
                    <?php _e( 'Fuel Type', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'fuel_type' ); ?>
                    </div>

                    <input id="cdemo-fuel-type"
                           name="fuel_type"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'fuel_type' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-fuel-economy-unit">
                    <?php _e( 'Fuel Economy Unit', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'fuel_economy_unit' ); ?>
                    </div>

                    <select id="cdemo-fuel-economy-unit"
                            name="fuel_economy_unit"
                            class="meta-field">

                        <?php $unit = get_metadata( 'fuel_economy_unit' ); ?>

                        <option class="">
                            <?php _e( 'Global Default', 'cdemo' ); ?>
                        </option>

                        <option class="imperial"
                            <?php selected( 'imperial', $unit ); ?>><?php _e( 'MPG', 'cdemo' ); ?>
                        </option>

                        <option class="metric"
                            <?php selected( 'metric', $unit ); ?>><?php _e( '100/L km', 'cdemo' ); ?>
                        </option>

                    </select>

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-fuel-economy-city">
                    <?php _e( 'Economy City', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'fuel_economy_city' ); ?>
                    </div>

                    <div class="meta-field cdemo-range-input">

                        <?php $city = get_metadata( 'fuel_economy_city', false ); ?>

                        <input id="cdemo-fuel-economy-city"
                               name="fuel_economy_city[]"
                               placeholder="<?php _e( 'Min', 'cdemo' ); ?>"
                               type="number"
                               step="0.1"
                               value="<?php esc_attr_e( pluck( $city, 0 ) ); ?>" />

                        <input id="cdemo-fuel-economy-city"
                               name="fuel_economy_city[]"
                               placeholder="<?php _e( 'Max', 'cdemo' ); ?>"
                               type="number"
                               step="0.1"
                               value="<?php esc_attr_e( pluck( $city, 1 ) ); ?>" />

                    </div>

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-fuel-economy-hwy">
                    <?php _e( 'Economy Highway', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'fuel_economy_hwy' ); ?>
                    </div>

                    <div class="meta-field cdemo-range-input">

                        <?php $hwy = get_metadata( 'fuel_economy_hwy', false ); ?>

                        <input id="cdemo-fuel-economy-hwy"
                               name="fuel_economy_hwy[]"
                               placeholder="<?php _e( 'Min', 'cdemo' ); ?>"
                               type="number"
                               step="0.1"
                               value="<?php esc_attr_e( pluck( $hwy, 0 ) ); ?>" />

                        <input id="cdemo-fuel-economy-hwy"
                               name="fuel_economy_hwy[]"
                               placeholder="<?php _e( 'Max', 'cdemo' ); ?>"
                               type="number"
                               step="0.1"
                               value="<?php esc_attr_e( pluck( $hwy, 1 ) ); ?>" />

                    </div>

                </div>

            </div>

        </div>

    </div><!-- /details -->

    <!-- features -->
    <div id="features" class="metabox-section"></div><!-- /features -->

    <?php get_template( 'admin/meta-fields-common' ); ?>

</div>

<div class="clear"></div>