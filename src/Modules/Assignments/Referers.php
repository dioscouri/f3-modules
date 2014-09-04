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

        $referer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $parser = (new \Snowplow\RefererParser\Parser)->parse($referer);        
        
        $match = false;
        
        $list = (array) $module->{'assignment.referers.list'};
        foreach ($list as $shortcut_referer) 
        {
            switch ($shortcut_referer) 
            {
                case "email":
                    if ($parser->isKnown()) 
                    {
                        if ($parser->getMedium() == 'email') 
                        {
                            $match = true;
                        }
                    }                    
                    break;
                case "search":
                    if ($parser->isKnown())
                    {
                        if ($parser->getMedium() == 'search')
                        {
                            $match = true;
                        }
                    }                    
                    break;
                case "social":
                    if ($parser->isKnown())
                    {
                        if ($parser->getMedium() == 'social')
                        {
                            $match = true;
                        }
                    }                    
                    break;
                case "google":
                    if ($parser->isKnown())
                    {
                        if (strtolower($parser->getSource()) == 'google')
                        {
                            $match = true;
                        }
                    }                    
                    break;                    
                case "facebook":
                    if ($parser->isKnown())
                    {
                        if (strtolower($parser->getSource()) == 'facebook')
                        {
                            $match = true;
                        }
                    }                    
                    break;
            }
        }
        
        if (empty($match)) 
        {
            $patterns = array();
            if (in_array('other', $list))
            {
                $patterns = (array) $module->{'assignment.referers.others'};
            }
                        
            foreach ($patterns as $pattern)
            {
                if (strpos($referer, $pattern) !== false) {
                    $match = true;
                }
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