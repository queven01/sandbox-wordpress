<?php
/**
 * Template for managing the vehicles list view.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;

?>

<div class="cdemo-manage-ui">

    <form action="?">

        <label for="ui-category"><?php _e( 'Select a category to edit:', 'cdemo' ); ?></label>

        <select name="category" id="ui-category">

            <?php foreach ( $categories as $category ) : ?>

                <option value="<?php esc_attr_e( $category->name ); ?>"
                    <?php selected( $category->name, $context ); ?>>

                    <?php esc_html_e( $category->labels->singular_name ) ; ?>

                </option>

            <?php endforeach; ?>

        </select>

        <button class="button"><?php _e( 'Select', 'cdemo' ); ?></button>

        <input type="hidden" name="page"    value="<?php esc_attr_e( get_request_var( 'page' ) ); ?>">
        <input type="hidden" name="tab"     value="<?php esc_attr_e( get_request_var( 'tab' ) ); ?>">
        <input type="hidden" name="section" value="<?php esc_attr_e( get_request_var( 'section' ) ); ?>">

    </form>

</div>


<!-- manage-ui-wrapper -->
<div id="cdemo-manage-ui-wrapper">

    <!-- manage-ui-frame -->
    <div id="cdemo-manage-ui-frame" class="wp-clearfix">

        <!-- ui-fields-column -->
        <div id="cdemo-ui-fields-column" class="ui-fields-column">

            <div id="cdemo-ui-fields-palette" class="ui-fields-palette">

                <div class="inner">

                    <h3 class="title"><?php _e( 'Inactive Fields', 'cdemo' ); ?></h3>

                    <ul id="cdemo-available-fields" class="ui-fields">

                        <li class="empty-message" <?php echo empty( $config ) || count( $config ) < count( $fields ) ? 'style="display: none;"' : ''; ?>>
                            <?php _e( 'No more fields available', 'cdemo' ); ?>
                        </li>

                        <?php foreach ( $fields as $id => $field ) : ?>


                            <?php if ( empty( $config ) || !array_key_exists( $id, $config ) ) : ?>

                                <li class="ui-field">
                                    <?php render_ui_edit_field( $option, $context, $id, $field['title'], $field['default'] ); ?>
                                </li>

                            <?php endif; ?>


                        <?php endforeach; ?>

                    </ul>

                </div>

            </div>

        </div><!-- /manage-fields-column -->


        <!-- manage-ui-fields -->
        <div id="cdemo-manage-ui-fields">

            <div id="cdemo-fields-management" class="ui-fields-management">

                <form method="post" action="options.php">

                    <div class="ui-edit-fields">

                        <div id="cdemo-ui-fields-header">

                            <div class="ui-publishing-actions wp-clearfix">
                                <h3 class="title"><?php _e( 'Active fields', 'cdemo' ); ?></h3>
                                <div class="ui-publishing-action">
                                    <button class="button-primary"><?php _e( 'Save Fields', 'cdemo' ); ?></button>
                                </div>

                            </div>

                        </div>

                        <div class="inner wp-clearfix">

                            <ul id="cdemo-fields-configuration" class="ui-fields">

                                <li class="empty-message" <?php echo !empty( $config ) ? 'style="display: none;"' : ''; ?>>
                                    <?php _e( 'Get started by dragging and dropping a field', 'cdemo' ); ?>
                                </li>

                                <?php if ( !empty( $config ) ) : ?>


                                    <?php foreach ( $config as $id => $label ) : ?>

                                        <li class="ui-field editable">
                                            <?php render_ui_edit_field( $option, $context, $id, $fields[ $id ]['title'], $label ); ?>
                                        </li>

                                    <?php endforeach; ?>


                                <?php endif; ?>

                            </ul>

                        </div>

                        <div id="cdemo-ui-fields-footer">

                            <div class="ui-publishing-actions wp-clearfix">

                                <div class="ui-publishing-action">
                                    <button class="button-primary"><?php _e( 'Save Fields', 'cdemo' ); ?></button>
                                </div>

                            </div>

                        </div>

                    </div>

                    <?php settings_fields( $option_group ); ?>

                </form>

            </div>

        </div><!-- /manage-ui-fields -->

    </div><!-- /manage-ui-frame -->

</div><!-- /manage-ui-wrapper -->