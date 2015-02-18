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
