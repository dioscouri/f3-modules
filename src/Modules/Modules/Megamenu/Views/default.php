<?php 
$list = !empty($module->items) ? $module->items : array();
$params = !empty($module->params) ? $module->params : new \Dsc\Registry\Registry;
$class_suffix = !empty($module->options['class_suffix']) ? $module->options['class_suffix'] : null;
$megamenu_open = false; 
?>

<ul class="<?php echo $class_suffix;?>"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $key => $item) 
{
    echo $module->itemHtml( $item );
}
?>
</ul>