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
        	<h2 align="center">FILTERING FOR YOUR CUSTOMERS</h2>
            <p><button onclick="window.location='../trainer_header.php?select=0'">Click me to go back </button></p>

        	<br />
            <div class="col-md-3">                				
				<div class="list-group">
					<h3>AGE</h3>
					<input type="hidden" id="hidden_minimum_AGE" value="15" />
                    <input type="hidden" id="hidden_maximum_AGE" value="99" />
                    <p id="AGE_show">15-99</p>
                    <div id="AGE_range"></div>
                </div>

                <div class="list-group">
                    <h3>WEIGHT</h3>
                    <input type="hidden" id="hidden_minimum_weight" value="30" />
                    <input type="hidden" id="hidden_maximum_weight" value="200" />
                    <p id="weight_show">30-200</p>
                    <div id="weight_range"></div>
                </div>
                <div class="list-group">
                    <h3>LENGTH</h3>
                    <input type="hidden" id="hidden_minimum_length" value="140" />
                    <input type="hidden" id="hidden_maximum_length" value="240" />
                    <p id="length_show">140-240</p>
                    <div id="length_range"></div>
                </div>

                <div class="list-group">
					<h3>Membership</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = "SELECT DISTINCT MembershipTypeName FROM customer order by MembershipTypeName";

                    $result = mysqli_query($conn,$query);
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector membership" value="<?php echo $row['MembershipTypeName']; ?>"  > <?php echo $row['MembershipTypeName']; ?></label>
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
        var minimum_AGE = $('#hidden_minimum_AGE').val();
        var maximum_AGE = $('#hidden_maximum_AGE').val();
        var minimum_weight = $('#hidden_minimum_weight').val();
        var maximum_weight = $('#hidden_maximum_weight').val();
        var minimum_length = $('#hidden_minimum_length').val();
        var maximum_length = $('#hidden_maximum_length').val();
        var membership = get_filter('membership');


        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_AGE:minimum_AGE, maximum_AGE:maximum_AGE,minimum_weight:minimum_weight, maximum_weight:maximum_weight,minimum_length:minimum_length, maximum_length:maximum_length, membership:membership},
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

    $('#AGE_range').slider({
        range:true,
        min:15,
        max:99,
        values:[15, 99],
        step:1,
        stop:function(event, ui)
        {
            $('#AGE_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_AGE').val(ui.values[0]);
            $('#hidden_maximum_AGE').val(ui.values[1]);
            filter_data();
        }
    });
    $('#weight_range').slider({
        range:true,
        min:30,
        max:200,
        values:[30, 200],
        step:1,
        stop:function(event, ui)
        {
            $('#weight_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_weight').val(ui.values[0]);
            $('#hidden_maximum_weight').val(ui.values[1]);
            filter_data();
        }
    });
    $('#length_range').slider({
        range:true,
        min:140,
        max:240,
        values:[140, 240],
        step:1,
        stop:function(event, ui)
        {
            $('#length_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_length').val(ui.values[0]);
            $('#hidden_maximum_length').val(ui.values[1]);
            filter_data();
        }
    });

});
</script>

</body>

</html>
