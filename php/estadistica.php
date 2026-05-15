<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://root:example@mongo:27017"); //Esborrar linia en cas d'estar en producció
// $client = new MongoDB\Client("mongodb+srv://a25marfajdel_db_user:ProjecteFinal_12345.@cluster0.hmpbtpj.mongodb.net/?appName=Cluster0"); //descomentar en cas d'estar en producció
$collection = $client->local->user_log; //Esborrar linia en cas d'estar en producció
//$collection = $client->accessos->accessos; //descomentar en cas d'estar en producció
$totalaccess = $collection->countDocuments(); //Compta el total de documents


$pagines = $collection->aggregate( [

    [
        '$group' => [
            '_id' => ['$arrayElemAt' => [ ['$split' => ['$URL', '?']], 0 ]],
            'total' => [ '$sum' => 1],
        ]
    ],
    [
        '$sort' => ['total' => -1]
    ],
    [
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
    ]
])->toArray();

$acces_data = $collection->aggregate([
    [
        '$group' =>[
            '_id' => ['$substr' => ['$date', 0, 10]],
            'total' => ['$sum' => 1]
        ]

    ],
    [
        '$sort' => ['_id' => 1]
    ],
    [
        '$project' => [
            '_id' => 0,
            'date' => '$_id',
            'total' => 1
        ]
    ]
])->toArray();

$pagina = $_GET['URL'] ?? '';
$data = $_GET['date'] ?? ''; 


$pipeline = [];

//Afegim els camps: 'dia' sol amb la data, no el temps i uri s'agafa com es afegeix.
$pipeline[] = [
    '$project' => [
        'date' => ['$substr' => ['$date', 0, 10]],
        'URL' => 1
    ]
];
// Creem un array buit que equival al filtre
$filtre = [];

// Si la varibale php data no esta buida, afegim al filtre la condició que el camp "dia" de MongoDB ha de ser igual al valor de $data.
if (!empty($data)) {
    $filtre['date'] = $data;
}

// Si la variable php $pagina no està buida, afegim al filtre la condició que el camp "uri" de MongoDB ha de ser igual al valor de $pagina.
if (!empty($pagina)) {
    $filtre['URL'] = $pagina;
}

// Si el filtre té alguna condició, amb l'etapa $match li diem a MongoDB que només busqui els documents que coincideixin.
if (!empty($filtre)) {
    $pipeline[] = ['$match' => $filtre];
}

// Afegim l'etapa $count al pipeline perquè MongoDB compti quants documents han passat els filtres i guardi el resultat amb el nom "total".
$pipeline[] = ['$count' => 'total'];

// Executem tot el pipeline a MongoDB i guardem tot a $resultat.
$resultat = $collection->aggregate($pipeline);

// Amb el foreach mirem la variable $resultat i agafem el número i posem en una varibale php mostrar-lo a HTML.
$total = 0;
foreach ($resultat as $fila) {
    $total = $fila['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas</title>
    <link rel="stylesheet" href="css/estadistica.css">
</head>

<body>
    <header>
        <h1>Panell d'accés</h1>
    </header>
    <?php include "header2.php" ?>
    <div class="div_principal">
        <div class="filtre">
            <h2>Buscar accessos</h2>
                    <form method="GET">
                        <div>
                            <input type="date" name="date" value="<?= htmlspecialchars($data) ?>">
                            <input type="text" name="URL" placeholder="/inici" value="<?= htmlspecialchars($pagina) ?>">
                            <input type="submit" value="Buscar">
                        </div>
                    </form>

                    <?php if (!empty($data) || !empty($pagina)): ?>
                        <div class="total">
                            <h2>Accessos trobats:</h2>
                            <h2><?= $total ?></h2>
                        </div>
                    <?php else: ?>
                        <p>Introdueix almenys una data o insereix el link.</p>
                    <?php endif; ?>
        </div>
        <div class="div_secundaria">
            <div class="pagines">
                <h2>Pàgines més visitades</h2>
                <?php 
                $totalvisites = $pagines[0]['total'];
                foreach($pagines as $pag):
                    $perc = ($pag['total'] / $totalvisites) * 100;
                    
                ?>
                <div class="pagina_info">
                    <span><?= $pag['URL'] ?></span>
                    <span><?= $pag['total'] ?> visites</span>
                </div>
                <div class="barra_fons">
                    <div class="barra_progress" style="width: <?= $perc ?>%"></div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="resum">
                <h2>Total d'accessos</h2>
                <div>
                    <h1><?= $totalaccess ?></h1>
                </div>
            </div>
        </div>
        <div class="taules"> 
            <div class="taula_individual">

                <h2>Pagines visitades</h2>
                <table border="1"> <!-- Taula de les pàgines visitades i el nombre de visites per cada pàgina -->
                    <tr>
                        <th>URL</th>
                        <th>Visites</th>
                    </tr>
                    
                        <?php foreach($pagines as $pag) {
                            echo "<tr>";
                            echo "<td>" . $pag['URL'] . "</td>";
                            echo "<td>" . $pag['total'] . "</td>";
                            echo "</tr>"; 
                        } ?>
                    
                </table>
            </div>
            <div class="taula_individual">
                <h2>Accessos per dia</h2>
                <table border="1"> <!-- Taula de les hores d'accés a la pàgina -->
                    <tr>
                        <th>Data</th>
                        <th>Total</th>
                    </tr>
                        <?php foreach($acces_data as $data) {
                            echo "<tr>";
                            echo "<td>" . $data['date'] . "</td>";
                            echo "<td>" . $data['total'] . "</td>";
                            echo "</tr>";
                        } ?>
                </table>
            </div>
        </div>
    </div>

    <a href="administrador.php" class="botones" style="margin-top: 20px; display: inline-block;">Inicio</a>

</body>
</html>