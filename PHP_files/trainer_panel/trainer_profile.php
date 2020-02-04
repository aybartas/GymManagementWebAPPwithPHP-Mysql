<?php

session_start();
include '../includes/dbh.inc.php';
include 'navbar.php';
?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/trainer_profile.css">
    <title>Trainer Profile</title>
</head>

<body>

<h2 style="text-align:center;margin-top: 100px">Account </h2>

<div class="card" style="width: 100%">
    <?php
    $current_username = $_SESSION['session_UsernameID'];
    $sql_path = "select Photo from system_user where UsernameID='$current_username'";
    $result = mysqli_query($conn,$sql_path);
    $is_adjusted = 0;
    $image_path = "";
    if(mysqli_num_rows($result) > 0){

        while($row = mysqli_fetch_assoc($result)){
            if($row['Photo'] == null){

                $is_adjusted = 0;
                $image_path = "images/default.jpg";
                ?>
                <img src="<?php echo $image_path; ?>" width="100%">
                <?php

                break;
            }
            else{

                $is_adjusted = 1;
                $image_path = "includes/".$row['Photo'];
                ;?>
                <img src="<?php echo $image_path; ?>" width="100%">
                <?php
                break;
            }
        }
    }

    else{
        header("Location: ../trainer_profile.php?error=photouploadsqlerror");
        exit();
    }
    ?>

    <p><button onclick="window.location='upload_image.php'">Change Profile Photo</button></p>

    <h2>Account Information</h2>

    <?php
    $sql = "select UsernameID, Salary, GraduatedSchool, Experience, satisfaction_rating ,Length,Weight from trainer where UsernameID = '${_SESSION['session_UsernameID']}' ";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) >0){
        while($row = mysqli_fetch_assoc($result)){
            echo "Username : ".substr($row["UsernameID"],2);
            echo "<br>";
            echo "Salary :".$row["Salary"];
            echo "<br>";
            echo "Education : ".$row["GraduatedSchool"];
            echo "<br>";
            echo "Experience : ".$row["Experience"];
            echo "<br>";
            echo "Rating : ".$row["satisfaction_rating"];
            echo "<br>";
            echo "Length : ".$row["Length"];
            echo "<br>";
            echo "Weight : ".$row["Weight"];
        }
    }
    ?>
    <p><button onclick="window.location='update_trainer_account.php'">Update Password</button></p>
    <p><button  onclick="window.location='update_trainer_account.php'">Update Account Informatıon</button></p>
    <!--Modal: Login with Avatar Form-->


</body>
