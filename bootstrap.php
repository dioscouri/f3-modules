<?php
class ModulesBootstrap extends \Dsc\Bootstrap
{
    protected $dir = __DIR__;
    protected $namespace = 'Modules';
    
    protected function preAdmin()
    {
        if (class_exists('\Search\Factory'))
        {
            \Search\Factory::registerSource(new \Search\Models\Source(array(
                'id' => 'modules',
                'title' => 'Modules',
                'class' => '\Modules\Models\Modules',
                'priority' => 40,
            )));
        }

        $path = $this->app->hive()['PATH'];
        if (strpos($path, '/admin/module/edit') !== false)
        {
            // Bootstrap the reports
            \Modules\Models\Conditions::bootstrap();
        }
        
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
                if ($position = $nav_item->{'details.module_position'}) 
                {
                    \Modules\Factory::registerPositions(array($position));
                }
            }
        }
    }
}

$app = new ModulesBootstrap();