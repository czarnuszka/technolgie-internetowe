<?php
	session_start();

	if ((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: ../skatetour/index.php');
		exit();
	}

?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
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
        <p>Nie posiadasz jeszcze konta?</p><a href="signUp.php" class="header-login">Zarejestuj się!</a>
    </nav>
</header>
<main>
    <section class="form">
        <div class="form-style">
            <h1>LOGOWANIE</h1>
            <form action="scripts/signin.php" method="post">
                <div class="section">Podaj dane do logowania</div>
                <div class="inner-wrap">
                    <label>
                        <input type="email" name="login" placeholder="Adres email" />
                    </label>
                    <label>
                        <input type="password" name="password" placeholder="Hasło" />
                    </label>
                </div>

                <div class="button-section">
                        <span class="remember-password">
                            <label>
                                <input type="checkbox">Zapamiętaj hasło
                            </label>
                                <?php
                                if(isset($_SESSION['error']))	echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                        </span>
                    <input type="submit" name="Sign In" value="Zaloguj się" />
                </div>
            </form>
        </div>
    </section>
</main>
<div id="footer"></div>
</body>

</html>