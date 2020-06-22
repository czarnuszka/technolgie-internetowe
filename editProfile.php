<?php

session_start();

require_once "scripts/helpers/displayError.php"

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
            echo '<a href="scripts/logout.php" class="header-login">Wyloguj się!</a>';
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
                <input type="file" value="Zmień avatar">
            </div>
            <div class="right">
                <form action="scripts/updateProfile.php" method="post">

                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id']?>">
                    <input type="hidden" name="redirect_success" value="../profile.php">
                    <input type="hidden" name="redirect_error" value="../editProfile.php">

                    <div class="data">
                        <h4>Imię:</h4><input type="text" name="name" value="<?php echo $_SESSION['name']?>">
                    </div>
                    <div class="data">
                        <h4>Nazwisko:</h4><input type="text" name="lastname" value="<?php echo $_SESSION['lastname']?>">
                    </div>
                    <div class="data">
                        <h4>Data urodzenia:</h4><input type="text" name="bday" value="<?php echo $_SESSION['bday']?>">
                    </div>
                    <div class="data">
                        <h4>Email:</h4><input type="text" name="email" value="<?php echo $_SESSION['email']?>">
                    </div>
                    <div class="data">
                        <h4>Numer telefonu:</h4><input type="text" name="phonenumber" value="<?php echo $_SESSION['phonenumber']?>">
                    </div>
                    <div class="data">
                        <h4>Wprowadż stare hasło:</h4><input type="password" name="old_password">
                        <h4>Wprowadż nowe hasło:</h4><input type="password" name="new_password">
                        <h4>Powtórz nowe hasło:</h4><input type="password" name="repeat_new_password">
                        <?php
                            echo displaySessionErrors('error_password');
                        ?>
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