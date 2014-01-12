f3-modules
=========

A module manager for the F3 framework

### Getting Started

```
Add this to your project's composer.json file:

{
    "require": {
        "dioscouri/f3-modules": "dev-master"
    }
}
```

Then add the following two lines to your index.php file, immediately before $app->run();

```
// bootstap each mini-app
\Dsc\Apps::instance()->bootstrap();

// trigger the preflight event
\Dsc\System::instance()->preflight(); 
``` 

### Adding Module Positions to the System

Yor front-end template probably has several custom module positions (header, footer, left, right, etc).  Tell the f3-admin about them with the following code, which you should put in your apps/site/bootstrap.php

```
// register the template'e module positions
\Modules\Factory::registerPositions( array('promo', 'footer', 'above-content', 'below-content') );
```

### Displaying a Module Position in your template

Add the following to your template file to render modules in the "footer" position.

```
<tmpl type="modules" name="footer" />
```

### Displaying a Module Position in a view file

Use the following code to render a module position within one of your views.

```
echo \Modules\Factory::render( 'your_custom_position_name', \Base::instance()->get('PARAMS.0') );
```

### Add your app's modules to the system

To add your own custom modules to the system, put them all within subfolders of your own \Modules folder, for example:
```
/apps/site/modules/
```
resulting in:
/apps/site/modules/custom_module_1/
/apps/site/modules/custom_module_2/

Then register your module folder with the system:

```
// register the modules path
\Modules\Factory::registerPath( $f3->get('PATH_ROOT') . "apps/site/modules/" );
```

### Bootstrap your modules

All of your modules can have their own bootstrap.php file, and therefore can have their own Listeners.  Put the bootstrap.php file in the root of their folder, such as:

/apps/site/modules/custom_module_1/bootstrap.php
/apps/site/modules/custom_module_2/bootstrap.php

### Add custom fields to the f3-admin module-editing form

Your module's Listener can add custom html to the f3-admin module-editing form.  See the core Megamenu Module for a working example:

f3-modules/src/Modules/Modules/Megamenu/Listeners/Admin.php
