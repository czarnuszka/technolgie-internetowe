<?php

	session_start();

?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Skate~Tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
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
<section class="index-banner">
    <div class="vertical-center">
        <h2>ROLKI<br />Jak? Gdzie? Kiedy?</h2>
        <h1>U nas wszystkiego się dowiesz!</h1>
    </div>
</section>
<main>
    <div class="wrapper">
        <section class="index-links">
            <a href="#">
                <div class="index-boxlink-square">
                    <h3>Miejsca</h3>
                </div>
            </a>
            <a href="#">
                <div class="index-boxlink-rectangle">
                    <h3>Trasy</h3>
                </div>
            </a>
            <a href="video.php">
                <div class="index-boxlink-square">
                    <h3>Filmy</h3>
                </div>
            </a>
            <a href="gallery.php">
                <div class="index-boxlink-rectangle">
                    <h3>Galeria zdjęć</h3>
                </div>
            </a>
            <a href="#">
                <div class="index-boxlink-square">
                    <h3>Kursy</h3>
                </div>
            </a>
            <a href="#">
                <div class="index-boxlink-square">
                    <h3>Treningi</h3>
                </div>
            </a>
            <a href="#">
                <div class="index-boxlink-square">
                    <h3>Wycieczki</h3>
                </div>
            </a>
            <a href="#">
                <div class="index-boxlink-square">
                    <h3>Opinie</h3>
                </div>
            </a>
            <a href="#">
                <div class="index-boxlink-rectangle">
                    <h3>Forum</h3>
                </div>
            </a>
        </section>

    </div>
</main>
<div id="footer"></div>
</body>

</html>