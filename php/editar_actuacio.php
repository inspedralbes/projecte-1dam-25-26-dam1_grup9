<?php
require_once "connexion.php";

$id = $_GET['id'] ?? null;


if (!$id) {
    die("No s'ha especificat cap incidència.");
}

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
            echo "<p style='text-align:center;'><a href='lista_prioritat.php' class='botones'>Salir</a></p>";
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

    <style>
        header {
                background: linear-gradient(to right, #23e2c2, #6a8bf0);
                color: white;
                padding: 20px;
                font-family: Arial;
                text-align: center;
        }
        select{
            padding: 5px 10px;
        }
         button {
            padding: 8px;
            margin: 10px;
            width: 50%;
        }


        .botones {
            background: #2c51f1;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
        }

        .botones:hover {
            background: #54a7df;
        }
    </style>
</head>

<body>

<header>
    <h1>Editar incidència <span style="color: black;"># <?= $id ?></span></h1>
</header>

<div >


    <form method="POST">

        
        <p><b>Tècnic assignat:</b></p>
        <select name="tecnic" required>
            <option value="">-- Seleccionar tècnic --</option>
            <?php foreach ($tecnics as $t): ?>
                <option value="<?= $t['id'] ?>"
                    <?= ($inc['tecnic_id'] == $t['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

       
        <p><b>Prioritat:</b></p>
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
    
        <p><b>Tipus d'incidència:</b></p>
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
    </form>
    <br>
    <button class="botones" type="submit" name="guardar" >
        Guardar canvis
    </button>

</div>

</body>
</html>