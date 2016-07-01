<?php
namespace App\Controllers;

use App\Models\Options;
use App\Models\Pages;

class PageController extends Controller
{
    public function __construct(Options $options)
    {
        parent::__construct($options);
    }

    public function index()
    {
        $page = [];
        return $this->getView('page.twig', $page);
    }

    public function create()
    {
        return $this->getView('create-page.twig');
    }
    
    public function edit($id)
    {
        $page = Pages::find($id)->first()->toArray();
        $moduleContent = $this->getPageModules($page);
        unset($page['page_content']);
        return $this->getView('modules/base.twig', ['modules' => $moduleContent, 'page' => $page]);
    }

    public function store($post)
    {}

    public function update($post)
    {}

    public function destroy()
    {}
    
    private function getPageModules($moduleContent)
    {
        $pageContent = '';
        $moduleContent['page_content'] = $this->unserialize($moduleContent['page_content']);

        foreach($moduleContent['page_content'] as $module => $content)
        {
            $moduleArray = explode('_', $module);
            $moduleName = $moduleArray[0] . '_' . $moduleArray[1];
            $pageContent .= $this->getView('modules/'.$moduleName.'.twig', ['content' => $content]);
        }
        
        return $pageContent;
    }
}