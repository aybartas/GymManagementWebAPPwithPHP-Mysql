<?php
session_start();
require_once "../../includes/dbh.inc.php";


@$buton = $_POST["buton"];
if ($buton){
    @$LessonName = htmlspecialchars($_POST["LessonName"]);
    @$Room = htmlspecialchars($_POST["Room"]);
    $current_customer = $_SESSION["session_UsernameID"];

    $sql_check = "select CustomerID, LessonName,SectionRoom from  purchase where CustomerID = '$current_customer'";
    $result = mysqli_query($conn,$sql_check);
    $exist = 0;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

            if ($row['LessonName'] == $LessonName and $Room = $row['SectionRoom']){
                $exist = 1;
            }
        }
    }

    if ($exist == 1){

        header("location: ../join_lesson.php?error=lessonalreadytaken");
        exit();
    }

    $sql = "INSERT INTO purchase (CustomerID, SectionRoom, LessonName) VALUES (?,?, ?)";

    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "sis", $current_customer, $Room,$LessonName);

        if(mysqli_stmt_execute($stmt)){

            header("location: ../join_lesson.php");
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Lesson</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Confirm Purchase</h2>
                </div>
                <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <p>Are you sure you want to buy this lesson ? .</p>
                    <p> No refund provided for this process </p>
                    <input type="hidden" name="LessonName" value="<?php echo $_GET["LessonName"]; ?>"/>
                    <input type="hidden" name="Room" value="<?php echo $_GET["Room"]; ?>"/>
                    <input name="buton" type="submit" class="btn btn-primary" value="Buy">
                    <a href="../join_lesson.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>