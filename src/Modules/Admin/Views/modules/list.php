<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-table fa-fw "></i> 
				Modules
			<span> > 
				List
			</span>
		</h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
        <ul id="sparks" class="list-actions list-unstyled list-inline">
            <li>
                <a class="btn btn-default" href="./admin/module/create">Add New</a>
            </li>
        </ul>
	</div>
</div>

<form class="searchForm" method="post">

    <div class="no-padding">
        
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
                <?php /* ?>
                <ul class="list-filters list-unstyled list-inline">
                    <li>
                        <a class="btn btn-link">Advanced Filtering</a>
                    </li>                
                    <li>
                        <a class="btn btn-link">Quicklink Filter</a>
                    </li>
                    <li>
                        <a class="btn btn-link">Quicklink Filter</a>
                    </li>                    
                </ul>
                */ ?>
            </div>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control" type="text" name="filter[keyword]" placeholder="Search..." maxlength="200" value="<?php echo $state->get('filter.keyword'); ?>"> 
                        <span class="input-group-btn">
                            <input class="btn btn-primary" type="submit" onclick="this.form.submit();" value="Search" />
                            <button class="btn btn-danger" type="button" onclick="Dsc.resetFormFilters(this.form);">Reset</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="widget-body-toolbar">    
    
            <div class="row">
                <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">
                    <span class="pagination">
                    <div class="input-group">
                        <select id="bulk-actions" name="bulk_action" class="form-control">
                            <option value="null">-Bulk Actions-</option>
                            <option value="delete" data-action="./admin/shop/collections/delete">Delete</option>
                        </select>
                        <span class="input-group-btn">
                            <button class="btn btn-default bulk-actions" type="button" data-target="bulk-actions">Apply</button>
                        </span>
                    </div>
                    </span>
                </div>    
                <div class="col-xs-12 col-sm-7 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                    <div class="row text-align-right">
                        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <?php if (!empty($paginated->total_pages) && $paginated->total_pages > 1) { ?>
                            <?php echo $paginated->serve(); ?>
                        <?php } ?>
                        </div>
                        <?php if (!empty($paginated->items)) { ?>
                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                            <span class="pagination">
                            <?php echo $paginated->getLimitBox( $state->get('list.limit') ); ?>
                            </span>
                        </div>
                        <?php } ?>
                    </div>            
                </div>
            </div>
        
        </div>
        <!-- /.widget-body-toolbar -->
        
        <input type="hidden" name="list[order]" value="<?php echo $state->get('list.order'); ?>" />
        <input type="hidden" name="list[direction]" value="<?php echo $state->get('list.direction'); ?>" />
        
        <div class="table-responsive datatable dt-wrapper dataTables_wrapper">
            
            <table class="table table-striped table-bordered table-hover table-highlight table-checkable">
    		<thead>
    			<tr>
    			    <th class="checkbox-column"><input type="checkbox" class="icheck-input"></th>
    				<th data-sortable="title">Title</th>
    				<th data-sortable="type">Type</th>
    				<th>Positions</th>
    				<th data-sortable="ordering">Order</th>
    				<th>Status</th>				
    				<th class="col-md-1"></th>
    			</tr>
    		</thead>
    		<tbody>    
        
            <?php if (!empty($paginated->items)) { ?>
            
            <?php foreach($paginated->items as $item) { ?>
                <tr>
                    <td class="checkbox-column">
                        <input type="checkbox" class="icheck-input" name="ids[]" value="<?php echo $item->id; ?>">
                    </td>
                                
                    <td class="">
                        <h5>
                        <a href="./admin/module/edit/<?php echo $item->id; ?>">
                        <?php echo $item->{'title'}; ?>
                        </a>
                        </h5>
                        
                        <p class="help-block">
                        <?php echo $item->{'description'}; ?>
                        </p>
                    </td>
    
                    <td class="">
                    <?php echo substr( $item->{'type'}, 0, strpos( $item->{'type'}, '::' ) ); ?>
                    </td>
                    
                    <td class="">
                    <?php echo implode(", ", (array) $item->{'positions'} ); ?>
                    </td>
    
                    <td class="">
                    <?php echo (int) $item->{'ordering'}; ?>
                    </td>
                    
                    <td class="">
                        <div><?php echo ucwords( $item->{'publication.status'} ); ?></div>
                        <div><?php if ($item->{'publication.start_date'}) { echo "Up: " . $item->{'publication.start_date'}; } ?></div>
                        <div><?php if ($item->{'publication.end_date'}) { echo "Down: " . $item->{'publication.end_date'}; } ?></div>
                    </td>
                                    
                    <td class="text-center">
                        <a class="btn btn-xs btn-secondary" href="./admin/module/edit/<?php echo $item->id; ?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                        &nbsp;
                        <a class="btn btn-xs btn-danger" data-bootbox="confirm" href="./admin/module/delete/<?php echo $item->id; ?>">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            
            <?php } else { ?>
                <tr>
                <td colspan="100">
                    <div class="">No items found.</div>
                </td>
                </tr>
            <?php } ?>
    
            </tbody>
        </table>
    
        </div>
        
        <div class="dt-row dt-bottom-row">
            <div class="row">
                <div class="col-sm-10">
                    <?php if (!empty($paginated->total_pages) && $paginated->total_pages > 1) { ?>
                        <?php echo $paginated->serve(); ?>
                    <?php } ?>
                </div>
                <div class="col-sm-2">
                    <div class="datatable-results-count pull-right">
                        <span class="pagination">
                            <?php echo (!empty($paginated->total_pages)) ? $paginated->getResultsCounter() : null; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
    </div>

</form>