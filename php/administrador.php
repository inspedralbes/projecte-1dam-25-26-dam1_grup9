<?php include_once "logger.php"?>
<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Opciones</title>
    <link rel="stylesheet" href="css/menu.css">
</head>
<body >

<div>
    <form action="informe.php" method="get">
        <button type="submit">Informe de Tècnics</button>
    </form>

    <form action="informe_actuacio.php" method="get">
        <button type="submit">Informe d'actuació</button>
    </form>

    <form action="lista_prioritat.php" method="get">
        <button type="submit">Modificar incidencia</button>
    </form>

    <form action="consumo.php" method="get">
        <button type="submit">Consum per departament</button>
    </form>
    
    <form action="estadistica.php" method="get">
        <button type="submit">Estadístiques d'Accés</button>
    </form>

   
    <br>
    <a href="index.php" class="inicio">Salir</a>


</div>

</body>
</html>