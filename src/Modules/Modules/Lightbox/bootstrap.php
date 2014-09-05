<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Modules\Modules\Lightbox\Listeners\Admin::instance());
        
        break;
    case "site":
        
        if (class_exists('\Minify\Factory'))
        {
            \Minify\Factory::registerPath(__dir__ . '/');
        
            $files = array(
                'LightboxAssets/js/bootbox-4.3.0.min.js',
                'LightboxAssets/js/jquery.cookie-1.4.1.js',
            );
        
            foreach ($files as $file)
            {
                \Minify\Factory::js($file);
            }
        }
        else 
        {
            // symlink to the public folder if necessary
            if (!is_dir($f3->get('PATH_ROOT') . 'public/LightboxAssets'))
            {
                $public_theme = $f3->get('PATH_ROOT') . 'public/LightboxAssets';
                $theme_assets = realpath(__dir__ . '/LightboxAssets');
                $res = symlink($theme_assets, $public_theme);
            }            
        }
        
        break;
}
?>