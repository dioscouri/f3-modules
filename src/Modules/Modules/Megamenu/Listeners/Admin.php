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
        $content[] = $this->getSelect( $item );
        
        $event->setArgument('tabs', $tabs);
        $event->setArgument('content', $content);
    }
    
    public function onDisplayAdminMenusEdit( $event )
    {
        $item = $event->getArgument('item');
        $tabs = $event->getArgument('tabs');
        $content = $event->getArgument('content');
    
        $tabs[] = 'Megamenu';
        
        $f3 = \Base::instance();
        $f3->set('item', $event->getArgument('item'));
        
        $temp_ui = dirname( __FILE__ ) . "/./Admin/Views/";        
        
        $content[] = \Dsc\System::instance()->get('theme')
        ->registerViewPath( $temp_ui, 'Modules/Modules/Megamenu/Admin/Views' )
        ->renderView('Modules/Modules/Megamenu/Admin/Views::menuitem.php');
    
        $event->setArgument('tabs', $tabs);
        $event->setArgument('content', $content);
    }
    
    protected function getSelect( $item )
    {
        $model = new \Admin\Models\Navigation;
    
        $roots = $model->getRoots();
    
        if (! empty( $roots ))
        {
    
            $html = '<select name="megamenu[menu]" id="megamenu-menu" class="form-control">';
            $html .= '<option>-Please select a menu-</option>';
    
            foreach ( $roots as $one )
            {
                $html .= '<option value="' . $one->id . '"';
    
                if (!empty($item->{'megamenu.menu'}) && $one->id == $item->{'megamenu.menu'})
                {
                    $html .= "selected='selected'";
                }
                $html .= '>';
                $html .= $one->title;
                $html .= '</option>';
            }
    
            $html .= '</select>';
        }
    
        return $html;
    }
}