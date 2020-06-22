<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
}

require_once "scripts/config/database.php";

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
        <h2>Użytkownicy serwisu</h2>
        <section>
            <div class="usersList">
                <?php
                    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    $result = $connection->query("SELECT * FROM users");

                    if (mysqli_connect_errno()) {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    exit();
                    }

                    $data = $result->fetch_all(MYSQLI_ASSOC);

                    echo '<p><b>Liczba użytkowników: ' . count($data) . '</b></p>';

                    if (isset($_SESSION['profileUpdated'])) {
                        if ($_SESSION['profileUpdated'] == true) {
                            echo "<div class='success'><p style='color:green'>Dane użytkownika zostały zaktualizowane.</p></div>";
                        } else {
                            echo "Nie udało się zaktualizować profilu.";
                        }
                    }
                    unset($_SESSION['profileUpdated']);

                    echo '<table>';
                    echo '<tr><td><b>Id</b></td><td><b>Imie</b></td><td><b>Nazwisko</b></td><td><b>Data urodzenia</b></td><td><b>Email</b></td><td><b>Nr telefonu</b></td><td><b>Admin</b></td></tr>';

                    foreach ($data as $user) {
                            echo '<tr>';
                            echo '<td>' . $user['id'] . '</td>';
                            echo '<td>' . $user['name'] . '</td>';
                            echo '<td>' . $user['lastname'] . '</td>';
                            echo '<td>' . $user['bday'] . '</td>';
                            echo '<td>' . $user['email'] . '</td>';
                            echo '<td>' . $user['phonenumber'] . '</td>';
                            echo '<td>' . $user['admin'] . '</td>';
                            echo '<td><form action="editUsersProfile.php" method="post">
                                    <input type="hidden" name="user_id" value="' . $user['id'] .'">
                                    <input type="submit" value="Edytuj">
                                  </form></td>';
                            echo '<td><form action="scripts/deleteUser.php" method="post">
                                        <input type="hidden" name="user_id" value="' . $user['id'] .'">
                                        <input type="submit" value="Usuń">
                                  </form></td>';
                            echo '</tr>';
                        }
                        echo '</table>';

                ?>
    </div>
    </section>
    </div>

</main>
<div id="footer"></div>
</body>

</html>


