<?php
global $wpdb;

if(is_null($wpdb))
{
    function add_action($string, $func)
    {}

    function add_menu_page($s1, $s2, $s3, $s4, $func)
    {}

    function add_submenu_page($s1, $s2, $s3, $s4, $s5, $func)
    {}
}