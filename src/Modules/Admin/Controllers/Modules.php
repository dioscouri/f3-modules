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
        $model = $this->getModel();
        $state = $model->populateState()->setState('filter.type', true)->getState();
        \Base::instance()->set('state', $state );
        
        $paginated = $model->paginate();
        \Base::instance()->set('paginated', $paginated );

        $this->app->set('meta.title', 'Modules');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Modules/Admin/Views::modules/list.php');
    }
}