<?php

    session_start();
    include '../../includes/dbh.inc.php';

if(isset($_POST['trainer-submit'])){

        $selectedtrainer = $_POST['selected_trainer'];
        $arr = explode(" ",$selectedtrainer);
        $trainer = $arr[0];
        $customer_username = $_SESSION['session_UsernameID'];

    $sql = "select TrainerID from customer where UsernameID = '$customer_username'";

    $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0){

            while($row =mysqli_fetch_assoc($result)){

                if(is_null($row['TrainerID'])){

                    $update_sql = "UPDATE customer set TrainerID = '$trainer' where UsernameID = '$customer_username'";
                    if(mysqli_query($conn,$update_sql)){
                        header("Location: ../user_header.php");
                        exit();

                    }

                }
                else{

                    header("Location: ../select_trainer.php?error=youhavealreadytrainer");
                    exit();
                }
            }

        }






    }