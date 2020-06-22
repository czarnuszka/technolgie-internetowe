<?php

// Obsługa błędów

function displaySessionErrors(string $sessionErrorField) : ?string
{
    if (!isset($_SESSION[$sessionErrorField])) {
        return null;
    }

    if (is_array($_SESSION[$sessionErrorField]))
    {
        $errors = '';

        foreach($_SESSION[$sessionErrorField] as $error) {
            $errors .= '<div class="error">' . $error . '</div>';
        }
        unset($_SESSION[$sessionErrorField]);

        return $errors;
    }

    $error = '<div class="error">' . $_SESSION[$sessionErrorField] . '</div>';
    unset($_SESSION[$sessionErrorField]);

    return $error;
}