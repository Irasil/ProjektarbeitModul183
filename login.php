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
            <input type="text" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="password" placeholder="Passwort" name="password" autocomplete="off">
        </div>
        <button class="button1" name="submit">Login</button>
    </form>
    
</body>
</html>
