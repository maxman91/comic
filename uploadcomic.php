<?php  
require 'config/config.php';
if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
	$error_array = array(); 
}
else {
	header("Location: register.php");
}

if(isset($_POST['upload_button'])){
 	
 
$title = $_POST['upload_title'];
$username = $userLoggedIn;
$description = $_POST['upload_description'];

 $imagesql = "";


$count=0;
           
foreach ($_FILES['upload_image']['name'] as $image) 
{
 	$temp_name  = $_FILES['upload_image']['tmp_name'][$count];
 	$count=$count + 1;
 	$targetDir = "assets/images/posts/";
    $image = $targetDir . uniqid() . basename($image);
    move_uploaded_file($temp_name, $image);
    $imagesql .=$image .',';
  
}


 




$date = date("Y-m-d H:i:s");

					$author = metaphone($username);
					$heading = metaphone($title);
					$bodies = metaphone($bodies);

					$sounds = $author . $heading . $bodies;


$query = mysqli_query($con, "INSERT INTO uploads VALUES ('', '$username', '$title', '$description', '$imagesql', '$date', '0', '0', '0','no',',','0','$sounds')");

		

header("location:http://localhost/comic/$username");
}
?>





<html>
<head>
	<title>Upload a Comic! | KismatComics</title>
	<script src="assets/js/uploadpic.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/settings.css">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>
<div class="page">
<div class="header">
	
   		
   			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
	   		<h2 class="instruction">Upload a Comic!</h2>
	   		<br>
	</div>  		
	<form action="uploadcomic.php" method="POST" enctype="multipart/form-data">
	   		<input type="text" name="upload_title" placeholder="Title"  required>
	   		<br>
	   		<?php if(in_array("Your title must be between 2 and 25 characters<br>", $error_array)) echo "Your title must be between 2 and 25 characters<br>"; ?>
	   	    
	   		<label for="upload_image">Upload image(s)</label>
	   	    <input type="file" style="width:200px; height:30px; "accept="image/*" size="60" id="upload_image" name = "upload_image[]" placeholder="Upload images"  multiple required>
				
					<br>


	   		<textarea type="text" rows="5" name="upload_description" placeholder="Description" required></textarea>
	   		
					<br>
					
			

	   		<input type="submit" name="upload_button" value="Submit">
	   		
			
			
		</form> 
	
	</div>
</body>


