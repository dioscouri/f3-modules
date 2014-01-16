<?php 
$list = !empty($module->items) ? $module->items : array();
$params = !empty($module->params) ? $module->params : new \Joomla\Registry\Registry;
$class_suffix = !empty($module->options['class_suffix']) ? $module->options['class_suffix'] : null;
$megamenu_open = false;  
$id_tag = $params->get('tag_id') ? "id='" . $params->get('tag_id') . "'" : null;
// TODO Find the current menu item.  We need it's slug
// with the current item's slug, when looping through the items, add "class='active'" to any items that are in the path/breadcrumb of the current item
$found = false;   
?>

<ul <?php echo $id_tag; ?> class="nav <?php echo $class_suffix;?>">
<?php
foreach ($list as $key => $item) 
{
    $class = !empty($item->class) ? $item->class : 'menu-item';
    if (strpos($item->{'details.url'}, $PARAMS[0]) !== false && !$found) {
        $found = true;
        $class .= " active current";
    }
    $dropdown = false;
    if (isset($list[$key+1]) && $list[$key+1]->getDepth() > $item->getDepth()) {
        $class .= " dropdown";
        $dropdown = true;
    }
        
	echo '<li class="' . $class . '">';
	
	// is this a module?
    // or just a regular link?
    if ($dropdown) {
        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
        echo $item->title;
        echo '<b class="caret"></b>';
        echo '</a>';        
    } else {
        echo '<a href="' . $item->{'details.url'} . '">';
        echo $item->title;
        echo '</a>';
    }
    
	// The next item is deeper.
    if ($dropdown) {
	    echo '<ul class="dropdown-menu">';
	}
	// The next item is shallower.
	elseif (isset($list[$key+1]) && $item->getDepth() > $list[$key+1]->getDepth()) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->getDepth() - $list[$key+1]->getDepth());
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
}
?></ul>
