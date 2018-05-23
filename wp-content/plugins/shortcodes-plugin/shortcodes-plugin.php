<?php
/*
Plugin Name: Custom Shortcode Plugin
Plugin URI: https://www.strathcom.com
description: Create your own shortcodes or use pre-made ones!
Version: 1.0
Author: Kevin Correa
*/




function pure_awesomeness() {

echo "HELLO";

}

add_action(‘init’, ‘pure_awesomeness’);

?>


