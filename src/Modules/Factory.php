<?php 
namespace Modules;

class Factory extends \Prefab 
{
    /**
     * Bootstraps all registered modules
     * 
     */
    public function bootstrap()
    {
        $paths = \Base::instance()->get('dsc.module.paths');
        
        foreach ($paths as $path)
        {
            if ($folders = \Joomla\Filesystem\Folder::folders( $path ))
            {
                foreach ($folders as $folder)
                {
                    if (file_exists( $path . $folder . '/bootstrap.php' )) {
                        require_once $path . $folder . '/bootstrap.php';
                    }
                }
            }
        }
        
        return $this;
    }
    
    /**
     * Loads the modules published to a particular position, 
     * optionally (usually) filtered by a route (accepts * or null to indicate all routes)
     * 
     * @param unknown $postition
     * @param string $route
     * @param array $options
     * 
     * @return array
     */
    public static function load( $position, $route=null, $options=array() )
    {
        $return = array();

        $model = new \Modules\Admin\Models\Modules;
        $list = $model->setState('filter.position', $position)->setState('filter.published', true)->getList();
        
        // Run each module in $return through the Assignments check
        foreach ($list as $module) 
        {
            if ($module->passesAssignments( $route, $options )) 
            {
                $return[] = $module;
            }
        }  
        
        return $return;    
    }
    
    /**
     * Render a module position
     * 
     * @param unknown $position
     * @param string $route
     * @param unknown $options
     * 
     * @return string HTML
     */
    public static function render( $position, $route=null, $options=array() )
    {
        $contents = array();
        foreach (self::load($position, $route, $options) as $module) 
        {
            $contents[] = $module->render();
        }
            
        return implode('', $contents);
    }
    
    /**
     * Register a position with the system,
     * for use in the f3-admin when displaying available module positions.
     * Normal usage is within a Listener or a bootstrap file for registering a template's custom positions
     * 
     * @param unknown $name
     */
    public static function registerPositions( $new_positions=null )
    {
        $positions = \Base::instance()->get('dsc.module.positions');
        if (empty($positions) || !is_array($positions))
        {
            $positions = array();
        }
        
        if (empty($new_positions)) 
        {
            return $positions;
        }
        
        if (!is_array($new_positions)) 
        {
            $new_positions = array( $new_positions );
        }
        
        foreach ($new_positions as $position) 
        {
            // if $positions is not already registered, register it
            if (!in_array($position, $positions))
            {
                $positions[] = $position;
            }
        }
        
        \Base::instance()->set('dsc.module.positions', $positions);
        
        return $positions;
    }
    
    /**
     * Registers a position where a module may be located
     * Used when getting a list of installed modules
     * 
     * @param unknown $path
     */
    public static function registerPath( $path ) 
    {
        $paths = \Base::instance()->get('dsc.module.paths');
        if (empty($paths) || !is_array($paths)) 
        {
            $paths = array();
        }
        
        // if $path is not already registered, register it
        // last ones inserted are given priority by using unshift
        if (!in_array($path, $paths)) 
        {
            array_unshift( $paths, $path );
            \Base::instance()->set('dsc.module.paths', $paths);
        }
        
        return $paths;
    }
}