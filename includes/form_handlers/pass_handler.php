<?php 

if(isset($_POST['pass_button'])) {

	$email = filter_var($_POST['pass_email'], FILTER_SANITIZE_EMAIL); 

	$check_databasepass_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
	$check_pass_query = mysqli_num_rows($check_databasepass_query);

	 if($check_pass_query == 1) {

	 	$p = substr ( md5(uniqid(rand(), true)), 3, 10);

		// Update the database:
		$q = "UPDATE users SET pass=SHA1('$p') WHERE email='$email' LIMIT 1";
		$body = "Your password to log into <whatever site> has been temporarily changed to '$p'. Please log in using this password. Then you may change your password to something more familiar.";
			mail ($_POST['pass_email'], 'Your temporary password.', $body, 'From: admin@sitename.com');
		    array_push($error_array, "<span style='color: #14C800;'>Temporary password has been sent to your email. </span><br>.</span><br>");
	 }

	 else {
	 	array_push($error_array, "<span>The submitted email address does not match those on file!</span><br>");
	 }




}














?>