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
            margin-top: 15%;
            
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

<div>
    <form action="informe.php" method="get">
        <button type="submit">Informes</button>
    </form>

    <form action="lista.php" method="get">
        <button type="submit">Lista d'incidencia</button>
    </form>
    
    <form action="estadistica.php" method="get">
        <button type="submit">Estadístiques d'Accés</button>
    </form>

    <form action="consumo.php" method="get">
        <button type="submit">Consum per departament</button>
    </form>
    <br>
    <a href="index.php" class="inicio">Salir</a>


</div>

</body>
</html>