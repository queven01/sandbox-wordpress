<?php
/**
 * Template for snowmobile metabox.
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

                <label class="label" for="cdemo-serial-number">
                    <?php _e( 'Serial Number', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'serial_number' ); ?>
                    </div>

                    <input id="cdemo-serial-number"
                           name="serial_number"
                           class="meta-field"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'serial_number' ) ); ?>" />

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
                           class="meta-field"
                           type="text"
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
                    <?php _e( 'Engine Size (cc)', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'engine_disp' ); ?>
                    </div>

                    <input id="cdemo-engine-disp"
                           name="engine_disp"
                           class="meta-field"
                           type="number"
                           step="0.1"
                           value="<?php esc_attr_e( get_metadata( 'engine_disp' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group misc">

            <div class="form-field">

                <label class="label" for="cdemo-track-length">
                    <?php _e( 'Track Length', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'track_length' ); ?>
                    </div>

                    <input id="cdemo-track-length"
                           name="track_length"
                           class="meta-field"
                           type="number"
                           step="0.01"
                           value="<?php esc_attr_e( get_metadata( 'track_length' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-reverse-gear">
                    <?php _e( 'Reverse Gear', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'reverse_gear' ); ?>
                    </div>

                    <select id="cdemo-reverse-gear"
                            name="reverse_gear"
                            class="meta-field">

                        <?php $selected = get_metadata( 'reverse_gear' ); ?>

                        <option value="no"
                            <?php selected( 'no', $selected ); ?>><?php _e( 'No', 'cdemo' ); ?>
                        </option>

                        <option value="yes"
                            <?php selected( 'yes', $selected ); ?>><?php _e( 'Yes', 'cdemo' ); ?>
                        </option>

                    </select>

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-electric-start">
                    <?php _e( 'Electric Start', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'electric_start' ); ?>
                    </div>

                    <select id="cdemo-electric-start"
                            name="electric_start"
                            class="meta-field">

                        <?php $selected = get_metadata( 'electric_start' ); ?>

                        <option value="no"
                            <?php selected( 'no', $selected ); ?>><?php _e( 'No', 'cdemo' ); ?>
                        </option>

                        <option value="yes"
                            <?php selected( 'yes', $selected ); ?>><?php _e( 'Yes', 'cdemo' ); ?>
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div><!-- /details -->

    <?php get_template( 'admin/meta-fields-common' ); ?>

</div>

<div class="clear"></div>
