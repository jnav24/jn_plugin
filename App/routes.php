<?php
use App\Providers\EnvProvider as Env;

add_action('admin_menu', function() {
    add_menu_page(Env::getEnv('PAGE_TITLE','blah'), Env::getEnv('MENU_NAME', 'JN Plugin Name'),'manage_options', Env::getEnv('MENU_SLUG', 'jn-plugin'), function() {
        echo "main page";
    }, '','2.3');
});

add_action('admin_menu', function() {
    add_submenu_page(Env::getEnv('MENU_SLUG', 'jn-plugin'), Env::getEnv('SUBMENU_TITLE', 'Add Page'), Env::getEnv('SUBMENU_NAME', 'Add Page'), 'manage_options', Env::getEnv('SUBMENU_SLUG', 'jn-subplugin'), function() {
        echo "add page";
    });
});