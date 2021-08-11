<?php  
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
if (isset($_GET['x'], $_GET['y']) 
	&& filter_var($_GET['x'], FILTER_VALIDATE_EMAIL)
	&& (strlen($_GET['y']) == 32 )
	) {

	// Update the database...
	
	$q = "UPDATE users SET active=NULL WHERE (email='" . mysqli_real_escape_string($con, $_GET['x']) . "' AND active='" . mysqli_real_escape_string($con, $_GET['y']) . "') LIMIT 1";
	$r = mysqli_query ($con, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($con));
	?>
	<html>
<head>
	<title>Activation | KismatComics</title>
	<script src="assets/js/register.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
</head>
	
 <form>
 	<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction">Activation</h2>
			<br>
	<?php  
	if (mysqli_affected_rows($con) == 1) {
		echo "<h3>Your account is now active. You may now log in.</h3>";
	} else {
		echo '<p class="error">Your account could not be activated. Please re-check the link or contact the system administrator.</p>'; 
	}
	?>
	<a href="register.php" id="signin" class="signin">Login here!</a>
</form>
</html>
 <?php
	mysqli_close($con);

} else { // Redirect.

	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.

} // End of main IF-ELSE.
?>
