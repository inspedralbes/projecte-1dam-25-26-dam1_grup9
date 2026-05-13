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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">   
    <style>
     
        header {
            background: linear-gradient(to right, #23e2c2, #6a8bf0);
            color: white;
            padding: 20px;
            font-family: Arial;
            text-align: center;
        }

        button {
            width: 200px;
            margin: 10px ;
            padding: 10px;
            font-size: 16px;
            
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

<div>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    crear_incidencia($conn);

} else {
?>
    <header>
        <h1>Registrar nova incidència</h1>
    </header>

    <?php include "header2.php" ?>
    
    <fieldset style="margin-top: 5%;">
        <form action="crear_incidencia.php" method="post" onsubmit="return validarForm()">
        <br>
        <label  class="form-label"><h5>Departament:</h5></label>
            <select class="form-select" name="departament_id" id="departament_id" >
                <option value="">Seleccionar departament</option>
                <option value="1">Matematiques</option>
                <option value="2">Informatica</option>
                <option value="3">Historia</option>
                <option value="4">Llengua</option>
                <option value="5">Ciencies</option>
            </select>

        <div class="mb-3">
            <br>
            <label  class="form-label"><h5>Descripció:</h5></label>
            <textarea  class="form-control" rows="4" name="descripcio" id="descripcio"></textarea>
        </div>
            <h4 id="error" style="color:red;"></h4>
        
        <a href="usuari.php" class="btn btn-primary">Inicio</a>
        <button  type="submit" class="btn btn-success" >Enviar incidència</button>
        
        
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
    </fieldset>
    
</div>

</body>
</html>