<?php
session_start();
include('connection.php');

$category=mysql_real_escape_string($_POST['category']);

$query="SELECT * FROM tblcategory WHERE category='$category'";

$get=mysql_query($query);
if (mysql_num_rows($get)==0) {
	$query="INSERT INTO tblcategory (category) VALUES ('$category')";
	if (mysql_query($query)or die(mysql_error())) {
		do
		{
			$activity_id = mt_rand(100000, 999999);
			$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
			$get = mysql_query($query);
			$num_rows = mysql_num_rows($get);
		} while ($num_rows!=0);

		$activity_date = date("Y/m/d");
		$activity_details = "Added ".$category." in Category List.";
		$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
		mysql_query($query) or die(mysql_error());
		$_SESSION['notification']="Added Successfully! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
		$_SESSION['status']="SUCCESS";
		header('Location: /index.php');
	}
}
else
{
	do
	{
		$activity_id = mt_rand(100000, 999999);
		$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
		$get = mysql_query($query);
		$num_rows = mysql_num_rows($get);
	} while ($num_rows!=0);

	$activity_date = date("Y/m/d");
	$activity_details = "Failed to Add ".$category." Due to duplicate";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Failed to Add! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: index.php');
}
mysql_close();
?>