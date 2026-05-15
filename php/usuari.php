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

    <form action="crear_incidencia.php" method="get">
        <button type="submit">Registrar nova incidència</button>
    </form>

    <form action="ver_estado.php" method="get">
        <button type="submit">Consulta l'estat d'incidència</button>
    </form>

    <br>
    <a href="index.php" class="inicio">Salir</a>
</body>
</html>
