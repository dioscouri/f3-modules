<?php 
namespace Modules;

class Listener extends \Prefab 
{
    public function onSystemRebuildMenu( $event )
    {
        if ($mapper = $event->getArgument('mapper')) 
        {
            $mapper->reset();
            $mapper->id = 'f3-modules';
            $mapper->title = 'Modules';
            $mapper->route = '';
            $mapper->icon = 'fa fa-building';
            $mapper->children = array(
                    json_decode(json_encode(array( 'title'=>'List', 'route'=>'/admin/modules', 'icon'=>'fa fa-list' )))
                    ,json_decode(json_encode(array( 'title'=>'Add New', 'route'=>'/admin/module/create', 'icon'=>'fa fa-plus' )))
            );
            $mapper->save();
            
            \Dsc\System::instance()->addMessage('Modules added its admin menu items.');
        }
    }
    
    public function onAdminNavigationGetQuickAddItems( $event )
    {
        $items = $event->getArgument('items');
        $tree = $event->getArgument('tree');
        
        $item = new \stdClass;
        $item->title = 'HTML Module';
        $item->form = \Modules\Admin\Controllers\MenuItemQuickAdd::instance()->html($event);
        
        $items[] = $item;

        $event->setArgument('items', $items);
    }
    
    public function onDisplayAdminMenusEdit( $event ) 
    {
        $item = $event->getArgument('item');
        $tabs = $event->getArgument('tabs');
        $content = $event->getArgument('content');
        
        if (strpos($item->{'details.type'}, 'module-html') !== false) 
        {
            $tabs[] = 'HTML Module';
            $content[] = \Modules\Admin\Controllers\MenuItem::instance()->html($event);
        }
        
        $event->setArgument('tabs', $tabs);
        $event->setArgument('content', $content);
    }
    
    public function onPreflight( $event ) 
    {
        // bootstrap all modules
        \Modules\Factory::instance()->bootstrap();
    }
}