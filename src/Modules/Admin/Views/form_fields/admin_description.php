<div class="row">
    <div class="col-md-2">
        
        <h3>Admin-Only Description</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
    
        <div class="form-group">
            <label>This description is for admins only.  It never displays on the front-end of the site.</label>
            <textarea name="description" class="form-control" rows="10"><?php echo $flash->old('description'); ?></textarea>
        </div>
        <!-- /.form-group -->
            
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row --> 