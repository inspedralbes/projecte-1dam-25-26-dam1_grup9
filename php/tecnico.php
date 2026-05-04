
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Opciones</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    
    	button {
            display: block;
            width: 200px;
            margin: 10px ;
            padding: 12px;
            font-size: 16px;
            cursor: pointer;
        }
        .inicio {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #ccc;
            border: none;
            cursor: pointer;
        }

        .inicio:hover {
            background-color: #aaa;
        }
    </style>
</head>
<body >

<div>

    
    <form action="lista_actuacio.php" method="get">
        <button type="submit">Registrar actuació</button>
    </form>

    
    <form action="informe.php" method="get">
        <button type="submit">Informes</button>
    </form>

    <br><br>
    <a href="index.php" class="inicio">Inicio</a>

</div>

</body>
</html>