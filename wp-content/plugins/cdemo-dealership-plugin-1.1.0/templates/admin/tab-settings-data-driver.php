<?php
/**
 * Template for Data Driver settings tab.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage cdemo\admin
 */
namespace cdemo;

?>


<?php if ( sync_enabled() ) : ?>


    <h2><?php _e( 'cDemo PIM Sync', 'cdemo' ); ?></h2>

    <table class="form-table">

        <tr>

            <th><?php _e( 'Sync Status', 'cdemo' ); ?></th>

            <td>

                <div id="data-driver">

                    <div class="left">

                        <div class="sync-progress">
                            <span class="sync-indicator"></span>
                        </div>

                    </div>

                    <div class="right">

                        <button type="button" class="button control-sync">
                            <span class="control-feedback"></span>
                        </button>

                    </div>

                </div>

                <p class="description sync-message"></p>

            </td>

        </tr>

    </table>

<?php endif; ?>

<form method="post" action="options.php">

    <?php do_settings_sections( $page ); ?>
    <?php settings_fields( $option_group ); ?>
    <?php submit_button(); ?>

</form>
