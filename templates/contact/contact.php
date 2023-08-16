<section class="contact__container">
	<h1>Contact</h1>
	<div class="contact__form">
		<form action="index.php?page=contact&action=send" method="post">
			<label for="name">Name</label>
			<input type="text" name="contactName" placeholder="Name">

			<label for="email">Email</label>
			<input type="email" name="contactEmail" placeholder="Email">

			<label for="subject">Subject</label>
			<input type="text" name="contactSubject" placeholder="Subject">

			<label for="message">Message</label>
			<textarea name="contactMessage" placeholder="Message" cols="10" rows="15"></textarea>

			<input type="submit" value="Send" class="purple__button">
		</form>
	</div>
</section>