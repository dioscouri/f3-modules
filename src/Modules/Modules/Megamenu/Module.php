<?php 
namespace Modules\Modules\Megamenu;

class Module extends \Modules\Abstracts\Module
{
    public $list = array(); // unprocessed list of menu items, typically straight from the data source
    public $items = array(); // final, processed list of menu items ready for display
    
    public function __construct($options=array()) 
    {
        if (!empty($options['list'])) {
            $this->list = $options['list'];
            unset($options['list']);
        }

        parent::__construct($options);
        
        $this->prepareMenu();
    }
    
    /**
     * Prepares the menu items for display,
     * loading the selected menu if necessary.
     * In short, we're creating an array of objects where an item's children are nested within it's ->children property 
     * 
     */
    public function prepareMenu()
    {
        if (empty($this->list) && !empty($this->module->{'megamenu.menu'})) {
            // Load the menu based on the module's parameters
            $this->list = (new \Admin\Models\Navigation)->emptyState()->setState('filter.root', false)->setState('filter.published', true)->setState('filter.tree', $this->module->{'megamenu.menu'})->setState('order_clause', array( 'tree'=> 1, 'lft' => 1 ))->getList();
        }
        
        if (empty($this->list)) {
            return array();
        }

        $items = $this->list;
        
        $children = array();
        foreach ($items as $key=>$item) 
        {
            if (!empty($item->parent)) {
                if (empty($children[(string)$item->parent])) {
                    $children[(string)$item->parent] = array();
                }
                $children[(string)$item->parent][] = $item;
            }
        }
        
        foreach ($items as $key=>$item) 
        {
            if (!empty($children[(string)$item->id])) {
                $item->set('children', $children[(string)$item->id]);
            } else {
                $item->set('children', array() );
            }
        }
        
        foreach ($items as $key=>$item) 
        {
            if ($item->getDepth() > 2) 
            {
                unset($items[$key]);
            }
        }
        
        $this->items = $items;
    }
    
    public function html()
    {
        $f3 = \Base::instance();
        
        $old_ui = $f3->get('UI');
        $temp_ui = !empty($this->options['views']) ? $this->options['views'] : dirname( __FILE__ ) . "/Views/";
        $f3->set('UI', $temp_ui);
        
        $f3->set('module', $this);
        
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/Views/', 'Modules/Megamenu/Views' );
        $string = \Dsc\System::instance()->get('theme')->renderLayout('Modules/Megamenu/Views::default.php');        
        
        $f3->set('UI', $old_ui);
        
        return $string;
    }
    
    public function itemHtml( $item ) 
    {
        $string = null;
        
        $string .= implode( '', $this->renderItemAndChildren( $item ) );

        return $string;
    }
    
    public function renderItemAndChildren( $item ) 
    {
        $strings = array();
        
        if ($item->display_type == "title") {
            $a_class = ' nav-title ';
        } else {
            $a_class = ' nav-title-normal ';
        }
        
        $a_class .= $item->class . ' ';
        
        // OPTION 1
        // is this item at depth == 1 AND (does this item have children or is it a module)?
        // if so, display the current item in an LI.dropdown.mega-menu-{columns-int} > A
        // wrap the title in:
        /*  <a href="url" data-target="#ID" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                Dropdown <b class="caret"></b>
            </a>
        */ 
        // and nest its children/content in a UL.dropdown-menu>li
        if ($item->children || (strpos($item->{'details.type'}, 'module-') !== false)) {
            
            $columns = ((int) $item->{'megamenu.columns'} > 0) ? (int) $item->{'megamenu.columns'} : 1;
            $url = strpos($item->{'details.type'}, 'module-') !== false ? 'javascript:void(0);' : $item->{'details.url'};
            $data_target = 'dm-' . $item->id;
            
            $strings[] = '<li class="dropdown mega-menu mega-menu-' . $columns . '">';
                $strings[] = '<a href="' . $url . '" data-target="#' . $data_target . '" class="dropdown-toggle disabled'. $a_class .'" data-toggle="dropdown" data-hover="dropdown">';
                // display title?
                if ($item->display_title == 0) {} else
                {                
                    $strings[] = $item->title . '<b class="caret"></b>';
                }
                
                if ($item->display_subtitle && $item->{'details.subtitle'})
                {
                    $strings[] = '<small class="nav-desc">';
                    $strings[] = $item->{'details.subtitle'};
                    $strings[] = '</small>';
                }
                
                $strings[] = '</a>';
                
                $strings[] = '<ul id="' . $data_target . '" class="dropdown-menu">';
                
                // if this item is a module, display its content in an LI
                // add a column width to the LI if necessary
                if (strpos($item->{'details.type'}, 'module-') !== false) {
                    switch ($columns)
                    {
                    	case "6":
                    	    $width_class = " six-column ";
                    	    break;
                    	case "5":
                    	    $width_class = " five-column ";
                    	    break;
                    	case "4":
                    	    $width_class = " four-column ";
                    	    break;
                    	case "3":
                    	    $width_class = " three-column ";
                    	    break;
                    	case "2":
                    	    $width_class = " two-column ";
                    	    break;
                    	default:
                    	    $width_class = " one-column ";
                    	    break;
                    }                    
                    $strings[] = '<li class="' . $width_class . '">';
                    $strings[] = $item->{'details.content'};
                    $strings[] = '</li>';
                    $strings[] = '<li class="dropdown-separator"></li>';
                }
                
                $column_total_width = 0;
                $number_of_children = count($item->children);
                foreach ($item->children as $key=>$child)
                {
                    // what is the width of this child item?  add the appropriate class to its LI
                    $child_width = (int) $child->{'megamenu.width'} > 0 ? (int) $child->{'megamenu.width'} : 1;
                    switch ($child_width) 
                    {
                    	case "6":
                    	    $width_class = " six-column ";
                    	    break;
                	    case "5":
                	        $width_class = " five-column ";
                	        break;
            	        case "4":
            	            $width_class = " four-column ";
            	            break;
        	            case "3":
        	                $width_class = " three-column ";
        	                break;
    	                case "2":
    	                    $width_class = " two-column ";
    	                    break;
    	                default:
    	                    $width_class = " one-column ";
	                        break;
                    }
                    
                    // if it has children, how are we supposed to display the children, grouped (a nested LI) or as a dropdown?
                    // if as a dropdown, add class=dropdown-submenu to this LI
                    if ($child->children && $child->{'megamenu.group_children'} == '0') {
                        $strings[] = '<li class="' . trim( $width_class . $child->class ) . ' dropdown-submenu">';
                    } else {
                        $strings[] = '<li class="' . trim( $width_class . $child->class ) . '">';
                    }
                    
                    // display the child's content and its children, if any
                    $strings = $this->renderChildItemAndDescendants( $strings, $child, 2 );                
                
                    $strings[] = '</li>';
                    
                    $column_total_width = $column_total_width + $child_width;
                    if ($column_total_width >= $columns && ($number_of_children > $key+1)) 
                    {
                        $strings[] = '<li class="dropdown-separator"></li>';
                        $column_total_width = 0;
                    }
                }
                
                $strings[] = '</ul>';
                
            $strings[] = '</li>';
            
        } 
            else 
        {
            // just a normal link at level 1 with no children
            $strings[] = '<li class="dropdown menu-item">';
                $strings[] = '<a class="'. $a_class .'" href="' . $item->{'details.url'} . '">';
                // display title?
                if ($item->display_title == 0) {} else
                {
                    $strings[] = $item->title;
                }
                
                if ($item->display_subtitle && $item->{'details.subtitle'})
                {
                    $strings[] = '<small class="nav-desc">';
                    $strings[] = $item->{'details.subtitle'};
                    $strings[] = '</small>';
                }
                
                $strings[] = '</a>';
            $strings[] = '</li>';
        }
        
        return $strings;
    }
    
    public function renderChildItemAndDescendants( array $strings, $item, $depth ) 
    {
        // display its content if it is a module or if it has no children
        // otherwise, if it has children, how are they supposed to be displayed, grouped or in a dropdown?
        
        if (!$item->children || (strpos($item->{'details.type'}, 'module-') !== false)) 
        {
            $a_class = $item->class;
            
            if ($item->display_type == "title") {
                $a_class .= ' nav-title ';
            } else {
                $a_class .= ' nav-title-normal ';
            }
            
            if (strpos($item->{'details.type'}, 'module-') !== false) 
            {
                // a module with no children
                // display title?
                if ($item->display_title == 0) {} else 
                {
                    $strings[] = '<span class="'.$a_class.'">';
                    $strings[] = $item->title;
                    $strings[] = '</span>';
                }
                
                if ($item->display_subtitle && $item->{'details.subtitle'}) 
                {
                    $strings[] = '<small class="nav-desc">';
                    $strings[] = $item->{'details.subtitle'};
                    $strings[] = '</small>';                	
                }
                
                $strings[] = '<div>';
                $strings[] = $item->{'details.content'};
                $strings[] = '</div>';
            } 
                else 
            {
                // just a normal link with no children
                $strings[] = '<a class="'.$a_class.'" href="' . $item->{'details.url'} . '">';
                $strings[] = $item->title;
                $strings[] = '</a>';
            }            
        }
            else
        {
            // it has children, how are they supposed to be displayed, grouped or in a dropdown?
            // if as dropdown:
            if ($item->{'megamenu.group_children'} == '0') {
                $url = strpos($item->{'details.type'}, 'module-') !== false ? 'javascript:void(0);' : $item->{'details.url'};
                $data_target = 'dm-' . $item->id;
                $a_class = $item->class;
                
                if ($item->display_type == "title") {
                    $a_class .= ' nav-title ';
                } else {
                    $a_class .= ' nav-title-normal ';
                }
                
                $strings[] = '<a class="'.$a_class.'" href="' . $url . '" data-target="#' . $data_target . '">';
                if ($item->display_title == 0) {} else
                {
                    $strings[] = $item->title;
                }
                
                if ($item->display_subtitle && $item->{'details.subtitle'})
                {
                    $strings[] = '<small class="nav-desc">';
                    $strings[] = $item->{'details.subtitle'};
                    $strings[] = '</small>';
                }                
                $strings[] = '</a>';
                $strings[] = '<ul id="' . $data_target . '" class="dropdown-menu">';
            } 
                else 
            {
            
                $a_class = $item->class;
                
                // else if as a grouped list
                if ($item->display_type == "title") {
                    $a_class .= ' nav-title ';
                } else {
                    $a_class .= ' nav-title-normal ';
                }
                                
                $strings[] = '<a class="'.$a_class.'" href="' . $item->{'details.url'} . '">';
                if ($item->display_title == 0) {} else
                {
                    $strings[] = $item->title;
                }
                
                if ($item->display_subtitle && $item->{'details.subtitle'})
                {
                    $strings[] = '<small class="nav-desc">';
                    $strings[] = $item->{'details.subtitle'};
                    $strings[] = '</small>';
                }
                $strings[] = '</a>';
                $strings[] = '<ul>';
                //$strings[] = '<li class="divider"></li>';
            }
            
            foreach ($item->children as $child) 
            {
                // if it has children, how are we supposed to display the children, grouped (a nested LI) or as a dropdown?
                // if as a dropdown, add class=dropdown-submenu to this LI
                if ($child->children && $child->{'megamenu.group_children'} == '0') {
                    $strings[] = '<li class="dropdown-submenu">';
                } else {
                    $strings[] = '<li>';
                }
                                
                // display the child's content and its children, if any
                $strings = $this->renderChildItemAndDescendants( $strings, $child, $depth++ );                
            
                $strings[] = '</li>';
            }
            
            $strings[] = '</ul>';
        }    
                
        return $strings;
    }
    
}