<?php

namespace App\Containers;

class MigrationsRunner
{
    private static function run($method)
    {
        $files = scandir(__DIR__.'/../Migrations');

        foreach($files as $file)
        {
            if(substr($file, -4) == '.php')
            {
                $class = "App\\Migrations\\" . str_replace('.php', '', $file);
                $table = new $class();
                $table->{$method}();
            }
        }
    }
    
    public static function migrate()
    {
        self::run('up');
    }
    
    public static function rollback()
    {
        self::run('down');
    }
}