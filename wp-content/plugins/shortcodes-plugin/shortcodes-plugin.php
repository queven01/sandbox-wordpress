<?php
/*
Plugin Name: Custom Shortcode Plugin
Plugin URI: https://www.strathcom.com
description: Create your own shortcodes or use pre-made ones!
Version: 1.0
Author: Kevin Correa
*/

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
