######Valide en date du 16 février 2015
![Header La Grange](http://clients.la-grange.ca/grange/grange_header.jpg "Header La Grange")

###Documentation sur l'utilisation du feed Twitter.
Lorsqu'on utilise l'API de Twitter, il y a deux façon de se connecter. 
On peut donc être connectés en tant qu'utilisateur, ce qui est normalement utilisé 
si on veut que nos utilisateurs puissent poster, ou encore être connectés en tant que
"application-only". Nous utiliserons surement plus souvent cette méthode car elle a l'avantage
d'être transparente et donc de ne pas nécessiter d'action de l'utilisateur pour fonctionner.

Ce dernier mode de connexion nous offre la possibilité de :
* GET les timeline des utilisateurs,
* Accéder aux amis et followers de n'importe quel compte Twitter,
* Accéder aux ressources de certaines listes. Les listes sont des groupes d'utilisateurs,
* Rechercher des tweets, et dans des tweets (par exemple, certains hashtags),
* GET l'information des utilisateurs

En dehors de la connexion, Twitter a une autre façon de limiter notre accès à leur 
contenu : la [limitation de requêtes](https://dev.twitter.com/rest/public/rate-limits) qui n'est pas
super haute pour la plupart des choses. Twitter, nous propose de cacher nos résultats de requêtes et
de ne pas appeler l'API sur le page load. Il y a une possibilité d'être blacklistés si on ne suit pas 
les limites.