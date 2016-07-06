<?php

namespace App\Managers;

class MigrationManager
{
    private static function run($method, $namespace)
    {
        $files = scandir(__DIR__ . '/../' . $namespace);

        foreach($files as $file)
        {
            if(substr($file, -4) == '.php')
            {
                $class = "App\\{$namespace}\\" . str_replace('.php', '', $file);
                $table = new $class();
                $table->{$method}();
            }
        }
    }

    public static function migrate()
    {
        self::run('up', 'Migrations');
        self::run('run', 'Seeds');
    }

    public static function rollback()
    {
        self::run('down', 'Migrations');
    }
}
