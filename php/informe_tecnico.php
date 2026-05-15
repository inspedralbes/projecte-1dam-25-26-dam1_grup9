<?php
session_start();

require_once "connexion.php";
include_once "logger.php";

// Esta línea comprueba si el ID está guardado en la SESIÓN ($_SESSION).
if (!isset($_SESSION['tecnic_id'])) {
     // Si no se encuentra en la sesión, te echa y te manda a que eligas uno de los técnicos
    header("Location: elegir_tecnico.php");
    exit();
}
//Cogemos el id que nos envio
$id_seleccionat = $_SESSION['tecnic_id'];

// Este sql lo que hace es coger el nombre de tecnico, la id de la incidencia, data de creación, el rango de prioridad, el tiempo y si no 
//hay que ponga 0. Donde cada incidencia esta asignada a un tecnico. Si hay actuaciones que se muetre y si no hay tambien.
// Debe solo coger incidencia que no estan solucionadas y deben estar agrupados por la id incidencia (y entre otros). Ademas de estar ordenado pro prioridad 
$sql = ("SELECT t.nom AS tecnic, i.id AS incidencia, i.data_obertura, i.prioritat, COALESCE(SUM(a.temps), 0) AS temps_total
    FROM tecnics t
    JOIN incidencies i ON i.tecnic_id = t.id
    LEFT JOIN actuacions a ON a.incidencia_id = i.id
    WHERE i.resolta = 0 AND t.id = ?
    GROUP BY i.id, t.nom, i.data_obertura, i.prioritat
    ORDER BY t.nom, 
            CASE i.prioritat
                WHEN 'Alta' THEN 1
                WHEN 'Mitja' THEN 2
                WHEN 'Baixa' THEN 3
            END
");
//prepara la consulta sql
$stmt = $conn->prepare($sql);
// Aseguramos que la variable ? que se envie sea un numero 
$stmt->bind_param("i", $id_seleccionat);
$stmt->execute();
//Obtener el resultado
$res = $stmt->get_result();
//Conviertes el resultado en un array (fetch_all) y MYSQLI_ASSOC usa como etiquetas los nombres de columnas.
$data = $res->fetch_all(MYSQLI_ASSOC);

$result = [];

foreach ($data as $row) {
     //guardamos el nombre del tecnico
    $nom = $row['tecnic'];
     //creamos grupos por tecnico donde dentro de cada tecnico tiene sus incidencias ordenadas por prioridad
    $result[$row['tecnic']][$row['prioritat']][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Informe de Tècnics</title>
<link rel="stylesheet" href="css/informe_tecnico.css">
</head>

<body>

<div >

    <header>
        <h2>Informe</h2>
    </header>
    <?php include "header2.php" ?>

    <?php if (empty($result)): ?>
        <p>No hi ha incidències obertes actualment.</p>
    <?php endif; ?>

    <?php foreach ($result as $tecnic => $prioritats): ?>

        <h3>TÈCNIC ENCARREGAT: <span style="color: #2a04ff ;"><?= htmlspecialchars($nom) ?></span></h3>

       
            <table>
                <tr>
                    <th>Incidència</th>
                    <th>Data inici</th>
                    <th>Temps total</th>
                    <th>Prioritat</th>
                </tr>
                <?php
                    //si no hay incidencia asignadas a este tecnico muestra un mensaje
                    $existe = false;
                    $ordre = ['Alta', 'Mitja', 'Baixa'];

                    $color = ['Alta' => '#ff1100', 'Mitja' => '#ff9900', 'Baixa' => '#4caf50'];

                    foreach ($ordre as $prioritat_ordenat) {
                    
                    if (isset($prioritats[$prioritat_ordenat])) {
                        foreach ($prioritats[$prioritat_ordenat] as $i) {
                            $existe = true; ?>
                            <tr>
                                <td>#<?= $i['incidencia'] ?></td>
                                <td><?= $i['data_obertura'] ?></td>
                                <td><?= $i['temps_total'] ?> min</td>
                                <td style="background-color: <?= $color[$i['prioritat']] ?>;"><?= $i['prioritat'] ?></td>
                            </tr>
                        <?php }
                    }
                }

                if (!$existe): ?>
                    <tr>
                        <td colspan="4">No hi ha incidències asignadas</td>
                    </tr>
                <?php endif; ?>

            </table>

            

            <?php endforeach; ?>

</div>
<br>
<a href="tecnico.php?id=<?= $id_seleccionat ?>" class="botones">Salir</a>

</body>
</html>
