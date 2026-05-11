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
$data = $_GET['date'] ?? null; //Obté la data de la consulta, si no existeix, assigna null
$pagina = $_GET['URL'] ?? null; //Obté la pàgina de la consulta, si no existeix, assigna null
$name = $_GET['name'] ?? null; //Obté el nom de la consulta, si no existeix, assigna null
$filtre = [];

if (!empty($data)) {
    $filtre['date'] = $data;
}
if (!empty($pagina)) {
    $filtre['URL'] = $pagina;
}
if (!empty($name)) {
    $filtre['name'] = $name;
}
?>
<!DOCTYPE html>
<html>
    <body>
        <h2>Filtre per Data, Usuari i URL</h2>
        <form action="agregacio.php" method="GET">
            <label for="date">Data:</label>
            <input type="date" id="date" name="date">
            <label for="name">Usuari:</label>
            <input type="text" id="name" name="name">
            <label for="URL">URL:</label>
            <input type="text" id="URL" name="URL">
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
        <h2>Usuaris amb Accés</h2>
        <table border="1">
            <tr>
                <th>Usuari</th>
                <th>Total</th>
            </tr>
            <?php foreach($usuaris as $usuari) { 
                echo "<tr>";
                echo "<td>" . $usuari['name'] . "</td>";
                echo "<td>" . $usuari['total'] . "</td>";
                echo "</tr>";
            } ?>
        </table>

    </body>
</html>