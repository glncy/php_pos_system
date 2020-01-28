<?php
$search=mysql_real_escape_string($_GET["search"]);
include('connection.php');
$output = '<table class="table" cellpadding="3px" cellspacing="0px">
				<thead>
					<tr>
						<th>Product ID</th>
						<th>Brand Name</th>
						<th>Generic name</th>
						<th>Category</th>
						<th>Original Price</th>
						<th>Selling Price</th>
						<th>Quantity</th>
						<th colspan="2" style="text-align: center;">Options</th>
					</tr>
				</thead>
				<tbody>';
$query = "SELECT * FROM tblproducts WHERE barcode LIKE '%$search%' OR brand_name LIKE '%$search%' OR generic_name LIKE '%$search%' OR category LIKE '%$search%'";
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
		$output .="<tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".$row['original_price']."</td><td>&#8369;".$row['selling_price']."</td><td>".$qty."</td><td><button data-toggle='modal' class='btn btn-success' data-target='#product_edit".$id."'>Edit</button></td><td><button data-toggle='modal' class='btn btn-warning' data-target='#product_add".$id."'>Add Stocks</button></td><td><button data-toggle='modal' class='btn btn-danger' data-target='#product_delete".$id."'>Delete</button></td></tr>";
	}
	$output .= '</tbody></table>';
	echo $output;
}
else
{
	echo '<td colspan="9"><center>Data Not Found</center></td>';
}
?>	