<?php
namespace App\Seeds;

use Illuminate\Database\Capsule\Manager as Capsule;

class ModuleSeed
{
    public function run()
    {
        $modules = array(
            [
                'module_file' => 'module_banner',
                'module_image' => 'banner'
            ],
            [
                'module_file' => 'module_slideshow',
                'module_image' => 'slideshow'
            ],
        );

        Capsule::table('modules')->insert($modules);
    }
}