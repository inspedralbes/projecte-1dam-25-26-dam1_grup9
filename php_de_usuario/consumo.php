<?php include_once "header.php"; 
include_once "connexio.php"; ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="http://localhost:8080/css/estado.css">
 </head>
 <body>
    <h2 class="h1">Registre total d'incidències per departament </h2>

        <table>
            <thead>
                <tr>
                    <th>DEPARTAMENT</th>
                    <th>NOMBRE TOTAL D'INCIDÈNCIA</th>
                    <th>TEMPS INVERTIT TOTAL</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Incidencies as $Incidencies) { ?>
                    <tr>
                        <td><?php echo $Incidencies["departament_id"] ?></td>
                        <td><?php echo $Incidencies["nombre_total_incidencia"] ?></td>
                        <td><?php echo $Incidencies["temps_total"] ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <br>
    <br>
        
        <div >
            <a href="index.php" class="botones">Sortir </a>     
            
        </div>
 </body>
 </html>       
    