<?php
	require('modules/facebook/autoload.php');
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	
	// Set up l'applicaiton
	FacebookSession::setDefaultApplication('APP_ID', 'APP_SECRET');

	// If you already have a valid access token:
	$session = new FacebookSession('access-token');

	// If you're making app-level requests:
	$session = FacebookSession::newAppSession();

	// To validate the session:
	try {
	  $session->validate();
	} catch (FacebookRequestException $ex) {
	  // Session not valid, Graph API returned an exception with the reason.
	  echo $ex->getMessage();
	} catch (\Exception $ex) {
	  // Graph API returned info, but it may mismatch the current app or have expired.
	  echo $ex->getMessage();
	}

	// GET THEM PHOTOS BOYS
	$request = new FacebookRequest(
		$session,
		'GET',
		'/PAGE_OR_USER_ID/photos/uploaded'
	);
	$response = $request->execute();
	$page_photos = $response->getGraphObject()->asArray()['data'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
	</head>
	<body>
		<?php
			foreach ($page_photos as $photo) {
				$postMarkup = '<div class="post">';
				$postMarkup .= '<p>Photo de ' . $photo->from->name . '</p>';
				$postMarkup .= '<img src="' . $photo->source . '" alt="Wow" /`>';
				$postMarkup .= '<p>' . $photo->name . '</p>';
				$postMarkup .= '</div>';
				
				echo $postMarkup;
			}

		?>
	</body>
</html>