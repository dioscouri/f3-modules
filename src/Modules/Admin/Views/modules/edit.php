<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark">
            <i class="fa fa-table fa-fw "></i> 
            <a href="./admin/modules">Modules</a>
            <span> > <?php echo $item->title; ?> </span>
        </h1>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

    </div>
</div>

<div class="well">

    <form id="detail-form" class="form" method="post">
        <div class="row">
        
            <div class="col-md-12">
            
                <div class="clearfix">
    
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <input id="primarySubmit" type="hidden" value="save_edit" name="submitType" />
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a onclick="document.getElementById('primarySubmit').value='save_new'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Create Another</a>
                                </li>
                                <li>
                                    <a onclick="document.getElementById('primarySubmit').value='save_as'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save As</a>
                                </li>                            
                                <li>
                                    <a onclick="document.getElementById('primarySubmit').value='save_close'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Close</a>
                                </li>
                            </ul>
                        </div>                          
                        &nbsp;
                        <a class="btn btn-default" href="./admin/modules">Cancel</a>
                    </div>
    
                </div>
                <!-- /.form-actions -->        
                
                <hr />    
        
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-basics" data-toggle="tab"> Basics </a>
                    </li>
                    <li>
                        <a href="#tab-display" data-toggle="tab"> Display </a>
                    </li>                
                    <li>
                        <a href="#tab-conditions" data-toggle="tab"> Conditions </a>
                    </li>
                    <li>
                        <a href="#tab-options" data-toggle="tab"> Type </a>
                    </li>                
                </ul>
                
                <div class="tab-content">
    
                    <div class="tab-pane active" id="tab-basics">
                    
                        <?php echo $this->renderLayout('Modules/Admin/Views::form_fields/basics.php'); ?>
                        
                        <hr/>
                        
                        <?php echo $this->renderLayout('Admin/Views::form_fields/publication.php'); ?>
                        
                        <hr/>
                        
                        <?php echo $this->renderLayout('Modules/Admin/Views::form_fields/positions.php'); ?>
                        
                        <hr/>
                        
                        <?php echo $this->renderLayout('Modules/Admin/Views::form_fields/ordering.php'); ?>
                        
                        <hr/>
                        
                        <?php echo $this->renderLayout('Modules/Admin/Views::form_fields/admin_description.php'); ?>
                    
                    </div>
                    <!-- /.tab-pane -->
                    
                    <div class="tab-pane" id="tab-display">
                    
                        <?php echo $this->renderLayout('Modules/Admin/Views::form_fields/display.php'); ?>
                                            
                    </div>
                    <!-- /.tab-pane -->
                    
                    <div class="tab-pane" id="tab-conditions">
                    
                        <?php echo $this->renderLayout('Modules/Admin/Views::form_fields/conditions.php'); ?>
                    
                    </div>
                    <!-- /.tab-pane -->                
                                    
                    <div class="tab-pane" id="tab-options">

                        <?php echo $this->renderLayout('Modules/Admin/Views::form_fields/type.php'); ?>
                            
                    </div>
                    
                </div>
        
    
        </div>
    </form>

</div>