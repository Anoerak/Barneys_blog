<?php if (!isset($_SESSION)) {
	session_start();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://kit.fontawesome.com/89ed478db9.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="../src/lib/style/style.css">
	<title><?= $title ?></title>
</head>

<body>
	<?php require 'templates/components/header/header.php'; ?>
	<main>
		<?= $content ?>
		<!-- Élément spécifique -->
	</main>
	<?php include 'templates/components/footer/footer.php'; ?>
</body>


</html>