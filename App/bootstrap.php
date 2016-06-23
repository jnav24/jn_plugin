<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Containers\TwigContainer;
use App\Models\Options;
use App\Providers\EnvProvider;
use Illuminate\Database\Capsule\Manager as Capsule;

$twig = new TwigContainer(__DIR__.'/Views', new Options());

/*
|--------------------------------------------------------------------------
| Environment Setup
|--------------------------------------------------------------------------
|
| Sets up the environment based on the .env file outside the App directory.
|
*/

$env = new EnvProvider();
$env->setPath(__DIR__ . '/../');
$env->load();

/*
|--------------------------------------------------------------------------
| Schema Setup and Init
|--------------------------------------------------------------------------
|
| The schema is the migration of custom tables located in the App\Migrations
|
|
*/

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'mysql',
    'database' => DB_NAME,
    'host' => DB_HOST,
    'username' => DB_USER,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);
$capsule->setAsGlobal();
//$capsule->bootEloquent();

/*
|--------------------------------------------------------------------------
| WordPress Additionals
|--------------------------------------------------------------------------
|
| Additional addons for this WordPress Plugin.
|
*/

add_action('admin_enqueue_scripts',function() {
    wp_enqueue_style('hmstyles', plugins_url('main.css',__FILE__));
    wp_enqueue_script("jquery");
    wp_enqueue_media();
});