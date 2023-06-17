<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Erstellen</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
</head>
<body>

<div >
    <ul>
    <li><a  class="a1"  href="index.php">Home</a></li>
    </ul>
</div>

    <form class="form1" id="login_form" action="create.php" method="post">
        <h1>User Erstellen</h1>
        <div class="inputs_container">
            <input type="text" pattern="^[^';-]+$" placeholder="Benutzername" name="username" autocomplete="off">
            <input type="text" pattern="^[^';-]+$" placeholder="Email" name="email" autocomplete="off">
            <input type="password" pattern="^[^';-]{8,}$" placeholder="Passwort" name="password" autocomplete="off">
            
        </div>
        <button class="button1" name="submit">Erstellen</button>
    </form>
    
</body>
</html>
