<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = strval($_GET['q']);

$con = mysqli_connect("localhost", "root", "", "comic");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM users WHERE username = '".$q."'";
$result = mysqli_query($con,$sql);


while($row = mysqli_fetch_array($result)) {
   $link1 = "http://localhost/comic/$row[username]";
   $pic3 = $row['profile_pic'];
   $pic1 = implode(' ', (array)$pic3);
    
    echo "<div class='subscription'><a href='$link1'>";
    echo '<img src='. $pic1.'><br><p>'; 
    echo $row['username'] ;
    echo '</p></a></div><br>';
    
}
echo "</table>";
$sql2="SELECT * FROM uploads WHERE username = '".$q."' ORDER BY id DESC" ;
$result2 = mysqli_query($con,$sql2);
$a=0;
foreach ($result2 as $key => $uploads) {
 $string = $uploads['image'];
          $arr = explode(",", $string, 2);
      $image = $arr[0];
        $postid = $uploads['id'];
         $a++;
        if ($a<20) {
            echo '<a href="comic/'.$postid.'"><img class="thumbnailpic" src="'.$image.'"></a>';}
            


         
  
  
    
    
}







mysqli_close($con);
?>
</body>
</html> 