<?php 
namespace Modules\Admin\Controllers;

class Modules extends \Admin\Controllers\BaseAuth 
{
	use \Dsc\Traits\Controllers\AdminList;
	protected $list_route = '/admin/modules';
	
	protected function getModel()
	{
		$model = new \Modules\Models\Modules;
		return $model;
	}
	
    public function index()
    {
        \Base::instance()->set('pagetitle', 'Modules');
        \Base::instance()->set('subtitle', '');
        
        $model = $this->getModel();
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        $paginated = $model->paginate();
        \Base::instance()->set('paginated', $paginated );
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Modules/Admin/Views::modules/list.php');
    }
}