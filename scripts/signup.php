<?php
session_start();

if(isset($_POST['email'])) {
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

    require_once "config/database.php";
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
                if ($connection->query("INSERT INTO users VALUES (NULL, '$name', '$lastname', '$bday', '$gender', '$email', '$phonenumber', '$password_hash', 0)"))
                {
                    $_SESSION['successful_registration']=true;
                    header('Location: ../successful_registration.php');
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
        echo '<span style="color:red;">"Błąd serwera! Spróbuj zarejestrował się później."</span>';
        echo '<br />Informacja developerska: ' . $error;
    }

    header('Location: ../signUp.php');
}

