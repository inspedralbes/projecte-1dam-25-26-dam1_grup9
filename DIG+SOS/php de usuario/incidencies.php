<?php
$mysqli = include_once "connexio.php";
$nombre = $_POST["nom_incidencia"];
$departament_id = $_POST["departament_id"];
$descripcion = $_POST["descripcio"];
$sentencia = $mysqli->prepare("INSERT INTO Incidencies (nom_incidencia, departament_id, descripcio) VALUES (?, ?, ?)");
$sentencia->bind_param("sis", $nom_incidencia, $departament_id, $descripcio);
$sentencia->execute();






