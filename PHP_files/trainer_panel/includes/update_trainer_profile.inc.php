<?php

include '../../includes/dbh.inc.php';
session_start();
$currentUsername = $_SESSION['session_UsernameID'];

if(isset($_POST['update-password'])) {

    $old_password = $_POST['old-password'];
    $new_password = $_POST['pwd'];
    $new_password_repeat = $_POST['pwd-repeat'];

    if (empty($new_password) || empty($new_password_repeat) || empty($old_password)) {

        header("Location: ../update_trainer_account.php?error=emptyfields");
        exit();
    }
     elseif (!preg_match("/^[a-zA-Z0-9]+/", $new_password)) {

        header("Location: ../update_trainer_account.php?error=invalidPassword");
        exit();

    } elseif ($new_password !== $new_password_repeat) {

        header("Location: ../update_trainer_account.php?error=passwordsDontMatch");
        exit();
    }

    else {
                $sql = "select Password from system_user where UsernameID='$currentUsername'";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                        $row = mysqli_fetch_assoc($result);
                        if ($row['Password'] == hash("sha256",$old_password)){

                            $new_password = hash("sha256", $new_password);
                            $update_trainer = "UPDATE system_user SET Password = '$new_password' where UsernameID = '$currentUsername'";

                            if (mysqli_query($conn, $update_trainer)) {
                                header("Location: ../trainer_profile.php?PasswordChangedSuccessfullt");
                                exit();
                            }
                            else{

                                header("Location: ../update_trainer_account.php?error=sqlpassworderror");
                                exit();
                            }
                        }
                        else{
                            header("Location: ../update_trainer_account.php?error=givenoldpassworddoesntmatch");
                            exit();
                        }
                }
                else{

                    header("Location: ../update_trainer_account.php?error=oldpasswordcantbetakenfromdb");
                    exit();
                }
        }
    }
if (isset($_POST["update-submit"])){

    header("Location: ../trainer_profile.php?PasswordChangedSuccessfullt");
    exit();

}






