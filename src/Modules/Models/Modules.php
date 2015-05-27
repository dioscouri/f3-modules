<?php 
namespace Modules\Models;

class Modules extends \Dsc\Mongo\Collections\Content 
{
    use \Dsc\Traits\Models\OrderableCollection;

    public $positions = array();
    
    protected $__collection_name = 'common.modules';
    protected $__type = 'core.html::\Modules\Modules\Html\Module';
    protected $__config = array(
        'default_sort' => array(
            'ordering' => 1
        ),
    );
    
    protected function fetchConditions()
    {
        parent::fetchConditions();

        $filter_keyword = $this->getState('filter.keyword');
        if ($filter_keyword && is_string($filter_keyword))
        {
            $key =  new \MongoRegex('/'. $filter_keyword .'/i');
        
            $where = array();
        
            $regex = '/^[0-9a-z]{24}$/';
            if (preg_match($regex, (string) $filter_keyword))
            {
                $where[] = array('_id'=>new \MongoId((string) $filter_keyword));
            }

            $where[] = array('title'=>$key);
            $where[] = array('copy'=>$key);
            $where[] = array('description'=>$key);
            $where[] = array('metadata.creator.name'=>$key);
        
            $this->setCondition('$or', $where);
        }
        
        $filter_copy_contains = $this->getState('filter.copy-contains');
        if (strlen($filter_copy_contains))
        {
            $key =  new \MongoRegex('/'. $filter_copy_contains .'/i');
            $this->setCondition('copy', $key);
        }
        
        $filter_type = $this->getState('filter.type');
        if ($filter_type) {
            if (is_bool($filter_type) && $filter_type) {
                $this->unsetCondition( 'type' );
            } elseif (strlen($filter_type)) {
                $this->setCondition('type', $filter_type );
            }
        }
        
        $filter_position = $this->getState('filter.position');
        if (strlen($filter_position))
        {
            $this->setCondition('positions', $filter_position);
        }
        
        $filter_route = $this->getState('filter.route');
        if (strlen($filter_route))
        {
            $this->setCondition('assignment.routes.list', $filter_route);
        }
        
        $filter_published = $this->getState('filter.published');
        if ($filter_published || (int) $filter_published == 1) {
            // only published items, using both publication dates and published field
            $this->setState('filter.publication_status', 'published');
            $this->setState('filter.published_today', true);
        
        } elseif ((is_bool($filter_published) && !$filter_published) || (strlen($filter_published) && (int) $filter_published == 0)) {
            // only unpublished items
            $this->setState('filter.publication_status', array( '$ne' => 'published' ));
            $this->setState('filter.published_today', false);
        }
        
        $filter_published_today = $this->getState('filter.published_today');
        if (strlen($filter_published_today))
        {
            // add $and conditions to the query stack
            if (!$and = $this->getCondition('$and')) {
                $and = array();
            }
        
            $and[] = array('$or' => array(
                array('publication.start.time' => null),
                array('publication.start.time' => array( '$lte' => time() )  )
            ));
        
            $and[] = array('$or' => array(
                array('publication.end.time' => null),
                array('publication.end.time' => array( '$gt' => time() )  )
            ));
        
            $this->setCondition('$and', $and);
        }
        
        $filter_status = $this->getState('filter.publication_status');
        if (!empty($filter_status))
        {
            $this->setCondition('publication.status', $filter_status);
        }
        
        return $this;
    }

    protected function beforeSave()
    {
        if (!empty($this->images))
        {
            $images = array();
            $current = $this->images;
            $this->images = array();
        
            foreach ($current as $image)
            {
                if (!empty($image['image']))
                {
                    $images[] = array(
                        'image' => $image['image']
                    );
                }
            }
        
            $this->images = $images;
        }
        
        $this->ordering = (int) $this->ordering;
        
        if (!empty($this->positions) && !is_array($this->positions))
        {
            $this->positions = trim($this->positions);
            if (!empty($this->positions)) {
                $this->positions = array_map(function($el){
                    return strtolower($el);
                }, \Base::instance()->split( (string) $this->positions ));
            }
        }
        elseif(empty($this->positions) && !is_array($this->positions))
        {
            $this->positions = array();
        }
        
        if (!empty($this->{'assignment.routes.list'}) && !is_array($this->{'assignment.routes.list'}))
        {
            $this->{'assignment.routes.list'} = trim($this->{'assignment.routes.list'});
            if (!empty($this->{'assignment.routes.list'})) {
                $this->{'assignment.routes.list'} = \Base::instance()->split( (string) $this->{'assignment.routes.list'} );
            }
        }
        elseif(empty($this->{'assignment.routes.list'}) && !is_array($this->{'assignment.routes.list'})) {
            $this->{'assignment.routes.list'} = array();
        }
        
        if (!empty($this->{'assignment.referers.list'}) && !is_array($this->{'assignment.referers.list'}))
        {
            $this->{'assignment.referers.list'} = trim($this->{'assignment.referers.list'});
            if (!empty($this->{'assignment.referers.list'})) {
                $this->{'assignment.referers.list'} = \Base::instance()->split( (string) $this->{'assignment.referers.list'} );
            }
        }
        elseif(empty($this->{'assignment.referers.list'}) && !is_array($this->{'assignment.referers.list'})) {
            $this->{'assignment.referers.list'} = array();
        }
        
        if (!empty($this->{'assignment.referers.others'}) && !is_array($this->{'assignment.referers.others'}))
        {
            $this->{'assignment.referers.others'} = trim($this->{'assignment.referers.others'});
            if (!empty($this->{'assignment.referers.others'})) {
                $this->{'assignment.referers.others'} = \Base::instance()->split( (string) $this->{'assignment.referers.others'} );
            }
        }
        elseif(empty($this->{'assignment.referers.others'}) && !is_array($this->{'assignment.referers.others'})) {
            $this->{'assignment.referers.others'} = array();
        }
    
        return parent::beforeSave();
    }
    
    /**
     * Gets an array of all the registered module types
     * 
     * @param string $group_items
     * @return multitype:multitype: NULL |unknown
     */
    public function types($group_items=true)
    {
        // Search the registered module folders for the list of modules
        $paths = \Base::instance()->get('dsc.module.paths');
        
        // TODO cache the results
        
        $types = array();
        $grouped = array();
        
        foreach ($paths as $path) 
        {
            if ($folders = \Joomla\Filesystem\Folder::folders( $path ))
            {
                foreach ($folders as $folder)
                {
                    if (file_exists( $path . $folder . '/module.json' )) 
                    {

                      //  echo $path . $folder . '/module.json';
                       // die();
                        $file = $path . $folder . '/module.json';
                        if ($contents = file_get_contents($file)) 
                        {
                            $object = json_decode($contents);
                            if (empty($object->title)) {
                                continue;
                            }
                                                        
                            if (empty($object->group)) {
                                $object->group = 'Misc';
                            }
                            if (empty($object->class) || !class_exists($object->class)) {
                                if (!file_exists($path . $folder . '/Module.php')) {
                                    continue;
                                }
                                if (!$sniffed = $this->getClass($path . $folder . '/Module.php')) {
                                    continue;
                                }
                                $class = "\\" . $sniffed['class'];
                                if (!empty($sniffed['namespace'])) {
                                    $class = $sniffed['namespace'] . $class;
                                }
                                $object->class = $class;
                            }                            
                            
                            // only one instance of :: can be in the final type string
                            $object->group = str_replace('::', '-', $object->group);
                            $object->title = str_replace('::', '-', $object->title);
                            
                            // set the type
                            $object->type = strtolower($object->group . "." . $object->title) . "::" . $object->class;
                            
                            if (empty($grouped[$object->group])) {
                                $grouped[$object->group] = array();
                            }
                            $grouped[$object->group][] = $object;
                            $types[] = $object;
                        }
                    }
                }
            }
        }
        
        // sort the results, first by group, then by title
        if ($group_items) {
            
            ksort($grouped);
            foreach ($grouped as $key=>$type)
            {
                $grouped[$key] = \Dsc\ArrayHelper::sortObjects($grouped[$key], 'title');
            }            
            
            return $grouped;  
        }
        
        $types = \Joomla\Utilities\ArrayHelper::sortObjects($types, 'type');

        return $types;
    }
    
    /**
     * Module positions registered with the system
     * 
     * @return unknown
     */
    public static function positions()
    {
        // Search the registered module folders for the list of modules
        $positions = \Base::instance()->get('dsc.module.positions');
        sort($positions);
        
        return $positions;
    }
    
    /**
     * Gets the namespace and class inside a file 
     *  
     * @param unknown $file
     * @return multitype:unknown string
     */
    protected function getClass( $file ) 
    {
        $fp = fopen($file, 'r');
        $class = $namespace = $buffer = '';
        $i = 0;
        while (!$class) {
            if (feof($fp)) break;
        
            $buffer .= fread($fp, 512);
            $tokens = token_get_all($buffer);
        
            if (strpos($buffer, '{') === false) continue;
        
            for (;$i<count($tokens);$i++) {
                if ($tokens[$i][0] === T_NAMESPACE) {
                    for ($j=$i+1;$j<count($tokens); $j++) {
                        if ($tokens[$j][0] === T_STRING) {
                            $namespace .= '\\'.$tokens[$j][1];
                        } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                            break;
                        }
                    }
                }
        
                if ($tokens[$i][0] === T_CLASS) {
                    for ($j=$i+1;$j<count($tokens);$j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i+2][1];
                        }
                    }
                }
            }
        }
        
        return array('namespace' => $namespace, 'class' => $class);
    }
    
    /**
     * 
     * @param string $route
     * @param unknown $options
     * @return boolean
     */
    public function passesAssignments( $route=null, $options=array() )
    {
        $result = false;
        $passes = array();
    
        // is it a pass ALL or pass ANY?
        $method = 'all';
        if ($this->{'assignment.method'} == 'any') {
            $method = 'any';
        }
    
        // Core conditions
        $types = array(
            'Routes',
            'UrlQueries',
            'LoginStatus',
            'Referers',
            'Groups'
        );
    
        foreach ($types as $type)
        {
            $classname = "\\Modules\\Assignments\\" . $type;
            $passes["core-" . $type] = $classname::passes( $this, $route, $options );
            if ($method == 'any' && $passes["core-" . $type])
            {
                return true;
            }
        }
        
        // now do the same thing for the registered conditions 
        if ($conditions = (new \Modules\Models\Conditions)->getItems()) 
        {
            foreach ($conditions as $condition) 
            {
                $passes[$condition->namespace] = $condition->getClass()->passes( $this, $route, $options );
                if ($method == 'any' && $passes[$condition->namespace])
                {
                    return true;
                }                
            }
        }        
    
        if (!in_array(false, $passes, true)) {
            $result = true;
        }
    
        return $result;
    }
    
    /**
     * Renders the module's html by triggering its ->html() method
     * 
     * @return string
     */
    public function render()
    {
        // get an instance of this module's class from the ->type property
        $parts = explode( '::', $this->{'type'} );
        if (empty($parts[1]) || !class_exists($parts[1])) {
            return null;
        }
    
        // TODO Give the ability for developers to create their own Chromes
    
        // pass this model as part of the $options array in the constructor
        // return the module's html()
        if (!$module_html = (new $parts[1](array('model'=>$this)))->html()) {
            return null;
        }
        
        switch ($this->{'display.output_type'}) 
        {
            case "raw":
                return $module_html;
                break;
            default:
                break;
        }
    
        $module_type = (string) preg_replace('/[^A-Z0-9_.-]/i', '', $parts[0]);
        $module_type = ltrim($module_type, '.');
        $module_type = str_replace(array('_', '.'), array('-', '-'), $module_type);
    
        $classes = trim('module-wrap clearfix '. $module_type . ' ' . $this->{'display.classes'});
    
        $strings = array();
        $strings[] = '<div class="' . $classes . '" id="module-' . $this->id . '">';
        if ($this->{'display.title'} == 1 || is_null($this->{'display.title'}) )
        {
            $tag = $this->{'display.title_tag'} ? $this->{'display.title_tag'} : 'h4';
            $strings[] = '<' . $tag . '>';
            $strings[] = $this->{'title'};
            $strings[] = '</' . $tag . '>';
        }
    
        $strings[] = '<div class="module-content clearfix">';
        $strings[] = $module_html;
        $strings[] = '</div>';
    
        $strings[] = '</div>';
    
        return implode( '', $strings );
    }

    /**
     * Converts this to a search item, used in the search template when displaying each search result
     */
    public function toAdminSearchItem()
    {
        $image = (!empty($this->{'featured_image.slug'})) ? './asset/thumb/' . $this->{'featured_image.slug'} : null;
        $published_status = '<span class="label ' . $this->publishableStatusLabel() . '">' . $this->{'publication.status'} . '</span>';
        $positions = !empty($this->positions) ? '<span class="label label-info">' . implode("</span> <span class='label label-info'>", (array) $this->positions) . '</span>' : null;
        
        $item = new \Search\Models\Item(array(
            'url' => './admin/module/edit/' . $this->id,
            'title' => $this->title,
            'subtitle' => $this->description,
            'image' => $image,
            'summary' => $positions,
            'datetime' => $published_status . ' ' . date('Y-m-d', $this->{'publication.start.time'} ),
        ));
    
        return $item;
    }
    
    /**
     *
     * @param array $types
     * @return unknown
     */
    public static function distinctTypes($query=array())
    {
        $model = new static();
        $distinct = $model->collection()->distinct("type", $query ? $query : null);
        $distinct = array_values( array_filter( $distinct ) );
        sort($distinct);
        
        return $distinct;
    }
    
    /**
     *
     * @param array $types
     * @return unknown
     */
    public static function distinctRoutes($query=array())
    {
        $model = new static();
        $distinct = $model->collection()->distinct("assignment.routes.list", $query ? $query : null);
        $distinct = array_values( array_filter( $distinct ) );
        sort($distinct);
    
        return $distinct;
    }
}