<?php
session_start();

$payment=$_POST['payment'];
$change=$_POST['change'];

echo $change;

include("../connection.php"); 
do
{
	$invoice = mt_rand(100000, 999999);
	$query="SELECT * FROM tblsales_report WHERE invoice='$invoice'";
	$get = mysql_query($query);
	$num_rows = mysql_num_rows($get);
} while ($num_rows!=0);

$customer_name = $_POST['customers_name'];
$date = date("Y/m/d");
$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
$amount = 0;
$amount_2 = 0;
$query = "SELECT * FROM $table";
$get = mysql_query($query);
$amount_3=0;
while ($row=mysql_fetch_array($get)) {
	$id = $row['id'];
	$product_id = $row['product_id'];
	$qty = $row['qty'];
	$query_2 = "SELECT * FROM tblproducts WHERE id='$product_id'";
	$get_2 = mysql_query($query_2);
	$row_2 = mysql_fetch_array($get_2);
	$sell_price=$row_2['selling_price'];
	$orig_price=$row_2['original_price'];
	$amount += $qty*$row_2['selling_price'];
	$amount_2 += $qty*$row_2['original_price'];
	$amount_3 += $qty*($row_2['selling_price']+$row_2['vat_price']);
	$query_3="SELECT * FROM tblproduct_stocks WHERE product_key='$product_id' and status='' ORDER BY id ASC";
	$get_3=mysql_query($query_3);
	//$row_3=mysql_fetch_array($get_3);
	$qty_3=0;
	while ($row_3=mysql_fetch_array($get_3)) {
		$qty_3+=$row_3['qty'];
	}

	$remain=$qty_3-$qty;
	$product_amnt_2=$row_2['original_price']*$qty;
	$product_amnt=$row_2['selling_price']*$qty;
	ProductInventory($invoice,mysql_real_escape_string($row_2['brand_name']),mysql_real_escape_string($row_2['generic_name']),mysql_real_escape_string($row_2['category']),mysql_real_escape_string($row_2['selling_price']),$qty,$remain,$product_amnt,($product_amnt-$product_amnt_2),$date);
	ProductChanges($qty,$amount_3,$product_id,$sell_price,$orig_price);
}

$transaction = SalesReport($customer_name,$amount,($amount-$amount_2),$date,$invoice);
$_SESSION['notification']="Order Success";
$_SESSION['status']="SUCCESS";
$location = '?payment='.$payment.'&change='.$change.'&invoice='.$invoice.'&trans_id='.$transaction.'';
header('Location: print.php'.$location);

function SalesReport($customer_name,$amount,$profit,$date,$invoice)
{
	do
	{
		$trans_id = date("Y")."-";
		$trans_id .= mt_rand(100000, 999999);
		$query_sales="SELECT * FROM tblsales_report WHERE trans_id='$trans_id'";
		$get_sales = mysql_query($query_sales);
		$num_rows = mysql_num_rows($get_sales);
	} while ($num_rows!=0);	

	$query_sales = "INSERT INTO tblsales_report(trans_id,date,customer_name,invoice,amount,profit) VALUES ('$trans_id','$date','$customer_name','$invoice','$amount','$profit')";
	mysql_query($query_sales);
	return $trans_id;
}

function ProductInventory($invoice,$brand_name,$generic_name,$category,$price,$qty_ordered,$remain_qty,$amnt,$profit_inventory,$date)
{
	$query_inventory = "INSERT INTO tblproduct_inventory(invoice, date, brand_name, generic_name, category, price, qty, remain_qty, total_amnt, profit) VALUES ('$invoice','$date','$brand_name','$generic_name','$category','$price','$qty_ordered','$remain_qty','$amnt','$profit_inventory')";
	mysql_query($query_inventory) or die(mysql_error());
}

function ProductChanges($qty,$total_selling_price,$product_id,$sell,$orig)
{
	$qty_new=0;
	$query_qty="SELECT * FROM tblproduct_stocks WHERE product_key='$product_id'";
	$get_qty=mysql_query($query_qty);
	$qty_count=0;
	while ($row_qty=mysql_fetch_array($get_qty)) {
		$qty_new+=$row_qty['qty'];
	}
	$query_productchange = "SELECT * FROM tblproducts WHERE id='$product_id'";
	$get_product=mysql_query($query_productchange);
	$row_product=mysql_fetch_array($get_product);
	$new_qty = $qty_new-$qty;
	$new_total_price = $row_product['total_price']-$total_selling_price;
	$new_total_profit = $new_qty*($row_product['selling_price']-$row_product['original_price']);
	$new_sold = $row_product['sold']+$qty;
	$query_productchange = "UPDATE tblproducts SET total_price='$new_total_price',sold='$new_sold' WHERE id='$product_id'";
	mysql_query($query_productchange);
	$query_qty="SELECT * FROM tblproduct_stocks WHERE product_key='$product_id' AND status='' AND qty>0 ORDER BY id asc";
	$get_qty=mysql_query($query_qty);
	$row_qty=mysql_fetch_array($get_qty);
	$update_qty=$row_qty['qty']-$qty;
	$query_productchange = "UPDATE tblproduct_stocks SET qty='$update_qty' WHERE product_key='$product_id' AND status='' AND qty>0 ORDER BY id asc LIMIT 1";
	mysql_query($query_productchange);
}
?>