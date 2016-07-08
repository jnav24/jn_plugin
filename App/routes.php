<?php

use App\Controllers\ModuleController;
use App\Controllers\PageController;
use App\Controllers\PageListController;
use Illuminate\Database\Capsule\Manager as Capsule;

$pageList = new PageListController();
$page = new PageController();
$module = new ModuleController();
$parent_slug = env()->getEnv('PREFIX', 'jn_') . "list_pages";

/*
|--------------------------------------------------------------------------
| Main Plugin Page
|--------------------------------------------------------------------------
|
*/

add_action('admin_menu', function() use ($parent_slug, $pageList) {
    $pageTitle = "JN Plugin";
    $pageName = "JN Plugin";

    add_menu_page($pageTitle, $pageName,'manage_options', $parent_slug, function() use ($pageList) {
        echo $pageList->index();
    }, '','2.3');
});

/*
|--------------------------------------------------------------------------
| Modules page
|--------------------------------------------------------------------------
|
*/

add_action('admin_menu', function() use ($parent_slug, $module) {
    $child_slug = env()->getEnv('PREFIX', 'jn_') . "edit_modules";
    $pageTitle = "Edit Modules";
    $pageName = "Edit Modules";

    add_submenu_page($parent_slug, $pageTitle, $pageName, 'manage_options', $child_slug, function() use ($module) {
        echo $module->edit();
    });
});

/*
|--------------------------------------------------------------------------
| Add Page
|--------------------------------------------------------------------------
|
*/

add_action('admin_menu', function() use ($parent_slug,  $page) {
    $child_slug = env()->getEnv('PREFIX', 'jn_') . "add_page";
    $pageTitle = "Add Page";
    $pageName = "Add Page";

    add_submenu_page($parent_slug, $pageTitle, $pageName, 'manage_options', $child_slug, function() use ($page) {
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

if(Capsule::schema()->hasTable('pages'))
{
    $allPages = Capsule::table('pages')->get();
    if(!empty($allPages))
    {
        add_action('admin_menu', function() use ($page, $allPages) {
            foreach($allPages as $singlePage)
            {
                $submenuName = env()->getEnv('PREFIX', 'jn_') . $singlePage->page_url;
                $singlePage->page_name = ucfirst($singlePage->page_name);

                add_submenu_page(null, $singlePage->page_name, $singlePage->page_name, 'manage_options', $submenuName, function() use ($page, $singlePage) {
                    echo $page->edit($singlePage->page_id);
                });
            }
        });
    }
}

/*
|--------------------------------------------------------------------------
| All Post calls
|--------------------------------------------------------------------------
|
*/

if(isset($_POST['page_action']))
{
    switch ($_POST['page_action'])
    {
        case "create":
            $page->store($_POST);
            break;
        case "update":
            $page->update($_POST);
            break;
        case "delete":
            $page->destroy($_POST);
            break;
        case "module-update":
            $module->update($_POST);
            break;
        case "module-delete":
            $module->destroy($_POST);
            break;
    }
}