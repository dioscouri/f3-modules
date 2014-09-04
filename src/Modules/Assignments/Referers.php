<?php
namespace Modules\Assignments;

class Referers extends \Dsc\Singleton
{
    public static function passes( \Modules\Models\Modules $module, $route=null, $options=array() )
    {
        // if this ruleset is ignored, return null
        if (!in_array($module->{'assignment.referers.method'}, array('include', 'exclude') ) ) 
        {
            return null;
        }
        
        return null;

        $match = false;
        $patterns = array();
        
        $list = (array) $module->{'assignment.referers.list'};
        if (in_array('other', $list)) 
        {
            $patterns = (array) $module->{'assignment.referers.others'};
        }
        
        foreach ($list as $shortcut_referer) 
        {
            switch ($shortcut_referer) 
            {
                case "email":
                    break;
                case "search":
                    break;
                case "google":
                    break;
                case "social":
                    break;
                case "facebook":
                    break;
            }
        }
        
        if (empty($patterns)) {
            $match = true;
        }
        
        foreach ($patterns as $pattern) 
        {
            if (strpos($referer, $pattern) !== false) {
                $match = true;
            }
        }        
        
        switch ($module->{'assignment.referers.method'})
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