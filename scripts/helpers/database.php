<?php
//DIR pobranie ścieżki bieżącego pliku w kontekście serwera www
require_once __DIR__ . "/../config/database.php";

//Konfiguracja połączenia z bazą danych
function databaseConnection() : mysqli {
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($connection->connect_errno!=0)
    {
        die ("Error: " . $connection->connect_errno);
    }

    return $connection;
}

//Pobieranie danych użytkownika z bazy
function getUserDataById(mysqli $connection, int $id) : array {
    $statement = $connection->prepare("SELECT * FROM users WHERE id=?");
    $statement->bind_param('i', $id);

    $result = $statement->execute();

    if(!$result) {
        return [];
    }

    $userDbObject = $statement->get_result();

    $statement->close();

    return $userDbObject->fetch_assoc();
}