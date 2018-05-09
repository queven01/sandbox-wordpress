<?php
/**
 * General template for a settings form.
 *
 * @since 1.0.0
 * @package cdemo
 * @subpackage admin
 */
namespace cdemo;

?>

<form method="post" action="options.php">

    <?php do_settings_sections( $page ); ?>

    <?php settings_fields( $option_group ); ?>

    <?php submit_button(); ?>

</form>
