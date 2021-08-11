<?php 
include("includes/header.php"); 


if(isset($_GET['profile_username'])) {
	$username = $_GET['profile_username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND user_closed='no'");
	$user_array = mysqli_fetch_array($user_details_query);

	$num_subscribers = (substr_count($user_array['subscribers'], ",")) - 1;
	$num_subscriptions = (substr_count($user_array['subscriptions'], ",")) - 1;
}

if (empty($user_array)) {
    header("location:http://localhost/comic/nopage.php");
}

if(isset($_POST['message_submit'])){
	$user_to = $user_array['username'];
	$userLoggedIn = $user['username'];
	$date = date("Y-m-d H:i:s");
	$body = $_POST['body'];
	$subject = $_POST['subject'];
	$query1 = mysqli_query($con, "INSERT INTO messages VALUES('', '$user_to', '$userLoggedIn', '$body', '$date', ',$userLoggedIn,', 'no', ',', '$subject')");

	 
}

if(isset($_POST['reply'])){

$user_to = $_POST['user_from'];
$replier = $user['username'];
$re = "Reply:";
$originalsubject = str_replace('Reply:','',$_POST['subject']);
$subject = $re.$originalsubject;
$body = $_POST['replymessage'];
$date = date("Y-m-d H:i:s");

$query1 = mysqli_query($con, "INSERT INTO messages VALUES('', '$user_to', '$replier', '$body', '$date', 'no', 'no', 'no', '$subject')");

	 
}


if(isset($_POST['unSUBSCRIBE'])) {

	$logged_in_user = $user['username'];
	$user_to_remove = $user_array['username'];
	$query = mysqli_query($con, "SELECT subscriptions FROM users WHERE username='$logged_in_user'");
	$row = mysqli_fetch_array($query);
	$friend_array_username = $row['subscriptions'];

	$new_friend_array = str_replace($user_to_remove . ",", "", $user['subscriptions']);
	$remove_friend = mysqli_query($con, "UPDATE users SET subscriptions='$new_friend_array' WHERE username='$logged_in_user'");

	$new_friend_array = str_replace($user['username'] . ",", "", $user_array['subscribers']);
	$remove_friend = mysqli_query($con, "UPDATE users SET subscribers='$new_friend_array' WHERE username='$user_to_remove'");
	header("location:http://localhost/comic/profileredirect.php?username=$username");
}


$upload = mysqli_query($con, "SELECT * FROM UPLOADS WHERE username='$username' AND deleted='no' ORDER BY id DESC");




				

if(isset($_POST['SUBSCRIBE'])) {

	if (isset($user)) {
					if ($user_array['username'] != $user['username']) {
						$usernameComma = "," . $user_array['username'] . ",";

					if((strstr($user['subscriptions'], $usernameComma))) {
								header("location:http://localhost/comic/profileredirect.php?username=$username");
					}
					else {
						$user_to = $user_array['username'];
							$user_from = $user['username'];

							

							$add_friend_query = mysqli_query($con, "UPDATE users SET subscribers=CONCAT(subscribers, '$user_from,') WHERE username='$user_to'");
							$add_friend_query = mysqli_query($con, "UPDATE users SET subscriptions=CONCAT(subscriptions, '$user_to,') WHERE username='$user_from'");
							header("location:http://localhost/comic/profileredirect.php?username=$username");
					}
				}
			}
}

?>




<!DOCTYPE html>
<html>
<head>
	<title><?php echo $user_array['username'];?>'s profile| KismatComics</title>
	<script src="assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
	<title></title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body onload="showpostlinks()">
 <div class="page">
   <div id="Profile">
	<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction"><?php echo $user_array['username'];?>'s profile</h2>
		<div>
			<img class="profile_pic" src="<?php echo $user_array['profile_pic']; ?>">
			<br>
			<?php 
				if (isset($user)) {
					if ($user_array['username'] == $user['username']) {
						echo '<a href="settings.php">Settings!</a><br>';
					}
				}
				?>
			<?php
				if (isset($user)) {
   				 if($user_array['username'] != $user['username']) {
   				 	echo '<a href="#" onclick="showmessage()">Send Message!</a>';
   				 } 
   				 else if($user_array['username'] == $user['username']){
   				 	$thisuser = $user_array['username'];
   				 	$newmessagesquery = mysqli_query($con, "SELECT * FROM messages WHERE user_to='$userLoggedIn' AND flaged = 'no'");
   				 	$newstuffcount = 0;

   				 	$newrepliessquery = mysqli_query($con, "SELECT * FROM message_replies WHERE user_to='$userLoggedIn' AND flaged = 'no'");


   				 	foreach ($newmessagesquery as $key => $newmessagesquery) {
   				 		$usernameComma = "," . $userLoggedIn . ",";
					  		

					            if((strstr($newmessagesquery['opened'], $usernameComma))) {
								  
					                             } else {
						                       $newstuffcount++;
					}
   				 	}

   				 	foreach ($newrepliessquery as $key => $newrepliessquery) {
   				 		$usernameComma = "," . $userLoggedIn . ",";
   				 		$messageid     = $newrepliessquery['messages_id'];
   				 		$messagequery = mysqli_query($con, "SELECT * FROM messages WHERE id='$messageid'");
					  	$followingdata = $messagequery->fetch_assoc();
					  

					            if((strstr($newrepliessquery['opened'], $usernameComma)) or (strstr($followingdata['deleted'], $usernameComma))) {
								  
					                             } else {
						                       $newstuffcount++;
					}
   				 	}





   				 	 if($newstuffcount>0)
   				 	 	{
   				 	 	echo '<input type="hidden" id="thisuser" name="thisuser" value=' . $thisuser . '>';
   				 		echo '<a href="messages.php"><b> <p class="new messagelinktw">';
   				 		echo "Check Inbox!(";
   				 		echo $newstuffcount;
   				 		echo ")</p></b></a>";}
   				 	else {
   				 		echo '<a href="messages.php" >Check Inbox!</a>';
   				 	}
   				 	
   				 	
   				 }
   				
   				}
   				 else  {
   				 	echo '<a href="register.php">Send Message!</a>';
   				 }
			 ?>
			 <br>
 			
 			
			<?php 
				if (isset($user)) {
					if ($user_array['username'] == $user['username']) {
						echo '<input type="submit" class="button" onclick="uploadpage()" id="registerpagelink" value="UPLOAD!" name="SUBSCRIBElink">';
					}}
				else {
					echo '<input type="submit" class="button" onclick="linkregisterpage()" id="registerpagelink" value="SUBSCRIBE!" name="SUBSCRIBElink">';
				}
				

			?>
				
			<form action="<?php echo $user_array['username'];?>#" method="POST">

			<?php 
				if (isset($user)) {
					if ($user_array['username'] != $user['username']) {
						$usernameComma = "," . $user_array['username'] . ",";

					if((strstr($user['subscriptions'], $usernameComma))) {
								echo '<input type="submit" class="button"  value="UNSUBSCRIBE" name="unSUBSCRIBE">';
					}
					else {
						echo '<input type="submit" class="button"  value="SUBSCRIBE" name="SUBSCRIBE">';
					}
				}
			}

						
				

			?>


			</form>
		</div>

			
			

			
			<a href="#" id="subscriptions_link" class="links" onclick="showsubscriptionslinks()"> Subscribers: <?php echo $num_subscribers ?></a>
			<a href="#"id="posts_link" class="links" onclick="showpostlinks()">Posts</a>
			<br>
			<br>
		<div class="container">
			<div class="left_tabs" id="left_tabs">
				<a href="#" class="tabs" id="Posts_tab" onclick="showpostlinks()">Posts</a>
				<a href="#" class="tabs" id="Subscriptions_tab" onclick="showsubscriptionslinks()">Subscribers</a>
			</div>
		
			<a href="#" class="tabs" id="Favorites_tab" onclick="showfavoritestab()"> Favorites</a>
			<a href="#" class="tabs" id="Subscribers_tab" onclick="showsubscriberstab()">Subscriptions</a>
		</div>
	</div>
	<div class="library">
		<div id="Posts_library">
			

			<?php  

			$p=0;
				foreach ($upload as $key => $upload) {
					$string = $upload['image'];
					$p++;
					$arr = explode(",", $string, 2);
					$image = $arr[0];
					$postid = $upload['id'];
					
					if ($p<9) {
						echo '<a href="comic/'.$postid.'"><img class="thumbnailpic" src="'.$image.'"></a>';
					} else {
					echo '<a class="lazys" href="comic/'.$postid.'"><img class="lazy" data-src="'.$image.'"></a>';}

				}



			?>

		</div>
			<div id="Favorites_library">
			 
			<?php
				$allFavorites = $user_array['favorites'];
				$favorites2 = explode( ',', $allFavorites );
				$Favorites = array_filter($favorites2);
				

				$f=0;

				foreach( array_reverse($Favorites) as $index => $Favorites ) {
					$favorites_query = mysqli_query($con, "SELECT * FROM uploads WHERE id='$Favorites' AND deleted='no'");

					$favorites_array = mysqli_fetch_array($favorites_query);
					
					$deleted = $favorites_array['deleted'];

					if ($deleted =='no') {
						# code...
					


					$link = "http://localhost/comic/comic/$Favorites";





					
					$pic_query = mysqli_query($con, "SELECT image FROM uploads WHERE id='$Favorites' AND deleted='no' ");
					
					//$deleted = mysqli_num_rows($r);

					//if ($deleted == 0) {
					//	break;
					//}
						$f++;
					$pic_array = mysqli_fetch_array($pic_query);
					$pic = implode(' ', (array)$pic_array);
					$string = $pic;
					$arr = explode(",", $string, 2);
					$image = $arr[0];
	    			if ($f<9) {
	    			echo '<a href="'.$link.'"><img class="thumbnailpic" src="'.$image.'"></a>';}
	    			else {
	    			echo '<a class="lazys" href="'.$link.'"><img class="lazy" data-src="'.$image.'"></a>';}

	    			
	    				}

	    			}
	    			 ?>

			</div>
			<div id="Subscriptions_library">
			<b>Subscribers: <?php echo $num_subscribers ?> </b>
				<div class="subscribers">
				<?php
				$allSubscribers = $user_array['subscribers'];
				$Subscribers2 = explode( ',', $allSubscribers );
				$Subscribers = array_filter($Subscribers2);
				
				$sb=0;

				foreach( $Subscribers as $index => $Subscribers ) {
					$link = "http://localhost/comic/$Subscribers";

					$pic_query = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$Subscribers'");
					$pic_array = mysqli_fetch_array($pic_query);
					$pic = implode(' ', (array)$pic_array);
	    			
					$sb++;
	    			if ($sb<60) {
	    			
	    			echo '<a href=';
	    			echo $link;
	    			echo '>';
	    			
	    			echo '<img src='. $pic.'><br>'. $Subscribers;
	    			echo '</a><br>';}

	    			else {
	    				echo '<a class="lazys" href=';
	    				echo $link;
	    				echo '>';
	    			
	    				echo '<img class="lazys" data-src='. $pic.'><br>'. $Subscribers;
	    				echo '</a><br>';
	    			}
	    				

	    			}
	    			 ?>
				</div>
			</div>
			<div id="Subscribers_library">
			  
				<div class="subscriptions">
				
								
					<form>
					<select name="Subscriptions" onchange="showUser(this.value)">
					<option value=""><b>Subscriptions: <?php echo $num_subscriptions ?></b></option>


						<?php
						$allsubscriptions = $user_array['subscriptions'];
						$subscriptions2 = explode( ',', $allsubscriptions );
						$subscriptions = array_filter($subscriptions2);
						
						

				
							foreach($subscriptions as $key => $value):
							echo '<option value="'.$value.'">'.$value.'</option>'; //close your tags!!
							

							endforeach;


							?>
				
					</select>
			    	</form>
						
					<div id="txtHint">
						<?php
						$allsubscriptions = $user_array['subscriptions'];
						$subscriptions2 = explode( ',', $allsubscriptions );
						$subscriptions = array_filter($subscriptions2);
						
						
						foreach ($subscriptions as $key => $subscriptions) {
							$uploadpics = mysqli_query($con, "SELECT * FROM UPLOADS WHERE username='$subscriptions' AND deleted='no'");
						}
						
					


						?>
					</div>
					</div>
				</div>
			</div>
		</div>
	
	<div id="Inbox">
		<div class="header">
			<br>
			<h2 class="logo">KComics</h2>
			<h2 class="instruction"><?php echo $user_array['username'];?>'s inbox</h2>
			<div>
				
			


				<img class="profile_pic" src="<?php echo $user_array['profile_pic']; ?>">
			<br>
			<a href="#" onclick="showprofile()">View Profile!</a>
			<h3 class="instruction">Send <?php if($user_array['username'] != $user['username']) {
   				 	echo $user_array['username'];
   				 } ?> a message!</h3>
			</div>


		</div>
			
				
			
				<form class="<?php
						
   				 		if($user_array['username'] != $user['username']) {
   				 	
   				 		echo 'message';				} 
   				 		else {
   				 			echo 'hide';
   				 		}

					 ?>" name="message"  action="<?php echo $user_array['username'];?>#" method="post">
					<input type="text" name="subject" placeholder="Subject" required>
				</br>
					<textarea name="body" placeholder="Message" required></textarea>
				</br>

					<input type="submit" name="message_submit" class="button" value="Send Message!">
				




				</form>




	</div>
</div>

</body>
</html>