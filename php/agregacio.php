<?php require_once "logger.php";

$totalaccess = $collection->countDocuments([]); //Compta el total de documents

$pagines = [
    [
        '$unwind' => '$url'
    ],
];
?>