<?php

session_start();

?>

<a href="index.php" class="header-brand">Skate~Tour</a>
<nav id="pages">
    <ul>
        <li><a href="news.html">Aktualności</a> </li>
        <li><a href="about.html">O nas</a> </li>
        <li><a href="contact.html">Kontakt</a> </li>
        <?php if(isset($_SESSION['admin']) && true === $_SESSION['admin']) echo "<li><a href=\"usersAdministration.php\">Panel Administracyjny</a> </li>" ?>
    </ul>
</nav>
