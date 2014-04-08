<?php 
namespace Modules\Admin\Controllers;

class Modules extends \Admin\Controllers\BaseAuth 
{

    public function index()
    {
        \Base::instance()->set('pagetitle', 'Modules');
        \Base::instance()->set('subtitle', '');
        
        $model = new \Modules\Admin\Models\Modules;
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        $list = $model->paginate();

        $paginated = new \Dsc\Pagination($list['total'], $list['limit']);
        $paginated->items = !empty($list['subset']) ? $list['subset'] : array();
        \Base::instance()->set('paginated', $paginated );
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Modules/Admin/Views::modules/list.php');
    }
}