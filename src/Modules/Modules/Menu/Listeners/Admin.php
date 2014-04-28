<?php
namespace Modules\Modules\Menu\Listeners;

class Admin extends \Prefab
{

    public function onDisplayAdminModuleEdit( $event )
    {
        $module = $event->getArgument( 'module' );
        
        if ($module != "core.menu::\Modules\Modules\Menu\Module")
        {
            return;
        }
        
        $item = $event->getArgument( 'item' );
        
        $tabs = $event->getArgument( 'tabs' );
        $content = $event->getArgument( 'content' );
        
        $tabs[] = 'Menu Options';
        $content[] = $this->getSelect( $item );
        
        $event->setArgument( 'tabs', $tabs );
        $event->setArgument( 'content', $content );
    }

    protected function getSelect( $item )
    {
        $model = new \Admin\Models\Navigation;
        
        $roots = $model->getRoots();
        
        if (! empty( $roots ))
        {
            
            $html = '<select name="details[selected-menu]" id="selected-menu" class="form-control">';
            $html .= '<option>-Please select a menu-</option>';
            
            foreach ( $roots as $one )
            {
                $html .= '<option value="' . $one->id . '"';
                
                if ($one->_id == @$item->details['selected-menu'])
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