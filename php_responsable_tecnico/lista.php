<?php include_once "header.php";  ?>

<?php
include_once "connexio.php";
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
</head>

<body>
    <h1>Llistat de incidències</h1>
    <?php

    // Consulta SQL per obtenir totes les files de la taula 'incidencies'
    $sql = "SELECT id, nom_incidencia, departament_id, data_incidencia, prioritat, descripcio, estat FROM incidencies";
    $result = $conn->query($sql);

    // Comprovar si hi ha resultats
    if ($result && $result->num_rows > 0) { ?>

    <h2 class="h1">Estat de l'incidència</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>TÍTOL D'INCIDÈNCIA</th>
                <th>DEPARTAMENT</th>
                <th>DATA DE CREACIÓ</th>
                <th>PRIORITAT</th>
                <th>DESCRIPCIÓ</th>
                <th>ESTAT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 3. El bucle per recórrer les files de la base de dades
            while ($in = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $in["id"] ?></td>
                    <td><?php echo htmlspecialchars($in["nom_incidencia"]) ?></td>
                    <td><?php echo $in["departament_id"] ?></td>
                    <td><?php echo $in["data_incidencia"] ?></td>
                    <td><?php echo $in["prioritat"] ?></td>
                    <td><?php echo htmlspecialchars($in["descripcio"]) ?></td>
                    <td><?php echo $in["estat"] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php 
} else {
    echo "<p>No hi ha dades a mostrar.</p>";
}

    // Tancar la connexió
    $conn->close();
    ?>


</body>

</html>