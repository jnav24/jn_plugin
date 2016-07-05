<?php
use App\Controllers\PageController;
use App\Controllers\PageListController;
use App\Managers\EnvManager as Env;

$pageList = new PageListController();
$page = new PageController();

/*
|--------------------------------------------------------------------------
| Main Plugin Page
|--------------------------------------------------------------------------
|
*/

add_action('admin_menu', function() {
    add_menu_page(Env::getEnv('MENU_TITLE','JN Plugin Title'), Env::getEnv('MENU_NAME', 'JN Plugin Name'),'manage_options', Env::getEnv('MENU_SLUG', 'jn-plugin'), function() {
        global $pageList;
        echo $pageList->index();
    }, '','2.3');
});

/*
|--------------------------------------------------------------------------
| Add Page
|--------------------------------------------------------------------------
|
*/

add_action('admin_menu', function() {
    add_submenu_page(Env::getEnv('MENU_SLUG', 'jn-plugin'), Env::getEnv('SUBMENU_TITLE', 'Add Page'), Env::getEnv('SUBMENU_NAME', 'Add Page'), 'manage_options', Env::getEnv('SUBMENU_SLUG', 'jn-subplugin'), function() {
        global $page;
        echo $page->create();
    });
});