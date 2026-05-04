<?php
require_once "connexion.php";

$sql = ("SELECT t.nom AS tecnic, i.id AS incidencia, i.data_obertura, i.prioritat, COALESCE(SUM(a.temps), 0) AS temps_total
    FROM tecnics t
    JOIN incidencies i ON i.tecnic_id = t.id
    LEFT JOIN actuacions a ON a.incidencia_id = i.id
    WHERE i.resolta = 0
    GROUP BY i.id, t.nom, i.data_obertura, i.prioritat
    ORDER BY t.nom, 
            CASE i.prioritat
                WHEN 'Alta' THEN 1
                WHEN 'Mitja' THEN 2
                WHEN 'Baixa' THEN 3
            END
");

$stmt = $conn->prepare($sql);
$stmt->execute();

// 1. RECOLLIM les dades correctament
$res = $stmt->get_result();
$data = $res->fetch_all(MYSQLI_ASSOC);

$result = [];

// 2. AGRUPEM les dades al nou array $result
foreach ($data as $row) {
    $result[$row['tecnic']][$row['prioritat']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Informe de Tècnics</title>

<style>
   

    table {
        margin: auto;
        width: 90%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
    }

    th {
        background: #ddd;
    }

    h3 {
        margin-top: 25px;
    }
</style>
</head>

<body>

<div >

    <h2>Informe de Tècnics</h2>
    
     <?php if (empty($result)): ?>
        <p>No hi ha incidències obertes actualment.</p>
    <?php endif; ?>

    <?php foreach ($result as $tecnic => $prioritats): ?>

        <h3>TÈCNIC: <?= htmlspecialchars($tecnic) ?></h3>

        <?php foreach (['Alta', 'Mitja', 'Baixa'] as $p): ?>

            <h4>--- Prioritat <?= $p ?> ---</h4>

            <table>
                <tr>
                    <th>Incidència</th>
                    <th>Data inici</th>
                    <th>Temps total</th>
                </tr>

                <?php if (!empty($prioritats[$p])): ?>
                    <?php foreach ($prioritats[$p] as $i): ?>
                        <tr>
                            <td>#<?= $i['incidencia'] ?></td>
                            <td><?= $i['data_obertura'] ?></td>
                            <td><?= $i['temps_total'] ?> min</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Sense incidències</td>
                    </tr>
                <?php endif; ?>

            </table>

        <?php endforeach; ?>

    <?php endforeach; ?>

</div>

</body>
</html>