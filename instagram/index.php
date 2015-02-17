<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Instagram stuff</title>

		<script src="js/vendor/jquery.js"></script>
	</head>
	<body>
		<?php
			require_once('modules/Instagram.php');
			use MetzWeb\Instagram\Instagram;

			$instagram = new Instagram('f00a70fac104414486936cee8cf1b048');
			$some_user_id = 346926040;
			
			$userData = $instagram->getUser($some_user_id);

			var_dump($userData);
		?>
	</body>
</html>