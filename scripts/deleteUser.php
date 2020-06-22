<?php

session_start();

require_once "helpers/database.php";

//Obiekt połączenia mysqli
$connection = databaseConnection();

$userId = $_POST['user_id'];

//Przygotowanie zapytania o usunięcie użytkownika w bazie danych
//oraz skojarzenie konkretnych parametrów przy użyciu techniki prepared statement
$statement = $connection->prepare("DELETE FROM users WHERE id=?");
$statement->bind_param('i', $userId);

//Informacja zwrotna z bazy danych na temat powodzenia wykonywanej operacji
$result = $statement->execute();

//zamknięcie połączenia
$statement->close();

if(!$result) {
    header('Location: ../usersAdministration.php?error=UserNotDeleted');
}

header('Location: ../usersAdministration.php?success=UserDeleted'); //TODO: użyć $_GET['success'] w usersAdministration.php

?>