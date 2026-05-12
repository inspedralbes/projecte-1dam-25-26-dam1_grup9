<?php  
require_once "connexion.php";
include_once "logger.php";

$result = $conn->query("SELECT * FROM incidencies i
JOIN departament d ON d.id = i.departament_id
WHERE resolta = 0");
$incidencies = $result->fetch_all(MYSQLI_ASSOC);
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
            font-family: Arial;
            text-align: center;
        }
        table {
            
            border-collapse: collapse;
            width: 100%;
            
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            font-family: Arial;
            text-align: center;
        }

        th {
            background-color: #2b5de7;
            color: white;
            font-family: Arial;
        }

        .botones {
            padding: 6px 12px;
            background: #2c51f1;
            text-decoration: none;
            color: white;
            border-radius: 5px;
        }

        .botones:hover {
            background: #54a7df;
            
        }

        .inicio {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #2d59e9;
            border: none;
            color: white;
            font-family: Arial;
        }

        .inicio:hover {
            background-color: #55a5da;
        }
    </style>
</head>

<body>

<div class="box">

    <header>
        <h1>Incidències no resoltes</h1>
    </header>
    <?php include "header2.php" ?>
    <br>
    <table>
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
                        <a class="botones" href="editar_actuacio.php?id=<?= $i['id'] ?>">
                            Editar
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
    <a href="administrador.php" class="inicio">Cancelar</a>
</div>

</body>
</html>