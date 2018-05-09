<?php
/**
 * Template for listings widget form.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;

?>

<p>

    <label class="title" for="<?php echo $this->get_field_id( 'title' ) ?>">
        <?php _e( 'Title', 'cdemo' ); ?>
    </label>

    <input type="text"
           class="widefat"
           id="<?php echo $this->get_field_id( 'title' ) ?>"
           name="<?php echo $this->get_field_name( 'title' ) ?>"
           value="<?php echo esc_attr( pluck( $instance, 'title' ) ); ?>" />

</p>

<p>

    <label><?php _e( 'Category', 'cdemo' ); ?></label>

    <fieldset>

        <?php foreach( active_listing_types() as $category ) : ?>

            <label>

                <input type="checkbox"
                       name="<?php echo $this->get_field_name( 'vehicle_category' ) ?>[]"
                       value="<?php echo esc_attr( $category ); ?>"
                    <?php checked( in_array( $category, pluck( $instance, 'vehicle_category' ) ) ) ?> /><?php esc_html_e( $category ); ?>

            </label>

            <br>

        <?php endforeach; ?>

    </fieldset>

</p>

<p>

    <label for="<?php echo $this->get_field_id( 'count' ) ?>">
        <?php _e( 'Number of listings to show', 'cdemo' ); ?>
    </label>

    <input type="number"
           class="widefat"
           id="<?php echo $this->get_field_id( 'count' ) ?>"
           name="<?php echo $this->get_field_name( 'count' ) ?>"
           value="<?php echo absint( pluck( $instance, 'count' ) ); ?>" />

</p>

<p>

    <label for="<?php echo $this->get_field_id( 'order_by' ) ?>">
        <?php _e( 'Order by', 'cdemo' ); ?>
    </label>

    <select class="widefat"
            id="<?php echo $this->get_field_id( 'order_by' ) ?>"
            name="<?php echo $this->get_field_name( 'order_by' ) ?>">

        <?php foreach( $this->order_by_options() as $key => $value ) : ?>

            <option value="<?php echo $key; ?>"
                <?php selected( $key, pluck( $instance, 'order_by' ) ) ?>><?php esc_html_e( $value ); ?>
            </option>

        <?php endforeach; ?>

    </select>

</p>

<p>

    <label for="<?php echo $this->get_field_id( 'order' ) ?>">
        <?php _e( 'Order', 'cdemo' ); ?>
    </label>

    <select class="widefat"
            id="<?php echo $this->get_field_id( 'order' ) ?>"
            name="<?php echo $this->get_field_name( 'order' ) ?>">

        <?php foreach( $this->order_options() as $key => $value ) : ?>

            <option value="<?php esc_attr_e( $key ); ?>"
                <?php selected( $key, $instance['order'], true ); ?>><?php esc_html_e( $value ); ?>
            </option>

        <?php endforeach; ?>

    </select>

</p>

