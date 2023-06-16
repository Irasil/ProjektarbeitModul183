<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>
<body>

<div >
    <ul>
    <li><a  class="a1"  href="index.php">Home</a></li>
    </ul>
</div>

    <form class="form1" id="login_form" action="login.php" method="post">
        <h1>Login</h1>
        <div class="inputs_container">
            <input type="text" pattern="^[^';-]{3,}$" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="password" pattern="^[^';-]{8,}$" placeholder="Passwort" name="password" autocomplete="off">
        </div>
        <button class="button1" name="submit">Login</button>
    </form>
    
</body>
</html>

<?php
// Verbindung zur Datenbank herstellen
$config = require_once 'config.php';
require_once 'log.php';
$log = new Log('log.log');

// Funktion zum Bereinigen der Benutzereingaben
class DataAccess
{
    private $conn;

    public function __construct($config)
    {
        $this->conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);

        // Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
        if ($this->conn->connect_error) {
            die("Verbindung zur Datenbank fehlgeschlagen: " . $this->conn->connect_error);
        }
    }

    public function getUserByUsernameAndPassword($username, $password)
    {
        $sql = "SELECT * FROM users WHERE Name = ? AND Passwort = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->fetch_assoc();
    }

    // Datenbankverbindung schließen
    public function closeConnection()
    {
        $this->conn->close();
    }
}

// Überprüfen, ob das Formular abgeschickt wurde
if (isset($_POST['submit'])) {
    $username = cleanInput($_POST['username']);
    $password = cleanInput($_POST['password']);

    // Validierung der Benutzereingaben
    if (validateUsername($username) && validatePassword($password)) {
        // Datenbankzugriffsschicht initialisieren
        $dataAccess = new DataAccess($config);

        // Benutzerdaten abrufen
        $userData = $dataAccess->getUserByUsernameAndPassword($username, $password);

        // Überprüfen, ob ein Datensatz mit den angegebenen Anmeldedaten gefunden wurde
        if ($userData) {
            // Anmeldung erfolgreich
            echo "Anmeldung erfolgreich!";
            $log->write('[INFO] - ' . $username . ' hat sich erfolgreich angemeldet!');
        } else {
            // Anmeldung fehlgeschlagen
            echo "Anmeldung fehlgeschlagen. Bitte überprüfe deine Anmeldedaten.";
            $log->write('[WARNING] - Login als ' . $username . ' fehlgeschlagen!');
        }

        // Datenbankverbindung schließen
        $dataAccess->closeConnection();
    } else {
        echo "Ungültige Benutzereingaben.";
    }
}

// Funktion zum Bereinigen der Benutzereingaben
function cleanInput($input)
{
    $cleanedInput = trim($input);
    $cleanedInput = stripslashes($cleanedInput);
    $cleanedInput = htmlspecialchars($cleanedInput);
    return $cleanedInput;
}

// Funktion zur Validierung des Benutzernamens
function validateUsername($username)
{
    if (strlen($username) >= 3) {
        return true;
    } else {
        return false;
    }
}

// Funktion zur Validierung des Passworts
function validatePassword($password)
{
    if (strlen($password) >= 8) {
        return true;
    } else {
        return false;
    }
}
?>

