<?php 
namespace Modules\Modules\Megamenu\Listeners;

class Admin extends \Prefab 
{
    public function onDisplayAdminModuleEdit( $event ) 
    {
        $module = $event->getArgument('module');
        if ($module != "core.megamenu::\Modules\Modules\Megamenu\Module") {
            return;
        }

        $item = $event->getArgument('item');
        $tabs = $event->getArgument('tabs');
        $content = $event->getArgument('content');
        
        $tabs[] = 'Megamenu Options';
        $content[] = 'Additional fields from the Megamenu Module Listener';
        
        $event->setArgument('tabs', $tabs);
        $event->setArgument('content', $content);
    }
}