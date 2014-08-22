<?php
namespace Modules\Assignments;

class Groups extends \Dsc\Singleton
{

    public static function passes($module, $route = null, $options = array())
    {
        // if this ruleset is ignored, return null
        if (!in_array($module->{'assignment.groups.method'}, array(
            'one',
            'all',
            'none'
        )))
        {
            return null;
        }
        
        $groups_method = $module->{'assignment.groups.method'};
        $assigned_groups = $module->{'assignment.groups.list'};
        $identity_id = \Dsc\System::instance()->get('auth')->getIdentity()->id;
        
        if (!empty($assigned_groups))
        {
            $groups = array();
            $user = (new \Users\Models\Users())->setState('filter.id', $identity_id)->getItem();
            if (empty($identity_id) || empty($user->id))
            {
                // Get the default group
                $group_id = \Shop\Models\Settings::fetch()->{'users.default_group'};
                if (!empty($group_id))
                {
                    $groups[] = (new \Users\Models\Groups())->setState('filter.id', (string) $group_id)->getItem();
                }
            }
            elseif (!empty($user->id))
            {
                $groups = $user->groups();
            }
            
            $group_ids = array();
            foreach ($groups as $group)
            {
                $group_ids[] = (string) $group->id;
            }
            
            switch ($groups_method)
            {
                case "none":
                    $intersection = array_intersect($assigned_groups, $group_ids);
                    if (!empty($intersection))
                    {
                        return false;
                    }
                    
                    break;
                case "all":
                    // $missing_groups == the ones from $assigned_groups that are NOT in $group_ids
                    $missing_groups = array_diff($assigned_groups, $group_ids);
                    if (!empty($missing_groups))
                    {
                        return false;
                    }
                    
                    break;
                case "one":
                default:
                    $intersection = array_intersect($assigned_groups, $group_ids);
                    if (empty($intersection))
                    {
                        return false;
                    }
                    
                    break;
            }
        }
        
        return true;
    }
}