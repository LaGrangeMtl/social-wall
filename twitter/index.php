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
			    'oauth_access_token' => "YOUR_ACCESS_TOKEN",
			    'oauth_access_token_secret' => "YOUR_ACCESS_TOKEN_SECRET",
			    'consumer_key' => "YOUR_CONSUMER_KEY",
			    'consumer_secret' => "YOUR_CONSUMER_SECRET"
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