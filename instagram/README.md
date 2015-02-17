######Valide en date du 17 février 2015
![Header La Grange](http://clients.la-grange.ca/grange/grange_header.jpg "Header La Grange")

###Documentation sur l'utilisation de l'API Instagram.
Pour faciliter l'usage de l'API d'Instagram, on utilise depuis 1 an environ une [librairie](https://github.com/cosenary/Instagram-PHP-API).
Celle ci nous permet d'accéder aux ressources publiques mais aussi de faire des requêtes qui nécécessite 
l'authentification d'un utilisateur.

Comme Facebook et Twitter par exemple, il faut avoir une "app" pour pouvoir accéder à des données. Sur 
Instagram, on parle alors de **client**. Les settings de developpeurs sont disponibles à partir d'[ici](http://instagram.com/developer).

#Backend
Pour avoir accès à l'API d'Instagram, rien de plus simple avec la librairie de Cosenary.

Par exemple si on veut logger un utilisateur, ce qui nous permetterait d'avoir accès à des données privées
ou encore de soumettre des photos/modifier du contenu en son nom :
```````php
require_once 'Instagram.php';
use MetzWeb\Instagram\Instagram;

$instagram = new Instagram(array(
  'apiKey'      => 'YOUR_APP_KEY',
  'apiSecret'   => 'YOUR_APP_SECRET',
  'apiCallback' => 'YOUR_APP_CALLBACK'
));

echo "<a href='{$instagram->getLoginUrl()}'>Login with Instagram</a>";
```````

Ensuite on s'authentifie avec OAuth2 :
```````php
// grab OAuth callback code
$code = $_GET['code'];
$data = $instagram->getOAuthToken($code);

echo 'Your username is: ' . $data->user->username;
``````

Ensuite on a accès aux données privées de l'utilisateur comme ceci :
```````php
// set user access token
$instagram->setAccessToken($data);

// get all user likes
$likes = $instagram->getUserLikes();

// take a look at the API response
echo '<pre>';
print_r($likes);
echo '<pre>';
``````

Si par contre on veut seulement accéder à ce qui est public, on a pas besoin
d'authentifier un utilisateur. On peut s'authentifier en tant qu'application comme ceci:
``````php
new Instagram('CLIENT_ID');
``````
En utilisant cette dernière méthode, on n'a pas besoin d'access token, mais nos actions sont 
limitées dans l'API.

Pour plus d'informations sur les méthodes applicables par la librairie, voir [ici](https://github.com/cosenary/Instagram-PHP-API#available-methods).

Comme toujours, il y a un [exemple](index.php) disponible.