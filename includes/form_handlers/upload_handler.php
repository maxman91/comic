<?php
//Declaring variables to prevent errors
$title =""; 
$image = ""; 
$description = ""; 
$username = ""; 
$date = ""; 
$error_array = array(); 

 if(isset($_POST['upload_button'])){

	//Registration form values

	//Username
	$username = $userLoggedIn
	

	$date = date("Y-m-d H:i:s"); //Current date

	//title
	$title = ($_POST['upload_title']);

	//description
	$description = ($_POST['upload_description']);


	if(strlen($title) > 25 || strlen($username) < 2) {
		array_push($error_array, "Your title must be between 2 and 25 characters<br>");
	}

	$image = ($_POST['upload_image']);
		
			


		$query = mysqli_query($con, "INSERT INTO uploads VALUES ('', '$username', '$title', '$description', '$image', '$date', '0', '0', '0','no')");


			

		//Clear session variables 
		$_SESSION['upload_image'] = "";
		$_SESSION['upload_title'] = "";
		$_SESSION['upload_description'] = "";
		
	}

}
?>