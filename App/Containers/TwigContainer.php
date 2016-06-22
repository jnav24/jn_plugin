<?php
namespace App\Containers;

use App\Models\Options;
use App\Providers\TwigProvider;

class TwigContainer extends TwigProvider
{
    private $optionsModel;
    
    public function __construct($htmlPath, Options $optionsModel)
    {
        parent::__construct($htmlPath);
        $this->setOptions();
        $this->getWpEditor();
        $this->rmSlashes();
        $this->optionsModel = $optionsModel;
    }

    private function setOptions()
    {
        $results = [];

        // Get the options_value from options table
        // $results = OptionsModel::where('option_name', 'siteurl')->get('options_value');
        
        $this->options['base_url'] = $results['option_value'];
        $this->options['admin_url'] = $results['option_value'] . '/wp-admin/';
        $this->options['plugin_url'] = $this->options['admin_url'] . 'admin.php?page=' . $this->prefix;
        $this->options['plugin_path'] = $results['option_value'] . 'wp-content/plugins/' . $this->prefix . 'plugin-new/';
        $this->options['theme_path'] = $results['option_value'] . 'wp-content/themes/' . $this->prefix . 'theme/';
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