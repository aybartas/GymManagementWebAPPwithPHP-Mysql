<?php
    include '../includes/dbh.inc.php';
    include 'navbar.php'; ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Request WorkoutL</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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

                .container {
                    max-width: 400px;
                    width: 100%;
                    margin: 0 auto;
                    position: relative;
                }

                #contact input[type="text"],
                #contact textarea,
                #contact button[type="submit"] {
                    font: 400 12px/16px "Roboto", Helvetica, Arial, sans-serif;
                }

                #request {
                    background: #F9F9F9;
                    padding: 25px;
                    margin: 150px 0;
                    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
                }

                #request h3 {
                    display: block;
                    font-size: 30px;
                    font-weight: 300;
                    margin-bottom: 10px;
                }

                #request h4 {
                    margin: 5px 0 15px;
                    display: block;
                    font-size: 13px;
                    font-weight: 400;
                }

                fieldset {
                    border: medium none !important;
                    margin: 0 0 10px;
                    min-width: 100%;
                    padding: 0;
                    width: 100%;
                }
                #request input[type="text"],
                #request textarea {
                    width: 100%;
                    border: 1px solid #ccc;
                    background: #FFF;
                    margin: 0 0 5px;
                    padding: 10px;
                }

                #request input[type="text"]:hover,

                #request textarea:hover {
                    -webkit-transition: border-color 0.3s ease-in-out;
                    -moz-transition: border-color 0.3s ease-in-out;
                    transition: border-color 0.3s ease-in-out;
                    border: 1px solid #aaa;
                }

                #request textarea {
                    height: 100px;
                    max-width: 100%;
                    resize: none;
                }

                #request button[type="submit"] {
                    cursor: pointer;
                    width: 100%;
                    border: none;
                    background: black;
                    color: #FFF;
                    margin: 0 0 5px;
                    padding: 10px;
                    font-size: 15px;
                }

    </style>
    </head>
    <body>

    <div class="container">
        <form id="request" action="includes/request_workout.inc.php" method="post">
            <h3>Request Workout Form</h3>


            <fieldset>
                <textarea  name="description" placeholder="Please explain your expectations from the program here ...." tabindex="5" required></textarea>
            </fieldset>
            <fieldset>
                <button name="submit-request" type="submit" id="request-submit" >Submit</button>
            </fieldset>

        </form>
    </div>



    </body>
</html>


