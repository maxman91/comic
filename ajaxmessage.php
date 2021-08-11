<?php
include("includes/header.php"); 
$q = strval($_GET['q']);


$con = mysqli_connect("localhost", "root", "", "comic");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");

$sql="UPDATE messages SET deleted='yes' WHERE id =  '$q' ";
$result = mysqli_query($con,$sql);


 $thisuser = $user['username'];
				$q = "SELECT id , body , user_to , user_from , date , opened, flaged , deleted , subject FROM messages WHERE (user_to = '$thisuser' OR user_from = '$thisuser') AND deleted='no'";
				$r = mysqli_query($con, $q) or die("no query");
					
				foreach( $r as $index => $r ) {
					$user_from = $r['user_from'];
					$mpic_query = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user_from '");
					$mpic_array = mysqli_fetch_array($mpic_query);
					$mpic = implode(' ', (array)$mpic_array);
					

					

						echo '<br><div class="everythingmessage"><div class="fullmessage"><div class="avatar"><input type="submit" class="button" onclick="messagedelete(messId.value)" value="X" name="deletemessage"><h3><img src='. $mpic.'></br> <a href='.$user_from.'>' . $r['user_from'] . '</h3></a></div><div class="message_body">';
						
						echo '<a class="messagelink"><h3 class="subject">' . $r['subject'] . '</h3></a>';
						echo '<p>' . $r['body'] .  '</p>';
						echo '<input type="hidden" id="messId" name="messId" value=' . $r['id'] . '>';
						
						echo '<div class="dates"><i><br>Sent on ' . $r['date'] . '</i></div>' ;
						echo '<br></div><input type="submit" onclick="messageflag(messId.value)"class="button flag_button"  value="Flag!" name="abuse">';
						echo '</div></div><br>';





}





mysqli_close($con);
?>