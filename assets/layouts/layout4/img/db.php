
<?php
$conn = mysql_connect('localhost', 'u629640469_abk', 'Quiz123!@#');

	 if (!$conn)

    {

	 die('Could not connect: ' . mysql_error());

	}

	mysql_select_db("u629640469_sdb", $conn);
?>