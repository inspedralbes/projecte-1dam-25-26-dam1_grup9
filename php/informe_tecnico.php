<?php
session_start();

require_once "connexion.php";
include_once "logger.php";

if (!isset($_SESSION['tecnic_id'])) {
    header("Location: elegir_tecnico.php");
    exit();
}
$id_seleccionat = $_SESSION['tecnic_id'];

$sql = ("SELECT t.nom AS tecnic, i.id AS incidencia, i.data_obertura, i.prioritat, COALESCE(SUM(a.temps), 0) AS temps_total
    FROM tecnics t
    JOIN incidencies i ON i.tecnic_id = t.id
    LEFT JOIN actuacions a ON a.incidencia_id = i.id
    WHERE i.resolta = 0 AND t.id = ?
    GROUP BY i.id, t.nom, i.data_obertura, i.prioritat
    ORDER BY t.nom, 
            CASE i.prioritat
                WHEN 'Alta' THEN 1
                WHEN 'Mitja' THEN 2
                WHEN 'Baixa' THEN 3
            END
");

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_seleccionat);
$stmt->execute();

$res = $stmt->get_result();
$data = $res->fetch_all(MYSQLI_ASSOC);

$result = [];

foreach ($data as $row) {
    $nom = $row['tecnic'];
    $result[$row['tecnic']][$row['prioritat']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Informe de Tècnics</title>

<style>
    header {
        text-align: center;
        padding: 10px 20px;
        background: linear-gradient(90deg, #4b6cb7, #182848);
        color: white;
        font-size : 24px;
    }
    h3 {
        margin-top: 30px;
        font-family: Arial;
    }

    table {
        
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
        font-family: Arial;
    }

    th {
        background: #7779f0;
        color: white;
        font-family: Arial;
    }
    .botones {
        padding: 10px 20px;
        background-color: #2d59e9;
        text-decoration: none;
        color: white;
        font-family: Arial;
        
    }
    .botones:hover {
        background-color: #55a5da;
    }

</style>
</head>

<body>

<div >

    <header>
        <h2>Informe</h2>
    </header>
    <?php include "header2.php" ?>

    <?php if (empty($result)): ?>
        <p>No hi ha incidències obertes actualment.</p>
    <?php endif; ?>

    <?php foreach ($result as $tecnic => $prioritats): ?>

        <h3>TÈCNIC ENCARREGAT: <span style="color: #2a04ff ;"><?= htmlspecialchars($nom) ?></span></h3>

       
            <table>
                <tr>
                    <th>Incidència</th>
                    <th>Data inici</th>
                    <th>Temps total</th>
                    <th>Prioritat</th>
                </tr>
                <?php
                    $existe = false;
                    $ordre = ['Alta', 'Mitja', 'Baixa'];

                    $color = ['Alta' => '#ff1100', 'Mitja' => '#ff9900', 'Baixa' => '#4caf50'];

                    foreach ($ordre as $prioritat_ordenat) {
                    
                    if (isset($prioritats[$prioritat_ordenat])) {
                        foreach ($prioritats[$prioritat_ordenat] as $i) {
                            $existe = true; ?>
                            <tr>
                                <td>#<?= $i['incidencia'] ?></td>
                                <td><?= $i['data_obertura'] ?></td>
                                <td><?= $i['temps_total'] ?> min</td>
                                <td style="background-color: <?= $color[$i['prioritat']] ?>;"><?= $i['prioritat'] ?></td>
                            </tr>
                        <?php }
                    }
                }

                if (!$existe): ?>
                    <tr>
                        <td colspan="4">No hi ha incidències obertes</td>
                    </tr>
                <?php endif; ?>

            </table>

            

            <?php endforeach; ?>

</div>
<br>
<a href="tecnico.php?id=<?= $id_seleccionat ?>" class="botones">Salir</a>

</body>
</html>