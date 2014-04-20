<?php
namespace Modules\Assignments;

class Routes extends \Dsc\Singleton
{
    public static function passes( $module, $route=null, $options=array() )
    {
        // if this ruleset is ignored, return null
        if (!in_array($module->{'assignment.routes.method'}, array('include', 'exclude') ) ) 
        {
            return null;
        }

        if (is_null($route) || $route == '*') {
            return true;
        }
        
        // get the list of urls to match $route against
        // if any of them match, return true
        $patterns = (array) $module->{'assignment.routes.list'};
        if (empty($patterns)) {
            return true;
        }
        
        foreach ($patterns as $pattern) 
        {
            if (fnmatch($pattern, $route)) {
                return true;
            }
        }        
        
        return false;
    }
}