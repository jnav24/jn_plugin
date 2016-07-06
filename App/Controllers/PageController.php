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
        return $this->getView('pages/page-create.twig', ['modules' => $modules]);
    }
    
    public function edit($id)
    {
        $page = Pages::find($id)->first()->toArray();
        $moduleContent = $this->getPageModules($page);
        unset($page['page_content']);
        return $this->getView('modules/base.twig', ['modules' => $moduleContent, 'page' => $page]);
    }

    public function store($post)
    {
        $page = new Pages();
        $page->page_content = $post['page_content'];
        $page->page_name = $post['page_name'];
        $page->page_url = $post['page_url'];
        $page->created_by = $post['modified_by'];
        $page->modified_by = $post['modified_by'];
        $page->created_at = Carbon::now();
        $page->updated_at = Carbon::now();
        $page->save();

//        msg()->success('Page has been updated successfully.');
    }

    public function update($post)
    {
        $page = Pages::find($post['page_id']);
        $page->page_name = $post['page_name'];
        $page->page_url = $post['page_url'];
        $page->page_content = $this->serialize($post['page_content']);
        $page->modified_by = $post['modified_by'];
        $page->updated_at = Carbon::now();
        $page->save();
    }

    public function destroy($id)
    {
        Pages::destroy($id);
    }
    
    private function getPageModules($moduleContent)
    {
        $pageContent = '';
        $moduleContent['page_content'] = $this->unserialize($moduleContent['page_content']);

        foreach($moduleContent['page_content'] as $module => $content)
        {
            $moduleArray = explode('_', $module);
            $moduleName = $moduleArray[0] . '_' . $moduleArray[1];
            $pageContent .= $this->getModules($moduleName.'.twig', ['content' => $content]);
        }
        
        return $pageContent;
    }
}