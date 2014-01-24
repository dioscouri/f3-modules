<div class="panel panel-default">
    <div class="panel-heading">
        <label>Top Level Items</label>
        <p class="help-block"><small>The following options only apply if this is a first-level menu item</small></p>
    </div>
    <div class="panel-body">
    
        <div class="form-group row">
            <label class="col-md-2">Columns</label>
            <div class="col-md-2">
            <select name="megamenu[columns]" class="form-control">
                <option value="1" <?php if ($flash->old('megamenu.columns') == 1) { echo "selected='selected'"; } ?>>1</option>
                <option value="2" <?php if ($flash->old('megamenu.columns') == 2) { echo "selected='selected'"; } ?>>2</option>
                <option value="3" <?php if ($flash->old('megamenu.columns') == 3) { echo "selected='selected'"; } ?>>3</option>
                <option value="4" <?php if ($flash->old('megamenu.columns') == 4) { echo "selected='selected'"; } ?>>4</option>
                <option value="5" <?php if ($flash->old('megamenu.columns') == 5) { echo "selected='selected'"; } ?>>5</option>
                <option value="6" <?php if ($flash->old('megamenu.columns') == 6) { echo "selected='selected'"; } ?>>6</option>
            </select>
            </div>
            <p class="help-block">How many columns should this Megamenu contain? This will also determine the starting width of the megamenu, though you can adjust it with CSS.</p>
            <p class="help-block">After setting the number of columns here, assign a width to each this menu item's children.</p>
        </div>
        <!-- /.form-group -->
        
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <label>Items Below the Top Level</label>
        <p class="help-block"><small>The following options only apply to menu items that are not on the first level.</small></p>
    </div>
    <div class="panel-body">
    
        <div class="form-group row">
            <label class="col-md-2">Width</label>
            <div class="col-md-2">
            <select name="megamenu[width]" class="form-control">
                <option value="1" <?php if ($flash->old('megamenu.width') == 1) { echo "selected='selected'"; } ?>>1</option>
                <option value="2" <?php if ($flash->old('megamenu.width') == 2) { echo "selected='selected'"; } ?>>2</option>
                <option value="3" <?php if ($flash->old('megamenu.width') == 3) { echo "selected='selected'"; } ?>>3</option>
                <option value="4" <?php if ($flash->old('megamenu.width') == 4) { echo "selected='selected'"; } ?>>4</option>
                <option value="5" <?php if ($flash->old('megamenu.width') == 5) { echo "selected='selected'"; } ?>>5</option>
                <option value="6" <?php if ($flash->old('megamenu.width') == 6) { echo "selected='selected'"; } ?>>6</option>
            </select>
            </div>
            <p class="help-block">How many columns should this menu item span?</p>
        </div>
        <!-- /.form-group -->
        
        <div class="form-group row">
            <label class="col-md-2">Group Child Items</label>
            <div class="form-group col-md-10">
            <label class="radio-inline">
                <input type="radio" name="megamenu[group_children]" value="1" <?php if (is_null($flash->old('megamenu.group_children')) || $flash->old('megamenu.group_children') == '1') { echo 'checked'; } ?>> Yes
            </label>
            <label class="radio-inline">
                <input type="radio" name="megamenu[group_children]" value="0" <?php if ($flash->old('megamenu.group_children') == '0') { echo 'checked'; } ?>> No
            </label>
            <p class="help-block">If set to YES, this item's children will be displayed grouped as an unordered list rather than as dropdowns. 
            </div>
        </div>
        <!-- /.form-group -->
    
    </div>
</div>