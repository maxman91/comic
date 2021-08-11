
<?php 
include("includes/header.php");
if(isset($_GET['comic_id'])) {
	
	$postid = $_GET['comic_id'];
	$post_details_query = mysqli_query($con, "SELECT * FROM uploads WHERE id='$postid' AND deleted='no'");
	$post_array = mysqli_fetch_array($post_details_query);
	$username = $post_array['username'];

	$realid = $post_array['id'];

	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
	$user_array = mysqli_fetch_array($user_details_query);

	if(isset($userLoggedIn)) {
	$user_loggedin_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$loggedin_array = mysqli_fetch_array($user_loggedin_query);}

	$num_pics = (substr_count($post_array['image'], ","));

  	$q = "SELECT id , post_id, body , user_from , date , opened, flaged , deleted FROM comments WHERE post_id = $postid AND deleted='no'";
	$r = mysqli_query($con, $q);


	$co = mysqli_num_rows($r);

	$views = $post_array['views'];

	$views++;

	$query = mysqli_query($con, "UPDATE uploads SET views='$views' WHERE id='$postid'");

}

if (empty($post_array)) {
    header("location:http://localhost/comic/nopage.php");
}


if (!empty($userLoggedIn)) {
 $action = $_GET['comic_id'];
} else {
		
	$action = '../register.php';
}



$image = preg_replace('/[ ,]+/', '', trim($post_array['image']));

if(isset($_POST['like'])) {
	$total_likes = $post_array['likes'];
	$total_likes++;
	$post_id = $post_array['id'];
	$user_from = $userLoggedIn;
	$query = mysqli_query($con, "UPDATE uploads SET likes='$total_likes' WHERE id='$post_id'");
	$query2 = mysqli_query($con, "UPDATE users SET favorites=CONCAT(favorites, '$post_id,') WHERE username='$userLoggedIn'");
	header("location:http://localhost/comic/redirect.php?postid=$postid");

}

if(isset($_POST['dislike'])) {
	$total_likes = $post_array['likes'];
	$total_likes--;
	$post_id = $post_array['id'];
	$user_from = $user['username'];
	$query = mysqli_query($con, "UPDATE uploads SET likes='$total_likes' WHERE id='$post_id'");
	$query2 = mysqli_query($con, "UPDATE users SET favorites=CONCAT(favorites, '$post_id,') WHERE username='$userLoggedIn'");
	$new_friend_array = str_replace($post_id . ",", "", $loggedin_array['favorites']);
	$remove_friend = mysqli_query($con, "UPDATE users SET favorites='$new_friend_array' WHERE username='$userLoggedIn'");
	header("location:http://localhost/comic/redirect.php?postid=$postid");

}

if(isset($_POST['flag'])) {
	$total_flags = $post_array['flags'];
	$total_flags++;
	$post_id = $post_array['id'];
	$user_from = $user['username'];
	$query = mysqli_query($con, "UPDATE uploads SET flags='$total_flags' WHERE id='$post_id'");
	$query2 = mysqli_query($con, "UPDATE uploads SET flag=CONCAT(flag, '$user_from,') WHERE id='$post_id'");
	header("location:http://localhost/comic/redirect.php?postid=$postid");

}

if(isset($_POST['unflag'])) {
	$total_flags = $post_array['flags'];
	$total_flags--;
	$post_id = $post_array['id'];
	$user_from = $user['username'];
	$query = mysqli_query($con, "UPDATE uploads SET flags='$flags' WHERE id='$post_id'");
	$query2 = mysqli_query($con, "UPDATE uploads SET flag=CONCAT(flag, '$user_from,') WHERE id='$post_id'");
	$new_friend_array = str_replace($user['username'] . ",", "", $post_array['flag']);
	$remove_friend = mysqli_query($con, "UPDATE uploads SET flag='$new_friend_array' WHERE id='$post_id'");
	header("location:http://localhost/comic/redirect.php?postid=$postid");

}


if(isset($_POST['post_comment'])) {
					$date = date("Y-m-d H:i:s");
					$body = $_POST['body'];
		           $query = mysqli_query($con, "INSERT INTO comments VALUES ('', '$postid', '$userLoggedIn', '$date', 'no',',','no','$body')");
		           $comments = $post_array['comments'];

		           $comments++;
		           
		           $query = mysqli_query($con, "UPDATE uploads SET comments=$comments WHERE id='$postid'");

		           header("location:http://localhost/comic/redirect.php?postid=$postid");
	}

if(isset($_POST['flag_comment'])) {
	$commentId = $_POST['commentId']; 
	
  if($userLoggedIn==$username){
  	
  	$sql="UPDATE comments SET deleted='yes' WHERE id =  '$commentId' ";
    $result = mysqli_query($con,$sql);

    $query2 = mysqli_query($con, "UPDATE comments SET flaged=CONCAT(flaged, '$userLoggedIn,') WHERE id='$commentId'");

} else {
	$query2 = mysqli_query($con, "UPDATE comments SET flaged=CONCAT(flaged, '$userLoggedIn,') WHERE id='$commentId'");
}
header("location:http://localhost/comic/redirect.php?postid=$postid");
}

if(isset($_POST['unflag_comment'])) {
	$commentId = $_POST['commentId'];
	$r_query = mysqli_query($con, "SELECT * FROM comments WHERE id='$commentId'");
	$r = mysqli_fetch_array($r_query);
	$query2 = mysqli_query($con, "UPDATE comments SET flaged=CONCAT(flaged, '$userLoggedIn,') WHERE id='$commentId'");
	$new_friend_array = str_replace($userLoggedIn .",","", $r['flaged']);
	$remove_friend = mysqli_query($con, "UPDATE comments SET flaged='$new_friend_array' WHERE id='$commentId'");
	header("location:http://localhost/comic/redirect.php?postid=$postid"); }

if(isset($_POST['commenteditsubmit'])){
		$id = $_POST['commentid'];
		$body = $_POST['bodyedit'];
		$date = date("Y-m-d H:i:s");
	 
		$sql="UPDATE comments SET body='$body' WHERE id =  '$id' ";
        $result = mysqli_query($con,$sql);
        $sql1="UPDATE comments SET date='$date' WHERE id =  '$id' ";
        $result = mysqli_query($con,$sql1);
        header("location:http://localhost/comic/redirect.php?postid=$postid");
}



if(isset($_POST['commentquotesubmit'])){
		
		$body = $_POST['bodyquote'];
		$date = date("Y-m-d H:i:s");
	 	
	 	
		$query = mysqli_query($con, "INSERT INTO comments VALUES ('', '$postid', '$userLoggedIn', '$date', 'no',',','no','$body')");
		
        header("location:http://localhost/comic/redirect.php?postid=$postid");
}



if(isset($_POST['Delete_Post'])){
	$sql="UPDATE uploads SET deleted='yes' WHERE id =  '$postid' ";
    $result = mysqli_query($con,$sql);
    header("location:http://localhost/comic/redirect.php?postid=$postid");
}



 ?>

<!DOCTYPE html>
<html>
<head>
	<meta name="description" content="<?php echo $post_array['description'];?>">
	<script src="../assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets/css/post.css">
	<title><?php echo $post_array['title'];?> | KismatComics</title>
	<link rel="canonical" href="https://http://localhost/comic/comic/<?php echo $realid; ?>"/>
</head>
<body>
	<div class="page">
		<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<br>
			<h2 class="instruction">"<?php echo $post_array['title'];?>"</h2>
			
			
			<br>

			</div>

			<?php
				if ($num_pics > 1){
					$pic_array = $post_array['image'];
					$pics = explode( ',', $pic_array);
					$pic = array_filter($pics);
					$p=0;
				
					
				
							foreach($pic as $key => $value):
							if ($value == "assets/images/posts/"){ continue;}
							
							$p++;
							if ($p<6) {
								echo '<br><a href="../'.$value.'"><img src="../'.$value.'"alt="'.$post_array['title'].'"></a>';
							}
								else {
							echo '<br><a class="lazys" href="../'.$value.'"><img class="lazy" data-src="../'.$value.'"alt="'.$post_array['title'].'"></a>';}

							endforeach;
				} else {
					 echo'<a href="../'.$image.'"><img src="../'.$image.'" alt="'.$post_array['title'].'" ></a>';
				}

			 ?>
	<br>
	
	<p class="likes"><b><?php echo $post_array['likes'];?> Likes</b></p>
	<div class="description">
		
		<a href="../<?php echo $post_array['username'];?>" Rel="nofollow"><img class="profile_pic" src="../<?php echo $user_array['profile_pic']; ?>"></a>

		<h3 class="titles"><?php echo $post_array['title'];?></h3>
	
	
		<h4 class="titles">by <a Rel="nofollow" href="../<?php echo $post_array['username'];?>"><?php echo $post_array['username'];?></a></h4>
       <form action="<?php echo $post_array['id'];?>#" method="POST">
		<?php 
		if (isset($user)) {$usernameComma = "," . $postid . ",";
					if((strstr($loggedin_array['favorites'], $usernameComma))) {
								echo '<input type="submit" class="button" name="dislike" value="dislike">';
					} else{
						echo '<input type="submit" class="button" name="like" value="like">';
					}
					}
				else {
					echo '<input type="button" class="button" onclick="linkregisterpage1()" value="like">';
				}
	
		?>
             
		<br>
	</form>


	<form action='../flag.php' method='post'>
		<p><?php echo $post_array['description'];?></p>
		<br>
		<i>posted on <?php echo $post_array['date'];?> </i>



		<?php 

		if (isset($user)) {$usernameComma = "," . $user['username'] . ",";
		if((strstr($post_array['flag'], $usernameComma))) {
			echo "<input type='hidden' name='flagpost' value=";
			echo $postid;
			echo '>';
			echo '<input type="submit" class="flag" value="unFlag" name="unflag">';
		}else{
			if ($post_array['username'] == $userLoggedIn) {
				echo '<input type="submit" class="flag" value="Delete Post" name="Delete_Post" ';
			} else {
	    
		
		echo "<input type='hidden' name='flagpost' value=";
		echo $postid;
		echo '>';
	    echo '<input type="submit" class="flag" name="flag" value="flag">';
	    
		}}} else {
		
		echo "<input type='hidden' name='flagpost' value=";
		echo $postid;
		echo '>';
	    echo '<input type="submit" class="flag" name="flag" value="flag">';
	    

		}
	
		?>
	</div>

</form>

	</div>
	</div>

	<div class="page">
		  <h2 class="instructions"> <?php echo $co;?> Comments</h2>

		  <form class="messagereply" name="message"  action="<?php echo $action;?>#" method="post">
					
				</br>
					<textarea name="body" placeholder="Add a comment!" required></textarea>
				</br>

				 
					

 						
					<input type="submit" name="post_comment" class="button2" value="Post Comment!">
				

				
			



				</form>
				<br>


				<?php
				
				$c=0;
					
				foreach( $r as $index => $r ) {
					$user_from = $r['user_from'];
					$pmpic_query = mysqli_query($con, "SELECT profile_pic FROM users WHERE username='$user_from'");
					$pmpic_array = mysqli_fetch_array($pmpic_query);
					$pmpic = implode(' ', (array)$pmpic_array);
					
					$c++;
			       	
			       	if ($c<5) {
					echo '<div class="comment">';
					echo '<a Rel="nofollow" href=../'.$user_from.'>';
					echo '<img class="profile_pic" src=../'. $pmpic.'></a>';
					echo '<h3 class="titles">Comment</h3>';
					echo '<h4 class="titles">by <a Rel="nofollow" href=../'.$user_from.'>' . $r['user_from'] . '</a></h3>';
					
					if (isset($_SESSION['username'])) {
								if($userLoggedIn==$user_from){
									echo '<form method="POST" action="../edit.php"><input type="submit" class="commentbutton" name="editcomment" value="Edit">';

								} else {
									$usernameComma = "," . $userLoggedIn . ",";
									
									if((strstr($r['flaged'], $userLoggedIn))) {
									echo '<form method="POST" action="'.$post_array['id'].'"><br><input type="submit" class="flag" value="unflag" name="unflag_comment"';
											}else {

									echo '<form method="POST" action="'.$post_array['id'].'"><br><input type="submit" class="commentbutton" name=flag_comment value="Flag">';

								}}
                                     }
                              else {
	                           echo '<br><form method="POST" action="../register.php"><input type="submit" class="commentbutton" value="Flag">';
                                     }


					echo  '<br>';
					echo '<input type="hidden" id="messId" name="postid" value=' . $r['post_id'] . '>';
					echo '<input type="hidden" id="messId" name="commentId" value=' . $r['id'] . '>';
					echo '</form>';
					echo '<p>'.$r['body'].'</p>';
					echo '<i>posted on '.$r['date'].' </i><br>';
					 echo '<form method="POST" action="';
			        if (isset($_SESSION['username'])) {
								echo '../quote.php';
                                     }
                              else {
	                           echo '../register.php';
                                     }
					echo  '"><input type="submit" name="quotecomment" class="quote" value="quote">';
					echo '<input type="hidden" id="messId" name="postid" value=' . $r['post_id'] . '>';
					echo '<input type="hidden" id="messId" name="commentId" value=' . $r['id'] . '>';
					echo '</form>';
					echo '</div>';
					
					echo '<br>';} else {
						echo '<div class="comment lazys">';
					echo '<a Rel="nofollow" href=../'.$user_from.'>';
					echo '<img class="profile_pic" src=../'. $pmpic.'></a>';
					echo '<h3 class="titles">Comment</h3>';
					echo '<h4 class="titles">by <a Rel="nofollow" href=../'.$user_from.'>' . $r['user_from'] . '</a></h3>';
					
					if (isset($_SESSION['username'])) {
								if($userLoggedIn==$user_from){
									echo '<form method="POST" action="../edit.php"><input type="submit" class="commentbutton" name="editcomment" value="Edit">';

								} else {
									$usernameComma = "," . $userLoggedIn . ",";
									
									if((strstr($r['flaged'], $userLoggedIn))) {
									echo '<form method="POST" action="'.$post_array['id'].'"><br><input type="submit" class="flag" value="unflag" name="unflag_comment"';
											}else {

									echo '<form method="POST" action="'.$post_array['id'].'"><br><input type="submit" class="commentbutton" name=flag_comment value="Flag">';

								}}
                                     }
                              else {
	                           echo '<br><form method="POST" action="../register.php"><input type="submit" class="commentbutton" value="Flag">';
                                     }


					echo  '<br>';
					echo '<input type="hidden" id="messId" name="postid" value=' . $r['post_id'] . '>';
					echo '<input type="hidden" id="messId" name="commentId" value=' . $r['id'] . '>';
					echo '</form>';
					echo '<p>'.$r['body'].'</p>';
					echo '<i>posted on '.$r['date'].' </i><br>';
					 echo '<form method="POST" action="';
			        if (isset($_SESSION['username'])) {
								echo '../quote.php';
                                     }
                              else {
	                           echo '../register.php';
                                     }
					echo  '"><input type="submit" name="quotecomment" class="quote" value="quote">';
					echo '<input type="hidden" id="messId" name="postid" value=' . $r['post_id'] . '>';
					echo '<input type="hidden" id="messId" name="commentId" value=' . $r['id'] . '>';
					echo '</form>';
					echo '</div>';
					
					echo '<br>';
					}
						
						



					
				}

				



				  ?>

				  
	</div>
</html>

