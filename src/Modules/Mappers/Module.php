<?php
namespace Modules\Mappers;

class Module extends \Dsc\Mongo\Mapper 
{
    public function passesAssignments( $route=null, $options=array() ) 
    {
        $result = false;
        $passes = array();
        
        // is it a pass ALL or pass ANY?
        $method = 'all';
        if ($this->{'assignment.method'} == 'any') {
            $method = 'any';
        }
        
        // TODO Get all the assignment classes from the Assignments folder?  Or allow them to be registered somehow?
        $types = array(
        	'Routes'
        );
        
        foreach ($types as $type) 
        {
            $classname = "\\Modules\\Assignments\\" . $type;
            $passes[$type] = $classname::instance()->passes( $this, $route, $options );
            if ($method == 'any' && $passes[$type]) 
            {
                return true;
            } 
        }
        
        if (!in_array(false, $passes, true)) {
            $result = true;
        }
        
        return $result;
    }
    
    public function render()
    {
        // get an instance of this module's class from the ->type property
        $parts = explode( '::', $this->{'metadata.type'} );
        if (empty($parts[1]) || !class_exists($parts[1])) {
            return null;
        }
        
        // TODO Give the ability for developers to create their own Chromes
        
        // pass this mapper as part of the $options array in the constructor
        // return the module's html()        
        if (!$module_html = (new $parts[1](array('mapper'=>$this)))->html()) {
            return null;
        }

        $module_type = (string) preg_replace('/[^A-Z0-9_.-]/i', '', $parts[0]);
        $module_type = ltrim($module_type, '.');
        $module_type = str_replace(array('_', '.'), array('-', '-'), $module_type);
        
        $classes = trim('module-wrap clearfix '. $module_type . ' ' . $this->{'display.classes'});
        
        $strings = array();        
        $strings[] = '<div class="' . $classes . '" id="module-' . $this->id . '">'; 
        if ($this->{'display.title'} == 1 || is_null($this->{'display.title'}) ) 
        {
            $tag = $this->{'display.title_tag'} ? $this->{'display.title_tag'} : 'h4';
            $strings[] = '<' . $tag . '>';
            $strings[] = $this->{'metadata.title'};
            $strings[] = '</' . $tag . '>';
        }        
        
        $strings[] = '<div class="module-content clearfix">';
        $strings[] = $module_html;
        $strings[] = '</div>';
        
        $strings[] = '</div>';
        
        return implode( '', $strings );
    }
}
?>