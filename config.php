<?php
// Verbindung zur Datenbank herstellen
$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "coinDB";

// Array mit den Verbindungsdaten erstellen
$connectionData = array(
    'servername' => $servername,
    'username' => $username,
    'password' => $password,
    'dbname' => $dbname
);
return $connectionData;
?>