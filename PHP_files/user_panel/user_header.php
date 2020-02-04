<?php
session_start();
include '../includes/dbh.inc.php';
include 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CUSTOMER PANEL</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/user_header.css">
    <style>
        button {
            border: none;
            outline: 0;
            display: inline-block;
            padding: 8px;
            color: white;
            background-color: #000;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover, a:hover {
            opacity: 0.7;
        }
    </style>
</head>
<body>

<div class="header">
    <h1 style="text-align: center">WELCOME TO CUSTOMER PANEL</h1>
</div>
<h1 style="text-align: center"> Select Personal Trainer</h1>

    <p><button  style="width: 45%;float: right" onclick="window.location='select_trainer.php'">Click to Select Trainer</button></p>

    <p><button style ="width: 45%; float: left" onclick="window.location='trainer_filtering/index.php'">Click to See Categorized Trainers</button></p>


<div class="row" >
    <div class="column" >
        <h2>Trainers</h2>
        <table id="lesson_table">

            <tr>
                <th>Trainer</th>
                <th> Rating</th>

            </tr>
            <?php

            $sql = "select UsernameID , satisfaction_rating from trainer ";
            $result = mysqli_query($conn,$sql);

            while($DB_ROW = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td> <?php  echo  substr($DB_ROW['UsernameID'],2);   ?> </td>
                    <td> <?php  echo  $DB_ROW['satisfaction_rating']; ?> </td>
                </tr>
            <?php }?>
        </table>

    </div>

    <div class="column">
        <h2>Default Workout</h2>
        <p> This workout is given to everybody free. If you want to improve your body faster way you need to select a personl trainer. <br> You can always request another workout if you select a  personal trainer ! </p>
        <table id="default_exercise">

            <tr>
                <th> Program Name</th>
                <th>Exercise</th>
                <th> Set</th>
                <th> Reps</th>
            </tr>
            <?php

            $sql = "select   c.ProgramName  ,C.ExerciseName , E.`Set`, E.RepetitionPerSet  FROM consist_of as C , exercise as E WHERE C.ProgramName = 'Get Muscle Begginer' and C.ExerciseName = E.Name ";
            $result = mysqli_query($conn,$sql);
            while($DB_ROW = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td> <?php  echo  $DB_ROW['ProgramName'];   ?> </td>
                    <td> <?php  echo  $DB_ROW['ExerciseName'];   ?> </td>
                    <td> <?php  echo  $DB_ROW['Set'];   ?> </td>
                    <td> <?php echo $DB_ROW['RepetitionPerSet']; ?> </td>
                </tr>
            <?php }?>

        </table>


    </div>


    <div class="column">
        <h2>Advantages</h2>
        <p> One of the primary reasons that someone should have a Personal Trainer is that they are trained in teaching others how to exercise. And while exercise in itself is only a part of fitness, with nutrition and lifestyle playing an essential role in the overall picture if you don’t get exercise right then you will never achieve your goals.

            The importance of education when exercising is important for two primary reasons:

            1) If you don’t know which exercises are most effective for the goals you have, you are unlikely to achieve those goals. For example, if your goal is to build core strength but you spend all your time on cardio exercises, then you are unlikely to hit your goal.

            2) Education when performing exercises is essential in reducing the risk of injury. Many people every year are seriously injured by performing exercises they have not received training for, and this can impact their health and fitness for a long time. Having someone trained in how to execute certain tasks will greatly reduce the level of risk and increase the effectiveness of your fitness routine. </p>
    </div>

    
</div>



</body>
</html>

