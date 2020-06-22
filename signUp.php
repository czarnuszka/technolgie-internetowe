<?php
    session_start();

    require_once "scripts/signup.php"
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
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
        <p>Posiadasz już konto?</p><a href="signIn.php" class="header-login">Zaloguj się!</a>
    </nav>
</header>
<main>
    <section class="form">
        <div class="form-style">
            <h1>REJESTRACJA</h1>
            <form action="scripts/signup.php" method="post">
                <div class="section"><span>1</span>Dane podstawowe</div>
                <div class="inner-wrap">
                    <label>Imie
                        <input type="text" name="name" />
                        <?php
                            if (isset($_SESSION['error_name']))
                            {
                                echo '<div class="error">' . $_SESSION['error_name'] . '</div>';
                                unset($_SESSION['error_name']);
                            }
                        ?>
                    </label>

                    <label>Nazwisko
                        <input type="text" name="lastname" />
                        <?php
                            if (isset($_SESSION['error_lastname']))
                            {
                                echo '<div class="error">' . $_SESSION['error_lastname'] . '</div>';
                                unset($_SESSION['error_lastname']);
                            }
                        ?>
                    </label>

                    <label>Data urodzenia
                        <input type="date" id="date" name="bday">
                        <?php
                            if (isset($_SESSION['error_bday']))
                            {
                                echo '<div class="error">' . $_SESSION['error_bday'] . '</div>';
                                unset($_SESSION['error_bday']);
                            }
                        ?>
                    </label>
                    Płeć<br>
                    <div class="gender">
                        Kobieta:<input type="radio" name="gender" value="female">
                        Mężczyzna:<input type="radio" name="gender" value="male">
                        Inne:<input type="radio" name="gender" value="other">
                    </div>
                    <?php
                        if (isset($_SESSION['error_gender']))
                        {
                            echo '<div class="error">' . $_SESSION['error_gender'] . '</div>';
                            unset($_SESSION['error_gender']);
                        }
                    ?>
                    <br>
                </div>

                <div class="section"><span>2</span>Email & Telefon</div>
                <div class="inner-wrap">
                    <label>Email
                        <input type="email" name="email" />
                        <?php
                            if (isset($_SESSION['error_email']))
                            {
                                echo '<div class="error">' . $_SESSION['error_email'] . '</div>';
                                unset($_SESSION['error_email']);
                            }
                        ?>
                    </label>

                    <label>Numer telefonu
                        <input type="text" name="phonenumber" />
                        <?php
                            if (isset($_SESSION['error_phonenumber']))
                            {
                                echo '<div class="error">' . $_SESSION['error_phonenumber'] . '</div>';
                                unset($_SESSION['error_phonenumber']);
                            }
                        ?>
                    </label>
                </div>

                <div class="section"><span>3</span>Hasło</div>
                <div class="inner-wrap">
                    <label>Hasło
                        <input type="password" name="password1" />
                        <?php
                            if (isset($_SESSION['error_password']))
                            {
                                echo '<div class="error">' . $_SESSION['error_password'] . '</div>';
                                unset($_SESSION['error_password']);
                            }
                        ?>
                    </label>
                    <label>Powtórz hasło
                        <input type="password" name="password2" />
                    </label>
                </div>
                <div class="button-section">
                    <span class="privacy-policy">
                        <label>
                            <input type="checkbox" name="privacy_policy">Przeczytałem/am i akceptuję Regulamin oraz Politykę Prywatności
                            <?php
                                if (isset($_SESSION['error_privacy_policy']))
                                {
                                    echo '<div class="error">' . $_SESSION['error_privacy_policy'] . '</div>';
                                    unset($_SESSION['error_privacy_policy']);
                                }
                            ?>
                        </label>
                    </span>
                    <input type="submit" name="Sign Up" value="Zarejestruj się" />
                </div>
            </form>
        </div>
    </section>
</main>
<div id="footer"></div>
</body>

</html>