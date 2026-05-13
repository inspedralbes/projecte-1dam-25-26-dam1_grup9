<?php include_once "logger.php"?>
<?php
$id_tecnic = isset($_GET['tecnic_id']) ? $_GET['tecnic_id'] : (isset($_GET['id']) ? $_GET['id'] : '');

if (empty($id_tecnic)) {
    header("Location: elegir_tecnico.php");
    exit();
}
$nom = isset($noms[$id_tecnic]) ? $noms[$id_tecnic] : "Usuari desconegut";
?>

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

    
    <form action="lista_actuacio.php" method="get">
         <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_tecnic); ?>">
        <button type="submit">Registrar actuació</button>
    </form>


    <form action="informe_tecnico.php" method="get">
         <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_tecnic); ?>">
        <button type="submit">Informes</button>
    </form>

    <br>
    <a href="index.php" class="btn btn-primary">Salir</a>

</div>

</body>
</html>