<?php

    if (isset($_POST['submit'])) {

        $newFileName = $_POST['filename'];
        if (empty($_POST['submit'])) {
            $newFileName = "gallery";
        } else {
            //Zabezpieczenie przed wprowadzeniem spacji w nazwie pliku oraz dużych liter
            $newFileName = strtolower(str_replace(" ", "-"));
        }
        $imageTitle = $_POST['filetitle'];
        $imageDesc = $_POST['filedesc'];

        //FILES zawiera dane na temat pliku przesyłanego za pomocą kodu. Nie zawiera przesłanego pliku, a inną tablicę
        $file = $_FILES["file"];

        //
        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileTempName = $file['temp_name'];
        $fileError = $file['error'];
        $fileSize = $file['size'];

        $fileExt = explode(".", $fileName);

        $fileActualExt = strtolower(end($fileExt));

        //Rozszerzenia z jakimi można udostępniać pliki
        $allowed = array("jpg", "jpeg", "png");

    }