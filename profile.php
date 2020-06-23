<?php

session_start();

require_once "scripts/helpers/database.php";

if (!isset($_SESSION['logged'])) {
    header('Location: index.php');
}

$connection = databaseConnection();

$user = getUserDataById($connection, $_SESSION['id']);

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
        <h2>Twój profil</h2>
        <section>
           <div class="left">
               <img src="img/avatar.jpg" alt="user">
           </div>
            <div class="right">
                <?php
                    if(isset($_SESSION['profileUpdated'])){
                        if($_SESSION['profileUpdated'] == true) {
                            $_SESSION['name'] = $user['name'];
                            $_SESSION['lastname'] = $user['lastname'];
                            $_SESSION['bday'] = $user['bday'];
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['phonenumber'] = $user['phonenumber'];
                            $_SESSION['admin'] = $user['admin'];
                            echo "<div class='success'><p style='color:green'>Dane użytkownika zostały zaktualizowane.</p></div>";
                        } else {
                            echo "Nie udało się zaktualizować profilu.";
                        }
                    }
                    unset($_SESSION['profileUpdated']);
                ?>
                <div class="data">
                    <h4>Imię:</h4><p><?php echo $user['name']?></p>
                </div>
                <div class="data">
                    <h4>Nazwisko:</h4><p><?php echo $user['lastname']?></p>
                </div>
                <div class="data">
                    <h4>Data urodzenia:</h4><p><?php echo $user['bday']?></p>
                </div>
                <div class="data">
                    <h4>Email:</h4><p><?php echo $user['email']?></p>
                </div>
                <div class="data">
                    <h4>Numer telefonu:</h4><p><?php echo $user['phonenumber']?></p>
                </div>
                <a href="editProfile.php"><input type="submit" name="edit_data" value="Edytuj profil"></a>
            </div>
        </section>
    </div>

</main>
<div id="footer"></div>
</body>

</html>