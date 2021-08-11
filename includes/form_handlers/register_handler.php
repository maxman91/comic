<?php
//Declaring variables to prevent errors
$username =""; //Username
$birthdate = ""; //birthday
$gender = ""; //gender
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password 2
$date = ""; //Sign up date 
$error_array = array(); //Holds error messages

if(isset($_POST['register_button'])){

	//Registration form values

	//Username
	$username = strip_tags($_POST['reg_username']); //Remove html tags 
	$_SESSION['reg_username '] = $username; //Stores user name into session variable

	//Birthday
	$birthdate = strip_tags($_POST['reg_birthdate']); 
	$_SESSION['reg_birthdate'] = $birthdate; //Stores first name into session variable

	//Gender
	$gender = strip_tags($_POST['reg_gender']);

	//email
	$em = strip_tags($_POST['reg_email']); //Remove html tags
	$em = str_replace(' ', '', $em); //remove spaces
	$em = ucfirst(strtolower($em)); //Uppercase first letter
	$_SESSION['reg_email'] = $em; //Stores email into session variable

	//email 2
	$em2 = strip_tags($_POST['reg_email2']); //Remove html tags
	$em2 = str_replace(' ', '', $em2); //remove spaces
	$em2 = ucfirst(strtolower($em2)); //Uppercase first letter
	$_SESSION['reg_email2'] = $em2; //Stores email2 into session variable

	//Password
	$password = strip_tags($_POST['reg_password']); //Remove html tags
	$password2 = strip_tags($_POST['reg_password2']); //Remove html tags

	$date = date("Y-m-d"); //Current date

	//Check if username already exists 
			$u_check = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($u_check);

			if($num_rows > 0) {
				array_push($error_array, "Username already in use<br>");
			}


	if($em == $em2) {
		//Check if email is in valid format 
		if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists 
			$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0) {
				array_push($error_array, "Email already in use<br>");
			}

		}
		else {
			array_push($error_array, "Invalid email format<br>");
		}


	}
	else {
		array_push($error_array, "Emails don't match<br>");
	}


	if(strlen($username) > 25 || strlen($username) < 2) {
		array_push($error_array, "Your Username must be between 2 and 25 characters<br>");
	}

	if(($username) !== str_replace(' ', '', $username)) {
		array_push($error_array, "Your Username must not have empty spaces.<br>");
	}

	if($password != $password2) {
		array_push($error_array,  "Your passwords do not match<br>");
	}
	else {
		if(preg_match('/[^A-Za-z0-9]/', $password)) {
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

	if(strlen($password > 30 || strlen($password) < 5)) {
		array_push($error_array, "Your password must be betwen 5 and 30 characters<br>");
	}


	if(empty($error_array)) {
		$password = md5($password); //Encrypt password before sending to database

		$active = md5(uniqid(rand(), true));


		//Profile picture assignment
		$rand = rand(1, 2); //Random number between 1 and 2


		if($rand == 1)
			$profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
		else if($rand == 2)
			$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";


		$query = mysqli_query($con, "INSERT INTO users VALUES ('', '$birthdate', '$gender', '$username', '$em', '$password', '$date', '$profile_pic', ',', '0', 'no', ',', ',','$active')");


			$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
			$body .= "http://localhost/comic/" . 'activate.php?x=' . urlencode($em) . "&y=$active";
			mail($_SESSION['reg_email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');

		array_push($error_array, "<span style='color: #14C800;'>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</span><br>");

		//Clear session variables 
		$_SESSION['reg_username'] = "";
		$_SESSION['reg_birthdate'] = "";
		$_SESSION['reg_email'] = "";
		$_SESSION['reg_email2'] = "";
	}

}
?>