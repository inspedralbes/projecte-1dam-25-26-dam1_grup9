<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://root:example@mongo:27017");

$collection = $client->local->user_log;

$totalaccess = $collection->countDocuments(); //Compta el total de documents


$pagines = $collection->aggregate( [

    [
        '$group' => [
            '_id' => '$URL',
            'total' => [ '$sum' => 1],
        ]
    ],
    [
        '$sort' => ['total' => -1]
    ],
    [
        '$project' => [
            '_id' => 0,
            'URL' => '$_id',
            'total' => 1
        ]
    ]
]);

$acces_data = $collection->aggregate([
    [
        '$group' =>[
            '_id' => ['$substr' => ['$date', 0, 10]]
        ]

    ],
    [
        '$sort' => ['_id' => 1]
    ]
]);

$usuaris = $collection->aggregate([
    [
        '$group' => [
            '_id' => '$name',
            'total' => ['$sum' => 1]
        ]
    ],
    [
        '$project' =>[
            '_id' => 0,
            'name' => '$_id',
            'total' => 1
        ]
    ]
]);
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
    <body>
        <h2>Buscar accessos</h2>
                <form method="GET" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($data) ?>">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="URL" class="form-control" placeholder="/inici" value="<?= htmlspecialchars($pagina) ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark w-100">Buscar</button>
                            
                        </div>
                    </div>
                </form>

                <?php if (!empty($data) || !empty($pagina)): ?>
                    <div class="alert alert-light border text-center">
                        <p class="mb-0 text-muted small">Accessos trobats</p>
                        <div class="text-total"><?= $total ?></div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Introdueix almenys una data o insereix tot el link.</p>
                <?php endif; ?>
        <h2>Pagines visitades</h2> 
        <table border="1"> <!-- Taula de les pàgines visitades i el nombre de visites per cada pàgina -->
            <tr>
                <th>URL</th>
                <th>Total</th>
            </tr>
            
                <?php foreach($pagines as $pag) {
                    echo "<tr>";
                    echo "<td>" . $pag['URL'] . "</td>";
                    echo "<td>" . $pag['total'] . "</td>";
                    echo "</tr>"; 
                } ?>
            
        </table>


        <h2>Data d'acces</h2>
        <table border="1"> <!-- Taula de les hores d'accés a la pàgina -->
            <tr>
                <th>Data</th>
            </tr>
                <?php foreach($acces_data as $data) {
                    echo "<tr>";
                    echo "<td>" . $data['_id'] . "</td>";
                    echo "</tr>";
                } ?>
        </table>

        
    </body>
</html>