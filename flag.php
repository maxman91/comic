<?php
require 'config/config.php';

if(isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}

if (isset($_POST['flag'])) {
  $postid = $_POST['flagpost'];
  

}

if(isset($userLoggedIn)){
	$user_from = $userLoggedIn;
} else {
	$user_from = '+';
}

if(isset($_POST['cancel'])) {
	header("Location: settings.php");
}


if (isset($_POST['flagp'])) {
  $postid = $_POST['flagpost'];
	$post_details_query = mysqli_query($con, "SELECT * FROM uploads WHERE id='$postid' AND deleted='no'");
	$post_array = mysqli_fetch_array($post_details_query);
    $reason = $_POST['reason'];
    $total_flags = $post_array['flags'];
    $total_flags++;
	$post_id = $post_array['id'];
	$date = date("Y-m-d H:i:s");
	
	$query = mysqli_query($con, "UPDATE uploads SET flags='$total_flags' WHERE id='$post_id'");
	$query2 = mysqli_query($con, "UPDATE uploads SET flag=CONCAT(flag, '$user_from,') WHERE id='$post_id'");
	
	$query3 = mysqli_query($con, "INSERT INTO flagpost VALUES ('', '$user_from', '$post_id', '$reason', '$date','no')");

	header("location:http://localhost/comic/index.php");
	

}

if (isset($_POST['unflag'])) {
  	$postid = $_POST['flagpost'];
	$post_details_query = mysqli_query($con, "SELECT * FROM uploads WHERE id='$postid' AND deleted='no'");
	$post_array = mysqli_fetch_array($post_details_query);
	
	$total_flags = $post_array['flags'];
	$total_flags--;
	$post_id = $post_array['id'];
	$user_from = $user['username'];
	$query = mysqli_query($con, "UPDATE uploads SET flags='$total_flags' WHERE id='$post_id'");
	$query2 = mysqli_query($con, "UPDATE uploads SET flag=CONCAT(flag, '$user_from,') WHERE id='$post_id'");
	$new_friend_array = str_replace($user['username'] . ",", "", $post_array['flag']);
	$remove_friend = mysqli_query($con, "UPDATE uploads SET flag='$new_friend_array' WHERE id='$post_id'");
	
	if(isset($userLoggedIn)){
		$removeflagquery = mysqli_query($con, "UPDATE flagpost SET unflagged='yes' WHERE userfrom='$userLoggedIn' AND postid='$post_id'");
                          }
	
     header("location:http://localhost/comic/comic/$post_id");
}



?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/settings.css">
	<title>Flag | KismatComics</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
<form action="flag.php" method="POST">
<div class="page">
	<div class="header">
		<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
		<h2 class="instruction">Flag</h4>
		</div>
		
		
		
      		<textarea name="reason" required placeholder="Reason for flagging"></textarea>
    
		<br>
	<p>Are you sure you want flag this post? Please leave detailed information above to permanently remove content or to ban abusive users. If you are not logged in please leave an email where you can be contacted.</p><br>
	<?php 
		echo "<input type='hidden' name='flagpost' value=";
		echo $postid;
		echo '">'; ?>
	
		<input type="submit" name="flagp" id="close_account" value="Yes! Flag it!" class="danger settings_submit">
		<input type="submit" name="cancel" id="update_details" value="Cancel flag!" class="info settings_submit">
	</form>

</div>

</body>
</html>
