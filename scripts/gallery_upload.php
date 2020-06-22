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

        //zmienne dotyczące pliku
        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileTempName = $file['temp_name'];
        $fileError = $file['error'];
        $fileSize = $file['size'];

        $fileExt = explode(".", $fileName);

        $fileActualExt = strtolower(end($fileExt));

        //Rozszerzenia z jakimi można udostępniać pliki
        $allowed = array("jpg", "jpeg", "png");

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 2000000) {
                    //nazwa pliku . unikatowe id . rozszerzenie
                    $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
                    $fileDestination = "../img/gallery/" . $imageFullName;

                    //połączenie z bazą galerii
                    include_once "config/databaseGallery.php";

                    if (empty($imageTitle) || empty($imageDesc)) {
                        header("Location: ../gallery.php?upload=empty");
                        exit();
                    } else {
                        $sql = "SELECT * FROM gallery;";
                        $stmt = mysqli_stmt_init($conn);
                        
                    }
                } else {
                    echo "File size is too big!";
                    exit();
                }
            } else {
                echo "You had aan error!";
                exit();
            }
        } else {
            echo "You need to upload a proper file type";
            exit();
        }

    }