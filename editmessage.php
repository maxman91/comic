<?php 
include("includes/header.php"); 
if(isset($_POST['messIdmain'])) {
		
            if(isset($_POST['messId'])) {
	
                $messageid = $_POST['messId'];
            	$message_details_query = mysqli_query($con, "SELECT * FROM message_replies WHERE id='$messageid'");
				$message_array = mysqli_fetch_array($message_details_query);

				$isoriginal ="no";
				
			
		} 

		     else {
		     		$messageid = $_POST['messIdmain'];
            		$message_details_query = mysqli_query($con, "SELECT * FROM messages WHERE id='$messageid'");
					$message_array = mysqli_fetch_array($message_details_query);

					$isoriginal ="yes";

		     }


		}   
	else {
		header("Location: register.php");
	}

	$messagelink = $_POST['messIdmain'];

?>


<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
	<title>Edit Message! | KismatComics</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
	<div class="page1">
	<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction"><?php echo $message_array['subject'];?></h2>
	</div>

	<br>														
              <form class="messagereply" name="messageedit"  action="message/<?php echo $messagelink;?>#" method="post">
					
				</br>
					<textarea name="bodyedit" required><?php echo $message_array['body'];?></textarea>
				</br>
					<input type="hidden" id="messId" name="messId" value=<?php echo $messageid;?>>
					<input type="hidden" id="messId" name="original" value=<?php echo $isoriginal;?>>
					<input type="submit" name="bodyeditsubmit" class="button" value="Edit Post!">
				




				</form>

</body>
</html>