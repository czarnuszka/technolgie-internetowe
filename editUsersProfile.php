<?php

session_start();

//if(!isset($_SESSION['admin'])) {
//    header("Location: index.php");
//}

require_once "scripts/config/database.php";

$userId = $_POST['user_id'];
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$result = $connection->query("SELECT * FROM users WHERE id = " . $userId);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

$user = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/profile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $("#navigationMenu").load("navigationMenu.php");
            $("#footer").load("footer.html");
        });
    </script>
</head>

<body>
<header>
    <div id="navigationMenu"></div>
    <nav id="login">
        <!-Logowanie-->
        <?php
        if (isset($_SESSION['logged'])) {
            echo '<a href="scripts/logout.php" class="header-logout">Wyloguj się!</a>';
            echo '<a href="profile.php" class="header-loggedin">Witaj ' . $_SESSION['name'] . '</a>';
        } else {
            echo '<a href="signUp.php" class="header-login">Załóż konto</a>';
            echo '<a href="signIn.php" class="header-login">Zaloguj się</a>';
        }
        ?>

    </nav>
</header>
<main>
    <div class="wrapper">
        <h2>Edytuj profil</h2>
        <section>
            <div class="left">
                <img src="img/avatar.jpg" alt="user">
            </div>
            <div class="right">
                <form action="scripts/updateProfile.php" method="post">

                    <input type="hidden" name="user_id" value="<?php echo $user['id']?>">
                    <input type="hidden" name="redirect_error" value="../editUsersProfile.php">
                    <input type="hidden" name="redirect_success" value="../usersAdministration.php">

                    <div class="data">
                        <h4>Imię:</h4><input type="text" name="name" value="<?php echo $user['name']?>">
                    </div>
                    <div class="data">
                        <h4>Nazwisko:</h4><input type="text" name="lastname" value="<?php echo $user['lastname']?>">
                    </div>
                    <div class="data">
                        <h4>Data urodzenia:</h4><input type="text" name="bday" value="<?php echo $user['bday']?>">
                    </div>
                    <div class="data">
                        <h4>Email:</h4><input type="text" name="email" value="<?php echo $user['email']?>">
                    </div>
                    <div class="data">
                        <h4>Numer telefonu:</h4><input type="text" name="phonenumber" value="<?php echo $user['phonenumber']?>">
                    </div>

                    <input type="submit" name="edit_data" value="Zapisz zmiany">
                </form>
            </div>

        </section>
    </div>

</main>
<div id="footer"></div>
</body>

</html>