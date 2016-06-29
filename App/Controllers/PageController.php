<?php
namespace App\Controllers;

class PageController extends Controller
{
    public function index()
    {
        $page = [];
        return $this->getView('page.twig', $page);
    }

    public function create()
    {
        return $this->getView('create-page.twig');
    }
    
    public function edit()
    {}

    public function store($post)
    {}

    public function update($post)
    {}

    public function destroy()
    {}
}