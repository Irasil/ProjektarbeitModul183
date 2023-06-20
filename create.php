<?php
require_once 'config.php';
require_once 'log.php';
$log = new Log('log.log');
require_once  'absoluttimeout.php';

// Überprüfen, ob das Formular abgeschickt wurde
if (isset($_POST['submit'])) {
    // Benutzername, E-Mail, Passwort und Guthaben aus den Formulardaten abrufen
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $amount = $_POST['amount'];
    $role = $_POST['role'];

    // Überprüfen, ob alle Felder ausgefüllt sind
    if (!empty($username) && !empty($email) && !empty($password) && !empty($amount) && !empty($role)) {
        // Überprüfen, ob der Benutzername bereits existiert
        $sqlCheckUsername = "SELECT * FROM users WHERE Name = ?";
        $stmtCheckUsername = $conn->prepare($sqlCheckUsername);
        $stmtCheckUsername->bind_param("s", $username);
        $stmtCheckUsername->execute();
        $resultCheckUsername = $stmtCheckUsername->get_result();

        if ($resultCheckUsername->num_rows > 0) {
            $usernameError = "Der Benutzername existiert bereits. Bitte wählen Sie einen anderen Benutzernamen.";
        } else {
            // Das Passwort hashen, bevor es in die Datenbank gespeichert wird
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // SQL-Befehl zum Einfügen der Benutzerdaten in die Datenbank
            $sqlInsertUser = "INSERT INTO users (Name, Email, Passwort, Guthaben, Rolle) VALUES (?, ?, ?, ?, ?)";
            $stmtInsertUser = $conn->prepare($sqlInsertUser);
            $stmtInsertUser->bind_param("sssis", $username, $email, $hashedPassword, $amount, $role);

            // Datenbankabfrage ausführen
            if ($stmtInsertUser->execute()) {
                echo "Benutzer erfolgreich erstellt.";
                $log->write("[CREATED] - Benutzer " . $username .  " erfolgreich erstellt.");
                header("Location: admin.php");
                exit;
            } else {
                echo "Fehler beim Erstellen des Benutzers: " . $stmtInsertUser->error;
                $log->write("[ERROR] - Fehler beim Erstellen des Benutzers: " . $stmtInsertUser->error);
            }
        }
    } else {
        echo "Bitte füllen Sie alle Felder aus.";
    }
}

// Verbindung zur Datenbank schließen
$conn->close();
?>

<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer Erstellen</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
    <script src="timeout.js"></script>
</head>

<body>


    <div>
        <ul>
            <li><a class="a1" href="index.php">Home</a></li>
            <li style="float: right;"><a class="a1" href="logout.php">Abmelden</a></li>
            <li style="float: right;"><a class="a1" href="admin.php">Meine Coins</a></li>
            <li style="float: right;"><a class="a1" href="overview.php">Coins Managen</a></li>
        </ul>
    </div>
    <div class="inputs_container">
    <div id="popupContainer"></div>
    <form class="form1" id="login_form" action="create.php" method="post">
    
        <h1>Benutzer Erstellen</h1>
        <div class="inputs_container">
            <input type="text" pattern="[a-zA-Z0-9äüöéèàêç]{3,}" placeholder="Benutzername" name="username" autocomplete="off">
            <?php if (isset($usernameError)) : ?>
                <p class="error"><?php echo $usernameError; ?></p>
            <?php endif; ?>
            <input type="text" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" placeholder="Email" name="email" autocomplete="off">
            <input type="password" pattern="[a-zA-Z0-9äüöéèàêç]{3,}" placeholder="Passwort" name="password" autocomplete="off">
            <input type="number" name="amount" id="amount" placeholder="Guthaben" min="0" pattern="[0-9]+" required>
            <select name="role" id="role" style="height: 64px; width: 240px; margin: 15px; padding: 0px 25px; border-radius: 10px; border: none; background-color: #373e49; box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.212); color: white; font-size: 20px; transition: 0.2s;">
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button class="button3" name="submit">Erstellen</button>
        </div>
    </form>
</div>

</body>

</html>