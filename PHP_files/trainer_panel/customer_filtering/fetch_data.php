<?php

session_start();
require '../../includes/dbh.inc.php';



if(isset($_POST["action"]))
{
    $current_trainer = $_SESSION['session_UsernameID'];

	$query = "
		SELECT * FROM customer , system_user where customer.UsernameID != ' ' and customer.UsernameID = system_user.UsernameID  
	";
	if(isset($_POST["minimum_AGE"], $_POST["maximum_AGE"]) && !empty($_POST["minimum_AGE"]) && !empty($_POST["maximum_AGE"]))
	{
		$query .= "
		 AND Age BETWEEN '".$_POST["minimum_AGE"]."' AND '".$_POST["maximum_AGE"]."'
		";
	}
    if(isset($_POST["minimum_weight"], $_POST["maximum_weight"]) && !empty($_POST["minimum_weight"]) && !empty($_POST["maximum_weight"]))
    {
        $query .= "
		 AND Weight BETWEEN '".$_POST["minimum_weight"]."' AND '".$_POST["maximum_weight"]."'
		";
    }
    if(isset($_POST["minimum_length"], $_POST["maximum_length"]) && !empty($_POST["minimum_length"]) && !empty($_POST["maximum_length"]))
    {
        $query .= "
		 AND Length BETWEEN '".$_POST["minimum_length"]."' AND '".$_POST["maximum_length"]."'
		";
    }

	if(isset($_POST["membership"]))
	{
		$membership_filter = implode("','", $_POST["membership"]);
		$query .= "
		 AND MembershipTypeName IN('".$membership_filter."')
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
					
					Age: '. $row['Age'] .' <br /> 
					Weight: '. $row['Weight'] .' <br />
					Length: '. $row['Length'] .' <br /> 
					Membership : '. $row['MembershipTypeName'] .' <br />	
				</div>
			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Customer Found</h3>';
	}
	echo $output;
}

?>