<form action="./admin/menu/create" method="post">
    <p class="help-block">Use custom routes to create pages completely comprised of modules.</p>

    <div class="form-group">
        <label>Title</label>
		<input type="text" class="form-control" placeholder="Title of Menu Item" name="title">
	</div>
    
    <div class="form-group">
        <label>Custom Route</label>
        <input type="text" class="form-control" placeholder="e.g. / or /custom-url" name="details[url]">
        <p class="help-block">This should begin with /</p>
    </div>
    
	<div class="form-group">
		<label>Custom Module Position</label>
		<input type="text" class="form-control" placeholder="e.g. my-custom-module-page" name="details[module_position]">
	</div>
    
    <!-- /.form-group -->
    <div class="form-group">
        <label>Publication Status</label>
        <select name="published" class="form-control">
            <option value="1">Published</option>
            <option value="0">Not Published</option>
        </select>
    </div>

    <div class="form-group">
        <label>Parent</label>

        <select id="parent" name="parent" class="form-control">
            <optgroup label="No Parent">
                <option  value="null">Menu Root</option>
            </optgroup>
            
            <?php if (!empty($all)) { foreach ($all as $one) { ?>
                <?php
               
                
                // display the options grouped by tree 
                if (empty($current_tree) || $current_tree != $one->tree) {
                    if (!empty($current_tree)) {
                        ?></optgroup><?php
                    }
                    $current_tree = $one->tree;
                    ?>
                    <optgroup label="<?php echo $one->title; ?>">
                    <?php
                }
                ?>
                
                <?php if ($one->id == $current_tree) { ?>
                <option data-tree="<?php echo $one->tree; ?>" value="<?php echo $one->id; ?>" >Top Level of <?php echo $one->title; ?></option>                        
                <?php } else { ?>
                <option data-tree="<?php echo $one->tree; ?>" value="<?php echo $one->id; ?>" ><?php echo @str_repeat( "&ndash;", substr_count( @$one->path, "/" ) - 1 ) . " " . $one->title; ?></option>
                <?php } ?>
            <?php } } ?>
            
            <?php if (!empty($all)) { ?>
            </optgroup>
            <?php } ?>
            
        </select>
    </div>   
	
	<div class="form-group">
		<button type="submit" class="btn btn-default">Add to Menu</button>
		<input type="hidden" name="tree" value="<?php echo $tree; ?>" />
		<input type="hidden" name="details[type]" value="module-custom" />
	</div>
</form>