<?php
session_start();

require_once "connexion.php";
include_once "logger.php";

//Asegura que el id existe
if (isset($_GET['id'])) {
    //Guarda ese id aquí
    $_SESSION['tecnic_id'] = $_GET['id'];
}
// si no hay un id guardado se le enviara a la pagian para que eliga al tecnico
if (!isset($_SESSION['tecnic_id'])) {
    header("Location: elegir_tecnico.php");
    exit();
}
// si el id es valido,guardalo para que pueda ser usado en la consulta
$id_seleccionat = $_SESSION['tecnic_id'];

// Consulta las incidencia con su departamento correspondiente y que sea una incidencia no resuleta
// donde ademas debe solo verse para el tecnico al que fue asigando (la que entro a la pagina)
// 'intval()' es una función de seguridad que transforma cualquier texto en un número entero
$sql = "SELECT * FROM incidencies i 
        JOIN departament d ON d.id = i.departament_id 
        WHERE i.resolta = 0 
        AND i.tecnic_id =  " . intval($id_seleccionat);

$result = $conn->query($sql);
if ($result) {
    // Si la consulta fue bien ejecutalo
    $incidencies = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Si falló, crea una lista vacía para que la pagina no de un error
    $incidencies = [];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Incidències no resoltes</title>
 <link rel="stylesheet" href="css/lista_actuacio.css">
</head>

<body>

<div >
    <header>
        <h1>Incidències no resoltes (Tècnic: <?= htmlspecialchars($id_seleccionat) ?>)</h1>
    </header>
    <?php include "header2.php" ?>
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
