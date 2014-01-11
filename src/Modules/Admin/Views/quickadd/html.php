<form class="form-horizontal" action="./admin/menu" method="post">
    <p class="">
		<label for="link-text" class="control-label">Title</label>
		<input type="text" class="form-control" id="link-title"
				placeholder="Title of Menu Item" name="title">
	</p>
	<p class="">
		<label for="link-content" class="control-label">Content</label>
		<textarea name="details[content]" class="form-control" placeholder="Insert HTML Here" rows="5"></textarea>
	</p>
	<p class="">
		<button type="submit" class="btn btn-default">Add to Menu</button>
		<input type="hidden" name="tree" value="<?php echo $tree; ?>" />
		<input type="hidden" name="details[type]" value="module-html" />
	</p>
</form>