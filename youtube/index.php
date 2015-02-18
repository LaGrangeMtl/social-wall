<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Youtube stuff</title>

		<script src="js/vendor/jquery.js"></script>
	</head>
	<body>
		<?php
			require_once('modules/google-api-php-client/autoload.php');

			$api_key = 'YOUR_API_KEY';

			$GClient = new Google_Client();
			$GClient->setApplicationName("YOUR_APP_NAME");
			$GClient->setDeveloperKey($api_key);

			$youtubeAPI = new Google_youtubeAPI_Youtube($GClient);

			$channelPlaylistsParams = array('channelId'=>'SOME_CHANNEL_ID');
			$channelPlaylists = $youtubeAPI->playlists->listPlaylists('snippet,contentDetails', $channelPlaylistsParams);

			// Mettons qu'on veut avoir juste une "playlist" d'un channel
			$playlist_id = $channelPlaylists[0]->id;

			// Mettons que tu veux voir de quoi ça a l'air une playlist
			echo "Une playlist ça d'l'air de d'ça";
			var_dump($channelPlaylists[0]);

			// Mettons que je veux les vidéos de la playlist
			$videoListParams = array('playlistId'=>$playlist_id);
			$videoListFromThatPlaylist = $youtubeAPI->playlistItems->listPlaylistItems('snippet,contentDetails', $videoListParams);

			// YEAH BOI. Ça a pris toute ça, mais on l'a eu.
			echo "<hr/><br/>La liste des vidéos ça d'l'air de d'ça";
			var_dump($videoListFromThatPlaylist['modelData']['items']);
		?>
	</body>
</html>