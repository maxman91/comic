<?php 
include("includes/header.php"); 
if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}
else {
	header("Location: register.php");
}
              $thisuser = $user['username'];
				$q = "SELECT id , body , user_to , user_from , date , opened, flaged , deleted , subject FROM messages WHERE user_to = '$thisuser' ORDER BY id DESC";
				$r = mysqli_query($con, $q) or die("no query");

				$s = "SELECT id , body , user_to , user_from , date , opened, flaged , deleted , subject FROM messages WHERE user_from = '$thisuser' ORDER BY id DESC";
				$t = mysqli_query($con, $s) or die("no query");

					

	if(isset($_POST['deletemessages'])) {
			foreach ($_POST['messages'] as $select)
				{


					$delete_query = mysqli_query($con, "UPDATE messages SET deleted=CONCAT(deleted, '$userLoggedIn,') WHERE id='$select'");
			
					$oepnend_query = mysqli_query($con, "UPDATE messages SET opened=CONCAT(opened, '$userLoggedIn,') WHERE id='$select'");

					
			
					}
					header("location:http://localhost/comic/redirectmd.php");
	}


	if(isset($_POST['deletemessage'])) {
		
		           $id = $_POST['messId']; 
		           $delete_query = mysqli_query($con, "UPDATE messages SET deleted=CONCAT(deleted, '$userLoggedIn,') WHERE id='$id'");
		           $open_query = mysqli_query($con, "UPDATE messages SET opened=CONCAT(opened, '$userLoggedIn,') WHERE id='$id'");
		           header("location:http://localhost/comic/redirectmd.php");
	}
         $newmessagesquery = mysqli_query($con,"SELECT * FROM messages WHERE user_to ='$userLoggedIn' AND opened ='no'");
		 $newmessages = mysqli_num_rows($newmessagesquery);



?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
	<title>Messages | KismatComics</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body onload="showInboxtab()">
	<div class="page1">
		 <div id="Profile">
	<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction"><?php echo $user['username'];?>'s messages</h2>

			<img class="profile_pic" src="<?php echo $user['profile_pic']; ?>"><br>
			<a href="#" id="sendmessage" onclick="showwrite()" style="visibility: hidden;">Write Message!</a>
			<a href="#" id="viewinbox"   onclick="showInboxtab()">View Inbox!</a>
			<br>
			<br>

	<div id="tabs" class="container">
			
		
			<a href="#" class="tabs" id="inbox_tab" onclick="showInboxtab()">Inbox</a>
			<a href="#" class="tabs" id="sent_tab" onclick="showsenttab()">Sent</a>
		</div>

	</div>
	
			
	<div id="inboxmessages" class="received"> 
		<p class="notes"></p>
		<form action="messages.php" method="post">
		
			<table class="table">
		<tr><th><input type="submit" class="buttonx" onclick="messagedelete(messId.value)" value="X" name="deletemessages"></th><th>Subject</th><th>From</th><th>Replies</th><th></th></tr>
	<?php
				
					$s=0;
				foreach( $r as $index => $r ) {
					$user_from = $r['user_from'];
					$mpic_query = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user_from '");
					$mpic_array = mysqli_fetch_array($mpic_query);
					$mpic = implode(' ', (array)$mpic_array);
					$id = $r['id'];
					$usernameComma = "," . $userLoggedIn . ",";
					$s++;

					if((strstr($r['opened'], $usernameComma))) {
								$bold='opened';
					} else {
						$bold = 'new';
					}
					 
					
					 $newrepliesquery = mysqli_query($con,"SELECT * FROM message_replies WHERE messages_id ='$id' AND opened=',$user_from,'");
		 			 $newreplies = mysqli_num_rows($newrepliesquery);
		 			 $repliesquery = mysqli_query($con,"SELECT * FROM message_replies WHERE messages_id ='$id'");
		 			 $replies = mysqli_num_rows($repliesquery);

		 			 if ($newreplies > 0) {
		 			 	$boldreply = 'new';
		 			 	
		 			 } else {$boldreply='opened';
		 			 			
		 			}

		 			if((strstr($r['deleted'], $usernameComma))) {
								
					} else { 
					 		if ($s<20) { 
					 			echo '<tr><td><input type="checkbox" value = '. $r['id'].' name="messages[]"></td>';
					echo '<form action="messages.php" method="post"><td><a class="messagelinktw" href="message/' . $r['id'] . ' "><p class=" '. $bold .'">' . $r['subject'] . '</p></a></td>';
					echo '<td><a class="messagelinktw $bold" href="' . $r['user_from'] . ' "><p class="">' . $r['user_from'] . '</p></a></td>' ;
					echo '<input type="hidden" id="messId" name="messId" value=' . $r['id'] . '>';
					echo '<td><a class="messagelinktw" href="message/' . $r['id'] . ' "><p class=" '. $boldreply .'">'. $replies .'</p></a></td>' ;
					echo '<td><input type="submit" class="buttonx"  value="X" name="deletemessage"></td></form>' ;
					echo '</tr>';
					 		} else {


					echo '<tr class="lazys"><td><input type="checkbox" value = '. $r['id'].' name="messages[]"></td>';
					echo '<form action="messages.php" method="post"><td><a class="messagelinktw" href="message/' . $r['id'] . ' "><p class=" '. $bold .'">' . $r['subject'] . '</p></a></td>';
					echo '<td><a class="messagelinktw $bold" href="' . $r['user_from'] . ' "><p class="">' . $r['user_from'] . '</p></a></td>' ;
					echo '<input type="hidden" id="messId" name="messId" value=' . $r['id'] . '>';
					echo '<td><a class="messagelinktw" href="message/' . $r['id'] . ' "><p class=" '. $boldreply .'">'. $replies .'</p></a></td>' ;
					echo '<td><input type="submit" class="buttonx"  value="X" name="deletemessage"></td></form>' ;
					echo '</tr>';}}
					

				 /*	echo '<br><div class="everythingmessage '. $bold .'"><div class="fullmessage"><div class="avatar"><input type="submit" class="button" onclick="messagedelete(messId.value)" value="X" name="deletemessage"><h3><img src='. $mpic.'></br> <a href='.$user_from.'>' . $r['user_from'] . '</h3></a></div><div class="message_body">';
						
						echo '<h3 class="subject">' . $r['subject'] . '</h3>';
						echo '<p>' . $r['body'] .  '</p>';
						echo '<input type="hidden" id="messId" name="messId" value=' . $r['id'] . '>';
						
						echo '<div class="dates"><i><br>Sent on ' . $r['date'] . '</i></div>' ;
						echo '<br></div><input type="submit" onclick="messageflag(messId.value)"class="button flag_button"  value="Reply!" name="abuse">';
						echo '</div></div><br>';
						*/



					
				}

				



				  ?>
				  </table>

				 
				
			</div>
			<div id="sentmessages" class="received"> 
		
		
			
			<table class="table">
		<tr><th><input type="submit" class="buttonx" onclick="messagedelete(messId.value)" value="X" name="deletemessages"></th><th>Subject</th><th>Sent to</th><th>Replies</th><th></th></tr>
	<?php
				$m=0;
					
				foreach( $t as $index => $t ) {
					$user_from = $t['user_from'];
					$mpic_query = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user_from'");
					$mpic_array = mysqli_fetch_array($mpic_query);
					$mpic = implode(' ', (array)$mpic_array);
					$id = $t['id'];
					$usernameComma = "," . $userLoggedIn . ",";
					$user_to = $t['user_to'];
					
					 

					 $newrepliesquery = mysqli_query($con,"SELECT * FROM message_replies WHERE messages_id ='$id' AND opened=',$user_to,'");
		 			 $newreplies = mysqli_num_rows($newrepliesquery);
		 			 $repliesquery = mysqli_query($con,"SELECT * FROM message_replies WHERE messages_id ='$id'");
		 			 $replies = mysqli_num_rows($repliesquery);
		 			 $m++;
		 			 if ($newreplies > 0) {
		 			 	$boldsreply='new';
		 			 	
		 			 } else {

		 			 	$boldsreply = 'opened';
		 			 			
		 			}
		 			 
		 			 	
		 			 			
		 			
					if((strstr($t['deleted'], $usernameComma))) {
								
					} else {

					if ($m<20) { 
						echo '<tr><td><input type="checkbox" value = '. $t['id'].' name="messages[]"></td>';
					echo '<td><form action="messages.php" method="post"><a class="messagelinktw" href="message/' . $t['id'] . ' "><p class="">' . $t['subject'] . '</p></a></td>';
					echo '<input type="hidden" id="messId" name="messId" value=' . $t['id'] . '>';
					echo '<td><a class="messagelinktw" href="' . $t['user_to'] . '"><p class=" ">' . $t['user_to'] . '</p></a></td>' ;
					echo '<td><a class="messagelinktw" href="message/' . $t['id'] . ' "><p class="'. $boldsreply .' ">'. $replies .'</p></a></td>' ;
					echo '<td><input type="submit" class="buttonx"  value="X" name="deletemessage"></td></form>' ;
					echo '</tr>';
					} else {
					 
					echo '<tr class="lazys"><td><input type="checkbox" value = '. $t['id'].' name="messages[]"></td>';
					echo '<td><form action="messages.php" method="post"><a class="messagelinktw" href="message/' . $t['id'] . ' "><p class="">' . $t['subject'] . '</p></a></td>';
					echo '<input type="hidden" id="messId" name="messId" value=' . $t['id'] . '>';
					echo '<td><a class="messagelinktw" href="' . $t['user_to'] . '"><p class=" ">' . $t['user_to'] . '</p></a></td>' ;
					echo '<td><a class="messagelinktw" href="message/' . $t['id'] . ' "><p class="'. $boldsreply .' ">'. $replies .'</p></a></td>' ;
					echo '<td><input type="submit" class="buttonx"  value="X" name="deletemessage"></td></form>' ;
					echo '</tr>';}}
					

				 /*	echo '<br><div class="everythingmessage '. $bold .'"><div class="fullmessage"><div class="avatar"><input type="submit" class="button" onclick="messagedelete(messId.value)" value="X" name="deletemessage"><h3><img src='. $mpic.'></br> <a href='.$user_from.'>' . $r['user_from'] . '</h3></a></div><div class="message_body">';
						
						echo '<h3 class="subject">' . $r['subject'] . '</h3>';
						echo '<p>' . $r['body'] .  '</p>';
						echo '<input type="hidden" id="messId" name="messId" value=' . $r['id'] . '>';
						
						echo '<div class="dates"><i><br>Sent on ' . $r['date'] . '</i></div>' ;
						echo '<br></div><input type="submit" onclick="messageflag(messId.value)"class="button flag_button"  value="Reply!" name="abuse">';
						echo '</div></div><br>';
						*/



					
				}

				



				  ?>
				  </table>

				 
				</form>
				
			</div>
								<br>
			<div id="messagewrite" class="messagereply"> 

				<form  name="messagesend"  action="messages.php" method="post">
					<input type="text" name="Send_to" placeholder="Send to" required>
					</br>
					<input type="text" name="subject" placeholder="Subject" required>
				</br>
					<textarea name="body" placeholder="Reply" required></textarea>
				</br>

					<input type="submit" name="reply_submit" class="button" value="Send Message!">
				




				</form>

			</div>
</div>
</div>
</body>
</html>