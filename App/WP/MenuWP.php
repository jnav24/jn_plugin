<?php
namespace App\WP;

class MenuWp
{
    public function removeMenuItems(array $items)
    {
        if(wp_get_current_user()->user_login == env()->getEnv('ADMIN_USER'))
        {
            return;
        }
        
        $menuItems = array(
            'Dashboard' => 'index.php',
            'First separator' => 'separator1', 
            'Posts' => 'edit.php',
            'Media' => 'upload.php',
            'Links' => 'link-manager.php',
            'Pages' => 'edit.php?post_type=page',
            'Comments' => 'edit-comments.php', 
            'Second separator' => 'separator2',
            'Appearance' => 'themes.php',
            'Plugins' => 'plugins.php',
            'Users' => 'users.php',
            'Tools' => 'tools.php',
            'Settings' => 'options-general.php',
            'Last separator' => 'separator-last', 
        );

        foreach($items as $item)
        {
            if(isset($menuItems[$item]))
            {
                remove_menu_page($menuItems[$item]);
            }
        }
    }
}