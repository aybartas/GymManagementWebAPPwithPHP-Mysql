<?php
session_start();
include 'navbar.php';
include '../includes/dbh.inc.php';

$current_trainer = $_SESSION['session_UsernameID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TRAINER HEADER</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../includes/jqu.js"></script>
    <link rel="stylesheet" href="../includes/boost.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        .header {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
        }

        .button {
            display: inline-block;
            border-radius: 4px;
            background-color: black;
            border: none;
            color: whitesmoke;
            text-align: center;
            font-size: 28px;
            padding: 20px;
            width: 200px;
            transition: all 0.5s;
            cursor: pointer;
            margin: 5px;
        }

        .button span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }

        .button span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }

        .button:hover span {
            padding-right: 25px;
        }

        .button:hover span:after {
            opacity: 1;
            right: 0;
        }

        table {
            border-collapse: collapse;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .column {
            float: left;
            width: 50%;
            padding: 15px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @media screen and (max-width: 600px) {
            .column {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1>WELCOME TO TRAINER PANEL</h1>
</div>
<div>

    <table id="log_table">

        <tr>

            <h2> ACTIVITY LOGS</h2>

        </tr>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Surname</th>
            <th> Description</th>
        </tr>
        <?php

        $sql = "select log.UsernameID , `Name` as name, Surname, Description from log,system_user where log.UsernameID = system_user.UsernameID order by ID desc limit 10";
        $result = mysqli_query($conn, $sql);

        while ($DB_ROW = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td> <?php echo substr($DB_ROW['UsernameID'],2); ?> </td>
                <td> <?php echo $DB_ROW['name']; ?> </td>
                <td> <?php echo $DB_ROW['Surname']; ?> </td>
                <td> <?php echo $DB_ROW['Description']; ?> </td>
            </tr>
        <?php } ?>

    </table>
</div>

<div>
    <form>

        <?php
        @$islem = $_GET["select"];

        switch ($islem) :
            case "0":
                ?>
                <form method="post">
                    <table id="request_table"
                           class="table text-center table-striped table-bordered mx-auto col-md-12 mt-5"
                           style="float: left">
                        <td colspan="4">
                            <h2> Requests</h2>
                        </td>
                        <tr>
                            <th>Customer Name</th>
                            <th>Description</th>
                            <th>Request Date</th>
                            <th>Look Program</th>
                        </tr>
                        <?php
                        $sql = "select R.UsernameID , Description,RequestDate  from request_program R , customer C 
                      where R.UsernameID = C.UsernameID AND C.TrainerID = '$current_trainer'";
                        $result = mysqli_query($conn, $sql);
                        while ($DB_ROW = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td> <?php
                                    $str = str_replace('c_', ' ', $DB_ROW['UsernameID']);
                                    echo $str;
                                    ?> </td>
                                <td> <?php echo $DB_ROW['Description']; ?> </td>
                                <td> <?php echo $DB_ROW['RequestDate']; ?> </td>
                                <?php
                                echo '<td><a href = "trainer_header.php?select=1&customer=' . $DB_ROW['UsernameID'] . '"
                                          class="btn btn-dark cente" style="float: right;position: relative;left: -30%;">Select</button></td>';
                                ?>

                            </tr>
                        <?php } ?>
                    </table>
                </form>
                <?php break;

            case "1": ?>
                <form method="post">
                    <table id="request_table"
                           class="table text-center table-striped table-bordered mx-auto col-md-6 mt-5"
                           style="float: left">
                        <td colspan="4">
                            <h2> Requests</h2>
                        </td>
                        <tr>
                            <th>Customer Name</th>
                            <th>Description</th>
                            <th>Request Date</th>
                            <th>Look Program</th>
                        </tr>
                        <?php
                        $sql = "select R.UsernameID , Description,RequestDate  from request_program R , customer C 
                      where R.UsernameID = C.UsernameID AND C.TrainerID = '$current_trainer'";
                        $result = mysqli_query($conn, $sql);
                        while ($DB_ROW = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td> <?php
                                    $str = str_replace('c_', ' ', $DB_ROW['UsernameID']);
                                    echo $str;
                                    ?> </td>
                                <td> <?php echo $DB_ROW['Description']; ?> </td>
                                <td> <?php echo $DB_ROW['RequestDate']; ?> </td>
                                <?php
                                echo '<td><a href = "trainer_header.php?select=1&customer=' . $DB_ROW['UsernameID'] . '"
                                          class="btn btn-dark cente" style="float: right;position: relative;left: -30%;">Select</button></td>';
                                ?>

                            </tr>
                        <?php } ?>
                    </table>
                </form> <?php
                $customer = htmlspecialchars($_GET["customer"]);
                $str = str_replace('c_', ' ', $customer);
                @$buton = $_POST["buton"];
                if ($buton) :
                    @$programid = htmlspecialchars($_POST["programid"]);
                    $sql = "delete from asked_for where customerid = '$customer' and ProgramName = '$programid'";
                    mysqli_query($conn, $sql);
                    echo "<script>window.location = 'trainer_header.php?select=1&customer=$customer'</script>";
                else:
                    echo '<td>
                <table id="customer_program_table" class="table text-center table-striped table-bordered mx-auto col-md-5 mt-5" style="float: right">
                    <td colspan="6">
                    <a href = "trainer_header.php?select=2&customer=' . $customer . '" class="btn btn-success" style="float: left;">ADD PROGRAM</a>
                    <h2>' . $str . '\'s Programs</h2>
                    </td>
                    <tr>
                        <th colspan="5">Program Name</th>
                        <th colspan="1">Delete</th>
                    </tr>';

                    $sql = "select * from asked_for where CustomerID = '$customer'";
                    $result = mysqli_query($conn, $sql);

                    while ($DB_ROW = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td colspan="5"> <?php echo $DB_ROW["ProgramName"]; ?> </td>
                            <td colspan="1">
                                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                                    <input type="hidden" name="programid" value="<?php echo $DB_ROW["ProgramName"]; ?>"/>
                                    <input name="buton" value="Delete" type="submit" class="btn btn-dark"/>
                                </form>
                            </td>
                        </tr>
                    <?php }
                endif;
                break;

            case "2":?>
                <form method="post">
                    <table id="request_table"
                           class="table text-center table-striped table-bordered mx-auto col-md-6 mt-5"
                           style="float: left">
                        <td colspan="4">
                            <h2> Requests</h2>
                        </td>
                        <tr>
                            <th>Customer Name</th>
                            <th>Description</th>
                            <th>Request Date</th>
                            <th>Look Program</th>
                        </tr>
                        <?php
                        $sql = "select R.UsernameID , Description,RequestDate  from request_program R , customer C 
                      where R.UsernameID = C.UsernameID AND C.TrainerID = '$current_trainer'";
                        $result = mysqli_query($conn, $sql);
                        while ($DB_ROW = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td> <?php
                                    $str = str_replace('c_', ' ', $DB_ROW['UsernameID']);
                                    echo $str;
                                    ?> </td>
                                <td> <?php echo $DB_ROW['Description']; ?> </td>
                                <td> <?php echo $DB_ROW['RequestDate']; ?> </td>
                                <?php
                                echo '<td><a href = "trainer_header.php?select=1&customer=' . $DB_ROW['UsernameID'] . '"
                                          class="btn btn-dark cente" style="float: right;position: relative;left: -30%;">Select</button></td>';
                                ?>

                            </tr>
                        <?php } ?>
                    </table>
                </form> <?php
                $customer = htmlspecialchars($_GET["customer"]);
                $str = str_replace('c_', ' ', $customer);
                @$buton = $_POST["buton"];
                if ($buton) :
                    @$programid = htmlspecialchars($_POST["programid"]);
                    $sql = "insert into asked_for (customerid, programname) values ('$customer','$programid');";
                    mysqli_query($conn, $sql);
                    echo "<script>window.location = 'trainer_header.php?select=1&customer=$customer'</script>";
                else:
                    echo '<td>
              <table id="program_table" class="table text-center table-striped table-bordered mx-auto col-md-5 mt-5" style="float: right;">
                  <td colspan="6">
                      <h2>Select Proper Program For ' . $str . '</h2>
                  </td>
                  <tr>
                      <th colspan="5">Program Name</th>
                      <th colspan="1">Add</th>
                  </tr>';

                    $sql = "select distinct ProgramName from consist_of where ProgramName not in
                                                  (select ProgramName from asked_for where CustomerID = '$customer')
                                                  and ProgramName not in(select not_fit.ProgramName from has, not_fit 
                                                  where has.CustomerID = '$customer' and has.PyhsicalAilmentName = not_fit.PyhsicalAilmentName)";
                    $result = mysqli_query($conn, $sql);

                    while ($DB_ROW = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td colspan="5"> <?php echo $DB_ROW["ProgramName"]; ?>
                            </td>
                            <td colspan="1">
                                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                                    <input type="hidden" name="programid"
                                           value="<?php echo $DB_ROW["ProgramName"]; ?>"/>
                                    <input name="buton" value="Add" type="submit" class="btn btn-dark"/>
                                </form>
                            </td>
                        </tr>
                    <?php }
                    break;
                endif;
        endswitch;
        ?>
</div>
</body>
</html>