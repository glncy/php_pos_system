<?php
include('connection.php');
$start = $_POST['printfrom'];
$end = $_POST['printto'];
if (($start=='')||($end==''))
{
	$query = "SELECT * FROM tblsales_report ORDER BY id DESC";
	$get=mysql_query($query);
	$output='<table class="table table-bordered" border="2px" cellspacing="0"><tr><td>Transaction ID</td><td>Transaction Date</td><td>Invoice Number</td><td>Amount</td><td>Profit</td></tr>';
	if (mysql_num_rows($get)>0)
	{
		while ($row = mysql_fetch_array($get)) {
			$output .="<tr><td>".$row['trans_id']."</td><td>".$row['date']."</td><td>".$row['invoice']."</td>";
			$inv=$row['invoice'];
			$query_getdes="SELECT * FROM tblproduct_inventory WHERE invoice='$inv'";
			$get_getdes=mysql_query($query_getdes);
			$output.="<td><table border='2px' width='100%'><tr><td>Brand Name</td><td>Generic Name</td></tr>";
			while ($row_getdes=mysql_fetch_array($get_getdes)) {
				$output.="<tr><td>".$row_getdes['brand_name']."</td><td>".$row_getdes['generic_name']."</td></tr>";
			}
			$output.="</table></td>";
			$output.="<td>&#8369;".$row['amount']."</td><td>&#8369;".$row['profit']."</td></tr>";
		}
	}
	else
	{
		echo '<td colspan="9"><center>Data Not Found</center></td>';
	}
}
else
{
	$query = "SELECT * FROM tblsales_report WHERE date >='$start' AND date <= '$end' ORDER BY id desc";
	$get=mysql_query($query);
	$output='<table class="table table-bordered" border="2px" cellspacing="0"><tr><td>Transaction ID</td><td>Transaction Date</td><td>Invoice Number</td><td>Amount</td><td>Profit</td></tr>';
	if (mysql_num_rows($get)>0)
	{
		while ($row = mysql_fetch_array($get)) {
			$output .="<tr><td>".$row['trans_id']."</td><td>".$row['date']."</td><td>".$row['invoice']."</td>";
			$inv=$row['invoice'];
			$query_getdes="SELECT * FROM tblproduct_inventory WHERE invoice='$inv'";
			$get_getdes=mysql_query($query_getdes);
			$output.="<td><table border='2px' width='100%'><tr><td>Brand Name</td><td>Generic Name</td></tr>";
			while ($row_getdes=mysql_fetch_array($get_getdes)) {
				$output.="<tr><td>".$row_getdes['brand_name']."</td><td>".$row_getdes['generic_name']."</td></tr>";
			}
			$output.="</table></td>";
			$output.="<td>&#8369;".$row['amount']."</td><td>&#8369;".$row['profit']."</td></tr>";
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