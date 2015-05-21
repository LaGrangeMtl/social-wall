######Valide en date du 17 février 2015
![Header La Grange](http://clients.la-grange.ca/grange/grange_header.jpg "Header La Grange")

###Documentation sur l'utilisation de l'API YouTube v3.
Pour utiliser une API propriétaire de Google, il faut se logger dans la [console de développeurs](https://console.developers.google.com/project)
et créer un projet, ainsi que demander une clé d'API pour tous les services demandés. Super simple.

Ensuite dépendamment de si on l'applique au niveau du backend ou du front-end , la manière 
d'appeler l'API change. Google nous demande d'utiliser leurs [bibliothèques clientes](https://developers.google.com/youtube/v3/libraries).

**NB:** En date du 18 février 2015, la librairie **PHP** et la librairie **JavaScript** sont en **_beta_** Ils se peut donc que 
celles-ci changent de manière impromptue.

#Backend (PHP)
On utilise la [librairie PHP](https://developers.google.com/api-client-library/php/start/get_started) de Google. 
Pour l'installation, se fier aux [instructions](https://developers.google.com/api-client-library/php/start/installation).

##GET une liste de vidéos d'un channel
L'API de Google est faite d'une façon un peu différente des REST API habituelles, en tout cas en utilisant 
le "SDK" PHP. Ainsi, on ne peut pas avoir accès aux vidéos d'un channel en faisant une requête du genre 
"videos(channelId=09812082)". En effet, la ressource vidéos correspond à UN vidéo.

Ceci dit, il est possible d'avoir accès aux vidéos d'une chaîne (ce qui est ce que l'on va faire le plus souvent, je présume) 
de la façon suivante (qui plus est ne requiert pas d'authentification) :
```````php
// On inclus la bibliothèque cliente de Google
require_once('modules/google-api-php-client/autoload.php');

// Ensuite on créé un Google_Client et un service, ici on a besoin 
// d'un service Youtube donc on utilise Google_Service_Youtube.
// On lui passe le Google_Client pour que le service puisse faire des
// appels à l'API avec nos credentials
$GClient = new Google_Client();
$GClient->setApplicationName("YOUR_APP_NAME");
$GClient->setDeveloperKey($api_key);

$youtubeAPI = new Google_Service_Youtube($GClient);
``````

Jusqu'ici, c'est un comportement normal pour une API. Ça deviens un peu plus
sinueux a partir d'ici. Une liste de vidéos, peu importe d'où elle viens, dans l'API de YouTube,
ça s'appelle une Playlist. C'est un peu mélangeant, mais c'est ça pareil.

Donc pour avoir les vidéos d'un channel, on doit aller récupérer ses "playlists". Il peut y avoir plusieurs 
playlists par channel, et chaque playlist peut contenir jusqu'à 200 vidéos.
```````php
$channelPlaylistsParams = array('channelId'=>'SOME_CHANNEL_ID');
$channelPlaylists = $youtubeAPI->playlists->listPlaylists('snippet,contentDetails', $channelPlaylistsParams);
``````

Une fois qu'on a les playlist, on pourrait par exemple prendre l'id d'une d'entre elle, et puis aller cherccher
les vidéos de cette playlist là comme ceci:
````````php
$playlist_id = $channelPlaylists[0]->id;

$videoListParams = array('playlistId'=>$playlist_id);
$videoListFromThatPlaylist = $youtubeAPI->playlistItems->listPlaylistItems('snippet,contentDetails', $videoListParams);
````````

Alternativement, on peut retriever une liste de vidéos d'un channel par le Search, avec le paramètre channelId. 
````````php
$searchResponse = $youtubeAPI->search->listSearch('id,snippet', array(
	'channelId' => self::$channelId,
	'maxResults' => $n,
	'order' => 'date'
));
````````

Et puis pour avoir accès aux détails des vidéos :
```````php
var_dump($videoListFromThatPlaylist['modelData']['items']);
``````


