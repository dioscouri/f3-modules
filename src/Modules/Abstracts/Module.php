<?php 
namespace Modules\Abstracts;

abstract class Module  
{
    public $mapper = null; // a \Modules\Mappers\Module
    public $options = array();
    
    public function __construct(array $options) 
    {
        if (!empty($options['mapper'])) {
            $this->mapper = $options['mapper'];
            unset($options['mapper']);
        } else {
            $this->mapper = \Modules\Admin\Models\Modules::instance()->getMapper();
        }
        
        $this->options = array() + $options;
    }
    
    /**
     * Returns the module's html based on the options and mapper's configuration
     */
    abstract public function html();
}