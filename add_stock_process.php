<?php
session_start();
include('connection.php');
$id=mysql_real_escape_string($_GET['id']);
$arrival_date=mysql_real_escape_string($_POST['arrival_date']);
$expiry_date=mysql_real_escape_string($_POST['expiration_date']);
$stocks=mysql_real_escape_string($_POST['qty']);
$query="SELECT * FROM tblproducts WHERE id='$id'";
$get=mysql_query($query);
$row=mysql_fetch_array($get);
$brand_name=$row['brand_name']." ".$row['generic_name'];
$vat_price = $row['vat_price'];
$profit_per_piece = $row['profit_per_piece'];
$selling_price = $row['selling_price'];
$total_price = $row['total_price'];
$total_vat = $row['total_vat'];
$profit_all_qty = $row['profit_all_qty'];
$query_qty="SELECT * FROM tblproduct_stocks WHERE product_key=$id";
	$get_qty=mysql_query($query_qty) or die(mysql_error());
	$qty=0;
	while ($row_qty=mysql_fetch_array($get_qty)) {
		$qty+=$row_qty['qty'];
	}

$new_qty=$qty + $stocks;
$new_total_price=$total_price + (($selling_price+$vat_price)*$stocks);
$new_profit_all_qty = $profit_all_qty + ($profit_per_piece*$stocks);
$new_total_vat = $total_vat + ($vat_price*$stocks);
$query="UPDATE tblproducts SET total_price='$new_total_price',profit_all_qty='$new_profit_all_qty',total_vat='$new_total_vat' WHERE id='$id'";
if (mysql_query($query))
{
	$query="INSERT INTO tblproduct_stocks (qty,arrival_date,expiry_date,product_key) VALUES ('$stocks','$arrival_date','$expiry_date','$id')";
	mysql_query($query);
	do
	{
		$activity_id = mt_rand(100000, 999999);
		$query="SELECT * FROM tblactivity_log WHERE activity_id='$activity_id'";
		$get = mysql_query($query);
		$num_rows = mysql_num_rows($get);
	} while ($num_rows!=0);
	$activity_date = date("Y/m/d");
	$activity_details = mysql_real_escape_string("Added ".$stocks." stocks to ".$brand_name.".");
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query) or die(mysql_error());
	$_SESSION['notification']="Added Stocks Successfully! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
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
	$activity_details = "Failed to Add ".$stocks." stocks to ".$brand_name.".";
	$query="INSERT INTO tblactivity_log (activity,activity_id,activity_date) VALUES ('$activity_details','$activity_id','$activity_date')";
	mysql_query($query) or die(mysql_error());
	$_SESSION['notification']="Failed to Add Stocks! Refer to Activity Log - Activity ID: ".$activity_id." - Activity Date: ".$activity_date;
	$_SESSION['status']="FAILED";
	header('Location: /index.php');
}
?>