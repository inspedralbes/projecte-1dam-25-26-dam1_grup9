<?php  
require_once "connexion.php";
include_once "logger.php";

// Convertimos a número entero para evitar ataques maliciosos (Inyección SQL)
$id = intval($_GET['codi']?? 0);
// Hacemos la consulta con el id 
$result = $conn->query("SELECT data_actuacio, descripcio, visible FROM actuacions Where incidencia_id = $id");
// Guardamos todas las actuaciones encontradas en una lista (Array)
$actuacions = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Consultar incidència</title>
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
            
            border-collapse: collapse;
            width: 90%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #8270e7;
            color: white;
        }

        fieldset{
            border: 2px solid black;
            margin: 20px auto;
            width: 70%;
            padding: 2px 15px;
            border-radius: 5px;
        
        }
    </style>
</head>

<body>

<div class="mb-3">
    <header>
        <h1>Consultar incidència</h1>
    </header>
    <?php include_once "header2.php" ?>
    <fieldset>
       <br>
        <div class="mb-3">
            <form method="GET" onsubmit="return validarForm()">
                <label  class="form-label"><h5><b>Codi incidència:</b></h5></label>
                <input  type="number" name="codi" id="codi" value="<?= htmlspecialchars($id ?? '') ?>">
                <button class="btn btn-primary" type="submit" >Buscar</button>
                <h4 id="error" style="color:red;"></h4>
            </form>
            <script>
                // Función de JavaScript para comprobar que los campos no estén vacíos
                //( si esta vacio muestra un mensaje de error) antes de enviar a PHP
                function validarForm(){

                let codi = document.getElementById("codi").value;
                let error = "";

                // Da error si está vacío, si no es un número (isNaN) o si es menor o igual a 0
                if(codi == "" || isNaN(codi) || parseInt(codi) <= 0){
                    error += "Id invàlid<br>";
                }

                // Si existe algún error saldrá un mensaje de color rojo y los datos no se envia
                if(error != ""){
                    document.getElementById("error").innerHTML = error;
                    return false; // Al devolver false, el formulario NO se envía
                }

                return true; // Al devolver true, el formulario se envía al PHP 
            }
            </script>
        </div>

        <h5><b>Actuacions visibles</b></h5>

        <table>
            <tr>
                <th>Data</th>
                <th>Descripció</th>
            </tr>
            <!--Comprueba si el id es válido y
             si la lista '$actuacions' contiene al menos una fila guardada (> 0)-->
            <?php if ($id && count($actuacions) > 0): ?>
                
                    // Recorre fila por fila y los datos de la fila se guardan en la variable '$a'.
                    <?php foreach ($actuacions as $a): ?>
                        <?php if ($a['visible'] == 1) { ?>
                                <tr>
                                    <td><?= $a['data_actuacio'] ?></td>
                                    <td><?= htmlspecialchars($a['descripcio']) ?></td>
                                </tr> 
                        <?php
                        }
                        ?>
                    <?php endforeach; ?>
            // Si al buscar el ID, la lista estaba vacía se mostrará un mensaje
            <?php elseif ($id): ?>
                <tr>
                    <td colspan="3">No hi ha actuacions visibles</td>
                </tr>
            <?php endif; ?>
        </table>
        <br>
            <div style="text-align: left;">
                <a class="btn btn-primary" href="usuari.php" >Sortir</a>
            </div>
        <br>
    </fieldset>
 </div>    
 
</body>
</html>
