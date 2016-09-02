<?php
namespace App\Controllers;

use App\Models\Pages;

class PageListController extends Controller
{
    public function index()
    {
        $pages = Pages::all()->toArray();
        return $this->getView('pages/page_list.twig', ['pages' => $pages]);
    }
}