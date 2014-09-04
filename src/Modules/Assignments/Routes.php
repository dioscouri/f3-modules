<?php
namespace Modules\Assignments;

class Routes extends \Dsc\Singleton
{
    public static function passes( \Modules\Models\Modules $module, $route=null, $options=array() )
    {
        // if this ruleset is ignored, return null
        if (!in_array($module->{'assignment.routes.method'}, array('include', 'exclude') ) ) 
        {
            return null;
        }

        if (is_null($route) || $route == '*') {
            return true;
        }
        
        $match = false;
        
        // get the list of urls to match $route against
        // if any of them match, return true
        $patterns = (array) $module->{'assignment.routes.list'};
        if (empty($patterns)) {
            $match = true;
        }
        
        foreach ($patterns as $pattern) 
        {
            if (fnmatch($pattern, $route)) {
                $match = true;
            }
        }        
        
        switch ($module->{'assignment.routes.method'})
        {
            case "exclude":
                $passes = $match ? false : true;
                break;
            default:
                $passes = $match;
                break;
        }
        
        return $passes;
    }
}