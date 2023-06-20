<?php
require_once 'config.php';

// Guthaben des aktuellen Benutzers aus der Datenbank abrufen

session_start();
$session_timeout = 10; // Session wird nach 10 Sek geschlossen
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//Hier brauche ich die Session von der Login Seite um den aktuellen User zu bekommen
$currentUser = $_SESSION['username'];
$sql = "SELECT Guthaben FROM users WHERE Name = '$currentUser'";
$result = $conn->query($sql);
$balance = 0;

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

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $balance = $row["Guthaben"];
}
// Namen aller Benutzer aus der Datenbank abrufen
$sqlUsers = "SELECT Name FROM users WHERE Name != '$currentUser'";
$resultUsers = $conn->query($sqlUsers);
$users = [];

if ($resultUsers->num_rows > 0) {
    while ($rowUsers = $resultUsers->fetch_assoc()) {
        $users[] = $rowUsers["Name"];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ihr Guthaben</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">   
</head>

</head>
<body>
<div >
    <ul>
    <li><a  class="a1"  href="index.php">Home</a></li>
    <li style="float: right;" ><a  class="a1" href="create.php">Benutzer erstellen</a></li>
    <li style="float: right;"><a class="a1" href="logout.php">Abmelden</a></li>
    </ul>


    
    <div class="inputs_container">
    
    <form class="form1" action="senden.php" id="login_form" method="POST">
    <h1>Hallo: <?php echo $currentUser; ?></h1>
    <h1>Ihr Guthaben: <?php echo $balance; ?></h1>
    <br><br>
    <h2>Geld senden:</h2>
    <div class="inputs_container">
        <label for="recipient">Empfänger:</label>
        <select name="recipient" id="recipient" style="height: 64px; width: 240px; margin: 15px; padding: 0px 25px; border-radius: 10px; border: none; background-color: #373e49; box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.212); color: white; font-size: 20px; transition: 0.2s;">
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
            <?php endforeach; ?>
        </select>

        <br><br>

        <label for="amount">Betrag:</label>
        <input type="number" name="amount" id="amount" placeholder="0" step="1" min="0" pattern="[0-9]+" required>

        <br><br>

        <input type="submit" value="Senden">
    </div>
    </div>
    </div>
    </form>
</body>
</html>
