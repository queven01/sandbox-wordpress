<?php
/**
 * Template for lead metabox.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;

?>

<div class="cdemo-metabox">

    <div class="form-field">

        <label class="label">
            <?php _e( 'For Listing', 'cdemo' ); ?>
        </label>

        <?php listing_dropdown( get_metadata( 'listing_id' ), 'id=cdemo-lead-listing&class=meta-field&name=listing_id' ); ?>

    </div>

    <div class="form-field">

        <label class="label" for="cdemo-lead-type">
            <?php _e( 'Request Type', 'cdemo' ); ?>
        </label>

        <select id="cdemo-lead-type"
                name="type"
                class="meta-field">

            <?php $type = get_metadata( 'type' ); ?>

            <option value="contact"
                <?php selected( 'contact', $type ); ?>><?php _e( 'Contact', 'cdemo' ); ?></option>

            <option value="test_drive"
                <?php selected( 'test_drive', $type ); ?>><?php _e( 'Test Drive', 'cdemo' ); ?></option>

        </select>

    </div>

    <div class="form-field">

        <label class="label" for="cdemo-lead-time">
            <?php _e( 'Requested Time', 'cdemo' ); ?>
        </label>

        <input id="cdemo-lead-time"
               class="meta-field"
               type="datetime"
               name="requested_time"
               value="<?php esc_attr_e( get_metadata( 'requested_time' ) ); ?>" />

    </div>

    <div class="form-field">

        <label class="label" for="cdemo-lead-name">
            <?php _e( 'Name', 'cdemo' ); ?>
        </label>

        <input id="cdemo-lead-name"
               name="name"
               type="text"
               class="meta-field"
               value="<?php esc_attr_e( get_metadata( 'name' ) ); ?>" />

    </div>

    <div class="form-field">

        <label class="label" for="cdemo-preferred-contact">
            <?php _e( 'Preferred Contact', 'cdemo' ); ?>
        </label>

        <select id="cdemo-preferred-contact"
                class="meta-field"
                name="preferred">

            <?php $preferred = get_metadata( 'preferred' ); ?>

            <option value="phone"
                <?php selected( 'phone', $preferred ); ?>><?php _e( 'Phone', 'cdemo' ); ?></option>

            <option value="email"
                <?php selected( 'email', $preferred ); ?>><?php _e( 'Email', 'cdemo' ); ?></option>

        </select>

    </div>

    <div class="form-field">

        <label class="label" for="cdemo-lead-phone">
            <?php _e( 'Phone', 'cdemo' ); ?>
        </label>

        <input id="cdemo-lead-phone"
               name="phone"
               type="text"
               class="meta-field"
               value="<?php esc_attr_e( get_metadata( 'phone' ) ); ?>" />

    </div>

    <div class="form-field">

        <label class="label" for="cdemo-lead-email">
            <?php _e( 'Email', 'cdemo' ); ?>
        </label>

        <input id="cdemo-lead-email"
               name="email"
               type="text"
               class="meta-field"
               value="<?php esc_attr_e( get_metadata( 'email' ) ); ?>" />

    </div>

    <?php meta_fields( 'lead' ); ?>

</div>
