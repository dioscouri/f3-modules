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
    }
}

$app = new ModulesBootstrap();