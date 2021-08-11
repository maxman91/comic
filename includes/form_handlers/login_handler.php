<?php  

if(isset($_POST['login_button'])) {
	$username = strip_tags($_POST['log_username']);

	$email = filter_var($_POST['log_username'], FILTER_SANITIZE_EMAIL); //sanitize email

	$_SESSION['log_username'] = $username; //Store username into session variable 
	$password = md5($_POST['log_password']); //Get password

	$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND active IS NULL");
	$check_login_query = mysqli_num_rows($check_database_query);

	$check_active_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND active IS NOT NULL");
	$check_activated_query = mysqli_num_rows($check_active_query);

	if($check_login_query == 1) {
		$row = mysqli_fetch_array($check_database_query);


		

		$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND user_closed='yes'");
		if(mysqli_num_rows($user_closed_query) == 1) {
			$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE username='$username'");
		}
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	    $user = mysqli_fetch_array($user_details_query);

		$_SESSION['username'] = $user['username'];
		header("Location: index.php");
		exit();
	}

	$check_edatabase_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password' AND active IS NULL");
	$check_elogin_query = mysqli_num_rows($check_edatabase_query);

	$check_eactive_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password' AND active IS NOT NULL");
	$check_eactivated_query = mysqli_num_rows($check_eactive_query);

	if($check_elogin_query == 1) {
		$row = mysqli_fetch_array($check_edatabase_query);
		$username = $row['username'];

		

		$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
		if(mysqli_num_rows($user_closed_query) == 1) {
			$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
		}




		$_SESSION['username'] = $username;
		header("Location: index.php");
		exit();
	}

	else if ($check_activated_query == 1) {
		array_push($error_array, "Account has not been activated.Another confirmation email has been sent to your address.<br>");
		$row = mysqli_fetch_array($check_active_query);


		$em = $row['email'];
		$active = $row['active'];

		$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
		$body .= "http://localhost/comic/" . 'activate.php?x=' . urlencode($em) . "&y=$active";
		mail($em, 'Registration Confirmation', $body, 'From: admin@sitename.com');
	}


	else if ($check_eactivated_query == 1) {
		array_push($error_array, "Account has not been activated.Another confirmation email has been sent to your address.<br>");
		$row = mysqli_fetch_array($check_eactive_query);


		$em = $row['email'];
		$active = $row['active'];

		$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
		$body .= "http://localhost/comic/" . 'activate.php?x=' . urlencode($em) . "&y=$active";
		mail($em, 'Registration Confirmation', $body, 'From: admin@sitename.com');
	}


	else {
		array_push($error_array, "Username or password was incorrect<br>");
	}


}

?>