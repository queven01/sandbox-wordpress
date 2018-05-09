<?php
/**
 * Functions for managing the drag and drop UI settings.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;


// Merge config with existing categories
add_filter( 'pre_update_option_' . Options::UI_FIELDS_RESULTS_PAGE_CONFIG, 'cdemo\filter_ui_field_config', 10, 3 );
add_filter( 'pre_update_option_' . Options::UI_FIELDS_DETAILS_PAGE_CONFIG, 'cdemo\filter_ui_field_config', 10, 3 );
add_filter( 'pre_update_option_' . Options::UI_FIELDS_SEARCH_FORM_CONFIG,  'cdemo\filter_ui_field_config', 10, 3 );


/**
 * Append field config to an existing option instead of overwriting.
 *
 * @param $value
 * @param $old
 * @param $option
 *
 * @filter pre_update_option_{UI_FIELDS_CONFIG}
 *
 * @since 1.0.0
 * @return array
 */
function filter_ui_field_config( $value, $old, $option ) {

    if ( is_array( $value ) ) {

        // Get the current config
        $config = get_option( $option );

        // Merge the config with any existing categories
        return array_merge( $config, $value );

    } else {
        return array();
    }

}


/**
 * Get all of the fields available for the UI manager palette.
 *
 * @param string $category
 *
 * @since 1.0.0
 * @return mixed
 */
function get_manage_ui_fields( $category ) {

    $fields = array();

    foreach ( ui_fields() as $id => $field ) {

        if ( in_array( $category, $field['context'] ) ) {
            $fields[ $id ] = $field;
        }

    }

    return $fields;

}


/**
 * Get all of the search form fields available for the UI manager palette.
 *
 * @param $context
 *
 * @since 1.0.0
 * @return array
 */
function get_manage_ui_fields_search_form( $context ) {

    $fields = array();

    foreach ( ui_fields_search_form() as $id => $field ) {

        if ( in_array( $context, $field['context'] ) ) {
            $fields[ $id ] = $field;
        }

    }

    return $fields;

}


/**
 * Output a UI field editor in the UI manager.
 *
 * @param string   $option   The settings API option name.
 * @param string   $context  The current screen context (category).
 * @param string   $id       The slug ID of the field as stored in the configuration.
 * @param string   $title    The title to display int the GUI editor.
 * @param callable $callback The function to render the field values in the editor.
 * @param array    $data     The configuration to populate the values of the field.
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_form_field( $option, $context, $id, $title, $callback, $data ) { ?>

    <h4 class="field-title">
        <?php esc_html_e( $title ); ?> <span class="toggle"></span>
    </h4>

    <div class="content">
        <?php call_user_func( $callback, "{$option}[$context][$id]", $data ); ?>
    </div>

<?php }


/**
 * Output a UI field editor in the UI manager.
 *
 * @param string   $option   The settings API option name.
 * @param string   $context  The current screen context (category).
 * @param string   $id       The slug ID of the field as stored in the configuration.
 * @param string   $title    The title to display int the GUI editor.
 * @param string   $value    The value of the field label.
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_field( $option, $context, $id, $title, $value ) { ?>

    <h4 class="field-title">
        <?php esc_html_e( $title ); ?> <span class="toggle"></span>
    </h4>

    <div class="content">

        <div class="form-field">
            <label class="label"><?php _e( 'Label', 'cdemo' ); ?></label>

            <input type="text"
                   value="<?php esc_attr_e( $value ); ?>"
                   name="<?php esc_attr_e( "{$option}[$context][$id]" ); ?>" />
        </div>

    </div>

<?php }


/***********************************************************************************************************************
 * Render callbacks for search form fields.
 *
 * @since 1.0.0
 */


/**
 * Render the edit fields for the year search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_year( $name, $config ) { ?>

    <p class="form-field">

        <label for="edit-year-label" class="label"><?php _e( 'Label', 'cdemo' ); ?></label>
        <input id="edit-year-label"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-year-min" class="label"><?php _e( 'Minimum', 'cdemo' ); ?></label>
        <input id="edit-year-min"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'min' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[min]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-year-max" class="label"><?php _e( 'Maximum', 'cdemo' ); ?></label>
        <input id="edit-year-max"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'max' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[max]' ) ); ?>" />
    </p>

<?php }


/**
 * Render the edit fields for the make search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_make( $name, $config ) { ?>

    <p class="form-field">
        <label for="edit-make-label" class="label"><?php _e( 'Label', 'cdemo' ); ?></label>
        <input id="edit-make-label"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-make-placeholder" class="label"><?php _e( 'Placeholder', 'cdemo' ); ?></label>
        <input id="edit-make-placeholder"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[placeholder]' ) ); ?>" />
    </p>

<?php }


/**
 * Render the edit fields for the model search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_model( $name, $config ) { ?>

    <p class="form-field">
        <label for="edit-model-label" class="label"><?php _e( 'Label', 'cdemo' ); ?></label>
        <input id="edit-model-label"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-model-placeholder" class="label"><?php _e( 'Placeholder', 'cdemo' ); ?></label>
        <input id="edit-model-placeholder"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[placeholder]' ) ); ?>" />
    </p>

<?php }


/**
 * Render the edit fields for the body type search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_body_type( $name, $config ) { ?>

    <p class="form-field">
        <label for="edit-body-type-label" class="label"><?php _e( 'Label', 'cdemo' ); ?></label>
        <input id="edit-body-type-label"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-body-type-placeholder" class="label"><?php _e( 'Placeholder', 'cdemo' ); ?></label>
        <input id="edit-body-type-placeholder"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[placeholder]' ) ); ?>" />
    </p>

<?php }


/**
 * Render the edit fields for the engine search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_engine( $name, $config ) { ?>

    <p class="form-field">
        <label for="edit-engine-label" class="label"><?php _e( 'Label', 'cdemo' ); ?></label>
        <input id="edit-engine-label"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-engine-placeholder" class="label"><?php _e( 'Placeholder', 'cdemo' ); ?></label>
        <input id="edit-engine-placeholder"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[placeholder]' ) ); ?>" />
    </p>

<?php }


/**
 * Render the edit fields for the transmission search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_transmission( $name, $config ) { ?>

    <p class="form-field">
        <label for="edit-transmission-label" class="label"><?php _e( 'Label', 'cdemo' ); ?></label>
        <input id="edit-transmission-label"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-transmission-placeholder" class="label"><?php _e( 'Placeholder', 'cdemo' ); ?></label>
        <input id="edit-transmission-placeholder"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[placeholder]' ) ); ?>" />
    </p>

<?php }


/**
 * Render the edit fields for the condition search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_condition( $name, $config ) { ?>

    <div class="form-field">
        <label class="label"><?php _e( 'Label', 'cdemo' ); ?></label>

        <input type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </div>

<?php }


/**
 * Render the edit fields for the price search form field.
 *
 * @param $name
 * @param $config
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_edit_price( $name, $config ) { ?>

    <p class="form-field">

        <label for="edit-price-label" class="label"><?php _e( 'Label', 'cdemo' ); ?></label>
        <input id="edit-price-label"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'label' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[label]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-price-min" class="label"><?php _e( 'Minimum', 'cdemo' ); ?></label>
        <input id="edit-price-min"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'min' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[min]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-price-max" class="label"><?php _e( 'Maximum', 'cdemo' ); ?></label>
        <input id="edit-price-max"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'max' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[max]' ) ); ?>" />
    </p>

    <p class="form-field">
        <label for="edit-price-step" class="label"><?php _e( 'Step', 'cdemo' ); ?></label>
        <input id="edit-price-step"
               type="text"
               value="<?php esc_attr_e( pluck( $config, 'step' ) ); ?>"
               name="<?php esc_attr_e( strcat( $name, '[step]' ) ); ?>" />
    </p>

<?php }
