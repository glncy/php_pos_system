<?php
session_start();
include('connection.php');
$id=$_GET['id'];
$query="SELECT * FROM system_accounts WHERE id='$id'";
$get=mysql_query($query);
$row=mysql_fetch_array($get);
$user_name=$row['user_name'];
$query="DELETE FROM system_accounts WHERE id='$id'";
if (mysql_query($query)) {
	do
	{
		$activity_id = mt_rand(100000, 999999);
		$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
		$get = mysql_query($query);
		$num_rows = mysql_num_rows($get);
	} while ($num_rows!=0);

	$activity_date = date("Y/m/d");
	$activity_details = "Deleted ".$user_name." in System Accounts.";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	if (mysql_query($query)) {
		$_SESSION['notification']="Deleted Successfully! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
		$_SESSION['status']="SUCCESS";
		header('Location: /index.php');
		echo "YES";
	}
	else
	{
		echo "NO";
	}
	

}
else
{
	$activity_date = date("Y/m/d");
	$activity_details = "Failed to Delete ".$user_name." in System Accounts due to an Error.";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Failed to Delete! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: /index.php');
}
mysql_close();
?>