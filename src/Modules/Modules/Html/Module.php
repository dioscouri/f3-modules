<?php 
namespace Modules\Modules\Html;

class Module extends \Modules\Abstracts\Module
{
    public function html()
    {
        \Base::instance()->set('module', $this);
        
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/Views/', 'Modules/Html/Views' );
        $string = \Dsc\System::instance()->get('theme')->renderLayout('Modules/Html/Views::default.php');
        
        return $string;
    }
}