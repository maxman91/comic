<?php  
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$uid = FALSE;
	

	// Validate the email address...
	if (!empty($_POST['email'])) {

		// Check for the existence of that email address...
		$q = 'SELECT id FROM users WHERE email="'.  mysqli_real_escape_string ($con, $_POST['email']) . '"';
		$r = mysqli_query ($con, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($con));
		
		if (mysqli_num_rows($r) == 1) { // Retrieve the user ID:
			list($uid) = mysqli_fetch_array ($r, MYSQLI_NUM); 
		} else { // No database match made.
			array_push($error_array, "<p>The submitted email address does not match those on file!</p>");
		}
		
	} else { // No email!
		array_push($error_array, "<p>You forgot to enter your email address!</p>");

		
	} // End of empty($_POST['email']) IF.
	
	if ($uid) { // If everything's OK.

		// Create a new, random password:
		$p = substr ( md5(uniqid(rand(), true)), 3, 10);

		// Update the database:
		$q = "UPDATE users SET password=md5('$p') WHERE id=$uid LIMIT 1";
		$r = mysqli_query ($con, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($con));

		if (mysqli_affected_rows($con) == 1) { // If it ran OK.
		
			// Send an email:
			$body = "Your password to log into <whatever site> has been temporarily changed to '$p'. Please log in using this password and this email address. Then you may change your password to something more familiar.";
			mail ($_POST['email'], 'Your temporary password.', $body, 'From: admin@sitename.com');
			
			// Print a message and wrap up:
			 array_push($error_array, "<p>Your password has been changed. You will receive the new, temporary password at the email address with which you registered. Once you have logged in with this password, you may change it by clicking on the Change Password link.</p>");
			mysqli_close($con);
			 // Stop the script.
			
		} else { // If it did not run OK. 
			array_push($error_array, "<p>Your password could not be changed due to a system error. We apologize for any inconvenience.</p>");
		}

	} else { // Failed the validation test.
		
		array_push($error_array, "<p>Please try again.</p>");

	}


} // End of the main Submit conditional.
?>
<html>
<head>
	<title>Password Recovery| KismatComics</title>
	<script src="assets/js/register.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	</head>
<body>

<form action="forgot.php" method="post">
	<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
	   		<h2 class="instruction">Password Recovery</h2>

	
	<input type="text" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
	<br>

	

	<?php if(in_array("<p>The submitted email address does not match those on file!</p>", $error_array)) echo "<p>The submitted email address does not match those on file!</p><br>"; 
		else if(in_array("<p>You forgot to enter your email address!</p>", $error_array)) echo "<p>You forgot to enter your email address!</p><br>";
		else if(in_array("<p>Your password has been changed. You will receive the new, temporary password at the email address with which you registered. Once you have logged in with this password, you may change it by clicking on the Change Password link.</p>", $error_array)) echo "<p>Your password has been changed. You will receive the new, temporary password at the email address with which you registered. Once you have logged in with this password, you may change it in your settings page.</p><br>"; 
		else if(in_array("<p>Your password could not be changed due to a system error. We apologize for any inconvenience.</p>", $error_array)) echo "<p>Your password could not be changed due to a system error. We apologize for any inconvenience.</p><br>";
		else if(in_array("<p>Please try again.</p>", $error_array)) echo "<p>Please try again.</p><br>";










	 ?>

	
	<a href="register.php" id="signin" class="signin">Login here!</a>


	<input type="submit" name="submit" value="Recover" />

</form>

</body>
</html>
