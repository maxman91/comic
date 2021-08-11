<?php 
require 'config/config.php';

include("includes/form_handlers/settings_handler.php");

if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}
else {
	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Setting | KismatComics</title>
 <link rel="stylesheet" type="text/css" href="assets/css/settings.css">
 <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
	<div class="page">
	<div class="header">
		<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
		<h2 class="instruction"><?php echo $_SESSION['username']?>'s Settings</h2>
		</div>
		<br>
		<?php echo $password_message; ?>
		<?php
		echo "<img src='" . $user['profile_pic'] ."' class='small_profile_pic'>";
			?>
			<br>
			<a href="upload.php">Upload new profile picture</a> <br><br><br>
			
	

	<h4>Change Password</h4>
	<form action="settings.php" method="POST">
		 <input type="password" placeholder="Old Password" name="old_password" id="settings_input"><br>
		 <input type="password" placeholder="New Password" name="new_password_1" id="settings_input"><br>
		 <input type="password" placeholder="New Password Again" name="new_password_2" id="settings_input"><br>

		

		<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
	</form>

	<h4>Close Account</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
	</form>
	
</div>
</body>
</html>