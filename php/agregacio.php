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
            '_id' => '$date'
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

$pipeline[] = [
    '$project' => [
        'URL' => 1,
        'date' => ['$substr' => ['$date', 0, 10]]
    ]
];

$filtre = [];
if (!empty($data)) {
    $filtre['date'] = $data;
}
if (!empty($pagina)) {
    $filtre['URL'] = $pagina;
}

if (!empty($filtre)){
    $pipeline[] = [
        '$match' => $filtre
    ];
}

$resultat = $collection->aggregate($pipeline);
?>
<!DOCTYPE html>
<html>
    <?php if (!$filtre): ?> <!-- Mostra totes les taules en cas de que el filtre no s'hagi aplicat -->
        <body>
            <h2>Filtre per Data, Usuari i URL</h2>
            <form action="agregacio.php" method="GET">
                <label for="date">Data:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($data); ?>">
                <!--<label for="name">Usuari:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"> -->
                <label for="URL">URL:</label>
                <input type="text" id="URL" name="URL" value="<?php echo htmlspecialchars($pagina); ?>">
                <input type="submit" value="Filtrar">
            </form>
            <h2>Pagines visitades</h2>
            <table border="1">
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

            <br>
            <h2>Hora d'accés</h2> 
            <table border="1">
                <tr>
                    <th>Hora</th>
                </tr>
                <?php foreach($acces_data as $data) { 
                    echo "<tr>";
                    echo "<td>" . $data['_id'] . "</td>";
                    echo "</tr>";
                } ?>
            </table>

            <br>
            <!--<h2>Usuaris amb Accés</h2>
            <table border="1">
                <tr>
                    <th>Usuari</th>
                    <th>Total</th>
                </tr>
                <?php foreach($usuaris as $usuari) { 
                    //echo "<tr>";
                    //echo "<td>" . $usuari['name'] . "</td>";
                    //echo "<td>" . $usuari['total'] . "</td>";
                    //echo "</tr>";
                } ?>
            </table> -->
        <?php else: ?> <!-- Mostrar el resultat dels filtres aplicats -->
            <body>
            <h2>Filtre per Data, Usuari i URL</h2>
            <form action="agregacio.php" method="GET">
                <label for="date">Data:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($data); ?>">
                <!--<label for="name">Usuari:</label>
                <input type="text" id="name" name="name" value=">
                -->
                <label for="URL">URL:</label>
                <input type="text" id="URL" name="URL" value="<?php echo htmlspecialchars($pagina); ?>">
                <input type="submit" value="Filtrar">
            </form>
            <h2>Resultats de la consulta</h2>
            <table border="1">
                <tr>
                    <th>URL</th>
                    <!--<th>Name</th>-->
                    <th>Date</th>
                </tr>
                <?php foreach($resultat as $res) { 
                    echo "<tr>";
                    echo "<td>" . $res['URL'] . "</td>";
                    //echo "<td>" . $res['name'] . "</td>";
                    echo "<td>" . $res['date'] . "</td>";
                    echo "</tr>";
                } ?>
            </table>
        <?php endif; ?>
    </body>
</html>