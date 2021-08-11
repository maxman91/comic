<?php
include("includes/header.php"); 
$q = strval($_GET['q']);

$con = mysqli_connect("localhost", "root", "", "comic");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$username = $user['username'];
$sql="UPDATE messages SET opened ='yes' WHERE user_to =  '$q' ";
$result = mysqli_query($con,$sql);


mysqli_close($con);
?>