<section class="signup__container">
	<h1>Sign Up</h1>

	<div class="signup__form">
		<form action="index.php?page=signup&action=create&option=user&id=none" method="post">
			<label for="username">Name</label>
			<input type="text" name="username" placeholder="username">

			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Email">

			<label for="password">Password</label>
			<input type="password" name="password" placeholder="Password">

			<label for="passwordCheck">Confirm Password</label>
			<input type="password" name="passwordCheck" placeholder="Confirm Password">

			<input type="submit" value="Sign Up" class="purple__button">
		</form>
	</div>
</section>