<header>
	<a href="index.php">
		<img src="../../public/img/logo.png" alt="Logo_violet_background_white_text_The_awesome_blog">
		<p>by Barney</p>
	</a>

	<nav>
		<ul>
			<li>
				<a class="
				{# if $_GET['page'] is undefined #}
				<?php if (!isset($_GET['page'])) : ?>
						active
					<?php endif ?>" href="index.php">
					<i class="fa-solid fa-house"></i>
					Home
				</a>
			</li>
			<li>
				<a class="
				<?php if (isset($_GET['page']) && $_GET['page'] === 'blog') : ?>
						active
					<?php endif ?>" href="index.php?page=blog&option=all">
					<i class="fa-solid fa-signs-post"></i>
					Blog
				</a>
			</li>
			<li>
				<a class="<?php if (isset($_GET['page']) && $_GET['page'] === 'about') : ?>active<?php endif ?>"
					href="index.php?page=about">
					<i class="fa-solid fa-circle-info"></i>
					About
				</a>
			</li>
			<li>
				<a class="<?php if (isset($_GET['page']) && $_GET['page'] === 'contact') : ?>active<?php endif ?>"
					href="index.php?page=contact">
					<i class="fa-regular fa-comment"></i>
					Contact
				</a>
			</li>
	</nav>


	<?php if (!isset($_SESSION['logged_user'])) : ?>
	<div class="login_up__section">
		<a href="index.php?page=login">
			<button class="login">
				Log in
			</button>
		</a>
		<a href="index.php?page=signup">
			<button class="signup">
				Sign up
			</button>
		</a>
	</div>
	<?php else : ?>
	<div class="logged_in__section">
		<a class="mini__profile__container"
			href="index.php?page=userProfile&action=get&option=user&id=<?= $_SESSION['user_id'] ?>">
			<img src="<?= $_SESSION['profile_picture'] ?>" alt="profile_picture">
			<p><?= $_SESSION['username'] ?></p>
		</a>
		<a href="index.php?page=login&action=logOut&option=userConnection">
			<button class="signup">
				Log out
			</button>
		</a>
	</div>
	<?php endif; ?>
</header>