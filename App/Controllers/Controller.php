<?php
namespace App\Controllers;

use App\WP\TwigWP;
use App\Models\Options;

abstract class Controller
{
    protected $path;
    protected $twig;

    public function __construct()
    {
        $this->path = __DIR__ . '/../resources/views';
        $this->twig = new TwigWP($this->path, new Options());
    }

    protected function getView($file, array $options = [])
    {
        if(!file_exists($this->path . '/' . $file))
        {
            return $this->twig->render('errors/404.twig', ['file' => $file]);
        }

        return $this->twig->render($file, $options);
    }

    protected function getModule($file, array $options = [])
    {
        if(!file_exists($this->path . '/modules/' . $file))
        {
            return $this->twig->render('errors/module-404.twig', ['file' => $file]);
        }

        return $this->twig->render('modules/' . $file, $options);
    }

    protected function serialize($value)
    {
        return base64_encode(serialize($value));
    }

    protected function unserialize($value)
    {
        return unserialize(base64_decode($value));
    }
    
    protected function urlFormat($string)
    {
        $string = html_entity_decode(strip_tags($string));
        $string = preg_replace('/\s+/', ' ', trim($string));
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^A-Za-z0-9_-]/', '', $string);
        $string = strtolower($string);

        return $string;
    }

    protected function makeModuleSafe($string)
    {
        return str_replace('-', '_', $this->urlFormat($string));
    }
}