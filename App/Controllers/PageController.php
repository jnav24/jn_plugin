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
        $page = Pages::find($id)->toArray();
        $moduleContent = $this->getPageModules($page);
        unset($page['page_content']);
        return $this->getView('modules/base.twig', ['modules' => $moduleContent, 'page' => $page]);
    }

    public function store($post)
    {
        $page = new Pages();
        $page->page_name = $post['page_name'];
        $page->page_url = $this->urlFormat($post['page_name']);
        $page->page_content = $this->serialize($post['modules']);
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
        $page->page_url = $this->urlFormat($post['page_name']);
        $page->page_content = $this->serialize($post['page_content']);
        $page->modified_by = $post['modified_by'];
        $page->updated_at = Carbon::now();

        $page->save();
    }

    public function destroy($post)
    {
        Pages::destroy($post['id']);
    }
    
    private function getPageModules($moduleContent)
    {
        $pageContent = '';
        $moduleContent['page_content'] = $this->unserialize($moduleContent['page_content']);

        if(!is_array($moduleContent['page_content']))
        {
            return $pageContent;
        }

        /**
         * TODO::
         * This array $moduleContent['page_content'] is currently
         * array(
         *  0 => 'module_banner',
         *  1 => 'module_text',
         * );
         *
         * it is supposed to be
         * array(
         *  'module_banner' => '',
         *  'module_text' => '',
         * );
         */

        foreach($moduleContent['page_content'] as $module => $content)
        {
            $moduleArray = explode('_', $module);
            $moduleName = $moduleArray[0] . '_' . $moduleArray[1];
            $pageContent .= $this->getModule($moduleName.'.twig', ['content' => $content]);
        }
        
        return $pageContent;
    }
}