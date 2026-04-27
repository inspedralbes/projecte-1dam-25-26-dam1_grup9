<?php
$mysqli = include_once "connexio.php";
$nom = $_POST['nom_incidencia'];
$departament_id = $_POST['departament_id'];
$descripcion = $_POST['descripcio'];
$sentencia = $mysqli->prepare("INSERT INTO incidencies (nom, departament_id, descripcio) VALUES (?, ?, ?)");
$sentencia->bind_param("sss", $nom, $departament_id, $descripcion);
$sentencia->execute();
?>





