<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>
<body>

<div >
    <ul>
    <li><a  class="a1"  href="../index.php">Home</a></li>
    </ul>
</div>

    <form class="form1" id="login_form" action="login.php" method="post">
        <h1>Login</h1>
        <div class="inputs_container">
            <input type="text" pattern="^[^';-]+$" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="password" pattern="^[^';-]{8,}$" placeholder="Passwort" name="password" autocomplete="off">
        </div>
        <button class="button1" name="submit">Login</button>
    </form>
    
</body>
</html>

<?php
// Verbindung zur Datenbank herstellen
require_once 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Überprüft, ob die Verbindung erfolgreich hergestellt wurde
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

// Überprüft, ob das Formular abgeschickt wurde
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL-Abfrage zum Überprüfen der Anmeldedaten
    $sql = "SELECT * FROM users WHERE Name = '$username' AND Passwort = '$password'";
    $result = $conn->query($sql);

    // Überprüft, ob ein Datensatz mit den angegebenen Anmeldedaten gefunden wurde
    if ($result->num_rows > 0) {
        // Anmeldung erfolgreich
        echo "Anmeldung erfolgreich!";
    } else {
        // Anmeldung fehlgeschlagen
        echo "Anmeldung fehlgeschlagen. Bitte überprüfe deine Anmeldedaten.";
    }
}

// Verbindung zur Datenbank schliessen
$conn->close();
?>