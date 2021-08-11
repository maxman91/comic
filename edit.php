<?php 
include("includes/header.php"); 
if(isset($_POST['editcomment']))  {
		     		$commentid = $_POST['commentId'];
            		$comment_details_query = mysqli_query($con, "SELECT * FROM comments WHERE id='$commentid'");
					$comment_array = mysqli_fetch_array($comment_details_query);

					

		     }


		
	else {
		header("Location: register.php");
	}

	$messagelink = $_POST['postid'];

	

?>


<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
	<title>Edit Comment | KismatComics</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
	<div class="page1">
	<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction">Edit Comment!</h2>
	</div>

	<br>														
              <form class="messagereply" name="messageedit"  action="comic/<?php echo $messagelink;?>#" method="post">
					
				</br>
					<textarea name="bodyedit" required><?php echo $comment_array['body'];?></textarea>
				</br>
					<input type="hidden" id="messId" name="commentid" value=<?php echo $commentid;?>>
					
					<input type="submit" name="commenteditsubmit" class="button" value="Edit Post!">
				




				</form>

</body>
</html>