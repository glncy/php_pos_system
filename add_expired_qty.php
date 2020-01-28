<?php
session_start();
include('connection.php');

$id=$_POST['id'];
$expired_qty=$_POST['expired_qty'];

$query = "SELECT * FROM tblproducts WHERE id='$id'";
$get = mysql_query($query);

$row=mysql_fetch_array($get);

$barcode = $row['barcode'];
$brand_name = $row['brand_name'];
$generic_name = $row['generic_name'];
$category = $row['category'];
$qty = $row['qty'];
$selling_price = $row['selling_price'];
$remaining_qty = $qty - $expired_qty;
$date = date("Y/m/d");

$query = "INSERT INTO tblexpired_report(barcode,brand_name,generic_name,category,expired_qty,remaining_qty,date) VALUES ('$barcode','$brand_name','$generic_name','$category','$expired_qty','$remaining_qty','$date')";
if (mysql_query($query))
{
	$total_price = $selling_price * $remaining_qty;
	$query = "UPDATE tblproducts SET qty='$remaining_qty', total_price='$total_price' WHERE id='$id'";
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
		$activity_details = "Added ".$expired_qty." Expired Stocks in ".$brand_name.".";
		$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
		mysql_query($query) or die(mysql_error());
		$_SESSION['notification']="Added Expired Stocks Successfully! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
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
	$activity_details = "Failed to Add Expired Stocks in ".$brand_name." Due to an error.";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Failed to Add Expired Stocks! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: /index.php');
}
?>