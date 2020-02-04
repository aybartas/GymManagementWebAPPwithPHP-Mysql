<?php
    session_start();
    include '../includes/dbh.inc.php';

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

<form action="includes/select_trainer.inc.php"  style="border:1px solid #ccc;width: 50%;margin: 0 auto" method="post" >
    <div class="container" >
        <h1>Select Your Trainer</h1>
        <hr>

        <p> Current Trainers Avaible</p>

        <select name="selected_trainer" >

            <?php
            $sql = "select trainer.UsernameID  as t,Name,Surname  from trainer, system_user where trainer.UsernameID = system_user.UsernameID";
            $result = mysqli_query($conn,$sql);
            $i = 0;

            while($DB_ROW = mysqli_fetch_array($result)){
                $option_value =  $DB_ROW['t']. " " .$DB_ROW['Name']. " " .$DB_ROW['Surname'];

                ?>
                <option>
                    <?php  echo $option_value;   ?>
                </option>
                <?php
                $i++;} ?>
        </select>

        <button type="submit" class="update-button" name="trainer-submit"> Select </button>
    </div>
</form>
<p><button onclick="window.location='user_header.php'" style="margin: auto;display: block;width: 50%">Go back </button></p>


