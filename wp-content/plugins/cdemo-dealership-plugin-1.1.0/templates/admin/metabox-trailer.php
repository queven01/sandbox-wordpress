<?php
/**
 * Template for the trailer post type metabox
 *
 * @since 1.1.0
 * @package cdemo
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

                <label class="label" for="cdemo-serial-number">
                    <?php _e( 'Serial Number', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'serial_number' ); ?>
                    </div>

                    <input id="cdemo-serial-number"
                           name="serial_number"
                           type="text"
                           class="meta-field"
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

    </div><!-- /overview -->

    <!-- details -->
    <div id="details" class="metabox-section">

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

            <div class="form-field">

                <label class="label" for="cdemo-deck-type">
                    <?php _e( 'Deck Type', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'deck_type' ); ?>
                    </div>

                    <input id="cdemo-deck-type"
                           name="deck_type"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'deck_type' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group drive">

            <div class="form-field">

                <label class="label" for="cdemo-axle-count">
                    <?php _e( 'Axle Count', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'axle_count' ); ?>
                    </div>

                    <input id="cdemo-axle-count"
                           name="axle_count"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'axle_count' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-hitch-type">
                    <?php _e( 'Hitch Type', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'hitch_type' ); ?>
                    </div>

                    <input id="cdemo-hitch-type"
                           name="hitch_type"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'hitch_type' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group body">

            <div class="form-field">

                <label class="label" for="cdemo-length">
                    <?php _e( 'Length', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'length' ); ?>
                    </div>

                    <input id="cdemo-length"
                           name="length"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'length' ) ); ?>" />

                </div>

            </div>

        </div>

    </div><!-- /details -->

    <!-- features -->
    <div id="features" class="metabox-section"></div><!-- /features -->

    <?php get_template( 'admin/meta-fields-common' ); ?>

</div>

<div class="clear"></div>
