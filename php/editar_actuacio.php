<?php
require_once "connexion.php";
require_once "logger.php";

// Obtenemos el id que teniamos antes 
// Si no existe se le asignará el valor null por defecto usando el operador ??
$id = $_GET['id'] ?? null;

// Si no hay un id se mostrara un mensaje de error
if (!$id) {
    die("No s'ha especificat cap incidència.");
}
// Si se ha pulsado el botón de "guardar" haz esto
if (isset($_POST['guardar'])) {
    // Se recoge los datos que se escribió en el formulario
    $tecnic = $_POST['tecnic'];
    $prioritat = $_POST['prioritat'];
    $tipus = $_POST['tipus'];
    //Le pide que actualize los valores 
    $stmt = $conn->prepare(" UPDATE incidencies
        SET tecnic_id = ?, prioritat = ?, tipus = ?
        WHERE id = ?
    ");
     // Ejecuta la consulta pasando las variables en orden dentro de un array y si lo hace bien muestre un mensaje de correcto
    // y tambien un boton para salir
    if ($stmt->execute([$tecnic, $prioritat, $tipus, $id])) :?>
        <div style="margin-top: 25%; color: green; text-align: center;font-family: Arial;">
           <h1>Dades actualitzades correctament</h1>
            <p><a href='lista_prioritat.php' style="background: #2c51f1;border: none;color: white;padding: 10px 20px;
            font-size: 16px;text-decoration: none;border-radius: 5px;font-family: Arial;">Salir</a></p> 
        </div>    
        <?php
        else :?>
            <p class='mensaje'>Error al actualitzar les dades de la incidència</p>
        <?php endif;
    exit();
    
}

// Pide a la bbdds el id y el nombre de todos los técnicos, ordenando alfabeticamnete
$res_tec = $conn->query("SELECT id, nom FROM tecnics ORDER BY nom ASC");
// el resultado lo guarda en la variable $tecnics 
// en forma de lista ordenada 
$tecnics = $res_tec->fetch_all(MYSQLI_ASSOC);

// Consulta para buscar todos los datos de una incidencia. 
//El signo "?" es para poner despues el id que queremos buscar.
$stmt = $conn->prepare("SELECT * FROM incidencies WHERE id = ?");
// asegurándose de que se trate estrictamente como un número entero ("i").
$stmt->bind_param("i", $id);
$stmt->execute();

// Recoge los datos que se ha devuelto de la bbdd tras la búsqueda.
$res_inc = $stmt->get_result();
// saca la única fila de ese id y la guarda en $inc 
$inc = $res_inc->fetch_assoc();


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">          
    <style>
        body{
            font-family:arial;
        }
        header {
                background: linear-gradient(to right, #23e2c2, #6a8bf0);
                color: white;
                padding: 20px;
                text-align: center;
        }
        select{
            padding: 5px 10px;
        }
         button {
            padding: 8px;
            margin: 10px;
            width: 25%;
        }
        fieldset{
            border: 2px solid black;
            margin: 20px auto;
            width: 50%;
            padding: 2px 15px;
            border-radius: 5px;
        
        }
    </style>
</head>

<body>

<header>
    <h1>Editar incidència <span style="color: black;"># <?= $id ?></span></h1>
</header>
    <?php include "header2.php" ?>

<div >


    <form method="POST">

        <fieldset>
            <br>
            <p><b>Tècnic assignat:</b></p>
                <select class="form-select" name="tecnic" required>
                    <option value="">Seleccionar tècnic</option>
                    <?php foreach ($tecnics as $t): ?>
                        <option value="<?= $t['id'] ?>"
                            <?= ($inc['tecnic_id'] ?? "") == $t['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>

            <p><b>Prioritat:</b></p>
            <div>
                <label>
                    <input type="radio" name="prioritat" value="Alta" required
                    <?= ($inc['prioritat'] ?? "") == "Alta" ? "checked" : "" ?>>
                    Alta
                </label>

                <label>
                    <input type="radio" name="prioritat" value="Mitja" required
                    <?= ($inc['prioritat'] ?? "") == "Mitja" ? "checked" : "" ?>>
                    Mitja
                </label>

                <label>
                    <input type="radio" name="prioritat" value="Baixa" required
                    <?= ($inc['prioritat'] ?? "") == "Baixa" ? "checked" : "" ?>>
                    Baixa
                </label>
            </div>

            <br>
    
            <p><b>Tipus d'incidència:</b></p>
            <div >
                <label >
                    <input type="radio" name="tipus" value="Software" required
                    <?= ($inc['tipus'] ?? "") == "Software" ? "checked" : "" ?>>
                    Software
                    <input type="radio" name="tipus" value="Hardware" required
                    <?= ($inc['tipus'] ?? "") == "Hardware" ? "checked" : "" ?>>
                    Hardware    
                    <input type="radio" name="tipus" value="Xarxa" required
                    <?= ($inc['tipus'] ?? "") == "Xarxa" ? "checked" : "" ?>>
                    Xarxa
                    <input type="radio" name="tipus" value="Altres" required
                    <?= ($inc['tipus'] ?? "") == "Altres" ? "checked" : "" ?>>
                    Altres
                </label> 
                <br>
                <br>
                <button class="btn btn-success" type="submit" name="guardar" >Guardar canvis</button>
                <a href="lista_prioritat.php" class="btn btn-primary">Salir</a>
            </div>        
        </fieldset>
          
    </form>
    
</body>
</html>
