<?php
session_start();

require_once "connexion.php";
include_once "logger.php";

if (isset($_GET['id'])) {
    $_SESSION['tecnic_id'] = $_GET['id'];
}

if (!isset($_SESSION['tecnic_id'])) {
    header("Location: elegir_tecnico.php");
    exit();
}

$id_seleccionat = $_SESSION['tecnic_id'];

$sql = "SELECT * FROM incidencies i 
        JOIN departament d ON d.id = i.departament_id 
        WHERE i.resolta = 0 
        AND i.tecnic_id =  " . intval($id_seleccionat);

$result = $conn->query($sql);
$incidencies = ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Incidències no resoltes</title>

    <style>
        header {
            background: linear-gradient(to right, #23e2c2, #6a8bf0);
            color: white;
            padding: 20px;
        }
        body {
            font-family: Arial;
            text-align: center;
        }


        table {
            margin: auto;
            border-collapse: collapse;
            width: 90%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
        }

        th {
            background-color: #4764e6;
            color:white;
        }

        .botones {
            padding: 8px 17px;
            background: #389bec;
            text-decoration: none;
            color: black;
            border-radius: 5px;
        }

        .botones:hover {
            background: #80b2f3;
        }

        h2 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div >
    <header>
        <h1>Incidències no resoltes (Tècnic: <?= htmlspecialchars($id_seleccionat) ?>)</h1>
    </header>
   
    <table>
        <h3>Tècnic: <?= htmlspecialchars($id_seleccionat) ?></h3>
        <tr>
            <th>ID</th>
            <th>Departament</th>
            <th>Data</th>
            <th>Prioritat</th>
            <th>Acció</th>
        </tr>

        <?php if (count($incidencies) > 0): ?>
            <?php foreach ($incidencies as $i): ?>
                <tr>
                    <td><?= $i['id'] ?></td>
                    <td><?= htmlspecialchars($i['departament_nom']) ?></td>
                    <td><?= $i['data_obertura'] ?></td>
                    <td><?= $i['prioritat'] ? $i['prioritat'] : '-' ?></td>
                    <td>
                        <a class="botones" href="registrar_actuacio.php?id=<?= $i['id'] ?>">
                            Nueva actuació
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No hi ha incidències pendents</td>
            </tr>
        <?php endif; ?>

    </table>
    <br>
    <a href="tecnico.php?id=<?= $id_seleccionat ?>" class="botones">Salir</a>

</div>


</body>
</html>