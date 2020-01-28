<?php
session_start();
include("../connection.php");
$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
$total = 0;
$query = "SELECT * FROM $table";
$get = mysql_query($query);
$cart=0;
$total_tax=0;
while ($row=mysql_fetch_array($get)) {
	$cart += $row['qty'];
	$id = $row['id'];
	$product_id = $row['product_id'];
	$query_2 = "SELECT * FROM tblproducts WHERE id='$product_id'";
	$get_2 = mysql_query($query_2);
	$row_2 = mysql_fetch_array($get_2);
	$total = $total+($row_2['selling_price']*$row['qty']);
	$total_tax += $row_2['vat_price']*$row['qty'];
}
$output = '<thead><tr>
				<th>No. of Items In Cart</th>
				<th>'.$cart.'</th>
			</tr>
				</thead>';
//$tax = $total*0.12;
$final_total = $total+$total_tax;

$output .= "";
$output .= "<tr><td>Sub Total:</td><td>&#8369;".round($total,2)."</td></tr>";
$output .= "<tr><td>Tax:</td><td>&#8369;".round($total_tax,2)."</td></tr>";
$output .= "<tr><td><input type='number' value='".round($final_total,2)."'' id='finaltotal' style='display:none;'></td><td style='font-size: 30px;'>&#8369;".round($final_total,2)."</td></tr>";
echo $output;
mysql_close();
?>