<?php
session_start();
if (!isset($_SESSION['user']))
{
	header("Location:/login.php");
}
else
{
	if ($_SESSION['role']=="Cashier")
	{
    	header("Location:/cashier/");
 	}
}
$date_now = date("Y/m/d");
include('connection.php');
$query="SELECT * FROM tblproduct_stocks WHERE expiry_date <= '$date_now'";
$get=mysql_query($query);
while ($row=mysql_fetch_array($get)) {
	$id = $row['id'];
	$product_key = $row['product_key'];
	if ($row['status']!='expired')
	{
		$query_update="UPDATE tblproduct_stocks SET status='expired' WHERE id='$id'";
		mysql_query($query_update);
		$query_search="SELECT * FROM tblproducts WHERE id='$product_key'";
		$get_search=mysql_query($query_search);
		$row_search=mysql_fetch_array($get_search);
		$brand_name=$row_search['brand_name'];
		$generic_name=$row_search['generic_name'];
		$category=$row_search['category'];
		$expired_qty=$row['qty'];
		$date=$row['expiry_date'];
		$barcode=$row_search['barcode'];
		$query_insert="INSERT INTO tblexpired_report(brand_name,generic_name,category,expired_qty,date,barcode,product_stocks_id) VALUES ('$brand_name','$generic_name','$category','$expired_qty','$date','$barcode','$id')";
		mysql_query($query_insert);
		$expiredqty=$row['qty'];
		$vat_price=$row_search['vat_price'];
		$selling_price=$row_search['selling_price'];
		$original_price=$row_search['original_price'];
		$total_deduct=($selling_price+$vat_price)*$expiredqty;
		$new_total_price=$row_search['total_price']-$total_deduct;
		$new_total_profit=$row_search['profit_all_qty']-(($selling_price-$original_price)*$expiredqty);
		$new_total_vat=$row_search['total_vat']-($expired_qty*$vat_price);
		$query_update="UPDATE tblproducts SET total_price='$new_total_price', total_vat='$new_total_vat', profit_all_qty='$new_total_profit'";
		mysql_query($query_update);
	}
}
mysql_close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pharmacy POS</title>
	<link rel="shortcut icon" type="images/png" href="res/logo.png">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap3/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="assets/jquery3.2.min.js"></script>
	<script type="text/javascript" src="assets/highcharts.js"></script>
	<script type="text/javascript" src="assets/exporting.js"></script>
	<script type="text/javascript" src="assets/bootstrap3/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap3/js/npm.js"></script>
	<style type="text/css">
		li>a
		{
			color: black;
		}
		li>a.hover
		{
			background-color: blue;
		}
		body
		{
			background-image: url("res/bg-pattern.png");
		}
		h1
		{
			background: rgba(255,255,255,0.7);
			padding: 10px;
			border-radius: 10px;
		}
		@page
		{
			size: 58mm 100mm;
		}
		.nav-hover:hover
		{
			background: #735674;
		}
		</style>
	<!-- FUNCTION -->
	<script>
	function sum() {
	            var txtFirstNumberValue = document.getElementById('sell_price').value;
	            var txtSecondNumberValue = document.getElementById('orig_price').value;
	            var txtThirdNumberValue = document.getElementById('qty').value;
	            var vat = document.getElementById('vat_price').value;
	            var total = parseFloat(txtFirstNumberValue) + parseFloat(vat);
	            var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
	            var result2 = parseFloat(total) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('profit').value = round;
			    }
			    else
			    {
			    	document.getElementById('profit').value = '';
			    }
			    if (!isNaN(result2)) {
			    	round = (Math.round(result2*100)/100).toFixed(2);
			        document.getElementById('total_price').value = round;
			    }
			    else
			    {
			    	document.getElementById('total_price').value = '';
			    }

			    var profit = document.getElementById('profit').value;
	            var qty = document.getElementById('qty').value;
	            var result = parseInt(qty) * parseFloat(profit);
	            //var result2 = parseFloat(txtFirstNumberValue) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('profit_all').value = round;
			    }
			    else
			    {
			    	document.getElementById('profit_all').value = '';
			    }

			    var result = parseFloat(txtFirstNumberValue) * 0.12;
	            //var result2 = parseFloat(txtFirstNumberValue) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('vat_price').value = round;
			    }
			    else
			    {
			    	document.getElementById('vat_price').value = '';
			    }

			    var result = parseFloat(vat) * parseInt(qty);
	            //var result2 = parseFloat(txtFirstNumberValue) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('total_vat').value = round;
			    }
			    else
			    {
			    	document.getElementById('total_vat').value = '';
			    }
	        }
	function edit_sum(idArea) {
	    var txtFirstNumberValue = document.getElementById('sell_price'+idArea).value;
	            var txtSecondNumberValue = document.getElementById('orig_price'+idArea).value;
	            var txtThirdNumberValue = document.getElementById('qty'+idArea).value;
	            var vat = document.getElementById('vat_price'+idArea).value;
	            var total = parseFloat(txtFirstNumberValue) + parseFloat(vat);
	            var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
	            var result2 = parseFloat(total) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('profit'+idArea).value = round;
			    }
			    else
			    {
			    	document.getElementById('profit'+idArea).value = '';
			    }
			    if (!isNaN(result2)) {
			    	round = (Math.round(result2*100)/100).toFixed(2);
			        document.getElementById('total_price'+idArea).value = round;
			    }
			    else
			    {
			    	document.getElementById('total_price'+idArea).value = '';
			    }

			    var profit = document.getElementById('profit'+idArea).value;
	            var qty = document.getElementById('qty'+idArea).value;
	            var result = parseInt(qty) * parseFloat(profit);
	            //var result2 = parseFloat(txtFirstNumberValue) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('profit_all'+idArea).value = round;
			    }
			    else
			    {
			    	document.getElementById('profit_all'+idArea).value = '';
			    }

			    var result = parseFloat(txtFirstNumberValue) * 0.12;
	            //var result2 = parseFloat(txtFirstNumberValue) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('vat_price'+idArea).value = round;
			    }
			    else
			    {
			    	document.getElementById('vat_price'+idArea).value = '';
			    }

			    var result = parseFloat(vat) * parseInt(qty);
	            //var result2 = parseFloat(txtFirstNumberValue) * parseFloat(txtThirdNumberValue);
	            if (!isNaN(result)) {
			    	round = (Math.round(result*100)/100).toFixed(2);
			        document.getElementById('total_vat'+idArea).value = round;
			    }
			    else
			    {
			    	document.getElementById('total_vat'+idArea).value = '';
			    }
	}
	/*function edit_sum() {
	            var txtFirstNumberValue = document.getElementById('edit_sell_price').value;
	            var txtSecondNumberValue = document.getElementById('edit_orig_price').value;
	            var txtThirdNumberValue = document.getElementById('edit_qty').value;
	            var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
	            var result2 = parseFloat(txtFirstNumberValue) * parseFloat(txtThirdNumberValue);
	            var round='';
	            if (!isNaN(result)) {
	            	round = (Math.round(result*100)/100).toFixed(2);
	                document.getElementById('edit_profit').value = round;
	            }
	            else
	            {
	            	document.getElementById('edit_profit').value = '';
	            }
	            if (!isNaN(result2)) {
	            	round = (Math.round(result2*100)/100).toFixed(2);
	                document.getElementById('edit_total_price').value = round;
	            }
	            else
	            {
	            	document.getElementById('edit_total_price').value = '';
	            }
	        }*/
	</script>
	<script>
		$(document).ready(function(e){
			$('#search-box').keyup(function(){
					$('#result').show('');
					var txt = $(this).val();
					$.ajax({
						url:"/fetch.php",
						method:"GET",
						data:'search='+txt,
						success:function(data)
						{
							$('#result').html(data);
						}
					});
				});
			});
		/*$(document).ready(function(e){
			$('#search-box').keyup(function(){
					$('#print').show('');
					var txt = $(this).val();
					$.ajax({
						url:"/print.php",
						method:"GET",
						data:'search='+txt,
						success:function(data)
						{
							$('#print').html(data);
						}
					});
				});
			});*/
	</script>
	<script>
		$(document).ready(function(e){
			$('#search-box-add').keyup(function(){
					$('#result').show('');
					var txt = $(this).val();
					$.ajax({
						url:"/fetch-add.php",
						method:"GET",
						data:'search='+txt,
						success:function(data)
						{
							$('#result-add').html(data);
						}
					});
				});
			});
		/*$(document).ready(function(e){
			$('#search-box-add').keyup(function(){
					$('#print').show('');
					var txt = $(this).val();
					$.ajax({
						url:"/print.php",
						method:"GET",
						data:'search='+txt,
						success:function(data)
						{
							$('#print').html(data);
						}
					});
				});
			});*/
	</script>
	<script type="text/javascript">
		function print(areaName) {
			var mywindow = window.open('', 'PRINT', 'height=400,width=600');

		    mywindow.document.write('<!DOCTYPE html><html><head><title>JOVES PHARMACY</title>');
		    mywindow.document.write('</head><style>*{font-design:none; font-size:10px; font-family: Arial;} table{width:100%;} th {text-align:left;}</style><body>');
		
		    if (areaName=="sales_report_print") {
		    	var printto = document.getElementById('printto').value;
		    	var printfrom = document.getElementById('printfrom').value;
		    	if ((printto=='')||(printfrom==''))
		    	{
		    		mywindow.document.write('<hr/><img src="res/sr_header.jpg" style="width:100%;"><hr/>');
		    		//mywindow.document.write('<hr/><h1 style={font-size:30px; text-align:center;}>Sales Report</h1><hr/>');
		    		mywindow.document.write('<table class="table" border="2px" cellspacing="0"><tr><td>Transaction ID</td><td>Transaction Date</td><td>Invoice Number</td><td><center>Description</center></td><td>Amount</td><td>Profit</td></tr><?php include('connection.php'); $query="SELECT * FROM tblsales_report ORDER BY id desc";$get=mysql_query($query);$output=''; while ($row = mysql_fetch_array($get)) { $output .="<tr><td>".$row['trans_id']."</td><td>".$row['date']."</td><td>".$row['invoice']."</td>"; $inv=$row['invoice']; $query_getdes="SELECT * FROM tblproduct_inventory WHERE invoice='$inv'"; $get_getdes=mysql_query($query_getdes); $output.="<td><table border=\'2px\' width=\'100%\'><tr><td>Brand Name</td><td>Generic Name</td></tr>"; while ($row_getdes=mysql_fetch_array($get_getdes)) { $output.="<tr><td>".$row_getdes['brand_name']."</td><td>".$row_getdes['generic_name']."</td></tr>"; } $output.="</table></td>"; $output.="<td>&#8369;".$row['amount']."</td><td>&#8369;".$row['profit']."</td></tr>"; } echo $output; mysql_close();?> </table>');
		    		//mywindow.document.write(document.getElementById('sales_report_result_print').innerHTML);
		    	}
		    	else
		    	{
		    		mywindow.document.write('<hr/><img src="res/sr_header.jpg" style="width:100%;"><hr/>');
		    		//mywindow.document.write('<hr/><h1 style={font-size:30px; text-align:center;}>Sales Report</h1><hr/>');
		    		mywindow.document.write(document.getElementById('sales_report_result_print').innerHTML);
		    	}
		    }
		    else if (areaName=="product_inventory_print") {
		    	var category = document.getElementById('category_find').value;
		    	if (category=='')
		    	{
		    		mywindow.document.write('<hr/><img src="res/ipr_header.jpg" style="width:100%;"><hr/>');
		    		//mywindow.document.write('<hr/><h1 style={font-size:30px; text-align:center;}>Product Inventory</h1><hr/>');
		    		mywindow.document.write('<table class="table" border="2px" cellspacing="0"><tr><td>Invoice</td><td>Date</td><td>Brand Name</td><td>Generic Name</td><td>Category</td><td>Price</td><td>Qty</td><td>Remaining</td><td>Amount</td><td>Profit</td></tr><?php include('connection.php'); $query="SELECT * FROM tblproduct_inventory ORDER BY id desc"; $get=mysql_query($query); $output=''; while ($row = mysql_fetch_array($get)) { $output .="<tr><td>".$row['invoice']."</td><td>".$row['date']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>".$row['price']."</td><td>".$row['qty']."</td><td>".$row['remain_qty']."</td><td>&#8369;".$row['total_amnt']."</td><td>&#8369;".$row['profit']."</td></tr>"; } echo $output; mysql_close(); ?></table>');
			    }
		    	else
		    	{
		    		mywindow.document.write('<hr/><img src="res/sr_header.jpg" style="width:100%;"><hr/>');
		    		//mywindow.document.write('<hr/><h1 style={font-size:30px; text-align:center;}>Sales Report</h1><hr/>');
		    		mywindow.document.write(document.getElementById('product_inventory_search').innerHTML);
		    	}
		    }
		    else if (areaName=="sold_often_chart_print") {
		    	mywindow.document.write('<hr/><img src="res/src_header.jpg" style="width:100%;"><hr/>');
		    	//mywindow.document.write('<hr/><h1 style={font-size:30px; text-align:center;}>Sold Often Chart</h1><hr/>');
		    	mywindow.document.write(document.getElementById(areaName).innerHTML);
		    }

		    mywindow.document.write('</body></html>');

		    mywindow.document.close(); // necessary for IE >= 10
		    mywindow.focus(); // necessary for IE >= 10*/

		    //mywindow.print();
		    //mywindow.close();

		    setTimeout(function() {
			    mywindow.print();
			    mywindow.close();
			}, 20);
		    return true;
		}
		
	</script>
	<script>
	function fetch_sales()
		{
			var printto = document.getElementById('printto').value;
		    var printfrom = document.getElementById('printfrom').value;

			$.ajax({
				type: 'post',
				url: 'selected_print.php',
				data: {
					printto:printto, printfrom:printfrom,
				},
				success: function (response) {
			   // We get the element having id of display_info and put the response inside it
				$( '#sales_report_result_print' ).html(response);
				}
			});
		}

	function fetch_rec_acq()
		{
			var printto = document.getElementById('printto_rec').value;
		    var printfrom = document.getElementById('printfrom_rec').value;

			$.ajax({
				type: 'post',
				url: 'recently_acquired_sortDate.php',
				data: {
					printto:printto, printfrom:printfrom,
				},
				success: function (response) {
			   // We get the element having id of display_info and put the response inside it
				$( '#recently_acquired_date_sort').html(response);
				}
			});
		}

	function fetch_productlist()
		{
			var category = document.getElementById('category_find').value;

			$.ajax({
				type: 'post',
				url: 'category_find.php',
				data: {
					category:category,
				},
				success: function (response) {
			   // We get the element having id of display_info and put the response inside it
				$( '#product_inventory_search').html(response);
				}
			});
		}
	</script>
	<script type="text/javascript">
		setTimeout(function() {
		    $('#notif').fadeOut('slow');
		}, 4000); // <-- time in milliseconds
	</script>
	<script type="text/javascript">
		Highcharts.setOptions({
   global: {
     useUTC: false
   },
   exporting: {
     buttons: {
       contextButton: {
         menuItems: [{
           text: 'Export to PDF',
           onclick: function() {
             this.exportChart({
               type: 'application/pdf'
             });
           }
         }]
       }
     }
   }
 });
	</script>
	<script type="text/javascript">
		function salesReportDate() {
			var dateFrom = document.getElementById(dateFrom).value
			var dateTo = document.getElementById(dateTo).value
			var searchSales = document.getElementById(searchSales).value
			if (test!='') 
			{
				$.ajax({
					type: 'post',
					url: 'fetch-salesreport.php',
					data: {
						dateFrom:test, dateTo:test
					},
					success: function (response) {
				   // We get the element having id of display_info and put the response inside it
					$( '#sales_result' ).html(response);
					}
				});
			}
		    //$("#orders").append(order);
		}
	</script>
</head>
<body>
	<nav class="navbar navbar-light bg-faded" style="background-color: #bd8dbf; border-radius: 0px;">
		<div class="container-fluid">
			
			<ul class="nav navbar-nav navbar-left">
	        	<li><img src="res/logo.png" width="100px"></li>
	        	<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
	        	<li><h6 style="font-family: Times New Roman; font-weight: bold; color: white; font-size: 50px;">JOVES PHARMACY</h6></li>
	        </ul>
	    	<ul class="nav navbar-nav navbar-right">
	        	<li><a class="nav-hover" href="logout.php" style="padding-bottom: 18px; color: white"><h4>Log Out</h4></a></li>
	    	</ul>
    	</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<?php
				include('connection.php');
				$query="SELECT * FROM tblproducts";
				$get=mysql_query($query);
				$low_qty_count=0;
				while ($row=mysql_fetch_array($get)) {
					$product_key = $row['id'];
					$query_low="SELECT * FROM tblproduct_stocks WHERE product_key='$product_key' AND status=''";
					$get_low=mysql_query($query_low) or die(mysql_error());
					$qty_low=0;
					while ($row_low=mysql_fetch_array($get_low)) {
						$qty_low+=$row_low['qty'];
					}
					if ($qty_low<=300) {
						$low_qty_count++;
					}
				}
				if ($low_qty_count>0) {
					//echo $low_qty_count;
					echo '<h5 style="background-color: #FF0033; color: white; padding: 10px;">There are Low in Quantity. Visit Product -> Low in Quantity to View.</h5>';
					if(isset($_SESSION['notification']))
					{
						include('message.php');
					}
				}
				else{
					if(isset($_SESSION['notification']))
					{
						include('message.php');
					}
				}
				$query="SELECT * FROM tblexpired_report WHERE status=''";
				$get=mysql_query($query);
				$count=mysql_num_rows($get);
				if ($count>0)
				{
					echo '<h5 style="background-color: #FF0033; color: white; padding: 10px;">There are Expired Products. Visit Product -> Expired Products to View.</h5>';
				}
				mysql_close();
				?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-2">
				<ul class="nav nav-pills nav-stacked" style="background: rgba(40,38,115,0.2); border-radius: 20px; padding: 10px;">
					<li class="active"><a data-toggle="pill" href="#products">Products</a></li>
					<li><a data-toggle="pill" href="#product_inventory">Product Inventory</a></li>
					<li><a data-toggle="pill" href="#sales">Sales Report</a></li>
					<li><a data-toggle="pill" href="#system_accounts">System Accounts</a></li>
					<li><a data-toggle="pill" href="#activity_logs">Activity Logs</a></li>
				</ul>
			</div>
			<div class="col-sm-10" >
				<div class="tab-content" style="background: rgba(40,38,115,0.2); border-radius: 20px; padding: 30px;">
					<div id="products" class="tab-pane fade in active">
						<div class="row">
							<div class="col-sm-12">
								<h1>Products</h1>
							</div>
						</div>
						<hr/>
						<ul class="nav nav-tabs nav-justified" style="background: rgba(223,255,233,1); border-radius: 20px; padding: 10px;">
							<li class="active"><a data-toggle="tab" href="#list_of_products">List of Products</a></li>
  						    <!--<li><a data-toggle="tab" href="#add_stocks">Add Stocks</a></li>-->
  						    <li><a data-toggle="tab" href="#expired_stocks">Expired Stocks</a></li>
  						    <!--<li><a data-toggle="tab" href="#sold_often">Sold Often</a></li>-->
  							<li><a data-toggle="tab" href="#rec_acq">Recently Acquired</a></li>
  							<li><a data-toggle="tab" href="#low_qty">Low in Quantity</a></li>
						</ul>
						<div class="tab-content">
							<div id="list_of_products" class="tab-pane fade in active">
								<br/>
								<div class="row">
									<form method="POST" action="add_category.php">
										<div class="col-sm-4"><input type="text" name="category" placeholder="Add Category" class="form-control" required></div>
										<div class="col-sm-2"><input type="submit" value="Add" class="btn btn-warning"></div>
									</form>
									<!--<form method="POST" action="delete_category.php">
										<div class="col-sm-4">
											<select class="form-control" name="id" required>
												<option disabled selected>Delete Category</option>
												<?php
												include('connection.php');
												$query="SELECT * FROM tblcategory";
												$get=mysql_query($query);
												while ($row = mysql_fetch_array($get))
												{
													echo "<option value='".$row['id']."'>".$row['category']."</option>";
												}
												mysql_close();
												?>
											</select>
										</div>
										<div class="col-sm-2"><input type="submit" value="Delete" class="btn btn-danger"></div>
									</form>-->
								</div>
								<hr/>
								<div class="row">
									<div class="col-sm-12">
										<h4 class="pull-left">List of Products</h4>
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-sm-12">
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="row">
													<div class="col-sm-6">
														<input type="search" placeholder="Search Product ID, Name, or Category" class="pull-left" id="search-box" name="search-box" size="40">
													</div>
													<div class="col-sm-6">
														<input type="button" data-toggle="modal" data-target="#addproduct" value="Add New Product" class="pull-right" style="border: solid red 3px;">
													</div>
												</div>
											</div>
											<div class="panel-body">
												<div class="row" >
													<div class="col-sm-12" align="center">
														<div id="print" style="display: none;"></div>
														<div class="table-responsive" id="result">
															<table class="table">
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
															<?php 
															include('connection.php');
															$query="SELECT * FROM tblproducts";
															$get=mysql_query($query);
															$output='';
															while ($row = mysql_fetch_array($get)) {
																$id=$row['id'];
																$query_qty="SELECT * FROM tblproduct_stocks WHERE product_key=$id AND status=''";
																$get_qty=mysql_query($query_qty) or die(mysql_error());
																$qty=0;
																while ($row_qty=mysql_fetch_array($get_qty)) {
																	$qty+=$row_qty['qty'];
																}
																$output .="<tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".$row['original_price']."</td><td>&#8369;".$row['selling_price']."</td><td>".$qty."</td><td><button data-toggle='modal' class='btn btn-success' data-target='#product_edit".$id."'>Edit</button></td><td><button data-toggle='modal' class='btn btn-warning' data-target='#product_add".$id."'>Add Stocks</button></td><td><button data-toggle='modal' class='btn btn-danger' data-target='#product_delete".$id."'>Delete</button></td></tr>";
															}
															echo $output;
															mysql_close();
															?>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--<div id="add_stocks" class="tab-pane">
								<br/>
								<div class="row">
									<div class="col-sm-12">
										<h4 class="pull-left">Add Stocks</h4>
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-sm-12">
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="row">
													<div class="col-sm-6">
														<input type="search" placeholder="Search Product ID, Name, or Category" class="pull-left" id="search-box-add" name="search-box" size="40">
													</div>
													<div class="col-sm-6">
														<input type="button" data-toggle="modal" data-target="#addproduct" value="Add New Product" class="pull-right" style="border: solid red 3px;">
													</div>
												</div>
											</div>
											<div class="panel-body">
												<div class="row" >
													<div class="col-sm-12" align="center">
														<div id="print" style="display: none;"></div>
														<div class="table-responsive" id="result-add">
															<table class="table">
																<thead>
																	<tr>
																		<th>Product ID</th>
																		<th>Brand Name</th>
																		<th>Generic name</th>
																		<th>Category</th>
																		<th>Original Price</th>
																		<th>Selling Price</th>
																		<th>Quantity</th>
																		<th colspan="2" style="text-align: center;">Add</th>
																	</tr>
																</thead>
																<?php 
																/*include('connection.php');
																$query="SELECT * FROM tblproducts";
																$get=mysql_query($query);
																$output='';
																while ($row = mysql_fetch_array($get)) {
																	$id=$row['id'];
																	$output .="<form method='POST' action='add_stock_process.php'><tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".$row['original_price']."</td><td>&#8369;".$row['selling_price']."</td><td>".$row['qty']."</td><td><input type='text' name='id' value=".$id." style='display:none;'><input type='number' name='stocks' size='1' required><input type='submit' value='Add'></td></tr></form>";
																}
																echo $output;
																mysql_close();*/
																?>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>-->
							<div id="expired_stocks" class="tab-pane fade">
								<br/>
								<div class="row">
									<div class="col-sm-12">
										<h4 class="pull-left">Expired Products</h4>
									</div>	
								</div>
								<hr/>
								<!--<div class="row">
									<div class="col-sm-12">
										<h6>Add Expired Products</h6>
									</div>
								</div>
								<form method="POST" action="add_expired_qty.php">
									<div class="row">
										<div class="col-sm-6">
											<select class="form-control" name="id" placeholder="Add Expired Products">
												<?php
												include('connection.php');
												$query="SELECT * FROM tblproducts";
												$get=mysql_query($query);
												while ($row=mysql_fetch_array($get))
												{
													echo "<option value='".$row['id']."'>".$row['barcode']." ".$row['brand_name']." ".$row['generic_name']."</option>";
												}
												mysql_close();
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<input name="expired_qty" type="number" class="form-control" placeholder="Expired Stocks" required>
										</div>
										<div class="col-sm-2">
											<input type="submit" class="form-control btn btn-danger">
										</div>
									</div>
								</form>
								<hr/>-->
								<div class="row">
									<div class="col-sm-12">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="row" >
													<div class="col-sm-12" align="center">
														<div class="table-responsive">
															<table class="table table bordered">
																<tr>
																	<th>Product ID</th>
																	<th>Brand Name</th>
																	<th>Generic name</th>
																	<th>Category</th>
																	<th>Expired Quantity</th>
																	<th>Date Expired</th>
																	<th></th>
																</tr>
																	<?php
																	include('connection.php');
																	$query="SELECT * FROM tblexpired_report WHERE status='' ORDER BY id desc";
																	$get=mysql_query($query);
																	$output='';
																	while ($row = mysql_fetch_array($get)) {
																		$id=$row['id'];
																		$output .="<form class='form-group' method='GET'><tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>".$row['expired_qty']."</td><td>".$row['date']."</td><td><a href='remove_expiry.php?id=".$id."&ref=".$row['product_stocks_id']."'><input type='button' value='Remove'></td></tr></form>";
																	}
																	echo $output;
																	mysql_close();
																	?>
																
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<h4 class="pull-left">Expired Products Log</h4>
									</div>	
								</div>
								<hr/>
								<div class="row">
										<div class="col-sm-12">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="row" >
														<div class="col-sm-12" align="center">
															<div class="table-responsive">
																<table class="table table bordered">
																	<tr>
																		<th>Product ID</th>
																		<th>Brand Name</th>
																		<th>Generic name</th>
																		<th>Category</th>
																		<th>Expired Quantity</th>
																		<th>Date Expired</th>
																	</tr>
																		<?php
																		include('connection.php');
																		$query="SELECT * FROM tblexpired_report WHERE status='removed' ORDER BY id desc";
																		$get=mysql_query($query);
																		$output='';
																		while ($row = mysql_fetch_array($get)) {
																			$id=$row['id'];
																			$output .="<form class='form-group' method='GET'><tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>".$row['expired_qty']."</td><td>".$row['date']."</td></tr></form>";
																		}
																		echo $output;
																		mysql_close();
																		?>
																	
																</table>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
							</div>
							
							<!--<div id="sold_often" class="tab-pane fade">
								
							</div>-->
							<div id="rec_acq" class="tab-pane fade">
								<br/>
								<div class="row">
									<div class="col-sm-12">
										<h4 class="pull-left">Recently Acquired</h4>
										<!--<button class="btn btn-warning pull-right" onclick="print('recently_acquired_print');">Print</button>-->
									</div>	
								</div>
								<hr/>
								<div class="row">
									<form class="form-group">
										<div class="col-sm-4">
											<span>From: </span>
											<input type="date" id="printfrom_rec" class="form-control" placeholder="to">
										</div>
										<div class="col-sm-4">
											<span>To: </span>
											<input type="date" id="printto_rec" class="form-control">
										</div>
										<div class="col-sm-4">
											<label></label><br/>
											<button class="btn btn-default" onclick="fetch_rec_acq();" class="form-control" type="button">Search</button>
											<!--<button class="btn btn-warning pull-right" onclick="print('product_inventory_print')" class="form-control" type="button">Print</button>-->
										</div>
									</form>
								</div>
								<hr/>
								<br/>
								<div class="row">
									<div class="col-sm-12">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="row" >
													<div class="col-sm-12" align="center">
														<div class="table-responsive" id="recently_acquired_date_sort">
															<table class="table table bordered">
																<tr>
																	<th>Product ID</th>
																	<th>Brand Name</th>
																	<th>Generic name</th>
																	<th>Category</th>
																	<th>Original Price</th>
																	<th>Selling Price</th>
																	<th>Quantity</th>
																	<th>Date Added</th>
																</tr>
																<tr>
																	<?php
																	include('connection.php');
																	$query="SELECT * FROM tblproduct_stocks ORDER BY id desc limit 20";
																	$get=mysql_query($query);
																	$output='';
																	while ($row = mysql_fetch_array($get)) {
																		$id=$row['id'];
																		$product_key=$row['product_key'];
																		$query_arrival="SELECT * FROM tblproducts WHERE id=$product_key";
																		$get_arrival=mysql_query($query_arrival);
																		while ($row_arrival=mysql_fetch_array($get_arrival)) {
																			$output .="<tr><td>".$row_arrival['barcode']."</td><td>".$row_arrival['brand_name']."</td><td>".$row_arrival['generic_name']."</td><td>".$row_arrival['category']."</td><td>&#8369;".$row_arrival['original_price']."</td><td>&#8369;".$row_arrival['selling_price']."</td><td>".$row['qty']."</td><td>".$row['arrival_date']."</td></tr>";
																		}
																	}
																	echo $output;
																	mysql_close();
																	?>
																</tr>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="low_qty" class="tab-pane fade">
								<br/>
								<div class="row">
									<div class="col-sm-12">
										<?php include('low_qty_graph.php'); ?>
									</div>	
								</div>
								<br/>
							</div>
						</div>
					</div>
					<div id="sales" class="tab-pane fade">
						<div class="row">
							<div class="col-sm-12">
								<h1>Sales Report</h1>
							</div>
						</div>
						<hr/>
						<ul class="nav nav-tabs nav-justified" style="background: rgba(223,255,233,1); border-radius: 20px; padding: 10px;">
							<li class="active"><a data-toggle="tab" href="#sold_often">Sold Often</a></li>
  						    <li><a data-toggle="tab" href="#sales_report">Sales Report</a></li>
						</ul>
						
						<div class="tab-content" style="background: rgba(40,38,115,0.2); border-radius: 20px; padding: 30px;">
							<div id="sales_report" class="tab-pane">
								<div class="row">
									<form class="form-group">
									<div class="col-sm-4">
										<span>From: </span>
										<input type="date" id="printfrom" class="form-control" placeholder="to">
									</div>
									<div class="col-sm-4">
										<span>To: </span>
										<input type="date" id="printto" class="form-control">
									</div>
									<div class="col-sm-4">
										<label></label><br/>
										<button class="btn btn-default" onclick="fetch_sales();" class="form-control" type="button">Search</button>
										<button class="btn btn-warning pull-right" onclick="print('sales_report_print');" class="form-control" type="button">Print</button>
									</div>
									</form>
								</div>
								<hr/>
								<!--<div class="row">
									<div class="col-sm-12">
										<form>
											<button class="btn btn-warning pull-right" onclick="print('sales_report_print');">Print</button>
											<button class="btn btn-warning pull-right">Print</button>
										</form>
									</div>
								</div>-->
								<br/>
								<div class="row">
									<div class="col-sm-12">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="row" >
													<div class="col-sm-12" align="center">
														<div class="table-responsive" id="sales_report_result_print">
															<table class="table table-bordered" id="table_print">
																<tr>
																	<td>Transaction ID</td>
																	<td>Transaction Date</td>
																	<td>Invoice Number</td>
																	<td><center>Description</center></td>
																	<td>Amount</td>
																	<td>Profit</td>
																</tr>
																<tr>
																	<?php
																		include('connection.php');
																		$query="SELECT * FROM tblsales_report ORDER BY id desc";
																		$get=mysql_query($query);
																		$output='';
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
																		mysql_close();
																	?>
																</tr>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="sold_often" class="tab-pane fade in active">
								<br/>
									<div class="row">
										<div class="col-sm-12">
											<form>
												<button type="button" class="btn btn-warning pull-right" onclick="print('sold_often_chart_print');">Print</button>
												<!--<button class="btn btn-warning pull-right">Print</button>-->
											</form>
										</div>
									</div>
									<br/>
									<div class="row">
										<div class="col-sm-12">
											<div id="sold_often_chart_print">
												<?php include('sold_often_chart.php'); ?>
											</div>
										</div>	
									</div>
								<br/>
							</div>
						</div>
					</div>
					<div id="product_inventory" class="tab-pane fade">
						<div class="row">
							<div class="col-sm-12">
								<h1>Product Inventory</h1>
							</div>
						</div>
						<div class="row">
							<form class="form-group">
								<div class="col-sm-4">
									<span>Select Category:</span>
									<select class="form-control" name="id" required id="category_find">
										<option value=""></option>
										<?php
										include('connection.php');
										$query="SELECT * FROM tblcategory";
										$get=mysql_query($query);
										while ($row = mysql_fetch_array($get))
										{
											echo "<option value='".$row['category']."'>".$row['category']."</option>";
										}
										mysql_close();
										?>
									</select>
								</div>
								<div class="col-sm-8">
									<label></label><br/>
									<button class="btn btn-default" onclick="fetch_productlist();" class="form-control" type="button">Search</button>
									<button class="btn btn-warning pull-right" onclick="print('product_inventory_print')" class="form-control" type="button">Print</button>
								</div>
							</form>
						</div>
						<hr/>
						<!--<div class="row">
							<div class="col-sm-12">
								<form>
									<button type="button" class="btn btn-warning pull-right" onclick="print('product_inventory_print');">Print</button>
								</form>
							</div>
						</div>-->
						<br/>
						<div class="row">
							<div class="col-sm-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="row" >
											<div class="col-sm-12" align="center">
												<div class="table-responsive" id="product_inventory_search">
													<table class="table table-bordered">
														<tr>
															<td>Invoice Number</td>
															<td>Date</td>
															<td>Brand Name</td>
															<td>Generic Name</td>
															<td>Category</td>
															<td>Price</td>
															<td>Qty</td>
															<td>Remaining</td>
															<td>Amount</td>
															<td>Profit</td>
														</tr>
														<tr>
															<?php
																include('connection.php');
																$query="SELECT * FROM tblproduct_inventory ORDER BY id desc";
																$get=mysql_query($query);
																$output='';
																while ($row = mysql_fetch_array($get)) {
																	$output .="<tr><td>".$row['invoice']."</td><td>".$row['date']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".$row['price']."</td><td>".$row['qty']."</td><td>".$row['remain_qty']."</td><td>&#8369;".$row['total_amnt']."</td><td>&#8369;".$row['profit']."</td></tr>";
																}
																echo $output;
																mysql_close();
															?>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="activity_logs">
						<div class="row">
							<div class="col-sm-12">
							<h1>Activity Logs</h1>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-sm-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="row" >
											<div class="col-sm-12" align="center">
												<div class="table-responsive">
													<table class="table table bordered">
														<tr>
															<th>Activity ID</th>
															<th>Date - Year/Month/Day</th>
															<th>Activity</th>
														</tr>											
														<?php
														include('connection.php');
														$query="SELECT * FROM tblactivity_log ORDER BY id desc";
														$get=mysql_query($query);
														while ($row=mysql_fetch_array($get)) {
															$activity_id=$row['activity_id'];
															$activity_details=$row['activity'];
															$activity_date=$row['activity_date'];
															echo "<tr><td>".$activity_id."</td><td>".$activity_date."</td><td>".$activity_details."</td></tr>";
														}
														mysql_close();
														?>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="system_accounts">
						<div class="row">
							<div class="col-sm-12">
							<h1>System Accounts</h1>
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-sm-12"><h6>Add Users</h6></div>
						</div>
						<div class="row">
							<form method="POST" action="add_account_process.php">
								<div class="col-sm-3"><input type="text" name="user_name" class="form-control" placeholder="Username"></div>
								<div class="col-sm-3"><input type="password" name="pw" class="form-control" placeholder="Password"></div>
								<div class="col-sm-2">
									<select class="form-control" name="role">
										<option value="Admin">Admin</option>
										<option value="Cashier">Cashier</option>
									</select>
								</div>
								<div class="col-sm-2">
									<input type="submit" value="Add" class="btn btn-default">
								</div>
							</form>
						</div>
						<hr/>
						<div class="row">
							<div class="col-sm-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="row" >
											<div class="col-sm-12" align="center">
												<div class="table-responsive">
													<table class="table table bordered">
														<tr>
															<th>User Name</th>
															<th>Password</th>
															<th>Role</th>
															<th colspan="2" style="text-align: center;">Options</th>
														</tr>
														<form method="POST">
														<?php
														include('connection.php');
														$query="SELECT * FROM system_accounts";
														$get=mysql_query($query);
														while ($row=mysql_fetch_array($get)) {
															if ($row['user_name']=="admin")
															{
																$status = "disabled";
															}
															else
															{
																$status = "";
															}
															$id = $row['id'];
															echo "<tr><td>".$row['user_name']."</td><td>********</td><td>".$row['role']."</td><td><input type='button' value='Edit' data-toggle='modal' data-target='#edit_account".$id."' class='form-control'</td><td><input type='button' value='Delete' data-toggle='modal' data-target='#delete_account".$id."'".$status." class='form-control'></td></tr>";
														}
														mysql_close();
														?>
														</form>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- MODAL -->
<!-- MODAL FOR ADD PRODUCT -->
<div class="modal fade" id="addproduct" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>New Product</h4>
			</div>
			<form action="add_product_process.php" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<h6>Product ID</h6>
							<input type="text" name="barcode" class="form-control" required>
						</div>
						<div class="col-sm-6">
							<h6>Brand Name</h6>
							<input type="text" name="brand_name" class="form-control" required>
						</div>
						<div class="col-sm-6">
							<h6>Generic Name</h6>
							<input type="text" name="generic_name" class="form-control" required>
						</div>
						<div class="col-sm-6">
							<h6>Category</h6>
							<select class="form-control" name="category" required>
								<?php
								include('connection.php');
								$query="SELECT * FROM tblcategory";
								$get=mysql_query($query);
								while ($row = mysql_fetch_array($get))
								{
									echo "<option value=".$row['category'].">".$row['category']."</option>";
								}
								?>
							</select>
						</div>
						<div class="col-sm-6">
							<h6>Arrival Date</h6>
							<input type="date" name="arrival_date" class="form-control" required>
						</div>
						<div class="col-sm-6">
							<h6>Expiration Date</h6>
							<input type="date" name="expiration_date" class="form-control" required>
						</div>
					</div>
					<hr/>       
					<div class="row">
						<div class="col-sm-3">
							<h6>Original Price</h6>
							<input type="number" name="original_price" class="form-control" id="orig_price" onkeyup="sum()" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Selling Price</h6>
							<input type="number" name="selling_price" class="form-control" id="sell_price" onkeyup="sum()" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>VAT Price</h6>
							<input type="number" name="vat_price" class="form-control" id="vat_price" readonly onkeyup="sum()" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Quantity</h6>
							<input type="number" name="qty" class="form-control" id="qty" onkeyup="sum()" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Total Price (With VAT)</h6>
							<input type="number" name="total_price" class="form-control" readonly id="total_price" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Profit Per Piece</h6>
							<input type="number" name="profit_per_piece" class="form-control" readonly id="profit" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Total Profit</h6>
							<input type="number" name="profit_all_qty" class="form-control" readonly id="profit_all" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Total VAT</h6>
							<input type="number" name="total_vat" class="form-control" readonly id="total_vat" required step="0.01">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" name="Submit" value="Add" class="btn btn-default">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- END OF MODAL FOR ADD PRODUCT -->	
<!-- MODAL FOR EDIT / DELETE PRODUCT / ADD STOCKS -->	
<?php
include('connection.php');
$query="SELECT * FROM tblproducts";
$get=mysql_query($query);
while ($row=mysql_fetch_array($get)) {
	$id=$row['id'];
	
	$barcode=$row['barcode'];
	$brand_name=$row['brand_name'];
	$generic_name=$row['generic_name'];
	$category=$row['category'];
	//$arrival_date=$row['arrival_date'];
	$original_price=$row['original_price'];
	$selling_price=$row['selling_price'];
	//$qty=$row['qty'];
	$vat_price=$row['vat_price'];
	$profit_all_qty=$row['profit_all_qty'];
	$total_vat=$row['total_vat'];
	$query_qty="SELECT * FROM tblproduct_stocks WHERE product_key=$id AND status=''";
	$get_qty=mysql_query($query_qty) or die(mysql_error());
	$qty=0;
	while ($row_qty=mysql_fetch_array($get_qty)) {
		$qty+=$row_qty['qty'];
	}

	$total_price=$row['total_price'];
	$profit_per_piece=$row['profit_per_piece'];
	include('edit_modal.php');
	include('delete_modal.php');
	include('add_stock_modal.php');
}
?>
<!-- END MODAL FOR EDIT / DELETE PRODUCT  / ADD STOCKS -->
<!-- MODAL FOR EDIT / DELETE ACCOUNT -->	
<?php
include('connection.php');
$query="SELECT * FROM system_accounts";
$get=mysql_query($query);
while ($row=mysql_fetch_array($get)) {
	$id=$row['id'];
	$user_name=$row['user_name'];
	$pw=$row['pw'];
	$role=$row['role'];
	include('edit_account_modal.php');
	include('delete_account_modal.php');
}
?>

<!-- END MODAL FOR EDIT / DELETE PRODUCT -->
<!-- END OF MODAL -->
</body>
</html>