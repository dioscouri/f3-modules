<?php 
namespace Modules\Admin\Controllers;

class Module extends \Admin\Controllers\BaseAuth 
{
    use \Dsc\Traits\Controllers\OrderableItemCollection;

    protected $list_route = '/admin/modules';
    protected $create_item_route = '/admin/module/create';
    protected $get_item_route = '/admin/module/read/{id}';    
    protected $edit_item_route = '/admin/module/edit/{id}';
    
    protected function getModel() 
    {
        $model = new \Modules\Models\Modules;
        return $model; 
    }
    
    protected function getItem() 
    {
        $f3 = \Base::instance();
        $id = $this->inputfilter->clean( $f3->get('PARAMS.id'), 'alnum' );
        $model = $this->getModel()
            ->setState('filter.id', $id);

        try {
            $item = $model->getItem();
        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
            $f3->reroute( $this->list_route );
            return;
        }

        return $item;
    }
    
    protected function displayCreate() 
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Create Module');
        
        $grouped_types = $this->getModel()->types();
        \Base::instance()->set('grouped_types', $grouped_types );
        
        $all_positions = $this->getModel()->positions();
        \Base::instance()->set('all_positions', $all_positions );
        
        $this->app->set('meta.title', 'Create Module | Modules');
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Modules/Admin/Views::modules/create.php');
    }
    
    protected function displayEdit()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Edit Module');
        
        $grouped_types = $this->getModel()->types();
        \Base::instance()->set('grouped_types', $grouped_types );
                        
        $all_positions = $this->getModel()->positions();
        \Base::instance()->set('all_positions', $all_positions );

        $item = $this->getItem();
        $type = $item->{'type'};
        
        $view = \Dsc\System::instance()->get('theme');
        $view->event = $view->trigger( 'onDisplayAdminModuleEdit', array( 'module' => $type, 'item' => $item, 'tabs' => array(), 'content' => array() ) );

        $this->app->set('meta.title', 'Edit Module | Modules');
        
        echo $view->render('Modules/Admin/Views::modules/edit.php');
    }
    
    /**
     * This controller doesn't allow reading, only editing, so redirect to the edit method
     */
    protected function doRead(array $data, $key=null) 
    {
        $f3 = \Base::instance();
        $id = $this->getItem()->get( $this->getItemKey() );
        $route = str_replace('{id}', $id, $this->edit_item_route );
        $f3->reroute( $route );
    }
    
    protected function displayRead() {}
    
    public function options()
    {
        $data = \Base::instance()->get('REQUEST');
        
        // get the metadata.type
        if (!$type = \Dsc\ArrayHelper::get($data, 'type')) {
            return;
        }

        $view = \Dsc\System::instance()->get('theme');
        $view->event = $view->trigger( 'onDisplayAdminModuleEdit', array( 'module' => $type, 'item' => $this->getItem(), 'tabs' => array(), 'content' => array() ) );
        $html = $view->renderLayout('Modules/Admin/Views::modules/options.php');
        
        $response = $this->getJsonResponse( array( 'message' => $html ) );
        return $this->outputJson($response);
    }
}