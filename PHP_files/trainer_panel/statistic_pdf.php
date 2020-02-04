<?php

    require 'navbar.php';
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        a:link, a:visited {
            background-color: #333333;
            color: white;
            padding: 14px 25px;

            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        a:hover, a:active {
            background-color: lightskyblue;
        }
    </style>
</head>
<body>

<h2>Statistics PDF's</h2>
<br>
<br>

<a href="fattest.php" target="_blank" style="padding-left: 200px;"> Fattest Customers</a>
<a href="tallest.php" target="_blank" style="padding-left: 200px;"> Tallest Customer </a>
<a href="students_trainer_has.php" target="_blank" style="padding-left: 200px;">Customers You Have </a>


</body>
</html>
