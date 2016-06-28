<?php
global $wpdb;

if(is_null($wpdb))
{
//    require __DIR__.'/../../../../wp-config.php';

    define('DB_NAME', 'jn_plugin');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_HOST', 'localhost');
}