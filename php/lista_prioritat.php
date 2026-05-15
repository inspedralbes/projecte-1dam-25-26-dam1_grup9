<?php  
require_once "connexion.php";
include_once "logger.php";

// Pide a la base de datos las incidencias no resueltas (resolta = 0) y su departamento
$result = $conn->query("SELECT i.*, d.departament_nom AS nombre 
FROM incidencies i
JOIN departament d ON i.departament_id = d.id
WHERE resolta = 0");

$incidencies = $result->fetch_all(MYSQLI_ASSOC);

// Si han pulsado eliminar 
if (isset($_GET['eliminar_id'])) {
    // Forzamos a que el ID sea estrictamente un número entero y que se guarde en la variable $id
    $id = intval($_GET['eliminar_id']);
    
 // Le pide que borre esa fila
$sql = "DELETE FROM incidencies WHERE id = $id";

// Envía la orden de borrado a la bbdd y comprueba si ha ido bien
if (mysqli_query($conn, $sql)) {
    // Recarga la misma página para limpiar el "?eliminar_id" de la barra de direcciones
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
} 
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Incidències no resoltes</title>
 <link rel="stylesheet" href="css/lista_prioritat.css">
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
                    <td><?= htmlspecialchars($i['nombre']) ?></td>
                    <td><?= $i['data_obertura'] ?></td>
                    <td><?= $i['prioritat'] ? $i['prioritat'] : '-' ?></td>
                    <td>
                        <a class="botones" href="editar_actuacio.php?id=<?= $i['id'] ?>">Editar</a>
                        <a class="botones" href="?eliminar_id=<?php echo $i['id']; ?>" 
                         onclick="return confirm('Estàs segur que vols eliminar aquesta incidència? ')"
                         style="background:red;"  >Borrar</a>
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
