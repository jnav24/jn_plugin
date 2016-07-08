<?php
namespace App\WP;

use App\Models\Options;
use App\Managers\TwigManager;

class TwigWP extends TwigManager
{
    private $optionsModel;

    public function __construct($htmlPath, Options $optionsModel)
    {
        parent::__construct($htmlPath);
        $this->optionsModel = $optionsModel;
        $this->setOptions();
        $this->getWpEditor();
        $this->rmSlashes();
        $this->getCurrentUser();
        $this->sessionInstance();
        $this->getUserName();
    }

    private function setOptions()
    {
        $results = $this->optionsModel->geturl();

        $this->options['base_url'] = $results['option_value'];
        $this->options['admin_url'] = $results['option_value'] . '/wp-admin/';
        $this->options['plugin_url'] = $this->options['admin_url'] . 'admin.php?page=' . env()->getEnv('PREFIX', 'wp_');
        $this->options['plugin_path'] = $results['option_value'] . 'wp-content/plugins/' . env()->getEnv('PLUGIN_NAME', '') . '/';
        $this->options['theme_path'] = $results['option_value'] . 'wp-content/themes/' . env()->getEnv('THEME_NAME', '') . '/';
        $this->options['plugin_img_path'] = $this->options['plugin_path'] . 'images/';
        $this->options['theme_img_path'] = $this->options['theme_path'] . 'images/';
        $this->options['add_page_url'] = $this->options['plugin_url'] . env()->getEnv('SUBMENU_SLUG', 'jn-subplugin');
        $this->options['main_page_url'] = $this->options['plugin_url'] . env()->getEnv('MENU_SLUG', 'jn-plugin');
    }

    private function getWpEditor()
    {
        $this->createSimpleFunc('getMCEEditor', function($content = '', $editorId = '') {
            return wp_editor($content,$editorId);
        });

        return;
    }

    private function getCurrentUser()
    {
        $this->createSimpleFunc('getCurrentUser', function() {
            return wp_get_current_user()->ID;
        });
    }

    private function rmSlashes()
    {
        $this->createSimpleFilter('rwSlashes', function($string) {
            return stripslashes($string);
        });

        return;
    }
    
    private function sessionInstance()
    {
        $this->createSimpleFunc('session', function() {
            return new \App\Managers\SessionManager();
        });
    }
    
    private function getUserName()
    {
        $this->createSimpleFunc('getUserName', function($id) {
            return get_user_by('ID', $id)->user_login;
        });
    }
}