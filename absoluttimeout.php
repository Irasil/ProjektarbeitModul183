<?php
session_start();

// Setze das absolute Timeout (in Sekunden)
$absoluteTimeout = 5; // Timeout von 30 Minuten 1800

// Überprüfe, ob die Session bereits gestartet wurde
if (isset($_SESSION['start_time'])) {
    // Berechne die vergangene Zeit seit dem Sitzungsbeginn
    $elapsedTime = time() - $_SESSION['start_time'];

    // Überprüfe das absolute Timeout
    if ($elapsedTime > $absoluteTimeout) {
        session_start();
        session_unset();
        session_destroy();
        header('Location: logout.php');
    }
    
} else {
    // Setze den Sitzungsbeginn
    $_SESSION['start_time'] = time();
}
