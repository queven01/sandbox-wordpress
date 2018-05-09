<?php
/**
 * General purpose template functions and utilities.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


// Add custom nav menus
add_action( 'init', 'cdemo\register_menu_locations' );


/**
 * Register customizable nav menus.
 *
 * @action init
 *
 * @since 1.0.0
 * @return void
 */
function register_menu_locations() {

    $locations = array(
        'cdemo_header' => __( 'Inventory Header Navigation Menu', 'cdemo' ),
        'cdemo_footer' => __( 'Inventory Footer Navigation Menu', 'cdemo' )
    );

    register_nav_menus( $locations );

}


/**
 * Retrieve a template from the templates/ directory. Arguments passed will be globally available in the template file.
 * Template files are included by default if the template is found. This function also optionally returns a configured
 * closure that can be executed at a later point.
 *
 * @param string $name     The name of the template (without the file extension).
 * @param array  $args     (Optional) Arguments to be passed to the template.
 * @param bool   $include  Whether or not the template file should be included.
 * @param bool   $once     Whether to include or include_once.
 * @param bool   $execute  Execute the include right away. When set to false, the internal closure will be returned to
 *                         so that the include can be executed at a later point.
 * @param object $bind    (Optional) The object of which the internal closure should bind $this to.
 *
 * @since 1.0.0
 * @return bool|string
 */
function get_template( $name, $args = array(), $include = true, $once = true, $execute = true, $bind = null ) {

    $template = false;
    $name = str_replace( '.php', '', $name ) . '.php';

    // Check root templates and partials path.
    if ( file_exists( CDEMO_TEMPLATES_PATH . $name ) ) {
        $template = CDEMO_TEMPLATES_PATH . $name;
    } else if ( file_exists( CDEMO_PARTIALS_PATH . $name ) ) {
        $template = CDEMO_PARTIALS_PATH . $name;
    }

    // If the template  path is found
    if ( $template ) {

        // If we are to execute an include of the template file
        if ( $include ) {

            // Create a new closure
            $exec = function ( $args ) use ( $template, $once ) {

                // Extract args in scope of closure
                if ( is_array( $args ) ) {
                    extract( $args );
                }

                if ( $once ) {
                    include_once $template;
                } else {
                    include $template;
                }

            };

            // Bind new $this to the closure
            if ( is_object( $bind ) ) {
                $exec = \Closure::bind( $exec, $bind, $bind );
            }

            // If we are executing, pass in any args we were given
            if ( $execute ) {
                $exec( $args );

            // Else return the closure
            } else {
                return $exec;
            }

        }

        // Return template path
        return $template;

    }

    // The template wasn't found
    return false;

}


/**
 * Buffer a rendered template and return the HTML as a string.
 *
 * @param string $name
 * @param array  $args
 * @param bool   $once
 *
 * @since 1.0.0
 * @return string
 */
function buffer_template( $name, $args = array(), $once = true ) {

    ob_start();

    get_template( $name, $args, true, $once );

    return ob_get_clean();

}
