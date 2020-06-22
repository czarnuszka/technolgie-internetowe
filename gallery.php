<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Galeria zdjęć</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/gallery.css">
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
    <section class="gallery-links">
        <div class="wrapper">
            <h2>Galeria zdjęć</h2>

            <div class="gallery-container">
                <?php

                include_once 'scripts/config/database.php';
                $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $result = $connection->query("SELECT * FROM gallery");

                $sql = "SELECT * FROM gallery ORDER BY orderGallery DESC;";
                $stmt = mysqli_stmt_init($connection);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL statement failed";
                } else {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<a href="#">
                        <div style="background-image: url(img/gallery/'.$row["imgFullNameGallery"].');"></div>
                        <h3>'.$row["titleGallery"].'</h3>
                        <p>'.$row["descGallery"].'</p>
                    </a>';
                    }
                }


                ?>
            </div>
            <?php
            if (isset($_SESSION['admin'])) {
                echo '<div class="gallery-upload">
                <form action="scripts/gallery_upload.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="filename" placeholder="File name...">
                    <input type="text" name="filetitle" placeholder="Image title...">
                    <input type="text" name="filedesc" placeholder="Image description...">
                    <input type="file" name="file">
                    <button type="submit" name="submit">UPLOAD</button>

                </form>
            </div>';
            }


            ?>
        </div>

    </section>
</main>
<div id="footer"></div>
</body>

</html>