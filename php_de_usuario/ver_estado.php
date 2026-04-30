<?php include_once "header.php";  
require_once "connexio.php";

$result = $conn->query("SELECT * FROM incidencies");
$Incidencies = $result -> fetch_all(MYSQLI_ASSOC);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2 >Estat de l'incidència</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <!--<th>TITOL D'INDIDÈNCIA</th> -->
                    <th>DEPARTAMENT</th>
                    <th>DATA DE CREACIÓ</th>
                    <th>PRIORITAT</th>
                    <th>DESCRIPCIÓ</th>
                    <th>ESTAT</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Incidencies as $in) { ?>
                    <tr>
                        <td> 
                            <?php echo $in["id"] ?>
                        </td>
                        <td><?php //echo $Incidencies["nom_incidencia"] ?></td>
                        <td><?php echo $in["departament_id"] ?></td>
                        <td><?php echo $in["data_incidencia"] ?></td>
                        <td><?php echo $in["prioritat"] ?></td>
                        <td><?php echo $in["descripcio"] ?></td>
                        <td><?php echo $in["estat"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <br>
        <br>

         <div >
            <a href="index.php" class="botones">Sortir</a>     
        </div>

        
</body>
</html>        
    


