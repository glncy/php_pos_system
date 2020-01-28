<div class="modal fade" id="product_add<?php echo $id;?>" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Add Product Stocks</h4>
			</div>
			<form method="POST" action='add_stock_process.php?id=<?php echo $id;?>'>
				<div class="modal-body">
					<h4>Product Info</h4>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Product ID</th>
								<th>Brand Name</th>
								<th>Generic name</th>
								<th>Category</th>
							</tr>
						</thead>
						<tr>
							<td><?php echo $barcode; ?></td>
							<td><?php echo $brand_name; ?></td>
							<td><?php echo $generic_name; ?></td>
							<td><?php echo $category; ?></td>
						</tr>
					</table>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Qty</th>
								<th>Arrival Date</th>
								<th>Expiration Date</th>
							</tr>
						</thead>
						<?php
						include('connection.php');
						$out = '';
						$query_details="SELECT * FROM tblproduct_stocks WHERE product_key='$id' ORDER BY id DESC";
						$get_details=mysql_query($query_details)or die(mysql_error());
						while ($row_details=mysql_fetch_array($get_details)) {
							$out.='<tr>
										<td>'.$row_details['qty'].'</td>
										<td>'.$row_details['arrival_date'].'</td>
										<td>'.$row_details['expiry_date'].'</td>
									</tr>';
						}
						echo $out;
						//mysql_close();
						?>
					</table>
					<div class="row">
						<div class="col-sm-4">
							<h6>Stocks</h6>
							<input type="number" name="qty" required class="form-control">
						</div>
						<div class="col-sm-4">
							<h6>Arrival Date</h6>
							<input type="date" name="arrival_date" class="form-control" required>
						</div>
						<div class="col-sm-4">
							<h6>Expiration Date</h6>
							<input type="date" name="expiration_date" class="form-control" required>
						</div>
					</div>
				</div>
			<div class="modal-footer">
				<input class="btn btn-danger" type="submit" value="Add">
			</div>
			</form>
		</div>
	</div>
</div>