<?php 
namespace Modules\Admin\Controllers;

class MenuItemQuickAdd extends \Admin\Controllers\BaseAuth 
{
	public function html($event)
	{
		$view = new \Dsc\Template;
		return $view->renderLayout('Modules/Admin/Views::quickadd/html.php');
	}
}