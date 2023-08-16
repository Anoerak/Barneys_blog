<?php session_start(); ?>
<section class="add__post">
	<h1>Update this Post</h1>
	<form class="add__post__form" action="index.php?page=post&action=update" method="post"
		enctype="multipart/form-data">
		<div class="form-group">
			<input type="hidden" name="post_id" id="post_id" value="<?= $datas->id ?>">
			<input type="hidden" name="author_id" id="author_id" value="<?= $_SESSION['user_id'] ?>">
			<input type="hidden" name="origin_title" id="origin_title" value="<?= $datas->title ?>">
			<input type="hidden" name="origin_category" id="origin_category" value="<?= $datas->category ?>">
			<input type="hidden" name="origin_content" id="origin_content" value="<?= $datas->content ?>">
			<label for="title">Title</label>
			<input type="text" class="add__title__input" id="title" name="title" placeholder="<?= $datas->title ?>">
			<label for="category">Category</label>
			<select class="add__category__select" id="category" name="category">
				<option value=""><?= $datas->category ?></option>
				<option value="Career">Career</option>
				<option value="Dating">Dating</option>
				<option value="Food">Food</option>
				<option value="Life">Life</option>
				<option value="Tech">Tech</option>
				<option value="Travel">Travel</option>
			</select>
			<img src=" <?= $datas->picture ?>" alt="post_picture">
			<label for="image">
				<input type="file" class="add__picture__input" id="post_picture" name="post_picture"
					accept=".jpeg, .jpg, .png, gif">
			</label>
			<label for="content">Content</label>
			<textarea class="form-control" id="add__content_textarea" name="content" rows="10" cols="80"
				placeholder="<?= $datas->content ?>"></textarea>
		</div>
		<div class="add__validation__area">
			<button type="submit" class="purple__button">Submit</button>
			<button type="reset" class="delete__button">Reset</button>
		</div>
	</form>
</section>