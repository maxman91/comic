<?php  
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>





<html>
<head>
	<title>No Page | KismatComics</title>
	<script src="assets/js/register.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
</head>

		<?php  

	if(isset($_POST['register_button'])) {
		echo '<body onload="hidefirst()">

		';
	} 
	else 
		{
		echo '<body onload="hidesecond()">

		';
	} 


	?>

	<div id="first">
		<form action="register.php" method="POST">
			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
			<h2 class="instruction">Page does not exist</h2>
			<br>
			<h3>Sorry this page has either been deleted or has never existed.</h3>
						<a href="index.php"><h3>Return home</h3></a>
			
	    </form>
    </div>

	 
</body>


