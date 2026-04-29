<?php include_once "header.php";  ?>

<style>
    <?php 
    
    echo file_get_contents("../css/estadistica.css"); 
    ?>
</style>
        
    <h2 class="h1">Estadistica d'acces </h2>

        <table>
            <thead>
                <tr>
                    <th>USUARI</th>
                    <th>NOMBRE TOTAL D'ACCES</th>
                    <th>ÚLTIM ACCES</th>
                    <th>INDIDÈNCIA MÈS VISITAT</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Incidencies as $Incidencies) { ?>
                    <tr>
                        <td><?php echo $Incidencies["departament_id"] ?></td>
                        <td><?php echo $Incidencies["nombre_total_incidencia"] ?></td>
                        <td><?php echo $Incidencies["temps_total"] ?></td>
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