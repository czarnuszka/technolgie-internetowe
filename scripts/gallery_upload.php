<?php

    if (isset($_POST['submit'])) {

        $newFileName = $_POST['filename'];
        if (empty($newFileName)) {
            $newFileName = "gallery";
        } else {
            //Zabezpieczenie przed wprowadzeniem spacji w nazwie pliku oraz dużych liter
            $newFileName = strtolower(str_replace(" ", "-", $newFileName));
        }
        $imageTitle = $_POST['filetitle'];
        $imageDesc = $_POST['filedesc'];

        //FILES zawiera dane na temat pliku przesyłanego za pomocą kodu. Nie zawiera przesłanego pliku, a inną tablicę
        $file = $_FILES["file"];

        //zmienne dotyczące pliku
        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileTempName = $file['tmp_name'];
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
                    include_once "config/database.php";
                    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    $result = $connection->query("SELECT * FROM gallery");

                    if (empty($imageTitle) || empty($imageDesc)) {
                        header("Location: ../gallery.php?upload=empty");
                        exit();
                    } else {
                        $sql = "SELECT * FROM gallery;";
                        $stmt = mysqli_stmt_init($connection);
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "SQL statement file";
                        } else {
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            $rowCount = mysqli_num_rows($result);
                            $setImageOrder = $rowCount + 1;

                            $sql = "INSERT INTO gallery (titleGallery, 	descGallery, imgFullNameGallery, orderGallery) VALUES (?, ?, ?, ?);";
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "SQL statement failed";
                            } else {
                                mysqli_stmt_bind_param($stmt, "ssss", $imageTitle, $imageDesc, $imageFullName, $setImageOrder);
                                mysqli_stmt_execute($stmt);

                                move_uploaded_file($fileTempName, $fileDestination);

                                header("Location: ../gallery.php?upload=success");
                            }
                        }
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