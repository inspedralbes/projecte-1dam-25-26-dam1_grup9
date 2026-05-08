<?php
require_once "connexion.php";

$sql = ("SELECT DISTINCT i.departament_id, (SELECT COUNT(*) FROM incidencies i2 WHERE i2.departament_id = i.departament_id) AS num_incidencies,
(SELECT COALESCE(SUM(a.temps),0) FROM actuacions a
JOIN incidencies i3 ON i3.id = a.incidencia_id WHERE i3.departament_id = i.departament_id) AS temps_total
FROM incidencies i
ORDER BY i.departament_id
");

$resultat = $conn->query($sql);

if ($resultat) {
    $data = $resultat->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error en la consulta: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Consum per Departaments</title>

<style>
    body {
    font-family: Arial;
               
    }
    table {
        margin: auto;
        width: 90%;
        border-collapse: collapse;
        margin-top: 20px;
        
    }

    th, td {
        border: 1px solid black;
        padding: 10px;
    }

    th {
        background: #7ba3fa;
    }
    .inicio {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #6f71eb;
            border: none;
            color: white;
        }

        .inicio:hover {
            background-color: #285ed3;
        }
</style>
</head>

<body>

<div>

    <h2>Consum per Departaments</h2>

    <table>
        <tr>
            <th>Departament</th>
            <th>Nº incidències</th>
            <th>Temps total</th>
        </tr>

        <?php if (count($data) > 0): ?>
            <?php foreach ($data as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['departament_id']) ?></td>
                    <td><?= $d['num_incidencies'] ?></td>
                    <td><?= $d['temps_total'] ?> min</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No hi ha dades</td>
            </tr>
        <?php endif; ?>

    </table>
    
</div>
<div>
    <br>
    <a href="usuari.php" class="inicio">Inicio</a>
</div>


</body>
</html>