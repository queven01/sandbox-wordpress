<?php
/**
 Trigger this file on plugin uninstall
 */

if (! defined('WP_UNINSTALL_PLUGIN')){
    die;
};

//Clear data base data

$customShortcode = get_posts( array('post_type' => 'customShortcode', 'numberposts' => -1));

foreach($customShortcode as $data){
    wp_delete_post($customShortcode->ID, true);
}
