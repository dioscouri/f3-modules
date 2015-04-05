<?php
namespace Modules\Site;

class Routes extends \Dsc\Routes\Group
{
    public function initialize()
    {
        $custom_nav_items = (new \Admin\Models\Navigation)->emptyState()
        ->setState('filter.root', false)
        ->setState('filter.published', true)
        ->setState('order_clause', array( 'tree'=> 1, 'lft' => 1 ))
        ->setCondition('details.type', 'module-custom')
        ->getList();

        if ($custom_nav_items) 
        {
            foreach ($custom_nav_items as $nav_item) 
            {
                $this->app->route('GET ' . $nav_item->{'details.url'}, function() use ($nav_item){
                    \Modules\Site\Controllers\Custom::instance()->index($nav_item);
                } );
            }                
        }
        
    }
}