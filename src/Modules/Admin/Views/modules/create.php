<script src="./ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function(){
    CKEDITOR.replaceAll( 'wysiwyg' );    
});

</script>

<div class="well">

<form id="detail-form" class="form" method="post">
    <div class="row">
    
        <div class="col-md-12">
        
            <div class="clearfix">

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <input id="primarySubmit" type="hidden" value="save_edit" name="submitType" />
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a onclick="document.getElementById('primarySubmit').value='save_new'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Create Another</a>
                            </li>
                            <li>
                                <a onclick="document.getElementById('primarySubmit').value='save_close'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Close</a>
                            </li>
                        </ul>
                    </div>                          
                    &nbsp;
                    <a class="btn btn-default" href="./admin/modules">Cancel</a>
                </div>

            </div>
            <!-- /.form-actions -->        
            
            <hr />    
    
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab-basics" data-toggle="tab"> Basics </a>
                </li>
                <li>
                    <a href="#tab-display" data-toggle="tab"> Display </a>
                </li>
                <li>
                    <a href="#tab-conditions" data-toggle="tab"> Conditions </a>
                </li>
                <li>
                    <a href="#tab-options" data-toggle="tab"> Type </a>
                </li>
            </ul>
            
            <div class="tab-content">

                <div class="tab-pane active" id="tab-basics">
                
                <div class="row">
            
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" name="title" placeholder="Title" value="<?php echo $flash->old('title'); ?>" class="form-control" />
                        </div>
                        <!-- /.form-group -->
                        
                        <div class="form-group">
                            <label><small class="help-block">Note: HTML entered here may not be displayed by all Module Types</small></label>
                            <textarea name="copy" class="form-control wysiwyg"><?php echo $flash->old('copy'); ?></textarea>
                        </div>
                        <!-- /.form-group -->
                        
                    </div>
                    <!-- /.col-md-9 -->
                    
                    <div class="col-md-3">
            
                        <div class="portlet">
            
                            <div class="portlet-header">
            
                                <h3>Publication</h3>
            
                            </div>
                            <!-- /.portlet-header -->
            
                            <div class="portlet-content">
            
                                <div class="form-group">
                                    <label>Status:</label>
            
                                    <select name="publication[status]" class="form-control">
                                        <option value="draft" <?php if ($flash->old('publication.status') == 'draft') { echo "selected='selected'"; } ?>>Draft</option>
                                        <option value="pending" <?php if ($flash->old('publication.status') == 'pending') { echo "selected='selected'"; } ?>>Pending Review</option>
                                        <option value="published" <?php if ($flash->old('publication.status') == 'published') { echo "selected='selected'"; } ?>>Published</option>
                                    </select>
                                
                                </div>
                                <div class="form-group">
                                    <label>Start:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input name="publication[start_date]" value="<?php echo $flash->old('publication.start_date', date('Y-m-d') ); ?>" class="ui-datepicker form-control" type="text" data-date-format="yyyy-mm-dd" data-date-today-highlight="true" data-date-today-btn="true">
                                        </div>
                                        <div class="input-group col-md-6">
                                            <input name="publication[start_time]" value="<?php echo $flash->old('publication.start_time' ); ?>" type="text" class="ui-timepicker form-control" data-show-meridian="false" data-show-inputs="false">
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Finish:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input name="publication[end_date]" value="<?php echo $flash->old('publication.end_date' ); ?>" class="ui-datepicker form-control" type="text" data-date-format="yyyy-mm-dd" data-date-today-highlight="true" data-date-today-btn="true">
                                        </div>
                                        <div class="input-group col-md-6">
                                            <input name="publication[end_time]" value="<?php echo $flash->old('publication.end_time' ); ?>" type="text" class="ui-timepicker form-control" data-default-time="false" data-show-meridian="false" data-show-inputs="false">
                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </div>
                                    <span class="help-text">Leave these blank to never unpublish.</span>
                                </div>
            
                            </div>
                            <!-- /.portlet-content -->
            
                        </div>
                        <!-- /.portlet -->
                        
                        <div class="portlet">
            
                            <div class="portlet-header">
            
                                <h3>Positions</h3>
            
                            </div>
                            <!-- /.portlet-header -->
            
                            <div class="portlet-content">
                            
                                <div class="form-group">
                                    <input name="positions" data-tags='<?php echo json_encode( $all_positions ); ?>' value="<?php echo implode(",", (array) $flash->old('positions') ); ?>" type="text" class="form-control ui-select2-tags" /> 
                                </div>
                                <!-- /.form-group -->
            
                            </div>
                            <!-- /.portlet-content -->
            
                        </div>
                        <!-- /.portlet -->
                        
                        <div class="portlet">
            
                            <div class="portlet-header">
            
                                <h3>Ordering</h3>
            
                            </div>
                            <!-- /.portlet-header -->
            
                            <div class="portlet-content">
                                <div class="form-group">
                                    <input name="ordering" value="<?php echo (int) $flash->old('ordering'); ?>" type="text" class="form-control" />
                                    <p class="help-block">Ordering applies within a <i>position</i></p> 
                                </div>
                                <!-- /.form-group -->
            
                            </div>
                            <!-- /.portlet-content -->
            
                        </div>
                        <!-- /.portlet -->
                        
                        <div class="form-group">
                            <label>Description - Admin Only</label>
                            <textarea name="description" class="form-control"><?php echo $flash->old('description'); ?></textarea>
                        </div>
                        <!-- /.form-group -->
                        
            
                    </div>
                    <!-- /.col-md-3 -->
                
                </div>
                <!-- /.row -->
                
                </div>
                <!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab-display">
                
                    <div class="form-group">
                        <label>Display Title</label>
                        <div class="form-group">
                        <label class="radio-inline">
                            <input type="radio" name="display[title]" value="1" <?php if (is_null($flash->old('display.title')) || $flash->old('display.title') == '1') { echo 'checked'; } ?>> Yes
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="display[title]" value="0" <?php if ($flash->old('display.title') == '0') { echo 'checked'; } ?>> No
                        </label>
                        </div>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label for="class">Title Tag</label>
                        <select name="display[title_tag]" class="form-control">
                            <option value="h1" <?php if ($flash->old('display.title_tag') == "h1") { echo "selected='selected'"; } ?>>H1</option>
                            <option value="h2" <?php if ($flash->old('display.title_tag') == "h2") { echo "selected='selected'"; } ?>>H2</option>
                            <option value="h3" <?php if ($flash->old('display.title_tag') == "h3") { echo "selected='selected'"; } ?>>H3</option>
                            <option value="h4" <?php if ($flash->old('display.title_tag') == "h4" || is_null($flash->old('display.title_tag'))) { echo "selected='selected'"; } ?>>H4</option>
                            <option value="h5" <?php if ($flash->old('display.title_tag') == "h5") { echo "selected='selected'"; } ?>>H5</option>
                            <option value="h6" <?php if ($flash->old('display.title_tag') == "h6") { echo "selected='selected'"; } ?>>H6</option>
                        </select>
                    </div>
                    <!-- /.form-group -->
                    
                    <div class="form-group">
                        <label for="class">Class Suffix</label>
                        <input type="text" name="display[classes]" placeholder="A string added to the class attribute of the element wrapping the entire module" value="<?php echo $flash->old('display.classes'); ?>" class="form-control" />
                    </div>
                    <!-- /.form-group -->
                                        
                </div>
                <!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab-conditions">
                
                    <?php echo $this->renderLayout('Modules/Admin/Views::modules/fields_conditions.php'); ?>
                
                </div>
                <!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab-options">
                    <div class="form-group">
                        <label>Select a Type</label>
                        <select name="type" class="form-control" onchange="ModulesGetOptions();">
                        <?php foreach ($grouped_types as $key=>$types) { ?>
                            <optgroup label="<?php echo $key; ?>">
                            <?php foreach ($types as $type) { ?>                    
                                <option value="<?php echo $type->type; ?>" <?php if ($type->type == $flash->old('type', $model->type() ) ) { echo "selected='selected'"; } ?>><?php echo $type->title; ?></option>
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
                    
                    <div id="module-options" class="form-group">
                        
                    </div>
                    <!-- /.form-group -->
                        
                </div>
                
            </div>
    

    </div>
</form>

</div>