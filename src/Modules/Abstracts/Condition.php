<?php 
namespace Modules\Abstracts;

abstract class Condition 
{
    use \Dsc\Traits\Container;
    
    public $model = null; // a \Modules\Models\Conditions object
    
    public function __construct(array $config=array()) 
    {
        foreach ($config as $key=>$value) {
            $this->$key = $value;
        }
        
        if (empty($this->model) || !is_a($this->model, '\Modules\Models\Conditions')) {
            $this->model = new \Modules\Models\Conditions;
        }
    }
    
    /**
     * Returns the condition's html 
     * for the admin-side module-editing form
     */
    abstract public function html();
    
    /**
     * Determines whether or not this condition passes
     * 
     * @param string $route
     * @param unknown $options
     */
    abstract public function passes(\Modules\Models\Modules $module, $route=null, $options=array());
    
    /**
     * Bootstrap this Condition, including:
     * 1. Register any custom routes that it needs
     * 2. Add Custom view paths
     *
     * @return \Modules\Abstracts\Condition
     */
    public function bootstrap()
    {
        return $this;
    }
}