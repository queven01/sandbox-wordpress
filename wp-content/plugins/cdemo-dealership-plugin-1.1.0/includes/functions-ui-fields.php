<?php
/**
 * Functions for getting UI field configurations.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Get a UI field configuration.
 *
 * @param string $option
 * @param string $category
 *
 * @since 1.0.0
 * @return bool
 */
function get_ui_fields_config( $option, $category ) {

    $config = get_option( $option );

    if ( $config && isset( $config[ $category ] ) ) {
        return $config[ $category ];
    }

    return false;

}


/**
 * Get the UI fields for the search form. Defaults to the global context if the category is not found.
 *
 * @param string $context
 *
 * @since 1.0.0
 * @return array
 */
function get_ui_fields_config_search_form( $context ) {

    $config = get_option( Options::UI_FIELDS_SEARCH_FORM_CONFIG );

    if ( isset( $config[ $context ] ) ) {
        return $config[ $context ];
    }

    return $config['global'];

}



/**
 * Get and prepare configured UI fields config for the details page.
 *
 * @param string $category
 *
 * @since 1.0.0
 * @return array
 */
function get_details_page_fields_for_output( $category ) {

    return get_ui_fields_for_output( Options::UI_FIELDS_DETAILS_PAGE_CONFIG, $category );

}



/**
 * Get and prepare configured UI fields for the results page view.
 *
 * @param string $category
 *
 * @since 1.0.0
 * @return array
 */
function get_results_page_fields_for_output( $category ) {

    return get_ui_fields_for_output( Options::UI_FIELDS_RESULTS_PAGE_CONFIG, $category );

}


/**
 * Get and prepare configured UI fields for output.
 *
 * @param $option
 * @param $context
 *
 * @since  1.0.0
 * @return array
 */
function get_ui_fields_for_output( $option, $context ) {

    $config = get_ui_fields_config( $option, $context );
    $fields = array();

    if ( is_array( $config ) ) {

        foreach ( $config as $id => $label ) {

            $field = get_ui_field( $id, $context );

            // Append the user label to the field
            if ( $field ) {
                $field['label'] = $label;
                $fields[ $id ]  = $field;
            }

        }

    }

    return $fields;

}


/**
 * Get a UI field.
 *
 * @param string $id
 * @param string $context
 *
 * @since 1.0.0
 * @return mixed
 */
function get_ui_field( $id, $context ) {

    $fields = ui_fields();

    if ( isset( $fields[ $id ] ) && in_array( $context, $fields[ $id ]['context'] ) ) {
        return $fields[ $id ];
    }

    return false;

}


/**
 * Get the search form fields config.
 *
 * @since 1.0.0
 * @return array
 */
function ui_fields_search_form() {
    $fields = array(
        'year' => array(
            'title'   => __( 'Year', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'defaults' => array(
                'label'       => __( 'Year', 'cdemo' ),
                'placeholder' => '',
                'min'         => 1901,
                'max'         => date( 'Y' ) + 1
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_year',
            'render_callback' => 'cdemo\render_ui_search_year'
        ),
        'make' => array(
            'title'   => __( 'Make', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'defaults' => array(
                'label'        => __( 'Make', 'cdemo' ),
                'placeholder'  => __( 'Select a make', 'cdemo' )
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_make',
            'render_callback' => 'cdemo\render_ui_search_make',
        ),
        'model' => array(
            'title'   => __( 'Model', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'defaults' => array(
                'label' => __( 'Model', 'cdemo' ),
                'placeholder'  => __( 'Enter a model', 'cdemo' )
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_model',
            'render_callback' => 'cdemo\render_ui_search_model',
        ),
        'body_style' => array(
            'title'   => __( 'Body Style', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv'
            ),
            'defaults' => array(
                'label' => __( 'Body Type', 'cdemo' ),
                'placeholder'  => __( 'Enter a type', 'cdemo' )
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_body_type',
            'render_callback' => 'cdemo\render_ui_search_body_type',
        ),
        'engine' => array(
            'title'   => __( 'Engine', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv'
            ),
            'defaults' => array(
                'label'        => __( 'Engine', 'cdemo' ),
                'placeholder'  => __( 'Enter a type', 'cdemo' )
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_engine',
            'render_callback' => 'cdemo\render_ui_search_engine',
        ),
        'transmission' => array(
            'title'   => __( 'Transmission', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'atv'
            ),
            'defaults' => array(
                'label' => __( 'Transmission', 'cdemo' ),
                'placeholder'  => __( 'Enter a transmission', 'cdemo' )
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_transmission',
            'render_callback' => 'cdemo\render_ui_search_transmission',
        ),
        'condition' => array(
            'title'   => __( 'Condition', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'defaults' => array(
                'label' => __( 'Condition', 'cdemo' )
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_condition',
            'render_callback' => 'cdemo\render_ui_search_condition',
        ),
        'price' => array(
            'title'   => __( 'Price', 'cdemo' ),
            'context' => array(
                'global',
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'defaults' => array(
                'label' => __( 'Price', 'cdemo' ),
                'min'   => 0,
                'max'   => 50000,
                'step'  => 100
            ),
            'edit_callback'   => 'cdemo\render_ui_edit_price',
            'render_callback' => 'cdemo\render_ui_search_price',
        )
    );

    return $fields;
}


/**
 * Get available UI fields for results and details pages.
 *
 * @since 1.0.0
 * @return array
 */
function ui_fields() {
    $config = array(
        'year_manufactured' => array(
            'title'   => __( 'Year', 'cdemo' ),
            'default' => __( 'Year', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'make' => array(
            'title'   => __( 'Make', 'cdemo' ),
            'default' => __( 'Make', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'model' => array(
            'title'   => __( 'Model', 'cdemo' ),
            'default' => __( 'Model', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'boat',
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'trim_level' => array(
            'title'   => __( 'Trim Level', 'cdemo' ),
            'default' => __( 'Trim Level', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'body_type' => array(
            'title'   => __( 'Body Type', 'cdemo' ),
            'default' => __( 'Body Type', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'interior_color' => array(
            'title'   => __( 'Interior Color', 'cdemo' ),
            'default' => __( 'Interior Color', 'cdemo' ),
            'context' => array(
                'automobile'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'exterior_color' => array(
            'title'   => __( 'Exterior Color', 'cdemo' ),
            'default' => __( 'Exterior Color', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv',
                'camper',
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'seating_capacity' => array(
            'title'   => __( 'Seating Capacity', 'cdemo' ),
            'default' => __( 'Seating Capacity', 'cdemo' ),
            'context' => array(
                'automobile'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'number_passenger_doors' => array(
            'title'   => __( 'Doors', 'cdemo' ),
            'default' => __( 'Doors', 'cdemo' ),
            'context' => array(
                'automobile'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'odometer_reading' => array(
            'title'   => __( 'Odometer Reading', 'cdemo' ),
            'default' => __( 'Odometer Reading', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'engine' => array(
            'title'   => __( 'Engine Type', 'cdemo' ),
            'default' => __( 'Engine Type', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'engine_disp' => array(
            'title'   => __( 'Displacement', 'cdemo' ),
            'default' => __( 'Displacement', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'snowmobile',
                'atv'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'cylinders' => array(
            'title'   => __( 'Cylinders', 'cdemo' ),
            'default' => __( 'Cylinders', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'horse_power' => array(
            'title'   => __( 'Horse Power', 'cdemo' ),
            'default' => __( 'Horse Power', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'drivetrain' => array(
            'title'   => __( 'Drive Type', 'cdemo' ),
            'default' => __( 'Drive Type', 'cdemo' ),
            'context' => array(
                'automobile',
                'atv'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'transmission' => array(
            'title'   => __( 'Transmission', 'cdemo' ),
            'default' => __( 'Transmission', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle',
                'atv'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'fuel_type' => array(
            'title'   => __( 'Fuel Type', 'cdemo' ),
            'default' => __( 'Fuel Type', 'cdemo' ),
            'context' => array(
                'automobile',
                'motorcycle'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'track_length' => array(
            'title'   => __( 'Track Length', 'cdemo' ),
            'default' => __( 'Track Length', 'cdemo' ),
            'context' => array(
                'snowmobile'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'length' => array(
            'title'   => __( 'Length', 'cdemo' ),
            'default' => __( 'Length', 'cdemo' ),
            'context' => array(
                'camper',
                'boat',
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'axle_count' => array(
            'title'   => __( 'Axle Count', 'cdemo' ),
            'default' => __( 'Axle Count', 'cdemo' ),
            'context' => array(
                'camper',
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'pushout_count' => array(
            'title'   => __( 'Push-Out Count', 'cdemo' ),
            'default' => __( 'Push-Out Count', 'cdemo' ),
            'context' => array(
                'camper'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'sleeping_capacity' => array(
            'title'   => __( 'Sleeping Capacity', 'cdemo' ),
            'default' => __( 'Sleeping Capacity', 'cdemo' ),
            'context' => array(
                'camper'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'hull_length' => array(
            'title'   => __( 'Hull Length', 'cdemo' ),
            'default' => __( 'Hull Length', 'cdemo' ),
            'context' => array(
                'boat'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'propulsion_type' => array(
            'title'   => __( 'Propulsion Type', 'cdemo' ),
            'default' => __( 'Propulsion Type', 'cdemo' ),
            'context' => array(
                'boat'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'deck_type' => array(
            'title'   => __( 'Deck Type', 'cdemo' ),
            'default' => __( 'Deck Type', 'cdemo' ),
            'context' => array(
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        ),
        'hitch_type' => array(
            'title'   => __( 'Hitch Type', 'cdemo' ),
            'default' => __( 'Hitch Type', 'cdemo' ),
            'context' => array(
                'trailer'
            ),
            'render_callback' => 'cdemo\render_ui_field',
        )
    );

    return $config;
}


/**
 * Output the fields in the search form.
 *
 * @param string       $context
 * @param VehicleQuery $query
 * @param string       $before
 * @param string       $after
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_fields( $context, $query, $before = '<div class="form-group">', $after = '</div>' ) {

    $fields = ui_fields_search_form();
    $config = get_ui_fields_config_search_form( $context );

    foreach ( $config as $id => $values ) {

        if ( array_key_exists( $id, $fields ) ) {

            echo $before;

            if ( !empty( $config[ $id ] ) && in_array( $context ?: 'global', $fields[ $id ]['context'] ) ) {
                call_user_func( $fields[ $id ]['render_callback'], $values, $query );
            }

            echo $after;

        }

    }

}


/**
 * Default render callback for a UI field.
 *
 * @param string $id
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_field( $id ) {
    esc_html_e( get_post_meta( get_the_ID(), $id, true ) ?: '-' );
}


/***********************************************************************************************************************
 * Render callbacks for search form fields.
 *
 * @since 1.0.0
 */

/**
 * Render the year field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_year( $config, $query ) { ?>

    <div class="form-field">

        <span id="year-label-wrap">
            <label class="label"><?php esc_html_e( pluck( $config, 'label' ) ); ?></label>
        </span>

        <div id="year-range-slider"
             data-min="<?php esc_attr_e( pluck( $config, 'min' ) ); ?>"
             data-max="<?php esc_attr_e( pluck( $config, 'max' ) ); ?>"></div>

        <div class="clearfix">
            <div id="display-year-min" class="pull-left range-display"></div>
            <div id="display-year-max" class="pull-right range-display"></div>
        </div>

        <input type="hidden"
               name="year_manufactured"
               id="vehicle-year"
               value="<?php esc_attr_e( maybe_implode( $query->get( 'year_manufactured' ), '-' ) ); ?>" />

    </div>

<?php }


/**
 * Render the make field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_make( $config, $query ) {

    $makes = get_available_makes_for_type( $query->get( 'post_type' ) ); ?>

    <div class="form-field">

        <label for="make" class="label">
            <?php esc_html_e( pluck( $config, 'label' ) ); ?>
        </label>

        <select id="make"
                name="make"
                type="text"
                class="form-control"
                data-selectize
                placeholder="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>">

            <option value=""><?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?></option>

            <?php foreach ( $makes as $make ) : ?>

                <option value="<?php esc_attr_e( $make ); ?>"
                    <?php selected( $make, $query->get( 'make' ) ); ?>><?php esc_html_e( $make ); ?>
                </option>

            <?php endforeach; ?>

        </select>

    </div>

<?php }


/**
 * Render the model field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_model( $config, $query ) { ?>

    <div class="form-field">

        <label for="model" class="label"><?php esc_html_e( pluck( $config, 'label' ) ); ?></label>

        <input type="text"
               id="model"
               name="model"
               class="form-control select-multiple"
               data-dependencies='[name="make"]'
               placeholder="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               value="<?php esc_attr_e( maybe_implode( $query->get( 'model' ), ',' ) ); ?>" />

    </div>

<?php }


/**
 * Render the body type field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_body_type( $config, $query ) { ?>

    <div class="form-field">

        <label for="body-type" class="label"><?php esc_html_e( pluck( $config, 'label' ) ); ?></label>

        <input type="text"
               id="body-type"
               name="body_type"
               class="form-control select-multiple"
               data-dependencies='[name="make"],[name="model"]'
               placeholder="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               value="<?php esc_attr_e( maybe_implode( $query->get( 'body_type' ), ',' ) ); ?>" />

    </div>

<?php }


/**
 * Render the engine field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_engine( $config, $query ) { ?>

    <div class="form-field">

        <label for="engine" class="label"><?php esc_html_e( pluck( $config, 'label' ) ); ?></label>

        <input type="text"
               id="engine"
               name="engine"
               class="form-control select-multiple"
               data-dependencies='[name="make"],[name="model"],[name="transmission"]'
               placeholder="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               value="<?php esc_attr_e( $query->get( 'engine' ) ); ?>" />

    </div>

<?php }


/**
 * Render the transmission field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_transmission( $config, $query ) { ?>

    <div class="form-field">

        <label for="transmission" class="label"><?php esc_html_e( pluck( $config, 'label' ) ); ?></label>

        <input type="text"
               id="transmission"
               name="transmission"
               class="form-control select-multiple"
               data-dependencies='[name="make"],[name="model"],[name="engine"]'
               placeholder="<?php esc_attr_e( pluck( $config, 'placeholder' ) ); ?>"
               value="<?php esc_attr_e( $query->get( 'transmission' ) ); ?>" />

    </div>

<?php }


/**
 * Render the condition field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_condition( $config, $query ) {

    $condition = $query->get( 'condition' );  ?>

    <label class="label"><?php esc_html_e( pluck( $config, 'label' ) ); ?></label>

    <fieldset>

        <label class="radio-label">
            <input class="cdemo-item-type"
                   type="radio"
                   value="new"
                   name="condition"
                <?php checked( 'new', $condition ); ?> /> <?php _e( 'New', 'cdemo' ); ?>
        </label>

        <br>

        <label class="radio-label">
            <input class="cdemo-item-type"
                   type="radio"
                   value="used"
                   name="condition"
                <?php checked( 'used', $condition ); ?> /> <?php _e( 'Used', 'cdemo' ); ?>
        </label>

        <br>

        <label class="radio-label">
            <input class="cdemo-item-type"
                   type="radio"
                   value="certified_pre-owned"
                   name="condition"
                <?php checked( 'certified_pre-owned', $condition ); ?> /> <?php _e( 'Certified Pre-Owned', 'cdemo' ); ?>
        </label>

    </fieldset>

<?php }


/**
 * Render the price field in the search form.
 *
 * @param $config
 * @param $query
 *
 * @since 1.0.0
 * @return void
 */
function render_ui_search_price( $config, $query ) { ?>

    <div class="form-field">

        <span id="price-label-wrap">
            <label class="label"><?php esc_html_e( pluck( $config, 'label' ) ); ?></label>
        </span>

        <div id="price-range-slider"
             data-currency="<?php esc_attr_e( get_option( Options::CURRENCY_CODE ) ); ?>"
             data-slider-for="price-range"
             data-display="display-price"
             data-step="<?php esc_attr_e( pluck( $config, 'step' ) ); ?>"
             data-min="<?php esc_attr_e( pluck( $config, 'min' ) ); ?>"
             data-max="<?php esc_attr_e( pluck( $config, 'max' ) ); ?>"></div>

        <div class="clearfix">
            <div id="display-price-min" class="pull-left range-display"></div>
            <div id="display-price-max" class="pull-right range-display"></div>
        </div>

        <input type="hidden"
               name="price"
               id="price-range"
               value="<?php esc_attr_e( maybe_implode( $query->get( 'price' ), '-' ) ); ?>" />

    </div>

<?php }