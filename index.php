<?php
/*
Plugin name: JN Plugin
Plugin URI: http://www.justinnavarro.net/plugins
Description: Template to site plugin
Author: Justin Navarro
Version: 0.1
Author URI: http://www.justinnavarro.net
License: GPL2
*/
global $wpdb;

require_once 'App/bootstrap.php';
require_once 'App/routes.php';

use App\Managers\MigrationManager as Migration;

/*
|--------------------------------------------------------------------------
| Registration Hooks
|--------------------------------------------------------------------------
|
| Can only be called here.
|
*/

register_activation_hook(__FILE__, function() {
    Migration::migrate();
});

register_deactivation_hook(__FILE__,function() {
    Migration::rollback();
});


/*
|--------------------------------------------------------------------------
| WordPress Additionals
|--------------------------------------------------------------------------
|
| Additional addons for this WordPress Plugin.
|
*/

add_action('admin_menu', function() {
    $menu = new App\WP\MenuWP();
    $menu->removeMenuItems(['Pages']);
});

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style('jn_plugin_styles', plugins_url('style.css', __FILE__));
    wp_enqueue_script("jn_plugin_script", plugins_url('main.min.js', __FILE__), array(), null, true);
    wp_enqueue_media();
});