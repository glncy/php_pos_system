<?php
$search=mysql_real_escape_string($_GET["search"]);
include('../connection.php');
$output = '<table class="table" cellpadding="3px" cellspacing="0px">
				<thead>
					<tr>
						<th>Product ID</th>
						<th>Brand Name</th>
						<th>Generic name</th>
						<th>Category</th>
						<th>Price</th>
						<th>Qty</th>
						<th colspan="2" style="text-align: center;"></th>
					</tr>
				</thead>
				<tbody>';
$query = "SELECT * FROM tblproducts WHERE (barcode LIKE '%$search%' OR brand_name LIKE '%$search%' OR generic_name LIKE '%$search%' OR category LIKE '%$search%')";
$result=mysql_query($query);
if (mysql_num_rows($result)>0) {
	while ($row = mysql_fetch_array($result)) {
		$id=$row['id'];

		$query_qty="SELECT * FROM tblproduct_stocks WHERE product_key=$id AND status=''";
		$get_qty=mysql_query($query_qty) or die(mysql_error());
		$qty=0;
		while ($row_qty=mysql_fetch_array($get_qty)) {
			$qty+=$row_qty['qty'];
		}

		$output .="<tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".($row['selling_price']+$row['vat_price'])."</td><td>".$qty."</td><td><input type='text' placeholder='QTY' class='form-control' id='id".$id."'></td><td><button class='btn btn-danger' onclick='addOrder(\"id".$id."\",\"".$id."\")'>Add</button></td></tr>";
	}
	$output .= '</tbody></table>';
	echo $output;
}
else
{
	echo '<td colspan="9"><center>Data Not Found</center></td>';
}
?>	