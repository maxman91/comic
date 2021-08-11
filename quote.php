<?php 
include("includes/header.php"); 

if(isset($_POST['quotecomment']))  {

		     		$commentid = $_POST['commentId'];
            		$comment_details_query = mysqli_query($con, "SELECT * FROM comments WHERE id='$commentid'");
					$comment_array = mysqli_fetch_array($comment_details_query);

					

		     }


		
	else {
		header("Location: register.php");
	}

	$messagelink = $_POST['postid'];
    $string = $comment_array['body'];
   	$out=preg_replace("~<blockquote(.*?)>(.*)</blockquote>~si","",' '.$string.' ');

?>


<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
	<title>Quote | KismatComics</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
	<div class="page1">
	<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction">Quote</h2>
	</div>

	<br>														
              <form class="messagereply" name="messageedit"  action="comic/<?php echo $messagelink;?>#" method="post">
					
				</br>
					<textarea name="bodyquote" required><blockquote><?php echo $out;?>
						<cite><a href="../<?php echo $comment_array['user_from'];?>"><?php echo $comment_array['user_from'];?></a></cite></blockquote>

					</textarea>
				</br>
					<input type="hidden" id="messId" name="commentid" value=<?php echo $commentid;?>>
					
					<input type="submit" name="commentquotesubmit" class="button" value="Quote!">
				




				</form>

</body>
</html>