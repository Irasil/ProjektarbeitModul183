<?php
require_once 'absoluttimeout.php';
if (isset($_SESSION['username'])) {
    $popupContainer = '<div id="popupContainer"></div>'; // Erzeuge das Popup-Div
} else {
    $popupContainer = ''; // Setze das Popup-Div auf einen leeren String
}
?>

<html lang="de">

<head>
    <meta charset="UTF-8">

    <!-- Muss geändert werden = Max Chache speicher Zeit -->
    <meta http-equiv="Cache-Control" content="max-age=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aarau Coin</title>
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <script src="timeout.js"></script>
</head>

<body>


    <div>
        <ul>
            <li class="active"><a class="a1" href="index.php">Home</a></li>
            <?php ;
            if (!isset($_SESSION['username'])) : ?>
                <li style="float: right;"><a class="a1" href="login.php">Anmelden</a></li>

            <?php else : ?>
                <li style="float: right;"><a class="a1" href="logout.php">Abmelden</a></li>
                <?php
                if (isset($_SESSION['rolle'])) {
                    if ($_SESSION['rolle'] == 'administrator') {
                        echo '<li style="float: right;"><a class="a1" href="create.php">Benutzer erstellen</a></li>';
                        echo '<li style="float: right;"><a class="a1" href="overview.php">Coins Managen</a></li>';
                        echo '<li style="float: right;"><a class="a1" href="admin.php">Meine Coins</a></li>';
                    } else {
                        echo '<li style="float: right;"><a class="a1" href="user.php">Meine Coins</a></li>';
                    }
                }
                ?>

            <?php endif; ?>
        </ul>
    </div>
    

    <div class="inputs_container"><?php echo $popupContainer; ?><h1>Willkommen bei Aarau Coin</h1>

    <div class="inputs_container"><img src="coin.png" alt="Coin" width="400px" height="400px" style="margin-top: 60px ;"></div>
</div>   

</body>

</html>