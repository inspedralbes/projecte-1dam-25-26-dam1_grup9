<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://root:example@mongo:27017");
// mongodb+srv://a25marfajdel_db_user:ProjecteFinal_12345.@cluster0.hmpbtpj.mongodb.net/?appName=Cluster0
$collection = $client->local->user_log;
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
// Obtenim l'adreça IP origen de la petció.
// Teniu informació sobre l'operador ?? a 
// https://phpsensei.es/operadores-en-php-null-coalesce-operator/
// "Si no es pot obtenir, es fa servir 'unknown' com a valor per defecte"

$host = $_SERVER['HTTP_HOST']; //obté el domini
$uri = $_SERVER['REQUEST_URI']; //obté l'URI
$url = $protocol . "://" .$host . $uri; //Construeix l'URL completa
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown'; //Obté la IP de l'usuari
$hora = date("Y-m-d");
$method = $_SERVER['REQUEST_METHOD']; //Obté el metode que està fent l'usuari


$resultat = $collection->insertOne([
    'URL' => $url,
    'name' => 'Anonim',
    'Metode' => $method,
    'ip_origin' => $ip,
    'date' => $hora
]);
$userId= $resultat->getInsertedId(); //Consegueix l'usuari ID



// Obtenir tots els documents de la col·lecció users de la BBDD demo
// $collection = $client->demo->users; #no cal, ja que ho hem fet abans
$documents = $collection->find();

