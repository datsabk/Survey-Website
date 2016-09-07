
<?php
session_start();
function checklogin()
{
if($_SESSION['username']!="")
	echo true;
else
	echo false;
}
?>