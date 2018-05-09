<?php
/**
 * Template for the boat post type metabox
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

    </div><!-- /overview -->

    <!-- details -->
    <div id="details" class="metabox-section">

        <div class="metabox-group body">

            <div class="form-field">

                <label class="label" for="cdemo-hull-shape">
                    <?php _e( 'Hull Shape', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'hull_shape' ); ?>
                    </div>

                    <input id="cdemo-hull-shape"
                           name="body_type"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'hull_shape' ) ); ?>" />

                </div>

            </div>

            <div class="form-field">

                <label class="label" for="cdemo-length">
                    <?php _e( 'Length', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'length' ); ?>
                    </div>

                    <input id="cdemo-length"
                           name="body_type"
                           class="meta-field ui-auto-complete"
                           data-field-depend="#post_type"
                           type="text"
                           value="<?php esc_attr_e( get_metadata( 'length' ) ); ?>" />

                </div>

            </div>

        </div>

        <div class="metabox-group drive">

            <div class="form-field">

                <label class="label" for="cdemo-propulsion-type">
                    <?php _e( 'Propulsion Type', 'cdemo' ); ?>
                </label>

                <div class="input-group">

                    <div class="input-group-addon">
                        <?php meta_field_lock( 'propulsion_type' ); ?>
                    </div>

                    <input id="cdemo-propulsion-type"
                           name="propulsion_type"
                           class="meta-field"
                           type="number"
                           step="0.01"
                           value="<?php esc_attr_e( get_metadata( 'propulsion_type' ) ); ?>" />

                </div>

            </div>

        </div>

    </div><!-- /details -->

    <?php get_template( 'admin/meta-fields-common' ); ?>

</div>

<div class="clear"></div>

