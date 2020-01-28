<?php
session_start();
include('connection.php');
$id=$_GET['id'];
$barcode=mysql_real_escape_string($_POST['barcode']);
$brand_name=mysql_real_escape_string($_POST['brand_name']);
$generic_name=mysql_real_escape_string($_POST['generic_name']);
$category=mysql_real_escape_string($_POST['category']);
//$arrival_date=mysql_real_escape_string($_POST['arrival_date']);
$original_price=mysql_real_escape_string($_POST['original_price']);
$selling_price=mysql_real_escape_string($_POST['selling_price']);
$qty=mysql_real_escape_string($_POST['qty']);
$total_price=mysql_real_escape_string($_POST['total_price']);
$profit_per_piece=mysql_real_escape_string($_POST['profit_per_piece']);

$query="SELECT * FROM tblproducts WHERE brand_name='$brand_name' AND generic_name='$generic_name'";
$get=mysql_query($query);
if (mysql_num_rows($get)>=1)
{
	$row=mysql_fetch_array($get);
	$temp_query="barcode='".$row['barcode']."', brand_name='".$row['brand_name']."', generic_name='".$row['generic_name']."', category=".$row['category'].", original_price='".$row['original_price']."', selling_price='".$row['selling_price']."', total_price='".$row['total_price']."' , profit_per_piece='".$row['profit_per_piece']."' WHERE id='".$row['id']."'";

	$query="UPDATE tblproducts SET barcode='$barcode', brand_name='$brand_name', generic_name='$generic_name', category='$category', original_price='$original_price', selling_price='$selling_price', total_price='$total_price' , profit_per_piece='$profit_per_piece' WHERE id='$id'";
	if (mysql_query($query) or die(mysql_error())) {
		$query="SELECT * FROM tblproducts WHERE brand_name='$brand_name' AND generic_name='$generic_name'";
		$get=mysql_query($query);
		if (mysql_num_rows($get)>1)
		{
			$query = "UPDATE tblproducts SET".$temp_query;
			mysql_query($query);
			do
			{
				$activity_id = mt_rand(100000, 999999);
				$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
				$get = mysql_query($query);
				$num_rows = mysql_num_rows($get);
			} while ($num_rows!=0);
			$activity_date = date("Y/m/d");
			$activity_details = "Failed to Edit ".$brand_name." Due to duplicate.";
			$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
			mysql_query($query);
			$_SESSION['notification']="Failed to Edit! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
			$_SESSION['status']="FAILED";
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
			$activity_details = "Edited ".$brand_name." in Product List.";
			$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
			mysql_query($query) or die(mysql_error());
			$_SESSION['notification']="Edited Successfully! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
			$_SESSION['status']="SUCCESS";
			header('Location: /index.php');
		}
	}
}
else
{
	$query="UPDATE tblproducts SET barcode='$barcode', brand_name='$brand_name', generic_name='$generic_name', category='$category', arrival_date='$arrival_date', original_price='$original_price', selling_price='$selling_price', qty='$qty', total_price='$total_price' , profit_per_piece='$profit_per_piece' WHERE id='$id'";
	if (mysql_query($query) or die(mysql_error())) {
		do
		{
			$activity_id = mt_rand(100000, 999999);
			$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
			$get = mysql_query($query);
			$num_rows = mysql_num_rows($get);
		} while ($num_rows!=0);
		$activity_date = date("Y/m/d");
		$activity_details = "Edited ".$brand_name." in Product List.";
		$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
		mysql_query($query) or die(mysql_error());
		$_SESSION['notification']="Edited Successfully! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
		$_SESSION['status']="SUCCESS";
		header('Location: /index.php');
	}
}
mysql_close();
?>