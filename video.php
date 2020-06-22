<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Filmy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/films.css">
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
    <section class="vid-style">
        <div class="wrapper">
            <h2>Jakiś tutorial</h2>
            <video width="480" height="280" controls>
                <source src="video/trailer.mp4" type="video/mp4">
            </video>
            <article>
                <h3>Opis</h3>
                <div>
                    <p>
                        "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"
                    </p>
                </div>
            </article>
        </div>
    </section>
</main>
<div id="footer"></div>
</body>

</html>