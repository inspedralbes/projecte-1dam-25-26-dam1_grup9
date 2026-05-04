<?php
require_once 'connexio.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: falta ID de incidencia");
}

/* =========================
   GUARDAR ACTUACIÓN
========================= */
if (isset($_POST['guardar'])) {

    $desc = $_POST['descripcio'];
    $temps = $_POST['temps'];
    $visible = isset($_POST['visible']) ? 1 : 0;

    $stmt = $pdo->prepare("
        INSERT INTO actuacions
        (incidencia_id, data_actuacio, descripcio, temps, visible)
        VALUES (?, NOW(), ?, ?, ?)
    ");

    $stmt->execute([$id, $desc, $temps, $visible]);
}

/* =========================
   FINALIZAR INCIDENCIA
========================= */
if (isset($_POST['tancar'])) {

    $data_final = $_POST['data_final'];

    $stmt = $pdo->prepare("
        UPDATE incidencies
        SET resolta = 1,
            data_tancament = ?
        WHERE id = ?
    ");

    $stmt->execute([$data_final, $id]);
}

/* =========================
   HISTORIAL
========================= */
$stmt = $pdo->prepare("
    SELECT data_actuacio, descripcio, temps, visible
    FROM actuacions
    WHERE incidencia_id = ?
    ORDER BY data_actuacio ASC
");

$stmt->execute([$id]);
$actuacions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Registrar actuació</title>

<style>
body {
    font-family: Arial;
    background: #f5f5f5;
    text-align: center;
}

.box {
    width: 850px;
    margin: auto;
    background: white;
    padding: 20px;
    margin-top: 30px;
    border-radius: 10px;
}

table {
    width: 95%;
    margin: auto;
    border-collapse: collapse;
}

th, td {
    border: 1px solid black;
    padding: 8px;
}

th {
    background: #ddd;
}

textarea, input {
    width: 90%;
    padding: 6px;
    margin: 5px;
}

.btn {
    padding: 10px 15px;
    background: #ccc;
    border: none;
    cursor: pointer;
}

.btn:hover {
    background: #aaa;
}

.section {
    margin-top: 20px;
}
</style>
</head>

<body>

<div class="box">

<h2>Registrar actuació - Incidència #<?= $id ?></h2>

<!-- =========================
     HISTORIAL
========================= -->
<div class="section">

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

<hr>

<!-- =========================
     NOVA ACTUACIÓN
========================= -->
<div class="section">

<h3>Nova actuació</h3>

<form method="POST">

<textarea name="descripcio" placeholder="Descripció" required></textarea><br>

<input type="number" name="temps" placeholder="Temps (minuts)" required><br>

<label>
<input type="checkbox" name="visible" checked>
Visible per a l’usuari
</label>

<br><br>

<button class="btn" name="guardar">Afegir actuació</button>

</form>

</div>

<hr>

<!-- =========================
     TANCAR INCIDÈNCIA
========================= -->
<div class="section">

<h3>Finalitzar incidència</h3>

<form method="POST">

Data finalització:
<input type="date" name="data_final" required>

<br><br>

<button class="btn" name="tancar">
Tancar incidència
</button>

</form>

</div>

</div>

</body>
</html>