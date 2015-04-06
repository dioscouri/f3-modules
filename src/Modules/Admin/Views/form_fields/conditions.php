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
                    <option value="all" <?php if ($flash->old('assignment.method') == "all") { echo "selected='selected'"; } ?>>All conditions must be satisfied</option>
                    <option value="any" <?php if ($flash->old('assignment.method') == "any") { echo "selected='selected'"; } ?>>Any condition is matched</option>
                </select>            
            </div>
            <div class="col-md-9">
                <p class="help-block">Select <b>ALL</b> if <u>all of the conditions below</u> must be matched for the module to display. Select <b>ANY</b> if the module should display when <u>any of the conditions below</u> is matched.</p>
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
                    <option value="ignore" <?php if ($flash->old('assignment.routes.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore this condition</option>
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
                        This condition is ignored.
                    </div>                                  
                </div>              
                  
            </div>    
        </div>
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />

<div id="ruleset-url_queries" class="ruleset row">
    
    <div class="col-md-2">
        
        <h3>URL Query</h3>
        <p class="help-block">Show/Hide this module based on strings in the URL query (everything after the ?)</p>
                            
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <select name="assignment[url_queries][method]" class="form-control ruleset-switcher">
                    <option value="ignore" <?php if ($flash->old('assignment.url_queries.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore this condition</option>
                    <option value="include" <?php if ($flash->old('assignment.url_queries.method') == "include") { echo "selected='selected'"; } ?>>Include</option>
                    <option value="exclude" <?php if ($flash->old('assignment.url_queries.method') == "exclude") { echo "selected='selected'"; } ?>>Exclude</option>
                </select>                
            </div>
            <div class="col-md-9">
            
                <div class="ruleset-options">                
                    <div class="ruleset-enabled <?php if (!in_array($flash->old('assignment.url_queries.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        <input name="assignment[url_queries][list]" data-tags='[]' value="<?php echo implode(",", (array) $flash->old('assignment.url_queries.list') ); ?>" type="text" class="form-control ui-select2-tags" />
                    </div>                        
                    <div class="text-muted ruleset-disabled <?php if (in_array($flash->old('assignment.url_queries.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        This condition is ignored.
                    </div>                                  
                </div>              
                  
            </div>    
        </div>
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />

<div id="ruleset-login_status" class="ruleset row">
    
    <div class="col-md-2">
        
        <h3>Login Status</h3>
        <p class="help-block">Show/Hide this module based on login status</p>
                            
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <select name="assignment[login_status][method]" class="form-control ruleset-switcher">
                    <option value="ignore" <?php if ($flash->old('assignment.login_status.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore this condition</option>
                    <option value="include" <?php if ($flash->old('assignment.login_status.method') == "include") { echo "selected='selected'"; } ?>>Include</option>
                    <?php /* ?><option value="exclude" <?php if ($flash->old('assignment.login_status.method') == "exclude") { echo "selected='selected'"; } ?>>Exclude</option> */ ?>
                </select>                
            </div>
            <div class="col-md-9">
            
                <div class="ruleset-options">                
                    <div class="ruleset-enabled <?php if (!in_array($flash->old('assignment.login_status.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        <div class="form-group">
                            <select name="assignment[login_status][value]" class="form-control">
                            <?php 
                            echo \Dsc\Html\Select::options(array(
                                array('value'=>'0', 'text'=>'Not logged in'),
                                array('value'=>'1', 'text'=>'Logged in'),
                            ), $flash->old('assignment.login_status.value')); 
                            ?>
                            </select>
                        </div>
                    </div>                        
                    <div class="text-muted ruleset-disabled <?php if (in_array($flash->old('assignment.login_status.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        This condition is ignored.
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
                    <option value="ignore" <?php if ($flash->old('assignment.groups.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore this condition</option>
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
                        This condition is ignored.
                    </div>                                  
                </div>              
                  
            </div>    
        </div>
        
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr />

<div id="ruleset-referers" class="ruleset row">
    
    <div class="col-md-2">
        
        <h3>Visited from</h3>
        <p class="help-block">Show/Hide this module depending on the visitor's referrer</p>
                            
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3">
                <select name="assignment[referers][method]" class="form-control ruleset-switcher">
                    <option value="ignore" <?php if ($flash->old('assignment.referers.method') == "ignore") { echo "selected='selected'"; } ?>>Ignore this condition</option>
                    <option value="include" <?php if ($flash->old('assignment.referers.method') == "include") { echo "selected='selected'"; } ?>>Display to visitors from...</option>
                    <option value="exclude" <?php if ($flash->old('assignment.referers.method') == "exclude") { echo "selected='selected'"; } ?>>Display to all visitors except those from...</option>
                </select>                
            </div>
            <div class="col-md-9">
            
                <div class="ruleset-options">                
                    <div class="ruleset-enabled <?php if (!in_array($flash->old('assignment.referers.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        <div class="form-group">
                            <select name="assignment[referers][list]" class="form-control ui-select2" multiple="multiple">
                            <?php 
                            echo \Dsc\Html\Select::options(array(
                                array('value'=>'email', 'text'=>'All Recognized Email Clients'),
                                array('value'=>'search', 'text'=>'All Recognized Search Engines'),
                                array('value'=>'social', 'text'=>'All Recognized Social Platforms'),
                                array('value'=>'google', 'text'=>'Google'),
                                array('value'=>'facebook', 'text'=>'Facebook'),
                                array('value'=>'other', 'text'=>'Other'),
                            ), $flash->old('assignment.referers.list')); 
                            ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="help-block">If you selected 'Other', please provide the strings that we should search for in the referring URL:</label>
                            <input name="assignment[referers][others]" data-tags='[]' value="<?php echo implode(",", (array) $flash->old('assignment.referers.others') ); ?>" type="text" class="form-control ui-select2-tags" placeholder="e.g. utm, source, or wordpress.org"/>                            
                        </div>
                    </div>                        
                    <div class="text-muted ruleset-disabled <?php if (in_array($flash->old('assignment.referers.method'), array( "include", "exclude" ) ) ) { echo "hidden"; } ?>">
                        This condition is ignored.
                    </div>                                  
                </div>              
                  
            </div>    
        </div>
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<?php 
if ($conditions = (new \Modules\Models\Conditions)->getItems())
{
    foreach ($conditions as $condition)
    {
        echo "<hr/>";
        echo $condition->getClass()->html();
    }
}
?>