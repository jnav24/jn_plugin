<?php

namespace App\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class CreateTemplateTable
{
    public function up()
    {
        if(!Capsule::schema()->hasTable('template'))
        {
            Capsule::schema()->create('template', function($table) {
                $table->increments('template_id');
                $table->string('template_name');
            });
        }
    }

    public function down()
    {
        if(Capsule::schema()->hasTable('template'))
        {
            Capsule::schema()->drop('template');
        }
    }
}