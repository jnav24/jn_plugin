<?php
namespace App\Controllers;

use App\Models\Pages;
use App\Models\Modules;
use Carbon\Carbon;

class PageController extends Controller
{
    public function index()
    {
        $page = Pages::all()->toArray();
        return $this->getView('list-page.twig', ['pages' => $page]);
    }

    public function create()
    {
        $modules = Modules::all()->toArray();
        return $this->getView('pages/page_create.twig', ['modules' => $modules, 'page' => []]);
    }

    public function newCreate()
    {
        $modules = Modules::all()->toArray();
        $page = '';
        return $this->getView('pages/page_create_new.twig', ['modules' => $modules, 'page' => $page]);
    }
    
    public function edit($id)
    {
        $page = Pages::where('page_id', $id)->first()->toArray();
        $moduleContent = $this->getPageModules($page);
        unset($page['page_content']);
        return $this->getView('pages/page_edit.twig', ['modules' => $moduleContent, 'page' => $page]);
    }

    public function store($post)
    {
        if(!isset($post['modules']))
        {
            $post['modules'] = [];
        }
        
        $page = new Pages();
        $page->page_name = $post['page_name'];
        $page->page_url = $this->urlFormat($post['page_name']);
        $page->page_content = $this->serialize($post['modules']);
        $page->page_status = 'draft';
        $page->created_by = $post['modified_by'];
        $page->modified_by = $post['modified_by'];
        $page->created_at = Carbon::now();
        $page->updated_at = Carbon::now();
        $page->save();
        
//        msg()->success('Page has been updated successfully.');
        
        return $page;
    }

    public function update($post)
    {
        $page = Pages::find($post['page_id']);
        $page->page_name = $post['page_name'];
        $page->page_url = $this->urlFormat($post['page_name']);
        $page->page_content = $this->serialize($post['page_content']);
        $page->page_status = $post['page_status'];
        $page->modified_by = $post['modified_by'];
        $page->updated_at = Carbon::now();

        $page->save();
        
        return $page;
    }

    public function destroy($post)
    {
        $page = Pages::find($post['id']);
        Pages::destroy($post['id']);
        return $page;
    }
    
    private function getPageModules($moduleContent)
    {
        $pageContent = '';
        $moduleContent['page_content'] = $this->unserialize($moduleContent['page_content']);

        if(!is_array($moduleContent['page_content']))
        {
            return $pageContent;
        }

        foreach($moduleContent['page_content'] as $module => $content)
        {
            $moduleArray = explode('_', $module);
            $moduleName = $moduleArray[0] . '_' . $moduleArray[1];
            $pageContent .= $this->getModule($moduleName.'.twig', ['content' => $content]);
        }
        
        return $pageContent;
    }
}