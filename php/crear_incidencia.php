<?php
require_once "connexion.php";
require_once "logger.php";


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

    if ($stmt->execute()) :?>
        <div class="mensaje">
           <h1>Incidència creada correctament</h1>
           <h2><u>ID de la incidència:  <?php echo $conn->insert_id; ?></u></h2>
            <p><a href='index.php' class='inicio'>Salir</a></p> 
        </div>
         
        <?php endif;

        $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nova Incidència</title>

    <style>
        .mensaje {
            margin-top: 25%;
            color: green;
            text-align: center;
            
        }
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
            color: white;
            border-radius: 5px;
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
    <header>
        <h1>Registrar nova incidència</h1>
    </header>

    <form action="crear_incidencia.php" method="post" onsubmit="return validarForm()">
        <label><h4>Departament:</h4></label>
            <select name="departament_id" id="departament_id" >
                <option value="">Seleccionar departament</option>
                <option value="1">Matematiques</option>
                <option value="2">Informatica</option>
                <option value="3">Historia</option>
                <option value="4">Llengua</option>
                <option value="5">Ciencies</option>
            </select>


        <label><h4>Descripció:</h4></label>
        <textarea rows="4" name="descripcio" id="descripcio"></textarea>

            <h4 id="error" style="color:red;"></h4>
        
        <a href="usuari.php" class="inicio">Inicio</a>
        <button type="submit" class="envio">Enviar incidència</button>
        
        
    </form>
<?php
}
?>

    <script>

        function validarForm(){

            let dept = document.getElementById("departament_id").value;
            let desc = document.getElementById("descripcio").value;

            let error = "";

            if(dept == ""){
                error += "Has de seleccionar un departament<br>";
            }

            if(desc.trim().length < 5){
                error += "La descripció és massa curta o no hi ha cap descripció<br>";
            }

        
            if(error != ""){
                document.getElementById("error").innerHTML = error;
                return false; 
            }

            return true; 
        }

    </script>
</div>

</body>
</html>