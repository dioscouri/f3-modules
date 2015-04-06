<div class="row">
    <div class="col-md-2">
        
        <h3>Module Type</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>Select a Module Type.  If it has custom options, they will display below.</label>
            <select name="type" class="form-control" onchange="ModulesGetOptions();">
            <?php foreach ($grouped_types as $key=>$types) { ?>
                <optgroup label="<?php echo $key; ?>">
                <?php foreach ($types as $type) { ?>                    
                    <option value="<?php echo $type->type; ?>" <?php if ($type->type == $flash->old('type')) { echo "selected='selected'"; } ?>><?php echo $type->title; ?></option>
                <?php } ?>
                </optgroup>
            <?php } ?>
            </select>
            
            <script>
            ModulesGetOptions = function() {
                <?php // Get the form contents and send it to /admin/module/options ?>
                var form_data = new Array();
            	jQuery.merge( form_data, jQuery('#detail-form').serializeArray() );

                var request = jQuery.ajax({
                    type: 'post', 
                    url: './admin/module/options',
                    data: form_data
                }).done(function(data){
                    var lr = jQuery.parseJSON( JSON.stringify(data), false);
                    jQuery('#module-options').html(lr.message);
                });
            }
            </script>
        </div>
        <!-- /.form-group -->
            
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->                     

<hr/>

<div id="module-options" class="form-group">
    <?php echo $this->renderLayout('Modules/Admin/Views::modules/options.php'); ?>
</div>
<!-- /.form-group -->