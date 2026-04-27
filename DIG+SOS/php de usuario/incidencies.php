<?php
$mysqli = include_once "connexio.php";
$nombre = $_POST['nom_incidencia'];
$departament_id = $_POST['departament_id'];
$descripcion = $_POST['descripcio'];
$sentencia = $mysqli->prepare("INSERT INTO incidencies (nombre, departament_id, descripcion) VALUES (?, ?, ?)");
$sentencia->bind_param("sss", $nombre, $departament_id, $descripcion);
$sentencia->execute();
?>





