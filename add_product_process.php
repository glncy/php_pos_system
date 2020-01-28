<?php
session_start();
include('connection.php');

$barcode=mysql_real_escape_string($_POST['barcode']);
$brand_name=mysql_real_escape_string($_POST['brand_name']);
$generic_name=mysql_real_escape_string($_POST['generic_name']);
$category=mysql_real_escape_string($_POST['category']);
$arrival_date=mysql_real_escape_string($_POST['arrival_date']);
$expiry_date=mysql_real_escape_string($_POST['expiration_date']);
$original_price=mysql_real_escape_string($_POST['original_price']);
$selling_price=mysql_real_escape_string($_POST['selling_price']);
$qty=mysql_real_escape_string($_POST['qty']);
$vat_price=mysql_real_escape_string($_POST['vat_price']);
$total_price=mysql_real_escape_string($_POST['total_price']);
$profit_per_piece=mysql_real_escape_string($_POST['profit_per_piece']);
$profit_all_qty=mysql_real_escape_string($_POST['profit_all_qty']);
$total_vat=mysql_real_escape_string($_POST['total_vat']);


$query="SELECT * FROM tblproducts WHERE brand_name='$brand_name' AND generic_name='$generic_name'";
$get=mysql_query($query);
if (mysql_num_rows($get)==0) {
	$query="INSERT INTO tblproducts (barcode,brand_name,generic_name,category,original_price,selling_price,total_price,profit_per_piece,vat_price,profit_all_qty,total_vat) VALUES ('$barcode','$brand_name','$generic_name','$category','$original_price','$selling_price','$total_price','$profit_per_piece','$vat_price','$profit_all_qty','$total_vat')";
	if (mysql_query($query)or die(mysql_error())) {
		//$query="SELECT * tblproducts ORDER BY id desc limit 1";
		//$get=mysql_query($query);
		//$row=mysql_fetch_array($get);
		$product_key=mysql_insert_id();
		$query="INSERT INTO tblproduct_stocks (qty,expiry_date,arrival_date,product_key) VALUES ('$qty','$expiry_date','$arrival_date','$product_key')";
		mysql_query($query);
		do
		{
			$activity_id = mt_rand(100000, 999999);
			$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
			$get = mysql_query($query);
			$num_rows = mysql_num_rows($get);
		} while ($num_rows!=0);

		$activity_date = date("Y/m/d");
		$activity_details = "Added ".$brand_name." in Product List.";
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
	$activity_details = "Failed to Add ".$brand_name." Due to duplicate";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query);
	$_SESSION['notification']="Failed to Add! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: index.php');
}
mysql_close();
?>