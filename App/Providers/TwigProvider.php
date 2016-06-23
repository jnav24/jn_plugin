<?php

namespace App\Providers;

use \Twig_Environment;
use \Twig_Loader_Filesystem;
use \Twig_SimpleFunction;
use \Twig_SimpleFilter;
use App\Exceptions\TwigException;

class TwigProvider
{
    /**
     * @var string
     */
    private $htmlPath;

    /**
     * @var array
     */
    public $options;

    public function __construct($htmlPath)
    {
        $this->setHtmlPath($htmlPath);
        $this->initTwig();
    }

    private function setHtmlPath($htmlPath)
    {
        if(!file_exists($htmlPath))
        {
            throw new TwigException('Path does not exist');
        }

        $this->htmlPath = $htmlPath;
    }

    public function render($file, $options)
    {
        return $this->twig->render($file, array_merge($this->options, $options));
    }

    protected function createSimpleFunc($name, /*callable*/ $function)
    {
        if(!is_callable($function))
        {
            throw new TwigException('Second param must be a function');
        }

        return $this->twig->addFunction(new Twig_SimpleFunction($name, $function));
    }

    protected function createSimpleFilter($name, /*callable*/ $function)
    {
        if(!is_callable($function))
        {
            throw new TwigException('Second param must be a function');
        }

        return $this->twig->addFilter(new Twig_SimpleFilter($name, $function));
    }

    private function initTwig()
    {
        // Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem($this->htmlPath);
        $this->twig = new Twig_Environment($loader, array());
    }
}