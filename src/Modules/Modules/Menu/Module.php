<?php 
namespace Modules\Modules\Menu;

class Module extends \Modules\Abstracts\Module
{
    public $list = array(); // unprocessed list of menu items, typically straight from the data source
    public $items = array(); // final, processed list of menu items ready for display
    public $layout = 'default.php';
    
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
            // Load the menu based on the module's parameters
            $this->list = (new \Admin\Models\Navigation)->emptyState()->setState('filter.root', false)->setState('filter.published', true)->setState('filter.tree', $this->mapper->{'details.selected-menu'})->setState('order_clause', array( 'tree'=> 1, 'lft' => 1 ))->getList();
        }
        
        if (empty($this->list)) {
            return array();
        }

        $items = $this->list;
        
        $this->items = $items;
    }
    
    public function html()
    {
        $f3 = \Base::instance();
        
        $old_ui = $f3->get('UI');
        $temp_ui = !empty($this->options['views']) ? $this->options['views'] : dirname( __FILE__ ) . "/Views/";
        $f3->set('UI', $temp_ui);
        
        $f3->set('module', $this);

        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/Views/', 'Modules/Menu/Views' );
        $string = \Dsc\System::instance()->get('theme')->renderLayout('Modules/Menu/Views::' . $this->layout);        
        
        $f3->set('UI', $old_ui);
        
        return $string;
    }
    
     
}