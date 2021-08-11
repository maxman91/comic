<?php  
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>





<html>
<head>
	<title>Login | KismatComics</title>
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
			<h2 class="instruction">Login</h2>
			<br>
			<input type="text" placeholder="Username or Email" name="log_username" value="<?php 
					if(isset($_SESSION['log_username'])) {
						echo $_SESSION['log_username'];
					} 
					?>" required>
			<br>
			<input type="password" name="log_password" placeholder="Password" required>
			<br>
			<div class="error">
			<?php if(in_array("Username or password was incorrect<br>", $error_array)) echo  "Username/email or password was incorrect.<br>"; 
			elseif (in_array("Account has not been activated.Another confirmation email has been sent to your address.<br>", $error_array)) 
	   			echo "<br><span>Account has not been activated. <br>Another confirmation email has been <br>sent to your address.</span><br>";
			?>
			<a href="#" id="signup" class="signup" onclick="hidefirst()">Register here!</a>
			<input type="submit" name="login_button" value="Login">
			<br>

			<?php 
			$forgot = 'forgot.php';

			if(in_array("Username or password was incorrect<br>", $error_array)) echo  "<a href='".$forgot."'>Forgot Password?</a>";
			?>
			

		    </div>
	    </form>
    </div>

	<div id="second">
   		<form action="register.php" method="POST">
   			<a href="http://localhost/comic/"><h2 class="logo">KComics</h2></a>
	   		<h2 class="instruction">Register</h2>
	   		<br>
	   		<?php if(in_array("<span style='color: #14C800;'>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</span><br>", $error_array)) echo "<br><span style='color: #800080;'>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</span><br>";?>
	   		<input type="text" name="reg_username" placeholder="Username" value="<?php 
					if(isset($_SESSION['reg_username'])) {
						echo $_SESSION['reg_username'];
					} 
					?>" required>
	   		<br>
	   		<div class="error">
	   		<?php if(in_array("Username already in use<br>", $error_array)) echo "Username already in use<br>";
	   		else if(in_array("Your Username must be between 2 and 25 characters<br>", $error_array)) echo "Your Username must be between 2 and 25 characters<br>"; 
	   		else if(in_array("Your Username must not have empty spaces.<br>", $error_array)) echo "Your Username must not have empty spaces.<br>"; ?>


	   		
			</div>

	   		<input type="email" name="reg_email" placeholder="Email" value="<?php 
					if(isset($_SESSION['reg_email'])) {
						echo $_SESSION['reg_email'];
					} 
					?>" required>
	   		<br>
	   		<input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
					if(isset($_SESSION['reg_email2'])) {
						echo $_SESSION['reg_email2'];
					} 
					?>" required>
					<br>
					<div class="error">
					<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
					else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
					else if(in_array("Emails don't match<br>", $error_array)) echo "Emails do not match<br>"; ?>
				</div>
			<br>
	   		<input type="password" name="reg_password" placeholder="Password" required>
	   		<br>
	   		<input type="password" name="reg_password2" placeholder="Confirm password" required>
	   		<br>
	   		<div class="error">
	   		<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Passwords do not match<br>"; 
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "Your password must be betwen 5 and 30 characters<br>"; ?>
			</div>
			<label for="birthdate">Date of Birth</label>
			<input type="date" id="birthdate" name="reg_birthdate" value="<?php 
					if(isset($_SESSION['reg_birthdate'])) {
						echo $_SESSION['reg_birthdate'];
					} 
					?>" required>
			<br>
			<select id="sex" name="reg_gender" required>
				  <option value="">Gender</option>
				  <option value="Male">Male</option>
				  <option value="Female">Female</option>
				  <option value="Other">Other</option>
            </select> 
            <br>
            <br>
            <input type="checkbox" class="checkbox" id="agreeterms" name="agreeterms[]" required>

	   		<label class="checkbox" for="agreeterms">I have read and agree to the KismatComics <a href="http://localhost/comic/Terms&Conditions.php" target="blank">Terms of Service</a> and <a href="http://localhost/comic/privacy.php" target="blank" class="u">Privacy Policy</a></label>
            <br>
            <br>
	   		<a href="#" id="signin" class="signin" onclick="hidesecond()">Login here!</a>



	   		<input type="submit" name="register_button" value="Submit">
	   		
			
			
		</form> 
	</div>
	 
</body>


