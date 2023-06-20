<?php
require_once 'absoluttimeout.php';
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
            if (!$_SESSION) : ?>
                <li style="float: right;"><a class="a1" href="login.php">Anmelden</a></li>

            <?php else : ?>
                <li style="float: right;"><a class="a1" href="logout.php">Abmelden</a></li>
                <?php
                if (isset($_SESSION['rolle'])) {
                    if ($_SESSION['rolle'] == 'administrator') {
                        echo '<li style="float: right;"><a class="a1" href="admin.php">Meine Coins</a></li>';
                    } else {
                        echo '<li style="float: right;"><a class="a1" href="user.php">Meine Coins</a></li>';
                    }
                }
                ?>

            <?php endif; ?>
        </ul>
    </div>
    

    <div class="inputs_container"><div id="popupContainer"></div><h1>Willkommen bei Aarau Coin</h1></div>

    

</body>

</html>