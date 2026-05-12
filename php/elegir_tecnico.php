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
            color: black;
            padding: 15px 35px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 10px;
            margin-top: 15%;
            
        }
    
    	button {
            width: 150px;
            margin: 10px auto;
            padding: 5px;
            font-size: 16px;
            border-radius: 5px;
            background-color: #2d59e9;
            color:white;
        }
        fieldset{
            border: 2px solid black;
            margin: 20px auto;
            width: 50%;
            
            padding: 30px 15px 50px 10px;
            border-radius: 5px;
            background: white
        }
        select {
            width: 300px;
            margin: 10px 0;
            padding: 8px;
            border-radius:5px
        }
    
    </style>
</head>
<body >
<div>
    <fieldset>
        <form method="get" action="tecnico.php"> 
        <label><h4>Selecciona el teu nom: </h4></label><br>
            <select name="tecnic_id" id="tecnic_id" >
                <option value="">Seleccionar tècnic</option>
                <option value="1">Tècnic 1</option>
                <option value="2">Tècnic 2</option>
                <option value="3">Tècnic 3</option>
                <option value="4">Tècnic 4</option>
                <option value="5">Tècnic 5</option>
            </select>
        <br>

        <button type="submit"><b>Iniciar Secció</b></button>    
    </fieldset>
    
   
</div>

</body>
</html>