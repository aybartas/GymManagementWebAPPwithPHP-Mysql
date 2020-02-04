<?php 

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

    <title>FILTERING LESSONS</title>

    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href = "css/jquery-ui.css" rel = "stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
        	<br />
        	<h2 align="center">FILTER LESSONS</h2>
            <p><button onclick="window.location='../trainer_header.php?select=0'">Click me to go back </button></p>

        	<br />
            <div class="col-md-3">                				
				<div class="list-group">
					<h3>Price</h3>
					<input type="hidden" id="hidden_minimum_price" value="0" />
                    <input type="hidden" id="hidden_maximum_price" value="1000" />
                    <p id="price_show">0-1000</p>
                    <div id="price_range"></div>
                </div>				
                <div class="list-group">
					<h3>Name</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = "SELECT DISTINCT Name FROM lesson order by Name";

                    $result = mysqli_query($conn,$query);
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector Name" value="<?php echo $row['Name']; ?>"  > <?php echo $row['Name']; ?></label>
                    </div>
                    <?php
                    } ?>
                    </div>
                </div>
                <div class="list-group">
                    <h3>TrainerID</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
                        <?php

                        $query = "SELECT DISTINCT TrainerID FROM work_in order by TrainerID";

                        $result = mysqli_query($conn,$query);
                        foreach($result as $row)
                        {
                            ?>
                            <div class="list-group-item checkbox">
                                <label><input type="checkbox" class="common_selector TrainerID" value="<?php echo $row['TrainerID']; ?>"  > <?php echo $row['TrainerID']; ?></label>
                            </div>
                            <?php
                        } ?>
                    </div>
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
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var Name = get_filter('Name');
        var TrainerID = get_filter('TrainerID');

        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, Name:Name, TrainerID:TrainerID},
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

    $('#price_range').slider({
        range:true,
        min:0,
        max:1000,
        values:[0, 1000],
        step:5,
        stop:function(event, ui)
        {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });
});
</script>

</body>

</html>
