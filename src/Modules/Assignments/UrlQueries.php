<?php
namespace Modules\Assignments;

class UrlQueries extends \Dsc\Singleton
{
    public static function passes( \Modules\Models\Modules $module, $route=null, $options=array() )
    {
        // if this ruleset is ignored, return null
        if (!in_array($module->{'assignment.url_queries.method'}, array('include', 'exclude') ) ) 
        {
            return null;
        }

        $url = \Base::instance()->get('PARAMS.0');
        $match = false;
        $patterns = (array) $module->{'assignment.url_queries.list'};
        
        foreach ($patterns as $pattern)
        {
            if (strpos($url, $pattern) !== false) {
                $match = true;
            }
        }
    
        
        switch ($module->{'assignment.url_queries.method'})
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