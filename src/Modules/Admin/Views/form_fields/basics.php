<script>
jQuery(document).ready(function(){
    CKEDITOR.replaceAll( 'wysiwyg' );    
});
</script>

<div class="row">
    <div class="col-md-2">
        
        <h3>Title</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>Depending on the Module Type and your Display settings, this Title may not be displayed on the front-end.</label>
            <input type="text" name="title" placeholder="Title" value="<?php echo $flash->old('title'); ?>" class="form-control" />
        </div>
        <!-- /.form-group -->
                                    
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->

<hr/>

<div class="row">
    <div class="col-md-2">
        
        <h3>Module HTML Content</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">

        <div class="form-group">
            <p class="help-block">Note: HTML entered here may not be displayed by all Module Types.  In fact, most modules will ignore this and generate their own HTML based on their custom options.</p>
            <textarea name="copy" class="form-control wysiwyg"><?php echo $flash->old('copy'); ?></textarea>
        </div>
        <!-- /.form-group -->
                                    
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->