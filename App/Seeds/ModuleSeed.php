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
                'module_image' => 'module_banner.jpg'
            ],
            [
                'module_file' => 'module_slideshow',
                'module_image' => 'module_slideshow.jpg'
            ],
        );

        Capsule::table('modules')->insert($modules);
    }
}