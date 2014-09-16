<?php
namespace Modules\Assignments;

class LoginStatus extends \Dsc\Singleton
{

    public static function passes(\Modules\Models\Modules $module, $route = null, $options = array())
    {
        // if this ruleset is ignored, return null
        if (!in_array($module->{'assignment.login_status.method'}, array('include', 'exclude') ) )
        {
            return null;
        }
        
        $user = \Dsc\System::instance()->get('auth')->getIdentity();
        $is_logged_in = (empty($user->id)) ? false : true;
        
        $match = false;
        switch ($module->{'assignment.login_status.value'}) 
        {
            case "1":
                if ($is_logged_in) {
                    $match = true;
                }
                break;
            case "0":
            default:
                if (!$is_logged_in) {
                    $match = true;
                }                
                break;
        }  
        
        switch ($module->{'assignment.login_status.method'})
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