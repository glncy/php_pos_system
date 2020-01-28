<?php
include('connection.php');
$start = $_POST['dateFrom'];
$end = $_POST['dateTo'];

$query = "SELECT * FROM tblsales_report WHERE date BETWEEN $start AND $end ORDER BY id desc";
$get=mysql_query($query);
$output='';
if (mysql_num_rows($get)>0)
{
	while ($row = mysql_fetch_array($get)) {
		$output .="<tr><td>".$row['trans_id']."</td><td>".$row['date']."</td><td>".$row['customer_name']."</td><td>".$row['invoice']."</td><td>".$row['amount']."</td><td>".$row['profit']."</td></tr>";
	}
	echo $output;
}
else
{
	echo '<td colspan="9"><center>Data Not Found</center></td>';
}
mysql_close();
?>