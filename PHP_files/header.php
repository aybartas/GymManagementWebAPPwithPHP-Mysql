<?php
    include 'includes/dbh.inc.php';
    session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="This is an example of meta description">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <title> GYM MANAGEMENT</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <style>
            * {box-sizing: border-box;}

            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
            }
            table {
                border-collapse: collapse;
                width: 50%;
                margin-left:auto;
                margin-right:auto;
            }
            th, td {
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) {background-color: #f2f2f2;}
            h2 {
                text-align: center;
            }
            .row {
                display: flex;

                padding:5px;
            }
            .topnav {
                overflow: hidden;
                background-color: #e9e9e9;
            }

            .topnav a {
                float: left;
                display: block;
                color: black;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }

            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }

            .topnav a.active {
                background-color: #ddd;
                color: black;
            }

            .topnav .login-container {
                float: right;
            }
            .topnav .login-container input[type=password] {

                    margin-right:10px;
                            }

            .topnav input[type=text] {
                padding: 6px;
                margin-top: 8px;
                font-size: 17px;
                border: none;
                width:120px;
            }


            .topnav .login-container button {
                float: right;
                padding: 6px 10px;
                margin: auto;
                margin-top: 8px;
                margin-right: 30px;
                background-color: #555;
                color: white;
                font-size: 14px;
                border: none;
                cursor: pointer;

            }

            .topnav .login-container button:hover {
                background-color: black;
            }
            @media screen and (max-width: 600px) {
                .topnav .login-container {
                    float: none;
                }
                .topnav a, .topnav input[type=text], .topnav .login-container button {
                    float: none;
                    display: block;
                    text-align: left;
                    width: 100%;
                    margin: 0;
                    padding: 14px;
                }
                .topnav input[type=text] {
                    border: 1px solid #ccc;
                }
            }
        </style>
    </head>

    <body>

        <header>

        <div class="topnav" style="position: fixed;top: 0;width: 100%">

                 <a class="active" href="index.php"> GYM MANAGEMENT </a>

                <a href="#lesson_table"> Lessons </a>
                 <a href="#price_table"> Prices </a>
            <div class="login-container">

                <?php
                if(isset($_SESSION['session_UsernameID'])){
                    echo "<form  action=\"includes/logout.inc.php\" method=\"post\">
                            <button type=\"submit\" name= \"logout-submit\">Log out ! </button>
                          </form>";

                    if($_SESSION['current_type'] == "customer"){

                        echo "<a class='signupfirst' id='myBtn'  href=\"user_panel/user_header.php\" style='margin-right: auto;margin-left: auto;background-color: #555555;color: #dddddd'>Customer Panel </a>";
                    }
                    else  {

                        echo "<a class='signupfirst' id='myBtn'  href=\"trainer_panel/trainer_header.php?select=0\" style='margin-right: auto;margin-left: auto;background-color: #555555;color: #dddddd'>Trainer Panel </a>";



                    }
                }
                else{
                    echo " <form  action=\"includes/login.inc.php\" method=\"post\">
                     
                      <div class=\"row\" >
                         <input type=\"radio\" name=\"login_type\" value=\"trainer\"> trainer<br>
                         <input type=\"radio\" name=\"login_type\" value=\"customer\" checked> customer<br>
                    </div>
                    <input type=\"text\" name=\"user_username\" placeholder=\"Username\">
                    <input type=\"password\" name=\"user_password\" placeholder=\"Password...\">
                    
                    <button type=\"submit\" name= \"login-submit\">Login </button>
                </form>
                <a class='signupfirst' id='myBtn'  href=\"signup.php\" style='margin-right: auto;margin-left: auto;background-color: #555555;color: #dddddd'>Sign up ! </a>";
                }
                ?>

            </div>

        </div>
         <img src="img/fitness.jpg" style="width:100%;height:700px;margin-top: auto">
            <table id="price_table">

               <tr>

                   <h2> MEMBERSHIP PRICES</h2>

               </tr>
               <tr>
                   <th>Membership</th>
                   <th> Price</th>
               </tr>
               <?php

                    $sql = "select Name , price from membership_type ";
                    $result = mysqli_query($conn,$sql);

                    while($DB_ROW = mysqli_fetch_assoc($result)){
                    ?>
                        <tr>
                            <td> <?php  echo  $DB_ROW['Name'];   ?> </td>
                            <td> <?php  echo  $DB_ROW['price'];   ?> </td>

                        </tr>
               <?php }?>


           </table>

            <img src="img/fitness2.jpg" style="width:50%;height:500px;margin-bottom: auto;margin-top: 30px;margin-left: auto;margin-right: auto;display: block">


        </header>


