<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Providers\EnvProvider as Env;
use Illuminate\Database\Capsule\Manager as Capsule;

/*
|--------------------------------------------------------------------------
| Fake
|--------------------------------------------------------------------------
|
| Create fake data anywhere!
|
*/

$GLOBALS['fake'] = App\Providers\Fake::getInstance();

function fake()
{
    global $fake;
    return $fake;
}

/*
|--------------------------------------------------------------------------
| Environment Setup
|--------------------------------------------------------------------------
|
| Sets up the environment based on the .env file outside the App directory.
|
*/

$env = new Env();
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
    'prefix' => Env::getEnv('PREFIX', '')
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();