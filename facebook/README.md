######Valide en date du 13 février 2015 jusqu'en octobre 2017

###Documentation sur l'utilisation du feed Facebook.
Pour pouvoir utiliser le feed Facebook, il faudra utiliser une app. Pour cela,
on doit se rendre sur [developpers.facebook.com](http://developpers.facebook.com) et utiliser
un compte développeur. Il est important de bien configurer les addresses permisent par l'app.

Ainsi, pour pouvoir utiliser les features social de Facebook sur le site **exemple.ca**, il faudra 
donner à l'app cette adresse dans les champs **Website** du menu **Settings**. Facebook supporte le 
CORS bien sur et donc on peut développer en local en donnant à un des deux champs la valeur suivante : 
**http://localhost**

#Back-End
Normalement quand on passe par le back-end c'est parce qu'on veut pas que ce soit un user qui soit loggé 
dans notre application. Comme on veut que ce soit le site web qui y soit, il faut se logger en tant qu'app.
Ceci requiert l'utilisation d'un **app-id** et d'un **app-secret**. L'**app-secret** ne doit JAMAIS être passé 
au front-end.

**Important de noter, pour utiliser les classes facebook on doit spécifier lesquelles on utilise, sinon on a droit à une erreur 500**
````````php
require('modules/facebook/autoload.php');
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
````````

###Connexion
Pour connecter l'application, rien de plus simple :
````````php
// Set up l'applicaiton
FacebookSession::setDefaultApplication('app-id', 'app-secret');

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
```````

###Prendre de l'information
Une fois connectés, on peut faire une requête aux serveurs de facebook. Les requêtes suivent 
la syntaxe REST et retournent un objet requête qui contient un GraphObject. Celui-ci contient les 
infos demandées sous la propriété 'data'.
``````php
$request = new FacebookRequest(
	$session,
	'GET',
	'/{node}/{edge}/{sublevel_edge}'
);
$response = $request->execute();
$result = $response->getGraphObject()->asArray()['data'];
``````

Par exemple si on voudrait aller chercher les photos qu'une page a uploadées, le path serait construit
ainsi : 
```````php
'/ID_DE_LA_PAGE/photos/uploaded'
```````

Si notre application a des droits de publication sur une page, ou un compte quelconque, on peut aussi publier
sur Facebook d'une façon très semblable. Dans le cas d'un lien, par exemple :
``````php
$request = new FacebookRequest(
	$session,
	'POST',
	'/me/feed',
	array(
		'link' => 'www.example.com',
		'message' => 'User provided message'
	)
);
$response = $request->execute();
$result = $response->getGraphObject();
``````
**À noter que le champ 'message' doit être rempli par le user, d'une façon ou d'une autre pour remplir les 
conditions légales de Facebook** 


On peut voir un exemple [ici](backend-login-as-app.php)


#Front-End
À venir