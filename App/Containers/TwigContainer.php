<?php
namespace App\Containers;

use App\Models\Options;
use App\Providers\EnvProvider as Env;
use App\Providers\TwigProvider;

class TwigContainer extends TwigProvider
{
    private $optionsModel;
    
    public function __construct($htmlPath, Options $optionsModel)
    {
        parent::__construct($htmlPath);
        $this->optionsModel = $optionsModel;
        $this->setOptions();
        $this->getWpEditor();
        $this->rmSlashes();
    }

    private function setOptions()
    {
        $results = $this->optionsModel->geturl();
        
        $this->options['base_url'] = $results['option_value'];
        $this->options['admin_url'] = $results['option_value'] . '/wp-admin/';
        $this->options['plugin_url'] = $this->options['admin_url'] . 'admin.php?page=' . Env::getEnv('PREFIX', 'wp_');
        $this->options['plugin_path'] = $results['option_value'] . 'wp-content/plugins/' . Env::getEnv('PLUGIN_NAME', '') . '/';
        $this->options['theme_path'] = $results['option_value'] . 'wp-content/themes/' . Env::getEnv('THEME_NAME', '') . '/';
        $this->options['plugin_img_path'] = $this->options['plugin_path'] . 'images/';
        $this->options['theme_img_path'] = $this->options['theme_path'] . 'images/';
    }

    private function getWpEditor()
    {
        $this->createSimpleFunc('getMCEEditor', function($content = '', $editorId = '') {
            return wp_editor($content,$editorId);
        });

        return;
    }

    private function rmSlashes()
    {
        $this->createSimpleFilter('rwSlashes', function($string) {
            return stripslashes($string);
        });

        return;
    }
}