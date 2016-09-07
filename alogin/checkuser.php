<?php include '../config.php' ?>


<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];



$stmt = $db->query("select * from user_details where user_name= '$username' and password='$password'");
if(!empty($stmt ) AND $stmt ->rowCount() > 0)
{
$row_count = $stmt->rowCount();
if($row_count==1)
{
 $_SESSION['username']=$username; 
 echo true;
}
else
{
$_SESSION['username']="";
 echo false;
}
}
else
{
 echo false;
}
?>		