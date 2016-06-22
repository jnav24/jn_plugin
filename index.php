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

require_once 'App/bootstrap.php';

use App\Containers\MigrationsRunner;

/*
|--------------------------------------------------------------------------
| Registration Hooks 
|--------------------------------------------------------------------------
|
| Can only be called here.
|
*/

register_activation_hook(__FILE__, function() {
    MigrationsRunner::migrate();
});

register_deactivation_hook(__FILE__,function() {
    MigrationsRunner::rollback();
});
