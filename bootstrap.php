<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register the modules path
        \Modules\Factory::registerPath( $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-modules/src/Modules/Modules/" );
        
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Modules\Listener::instance());
        
        // register all the routes
        $f3->route('GET|POST /admin/modules', '\Modules\Admin\Controllers\Modules->display');
        $f3->route('GET|POST /admin/modules/page/@page', '\Modules\Admin\Controllers\Modules->display');
        $f3->route('GET|POST /admin/modules/delete', '\Modules\Admin\Controllers\Modules->delete');
        
        $f3->route('GET /admin/module/create', '\Modules\Admin\Controllers\Module->create');
        $f3->route('POST /admin/module/add', '\Modules\Admin\Controllers\Module->add');
        $f3->route('GET /admin/module/read/@id', '\Modules\Admin\Controllers\Module->read');
        $f3->route('GET /admin/module/edit/@id', '\Modules\Admin\Controllers\Module->edit');
        $f3->route('POST /admin/module/update/@id', '\Modules\Admin\Controllers\Module->update');
        $f3->route('GET|DELETE /admin/module/delete/@id', '\Modules\Admin\Controllers\Module->delete');
        
        $f3->route('GET|POST /admin/module/options [ajax]','\Modules\Admin\Controllers\Module->options');
        
        // append this app's UI folder to the path
        // new way
        \Dsc\System::instance()->get('theme')->registerViewPath( __dir__ . '/src/Modules/Admin/Views/', 'Modules/Admin/Views' );
        // old way        
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "vendor/dioscouri/f3-modules/src/Modules/Admin/Views/";
        $f3->set('UI', $ui);
        
        // TODO set some app-specific settings, if desired
                
        break;
    case "site":
        // TODO set some app-specific settings, if desired
        break;
}
?>