<?php
require_once "connexion.php";
require_once "logger.php";

// Función para guardar la incidencia en la base de datos
function crear_incidencia($conn){

    // Recogemos los datos puesto en el formulario. Si no existen, quedan vacíos
    $departamento = $_POST['departament_id'];
    $descripcion = $_POST['descripcio'];
    $data= date('Y-m-d H:i:s'); // Guardamos también la fecha y hora actual de la creación de la incidencia

     // ERROR: si no pone el departamento o la descripción se muestra un error y detiene el proceso
    if (empty($departamento) || empty($descripcion)) {
        echo "<p style='color:red;text-align:center;'>Error: camps buits</p>";
        return;
    }

    // Preparamos la consulta 
    $sql = "INSERT INTO incidencies (departament_id, descripcio, data_obertura) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    // Enlazamos los parametros  ("iss" = sencer, text, text)
    $stmt->bind_param("iss", $departamento, $descripcion, $data);

    // Si la bbdd acepta los datos correctamente, muestra un mensaje
    if ($stmt->execute()) :?>
        <div class="mensaje">
           <h1>Incidència creada correctament</h1>
           <h2><u>ID de la incidència:  <?php echo $conn->insert_id; ?></u></h2>
            <p><a href='index.php' class="btn btn-primary">Salir</a></p> 
        </div>
         
    <?php endif;

    $stmt->close(); // Cerramos la consulta
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nova Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">   
    <style>

        .mensaje{
            margin-top:20%;
            color:green;
            text-align:center

        }
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
    // Al ùlsar el botón de enviar (POST), procesamos los datos
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
    </fieldset>
    <script src="js/crear.js"></script>
</div>

</body>
</html>