<?php
session_start();
include('connection.php');
$id=$_GET['id'];

$query = "SELECT * FROM system_accounts WHERE id='$id'";
$get = mysql_query($query);
$row = mysql_fetch_array($get);

$user_name = $row['user_name'];
$pw=mysql_real_escape_string($_POST['pw']);
$role=mysql_real_escape_string($_POST['role']);

$query="UPDATE system_accounts SET pw='$pw', role='$role' WHERE id='$id'";
if (mysql_query($query))
{
	do
	{
		$activity_id = mt_rand(100000, 999999);
		$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
		$get = mysql_query($query);
		$num_rows = mysql_num_rows($get);
	} while ($num_rows!=0);
	$activity_date = date("Y/m/d");
	$activity_details = "Edited ".$user_name." in System Accounts.";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query) or die(mysql_error());
	$_SESSION['notification']="Edited Successfully! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
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
	$activity_details = "Failed to Edit ".$user_name." Due to duplicate.";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Failed to Edit! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: /index.php');
}
mysql_close();
?>