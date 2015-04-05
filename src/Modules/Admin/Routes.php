<?php
namespace Modules\Admin;

class Routes extends \Dsc\Routes\Group
{

    public function initialize()
    {
        $this->setDefaults(array(
            'namespace' => '\Modules\Admin\Controllers',
            'url_prefix' => '/admin'
        ));
        
        $this->addCrudGroup('Modules', 'Module');
        
        $this->add('/module/options', 'GET|POST', array(
            'controller' => 'Module',
            'action' => 'options',
            'ajax' => true
        ));
    }
}