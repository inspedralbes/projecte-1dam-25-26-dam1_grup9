# Documentació de pipelines
En aquest document, és una informació sobre el les pipelines del fitxer `estadistica.php` que estan implementades per atacar a la base de dades de MongoDB.

Tot el codi que es mostrarà a continuació, estarà documentat linia per linia.


## Pipeline d'URL

La funcionalitat d'aquesta pipeline, és poder **mostrar totes les URL que han accedit tots** els usuaris i la **quantitat de vegades** que s'han accedir cadascuna d'elles.

### GROUP
```
    [
        '$group' => [
            '_id' => ['$arrayElemAt' => [ ['$split' => ['$URL', '?']], 0 ]],
            'total' => [ '$sum' => 1],
        ]
    ],
```

Per implementar l'URL que ha accedir l'usuari, hem creat un pipeline on s'agrupa el link de la pàgina com l'ID principal. No obstant, només mostrarà un **UNIC** link. És a dir, quan un usuari accedeix el link per consultar una incidencia i busca per la seva ID, es crea una nou link on serà el mateix però s'afegeix el numero de l'ID i això incrementaria el llistat d'estadistica i només volem veure un unic link per cada apartat

També hem creat una variable "total" que incrementa cada vegada que hi ha un document en la colecció.


### SORT
```'$sort' => ['total' => -1]```

Aqui ordenem la quantitat de documents que hi ha per URL de manera descendent.

### PROJECT
```
'$project' => [
            '_id' => 0,
            'URL' => [
                '$concat' => [
                    '/',
                    [
                        '$arrayElemAt' => [
                            [ '$split' => ['$_id', '/'] ], -1
                        ]
                    ]
                ]
            ],
            'total' => 1
        ] 
```
En la part de project, només mostrarem el nom del fitxer juntament amb una ```/``` que ha accedit l'usuari i la quantitat de vegades que s'ha accedit aquell link.

Però no mostrarem l'ID del document.

## Pipeline de data d'accés
Amb aquesta pipeline, podrem veure la data que ha accedit l'usuari per cada URL.

### GROUP
```
[
        '$group' =>[
            '_id' => ['$substr' => ['$date', 0, 10]]
        ]

    ],
```
En el bloc de group, afegim com ID principal la data que s'ha accedit i el retallem només l'any, mes i el dia.

### SORT
```
[
        '$sort' => ['_id' => 1]
    ]
```
Ordenem la data de manera ascendent (del més nou cap el més antic).

---