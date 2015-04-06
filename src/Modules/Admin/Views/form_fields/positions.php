<div class="row">
    <div class="col-md-2">
        
        <h3>Positions</h3>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">

        <div class="form-group">
            <label>Select the Module Positions where this Module will be displayed.</label>
            <input name="positions" data-tags='<?php echo json_encode( $all_positions ); ?>' value="<?php echo implode(",", (array) $flash->old('positions') ); ?>" type="text" class="form-control ui-select2-tags" />
        </div>
        <!-- /.form-group -->
                                    
    </div>
    <!-- /.col-md-10 -->
    
</div>
<!-- /.row -->