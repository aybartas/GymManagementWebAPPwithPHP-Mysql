
<?php
session_start();
require_once "../../includes/dbh.inc.php";


@$buton = $_POST["buton"];
if ($buton){
    @$LessonName = htmlspecialchars($_POST["LessonName"]);
    @$Room = htmlspecialchars($_POST["Room"]);
    $current_customer = $_SESSION["session_UsernameID"];


    $sql = "DELETE FROM purchase WHERE LessonName = '$LessonName' and  SectionRoom = '$Room' and CustomerID = '$current_customer' ";

    $result = mysqli_query($conn,$sql);

    if($result){

        header("location: ../my_lessons.php?message=DeletedSuccesfully");
        exit();
    }
    else{

        header("location: ../my_lessons.php?error=deletediscarded");
            exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Lesson</title>
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
                    <h2>Confirm Removal</h2>
                </div>
                <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <p>Are you sure you want to remove this lesson ? .</p>
                    <p> This process can not be taken back</p>
                    <input type="hidden" name="LessonName" value="<?php echo $_GET["LessonName"]; ?>"/>
                    <input type="hidden" name="Room" value="<?php echo $_GET["Room"]; ?>"/>
                    <input name="buton" type="submit" class="btn btn-primary" value="Delete">
                    <a href="../my_lessons.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
