<?php

include 'includes/dbh.inc.php';

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

        .signupbtn {
            float: left;
            width: %50;
        }
        .container {
            padding: 16px;

        }

    </style>
    <main>

            <form action="includes/signup.inc.php"  style="border:1px solid #ccc;width: 50%;margin: 0 auto" method="post" >
                <div class="container" >
                <h1>Sign up</h1>
                <p>Please fill in this form to create an account.</p>

                    <hr>
                <input type="text" name="username" placeholder="Name">
                <input type="text" name="user_last_name" placeholder="Last Name">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwd-repeat" placeholder="Repeat Password">
                <input type="text" name="user_weight" placeholder="Weight(in terms of kilogram)">
                <input type="text" name="user_length" placeholder="Length(in terms of cm)">
                <input type="text" name="user_age" placeholder="Age">

                    <p> Phsical Alignments</p>
                    <?php

                    $sql = "select Name from physical_ailment";
                    $result = mysqli_query($conn,$sql);
                    $i = 0;

                    while($db_row = mysqli_fetch_array($result)){
                        ?>
                        <input type="checkbox" name="check_list[]" value= "<?php echo $db_row['Name']; ?>"> <?php
                        echo $db_row["Name"]; ?> <br>
                        <?php
                        $i++; }
                    ?>

                <select name="selected_mem_type" >

                    <?php
                        $sql = "select Name from membership_type";
                        $result = mysqli_query($conn,$sql);
                        $i = 0;

                        while($DB_ROW = mysqli_fetch_array($result)){
                            ?>
                            <option>
                                <?php echo $DB_ROW['Name']; ?>
                            </option>
                            <?php
                                $i++;} ?>
                </select>
                <input type ="text" name="user_card_no" placeholder="Credit Card No">
                <input type="date" name="user_card_expire_date" placeholder="Expire Date of Card">
                <button type="submit" class="signupbtn" name="signup-submit"> Signup </button>
                    <button type="submit" class="signupbtn" name="home-submit"> Home </button>
                </div>
            </form>
    </main>



<?php
     require "footer.php";
?>