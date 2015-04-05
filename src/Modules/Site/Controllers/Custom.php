<?php 
namespace Modules\Site\Controllers;

class Custom extends \Dsc\Controller 
{    
    public function index($nav_item)
    {
        $this->app->set('meta.title', $nav_item->title);
        $this->app->set('meta.description', '' );
        $this->app->set('nav_item', $nav_item);

        /*
        \Dsc\Activities::track('Viewed Custom Route', array(
            'Page Title' => $nav_item->title,
            'URL' => $nav_item->{'details.url'}
        ));
        */
                
        echo $this->theme->renderTheme('Modules/Site/Views::custom.php');
    }
}