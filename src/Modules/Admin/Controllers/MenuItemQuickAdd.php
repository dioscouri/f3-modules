<?php 
namespace Modules\Admin\Controllers;

class MenuItemQuickAdd extends \Admin\Controllers\BaseAuth 
{
	public function html($event)
	{
		$view = \Dsc\System::instance()->get('theme');
		return $view->renderLayout('Modules/Admin/Views::quickadd/html.php');
	}
	
	public function custom($event)
	{
	    return $this->theme->renderView('Modules/Admin/Views::quickadd/custom.php');
	}
}