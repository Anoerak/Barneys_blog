<!-- If you're registered, you have access to the form to post a submit a comment -->
<?php if (isset($_SESSION['logged_user'])) : ?>
<section class="comment__add_container">
	<h1>Add a Comment</h1>
	<form action="index.php?page=post&action=add&option=comment&id=<?= $_GET['id'] ?>" method="post"
		enctype="multipart/form-data">
		<div class="form-group">
			<label for="comment">Comment</label>
			<textarea name="comment" class="form-control" id="comment" cols="10" rows="7"></textarea>
		</div>
		<div class="form-buttons">
			<input type="submit" value="Submit" class="purple__button" />
		</div>
	</form>
</section>
<?php endif ?>