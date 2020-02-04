<?php

session_start();
require '../../includes/dbh.inc.php';

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM lesson,section,work_in where Lesson.Name = work_in.LessonName and section.Room = work_in.SectionRoom
		          and  Lesson.Name = section.LessonName  
	";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["Name"]))
	{
		$name_filter = implode("','", $_POST["Name"]);
		$query .= "
		 AND Lesson.Name IN('".$name_filter."')
		";
	}
	if(isset($_POST["TrainerID"]))
	{
		$TrainerID_filter = implode("','", $_POST["TrainerID"]);
		$query .= "
		 AND work_in.TrainerID IN('".$TrainerID_filter."')
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
					<p align="center"><strong><a href="#">'. $row['Name'] .'</a></strong></p>
					
					Price: '. $row['Price'] .' <br /> 
					Name : '. $row['Name'] .' <br />
					TrainerID : '. $row['TrainerID'] .' <br />
						
				</div>
				
			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Lesson Found</h3>';
	}
	echo $output;
}

?>