<?php
session_start();
if (!isset($_SESSION['user']))
{
	header("Location:/login.php");
}
else
{
	if ($_SESSION['role']=="Admin")
	{
    	header("Location:index.php");
 	}
}

include("../connection.php"); 
$table = mysql_real_escape_string($_SESSION['user']."_order_slip");
$query = "SELECT * FROM $table LIMIT 1";
$get = mysql_query($query);
if ($get==FALSE)
{
	$query = "CREATE TABLE $table (id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT, product_id VARCHAR(30) NOT NULL, qty VARCHAR(30) NOT NULL)";
	mysql_query($query);
}
else
{
	$query = "DELETE FROM $table";
	mysql_query($query);
}
mysql_close();
?>
	
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pharmacy POS</title>
	<link rel="shortcut icon" type="images/png" href="../res/logo.png">
	<link rel="stylesheet" type="text/css" href="../assets/bootstrap3/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/bootstrap3/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="../assets/jquery3.2.min.js"></script>
	<script type="text/javascript" src="../assets/highcharts.js"></script>
	<script type="text/javascript" src="../assets/exporting.js"></script>
	<script type="text/javascript" src="../assets/bootstrap3/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/bootstrap3/js/npm.js"></script>
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
		background: url('../res/bg-pattern.png');
	}
	</style>
	<script>
		function addOrder(ref_id,id) {
			var qty = document.getElementById(ref_id).value
		    //$("#orders").append(order);
		    $.ajax({
				type: 'post',
				url: 'order_slip.php',
				data: {
					id:id,
					qty:qty
				},
				success: function (response) {
			   // We get the element having id of display_info and put the response inside it
				$( '#orders' ).html(response);
				}
			});
		}
		function delOrder(id) {
		    //$("#orders").append(order);
		    $.ajax({
				type: 'post',
				url: 'delete_order.php',
				data: {
					id:id,
				},
				success: function (response) {
			   // We get the element having id of display_info and put the response inside it
				$( '#orders' ).html(response);
				}
			});
		}
		function OrderList() {
		    //$("#orders").append(order);
		    $.ajax({
				url: 'fetch_orderlist.php',
				success: function (response) {
			   // We get the element having id of display_info and put the response inside it
				$( '#orderlist' ).html(response);
				}
			});
			$.ajax({
				url: 'fetch_orderamnt.php',
				success: function (response) {
			   // We get the element having id of display_info and put the response inside it
				$( '#orderamnt' ).html(response);
				}
			});
		}
		function sum() {
            var txtFirstNumberValue = document.getElementById('payment').value;
            var txtSecondNumberValue = document.getElementById('finaltotal').value;
            var result = parseFloat(txtFirstNumberValue) - parseFloat(txtSecondNumberValue);
            if (!isNaN(result)) {
		    	round = (Math.round(result*100)/100).toFixed(2);
		        document.getElementById('change').value = round;
		        document.getElementById('change_2').value = round;
		    }
		    else
		    {
		    	document.getElementById('change').value = '';
		    	document.getElementById('change_2').value = '';
		    }
        }
		/*$(document).ready(function(e){
			$('#customers_name').keyup(function(){
					//$('#print').show('');
					var name = $(this).val();
					$("#getName").html("<input type='text' value='"+name+"' name='customers_name' style='display:none;'>");
				});
			});*/
	</script>
	<script>
		$(document).ready(function(e){
			$('#search-box').keyup(function(){
					$('#result').show('');
					var txt = $(this).val();
					$.ajax({
						url:"fetch.php",
						method:"GET",
						data:'search='+txt,
						success:function(data)
						{
							$('#result').html(data);
						}
					});
				});
			});
	</script>
	<script type="text/javascript">
		setTimeout(function() {
		    $('#notif').fadeOut('slow');
		}, 4000); // <-- time in milliseconds
	</script>
</head>
<body>
	<nav class="navbar navbar-light bg-faded" style="background-color: #bd8dbf; border-radius: 0px;">
		<div class="container-fluid">
			
			<ul class="nav navbar-nav navbar-left">
	        	<li><img src="../res/logo.png" width="100px"></li>
	        	<li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</li>
	        	<li><h6 style="font-family: Times New Roman; font-weight: bold; color: white; font-size: 50px;">JOVES PHARMACY</h6></li>
	        </ul>
	    	<ul class="nav navbar-nav navbar-right">
	        	<li><a class="nav-hover" href="../logout.php" style="padding-bottom: 18px; color: white"><h4>Log Out</h4></a></li>
	    	</ul>
    	</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<?php
					if(isset($_SESSION['notification']))
					{
						include('../message.php');
					}
				?>
			</div>
		</div>
		<!--<div class="row">
			<div class="col-sm-7">
				<input type="text" placeholder="Customer's Name" id="customers_name" class="form-control">
			</div>
		</div>
		<br/>-->
		<div class="row" style="padding: 10px;">
			<div class="col-sm-7" style="background: rgba(40,38,115,0.2); border-radius: 20px; padding: 20px;">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-sm-6">
								<input type="search" placeholder="Search Barcode, Name, or Category" class="pull-left" id="search-box" name="search-box" size="40">
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
											<th>Price</th>
											<th>Qty</th>
											<th colspan="2" style="text-align: center;"></th>
										</tr>
									</thead>
									<?php 
									include('../connection.php');
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

										$output .="<tr><td>".$row['barcode']."</td><td>".$row['brand_name']."</td><td>".$row['generic_name']."</td><td>".$row['category']."</td><td>&#8369;".($row['selling_price']+$row['vat_price'])."</td><td>".$qty."</td><td><input type='number' placeholder='QTY' class='form-control' id='id".$id."'></td><td><button class='btn btn-danger' onclick='addOrder(\"id".$id."\",\"".$id."\")'>Add</button></td></tr>";
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
			<div class="col-sm-5">
				<div class="row"style="background: rgba(255,192,250,0.5); border-radius: 20px; padding: 20px;">
					<div class="col-sm-12"><h4 align="center">Order Slip</h4></div>
					<div class="col-sm-12">
						<table id="orders" class="table table-bordered">
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ordermodal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Order List</h4>
			</div>
			<form method="POST" action='process_order.php' id="form">
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6">
							<!--<h4>Order List</h4>-->
							<br/>
							<table class="table table-responsive table-bordered" id="orderlist">
							</table>
						</div>
						<div class="col-sm-6">
							<!--<input type="text" placeholder="Customer's Name" class="form-control" name="customers_name">-->
							<br/>
							<table class="table table-responsive table-bordered" id="orderamnt">
							</table>
							<br/>
							<div class="row">
								<div class="col-sm-6">
									<label>Payment</label>
									<input type="number" placeholder="Payment" class="form-control" id="payment" onkeyup="sum()" required name="payment" step="0.01">
								</div>
								<div class="col-sm-6">
									<label>Change</label>
									<input type="number" placeholder="Change" class="form-control" id="change" disabled step="0.01">
									<input type="number" placeholder="Change" class="form-control" id="change_2" name="change" step="0.01" style="display: none;">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-danger" type="submit" value="Submit">
				<button class="btn btn-default" class="close" data-dismiss="modal">Cancel</button>
			</div>
			</form>
		</div>
	</div>
</div>
</body>