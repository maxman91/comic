<?php 
    include("includes/header.php");
  $upload = mysqli_query($con, "SELECT * FROM UPLOADS WHERE deleted='no' ORDER BY views + (comments * 2) + (likes * 3) 

  - DATEDIFF(CURDATE(),date)


  	DESC ");
	?>


<!DOCTYPE html>
<html>
<head>
	<meta name="description" content="View comic related artwork online.">
	<script src="assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
	<title>KismatComics</title>
	<link rel="canonical" href="http://localhost/comic/"/>
</head>
<body>
	 <div class="page">
		<div class="header">
			<br>
			<h2 class="logo">KComics</h2>
			
			
			
		<?php 
			if (isset($user)) {
				echo "<a Rel='nofollow' href='".$userLoggedIn."'><h2 class='instruction'>Your Profile</h2></a>";

				echo "<a Rel='nofollow' href='logout.php'><h2 class='instruction'>LogOut</h2></a>";


			} else {
				echo "<a Rel='nofollow' href='register.php'><h2 class='instruction'>LogIn</h2></a>";
			}

?>
			<br>
<form  class="form_search" action="search.php">
  <input type="text" id="search" name="search" placeholder="Search">
  
    <button type="submit"><i>Go!</i></button>
  
</form>
			</div>
			

		<?php  

			$p=0;
				foreach ($upload as $key => $upload) {
					$string = $upload['image'];
					$p++;
					$arr = explode(",", $string, 2);
					$image = $arr[0];
					$postid = $upload['id'];
					$title = $upload['title'];

					


					

					
					if ($p<9) {
						echo '<a href="comic/'.$postid.'"><img alt="'.$title.'" class="thumbnailpic" src="'.$image.'"></a>';
					} else {
					echo '<a class="lazys" href="comic/'.$postid.'"><img alt="'.$title.'" class="lazy" data-src="'.$image.'"></a>';}




				}



			?>
		</div>
		
	

</body>
</html>