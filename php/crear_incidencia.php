<?php
require_once "connexion.php";

function crear_incidencia($conn)
{
    $departamento = $_POST['departament_id'];
    $descripcion = $_POST['descripcio'];
    $data= date('Y-m-d H:i:s');

    if (empty($departamento) || empty($descripcion)) {
        echo "<p style='color:red;text-align:center;'>Error: camps buits</p>";
        return;
    }

    $sql = "INSERT INTO incidencies (departament_id, descripcio, data_obertura) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $departamento, $descripcion, $data);

    if ($stmt->execute()) {
        echo "<p style='color:green;text-align:center;'>Incidència creada correctament</p>";
        echo "<p style='text-align:center;'><a href='index.php' class='inicio'>Salir</a></p>";
    } else {
        echo "<p style='color:red;text-align:center;'>Error al crear incidència</p>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nova Incidència</title>

    <style>
        header {
            background: linear-gradient(to right, #23e2c2, #6a8bf0);
            color: white;
            padding: 20px;
            font-family: Arial;
            text-align: center;
        }
        body {
            display: flex;
            font-family: Arial;
            
        }

        input, select, textarea {
            display: block;
            width: 300px;
            margin: 10px 0;
            padding: 8px;
        }

        button {
            width: 200px;
            margin: 10px ;
            padding: 10px;
            font-size: 16px;
            
        }

        .inicio {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #6285e7;
            color: black;
        }
        .envio {
            background-color: #e7b75e;
            color: black;
        }

        .inicio:hover {
            background-color: #5833e0;
        }
        
    </style>
</head>

<body>

<div>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    crear_incidencia($conn);

} else {
?>
    <h2> Registre d'una nova Incidència</h2>

    <form action="crear_incidencia.php" method="post">

        <label>Departament:</label>
        <select name="departament_id" required>
            <option value="">Seleccionar departament</option>
            <option value="1">Matematiques</option>
            <option value="2">Informatica</option>
            <option value="3">Historia</option>
            <option value="4">Llengua</option>
            <option value="5">Ciencies</option>
        </select>


        <label>Descripció:</label>
        <textarea rows="4" name="descripcio"></textarea>
        
        
        <a href="usuari.php" class="inicio">Inicio</a>
        <button type="submit" class="envio">Enviar incidència</button>
        
        
    </form>
<?php
}
?>
</div>

</body>
</html>