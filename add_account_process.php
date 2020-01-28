<?php
session_start();
include('connection.php');

$user_name=mysql_real_escape_string($_POST['user_name']);
$pw=mysql_real_escape_string($_POST['pw']);
$role=mysql_real_escape_string($_POST['role']);

$query="SELECT * FROM system_accounts WHERE user_name='$user_name'";

$get=mysql_query($query);
if (mysql_num_rows($get)==0) {
	$query="INSERT INTO system_accounts (user_name,pw,role) VALUES ('$user_name','$pw','$role')";
	if (mysql_query($query)or die(mysql_error())) {
		do
		{
			$activity_id = mt_rand(100000, 999999);
			$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
			$get = mysql_query($query);
			$num_rows = mysql_num_rows($get);
		} while ($num_rows!=0);

		$activity_date = date("Y/m/d");
		$activity_details = "Added ".$brand_name." in Account List.";
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
	$activity_details = "Failed to Add ".$user_name." Due to duplicate";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Failed to Add! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: index.php');
}
mysql_close();
?>