<?php
// CONNEXIÓ BD
require_once "connexion.php";

$id = $_GET['id'] ?? null;

// Si no hi ha ID
if (!$id) {
    die("No s'ha especificat cap incidència.");
}

// GUARDAR CANVIS
if (isset($_POST['guardar'])) {

    $tecnic = $_POST['tecnic'];
    $prioritat = $_POST['prioritat'];
    $tipus = $_POST['tipus'];

    $stmt = $conn->prepare(" UPDATE incidencies
        SET tecnic_id = ?, prioritat = ?, tipus = ?
        WHERE id = ?
    ");

    if ($stmt->execute([$tecnic, $prioritat, $tipus, $id])) {
            echo "<p style='color:green;text-align:center;'>Dades actualitzades correctament</p>";
            echo "<p style='text-align:center;'><a href='index.php' class='botones'>Salir</a></p>";
        } else {
            echo "<p style='color:red;text-align:center;'>Error al actualitzar les dades de la incidència</p>";
        }
    exit();
}


$res_tec = $conn->query("SELECT id, nom FROM tecnics ORDER BY nom ASC");
$tecnics = $res_tec->fetch_all(MYSQLI_ASSOC);


$stmt = $conn->prepare("SELECT * FROM incidencies WHERE id = ?");

$stmt->execute([$id]);
$res_inc = $stmt->get_result();
$inc = $res_inc->fetch_assoc();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar incidència</title>

    <style>
    

        select, button {
            padding: 8px;
            margin: 10px;
            width: 80%;
        }


        .botones {
            background: #2c51f1;
            border: none;
            cursor: pointer;
        }

        .botones:hover {
            background: #54a7df;
        }
    </style>
</head>

<body>

<div >

    <h2>Editar incidència #<?= $id ?></h2>

    <form method="POST">

        
        <p>Tècnic assignat:</p>
        <select name="tecnic" required>
            <option value="">-- Seleccionar tècnic --</option>
            <?php foreach ($tecnics as $t): ?>
                <option value="<?= $t['id'] ?>"
                    <?= ($inc['tecnic_id'] == $t['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

       
        <p>Prioritat:</p>
        <div>
            <label>
                <input type="radio" name="prioritat" value="Alta"
                <?= ($inc['prioritat'] == "Alta") ? "checked" : "" ?>>
                Alta
            </label>

            <label>
                <input type="radio" name="prioritat" value="Mitja"
                <?= ($inc['prioritat'] == "Mitja") ? "checked" : "" ?>>
                Mitja
            </label>

            <label>
                <input type="radio" name="prioritat" value="Baixa"
                <?= ($inc['prioritat'] == "Baixa") ? "checked" : "" ?>>
                Baixa
            </label>
        </div>

        <br>
        <!-- TIPUS -->
        <p>Tipus d'incidència:</p>
        <div >
            <label >
                <input type="radio" name="tipus" value="Software"
                <?= ($inc['tipus'] == "Software") ? "checked" : "" ?>>
                Software
                <input type="radio" name="tipus" value="Hardware"
                <?= ($inc['tipus'] == "Hardware") ? "checked" : "" ?>>
                Hardware    
                <input type="radio" name="tipus" value="Xarxa"
                <?= ($inc['tipus'] == "Xarxa") ? "checked" : "" ?>>
                Xarxa
                <input type="radio" name="tipus" value="Altres"
                <?= ($inc['tipus'] == "Altres") ? "checked" : "" ?>>
                Altres
                
            </label>   
            
           

        <button class="botones" type="submit" name="guardar" >
            Guardar canvis
        </button>

    </form>

</div>

</body>
</html>