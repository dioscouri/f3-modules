<div class="row">
    <div class="col-md-2">
        
        <h3>Output Type</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>Select an Output Type</label>
            <select name="display[output_type]" class="form-control">
                <option value="default" <?php if ($flash->old('display.output_type') == "default") { echo "selected='selected'"; } ?>>Default</option>
                <option value="raw" <?php if ($flash->old('display.output_type') == "raw") { echo "selected='selected'"; } ?>>Raw - Content Only</option>
            </select>
            
            <ul class="help-block list-unstyled">
                <li><b>Default:</b> Wrap the Module's content in simple div elements identifying it for CSS targeting</li>
                <li><b>Raw:</b> Only output the actual content of the module.</li>
            </ul>
        </div>
        <!-- /.form-group -->
                                    
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr/>

<div class="row">
    <div class="col-md-2">
        
        <h3>Title Options</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>Display the Module Title?</label>
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
            <label for="class">Select a Heading Tag for the Title</label>
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
                                    
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr/>

<div class="row">
    <div class="col-md-2">
        
        <h3>Classes</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label for="class">This will be added to the class attribute of the element wrapping the entire module.  Use it for CSS targeting.</label>
            <input type="text" name="display[classes]" placeholder="eg. my-custom-module-class" value="<?php echo $flash->old('display.classes'); ?>" class="form-control" />
        </div>
        <!-- /.form-group -->
                                    
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->
