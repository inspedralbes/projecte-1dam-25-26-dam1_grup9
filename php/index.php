<?php include_once "logger.php"?>

<?php include_once "header.php"; ?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Usuari</title>
    <style>
    body {
        height: 100vh;
        font-family: Arial;
        background: linear-gradient(135deg, #0648c4be, #25117e);
        color: white;
        padding: 15px 35px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 10px;
        text-align: center;
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
<body>

<div >

    <form action="usuari.php" method="get">
        <button type="submit">Usuari</button>
    </form>

    <form action="elegir_tecnico.php" method="get">
        <button type="submit">Tècnic</button>
    </form>

    <form action="administrador.php" method="get">
        <button type="submit">Administrador</button>
    </form>

</div>

</body>
</html>