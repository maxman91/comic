
<?php 

include("includes/header.php");



if(isset($_GET['search'])) { 

$search = $_GET['search'];

   $location = metaphone($search);

  $upload = mysqli_query($con, "SELECT * FROM UPLOADS WHERE sound like '%$location%' AND deleted='no' ORDER BY views + (comments * 2) + (likes * 3) 

  - DATEDIFF(CURDATE(),date)


  	DESC ");

} else {


 





 $upload = mysqli_query($con, "SELECT * FROM UPLOADS WHERE deleted='no' ORDER BY views + (comments * 2) + (likes * 3) 

  - DATEDIFF(CURDATE(),date)


  	DESC ");



}















?>

<!DOCTYPE html>
<html>
<head>

	<script src="assets/js/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/profile.css">
	<title>Search | KismatComics</title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<body>
	 <div class="page">
		<div class="header">
			<br>
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>

			<?php 
			if (isset($user)) {
				echo "<a Rel='nofollow' href='".$userLoggedIn."'><h2 class='instruction'>Your Profile</h2></a>";

				echo "<a Rel='nofollow' href='logout.php'><h2 class='instruction'>LogOut</h2></a>";
			} else {
				echo "<a href='register.php'><h2 class='instruction'>LogIn</h2></a>";
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
					
					if ($p<9) {
						echo '<a href="comic/'.$postid.'"><img class="thumbnailpic" src="'.$image.'"></a>';
					} else {
					echo '<a class="lazys" href="comic/'.$postid.'"><img class="lazy" data-src="'.$image.'"></a>';}

				}



			?>
</div>
		
		
	

</body>
</html