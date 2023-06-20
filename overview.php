<?php
require_once 'config.php';
require_once 'log.php';
$log = new Log('log.log');

// Überprüfen, ob das Formular abgeschickt wurde
if (isset($_POST['submit'])) {
    // Benutzername und Guthaben aus den Formulardaten abrufen
    $username = $_POST['name'];
    $amount = $_POST['balance'];
    
    // Überprüfen, ob alle Felder ausgefüllt sind
    if (!empty($username) && !empty($amount)) {
        // SQL-Befehl zum Aktualisieren des Guthabens in der Datenbank
        $sqlUpdateBalance = "UPDATE users SET Guthaben = ? WHERE Name = ?";
        
        // Vorbereiten der SQL-Abfrage
        $stmt = $conn->prepare($sqlUpdateBalance);
        
        // Parameter binden
        $stmt->bind_param("is", $amount, $username);
        
        // Abfrage ausführen
        if ($stmt->execute()) {
            $log->write("[UPDATED] - Guthaben von Benutzer " . $username .  " erfolgreich aktualisiert.");
            header("Location: overview.php");
            exit;
        } else {
            $log->write("[ERROR] - Fehler beim Aktualisieren des Guthabens: " . $stmt->error);
        }
        
        // Statement schließen
        $stmt->close();
    } else {
        echo "Bitte füllen Sie alle Felder aus.";
    }
}

// Verbindung zur Datenbank schließen


session_start();
$session_timeout = 1000000; // Session wird nach 10 Sek geschlossen
$currentUser = $_SESSION['username'];

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
if (!isset($_SESSION['last_visit'])) {
    $_SESSION['last_visit'] = time();
  }
  if((time() - $_SESSION['last_visit']) > $session_timeout) {
    session_unset();
    session_destroy();
    header('Location: login.php');
  }
  $_SESSION['last_visit'] = time();


// Namen aller Benutzer aus der Datenbank abrufen
$sqlUsers = "SELECT * FROM users WHERE Name != '$currentUser'";
$resultUsers = $conn->query($sqlUsers);
$usersname = [];
$userscoin = [];

if ($resultUsers->num_rows > 0) {
    while ($rowUsers = $resultUsers->fetch_assoc()) {
        $usersname[] = $rowUsers["Name"];
        $userscoin[] = $rowUsers["Guthaben"];
    }
}

// Daten aus der Benutzertabelle abrufen
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Management</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
</head>
<body>

<div>
    <ul>
        <li><a class="a1" href="index.php">Home</a></li>
        <li style="float: right;" ><a  class="a1" href="create.php">Benutzer erstellen</a></li>
        <li style="float: right;"><a class="a1" href="logout.php">Abmelden</a></li>
    </ul>
</div>
<div >

<table class="table1">
        <thead>
            <tr>
                <th>Name</th>
                <th></th>
                <th>Guthaben</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['Name']; ?></td>
                    <td>
                        <form class="form2" action="overview.php" method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['Name']; ?>">
                           
                        
                    </td>
                    <td><?php echo $user['Guthaben']; ?></td>
                    <td>    
                            <input type="hidden" name="name" id="name" value="<?php echo $user['Name']; ?>">
                            <input type="number" name="balance" id="balance" value="">
                            <button class="button2" name="submit" type="submit">Speichern</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
     </div >
</body>
</html>