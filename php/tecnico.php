<?php include_once "logger.php"?>
<?php
// Busca el ID del técnico en la URL de dos formas distintas.
// Primero mira si existe '?tecnic_id=X'. Si no existe, mira si existe '?id=X'.
// Si encuentra alguno, lo guarda en '$id_tecnic'. Si no encuentra ninguno, lo deja vacío ('').
$id_tecnic = isset($_GET['tecnic_id']) ? $_GET['tecnic_id'] : (isset($_GET['id']) ? $_GET['id'] : '');

// Si '$id_tecnic' está vacío te envia inmediatamente al archivo php para que eligas una
if (empty($id_tecnic)) {
    header("Location: elegir_tecnico.php");
    exit();
}
?>
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
    
    <form action="lista_actuacio.php" >
        <!--Enviamos el '$id_tecnic' a "lista_actuacio.php"-->
         <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_tecnic); ?>">
        <button type="submit">Registrar actuació</button>
    </form>


    <form action="informe_tecnico.php">
        <!--Enviamos el '$id_tecnic' a "informe_tecnico.php"-->
         <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_tecnic); ?>">
        <button type="submit">Informes</button>
    </form>

    <br>
    <a href="index.php" class="btn btn-primary">Salir</a>

</div>

</body>
</html>