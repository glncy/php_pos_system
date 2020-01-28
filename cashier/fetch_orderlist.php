<?php
session_start();
include("../connection.php");
$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
$total = 0;
$query = "SELECT * FROM $table";
$get = mysql_query($query);
$output = '<thead>
					<tr>
						<th>Details</th>
						<th>Qty</th>
						<th>Price</th>
					</tr>
				</thead>';
while ($row=mysql_fetch_array($get)) {
	$id = $row['id'];
	$product_id = $row['product_id'];
	$query_2 = "SELECT * FROM tblproducts WHERE id='$product_id'";
	$get_2 = mysql_query($query_2);
	$row_2 = mysql_fetch_array($get_2);
	$total = $total+($row_2['selling_price']*$row['qty']);
	$output.= "<tr><td>".$row_2['barcode']." ".$row_2['brand_name']." ".$row_2['generic_name']."</td><td>".$row['qty']."</td><td>&#8369;".($row_2['selling_price']+$row_2['vat_price'])."</td></tr>";
}
$tax = $total*0.12;
$final_total = $total+$tax;
echo $output;
mysql_close();
?>