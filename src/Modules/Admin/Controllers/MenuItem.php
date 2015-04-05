<?php 
namespace Modules\Admin\Controllers;

class MenuItem extends \Admin\Controllers\BaseAuth 
{
	public function html($event)
	{
	    \Base::instance()->set('item', $event->getArgument('item'));
	    
		$view = \Dsc\System::instance()->get('theme');
		return $view->renderLayout('Modules/Admin/Views::menuitem/html.php');
	}
	
	public function custom($event)
	{
	    \Base::instance()->set('item', $event->getArgument('item'));
	     
	    $view = \Dsc\System::instance()->get('theme');
	    return $view->renderLayout('Modules/Admin/Views::menuitem/custom.php');
	}
}