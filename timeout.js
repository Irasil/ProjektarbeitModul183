var idleTimeout = 300000;  // 5 Minuten in Millisekunden
var idleTimer;
var logoutConfirmationTime = 5000; // 5 Sekunden in Millisekunden
var isPopupDisplayed = false;
var shouldPerformLogout = true;
var logoutConfirmationTimeout;

resetIdleTimer();

// Funktion zur Aktualisierung des Idle-Timers
function resetIdleTimer() {
    clearTimeout(idleTimer);
    idleTimer = setTimeout(showLogoutConfirmation, idleTimeout);
}

// Funktion zum Ausführen der Logout-Aktion
function logout() {
    if (shouldPerformLogout) {
        // Führe hier die Logout-Aktion durch (z.B. Seite neu laden oder AJAX-Anfrage senden)
        window.location.href = 'logout.php';
    }
}

// Funktion zur Anzeige der Logout-Bestätigung
function showLogoutConfirmation() {
    if (isPopupDisplayed) {
        return;
    }
    
    var popupContainer = document.getElementById('popupContainer');

    var popup = document.createElement('div');
    popup.innerHTML = `
        <div class="inputs_container">
            <h2>Möchten Sie angemeldet bleiben?</h2>
            <div class="buttons">
                <button id="btn-yes" class="button2">Ja</button>
                <button id="btn-no" class="button2">Nein</button>
            </div>
        </div>
    `;

    popupContainer.appendChild(popup);
    isPopupDisplayed = true;

    var btnYes = document.getElementById('btn-yes');
    var btnNo = document.getElementById('btn-no');

    btnYes.addEventListener('click', handleYesClick);
    btnNo.addEventListener('click', handleNoClick);

    // Funktion für den Klick auf "Ja"
    function handleYesClick() {
        if (popupContainer.contains(popup)) {
            popupContainer.removeChild(popup);
            isPopupDisplayed = false;
            clearTimeout(logoutConfirmationTimeout); // Timeout für Logout-Bestätigung löschen
            shouldPerformLogout = true;
            resetIdleTimer(); // Setze den Idle-Timer zurück
        }
    }

    // Funktion für den Klick auf "Nein"
    function handleNoClick() {
        if (popupContainer.contains(popup)) {
            popupContainer.removeChild(popup);
            isPopupDisplayed = false;
            shouldPerformLogout = true;
            logout();
        }
    }
    
    // Automatisches Schließen des Popups nach einer bestimmten Zeit
    logoutConfirmationTimeout = setTimeout(handleNoClick, logoutConfirmationTime);
}

// Event-Listener für Interaktionen des Benutzers
document.addEventListener('mousemove', resetIdleTimer);
document.addEventListener('keydown', resetIdleTimer);
document.addEventListener('mousedown', resetIdleTimer);

// Event-Listener für das Verlassen der Seite
window.addEventListener('beforeunload', function(event) {
    clearTimeout(idleTimer); // Stoppe den Idle-Timer, wenn die Seite verlassen wird
    clearTimeout(logoutConfirmationTimeout); // Stoppe den Logout-Bestätigungs-Timeout, wenn die Seite verlassen wird
});
