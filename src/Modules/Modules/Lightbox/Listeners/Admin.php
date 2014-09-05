<?php
namespace Modules\Modules\Lightbox\Listeners;

class Admin extends \Prefab
{
    public function onDisplayAdminModuleEdit( $event )
    {
        $module = $event->getArgument( 'module' );
        
        if ($module != "core.lightbox::\Modules\Modules\Lightbox\Module")
        {
            return;
        }
        
        $item = $event->getArgument( 'item' );
        
        $tabs = $event->getArgument( 'tabs' );
        $content = $event->getArgument( 'content' );
        
        $tabs[] = 'Lightbox Options';
        
        $theme = \Dsc\System::instance()->get('theme');
        $theme->registerViewPath( __dir__ . '/../Admin/', 'Modules/Lightbox/Admin/Views' );
        $content[] = $theme->renderView('Modules/Lightbox/Admin/Views::options.php');
        
        $event->setArgument( 'tabs', $tabs );
        $event->setArgument( 'content', $content );
    }
}