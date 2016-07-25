<?php
namespace App\Controllers;

use App\Models\Modules;

class ModuleController extends Controller
{    
    public function edit()
    {
        $modules = Modules::orderBy('module_file', 'asc')->get();
        return $this->getView('modules/module_edit.twig', ['modules' => $modules]);
    }

    public function store($post)
    {
        Modules::create([
            'module_file' => $this->setModuleName($post['module_file']),
            'module_image' => $this->stripUrlFromImg($post['module_image'])
        ]);
    }
    
    public function update($post)
    {
        for($i = 0; $i < count($post['module_id']); $i++)
        {
            if(empty($post['module_id'][$i]))
            {
                $this->store(['module_file'=>$post['module_file'][$i], 'module_image' => $post['module_image'][$i]]);
                continue;
            }

            $module = Modules::find($post['module_id'][$i]);
            $module->module_file = $this->setModuleName($post['module_file'][$i]);
            $module->module_image = $post['module_image'][$i];
            $module->save();
        }
    }
    
    public function destroy($post)
    {
        if(!empty($post['id']))
        {
            Modules::destroy($post['id']);
        }
    }

    private function setModuleName($module)
    {
        return 'module_' . $this->makeModuleSafe($module);
    }
}