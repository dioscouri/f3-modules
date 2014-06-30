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
    }
}

$app = new ModulesBootstrap();