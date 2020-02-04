<?php

    include '../includes/dbh.inc.php';
    session_start();
    $current_trainer = $_SESSION['session_UsernameID'];

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

    <form action="includes/reply_customer.inc.php"  style="border:1px solid #ccc;width: 50%;margin: 0 auto" method="post" >
        <div class="container" >
            <h1>Add Workout</h1>

            <hr>
            <input type="text" name="CustomerID" placeholder="Customer Username" required>
            <input type="text" name="ProgramID" placeholder="Program" required>

            <button type="submit" class="update-button" name="add-workout"> Add Workout </button>

            <button type="submit" class="update-button" name="delete-workout"> Delete Workout </button>

        </div>
    </form>
    <button onclick="window.location='trainer_header.php'" style="margin: auto;display: block;width: 50%">Go back </button>

</main>
