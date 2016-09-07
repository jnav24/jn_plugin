<?php
namespace App\Controllers;

use App\Models\Users;

class UsersController extends Controller
{
    public function retrieve($post)
    {
        $default = 'No user found.';
        if(!isset($post['id']))
        {
            return $default;
        }
        $user = Users::getUserName($post['id'])->toArray();
        if(empty($user))
        {
            return $default;
        }
        return $user[0]['user_login'];
    }
}