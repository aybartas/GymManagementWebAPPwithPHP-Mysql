<?php

    include '../../includes/dbh.inc.php';
    session_start();




if(isset($_POST['update-password'])) {
    $currentUsername = $_SESSION['session_UsernameID'];
    $old_password = $_POST['old-password'];
    $new_password = $_POST['pwd'];
    $new_password_repeat = $_POST['pwd-repeat'];

    if (empty($new_password) || empty($new_password_repeat) || empty($old_password)) {

        header("Location: ../update_user_account.php?error=emptyfields");
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]+/", $new_password)) {

        header("Location: ../update_user_account.php?error=invalidPassword");
        exit();

    } elseif ($new_password !== $new_password_repeat) {

        header("Location: ../update_user_account.php?error=passwordsDontMatch");
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
                    header("Location: ../user_profile.php?PasswordChangedSuccessfully");
                    exit();
                }
                else{

                    header("Location: ../update_user_account.php?error=sqlpassworderror");
                    exit();
                }
            }
            else{
                header("Location: ../update_user_account.php?error=givenoldpassworddoesntmatch");
                exit();
            }
        }
        else{

            header("Location: ../update_user_account.php?error=oldpasswordcantbetakenfromdb");
            exit();
        }
    }
}

    if(isset($_POST['update-submit'])) {

        $currentUsername = $_SESSION['session_UsernameID'];
        $new_user_real_name = $_POST['new_user_real_name'];
        $new_user_real_last_name = $_POST['new_user_real_last_name'];
        $new_weight = $_POST['user_weight'];
        $new_length = $_POST['user_length'];
        $new_age = $_POST['user_age'];

        if (!preg_match("/^[a-zA-Z ]+/", $new_user_real_name)) {

            header("Location: ../update_user_account.php?error=invalidname");
            exit();
        } elseif (!preg_match("/^[a-zA-Z ]+/", $new_user_real_last_name)) {

            header("Location: ../update_user_account.php?error=invalidlastname");
            exit();
        } //invalid username

        elseif ($new_weight < 30 || $new_weight > 200) {
            header("Location: ../update_user_account.php?error=invalidweighth");
            exit();
        } elseif ($new_length < 140 || $new_length > 240) {
            header("Location: ../update_user_account.php?error=invalidwlength");
            exit();
        } elseif ($new_age < 15 || $new_age > 99) {

            header("Location: ../update_user_account.php?error=ageisnotaccomodate=" . $new_age);
            exit();
           }
        else {

                mysqli_query($conn,"START TRANSACTION");


                $user_new_fat_ratio = round(((10000 * $new_weight) / ($new_length * $new_length)), 1);
                $update_customer = "UPDATE system_user SET  Name = '$new_user_real_name' , Surname = '$new_user_real_last_name' where UsernameID = '$currentUsername'";

                if ($t1 =mysqli_query($conn, $update_customer)) {

                    $update_system_user = "UPDATE customer SET Weight = '$new_weight' , Length = '$new_length' , Age = '$new_age', FatRatio = '$user_new_fat_ratio' where UsernameID = '$currentUsername'";
                    if ($t2=mysqli_query($conn, $update_system_user)) {

                        if (!empty($_POST['update_check_list'])) {

                            $delete_ailment = "delete from has where  CustomerID = '$currentUsername'";
                            $t3 = mysqli_query($conn,$delete_ailment);
                            if ($t3) {

                                foreach ($_POST['update_check_list'] as $selected) {

                                    $sql_phsical = "INSERT INTO has (CustomerID, PyhsicalAilmentName) VALUES (?,?) ";
                                    $stmt_phsical = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt_phsical, $sql_phsical)) {
                                        header("Location: ../update_user_account.php?error=sqlerror");
                                        exit();
                                    }
                                    mysqli_stmt_bind_param($stmt_phsical, "ss", $currentUsername, $selected);
                                    mysqli_stmt_execute($stmt_phsical);
                                }
                                $stmt = $conn->prepare("INSERT INTO log 
                                    (UsernameID, Description) VALUES (?,?)");
                                $description = $currentUsername . " " . " updated profile ! ";
                                $stmt->bind_param("ss", $currentUsername, $description);
                                $t4 =$stmt->execute();

                                if($t1 && $t2 && t3 && $t4){
                                    mysqli_query($conn,"COMMIT");
                                    header("Location: ../user_profile.php");
                                    exit();
                                }
                                else{

                                    mysqli_query($conn,"ROLLBACK");

                                }


                            } else {

                                header("Location: ../update_user_account.php?error=sqlerror1" . $currentUsername);
                                exit();
                            }
                        } else {
                            $stmt = $conn->prepare("INSERT INTO log 
                                    (UsernameID, Description) VALUES (?,?)");
                            $description = $currentUsername . " " . " updated profile ! ";
                            $stmt->bind_param("ss", $currentUsername, $description);
                            $stmt->execute();

                            header("Location: ../user_profile.php");
                            exit();
                        }
                    } else {

                        header("Location: ../update_user_account.php?error=sqlerror2" . $currentUsername);
                        exit();
                    }
                } else {

                    header("Location: ../update_user_account.php?error=sqlerror3" . $currentUsername);
                    exit();
                }


        }
    }
    else{
        header("Location: ../update_user_account.php");
        exit();
    }
