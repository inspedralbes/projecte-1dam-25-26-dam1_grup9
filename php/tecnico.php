
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
            
        }
    
    	button {
            display: block;
            width: 200px;
            margin: 10px auto;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
        }
        
        .inicio {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #2d59e9;
            border: none;
            color: white;
        }

        .inicio:hover {
            background-color: #55a5da;
        }
    </style>
</head>
<body >

<div>

    
    <form action="lista_actuacio.php" method="get">
        <button type="submit">Registrar actuació</button>
    </form>

    <form action="lista_prioritat.php" method="get">
        <button type="submit">Modificar incidencia</button>
    </form>

    <form action="informe.php" method="get">
        <button type="submit">Informes</button>
    </form>

   

    <br><br>
    <a href="index.php" class="inicio">Inicio</a>

</div>

</body>
</html>