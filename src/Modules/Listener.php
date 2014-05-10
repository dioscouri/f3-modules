<?php 
namespace Modules;

class Listener extends \Prefab 
{
    public function onSystemRebuildMenu( $event )
    {
    	if ($model = $event->getArgument('model'))
    	{
    		$root = $event->getArgument( 'root' );
    		$modules = clone $model;
    	
    		$modules->insert(
    				array(
    						'type'	=> 'admin.nav',
    						'priority' => 80,
    						'title'	=> 'Modules',
    						'icon'	=> 'fa fa-building',
        					'is_root' => false,
    						'tree'	=> $root,
							'base' => '/admin/modules',
    				)
    		);
    		
            $children = array(
                    array( 'title'=>'List', 'route'=>'/admin/modules', 'icon'=>'fa fa-list' ),
                    array( 'title'=>'Add New', 'route'=>'/admin/module/create', 'icon'=>'fa fa-plus' ),
            );
           	$modules->addChildrenItems( $children, $root );
            
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