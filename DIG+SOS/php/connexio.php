<?php
$host = "";
$usuari = "admin";
$contrasenia = "ProjecteFinal_12345.";
$base_de_dades = "db";
$dbname = "Incidencies";

$mysqli = new mysqli($base_de_dades, $usuari, $contrasenia, $dbname);
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
return $mysqli;
