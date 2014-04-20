<?php 
namespace Modules\Abstracts;

abstract class Module  
{
    public $model = null; // a \Modules\Models\Modules object
    public $options = array();
    
    public function __construct(array $options) 
    {
        if (!empty($options['model'])) {
            $this->model = $options['model'];
            unset($options['model']);
        } else {
            $this->model = new \Modules\Models\Modules;
        }
        
        $this->options = array() + $options;
    }
    
    /**
     * Returns the module's html based on the options and mapper's configuration
     */
    abstract public function html();
}