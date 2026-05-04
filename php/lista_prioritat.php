<?php  
require_once "connexio.php";

$result = $conn->query("SELECT * FROM Incidencies");
$Incidencies = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Incidències no resoltes</title>

    <style>
        body {
            font-family: Arial;
            text-align: center;
            background: #f5f5f5;
        }

        .box {
            width: 90%;
            margin: auto;
            margin-top: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            width: 95%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
        }

        th {
            background-color: #ddd;
        }

        .btn {
            padding: 6px 12px;
            background: #ccc;
            text-decoration: none;
            color: black;
            border-radius: 5px;
        }

        .btn:hover {
            background: #aaa;
        }

        h2 {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="box">

    <h2>Incidències NO resoltes</h2>

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
                    <td><?= htmlspecialchars($i['departament']) ?></td>
                    <td><?= $i['data_obertura'] ?></td>
                    <td><?= $i['prioritat'] ? $i['prioritat'] : '-' ?></td>
                    <td>
                        <a class="btn" href="editar_actuacio.php?id=<?= $i['id'] ?>">
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

        <a href="responsable_tecnico.php" class="inicio">Cancelar</a>
    </table>

</div>

</body>
</html>