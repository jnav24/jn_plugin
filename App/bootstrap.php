<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Managers\EnvManager as Env;
use Illuminate\Database\Capsule\Manager as Capsule;

/*
|--------------------------------------------------------------------------
| Global functions
|--------------------------------------------------------------------------
|
| Global functions that returns a provider class
|
*/

$run = [
    'fake' => App\Providers\FakeProvider::getInstance(),
    'mag' => App\Providers\MsgProvider::getInstance(),
    'session' => App\Providers\SessionProvider::getInstance(),
];

foreach ($run as $key => $value)
{
    $GLOBALS[$key] = $value;
    eval("function $key() { global $$key; return $$key; }");
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

/*
|--------------------------------------------------------------------------
| Autoload Helpers
|--------------------------------------------------------------------------
|
| Get all the files in the Helpers.
| Has to be after the global fake aka not in composer.
|
*/

function auto_load()
{
    $filePath = __DIR__ . '/Helpers';
    if( $fileList = opendir($filePath) )
    {
        while( ($file = readdir($fileList)) !== FALSE )
        {
            if(!preg_match('/\.$/',$file) && preg_match('/.php$/', $file))
            {
                $path = $filePath . '/' . $file;
                if(file_exists($path))
                {
                    require_once $path;
                }
            }
        }
    }
}
auto_load();