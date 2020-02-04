<?php

    session_start();
    include '../includes/dbh.inc.php';
    include 'navbar.php';
    ?>

<head>

    <link rel="stylesheet" href="css/user_profile.css">
    <title>User Profile</title>
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
            header("Location: ../user_profile.php?error=photouploadsqlerror");
            exit();
        }


    ?>

    <p><button onclick="window.location='upload_image.php'">Change Profile Photo</button></p>
    <h2>Account Information</h2>
    <?php
    $sql = "select UsernameID, MembershipTypeName, TrainerID, Weight, Length, Age, FatRatio from customer where UsernameID = '$current_username' ";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) >0){
        while($row = mysqli_fetch_assoc($result)){
            echo "Username : ".substr($row["UsernameID"],2);
            echo "<br>";
            echo "Membership :".$row["MembershipTypeName"];
            echo "<br>";
            echo "Trainer : ".substr($row["TrainerID"],2);
            echo "<br>";
            echo "Weight :".$row["Weight"];
            echo "<br>";
            echo "Length :".$row["Length"];
            echo "<br>";
            echo "Age :".$row["Age"];
            echo "<br>";
            echo "FatRatio :".$row["FatRatio"];
        }
    }
    ?>
    <p><button onclick="window.location='update_user_account.php'">Update  Account Informatıon</button></p>

</div>

</body>

