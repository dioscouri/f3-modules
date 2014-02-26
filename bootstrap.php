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
        \Dsc\System::instance()->get('router')->mount( new \Modules\Routes );
        
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