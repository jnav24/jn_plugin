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

use App\Providers\MigrationProvider;

/*
|--------------------------------------------------------------------------
| Registration Hooks 
|--------------------------------------------------------------------------
|
| Can only be called here.
|
*/

register_activation_hook(__FILE__, function() {
    MigrationProvider::migrate();
});

register_deactivation_hook(__FILE__,function() {
//    MigrationProvider::rollback();
});

/*
|--------------------------------------------------------------------------
| WordPress Additionals
|--------------------------------------------------------------------------
|
| Additional addons for this WordPress Plugin.
|
*/

add_action('admin_enqueue_scripts',function() {
    wp_enqueue_style('hmstyles', plugins_url('main.css', __FILE__));
    wp_enqueue_script("jquery");
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

	<input name="[module_banner][]">
*/