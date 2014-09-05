<?php 
if (!class_exists('\Minify\Factory'))
{
    ?>
    <script src="./LightboxAssets/js/bootbox-4.3.0.min.js"></script>
    <script src="./LightboxAssets/js/jquery.cookie-1.4.1.js"></script>
    <?php
}
?>

<?php 
$cookie_name = $module->model->id . "." . $module->model->{'lightbox.cookie_name'};
switch ( $module->model->{'lightbox.frequency'}) 
{
    case "every_page":
        $expires = false;
        break;
    case "monthly":
        $expires = 30;
        break;
    case "daily":
        $expires = 1;
        break;
    case "once_per_visit":
        $expires = null;
        break;
    case "once":
    default:
        $expires = 365;
        break;    
}
?>

<div id="lightbox-<?php echo $module->model->id; ?>" class="hidden">
    <?php echo $module->model->{'copy'}; ?>
</div>

<script>
jQuery(document).ready(function() {
    
    var cookie_name = "<?php echo $cookie_name; ?>";

    <?php if ($expires === false) { ?>

        bootbox.dialog({
            <?php if ($module->model->{'lightbox.title_enabled'} == 1) { ?>
            title: "<?php echo $module->model->title; ?>",
            <?php } ?>
            message: jQuery('#lightbox-<?php echo $module->model->id; ?>').html()
        });
     
    <?php } else { ?>
        if (!jQuery.cookie(cookie_name)) {
    
            <?php if (is_null($expires)) { ?>
            jQuery.cookie(cookie_name, 1 );
            <?php } elseif ($expires) { ?>
            jQuery.cookie(cookie_name, 1, { expires: <?php echo $expires; ?> } );
            <?php } ?>
    
            bootbox.dialog({
                <?php if ($module->model->{'lightbox.title_enabled'} == 1) { ?>
                title: "<?php echo $module->model->title; ?>",
                <?php } ?>
                message: '<?php echo $module->model->{'copy'}; ?>' 
            });
            
        }    
    <?php } ?>
});
</script>