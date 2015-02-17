<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Twitter stuff</title>

		<script src="js/vendor/jquery.js"></script>
	</head>
	<body>
		<?php
			require_once('modules/TwitterAPIExchange.php');

			/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
			$settings = array(
			    'oauth_access_token' => "361605925-DWTgPvy3oUWs3vxh0Hxe6WIvF1IOr7xxqLYgPfNp",
			    'oauth_access_token_secret' => "Pl4EaymO8LqKz0wt0nHWJ2phHQiI1LUquu2gMsUhI80cE",
			    'consumer_key' => "7HQco3Slead7bl08BcO1z2tda",
			    'consumer_secret' => "qXVT8aSZXJsFTLdfN4jhO57AdjXPUhQRH0CfYLo5W9sTs3xUpD"
			);

			/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
			$requestMethod = 'GET';
			$getfield = '?screen_name=lagrange_mtl';
			$twitter = new TwitterAPIExchange($settings);
			$twitter->setGetfield($getfield);
			$twitter->buildOauth($url, $requestMethod);
			
			var_dump($twitter);
			
			$response = json_decode($twitter->performRequest());
			var_dump($response);
		?>
	</body>
</html>