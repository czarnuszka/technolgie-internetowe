<?php

	session_start();

	session_unset();

	header('Location: ../signIn.php');

?>