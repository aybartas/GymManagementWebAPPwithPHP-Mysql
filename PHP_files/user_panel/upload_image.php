<?php

session_start();
include '../includes/dbh.inc.php';
include 'navbar.php';
?>


<form enctype="multipart/form-data" action="includes/upload_file.inc.php" method="post" name="changer" style="margin-top:300px;margin-left: 200px">
    <h1> Select an Image</h1>
    <input name="image" accept="image/jpeg" type="file">

    <input value="Submit" type="submit">
</form>
