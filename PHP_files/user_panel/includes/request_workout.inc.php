<?php
    session_start();
    include '../../includes/dbh.inc.php';



    if(isset($_POST['submit-request'])){

        $customer_username = $_SESSION['session_UsernameID'];
        $description = $_POST['description'];
        $date = date('Y/m/d H:i:s');
        $sql = "select TrainerID from customer where UsernameID = '$customer_username'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){

            while($row =mysqli_fetch_assoc($result)){

                if(is_null($row['TrainerID'])){

                        header("Location: ../request_workout.php?error=youneedatrainerfirst");
                        exit();
                }
                else{

                    $stmt = $conn->prepare("INSERT INTO request_program (UsernameID, Description, RequestDate) 
                            VALUES (?,?,?)");
                    $stmt->bind_param("sss",$customer_username,$description,$date);
                    $stmt->execute();
                    $stmt->close();
                    header("Location: ../user_header.php");
                    exit();
                }
            }

        }



    }