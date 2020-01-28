<?php
include('connection.php');
$start = $_POST['printfrom'];
$end = $_POST['printto'];
if (($start=='')||($end==''))
{
	$query = "SELECT * FROM tblproduct_stocks ORDER BY id desc limit 20";
	$get=mysql_query($query);
	$output='<table class="table table-bordered" border="2px" cellspacing="0"><tr><td>Product ID</td><td>Brand Name</td><td>Generic Name</td><td>Category</td><td>Original Price</td><td>Selling Price</td><td>Quantity</td><td>Date Added</td></tr>';
	if (mysql_num_rows($get)>0)
	{
		while ($row = mysql_fetch_array($get)) {
			$id=$row['id'];
			$product_key=$row['product_key'];
			$query_arrival="SELECT * FROM tblproducts WHERE id=$product_key";
			$get_arrival=mysql_query($query_arrival);
			while ($row_arrival=mysql_fetch_array($get_arrival)) {
				$output .="<tr><td>".$row_arrival['barcode']."</td><td>".$row_arrival['brand_name']."</td><td>".$row_arrival['generic_name']."</td><td>".$row_arrival['category']."</td><td>&#8369;".$row_arrival['original_price']."</td><td>&#8369;".$row_arrival['selling_price']."</td><td>".$row['qty']."</td><td>".$row['arrival_date']."</td></tr>";
			}
		}
		echo $output;
	}
	else
	{
		echo '<td colspan="9"><center>Data Not Found</center></td>';
	}
}
else
{
	$query = "SELECT * FROM tblproduct_stocks WHERE arrival_date >='$start' AND arrival_date <= '$end' ORDER BY id desc";
	$get=mysql_query($query);
	$output='<table class="table table-bordered" border="2px" cellspacing="0"><tr><td>Product ID</td><td>Brand Name</td><td>Generic Name</td><td>Category</td><td>Original Price</td><td>Selling Price</td><td>Quantity</td><td>Date Added</td></tr>';
	if (mysql_num_rows($get)>0)
	{
		while ($row = mysql_fetch_array($get)) {
			$id=$row['id'];
			$product_key=$row['product_key'];
			$query_arrival="SELECT * FROM tblproducts WHERE id=$product_key";
			$get_arrival=mysql_query($query_arrival);
			while ($row_arrival=mysql_fetch_array($get_arrival)) {
				$output .="<tr><td>".$row_arrival['barcode']."</td><td>".$row_arrival['brand_name']."</td><td>".$row_arrival['generic_name']."</td><td>".$row_arrival['category']."</td><td>&#8369;".$row_arrival['original_price']."</td><td>&#8369;".$row_arrival['selling_price']."</td><td>".$row['qty']."</td><td>".$row['arrival_date']."</td></tr>";
			}
		}
		echo $output;
	}
	else
	{
		echo '<td colspan="9"><center>Data Not Found</center></td>';
	}
}
$output.="</table>";
mysql_close();
?>