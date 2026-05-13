<?php
require_once 'connexion.php';
include_once "logger.php";

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

$stmtInc = $conn->prepare("SELECT data_tancament, data_obertura FROM incidencies WHERE id = ?");
$stmtInc->execute([$id]);
$incidencia = $stmtInc->get_result()->fetch_assoc();
$data_fi = $incidencia['data_tancament'] ?? null;
$data_inici = $incidencia['data_obertura'] ?? '' ;


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
        border-radius: 5px;
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
<?php include "header2.php" ?>
<fieldset>

    <h2>Historial d'actuacions</h2>

        <table>
            <tr>
                <th>Data de actuació</th>
                <th>Descripció</th>
                <th>Temps</th>
                <th>Visible</th>
                <th>Data de la finalització </th>
            </tr>

    <?php if (count($actuacions) > 0): ?>
        <?php foreach ($actuacions as $a): ?>
            <tr>
                <td><?= $a['data_actuacio'] ?></td>
                <td><?= htmlspecialchars($a['descripcio']) ?></td>
                <td><?= $a['temps'] ?> min</td>
                <td><?= $a['visible'] ? "Sí" : "No" ?></td>
                <td><?php if ($data_fi): ?>
                            <?= $data_fi ?>
                        <?php else: ?>
                            <span style="color: grey; font-style: italic;">Pendent de tancament</span>
                        <?php endif; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No hi ha actuacions</td>
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

        <form method="POST" onsubmit="return validarForm()">

            <b>Data finalització: <br></b>
            <input type="date" name="data_final" id="data_final">
            <br>
            <br>
            <button class="botones" name="tancar"><b>Tancar incidència</b></button>
            <h4 id="error" style="color:red;"></h4>
        
        </form>
       
        <script>
            function validarForm(){

                let data_inici =new Date("<?= $data_inici ?>");
                let data_fi = document.getElementById("data_final").value;

                let error = "";

                let dataFi = new Date(data_fi);

                if(dataFi < data_inici){
                    error = "La data de finalització no pot ser menor a la data de creació de la incidència<br>";
                }

                if(error != ""){
                    document.getElementById("error").innerHTML = error;
                    return false; 
                }

                return true;
            }
        </script>
</fieldset>
</div>
    <br>

    <a href="lista_actuacio.php" class="botones" >
        Cancelar
    </a>

</body>
</html>