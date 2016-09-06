<?php

namespace App\Controllers;

use App\Models\Posts;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function store($input)
    {
        $posts = new Posts();
        $posts->post_title = $input->page_name;
        $posts->post_name = $input->page_url;
        $posts->post_author = $input->created_by;
        $posts->post_status = $input->page_status;
        $posts->post_content = "[jn_plugin id='" . $input->page_id . "']";
        $posts->post_date = Carbon::now();
        $posts->post_date_gmt = Carbon::now();
        $posts->post_modified = Carbon::now();
        $posts->post_modified_gmt = Carbon::now();
        $posts->post_type = 'page';
        $posts->save();
    }
    
    public function update($input)
    {
        $posts = Posts::where('post_content', '[jn_plugin id="' . $input->page_id . '"]')->first();
        $posts->post_title = $input->page_name;
        $posts->post_name = $input->page_url;
        $posts->post_status = $input->page_status;
        $posts->post_modified = Carbon::now();
        $posts->post_modified_gmt = Carbon::now();
        $posts->save();
    }

    public function destroy($input)
    {
        $posts = Posts::where('post_content', "[jn_plugin id='" . $input->page_id . "']")->first();
        Posts::destroy($posts->ID);
    }
}