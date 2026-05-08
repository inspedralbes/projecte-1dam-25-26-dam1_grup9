<?php
require_once "connexion.php";

$result = $conn->query("SELECT * FROM incidencies
JOIN departament d ON d.id = incidencies.departament_id
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
        <h1>Incidències no resoltes</h1>
    </header>
   
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
    <a href="tecnico.php" class="botones">Salir</a>

</div>


</body>
</html>