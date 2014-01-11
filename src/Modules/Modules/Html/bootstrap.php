<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "admin":
        // register event listener
        //\Dsc\System::instance()->getDispatcher()->addListener(\Modules\Listener::instance());
        
        break;
    case "site":
        
        break;
}
?>