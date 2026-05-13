<?php
require_once "connexion.php";
include_once "logger.php";
$result = $conn->query("SELECT COUNT(*) as total FROM accessos");
$row = $result->fetch_assoc();
$total = $row['total'];


$pagines = $conn->query("SELECT pagina, COUNT(*) as total
    FROM accessos
    GROUP BY pagina
");


$usuaris = $conn->query("SELECT usuari, COUNT(*) as total
    FROM accessos
    GROUP BY usuari
");
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

    table {
        width: 95%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
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
</style>

<body>
    <header>
        <h1>Estadísticas de acceso en els departaments</h1>
    </header>
    <?php include "header2.php" ?>
    <fieldset>
        <h3 class= "uno">Accesos totales: <?= $total ?></h3>
    </fieldset>

    <h3>Páginas más visitadas</h3>
        <table border="1">
            <tr>
                <th>Página</th>
                <th>Accesos</th>
            </tr>

            <?php while($p = $pagines->fetch_assoc()): ?>
            <tr>
                <td><?= $p['pagina'] ?></td>
                <td><?= $p['total'] ?></td>
            </tr>
            <?php endwhile; ?>

        </table>


    <h3>Usuarios más activos</h3>
        <table border="1">
            <tr>
                <th>Usuario</th>
                <th>Accesos</th>
            </tr>

            <?php while($u = $usuaris->fetch_assoc()): ?>
            <tr>
                <td><?= $u['usuari'] ?></td>
                <td><?= $u['total'] ?></td>
            </tr>
            <?php endwhile; ?>

        </table>

    <a href="administrador.php" class="botones" style="margin-top: 20px; display: inline-block;">Inicio</a>

</body>
</html>