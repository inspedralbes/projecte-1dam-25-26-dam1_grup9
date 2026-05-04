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
}


$stmt = $conn->prepare(" SELECT data_actuacio, descripcio, temps, visible
    FROM actuacions
    WHERE incidencia_id = ?
    ORDER BY data_actuacio ASC
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
}

textarea {
    width: 50%;
    margin: 5px;
}

.botones {
    padding: 10px 15px;
    background: #8270e7;
    border: none;
    cursor: pointer;
}

.botones:hover {
    background: #a27ee7;
}



</style>
</head>

<body>

<div>

<h2>Registrar actuació - Incidència #<?= $id ?></h2>


<div >

<h3>Historial d’actuacions</h3>

<table>
<tr>
    <th>Data</th>
    <th>Descripció</th>
    <th>Temps</th>
    <th>Visible</th>
</tr>

<?php if (count($actuacions) > 0): ?>
    <?php foreach ($actuacions as $a): ?>
        <tr>
            <td><?= $a['data_actuacio'] ?></td>
            <td><?= htmlspecialchars($a['descripcio']) ?></td>
            <td><?= $a['temps'] ?> min</td>
            <td><?= $a['visible'] ? "Sí" : "No" ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="4">No hi ha actuacions</td>
    </tr>
<?php endif; ?>

</table>

</div>


<div>

<h3>Nova actuació</h3>

<form method="POST">

<textarea name="descripcio" placeholder="Descripció" required></textarea><br>

<input type="number" name="temps" placeholder="Temps (minuts)" required><br>

<br>

<input type="checkbox" name="visible" checked> Visible 


<br><br>

<button class="botones" name="guardar">Afegir actuació</button>

</form>

</div>


<div >

<h3>Finalitzar incidència</h3>

<form method="POST">

Data finalització:
<input type="date" name="data_final" required>

<br><br>

<button class="botones" name="tancar">
Tancar incidència
</button>

</form>

</div>
    <a href="lista_actuacio.php" class="botones" style="margin-top: 20px; display: inline-block;">
        Cancelar
</div>

</body>
</html>