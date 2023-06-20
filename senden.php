<?php
require_once 'config.php';
require_once 'log.php';
$log = new Log('log.log');
//require_once  'absoluttimeout.php';

// Überprüfen, ob das Formular abgeschickt wurde
if(isset($_SESSION['username'])){

$currentUser = $_SESSION['username'];
$recipient = $_POST['recipient'];
$amount = $_POST['amount'];

// Überprüfen, ob der Betrag größer als 0 ist
if ($amount > 0) {
    // Guthaben des aktuellen Benutzers aus der Datenbank abrufen
    $sqlSender = "SELECT Guthaben FROM users WHERE Name = '$currentUser'";
    $resultSender = $conn->query($sqlSender);
    $senderBalance = 0;

    if ($resultSender->num_rows > 0) {
        $rowSender = $resultSender->fetch_assoc();
        $senderBalance = $rowSender["Guthaben"];
    }

    // Guthaben des Empfängers aus der Datenbank abrufen
    $sqlRecipient = "SELECT Guthaben FROM users WHERE Name = '$recipient'";
    $resultRecipient = $conn->query($sqlRecipient);
    $recipientBalance = 0;

    if ($resultRecipient->num_rows > 0) {
        $rowRecipient = $resultRecipient->fetch_assoc();
        $recipientBalance = $rowRecipient["Guthaben"];
    }

    // Überprüfen, ob der Sender genügend Guthaben hat
    if ($senderBalance >= $amount) {
        // Transaktion durchführen: Guthaben aktualisieren
        $senderBalance -= $amount;
        $recipientBalance += $amount;

        // Guthaben des Senders aktualisieren
        $sqlUpdateSender = "UPDATE users SET Guthaben = '$senderBalance' WHERE Name = '$currentUser'";
        $conn->query($sqlUpdateSender);
        $log -> write("[INFO] - Sender: $currentUser, Empfänger: $recipient, Betrag: $amount");

        // Guthaben des Empfängers aktualisieren
        $sqlUpdateRecipient = "UPDATE users SET Guthaben = '$recipientBalance' WHERE Name = '$recipient'";
        $conn->query($sqlUpdateRecipient);
        if($currentUser == 'admin'){
            header("Location: admin.php");
        }else
        header("Location: user.php");
        echo "Geld erfolgreich überwiesen!";
        exit();

        
    } else {
        echo "Nicht genügend Guthaben für die Überweisung!";
    }
} else {
    echo "Ungültiger Betrag für die Überweisung!";
}
}else{
    header("Location: login.php");
}