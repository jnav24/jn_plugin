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
    wp_enqueue_script("jquery");
    wp_enqueue_script("jqueryui","//code.jquery.com/ui/1.11.4/jquery-ui.js");
    wp_enqueue_media();
});


/*
	create a page and build out an array like this to save

	$page = array(
		'module_banner_0' => [
			0 => 'img.jpg'
		],
		'module_slideshow_0' => [
			0 => [
				'img.jpg'
			]
		],
		'module_text_0' => [
			'title' => '',
			'text' => ''
		]
		'module_banner_1' => [
			0 => 'img.jpg'
		]
	)

	<input name="[modules][module_banner_0][]">
	<input name="[modules][module_text_0][]">

    Steps:
    load page by url
    go to index.php
    get templates from db
    get data from db
    load data to template
    display page
*/