<?php include_once "logger.php"?>

<?php include_once "header.php"; ?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Usuari</title>
    <link rel="stylesheet" href="css/menu.css">
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