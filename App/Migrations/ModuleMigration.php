<?php

namespace App\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class ModuleMigration
{
    public function up()
    {
        if(!Capsule::schema()->hasTable('modules'))
        {
            Capsule::schema()->create('modules', function($table) {
                $table->increments('module_id');
                $table->string('module_file')->unique();
                $table->string('module_image');
            });
        }
    }

    public function down()
    {
        Capsule::schema()->drop('modules');
    }
}