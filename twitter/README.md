######Valide en date du 16 février 2015
![Header La Grange](http://clients.la-grange.ca/grange/grange_header.jpg "Header La Grange")

###Documentation sur l'utilisation du feed Twitter.
Lorsqu'on utilise l'API de Twitter, il y a deux façon de se connecter. 
On peut donc être connectés en tant qu'utilisateur, ce qui est normalement utilisé 
si on veut que nos utilisateurs puissent poster, ou encore être connectés en tant que
**"application-only"**. Nous utiliserons surement plus souvent cette méthode car elle a l'avantage
d'être transparente et donc de ne pas nécessiter d'action de l'utilisateur pour fonctionner.

Ce dernier mode de connexion nous offre la possibilité de :
* GET les timeline des utilisateurs,
* Accéder aux amis et followers de n'importe quel compte Twitter,
* Accéder aux ressources de certaines listes. Les listes sont des groupes d'utilisateurs,
* Rechercher des tweets, et dans des tweets (par exemple, certains hashtags),
* GET l'information des utilisateurs

**Il faut par contre noter que cette méthode de connexion nécessite l'utilisation d'SSL et donc
requiert un certificat de sécurité et un site HTTPS.**

En dehors de la connexion, Twitter a une autre façon de limiter notre accès à leur 
contenu : la [limitation de requêtes](https://dev.twitter.com/rest/public/rate-limits) qui n'est pas
super haute pour la plupart des choses. Twitter, nous propose de cacher nos résultats de requêtes et
de ne pas appeler l'API sur le page load. Il y a une possibilité d'être blacklistés si on ne suit pas 
les limites.

#Backend
Twitter recommande fortement d'utiliser des [librairies](https://dev.twitter.com/overview/api/twitter-libraries) 
pour communiquer avec leurs serveurs dont une qui selon mes recherches a de bonnes review et fonctionne avec 
l'API v1.1 de Twitter : [twitter-api-php](https://github.com/J7mbo/twitter-api-php). Le fonctionnement est bien 
expliqué dans le README ou encore sur [stackoverflow](http://stackoverflow.com/questions/12916539/simplest-php-example-for-retrieving-user-timeline-with-twitter-api-version-1-1/15314662#15314662).

Voici donc un exemple simple pour **GET** une ressource :

`````php
//On require la librairie et on ajuste les settings pour fitter notre app
require_once('modules/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "YOUR_ACCESS_TOKEN",
    'oauth_access_token_secret' => "YOUR_ACCESS_TOKEN_SECRET",
    'consumer_key' => "YOUR_CONSUMER_KEY",
    'consumer_secret' => "YOUR_CONSUMER_SECRET"
);
`````
Ensuite on détermine quelle ressource on veut. Voici la [liste](https://dev.twitter.com/rest/public) des ressources 
disponibles et de leurs options. Ici on veut la timeline d'un certain utilisateur. Les options sont passés dans la
variable $getfield.
````````php
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$requestMethod = 'GET';
$getfield = '?screen_name=lagrange_mtl';
$twitter = new TwitterAPIExchange($settings);
````````

Il ne reste plus qu'à passer passer la requête et la décoder (elle est retournée en JSON, on pourrait donc la passer à du Javascript directement)
`````php
$twitter->setGetfield($getfield);
$twitter->buildOauth($url, $requestMethod);
$response = json_decode($twitter->performRequest());
`````
Il est important de noter que **pour que les requêtes fonctionnent en local**, il faut **désactiver SSL** car nos 
serveurs WAMP/XAMPP/etc. n'ont pas de certificats. Pour ce faire, dans la librairie TwitterAPIExchange, il faut setter 
**CURLOPT_SSL_VERIFYPEER => false** dans la fonction performRequest :
```````php
public function performRequest($return = true){
        if (!is_bool($return)) 
        { 
            throw new Exception('performRequest parameter must be true or false'); 
        }
        
        $header = array($this->buildAuthorizationHeader($this->oauth), 'Expect:');
        
        $getfield = $this->getGetfield();
        $postfields = $this->getPostfields();

        $options = array( 
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false, // IL FAUT AJOUTER/METTRE CETTE LIGNE À FALSE
            CURLOPT_TIMEOUT => 10,
        );
```````
**ATTENTION** : il faut bien entendu la remettre à true lorsqu'on tombe en prod

Il y a un exemple fonctionnel dans [index.php](index.php). 