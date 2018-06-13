<?php
/*
Plugin Name: Custom Shortcode Plugin
Plugin URI: https://www.strathcom.com
description: Create your own shortcodes or use pre-made ones!
Version: 1.0
Author: Kevin Correa
*/

$shortcode = get_option('existing_code', 'none');
$shortcode_name = get_option('existing_code_name', 'none');

function user_shortcode_admin_menu(){
    add_menu_page(
        'Custom User Created Shortcodes',
        'User Shortcode',
        'manage_options',
        'user-shortcode-admin-menu',
        'user_shortcode_page'
    );
}
add_action('admin_menu', 'user_shortcode_admin_menu');

function user_shortcode_page()
{
    if (array_key_exists('submit_shortcode_update', $_POST))
    {
        update_option('existing_code', $_POST['shortcode_input']);
        update_option('existing_code_name', $_POST['shortcode_name']);
        update_option('existing_code_creator_name', $_POST['creator_name']);

        ?>

	    <div id="setting-error-settings_updated" class="updated setting-error notice is-dismissable">
		    <strong>
			    Settings have been saved.
		    </strong>
	    </div>

	    <?php
    }

    global $shortcode, $shortcode_name;

    $shortcode = get_option('existing_code', 'none');
    $shortcode_name = get_option('existing_code_name', 'none');
    $shortcode_creator_name = get_option('existing_code_creator_name', 'none');

    ?>

    <div class="wrap">
        <h2>User Created Shortcodes</h2>
        <form method="post" action="">
	        <label for="shortcode_name">Shortcode Name</label>
	        <input type="text" name="shortcode_name" class="large-text" value="<?php print $shortcode_name; ?>">
	        <label for="shortcode_name">Creator</label>
	        <input type="text" name="creator_name" class="large-text" value="<?php print $shortcode_creator_name; ?>">
	        <label for="shortcode_input">Add Your Code Here</label>
	        <textarea class="large-text" name="shortcode_input" id="short-code-creator" cols="30" rows="15"><?php print $shortcode; ?></textarea>
	        <input type="submit" name="submit_shortcode_update" value="Submit Shortcode" class="button-primary">
        </form>
    </div>

	<h2>Shortcode</h2>
	<div><?php echo '['.$shortcode_name.']' ;?></div>

  <?php

//	function display_user_created_shortcode(){
//        $shortcode = get_option('existing_code', 'none');
//        print $shortcode;
//	}
//	add_action('wp-head', 'display_user_created_shortcode');

} //user_shortcode_page

function user_created_shortcode(){
    {
            global $shortcode;
            return $shortcode;
        }
}
add_shortcode( $shortcode_name, 'user_created_shortcode');







echo '<script type="text/javascript">
        
      </script>';





defined('ABSPATH') or die('Bad...no!');

class kevinShortCode
{
    function __construct(){
        add_action('init', array($this, 'custom_post_type'));
    }

    function register(){
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    function activate() {
        //Generate CPT
        $this->register_post_type();
        //Flush
        flush_rewrite_rules();
    }

    function deactivate() {
        //Flush
        flush_rewrite_rules();
    }

    function uninstall() {


    }
    function custom_post_type(){
        register_post_type('customShortcode', ['public' => true, 'label' => 'Short Code']);
    }

    function enqueue(){
        //enqueue all scripts
        wp_enqueue_style('mypluginstyle', plugins_url('shortcodes-plugin/assets/css/main.css'), __FILE__);
        wp_enqueue_script('mypluginscript', plugins_url('shortcodes-plugin/assets/js/main.js'), __FILE__);
    }

}

if (class_exists('kevinShortCode')){

    $kevinShortCode = new kevinShortCode();
    $kevinShortCode->register();

}

//activation
register_activation_hook(__FILE__, array($kevinShortCode, 'active'));

//deactivation
register_deactivation_hook(__FILE__, array($kevinShortCode, 'deactivate'));

//uninstall
