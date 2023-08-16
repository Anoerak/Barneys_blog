<section class="user__profile__container">
	<h1>User Profile</h1>

	<div class="user__profile__container__content">
		<form action="index.php?page=userProfile&action=update&option=user&id=<?= $_SESSION['user_id'] ?>" method="post"
			enctype="multipart/form-data">
			<input type="hidden" name="page" value="userProfile">
			<input type="hidden" name="action" value="update">
			<input type="hidden" name="option" value="user">
			<input type="hidden" name="id" value="<?= $_SESSION['user_id'] ?>">
			<div class="user__profile__container__content__top">
				<div class="user__profile__container__content__avatar">
					<img src="<?= $_SESSION['profile_picture'] ?>" alt="Avatar">
					<input type="file" name="profile_picture" id="profile_picture" accept=".jpeg, .jpg, .png">
				</div>
				<div class="user__profile__container__username">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" placeholder="<?= $_SESSION['username'] ?>">
				</div>
				<div class="user__profile__container__firstname">
					<label for="firstname">First Name</label>
					<input type="text" name="firstname" id="firstname" placeholder="<?= $_SESSION['firstname'] ?>">
				</div>
				<div class="user__profile__container__lastname">
					<label for="lastname">Last Name</label>
					<input type="text" name="lastname" id="lastname" placeholder="<?= $_SESSION['lastname'] ?>">
				</div>
				<div class="user__profile__container__email">
					<label for="email">Email</label>
					<input type="email" name="email" id="email" placeholder="<?= $_SESSION['email'] ?>">
				</div>
				<div class="user__profile__container__birthday">
					<label for="birthday">Birthday</label>
					<input type="text" name="birthday" id="birthday" onfocus="(this.type='date')"
						placeholder="<?= $_SESSION['birthday'] ?>">
				</div>
				<div class="user__profile__container__password">
					<label for="currentPassword">Current Password</label>
					<input type="password" name="currentPassword" id="currentPassword" placeholder="**********">
				</div>
				<div class="user__profile__container__password">
					<label for="newPassword">New Password</label>
					<input type="password" name="newPassword" id="newPassword" placeholder="**********">
				</div>
				<div class="user__profile__container__password">
					<label for="passwordCheck">Confirm Password</label>
					<input type="password" name="passwordCheck" id="passwordCheck" placeholder="**********">
				</div>
				<div class="action__container">
					<input class="purple__button update__user" type="submit" value="Update">
					<input class="delete__button delete__user" type="submit" value="Delete"
						formaction="index.php?page=userProfile&action=delete&option=user&id=<?= $_SESSION['user_id'] ?>">
				</div>
			</div>
		</form>
		<div class="user__profile__container__content__bottom">
			<h2>Newsletter</h2>
			<div class="user__profile__container__content__newsletter">
				<div class="newsletter__container">
					<p>Subscribe to our newsletter to receive the latest news from our blog.</p>
					<form action="index.php?page=newsletter&action=subscribe" method="post">
						<input type="hidden" name="action" value="subscribe">
						<input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
						<input class="purple__button" type="submit" value="Subscribe"
							<?php if ($_SESSION['newsletter'] === 'active') : ?> disabled <?php endif; ?>>
					</form>
				</div>
				<div class="newsletter__container">
					<p>Unsubscribe to our newsletter to stop receiving the latest news from our blog.</p>
					<form action="index.php?page=newsletter&action=unsubscribe" method="post">
						<input type="hidden" name="action" value="unsubscribe">
						<input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
						<input class="delete__button" type="submit" value="Unsubscribe"
							<?php if ($_SESSION['newsletter'] === 'inactive') : ?> disabled <?php endif; ?>>
					</form>
				</div>
			</div>
		</div>
</section>