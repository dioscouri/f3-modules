<script src="./ckeditor/ckeditor.js"></script>
<script>
jQuery(document).ready(function(){
    CKEDITOR.replaceAll( 'wysiwyg' );    
});
</script>

<p class="">
    <label for="link-content" class="control-label">Content</label>
    <textarea name="details[content]" class="wysiwyg form-control" placeholder="Insert HTML Here" rows="5" ><?php echo htmlspecialchars( $item->{'details.content'} ); ?></textarea>
</p>