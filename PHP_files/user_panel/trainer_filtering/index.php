<?php 

//index.php
session_start();
require '../../includes/dbh.inc.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FILTERING TRAINERS</title>

    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href = "css/jquery-ui.css" rel = "stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
        	<br />
        	<h2 align="center">FILTER TRAINERS</h2>
            <p><button onclick="window.location='../user_header.php'">Click me to go back and select trainer</button></p>

        	<br />
            <div class="col-md-3">                				
				<div class="list-group">
					<h3>Rating</h3>
					<input type="hidden" id="hidden_minimum_rating" value="1" />
                    <input type="hidden" id="hidden_maximum_rating" value="10" />
                    <p id="rating_show">1-10</p>
                    <div id="rating_range"></div>
                </div>				
                <div class="list-group">
					<h3>School</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = "SELECT DISTINCT GraduatedSchool FROM trainer order by GraduatedSchool";

                    $result = mysqli_query($conn,$query);
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector school" value="<?php echo $row['GraduatedSchool']; ?>"  > <?php echo $row['GraduatedSchool']; ?></label>
                    </div>
                    <?php
                    } ?>
                    </div>
                </div>
                <div class="list-group">
                    <h3>Experience</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
                        <?php

                        $query = "SELECT DISTINCT Experience FROM trainer order by Experience";

                        $result = mysqli_query($conn,$query);
                        foreach($result as $row)
                        {
                            ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector experience" value="<?php echo $row['Experience']; ?>"  > <?php echo $row['Experience']; ?></label>
                            </div>
                            <?php
                        } ?>
                    </div>
                </div>
                <div class="col-md-9">

                    <form action="../includes/select_trainer.inc.php"  style="width: 50%;margin: 5px auto;margin-left: 0;float: left" method="post" >
                        <div class="container" >



                            <p style="font-size:x-large;color: #2d6987"> Select Your Trainer</p>

                            <select name="selected_trainer" >

                                <?php
                                $sql = "select trainer.UsernameID  as t,Name,Surname  from trainer, system_user where trainer.UsernameID = system_user.UsernameID";
                                $result = mysqli_query($conn,$sql);
                                $i = 0;

                                while($DB_ROW = mysqli_fetch_array($result)){
                                    $option_value =  $DB_ROW['t']. " " .$DB_ROW['Name']. " " .$DB_ROW['Surname'];

                                    ?>
                                    <option>
                                        <?php  echo $option_value;   ?>
                                    </option>
                                    <?php
                                    $i++;} ?>
                            </select>

                            <button type="submit" class="update-button" name="trainer-submit" style="float: left"> Select </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-9">
            	<br />
                <div class="row filter_data">

                </div>
            </div>
        </div>

    </div>
<style>
#loading
{
	text-align:center; 
	background: url('loader.gif') no-repeat center; 
	height: 150px;
}
</style>

<script>
$(document).ready(function(){

    filter_data();

    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var minimum_rating = $('#hidden_minimum_rating').val();
        var maximum_rating = $('#hidden_maximum_rating').val();
        var school = get_filter('school');
        var experience = get_filter('experience');

        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_rating:minimum_rating, maximum_rating:maximum_rating, school:school, experience:experience},
            success:function(data){
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    $('#rating_range').slider({
        range:true,
        min:1,
        max:10,
        values:[1, 10],
        step:1,
        stop:function(event, ui)
        {
            $('#rating_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_rating').val(ui.values[0]);
            $('#hidden_maximum_rating').val(ui.values[1]);
            filter_data();
        }
    });

});
</script>

</body>

</html>
