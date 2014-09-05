<p class="alert alert-warning"><b>Important:</b> In the "Display" tab, set "Display Title" = No.  This will prevent the module's title from displaying inappropriately.</p> 

<div class="row">
    <div class="col-md-2">
        
        <h3>Display</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">

        <div class="form-group">
            <div class="row clearfix">
                <div class="col-md-6">        
                    <label>Display the module's title as the title of the Lightbox?</label>
                    <div class="form-group">
                    <label class="radio-inline">
                        <input type="radio" name="lightbox[title_enabled]" value="1" <?php if ($flash->old('lightbox.title_enabled')) { echo 'checked'; } ?>> Yes
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="lightbox[title_enabled]" value="0" <?php if (!$flash->old('lightbox.title_enabled')) { echo 'checked'; } ?>> No
                    </label>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Frequency</label>
                        <select name="lightbox[frequency]" class="form-control">
                            <option value="once" <?php if (!$flash->old('lightbox.frequency') || $flash->old('lightbox.frequency') == "once") { echo "selected='selected'"; } ?>>Default - one time only</option>
                            <option value="once_per_visit" <?php if ($flash->old('lightbox.frequency') == "once_per_visit") { echo "selected='selected'"; } ?>>Once per visit</option>
                            <option value="daily" <?php if ($flash->old('lightbox.frequency') == "daily") { echo "selected='selected'"; } ?>>Once a day</option>
                            <option value="monthly" <?php if ($flash->old('lightbox.frequency') == "monthly") { echo "selected='selected'"; } ?>>Once a month</option>
                            <option value="every_page" <?php if ($flash->old('lightbox.frequency') == "every_page") { echo "selected='selected'"; } ?>>Every page refresh</option>
                        </select>
                        <p class="help-block">This frequency setting only applies after all conditions in the Conditions tab have been met.</p>
                    </div>
                    
                    <div class="form-group">
                        <label>Cookie Name</label>
                        <input type="text" name="lightbox[cookie_name]" value="<?php echo !$flash->old('lightbox.cookie_name') ? new \MongoId : $flash->old('lightbox.cookie_name'); ?>" class="form-control" />
                        <p class="help-block">A cookie is necessary for the frequency setting to work.  To force all visitors to see this module again (e.g. if you modify the module's content), change this value.</p>
                    </div>
                    <!-- /.form-group -->
                                
                </div>
            </div>
        </div>
        <!-- /.form-group -->
    
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->
