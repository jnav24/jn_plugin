<?php

namespace App\Managers;

class PostManager
{
    public function getPostData()
    {
        $post = $_POST;

        if(empty($post))
        {
            $post = $this->getJsonPostData();
        }


        if(isset($post['page_action']))
        {
            $this->callMethod($post);
        }
    }

    private function getJsonPostData()
    {
        $json = file_get_contents('php://input');

        if(!empty($json) && $_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $json = (array)json_decode($json);
        }

        return $json;
    }

    private function callMethod($post)
    {
        $page_action = explode('-', $post['page_action']);
        if(count($page_action) != '2')
        {
            return false;
        }

        list($class, $method) = $page_action;
        $object = $this->validateObject($class, $method);
        
        if(is_object($object))
        {
            $results = $object->$method($post);

            if($class == 'page')
            {
                $this->callPostsMethod(['posts',$method], $results);
            }
        }
    }
    
    private function callPostsMethod($post, $obj)
    {
        list($class, $method) = $post;
        
        $object = $this->validateObject($class, $method);
        
        if(is_object($object))
        {
            $object->$method($obj);
        }
    }
    
    private function validateObject($class, $method)
    {
        $namespace = "App\\Controllers\\" . ucfirst($class) . "Controller";

        if(class_exists($namespace))
        {
            $object = new $namespace();

            if(method_exists($object, $method))
            {
                return $object;
            }
        }
        return false;
    }
}