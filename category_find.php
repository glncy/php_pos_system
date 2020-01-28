<?php
include('connection.php');
$category = $_POST['category'];
if ($category=='')
{
	$query = "SELECT * FROM tblproduct_inventory ORDER by id desc";
	$get=mysql_query($query);
	$output='<table class="table table-bordered" border="2px" cellspacing="0"><tr><td>Invoice Number</td><td>Date</td><td>Brand Name</td><td>Generic Name</td><td>Category</td><td>Price</td><td>Qty</td><td>Remaining</td><td>Amount</td><td>Profit</td></tr>';
	if (mysql_num_rows($get)>0)
	{
		while ($row = mysql_fetch_array($get)) {
			$output .="<tr><td>".$row['invoice']."</td><td>".$row['date']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".$row['price']."</td><td>".$row['qty']."</td><td>".$row['remain_qty']."</td><td>&#8369;".$row['total_amnt']."</td><td>&#8369;".$row['profit']."</td></tr>";
		}
		$output.="</table>";
		echo $output;
	}
	else
	{
		echo '<td colspan="9"><center>Data Not Found</center></td>';
	}
}
else
{
	$query = "SELECT * FROM tblproduct_inventory WHERE category='$category' ORDER BY id desc";
	$get=mysql_query($query) or die(mysql_error());
	$output='<table class="table table-bordered" border="2px" cellspacing="0"><tr><td>Invoice Number</td><td>Date</td><td>Brand Name</td><td>Generic Name</td><td>Category</td><td>Price</td><td>Qty</td><td>Remaining</td><td>Amount</td><td>Profit</td></tr>';;
	if (mysql_num_rows($get)>0)
	{
		while ($row = mysql_fetch_array($get)) {
			$output .="<tr><td>".$row['invoice']."</td><td>".$row['date']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".$row['price']."</td><td>".$row['qty']."</td><td>".$row['remain_qty']."</td><td>&#8369;".$row['total_amnt']."</td><td>&#8369;".$row['profit']."</td></tr>";
		}
		$output.="</table>";
		echo $output;
	}
	else
	{
		echo '<td colspan="9"><center>Data Not Found</center></td>';
	}
}
mysql_close();
?>