<?php
global $wpdb;

if(is_null($wpdb))
{
    require __DIR__.'/../../../../wp-config.php';
}