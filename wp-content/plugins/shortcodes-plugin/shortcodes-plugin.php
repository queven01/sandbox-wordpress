<?php
/*
Plugin Name: Custom Shortcode Plugin
Plugin URI: https://www.strathcom.com
description: Create your own shortcodes or use pre-made ones!
Version: 1.0
Author: Kevin Correa
*/
?>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<?php

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
//        update_option('existing_code_saved', $_POST['saved-shortcode']);

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
    $saved_shortcodes = get_option('existing_code_saved', 'none');

    ?>

    <div class="wrap">
        <h2>User Created Shortcodes</h2>
        <form method="post" action="">
	        <label for="shortcode_name">Shortcode Name</label>
	        <input type="text" name="shortcode_name" class="large-text" value="<?php print $shortcode_name; ?>">
	        <label for="shortcode_name">Creator</label>
	        <input type="text" name="creator_name" class="large-text" value="<?php print $shortcode_creator_name; ?>">
	        <label for="shortcode_input">Add Your Code Here</label>
	        <textarea class="large-text" name="shortcode_input" id="short-code-creator" cols="30" rows="15"><?php echo stripslashes($shortcode); ?></textarea>
	        <input type="submit" name="submit_shortcode_update" value="Submit Shortcode" class="button-primary">
	        <input type="button" name="add_new" value="Add New" class="button-secondary clear-form">
	        <input type="submit" name="btnDelete" value="Delete" class="button-secondary"/>
<!--	        <textarea class="large-text shortcode-list" name="saved-shortcode" cols="30" rows="15">--><?php //print $saved_shortcodes; ?><!--</textarea>-->
        </form>
    </div>

	<br><h2>Copy the Shortcode Below</h2>

	<?php

    if (strpos($shortcode_name, '_shortcode_plugin') !== false) {
        $shortcode_name = $shortcode_name;
	    }else {
        $shortcode_name = $shortcode_name . '_shortcode_plugin';
    }
	?>
	<div><h4><?php echo '['.$shortcode_name.']' ;?></h4></div><hr>


    <?php

		$option_name = $shortcode_name;
		$new_value = $shortcode ;

		if ( get_option( $option_name ) !== false ) {

		    // The option already exists, so we just update it.
		    update_option( $option_name, $new_value );
		    echo '<br><div class="update"><h1>Update Content Below</h1><hr>'.$new_value.'</div>';

		} else {

		    // The option hasn't been added yet. We'll add it with $autoload set to 'no'.
		    $deprecated = null;
		    $autoload = 'yes';
		    add_option( $option_name, $new_value, $deprecated, $autoload );
            echo '<br><div class="update"><h1>New Content Below</h1><hr>'.$new_value.'</div>';
		}


	    $all_options = wp_load_alloptions();

	    $my_options = array();
	    foreach( $all_options as $name => $value ) {
	        if(stristr($name, '_shortcode_plugin')) $my_options[$name] = $value;
	    }
	    ?>
	    <br><select name="dropdown-shortcodes" id="dropdown-shortcodes">
		  <option selected="selected">Choose one</option>
		  <?php
		    foreach( $my_options as $name => $value ) {
	            if(stristr($name, '_shortcode_plugin')) $my_options[$name] = $value; ?>
			    <option value="<?= $value ?>"><?= $name ?></option>
		        <?php
		    } ?>
		</select>

  <?php



} //user_shortcode_page

function user_created_shortcode(){
    {
            global $shortcode;
            return $shortcode;
        }
}
add_shortcode( $shortcode_name, 'user_created_shortcode');

function user_created_shortcode_two(){
    {
        $test = "second short code";
        return $test;
    }
}
add_shortcode( 'test', 'user_created_shortcode_two');





?>
<script type="text/javascript">
	$(document).ready(function(){
        $("#dropdown-shortcodes").change(function () {
            var value = $(this).val();
            var shortcode_name = $("#dropdown-shortcodes option:selected").text()
            var shortcode_creator = $("#dropdown-shortcodes option:selected").text()

            $("input[name=\'shortcode_name\']").val(shortcode_name);
            $("input[name=\'shortcode_name\']").val(shortcode_creator);
            $("textarea[name=\'shortcode_input\']").text(value);

        });

        $('.clear-form').click(function(){

            $("input[name=\'shortcode_name\']").val('');
            $("input[name=\'creator_name\']").val('');
            $("textarea[name=\'shortcode_input\']").text('');

        });

		// $("input[type=\'submit\']").click(function(){
         //    var $shortcodeValue = $("#short-code-creator").val();
        //
         //    $('.shortcode-list').append(document.createTextNode($shortcodeValue));
        //
		// });
    });
</script>


<?php




//defined('ABSPATH') or die('Bad...no!');
//
//class kevinShortCode
//{
//    function __construct(){
//        add_action('init', array($this, 'custom_post_type'));
//    }
//
//    function register(){
//        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
//    }
//
//    function activate() {
//        //Generate CPT
//        $this->register_post_type();
//        //Flush
//        flush_rewrite_rules();
//    }
//
//    function deactivate() {
//        //Flush
//        flush_rewrite_rules();
//    }
//
//    function uninstall() {
//
//
//    }
//    function custom_post_type(){
//        register_post_type('customShortcode', ['public' => true, 'label' => 'Short Code']);
//    }
//
//    function enqueue(){
//        //enqueue all scripts
//        wp_enqueue_style('mypluginstyle', plugins_url('shortcodes-plugin/assets/css/main.css'), __FILE__);
//        wp_enqueue_script('mypluginscript', plugins_url('shortcodes-plugin/assets/js/main.js'), __FILE__);
//    }
//
//}
//
//if (class_exists('kevinShortCode')){
//
//    $kevinShortCode = new kevinShortCode();
//    $kevinShortCode->register();
//
//}
//
////activation
//register_activation_hook(__FILE__, array($kevinShortCode, 'active'));
//
////deactivation
//register_deactivation_hook(__FILE__, array($kevinShortCode, 'deactivate'));
//
////uninstall
