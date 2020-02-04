<?php
    session_start();
    include 'navbar.php';
    include '../includes/dbh.inc.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>STATISTICS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
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

        .header {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
        }

        .column {
            float: left;
            width: 33.33%;
            padding: 15px;
        }


        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @media screen and (max-width:600px) {
            .column {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>STATISTICS ABOUT CUSTOMERS & TRAINERS</h1>

</div>


<div class="row">
    <div class="column">
        <h2>Average , Minimum , Maximum Salary for Trainers </h2>
         <?php

                $sql = "select  avg(Salary) , min(Salary) , max(Salary) from trainer ";
                $result = mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0){
                    while($row = mysqli_fetch_assoc($result)){
                        ?>

                            <h4> Average Salary is :  <?php echo round($row['avg(Salary)'],1); ?> $</h4>
                            <h4> Minimum Salary is :  <?php echo $row['min(Salary)']; ?> $</h4>
                            <h4> Maximum Salary is :  <?php echo $row['max(Salary)']; ?> $</h4>
                <?php }

        } ?>


    </div>

    <div class="column">
        <h2>Number of Trainers & Customers </h2>

        <?php

        $sql = "select  count(UsernameID)  from customer";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                ?>

                <h4>  Number of Customers :  <?php echo $row['count(UsernameID)']; ?> </h4>
            <?php }
        } ?>
        <?php

        $sql = "select  count(UsernameID)  from trainer ";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <h4> Number of Trainers:  <?php echo $row['count(UsernameID)']; ?> </h4>
            <?php }
        } ?>

    </div>

    <div class="column">
        <h2>Average , Minimum , Maxsimum Age of Customers</h2>
        <?php

        $sql = "select  avg(Age) ,min(Age) , max(Age) from customer ";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <h4>  Average age  of Customers :  <?php echo $row['avg(Age)']; ?>  years</h4>
                <h4>  Minimum age  of Customers :  <?php echo $row['min(Age)']; ?>  years</h4>
                <h4>  Maximum age  of Customers :  <?php echo $row['max(Age)']; ?> years </h4>
            <?php }
        } ?>
    </div>
    <div class="column">
        <h2> Most Expensive and Cheapest Lessons and Prices</h2>
        <?php

        $sql = "select Name , price from lesson USE INDEX (name_price_index) where Price = (select min(price) from lesson)";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <h4>  Cheapest Lesson:  <?php echo $row['Name']; ?> </h4>
                 <h4> Price:  <?php echo $row['price']; ?> $</h4>

            <?php break; }
        } ?>

        <?php

        $sql = "select Name , price from lesson where Price = (select max(price) from lesson)";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <h4>  Most Expensive Lesson:  <?php echo $row['Name']; ?> </h4>
                <h4>  Price:  <?php echo $row['price']; ?> $</h4>
            <?php break;}
        } ?>

    </div>

    <div class="column">
        <h2> Most Seen Customer Alignments</h2>
        <?php

        $sql = "select PyhsicalAilmentName , count(*) as freq 
        from has group by PyhsicalAilmentName order by count(*) desc limit 1";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <h4>  Most Seen Alignment:  <?php echo $row['PyhsicalAilmentName']; ?> </h4>
                <h4>  Number:  <?php echo $row['freq']; ?> </h4>

                <?php break; }
        } ?>
    </div>
    <div class="column">
        <h2> Most Common Professions Among Trainers</h2>
        <?php

        $sql = "select ProfessionName , count(*) as freq from be_profession
                group by ProfessionName order by count(*) desc limit 1";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <h4>  Most Seen Profession:  <?php echo $row['ProfessionName']; ?> </h4>
                <h4>  Number:  <?php echo $row['freq']; ?> </h4>

                <?php break; }
        } ?>
    </div>

    <div class="row">

        <div class="column">
            <h2> Most Preferred Membership</h2>
            <?php

            $sql = "select MembershipTypeName , count(*) as freq from customer
                group by MembershipTypeName order by count(*) desc limit 1";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <h4>  Most Seen Profession:  <?php echo $row['MembershipTypeName']; ?> </h4>
                    <h4>  Number:  <?php echo $row['freq']; ?> </h4>
                    <?php break; }
            } ?>
        </div>
        <div class="column">
            <h2> Most Preferred Days Among Customers</h2>
            <?php

            $sql = "select Day , count(*) as freq 
            from purchase, section, work_in
            where purchase.SectionRoom = section.Room and 
            section.Room = work_in.SectionRoom
            and purchase.LessonName = section.LessonName and section.LessonName = work_in.LessonName
            group by Day 
            order by count(*) desc limit 3";

            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <h4> <?php echo $row['Day']; ?>
                     Number: <?php echo $row['freq']; ?> </h4>
                    <?php ; }
            } ?>
        </div>

        <div class="column">
            <h2> Most Used Exercises</h2>
            <?php

            $sql = "select ExerciseName , count(*) as freq from consist_of
                group by ExerciseName order by count(*) desc limit 3";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <h4> <?php echo $row['ExerciseName']; ?>
                        Number: <?php echo $row['freq']; ?> </h4>
                    <?php ; }
            } ?>
        </div>
        <div class="column">
            <h2> Top Purchaser Customers</h2>
            <?php

            $sql = "select CustomerID , count(*) as freq from asked_for
                group by CustomerID order by count(*) desc limit 3";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <h4> <?php echo $row['CustomerID']; ?>
                        Number: <?php echo $row['freq']; ?> </h4>
                    <?php ; }
            } ?>
        </div>

    </div>

</div>

</body>
</html>
