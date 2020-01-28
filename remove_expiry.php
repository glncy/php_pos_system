<?php
$id=$_GET['id'];
$ref=$_GET['ref'];

include('connection.php');
$query="UPDATE tblexpired_report SET status='removed' WHERE id='$id'";
if (mysql_query($query) or die(mysql_error()))
{
	do
	{
		$activity_id = mt_rand(100000, 999999);
		$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
		$get = mysql_query($query);
		$num_rows = mysql_num_rows($get);
	} while ($num_rows!=0);
	$activity_date = date("Y/m/d");
	$activity_details = "Marked Expired Sucess";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Sucess! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="SUCCESS";
	header('Location: /index.php');
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
	$activity_details = "Marked Expired Failed";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Failed! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: /index.php');
}
?>