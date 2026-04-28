<?php
$host = "127.0.0.1";
$usuari = "admin";
$contrasenia = "ProjecteFinal_12345.";
$base_de_dades = "db";
$mysqli = new mysqli($host, $base_de_dades, $usuari, $contrasenia);
if ($mysqli->connect_errno) {
    echo "Ha fallat la connexió a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
return $mysqli;
