<?php include_once "logger.php"?>
<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Opciones</title>
    <style>
        body {
            text-align: center;
            height: 100vh;
            font-family: Arial;
            background: linear-gradient(135deg, #0648c4be, #25117e);
            color: white;
            padding: 15px 35px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 10px;
            margin-top: 10%;
            
        }
    
    	button {
            display: block;
            width: 200px;
            margin: 10px auto;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        
    </style>
</head>
<body >

    <form action="crear_incidencia.php" method="get">
        <button type="submit">Registrar nova incidència</button>
    </form>

    <form action="ver_estado.php" method="get">
        <button type="submit">Consulta l'estat d'incidència</button>
    </form>

     

</body>
</html>
