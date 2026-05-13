# Documentació de pipelines
En aquest document, és una informació sobre el les pipelines del fitxer `agregacio.php` que estan implementades per atacar a la base de dades de MongoDB.

Tot el codi que es mostrarà a continuació, estarà documentat linia per linia.


## Pipeline d'URL

La funcionalitat d'aquesta pipeline, és poder **mostrar totes les URL que han accedit tots** els usuaris i la **quantitat de vegades** que s'han accedir cadascuna d'elles.

### GROUP
```
    [
        '$group' => [
            '_id' => '$URL',
            'total' => [ '$sum' => 1],
        ]
    ],
```

Per implementar l'URL que ha accedir l'usuari, hem creat un pipeline on s'agrupa el link de la pàgina com l'ID principal. 

També hem creat una variable "total" que incrementa cada vegada que hi ha un document en la colecció.


### SORT
```'$sort' => ['total' => -1]```

Aqui ordenem la quantitat de documents que hi ha per URL de manera descendent.

### PROJECT
```
'$project' => [
            '_id' => 0,
            'URL' => '$_id',
            'total' => 1
        ] 
```
En la part de project, només mostrarem la URL que ha accedit l'usuari i la quantitat de vegades que s'ha accedit aquell link.

No obstant, no mostrarem l'ID del document.

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