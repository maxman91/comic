<?php
require 'config/config.php';

if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}
else {
	header("Location: register.php");
}

if(isset($_POST['cancel'])) {
	header("Location: settings.php");
}

if(isset($_POST['close_account'])) {
	$close_query = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");
	$removeactivity = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLoggedIn'");
	$new_friend_array = str_replace($userLoggedIn . ",", "", $user['subscriptions']);
	$remove_friend = mysqli_query($con, "UPDATE users SET subscriptions='$new_friend_array'");

	$remove_comments = mysqli_query($con, "UPDATE comments SET deleted='yes' WHERE user_from='$userLoggedIn'");
	$remove_posts = mysqli_query($con, "UPDATE uploads SET deleted='yes' WHERE username='$userLoggedIn'");

	
	

	$new_friend_array = str_replace($userLoggedIn . ",", "", $user['subscribers']);
	$remove_friend = mysqli_query($con, "UPDATE users SET subscribers='$new_friend_array'");
	session_destroy();
	header("Location: register.php");
}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/settings.css">
	<title>Close Account | KismatComics</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
<form action="close_account.php" method="POST">
<div class="page">
	<div class="header">
		<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
		<h2 class="instruction">Close Account</h4>
		</div>
		<br>
	
		
	Are you sure you want to close your account?<br><br>
	Closing your account will hide your profile, comments and all your posts from other users. Private messages sent will still be seen.<br><br>
	You can re-open your account at any time by simply logging in.<br><br>

	
		<input type="submit" name="close_account" id="close_account" value="Yes! Close it!" class="danger settings_submit">
		<input type="submit" name="cancel" id="update_details" value="No way!" class="info settings_submit">
	</form>

</div>

</body>
</html>
