<?php
require_once 'log.php';
$log = new Log('log.log');

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

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception('Fehler beim Verbinden mit der Datenbank: ' . $conn->connect_error);
    }
} catch (Exception $e) {
    $log->write('[FATAL] - ' . $e->getMessage());
    header("Location: ups.php");
    exit;
}
return $connectionData;
