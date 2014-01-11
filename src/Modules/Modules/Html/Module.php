<?php 
namespace Modules\Modules\Html;

class Module extends \Modules\Abstracts\Module
{
    public function html()
    {
        $f3 = \Base::instance();
        
        $old_ui = $f3->get('UI');
        $temp_ui = !empty($this->options['views']) ? $this->options['views'] : dirname( __FILE__ ) . "/Views/";
        $f3->set('UI', $temp_ui);
        
        $f3->set('module', $this);
        
        $string = \Dsc\Template::instance()->renderLayout('Modules/Html/Views::default.php');
        
        $f3->set('UI', $old_ui);
        
        return $string;
    }
}