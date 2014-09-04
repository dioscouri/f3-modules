<?php 
namespace Modules\Models;

class Conditions extends \Dsc\Mongo\Collections\Describable 
{
	public $namespace = null;          // required, unique. Fully Qualified
	public $slug = null;           // required, unique.
	
    public $title = null;           // human-readable      
    public $type = null;           // e.g. 'products', 'orders', 'customers', 'misc'
    public $icon = null;           // a font-awesome class name

    protected $__collection_name = 'module.conditions';
    protected $__type = 'misc';
    
    protected $__config = array(
        'default_sort' => array(
        	'type' => 1,
            'title' => 1,
        ) 
    );
    
    protected function fetchConditions()
    {
        parent::fetchConditions();
        
        $filter_namespace = $this->getState('filter.namespace');
        if (strlen($filter_namespace))
        {
            $this->setCondition('namespace', $filter_namespace);
        }
    	
        return $this;
    }
    
    public static function register( $namespace, array $options=array() )
    {
        $item = (new static)->setState('filter.namespace', $namespace)->getItem();
        if (empty($item->id) || !empty($options['__update']))
        {
            try {
                if (empty($item->id)) {
                    $item = new static;
                }
    
                $item->bind(array(
                    'namespace' => $namespace,
                ))->bind($options)->save();
    
                return $item;
            }
            catch (\Exception $e) {
    
                return false;
            }    
        }
    
        return true;
    }
    
    public static function bootstrap()
    {
        if ($items = (new static)->getItems())
        {
            foreach ($items as $item)
            {
                $item->getClass()->bootstrap();
            }
        }
    
        return true;
    }
    
    protected function beforeValidate()
    {
        if (empty($this->slug))
        {
            $this->slug = \Web::instance()->slug( $this->namespace );
        }
    
        return parent::beforeValidate();
    }
    
    /**
     * Gets an instance of the item's class
     *
     * @throws \Exception
     * @return unknown
     */
    public function getClass()
    {
        $class_name = $this->namespace . '\Condition';
        if (!class_exists($class_name)) {
            throw new \Exception('Class "'. $class_name .'" not found');
        }
    
        // get an instance of the class
        $class = new $class_name(array(
            'model' => $this
        ));
    
        if (!is_a($class, '\Modules\Abstracts\Condition'))
        {
            throw new \Exception('Class must be an instance of \Modules\Abstracts\Condition');
        }
    
        return $class;
    }
}