<?php  
require_once "connexion.php";
include_once "logger.php";

$id = intval($_GET['codi']?? 0);
$result = $conn->query("SELECT data_actuacio, descripcio, visible FROM actuacions Where incidencia_id = $id");

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
                function validarForm(){

                let codi = document.getElementById("codi").value;

                let error = "";

                if(codi == "" || isNaN(codi) || parseInt(codi) <= 0){
                    error += "Id invàlid<br>";
                }

                if(error != ""){
                    document.getElementById("error").innerHTML = error;
                    return false; 
                }

                return true; 
            }
            </script>
        </div>

        <h5><b>Actuacions visibles</b></h5>

        <table>
            <tr>
                <th>Data</th>
                <th>Descripció</th>
            </tr>
            
            <?php if ($id && count($actuacions) > 0): ?>
                    <?php foreach ($actuacions as $a): ?>
                    <?php if ($a['visible'] == 1) { ?>
                            <tr>
                                <td><?= $a['data_actuacio'] ?></td>
                                <td><?= htmlspecialchars($a['descripcio']) ?></td>
                            </tr> 
                        <?php
                        }?>
                        
                    <?php endforeach; ?>
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
