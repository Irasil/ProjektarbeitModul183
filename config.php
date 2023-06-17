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
$conn = new mysqli($servername, $username, $password, $dbname);
return $connectionData;
?>