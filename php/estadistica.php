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
<head>
    <title>Estadísticas</title>
</head>

<style>
    header {
        background: linear-gradient(to right, #23e2c2, #6a8bf0);
        color: white;
        padding: 20px;
        font-family: Arial;
        text-align: center;
    }
    body {
        font-family: Arial;
    }
    body .div_principal {
        margin-top: 20px;
        align-items: center;
        display: flex;
        flex-direction: column;
    }
    form{
        width: 35%;
        background: #d4d2d2;
        padding: 20px;
        border-radius: 5px;
    }
    input[type=date], input[type=text] {
        padding: 10px;
        margin-right: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    input[type=submit]{
        padding: 10px 15px;
        background-color: #4327e2;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        border-radius: 5px;
    }
    input[type=submit]:hover {
        background-color: #7ae6dd;
    }

    table {
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid black;
        padding: 5px;
    }

    th {
        background: #8270e7;
        color: white;
    }

    textarea {
        width: 50%;
        margin: 5px;
    }

    .botones {
        padding: 10px 15px;
        background: #4327e2;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
        border-radius: 5px;
    }

    .botones:hover {
        background: #7ae6dd;
    }
    .uno {
       text-align: center;
    }
    fieldset {
        margin: 20px auto;
        width: 50%;
        border: 5px solid #fd0707;
        padding: 2px;
        border-radius: 5px;
    }
    .div_principal{
        width: 80%;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0,0.1,0.1,0.5);
        border-radius: 5px;
        border: 1px solid #ccc;
        margin: 0 auto;
    }
    .taula_individual {
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        margin: 20px auto;
        width: 50%;
        display: flex;
        flex-direction: column;
        background-color: #e6e6e6;
    }
    .taules{
        display: flex;
        gap: 30px
        flex-direction: flex-start;
    }
    .taules div{
        margin-left: 20px;
        margin-right: 30px;
    }
    .taules h2{
        text-align: center;
    }
    .total{
        border: 1px solid #ccc;
        padding: 10px;
        width: 25%;
        border-radius: 5px;
        text-align: center;
        margin: 20px auto;
        font-family: Arial;
    }
    .taules .resum{
        display: flex;
        flex-direction: row
    }
    .resum{
        text-align: center;
        margin: 20px auto;
        float: left;
        width: 320px;
        background: #ececec;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }
    .filtre{
        display: flex;
        flex-direction: column;
        background-color: #e6e6e6;
        float:top;
        border-radius: 5px;
        border: 1px solid #ccc;
        text-align: center;
        width: 100%;
        align-items: center;
    }
    tr:nth-child(even){background-color: #95c3ff}
</style>

<body>
    <header>
        <h1>Panell d'accés</h1>
    </header>
    <?php include "header2.php" ?>
    <div class="div_principal">
        <div class="filtre">
            <h2>Buscar accessos</h2>
                    <form method="GET" class="mb-3">
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
                        <p>Introdueix almenys una data o insereix tot el link.</p>
                    <?php endif; ?>
        </div>
        <div class="resum">
            <h2>Resum</h2>
            <p>Total accessos: <?= $totalaccess ?></p>

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