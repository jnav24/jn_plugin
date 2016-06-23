<?php
namespace App\Controllers;

use App\Containers\TwigContainer;
use App\Models\Options;

abstract class Controller
{
    protected $path;
    protected $twig;

    public function __construct()
    {
        $this->path = __DIR__ . '/../resources/views';
        $this->twig = new TwigContainer($this->path, new Options());
    }

    protected function getView($file, array $options = [])
    {
        if(!file_exists($this->path . '/' . $file))
        {
            return $this->twig->render('404.twig', ['file' => $file]);
        }

        return $this->twig->render($file, $options);
    }
}