<?php 
namespace Modules\Admin\Models;

class Modules extends \Dsc\Models\Nodes 
{
    use \Dsc\Traits\Models\OrderableItem;
    
    protected $collection = 'common.modules';
    protected $type = 'custom.html'; // for modules, type is used to designate the module type 
    protected $default_ordering_direction = '1';
    protected $default_ordering_field = 'metadata.ordering';
    
    public function __construct($config=array())
    {
        parent::__construct($config);
        
        $this->filter_fields = array_merge( $this->filter_fields, array(
            'metadata.ordering'
        ) );
    }
    
    public function getMapper()
    {
        $mapper = null;
        if ($this->collection) {
            $mapper = new \Modules\Mappers\Module( $this->getDb(), $this->getCollectionName() );
        }
        return $mapper;
    }
    
    protected function fetchFilters()
    {
        $this->filters = array();
    
        $filter_keyword = $this->getState('filter.keyword');
        if ($filter_keyword && is_string($filter_keyword))
        {
            $key =  new \MongoRegex('/'. $filter_keyword .'/i');
    
            $where = array();
            $where[] = array('metadata.title'=>$key);
            $where[] = array('details.copy'=>$key);
            $where[] = array('metadata.creator.name'=>$key);
    
            $this->filters['$or'] = $where;
        }
    
        $filter_id = $this->getState('filter.id');
        if (strlen($filter_id))
        {
            $this->filters['_id'] = new \MongoId((string) $filter_id);
        }
        
        $filter_creator_id = $this->getState('filter.creator.id');
        if (strlen($filter_creator_id))
        {
            $this->filters['metadata.creator.id'] = $filter_creator_id;
        }
        
        $filter_type = $this->getState('filter.type');
        if (strlen($filter_type))
        {
            $this->filters['metadata.type'] = $filter_type;
        }
        
        $filter_position = $this->getState('filter.position');
        if (strlen($filter_position))
        {
            $this->filters['metadata.positions'] = $filter_position;
        }
        
        $filter_published = $this->getState('filter.published');
        if ((is_bool($filter_published) && $filter_published) || $filter_published == 'published') {
            // only published items, using both publication dates and published field
            $this->filters['publication.status'] = 'published';
            // TODO Set publication date filters
        } elseif (strlen($filter_published)) {
            $this->filters['publication.status'] = $filter_published; 
        }
        
        return $this->filters;
    }
    
    public function save( $values, $options=array(), $mapper=null )
    {
        if (isset($values['metadata']['ordering'])) {
            $values['metadata']['ordering'] = (int) $values['metadata']['ordering'];
        }
        
        if (empty($values['publication']['start'])) {
            $values['publication']['start'] = \Dsc\Mongo\Metastamp::getDate( $values['publication']['start_date'] . ' ' . $values['publication']['start_time'] );
        }
        
        if (empty($values['publication']['end']) && !empty($values['publication']['end_date'])) {
            $string = $values['publication']['end_date'];
            if (!empty($values['publication']['end_time'])) {
                $string .= ' ' . $values['publication']['end_time']; 
            }
            $values['publication']['end'] = \Dsc\Mongo\Metastamp::getDate( trim( $string ) );
        }

        if (!empty($values['metadata']['positions']) && !is_array($values['metadata']['positions']))
        {
            $values['metadata']['positions'] = trim($values['metadata']['positions']);
            if (!empty($values['metadata']['positions'])) {
                $values['metadata']['positions'] = \Base::instance()->split( (string) $values['metadata']['positions'] );
            }
        }
        
        if (empty($values['metadata']['positions'])) {
            unset($values['metadata']['positions']);
        }
        
        if (!empty($values['assignment']['routes']['list']) && !is_array($values['assignment']['routes']['list']))
        {
            $values['assignment']['routes']['list'] = trim($values['assignment']['routes']['list']);
            if (!empty($values['assignment']['routes']['list'])) {
                $values['assignment']['routes']['list'] = \Base::instance()->split( (string) $values['assignment']['routes']['list'] );
            }
        }
        
        if (empty($values['assignment']['routes']['list'])) {
            unset($values['assignment']['routes']['list']);
        }
    
        return parent::save( $values, $options, $mapper );
    }
    
    /**
     * 
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
                $grouped[$key] = \Joomla\Utilities\ArrayHelper::sortObjects($grouped[$key], 'title');
            }            
            
            return $grouped;  
        }
        
        $types = \Joomla\Utilities\ArrayHelper::sortObjects($types, 'type');

        return $types;
    }
    
    public function positions()
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
}