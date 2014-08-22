<script>
jQuery(document).ready(function(){
    ModuleAssignmentsSwitcher();

    jQuery('.ruleset-switcher').each(function(){
        e = jQuery(this);
        ModuleAssignmentsSwitch(e);
    });    
});

ModuleAssignmentsSwitcher = function() {
    jQuery('.ruleset-switcher').change(function(){
        e = jQuery(this);
        ModuleAssignmentsSwitch(e);
    });
};

ModuleAssignmentsSwitch = function(e) {
    var val = e.val();
    var id = e.parents('.ruleset').attr('id');
    if (id) {
        if (val == 'ignore') {
            jQuery('#' + id + ' .ruleset-options > .ruleset-enabled').hide().removeClass('hidden');
            jQuery('#' + id + ' .ruleset-options > .ruleset-disabled').show().removeClass('hidden');
        } else {
            jQuery('#' + id + ' .ruleset-options > .ruleset-enabled').show().removeClass('hidden');
            jQuery('#' + id + ' .ruleset-options > .ruleset-disabled').hide().removeClass('hidden');                                    
        }
    }    
};
</script>

<div class="row">
    <div class="col-md-2">
        
        <h3>Method</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">

        <div class="row">
            <div class="col-md-3">
                <select name="assignment[method]" class="form-control">
                    <option value="all" <?php if ($flash->old('assignment.method') == "all") { echo "selected='selected'"; } ?>>All</option>
                    <option value="any" <?php if ($flash->old('assignment.method') == "any") { echo "selected='selected'"; } ?>>Any</option>
                </select>            
            </div>
            <div class="col-md-9">
                <p class="help-block">Use <b>ALL</b> if <u>all of the rules below</u> must be matched for the module to display. Use <b>ANY</b> if the module should display when <u>any of the rules below</u> is matched.</p>
            </div>
        </div>
        
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />

<div id="ruleset-routes" class="ruleset row">
    
    <div class="col-md-2">
        
        <h3>Routes</h3>
        <p class="help-block">Specify the exact pages this module should display on (or not display on)</p>
                            
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <select name="assignment[routes][method]" class="form-control ruleset-switcher">
                    <option value="ignore" <?php if ($flash->old('assignment.routes.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore</option>
                    <option value="include" <?php if ($flash->old('assignment.routes.method') == "include") { echo "selected='selected'"; } ?>>Include</option>
                    <option value="exclude" <?php if ($flash->old('assignment.routes.method') == "exclude") { echo "selected='selected'"; } ?>>Exclude</option>
                </select>                
            </div>
            <div class="col-md-9">
            
                <div class="ruleset-options">                
                    <div class="ruleset-enabled <?php if (!in_array($flash->old('assignment.routes.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        <input name="assignment[routes][list]" data-tags='[]' value="<?php echo implode(",", (array) $flash->old('assignment.routes.list') ); ?>" type="text" class="form-control ui-select2-tags" />
                    </div>                        
                    <div class="text-muted ruleset-disabled <?php if (in_array($flash->old('assignment.routes.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        This ruleset is ignored.
                    </div>                                  
                </div>              
                  
            </div>    
        </div>
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />
                    
<div id="ruleset-groups" class="ruleset row">
    <div class="col-md-2">
        
        <h3>User Groups</h3>
        <p class="help-block">Specify the user groups that should (or should not) see this module.</p>
                        
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <select name="assignment[groups][method]" class="form-control ruleset-switcher">
                    <option value="ignore" <?php if ($flash->old('assignment.groups.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore</option>
                    <option value="one" <?php if ($flash->old('assignment.groups.method') == "one") { echo "selected='selected'"; } ?>>At least one</option>
                    <option value="all" <?php if ($flash->old('assignment.groups.method') == "all") { echo "selected='selected'"; } ?>>Must be in all</option>
                    <option value="none" <?php if ($flash->old('assignment.groups.method') == "none") { echo "selected='selected'"; } ?>>Cannot be in any</option>
                </select>                
            </div>
            <div class="col-md-9">
            
                <div class="ruleset-options">                
                    <div class="ruleset-enabled <?php if (!in_array($flash->old('assignment.groups.method'), array( "one", "all", "none" ) ) ) { echo "hidden"; } ?>">
                        <div class="form-group">
                            <?php if ((array) $groups = \Users\Models\Groups::find() ) { ?>
                            <div class="max-height-200 list-group-item">
                                <?php foreach ($groups as $one) { ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="assignment[groups][list][]" class="icheck-input" value="<?php echo $one->_id; ?>" <?php if (in_array($one->_id, (array) $flash->old('assignment.groups.list'))) { echo "checked='checked'"; } ?>>
                                        <?php echo $one->title;  ?>
                                    </label>
                                </div>
                                <?php } ?> 
                                
                            </div>
                            <?php } ?>
                            <input type="hidden" name="assignment[groups][list][]" value="" />                        
                        </div>
                        <!-- /.form-group -->
                    </div>                        
                    <div class="text-muted ruleset-disabled <?php if (in_array($flash->old('assignment.groups.method'), array( "one", "all", "none" ) ) ) { echo "hidden"; } ?>">
                        This ruleset is ignored.
                    </div>                                  
                </div>              
                  
            </div>    
        </div>
        
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->