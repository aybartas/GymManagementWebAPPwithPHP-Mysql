<?php

include '../includes/dbh.inc.php';
session_start();

?>

<style>

    main {
        font-family: Arial, Helvetica, sans-serif;
    }
    * {box-sizing: border-box}

    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }
    button,a {
        background-color: black;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .container {
        padding: 16px;

    }

</style>
<main>

    <form action="includes/update_trainer_profile.inc.php"  style="border:1px solid #ccc;width: 50%;margin: 0 auto" method="post" >
        <div class="container" >
            <h1>Change Password</h1>
            <hr>
            <input type="password" name="old-password" placeholder="Current Password">
            <input type="password" name="pwd" placeholder=" New Password">
            <input type="password" name="pwd-repeat" placeholder="Repeat Password">
            <button type="submit" class="update-button" name="update-password"> Change Password </button>
        </div>
    </form>

    <p><button onclick="window.location='trainer_profile.php'" style="margin: auto;display: block;width: 50%">Go back </button></p>

    <form action="includes/update_trainer_profile.inc.php"  style="border:1px solid #ccc;width: 50%;margin: 0 auto" method="post" >
        <div class="container" >
            <h1>Update Account</h1>
            <p>Please fill in this form to update your account</p>
            <hr>
            <?php
            $var = $_SESSION['session_UsernameID'];

            $sql = " select Name,Surname,Weight,Length,Age 
                from Customer,System_user where 
                System_user.UsernameID = '" .$var. "' " ;

            $result = $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)){

                $defaultName = $row["Name"];
                $defaultSurname = $row["Surname"];
                $defaultWeight = $row["Weight"];
                $defaultLength = $row["Length"];
                $defaultAge = $row["Age"];
                break;
            }
            ?>
            <input type="text" name="new_user_real_name" value="<?php echo $defaultName; ?>" >
            <input type="text" name="new_user_real_last_name" value="<?php echo $defaultSurname; ?>"  >
            <input type="text" name="user_weight" value="<?php echo $defaultWeight; ?>"  >
            <input type="text" name="user_length" value="<?php echo $defaultLength; ?>" >
            <input type="text" name="user_age" value="<?php echo $defaultAge; ?>"  >
            <p> Phsical Alignments</p>
            <?php

            $sql = "select Name from physical_ailment";
            $result = mysqli_query($conn,$sql);
            $i = 0;
            while($db_row = mysqli_fetch_array($result)){
                ?>
                <input type="checkbox" name="update_check_list[]" value= "<?php echo $db_row['Name']; ?>"> <?php
                echo $db_row["Name"]; ?> <br>
                <?php
                $i++; }
            ?>
            <button type="submit" class="update-button" name="update-submit"> Update </button>
        </div>
    </form>
    <p><button onclick="window.location='user_profile.php'" style="margin: auto;display: block;width: 50%">Go back </button></p>








</main>
