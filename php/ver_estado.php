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

        .botones {
            padding: 10px 20px;
            background-color: #4952ca;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            
        }
        .botones:hover {
            background-color: #2091d3;
        }
        fieldset{
            border: 2px solid black;
            margin: 20px auto;
            width: auto;
            padding: 2px 15px 30px ;
            border-radius: 5px;
        
        }
    </style>
</head>

<body>

<div class="box">
    <header>
        <h1>Consultar incidència</h1>
    </header>

    <fieldset>
       <br>
        <div class="form-box">
            <form method="GET" onsubmit="return validarForm()">
                <h3><b>Codi incidència:</b></h3>
                <input type="number" name="codi" id="codi" value="<?= htmlspecialchars($id ?? '') ?>">
                <button type="submit" >Buscar</button>
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

        <h3>Actuacions visibles</h3>

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
            <a href="usuari.php" class="botones">Sortir</a>
        </div>

    </fieldset>
 </div>    

</body>
</html>