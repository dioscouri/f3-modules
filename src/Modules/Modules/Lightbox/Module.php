<?php 
namespace Modules\Modules\Lightbox;

class Module extends \Modules\Abstracts\Module
{
    public function html()
    {
        \Base::instance()->set('module', $this);
        
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/Views/', 'Modules/Lightbox/Views' );
        $string = \Dsc\System::instance()->get('theme')->renderLayout('Modules/Lightbox/Views::index.php');
        
        return $string;
    }
}