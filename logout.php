<?php
session_start();
$src = $_GET['src'];
if (isset($src))
{
	if ($src == "cashier")
	{
		include("connection.php"); 
		$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
		$query = "DROP TABLE $table";
		mysql_query($query);
		mysql_close();
	}
}
session_destroy();
header('Location: /index.php');
?>