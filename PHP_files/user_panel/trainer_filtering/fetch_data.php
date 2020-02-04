<?php

//fetch_data.php
session_start();
require '../../includes/dbh.inc.php';

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM trainer,system_user where trainer.UsernameID = system_user.UsernameID 
	";
	if(isset($_POST["minimum_rating"], $_POST["maximum_rating"]) && !empty($_POST["minimum_rating"]) && !empty($_POST["maximum_rating"]))
	{
		$query .= "
		 AND satisfaction_rating BETWEEN '".$_POST["minimum_rating"]."' AND '".$_POST["maximum_rating"]."'
		";
	}
	if(isset($_POST["school"]))
	{
		$school_filter = implode("','", $_POST["school"]);
		$query .= "
		 AND GraduatedSchool IN('".$school_filter."')
		";
	}
	if(isset($_POST["experience"]))
	{
		$experience_filter = implode("','", $_POST["experience"]);
		$query .= "
		 AND Experience IN('".$experience_filter."')
		";
	}


	$result = mysqli_query($conn,$query);

	$output = '';
	if(mysqli_num_rows($result) > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:450px;">
					<img src="image/default.jpg" alt="" class="img-responsive" >
					<p align="center"><strong><a href="#">'. $row['Name'] .' '. $row['Surname'] .'</a></strong></p>
					
					Rating: '. $row['satisfaction_rating'] .' <br /> 
					School : '. $row['GraduatedSchool'] .' <br />
					Experience : '. $row['Experience'] .' Years<br />
					Username: '.$row['UsernameID'] . '
					
					
				</div>
				

			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Trainer Found</h3>';
	}
	echo $output;
}

?>