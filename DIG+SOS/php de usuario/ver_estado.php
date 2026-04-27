<?php include_once "header.php";  ?>

<style>
    <?php 
    
    echo file_get_contents("../css/consumo.css"); 
    ?>
</style>
        
    <h2 class="h1">Estat de l'incidència</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TITOL D'INDIDÈNCIA</th>
                    <th>DEPARTAMENT</th>
                    <th>DATA DE CREACIÓ</th>
                    <th>PRIORITAT</th>
                    <th>DESCRIPCIÓ</th>
                    <th>ESTAT</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($Incidencies as $Incidencies) { ?>
                    <tr>
                        <td><?php echo $Incidencies["id"] ?></td>
                        <td><?php echo $Incidencies["nom_incidencia"] ?></td>
                        <td><?php echo $Incidencies["departament_id"] ?></td>
                        <td><?php echo $Incidencies["data_incidencia"] ?></td>
                        <td><?php echo $Incidencies["prioritat"] ?></td>
                        <td><?php echo $Incidencies["descripcio"] ?></td>
                        <td><?php echo $Incidencies["estat"] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <br>
        <br>

         <div >
            <a href="index.php" class="botones">Sortir</a>     
        </div>

        <?php



