<?php

function validatePasswordSet(mysqli $connection, int $userId, ?string $oldPassword, ?string $newPassword, ?string $repeatNewPassword) : bool
{
    if(isset($_SESSION['error_password'])) {
        unset($_SESSION['error_password']);
    }

    if (!empty($oldPassword) && !compareUserDbPasswordById($connection, $userId, $oldPassword)) {
        $_SESSION['error_password'][] = "Podane obecne hasło jest nieprawidłowe.";
        return false;
    }

    $passwordFieldsEmpty = empty($oldPassword) && empty($newPassword) && empty($repeatNewPassword);

    if (!$passwordFieldsEmpty && $oldPassword === $newPassword) {
        $_SESSION['error_password'][] = "Wprowadzone hasło jest nieprawidłowe. Nowe hasło musi różnić się od poprzedniego.";
    }

    if (!$passwordFieldsEmpty && ((strlen($newPassword)<8) || (strlen($newPassword)>20))) {
        $_SESSION['error_password'][] = "Nowe hasło musi posiadać od 8 do 20 znaków.";
    }

    if (!$passwordFieldsEmpty && $newPassword !== $repeatNewPassword) {
        $_SESSION['error_password'][] = "Nowe hasło nie jest jednakowe w obydwu polach.";
    }

    if(!empty($_SESSION['error_password'])) {
        return false;
    }

    return true;
}

function compareUserDbPasswordById(mysqli $connection, int $id, string $password) : bool
{
    $statement = $connection->prepare("SELECT password FROM users WHERE id=?");
    $statement->bind_param('i', $id);

    $statement->execute();

    $result = $statement->get_result();

    $statement->close();

    $dbPassword = $result->fetch_assoc();

    return $dbPassword === password_hash($password, PASSWORD_DEFAULT);
}

