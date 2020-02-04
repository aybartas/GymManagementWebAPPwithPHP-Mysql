<?php

    if (isset($_POST['home-submit'])){
        header("Location: ../header.php");
        exit();
    }
    if(isset($_POST['signup-submit'])){

        require 'dbh.inc.php';
        $User_Trainer_ID = null;
        $user_real_name = $_POST['username'];
        $user_real_lastname = $_POST['user_last_name'];
        $username = $_POST['uid'];
        $password = $_POST['pwd'];
        $passwordRepeat = $_POST['pwd-repeat'];
        $user_weight = $_POST['user_weight'];
        $user_length= $_POST['user_length'];
        $user_age = $_POST['user_age'];
        $selected_membership = $_POST['selected_mem_type'];
        $user_card_no = $_POST['user_card_no'];
        $user_card_expire_date = $_POST['user_card_expire_date'];
        $current_date = date("Y-m-d H:i:s");

        if(empty($username) ||  empty($password) || empty($passwordRepeat) ){
            //url de çıkarr
            // boş girerse header ile signupa yonlendirme yapıyorsun. bazı veriler silinmemiş olacak

            header("Location: ../signup.php?error=emptyfields&uid=".$username);

            exit();
        }

        elseif (!preg_match("/^[a-zA-Z ]+/",$user_real_name)){

            header("Location: ../signup.php?error=invalidname");
            exit();
        }


        elseif (!preg_match("/^[a-zA-Z ]+/",$user_real_lastname)){

            header("Location: ../signup.php?error=invalidlastname");
            exit();
        }
        //invalid username
        elseif (!preg_match("/^[a-zA-Z0-9]+/", $username)){

            header("Location: ../signup.php?error=invaliduid");
            exit();
        }

        elseif (!preg_match("/^[a-zA-Z0-9]+/", $password)){

            header("Location: ../signup.php?error=invaliduid");
            exit();
        }
        elseif ($user_weight<30 || $user_weight>200){
            header("Location: ../signup.php?error=invalidweighth");
            exit();
        }
        elseif ($user_length< 140 || $user_length>240){
            header("Location: ../signup.php?error=invalidwlength");
            exit();
        }
        elseif ($user_age<15 || $user_age>99){

            header("Location: ../signup.php?error=ageisnotaccomodate=".$user_age);
            exit();
        }
        elseif (!ctype_digit($user_card_no)){

            header("Location: ../signup.php?error=invalidcardno");
            exit();
        }
        elseif ($current_date > $user_card_expire_date){

            header("Location: ../signup.php?error=expiredcard");
            exit();
        }
        elseif ($password !== $passwordRepeat){

            header("Location: ../signup.php?error=passwordCheck&password ="."&uid=".$username);
            exit();
        }

        // matching db ? same exist ?
        else{

             $sql = "select UsernameID from system_user where UsernameID=?";
             $statement = mysqli_stmt_init($conn);
             if(!mysqli_stmt_prepare($statement,$sql)){
                 header("Location: ../signup.php?error=sqlerror");
                exit();
             }
             else{

                mysqli_stmt_bind_param($statement,"s",$username);
                mysqli_stmt_execute($statement);
                mysqli_stmt_store_result($statement);
                $resultCheck = mysqli_stmt_num_rows($statement);
                if($resultCheck >0){
                    header("Location: ../signup.php?error=usernametaken".$username);
                    exit();
                }
                else{

                    $user_fat_ratio = round(((10000*$user_weight)/($user_length*$user_length)),1);
                    $period_to_added = strtolower($selected_membership);
                   if($period_to_added == "monthly"){

                       $end_date = date('Y-m-d H:i:s', strtotime($current_date. ' + 30 days'));
                        // enddate ve current date dogru , monthly üyelik , username alınmamış durumu
                       $sql = "INSERT INTO customer (UsernameID,
                                                    MembershipTypeName,
                                                    TrainerID,
                                                    Weight,
                                                    Length,
                                                    Age,
                                                    FatRatio,
                                                    CreditCardNumber,
                                                    CreditCardExpireDate) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                           header("Location: ../signup.php?error=sqlerror");
                           exit();
                       }
                       else{

                           $hashed_password = hash("sha256",$password);

                           $username = "c_".$username;
                           mysqli_stmt_bind_param($stmt,"sssddidss",$username,$selected_membership,$User_Trainer_ID,
                                                                            $user_weight,$user_length,$user_age,$user_fat_ratio,$user_card_no,$user_card_expire_date);
                           mysqli_stmt_execute($stmt);

                           if(!empty($_POST['check_list'])){

                               foreach ($_POST['check_list'] as $selected){

                                   $sql_phsical = "INSERT INTO has (CustomerID, PyhsicalAilmentName) VALUES (?,?) ";
                                   $stmt_phsical = mysqli_stmt_init($conn);
                                   if(!mysqli_stmt_prepare($stmt_phsical,$sql_phsical)){
                                       header("Location: ../signup.php?error=sqlerror");
                                       exit();
                                   }
                                   mysqli_stmt_bind_param($stmt_phsical,"ss",$username,$selected);
                                   mysqli_stmt_execute($stmt_phsical);
                               }
                           }

                           $sql_update = "UPDATE system_user SET  Name = '$user_real_name' , Surname = '$user_real_lastname' Password= '$hashed_password' , EndDate = '$end_date'  WHERE UsernameID = '$username'";

                           if(mysqli_query($conn, $sql_update)){

                               $stmt = $conn ->prepare("INSERT INTO log 
                                ( UsernameID, Description) VALUES (?,?)");
                               $description = $username." "."signed up to gym! ";
                               $stmt ->bind_param("ss",$username,$description);
                               $stmt->execute();

                               header("Location: ../header.php");
                               exit();

                           } else {
                               echo "ERROR: PASSWORD CAN NOT BE ADDED . "
                                   . mysqli_error($conn);
                           }
                       }
                   }
                   // monthly olmayan üyelik veritabanında kullanıcı adı yok sıkıntısız
                   else{
                       $splitted_membership_array = explode(" ",$period_to_added);
                       $months_to_added = intval($splitted_membership_array[0]);
                       $days_to_added = $months_to_added*30;
                       $end_date = date('Y-m-d H:i:s', strtotime($current_date.' + '.$days_to_added.' days'));
                       $sql = "INSERT INTO customer (UsernameID,
                                                    MembershipTypeName,
                                                    TrainerID,                               
                                                    Weight,
                                                    Length,
                                                    Age,
                                                    FatRatio,
                                                    CreditCardNumber,
                                                    CreditCardExpireDate) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                       $stmt = mysqli_stmt_init($conn);
                       if(!mysqli_stmt_prepare($stmt,$sql)){
                           header("Location: ../signup.php?error=sqlerror");
                           exit();
                       }
                       else{
                           $hashed_password = hash("sha256",$password);
                           $username = "c_".$username;
                           mysqli_stmt_bind_param($stmt,"sssddidss",$username,$selected_membership,$User_Trainer_ID,
                               $user_weight,$user_length, $user_age,$user_fat_ratio,$user_card_no,$user_card_expire_date);
                           mysqli_stmt_execute($stmt);
                           if(!empty($_POST['check_list'])){

                               foreach ($_POST['check_list'] as $selected){

                                   $sql_phsical = "INSERT INTO has (CustomerID, PyhsicalAilmentName) VALUES (?,?) ";
                                   $stmt_phsical = mysqli_stmt_init($conn);
                                   if(!mysqli_stmt_prepare($stmt_phsical,$sql_phsical)){
                                       header("Location: ../signup.php?error=sqlerror");
                                       exit();
                                   }
                                   mysqli_stmt_bind_param($stmt_phsical,"ss",$username,$selected);
                                   mysqli_stmt_execute($stmt_phsical);

                               }
                           }

                           $sql_update = "UPDATE system_user SET  Name = '$user_real_name' , Surname = '$user_real_lastname' , Password= '$hashed_password' , EndDate = '$end_date' WHERE UsernameID = '$username'";

                           if(mysqli_query($conn, $sql_update)){

                               $stmt = $conn ->prepare("INSERT INTO log 
                                ( UsernameID, Description) VALUES (?,?)");
                               $description = $username." "."signed up to gym! ";
                               $stmt ->bind_param("ss",$username,$description);
                               $stmt->execute();

                               header("Location: ../header.php");
                               exit();

                           } else {
                               echo "ERROR: PASSWORD CAN NOT BE ADDED . "
                                   . mysqli_error($conn);
                           }
                       }

                   }

                }
             }
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($statement);
        mysqli_close($conn);
    }
    else{
        header("Location: ../signup.php");
        exit();
    }