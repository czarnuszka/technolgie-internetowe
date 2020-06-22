<?php

	session_start();

    if (!isset($_SESSION['successful_registration']))
	{
		header('Location: index.php');
		exit();
	}
    else {
        unset($_SESSION['successful_registration']);
    }

?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Skate~Tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/forms.css">
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
    <nav id="no-account">
        <a href="signIn.php" class="header-login">Zaloguj się!</a>
    </nav>


</header>
<main>
    <div class="wrapper">
        <div class="successful_registration">
            Dziękujemy za rejestrację w serwisie! <br />Teraz możesz zalogować się na swoje konto!
        </div>
    </div>
</main>
<div id="footer"></div>
</body>

</html>