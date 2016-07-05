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

    public function serialize($value)
    {
        return base64_encode(serialize($value));
    }

    public function unserialize($value)
    {
        return unserialize(base64_decode($value));
    }
}