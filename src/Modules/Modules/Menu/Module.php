<?php 
namespace Modules\Modules\Menu;

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
        if (empty($this->list)) {
            // TODO Load the menu based on the module's parameters
             $model = new \Admin\Models\Menus;
             $this->list = $model->setState('filter.tree', $this->mapper->details['selected-menu'])->getList();


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
        
        $string = \Dsc\Template::instance()->renderLayout('Modules/Menu/Views::default.php');
        
        $f3->set('UI', $old_ui);
        
        return $string;
    }
    
     
}