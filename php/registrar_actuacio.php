<?php
require_once 'connexion.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: falta ID de incidencia");
}


if (isset($_POST['guardar'])) {

    $desc = $_POST['descripcio'];
    $temps = $_POST['temps'];
    $visible = isset($_POST['visible']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO actuacions
        (incidencia_id, data_actuacio, descripcio, temps, visible)
        VALUES (?, NOW(), ?, ?, ?)
    ");

    $stmt->execute([$id, $desc, $temps, $visible]);
}


if (isset($_POST['tancar'])) {

    $data_final = $_POST['data_final'];

    $stmt = $conn->prepare("UPDATE incidencies
        SET resolta = 1,
            data_tancament = ?
        WHERE id = ?
    ");

    $stmt->execute([$data_final, $id]);

     $stmt2 = $conn->prepare("UPDATE actuacions SET visible = 0 WHERE incidencia_id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
}


$stmt = $conn->prepare("SELECT a.data_actuacio, a.descripcio, a.temps, a.visible, i.data_tancament
    FROM actuacions a
    INNER JOIN incidencies i ON a.incidencia_id = i.id
    WHERE a.incidencia_id = ?
    ORDER BY a.data_actuacio ASC
");

$stmt->execute([$id]);
$resultat = $stmt->get_result();
$actuacions = $resultat->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Registrar actuació</title>

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
        color : white;
    }
    input{
        padding: 8px;  
        border: 1px solid #000000;
    }

    textarea {
        width: 150%;
        padding: 10px;
        height: 50px;
        margin: 10px 0px;
        border: 1px solid #000000;
    }

    .botones {
        padding: 10px 15px;
        background: #8270e7;
        border: none;
        cursor: pointer;
        text-decoration: none;
        color: white;
    }

    .botones:hover {
        background: #a27ee7;
    }
    fieldset {
        margin: 20px;
        padding: 20px ;
        border: 2px solid #000000;
        border-radius: 5px;
        
    }
    .uno{
        display: flex;
        
    }
    button {
        font-family: Arial;
        font-size: 16px;
    }

</style>
</head>

<body>

<header>
    <h1>Registrar actuació - Incidència <span style="color: black;"># <?= $id ?></span></h1>
</header>
<fieldset>

    <h2>Historial d’actuacions</h2>

        <table>
            <tr>
                <th>Data</th>
                <th>Descripció</th>
                <th>Temps</th>
                <th>Visible</th>
                <th>Data de la finalització</th>
            </tr>

    <?php if (count($actuacions) > 0): ?>
        <?php foreach ($actuacions as $a): ?>
            <tr>
                <td><?= $a['data_actuacio'] ?></td>
                <td><?= htmlspecialchars($a['descripcio']) ?></td>
                <td><?= $a['temps'] ?> min</td>
                <td><?= $a['visible'] ? "Sí" : "No" ?></td>
                <td><?= $a['data_tancament'] ?? "No especificada" ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No hi ha actuacions</td>
        </tr>
    <?php endif; ?>

        </table>
</fieldset>


<div class="uno">
<fieldset style="padding-right: 25%;">

    <h3>Nova actuació</h3>

        <form method="POST">
            <textarea name="descripcio" placeholder="Descripció" required></textarea><br>
            <input type="number" name="temps" placeholder="Temps (minuts)" required><br>
            <br>
            <input type="checkbox" name="visible" checked> Visible 
            <br>
            <br>
            <button class="botones" name="guardar"><b>Afegir actuació</b></button>

        </form>

</fieldset>


<fieldset style="padding-right: 25%;">

    <h3>Finalització de la incidència</h3>

        <form method="POST">

            <b>Data finalització: <br></b>
            <input type="date" name="data_final" required>
            <br>
            <br>
            <button class="botones" name="tancar"><b>Tancar incidència</b></button>
        
        </form>
</fieldset>
</div>
    <br>

    <a href="lista_actuacio.php" class="botones" >
        Cancelar
    </a>

</body>
</html>