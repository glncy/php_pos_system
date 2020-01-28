<?php
$search=mysql_real_escape_string($_GET["search"]);
include('connection.php');
$output = '<table cellpadding="0px" cellspacing="0px" style="display:none;">
				<thead>
					<tr>
						<th>Barcode</th>
						<th>Brand Name</th>
						<th>Generic name</th>
						<th>Category</th>
						<th>Original Price</th>
						<th>Selling Price</th>
						<th>Quantity</th>
					</tr>
				</thead>
				<tbody>';
$query = "SELECT * FROM tblproducts WHERE barcode LIKE '%$search%' OR brand_name LIKE '%$search%' OR generic_name LIKE '%$search%' OR category LIKE '%$search%'";
$result=mysql_query($query);
if (mysql_num_rows($result)>0) {
	while ($row = mysql_fetch_array($result)) {
		$id=$row['id'];
		$output .="<tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".$row['original_price']."</td><td>&#8369;".$row['selling_price']."</td><td>".$row['qty']."</td></tr>";
	}
	$output .= '</tbody></table>';
	echo $output;
}
else
{
	echo '<td colspan="9"><center>Data Not Found</center></td>';
}
?>
<table ></table>