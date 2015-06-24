<div class="row">
    <div class="col-md-2">
    
        <h3>Translations</h3>
        <p class="help-block">The following translations exist for this item.</p>
                
    </div>
    <!-- /.col-md-2 -->
                
    <div class="col-md-10">
        
        <?php foreach (\Dsc\Mongo\Collections\Translations\Languages::find() as $language) { ?>
        <div class="list-group-item">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $language->title; ?>
            </div>
            <div class="col-sm-6">
                <?php 
                if (empty($item->language) && $language->code == 'en') 
                {
                    ?>
                    <p>This is the <b><?php echo $language->code; ?></b> translation.
                    <?php                    
                }
                elseif (!empty($item->language) && $language->code == 'en') 
                {
                    if ($translation_source = $item->translationSource()) 
                    {
                        ?>
                        <a href="./admin/module/edit/<?php echo $translation_source->id; ?>" class="btn btn-info">Edit Original</a>
                        <?php 
                    }
                                        
                }
                elseif (!empty($item->language) && $language->code == $item->language) 
                {
                    ?>
                    <p>This is the <b><?php echo $language->code; ?></b> translation.</p>
                    <?php
                }
                elseif (!empty($item) && $translation = $item->translationExists( $language->code ) ) 
                {
                    if ($translation->id != $item->id) 
                    {  
                        ?>
                        <a href="./admin/module/edit/<?php echo $translation->id; ?>" class="btn btn-success">Edit Existing Translation</a>
                        <?php 
                    }
                } 
                else 
                { 
                    ?>
                    <a href="./admin/module/translate/<?php echo $item->id; ?>/<?php echo $language->code; ?>" class="btn btn-warning">Create and Edit New Translation</a>
                    <?php 
                } 
                ?>
            </div>
        </div>
        </div>
        <?php } ?>
    
    </div>
    <!-- /.col-md-10 -->
</div>
<!-- /.row -->