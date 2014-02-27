<script src="./ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function(){
    CKEDITOR.replaceAll( 'wysiwyg' );    
});

</script>

<form id="detail-form" action="./admin/module/add" class="form" method="post">
    <div class="row">
    
        <div class="col-md-12">
        
            <div class="form-actions clearfix">

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
                    <a href="#tab-assignment" data-toggle="tab"> Assignment </a>
                </li>
                <li>
                    <a href="#tab-options" data-toggle="tab"> Options </a>
                </li>
            </ul>
            
            <div class="tab-content">

                <div class="tab-pane active" id="tab-basics">
                
                <div class="row">
            
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" name="metadata[title]" placeholder="Title" value="<?php echo $flash->old('metadata.title'); ?>" class="form-control" />
                        </div>
                        <!-- /.form-group -->
                        
                        <div class="form-group">
                            <label><small class="help-block">Note: HTML entered here may not be displayed by all Module Types</small></label>
                            <textarea name="details[copy]" class="form-control wysiwyg"><?php echo $flash->old('details.copy'); ?></textarea>
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
                            
                                <div class="input-group">
                                    <input name="metadata[positions]" data-tags='<?php echo json_encode( $all_positions ); ?>' value="<?php echo implode(",", (array) $flash->old('metadata.positions') ); ?>" type="text" class="form-control ui-select2-tags" /> 
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
                                    <input name="metadata[ordering]" value="<?php echo (int) $flash->old('metadata.ordering'); ?>" type="text" class="form-control" />
                                    <p class="help-block">Ordering applies within a <i>position</i></p> 
                                </div>
                                <!-- /.form-group -->
            
                            </div>
                            <!-- /.portlet-content -->
            
                        </div>
                        <!-- /.portlet -->
                        
                        <div class="form-group">
                            <label>Description - Admin Only</label>
                            <textarea name="details[description]" class="form-control"><?php echo $flash->old('details.description'); ?></textarea>
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
                
                <div class="tab-pane" id="tab-assignment">
                    <script>
                    jQuery(document).ready(function(){
                        ModuleAssignmentsSwitcher();
                    });

                    ModuleAssignmentsSwitcher = function() {
                        jQuery('.ruleset-switcher').change(function(){
                            e = jQuery(this);
                            val = e.val();
                            id = e.parents('.ruleset').attr('id');
                            if (id) {
                                if (val == 'ignore') {
                                    jQuery('#' + id + ' .ruleset-options > .enabled').slideUp().removeClass('hidden');
                                    jQuery('#' + id + ' .ruleset-options > .disabled').slideDown().removeClass('hidden');
                                } else {
                                    jQuery('#' + id + ' .ruleset-options > .enabled').slideDown().removeClass('hidden');
                                    jQuery('#' + id + ' .ruleset-options > .disabled').slideUp().removeClass('hidden');                                    
                                }
                            }
                        });
                    }
                    </script>
                
                    <div class="form-group">
                        <label class="col-md-2">Method</label>
                        
                        <div class="col-md-2">
                            <select name="assignment[method]" class="form-control">
                                <option value="all" <?php if ($flash->old('assignment.method') == "all") { echo "selected='selected'"; } ?>>All</option>
                                <option value="any" <?php if ($flash->old('assignment.method') == "any") { echo "selected='selected'"; } ?>>Any</option>
                            </select>
                        </div>
                        
                        <p class="help-block">Set this to ALL if ALL of the rules below must be matched for the module to display.</p>
                        <p class="help-block">Set this to ANY if the module should display when ANY of the rules below is matched.</p>
                    </div>
                    <!-- /.form-group -->                    
        
                    <div id="ruleset-routes" class="portlet ruleset">
        
                        <div class="portlet-header">
                            <h3>Routes</h3>
                            <div class="col-md-2 pull-right portlet-tools">
                                <select name="assignment[routes][method]" class="form-control ruleset-switcher">
                                    <option value="ignore" <?php if ($flash->old('assignment.routes.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore</option>
                                    <option value="include" <?php if ($flash->old('assignment.routes.method') == "include") { echo "selected='selected'"; } ?>>Include</option>
                                    <option value="exclude" <?php if ($flash->old('assignment.routes.method') == "exclude") { echo "selected='selected'"; } ?>>Exclude</option>
                                </select>
                            </div>                            
                        </div>
                        <!-- /.portlet-header -->
        
                        <div class="portlet-content ruleset-options">
                            <div class="enabled <?php if (!in_array($flash->old('assignment.routes.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                                <input name="assignment[routes][list]" data-tags='[]' value="<?php echo implode(",", (array) $flash->old('assignment.routes.list') ); ?>" type="text" class="form-control ui-select2-tags" />
                            </div>                        
                            <div class="text-muted disabled <?php if (in_array($flash->old('assignment.routes.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                                This ruleset is ignored.
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab-options">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="metadata[type]" class="form-control" onchange="ModulesGetOptions();">
                        <?php foreach ($grouped_types as $key=>$types) { ?>
                            <optgroup label="<?php echo $key; ?>">
                            <?php foreach ($types as $type) { ?>                    
                                <option value="<?php echo $type->type; ?>" <?php if ($type->type == $flash->old('metadata.type')) { echo "selected='selected'"; } ?>><?php echo $type->title; ?></option>
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