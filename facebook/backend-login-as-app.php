<?php
	error_reporting(E_ALL);
	require('modules/facebook/autoload.php');
	use Facebook\FacebookSession;
	use Facebook\FacebookRequest;
	
	// Set up l'applicaiton
	FacebookSession::setDefaultApplication('570240956445444', 'ef9464fd6920eaedbd49ac96f90abc50');

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
		'/1479576005652192/photos/uploaded'
	);
	$response = $request->execute();
	$page_photos = $response->getGraphObject()->asArray()['data'];

	// Doesn't work. Will need to fix this
	/*function getSomethingFromFacebook($node, $edges){
		$path = '/' . $node . '/' . $edges;

		$request = new FacebookRequest(
			$session,
			'GET',
			$path
		);
		$response = $request->execute();
		$result = $response->getGraphObject()->asArray()['data'];

		return $result;
	}

	$page_photos = getSomethingFromFacebook('1479576005652192', 'photos/uploaded');/**/
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