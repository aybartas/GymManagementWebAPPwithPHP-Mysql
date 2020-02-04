<?php
    session_start();

    if(isset($_POST['login-submit'])){

        require 'dbh.inc.php';

        $Submitted_Username = $_POST['user_username'];
        $Submitted_Password = $_POST['user_password'];
        $Submitted_user_type = $_POST['login_type'];

        if(!isset($Submitted_Username) || !isset($Submitted_Password)
            || trim($Submitted_Password) == '' || trim($Submitted_Username == '')){

            $_SESSION['session_empty'] = "emptytry";
            header("Location:  ../index.php?error=emptyfield");
            exit();
        }
        else{

            if($Submitted_user_type == "customer"){
                $Submitted_Username = "c_".$Submitted_Username;
            }
            else{
                $Submitted_Username = "t_".$Submitted_Username;
            }

            $sql = "select * from system_user where UsernameID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){

                header("Location ../index.php?error=sqlerror");
                exit();
            }
            else{

                mysqli_stmt_bind_param($stmt,"s",$Submitted_Username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $Submitted_Password_Hash = hash("sha256",$Submitted_Password);

                    $passwordCheck = strcmp($Submitted_Password_Hash,$row['Password']);

                    if($passwordCheck != 0){
                        $_SESSION['session_wrong_password'] = "passwordwrong";
                        header("Location:  ../index.php?error=wrongpassword");
                        exit();
                    }
                    elseif ($passwordCheck == 0){


                        $_SESSION['session_UsernameID'] = $row['UsernameID'];

                        if (substr($_SESSION['session_UsernameID'],0,2) == "c_"){

                            $_SESSION['current_type'] = "customer";
                        }
                        else {

                            $_SESSION['current_type'] = "trainer";
                        }

                        header("Location:  ../index.php?loginsuccesfull");

                        exit();

                    }
                    else{
                        header("Location:  ../index.php?error=wrongpassword");
                        exit();
                    }
                }
                else{
                    $_SESSION['session_nouser'] = "nouser";
                    header("Location:  ../index.php?error=nouser");
                    exit();
                }

            }

        }

    }
    else{

        header("Location: ../index.php");
        exit();

    }

