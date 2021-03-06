<?php

namespace App\Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class PageMigration
{
    public function up()
    {
        if(!Capsule::schema()->hasTable('pages'))
        {
            Capsule::schema()->create('pages', function($table) {
                $table->increments('page_id');
                $table->text('page_content');
                $table->string('page_name');
                $table->string('page_url');
                $table->string('page_status');
                $table->string('page_type');
                $table->integer('created_by')->unsigned();
                $table->integer('modified_by')->unsigned();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        if(Capsule::schema()->hasTable('pages'))
        {
            Capsule::schema()->drop('pages');
        }
    }
}