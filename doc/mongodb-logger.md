# Documentació de Logger
En aquest document, trobaràs la informació sobre el funcionament del registre de dades i els paràmetres del fitxer que està implementat per atacar a la base de dades de MongoDB per desar els logs de l'aplicació.

Tot el codi que es mostrarà a continuació, estarà documentat línia per línia per entendre com es capturen i es guarden les dades.


## Connexió a la Base de Dades (MongoDB)

La funcionalitat d'aquest bloc és establir la connexió amb el servidor de MongoDB, diferenciant si estem treballant en l'entorn de desenvolupament local o a l'entorn de producció.

```php
require 'vendor/autoload.php';

\$client = new MongoDB\Client("mongodb://root:example@mongo:27017"); //Esborrar linia en cas d'estar en producció
// \$client = new MongoDB\Client("mongodb+srv://a25marfajdel_db_user:ProjecteFinal_12345.@cluster0.hmpbtpj.mongodb.net/?appName=Cluster0"); //descomentar en cas d'estar en producció
\(collection =\)client->local->user_log; //Esborrar linia en cas d'estar en producció
//\(collection =\)client->accessos->accessos; //descomentar en cas d'estar en producció
```

Primer de tot carreguem l'autoloader de Composer per poder utilitzar la llibreria de MongoDB. 

Després creem la connexió. Com es pot veure, tenim dues opcions comentades:
* **En local:** Ataquem a la base de dades `local` i a la col·lecció `user_log` connectant a través del contenidor de Docker (`mongo:27017`).
* **En producció:** Descomentarem la línia de MongoDB Atlas per desar les dades a la base de dades `accessos` dins de la col·lecció `accessos`.


## Captura de dades de la petició HTTP

Amb aquest bloc de codi, capturem totes les variables del servidor i del navegador de l'usuari que fa la petició per saber des d'on entra i què està fent.

```php
\$protocol = isset(\(_SERVER['HTTPS']) &&\)_SERVER['HTTPS'] === 'on' ? "https" : "http";

\(host =\)_SERVER['HTTP_HOST']; //obté el domini
\(uri =\)_SERVER['REQUEST_URI']; //obté l'URI
\(ip =\)_SERVER['REMOTE_ADDR'] ?? 'unknown'; //Obté la IP de l'usuari
\$hora = date("Y-m-d");
\(method =\)_SERVER['REQUEST_METHOD']; //Obté le metode que està fent l'usuari
```

Aquí definim les variables que guardarem:
* **Protocol:** Mirem si la connexió és segura o no (`https` o `http`).
* **Host i URI:** Guardem el domini de la web i la ruta de la pàgina exacta on ha entrat.
* **IP d'origen:** Fem servir l'operador `??`. Això vol dir que si per algun motiu no podem obtenir la IP de l'usuari a través de `REMOTE_ADDR`, de manera automàtica es guardarà el text `'unknown'` com a valor per defecte per evitar errors.
* **Hora:** Retallem i guardem el dia actual del servidor amb el format d'Any-Mes-Dia.
* **Mètode:** Guardem quin tipus d'acció està fent (per exemple `GET` si només visita la pàgina o `POST` si envia un formulari).


## Inserció del Log a MongoDB (Escriptura)

La funcionalitat d'aquesta part és agafar totes les dades recollides anteriorment i introduir-les dins de la nostra col·lecció en format de document.

```php
\(resultat =\)collection->insertOne([
    'URL' => \$uri,
    'name' => 'Anonim',
    'Metode' => \$method,
    'ip_origin' => \$ip,
    'date' => \$hora
]);
\(userId=\)resultat->getInsertedId(); //Consegueix l'usuari ID
```

Executem la funció `insertOne()` passant-li un array amb l'estructura de camps que volem que tinguin els nostres logs a la base de dades. Com que encara no tenim un sistema de logueig d'usuaris per nom, fiquem per defecte el text `'Anonim'` al camp `name`.

Finalment, creem la variable `$userId` que serveix per recuperar i saber quin ha estat l'ID únic (`_id`) que MongoDB li ha assignat a aquest registre de manera automàtica.


## Consulta de l'històric de Logs (Lectura)

L'última part de l'script serveix per extreure la informació que tenim emmagatzemada.

```php
// \(collection =\)client->demo->users; #no cal, ja que ho hem fet abans
\(documents =\)collection->find();
```

Com diu el comentari, no cal tornar a definir la col·lecció perquè ja ho hem fet a l'inici del fitxer. Executem la funció `find()` sense cap filtre per obtenir absolutament tots els documents de registre que s'han guardat fins ara i poder-los processar o llistar més endavant.
