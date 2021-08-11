<?php 
include("includes/header.php");
if(isset($_GET['message_id'])) {
	
	$messageid = $_GET['message_id'];
	$message_details_query = mysqli_query($con, "SELECT * FROM messages WHERE id='$messageid'");
	$message_array = mysqli_fetch_array($message_details_query);

	$q = "SELECT id , body , user_from , date , opened, flaged , deleted , subject , user_to FROM message_replies WHERE messages_id = '$messageid'";
	$r = mysqli_query($con, $q);


		} 

if (empty($message_array)) {
    header("location:http://localhost/comic/nopage.php");
}	


$usernameComma = "," . $userLoggedIn . ",";
if((strstr($message_array['deleted'], $usernameComma))) {
			header("location:http://localhost/comic/nopage.php");
					}


if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
	$usernameComma = "," . $userLoggedIn . ",";

	if((strstr($message_array['opened'], $usernameComma))) {
								
					} else {

	$opened="UPDATE messages SET opened=CONCAT(opened, '$userLoggedIn,') WHERE id =  '$messageid' ";
    $result = mysqli_query($con,$opened);
    }


    


   





} else {
	header("Location: ../register.php");
}

if ($message_array['deleted'] == 'yes') {
	header("Location: ../register.php");
}

if(isset($_POST['bodyeditsubmit'])){
		$id = $_POST['messId'];
		$body = $_POST['bodyedit'];
		$isoriginal = $_POST['original'];
		$date = date("Y-m-d H:i:s");
	if ($isoriginal == 'no') {
		
		$sql="UPDATE message_replies SET body='$body' WHERE id =  '$id' ";
        $result = mysqli_query($con,$sql);
        $sql1="UPDATE message_replies SET date='$date' WHERE id =  '$id' ";
        $result = mysqli_query($con,$sql1);

	} else {
		$sql="UPDATE messages SET body='$body' WHERE id =  '$id' ";
        $result = mysqli_query($con,$sql);
        $sql1="UPDATE messages SET date='$date' WHERE id =  '$id' ";
        $result = mysqli_query($con,$sql1);
	}


	header("location:http://localhost/comic/redirectmessage.php?messageid=$messageid");
}




if(isset($_POST['reply_submit'])){
	$date = date("Y-m-d H:i:s");
	$body = $_POST['body'];
	$subject = 're:'.$message_array['subject'];
    $userLoggedIn = $user['username'];
    

    if ($userLoggedIn != $message_array['user_to']) {
    	$user_tomr = $message_array['user_to'];
    } else {
    	$user_tomr = $message_array['user_from'];
    }

    if ($message_array['deleted'] = ',$user_tomr,') {
    	if ($message_array['flaged'] = 'no') {
    		$sql="UPDATE messages SET deleted=',' WHERE id =  '$messageid' ";
            $result = mysqli_query($con,$sql);
    	}
    }

    if ($message_array['deleted'] = ',$user_tomr,') {
    	if ($message_array['flaged'] = 'no') {
    		$sql="UPDATE messages SET deleted=',' WHERE id =  '$messageid' ";
            $result = mysqli_query($con,$sql);
    	}
    }
											
	$query = mysqli_query($con, "INSERT INTO message_replies VALUES('', '$messageid' , '$userLoggedIn' , '$body' , '$date' , ',$userLoggedIn,' , 'no' , ',' , '$subject' , '$user_tomr')");

	header("location:http://localhost/comic/redirectmessage.php?messageid=$messageid");

	 

}

if(isset($_POST['abuse'])){
     $q = $_POST['messId']; 


	$delete_query = mysqli_query($con, "UPDATE messages SET deleted=CONCAT(deleted, '$userLoggedIn,') WHERE id='$q'");

    $sql2="UPDATE messages SET flaged='yes' WHERE id =  '$q' ";
    $result2 = mysqli_query($con,$sql2);
    
    $sql3="UPDATE messages SET opened='yes' WHERE id =  '$q' ";
    $result3 = mysqli_query($con,$sql3);


	header("location:http://localhost/comic/redirectmessage.php?messageid=$messageid");

	 

}

if(isset($_POST['abuser'])){
     $q = $_POST['messId']; 
     $r = $_POST['messIdmain']; 

     $flagreply = mysqli_query($con, "UPDATE message_replies SET flaged='yes' WHERE id='$q'");
	


	$delete_query = mysqli_query($con, "UPDATE messages SET deleted=CONCAT(deleted, '$userLoggedIn,') WHERE id='$r'");

   
    
    
	header("location:http://localhost/comic/redirectmessage.php?messageid=$messageid");

	 

}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Message | KismatComics</title>
	<script src="../assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets/css/post.css">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
	<div class="page">
	<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction">Message: <?php echo $message_array['subject'];?></h2>
	</div>
<?php
if($user['username'] == $message_array['user_to'] Or $user['username'] == $message_array['user_from']) {
						 $user_from = $message_array['user_from'];
						$mpic_query = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user_from'");
						$mpic_array = mysqli_fetch_array($mpic_query);
						$mpic = implode(' ', (array)$mpic_array);

						 	
							
					    

					     

						echo '<br><div class="comment"><a href=../'.$user_from.'><img class="profile_pic" src=../'.$mpic.'></a>';
						echo '<h3 class="titles">'. $message_array['subject'] . '</h3>';
					    echo '<h4 class="titles">by <a href=../'.$user_from.'>' .$user_from. '</a></h3>';
						if($userLoggedIn==$user_from){
							
							echo '<form action="../editmessage.php" method="post"><input type="submit" onclick="edit(messId.value)"class="commentbutton"  value="Edit" name="Edit">';
							
							echo '<input type="hidden" id="messId" name="messIdmain" value=' . $message_array['id'] . '></form>';
						} else {
						echo '<form action="'.$messageid.'" method="post"><input type="submit" onclick="edit(messId.value)"class="commentbutton"  value="Flag" name="abuse">';}
						echo '<input type="hidden" id="messId" name="messId" value=' . $message_array['id'] . '>';
						echo '<br></form>';
						echo '<p>' . $message_array['body'] .  '</p>';
						
						echo '<i><br>Sent on ' . $message_array['date'] . '</i><br>';
						
						
						echo '</div><br>';


						
} else {
	header("Location: ../register.php");
} ?>

							<?php
				
								$c=0;
				foreach( $r as $index => $r ) {
					$user_from = $r['user_from'];
					$pmpic_query = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user_from '");
					$pmpic_array = mysqli_fetch_array($pmpic_query);
					$pmpic = implode(' ', (array)$pmpic_array);
					$c++;
					if((strstr($r['opened'], $usernameComma))) {
								
					} else {

	 				$opened1="UPDATE message_replies SET opened=CONCAT(opened, '$userLoggedIn,') WHERE messages_id =  '$messageid' ";
   					 $result = mysqli_query($con,$opened1);
    					}
					
						if ($c<10) {
						echo '<br><div class="comment"><a href=../'.$user_from.'><img class="profile_pic" src=../'. $pmpic.'></a>';
						echo '<h3 class="titles">'. $r['subject'] . '</h3>';
					    echo '<h4 class="titles">by <a href=../'.$user_from.'>' .$user_from. '</a></h3>';}
					    else { echo '<br><div class="comment lazys"><a href=../'.$user_from.'><img class="profile_pic" src=../'. $pmpic.'></a>';
						echo '<h3 class="titles">'. $r['subject'] . '</h3>';
					    echo '<h4 class="titles">by <a href=../'.$user_from.'>' .$user_from. '</a></h3>';}
						
						
						
						
						if($userLoggedIn==$user_from){
							

							echo '<form action="../editmessage.php" method="post"><input type="submit" onclick="edit(messId.value)"class="button flag_button"  value="Edit" name="Edit">';
							echo '<input type="hidden" id="messId" name="messId" value=' . $r['id'] . '>';
							echo '<input type="hidden" id="messId" name="messIdmain" value=' . $message_array['id'] . '></form>';
						} else {
						echo '<form action="'.$messageid.'" method="post"><input type="submit" onclick="flag(messId.value)"class="button flag_button"  value="Flag" name="abuser">';}
						echo '<input type="hidden" id="messId" name="messId" value=' . $r['id'] . '>';
						echo '<input type="hidden" id="messId" name="messIdmain" value=' . $message_array['id'] . '>';

						
						echo '</form><br>';

						echo '<p>' . $r['body'] .  '</p>';

						echo '<i><br>Sent on ' . $r['date'] . '</i></div><br>' ;
						



					
				}

				



				  ?>
            






 <br>														
              <form class="messagereply" name="message"  action="<?php echo $messageid;?>#" method="post">
					
				</br>
					<textarea name="body" placeholder="Reply" required></textarea>
				</br>

					<input type="submit" name="reply_submit" class="button" value="Send Reply!">
				




				</form>


</body>
</html>