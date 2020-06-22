<?php
    session_start();

    if(isset($_POST['email']))
    {
        //udana walidacja? Tak
        $is_valid=true;

        //Sprawdzanie czy zostało podane imie
        $name = $_POST['name'];
        if (strlen($name) == 0)
        {
            $is_valid=false;
            $_SESSION['error_name']="Podaj imię";
        }

        //Sprawdzanie czy zostało podane nazwisko
        $lastname = $_POST['lastname'];
        if (strlen($lastname) == 0)
        {
            $is_valid=false;
            $_SESSION['error_lastname']="Podaj nazwisko";
        }

        //Sprawdzanie daty urodzenia
        $bday = $_POST['bday'];
        if (strlen($bday) == 0)
        {
            $is_valid=false;
            $_SESSION['error_bday']="Podaj datę urodzenia";
        }

        //Sprawdzanie czy pole "płeć" zostało zaznaczone

        if(isset($_POST['gender']))
        {
           $gender = $_POST['gender'];
        }
        else
        {
            $is_valid=false;
            $_SESSION['error_gender']="Zaznacz płeć";
        }


        //Sprawdzanie poprawności adresu email
        $email = $_POST['email'];
        $emailOK = filter_var($email, FILTER_SANITIZE_EMAIL);

        if ((filter_var($emailOK, FILTER_VALIDATE_EMAIL)==false) || ($emailOK!=$email))
        {
           $is_valid=false;
           $_SESSION['error_email']="Podaj poprawny adres e-mail";
        }


        //Sprawdzanie czy został podany nr telefonu
        $phonenumber = $_POST['phonenumber'];
        if (strlen($phonenumber) != 9)
        {
            $is_valid=false;
            $_SESSION['error_phonenumber']="Numer telefonu powinien składać się z 9 cyfr";
        }

        //Sprawdzanie poprawności hasła
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if ((strlen($password1)<8) || (strlen($password1)>20))
        {
           $is_valid=false;
           $_SESSION['error_password']="Hasło musi posiadać od 8 do 20 znaków";
        }
        if ($password1!=$password2)
        {
           $is_valid=false;
           $_SESSION['error_password']="Podane hasła nie są takie same";
        }

        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        //Czy regulamin został zaakceptowany?
        if (!isset($_POST['privacy_policy']))
        {
            $is_valid=false;
            $_SESSION['error_privacy_policy']="Potwierdź akceptację regulaminu";
        }

        require_once "scripts/config/database.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try
        {
            $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            if ($connection->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else {

                //Czy email już istnieje?
                $result = $connection->query("SELECT id FROM users WHERE email='$email'");

                if (!$result) throw new Exception($connection->error);

                $number_of_emails = $result->num_rows;
                if ($number_of_emails>0)
                {
                    $is_valid=false;
                    $_SESSION['error_email']="Istnieje już konto o takim adresie email!";
                }

                if ($is_valid==true)
                {
                    //Wszystkie testy zaliczone. Dodaj do bazy.
                    if ($connection->query("INSERT INTO users VALUES (NULL, '$name', '$lastname', '$bday', '$gender', '$email', '$phonenumber', '$password_hash', '$admin' )"))
                    {
                        $_SESSION['successful_registration']=true;
                        header('Location: successful_registration.php');
                    }
                    else {
                        throw new Exception($connection->error);
                    }
                }

                $connection->close();
            }
        }
        catch (Exception $error)
        {
            echo '<span style="color:red;">"Błąd serwera! Spróbuj zarejestrować się później."</span>';
            echo '<br />Informacja developerska: ' . $error;
        }

    }
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
            <form action="" method="post">
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