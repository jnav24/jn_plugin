<?php
use App\Controllers\PageController;
use App\Controllers\PageListController;
use App\Managers\EnvManager as Env;
use App\Models\Pages;

$allPages = Pages::all();
$pageList = new PageListController();
$page = new PageController();
$parent_slug = Env::getEnv('PREFIX', 'jn_') . Env::getEnv('MENU_SLUG', 'jn-plugin');
$child_slug = Env::getEnv('PREFIX', 'jn_') . Env::getEnv('SUBMENU_SLUG', 'jn-subplugin');

/*
|--------------------------------------------------------------------------
| Main Plugin Page
|--------------------------------------------------------------------------
|
*/

add_action('admin_menu', function() {
    global $parent_slug;
    add_menu_page(Env::getEnv('MENU_TITLE','JN Plugin Title'), Env::getEnv('MENU_NAME', 'JN Plugin Name'),'manage_options', $parent_slug, function() {
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
    global $parent_slug, $child_slug;
    add_submenu_page($parent_slug, Env::getEnv('SUBMENU_TITLE', 'Add Page'), Env::getEnv('SUBMENU_NAME', 'Add Page'), 'manage_options', $child_slug, function() {
        global $page;
        echo $page->create();
    });
});

/*
|--------------------------------------------------------------------------
| Rest of the pages
|--------------------------------------------------------------------------
| Because having all the pages, that might be created, appear in the submenu,
| whether its 1 or 100, is not desirable and access to those pages is needed,
| the code below will allow this.
|
*/

if(!empty($allTemplates))
{
    add_action('admin_menu', function() {
        global $allPages;

        foreach($allPages as $singlePage)
        {
            $submenuName = Env::getEnv('PREFIX', 'jn_') . $singlePage['page_url'];
            $singlePage['page_name'] = ucfirst($singlePage['page_name']);

            add_submenu_page(null, $singlePage['page_name'], $singlePage['page_name'], 'manage_options', $submenuName, function() {
                global $page, $singlePage;
                echo $page->edit($singlePage['page_id']);
            });
        }
    });
}