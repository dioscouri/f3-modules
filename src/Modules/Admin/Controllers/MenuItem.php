<?php 
namespace Modules\Admin\Controllers;

class MenuItem extends \Admin\Controllers\BaseAuth 
{
	public function html($event)
	{
	    \Base::instance()->set('item', $event->getArgument('item'));
	    
		$view = new \Dsc\Template;
		return $view->renderLayout('Modules/Admin/Views::menuitem/html.php');
	}
}