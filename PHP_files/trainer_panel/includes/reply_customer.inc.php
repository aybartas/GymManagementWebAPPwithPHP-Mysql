<?php

    include '../../includes/dbh.inc.php';
    session_start();

    $customerid = "c_".$_POST['CustomerID'];
    $programid = $_POST['ProgramID'];
    $current_trainer = $_SESSION['session_UsernameID'];


    if (!preg_match("/^[0-9]+/", $programid)){

        header("Location: ../reply_customer.php?error=invaliduid");
        exit();
    }
    elseif (!preg_match("/^[a-zA-Z0-9]+/", $customerid)){

    header("Location: ../reply_customer.php?error=invaliduid");
        exit();
        }

    if(isset($_POST['add-workout'])){

        //check if already in database

        $sql = "select * from asked_for where CustomerID = '$customerid'
                          and ProgramID = '$programid' ";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){

            while($row = mysqli_fetch_assoc($result)){

                header("Location:  ../reply_customer.php?error=alreadyexists");
                exit();
            }
        }
        else{
            //db de yok
            $sql = "select UsernameID from  customer where  TrainerID = '$current_trainer' AND UsernameID = '$customerid'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                //databasede biri var ve trainerı da var
                $stmt = $conn->prepare("INSERT INTO asked_for (CustomerID, ProgramID) 
                                    VALUES (?,?)");
                $stmt ->bind_param("ss",$customerid,$programid);
                $stmt ->execute();

                header("Location:  ../trainer_header.php");
                exit();
            }
            else{

                header("Location:  ../reply_customer.php?error=nousername");
                exit();
            }
        }

    }
    elseif (isset($_POST['update-workout'])){

        //UPDATE
        $sql = "select * from asked_for where CustomerID = '$customerid'
                          and ProgramID = '$programid' ";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){

            $old_program_id = 0;
            $sql_old = "select ProgramID from asked_for
                        where CustomerID = '$customerid' and ProgramID = '$programid'";
            $old_sql_result = mysqli_query($conn,$sql_old);
            if(mysqli_num_rows($old_sql_result)){

                while($row =mysqli_fetch_assoc($old_sql_result)){
                    $old_program_id = $row['ProgramID'];
                    break;
                }
            }
            else{
                header("Location:  ../reply_customer.php?error=noprogramid");
                exit();
            }

            $sql = "UPDATE asked_for set ProgramID = '$programid' 
                                where CustomerID = '$customerid' and ProgramID = '$old_program_id' ";
            if(mysqli_query($conn,$sql)){

                header("Location:  ../trainer_header.php");
                exit();
            }
            else{

                header("Location:  ../reply_customer.php?error=sqlerror");
                exit();
            }
        }
        else{
            header("Location:  ../reply_customer.php?error=norecord");
            exit();
        }
    }
    else{
            //DELETE

        $sql = "select * from asked_for where CustomerID = '$customerid'
                          and ProgramID = '$programid' ";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){

            $sql = "delete from asked_for where ProgramID = '$programid' and CustomerID = '$customerid'";
            if(mysqli_query($conn,$sql)){
                header("Location:  ../trainer_header.php");
                exit();
            }
            else{

                header("Location:  ../reply_customer.php?error=sqlerror");
                exit();

            }

        }
        else{

            header("Location:  ../reply_customer.php?error=norecord");
            exit();

        }

    }

