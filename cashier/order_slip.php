<?php
session_start();
include("../connection.php");
$id = $_POST['id'];
$qty = $_POST['qty'];
$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
$total = 0;
$query = "INSERT INTO $table (product_id,qty) VALUES ('$id','$qty')";
mysql_query($query);
$query = "SELECT * FROM $table";
$get = mysql_query($query);
$output = '<thead>
					<tr>
						<th>Details</th>
						<th>Qty</th>
						<th>Price</th>
						<th align="center">Remove</th>
					</tr>
				</thead>';
while ($row=mysql_fetch_array($get)) {
	$id = $row['id'];
	$product_id = $row['product_id'];
	$query_2 = "SELECT * FROM tblproducts WHERE id='$product_id'";
	$get_2 = mysql_query($query_2);
	$row_2 = mysql_fetch_array($get_2);
	$total = $total+(($row_2['selling_price']+$row_2['vat_price'])*$row['qty']);
	$output.= "<tr><td>".$row_2['barcode']." ".$row_2['brand_name']." ".$row_2['generic_name']."</td><td>".$row['qty']."</td><td>&#8369;".($row_2['selling_price']+$row_2['vat_price'])."</td><td align='center'><button onclick='delOrder(\"".$id."\")' type='button'>X</button></td></tr>";
}
$output .= "<tr><td></td><td>Total:</td><td>&#8369;".$total."</td><td></td></tr><tr><td colspan='4'><button type='button' class='btn btn-warning btn-block' data-toggle='modal' data-target='#ordermodal' onclick='OrderList()'>Order</button></td><tr/>";
if (mysql_num_rows($get)!=0)
{
	echo $output;
}
mysql_close();
?>