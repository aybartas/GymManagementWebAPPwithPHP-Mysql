<?php
include '../includes/dbh.inc.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Lesson</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>

    <style>
        .topnav {
            overflow: hidden;
            background-color: #333;

            top: 0;
            width: 100%;
        }

        .topnav a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }


    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
<div class="topnav">
    <a href="../header.php"> Main Page</a>
    <a href="user_header.php">Customer Panel</a>
    <a href="user_profile.php">Profile</a>
    <a href="join_lesson.php">Join a Lesson</a>
    <a href="my_lessons.php">My Lessons</a>
    <a href="request_workout.php">Request Workout</a>

</div>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header clearfix">
                    <br>
                    <br>
                    <h2 class="pull-left">Lesson Details</h2>
                </div>
                <?php
                $username = $_SESSION['session_UsernameID'];
                $sql = " select  work_in.LessonName as LN, system_user.Name as systemusername, Surname, `Day`  as day,StartTime,EndTime,Price,Room, TrainerID 
                            from system_user, work_in ,section,lesson,purchase
                where work_in.LessonName= section.LessonName and work_in.SectionRoom = Room  
                  and  lesson.`Name` = section.LessonName and work_in.TrainerID = system_user.UsernameID 
                  and purchase.SectionRoom = work_in.SectionRoom and purchase.LessonName = work_in.LessonName 
                  and purchase.CustomerID = '". $username ."'";

                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Lesson Name</th>";
                        echo "<th>Trainer Name</th>";
                        echo "<th>Trainer Surname</th>";
                        echo "<th>Section Time</th>";
                        echo "<th>Price</th>";
                        echo "<th>Room</th>";
                        echo "<th>Delete Lesson</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        $merge_same_lesson = array();
                        $i=0;
                        $control=0;
                        $aa=0;

                        while($row = mysqli_fetch_array($result)) {
                            $aa++;
                            for ($j = 0; $i!=0 && $j<count ($merge_same_lesson); $j++) {
                                if ($merge_same_lesson[$j][0][0] == $row["LN"] &&
                                    $merge_same_lesson[$j][5][0] == $row["Room"] &&
                                    $merge_same_lesson[$j][6][0] == $row["TrainerID"]) {
                                    array_push($merge_same_lesson[$j][3], $row["day"].":".substr($row['StartTime'],
                                            0,5)."-".substr($row['EndTime'],0,5)
                                    );
                                    $control =1;
                                }
                            }
                            if($control == 0){
                                $merge_same_lesson[$i][0][0] = $row["LN"];
                                $merge_same_lesson[$i][1][0] = $row["systemusername"];
                                $merge_same_lesson[$i][2][0] = $row["Surname"];
                                $merge_same_lesson[$i][3][0] = $row["day"].":".substr($row['StartTime'],0,5)."-".substr($row['EndTime'],0,5);
                                $merge_same_lesson[$i][4][0] = $row["Price"];
                                $merge_same_lesson[$i][5][0] = $row["Room"];
                                $merge_same_lesson[$i][6][0] = $row["TrainerID"];
                                $i++;
                            }
                            $control =0;
                        }


                        $i=0;
                        for( $i=0;$i<count ($merge_same_lesson); $i++){
                            $string = "";
                            for ($j = 0; $j<count ($merge_same_lesson[$i][3]); $j++)
                                $string = $string . $merge_same_lesson[$i][3][$j]."\n";


                            echo "<tr>";
                            echo "<td>" . $merge_same_lesson[$i][0][0] . "</td>";
                            echo "<td>" . $merge_same_lesson[$i][1][0] . "</td>";
                            echo "<td>" . $merge_same_lesson[$i][2][0] . "</td>";


                            echo "<td>" . $string ."</td>";

                            echo "<td>" . $merge_same_lesson[$i][4][0] . "</td>";
                            echo "<td>" . $merge_same_lesson[$i][5][0]  . "</td>";
                            echo "<td>";
                            echo  "<a href='includes/delete_lesson.inc.php?LessonName=". $merge_same_lesson[$i][0][0]."&Room=" .$merge_same_lesson[$i][5][0] ."'
                        title='Delete Lesson' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></>";


                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";

                        // Free result set
                        mysqli_free_result($result);
                    } else{
                        echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                } else{
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }

                ?>
            </div>


        </div>
    </div>
</div>
</body>
</html>