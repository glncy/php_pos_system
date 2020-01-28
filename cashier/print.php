<?php
session_start();
include("../connection.php");
$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
$total = 0;
$query = "SELECT * FROM $table";
$get = mysql_query($query);
$output = '<thead><tr><th>Details</th><th>Qty</th><th>Price</th></tr></thead>';
while ($row=mysql_fetch_array($get)) {
	$id = $row['id'];
	$product_id = $row['product_id'];
	$query_2 = "SELECT * FROM tblproducts WHERE id='$product_id'";
	$get_2 = mysql_query($query_2);
	$row_2 = mysql_fetch_array($get_2);
	$total = $total+($row_2['selling_price']*$row['qty']);
	$output.= "<tr><td>".$row_2['barcode']." ".$row_2['brand_name']." ".$row_2['generic_name']."</td><td>".$row['qty']."</td><td>&#8369;".$row_2['selling_price']."</td></tr>";
}
mysql_close();

include("../connection.php");
$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
$total = 0;
$query = "SELECT * FROM $table";
$get = mysql_query($query);
$cart=0;
while ($row=mysql_fetch_array($get)) {
	$cart += $row['qty'];
	$id = $row['id'];
	$product_id = $row['product_id'];
	$query_2 = "SELECT * FROM tblproducts WHERE id='$product_id'";
	$get_2 = mysql_query($query_2);
	$row_2 = mysql_fetch_array($get_2);
	$total = $total+($row_2['selling_price']*$row['qty']);
}
$output_2 = '<thead><tr><th>No. of Items In Cart</th><th>'.$cart.'</th></tr></thead>';
$tax = $total*0.12;
$final_total = $total+$tax;
$output_2 .= "";
$output_2 .= "<tr><td>Sub Total:</td><td>&#8369;".round($total,2)."</td></tr>";
$output_2 .= "<tr><td>Tax:</td><td>&#8369;".round($tax,2)."</td></tr>";
$output_2 .= "<tr><td></td><td>&#8369;".round($final_total,2)."</td></tr>";
$output_2 .= "<tr><td>Paymet : &#8369;".round($_GET['payment'],2)."</td><td>Change : &#8369;".round($_GET['change'],2)."</td></tr>";
mysql_close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy POS</title>
	
</head>
<body id="print">
	<table width="40%">
		<tr>
			<td><center>JOVES PHARMACY, RIZAL ST. POBLACION</center></td>
		</tr>
		<tr>
			<td><center>EAST CALASIAO, PANGASINAN</center></td>
		</tr>
		<tr>
			<td><hr/></td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="40%">
		<tr>
			<td>Invoice # : <?php echo $_GET['invoice'];?></td>
			<td>Transaction ID : <?php echo $_GET['trans_id'];?></td>
		</tr>
		<tr>
			<td colspan="2"><hr/></td>
		</tr>
	</table>
	
	<table cellspacing="0" cellpadding="0" width="40%" border="1px">
		<?php echo $output;?>
	</table>
	<table cellspacing="0" cellpadding="0" width="40%">
		<tr>
			<td><hr/></td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="40%" border="1px">
		<?php echo $output_2;?>
	</table>
	<table cellspacing="0" cellpadding="0" width="40%">
		<tr>
			<td><hr/></td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="40%">
		<tr>
			<td><center>THIS IS YOUR OFFICIAL RECEIPT</center></td>
		</tr>
	</table>
	<script>
		alert('Click OK to Print the Receipt')
		var mywindow = window.open('', 'PRINT', 'height=400,width=600');
	    //mywindow.document.write('<html><head><title>Joves Pharmacy</title>');
	    //mywindow.document.write('</head><style>*{font-design:none; font-size:10px; font-family: Arial;} table{width:100%;} th {text-align:left;}</style><body>');
	    mywindow.document.write(document.getElementById('print').innerHTML);
	    //mywindow.document.write('</body></html>');

	    mywindow.document.close(); // necessary for IE >= 10
	    mywindow.focus(); // necessary for IE >= 10

	    setTimeout(function() {
			    mywindow.print();
			    mywindow.close();
			}, 20);

	    window.location = "index.php";
	</script>
</body>
</html>