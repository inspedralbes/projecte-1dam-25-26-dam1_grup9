<!DOCTYPE html>
<html lang="es">
<body>

<?php
    include_once "header.php";       
?>

<style>
    <?php 
    
    echo file_get_contents("../css/style.css"); 
    ?>
</style>
<form >
    
   <a href="crear_incidencia.php" class="index">Crear una incidencia <br></a>
    <br> 
    <br>
   <a  href="ver_estado.php" class="index">Para ver estado de incidencia <br></a>
    <br>
    <br>
   <a  href="consumo.php" class="index">Consumo por departamento <br></a>
    <br>
    <br>
   <a href="estadistica.php"  class="index">Estadistica de acceso <br></a>
        
</form>

</body>
</html>