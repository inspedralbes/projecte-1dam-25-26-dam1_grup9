<?php include_once "header.php";  
require_once "connexio.php";

$result = $conn->query("SELECT * FROM incidencies");
$Incidencies = $result -> fetch_all(MYSQLI_ASSOC);?>


<style>
    <?php 
    
    echo file_get_contents("../css/estado.css"); 
    ?>
</style>
        
    <h2 class="h1">Estat de l'incidència</h2>
        
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
                foreach ($Incidencies as $Incidencia) { ?>
                    <tr>
                        <td> 
                            <?php echo $Incidencia["id"] ?>
                        </td>
                        <td><?php //echo $Incidencies["nom_incidencia"] ?></td>
                        <td><?php echo $Incidencia["departament_id"] ?></td>
                        <td><?php echo $Incidencia["data_incidencia"] ?></td>
                        <td><?php echo $Incidencia["descripcio"] ?></td>
                        <td><?php echo $Incidencia["estat"] ?></td>
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



