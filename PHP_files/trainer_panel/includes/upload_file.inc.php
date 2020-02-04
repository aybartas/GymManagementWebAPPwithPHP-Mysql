<?php

session_start();
include '../../includes/dbh.inc.php';
$current_user = $_SESSION['session_UsernameID'];


if ($_FILES["image"]["error"] > 0)
{
    echo "NO CHOOSEN FILE";

}
else
{
    move_uploaded_file($_FILES["image"]["tmp_name"],"images/" . $_FILES["image"]["name"]);


    $file="images/".$_FILES["image"]["name"];
    $sql_photo = "UPDATE system_user SET Photo = '$file' where UsernameID = '$current_user'";
    $stmt_photo = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt_photo, $sql_photo)) {
        header("Location: ../upload_image.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt_photo, "s", $file);
    mysqli_stmt_execute($stmt_photo);
    header("Location: ../trainer_profile.php");
    exit();

}