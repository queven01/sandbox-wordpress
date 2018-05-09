<?php
/**
 * Functions for handling WordPress users.
 *
 * @since 1.0.0
 * @package cdemo
 */
namespace cdemo;


/**
 * Check if a user can manage site options, if $user is null will default to the current user.
 *
 * @param mixed $user
 *
 * @since 1.0.0
 * @return bool
 */
function user_can_manage_options( $user = null ) {

    if ( is_null( $user ) ) {
        return current_user_can( 'manage_options' );
    }

    return user_can( $user, 'manage_options' );

}
