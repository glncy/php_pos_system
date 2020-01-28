<div class="modal fade" id="product_delete<?php echo $id;?>" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Delete Product</h4>
			</div>
			<form method="POST" action='delete_process.php?id=<?php echo $id;?>'>
				<div class="modal-body">
					<center><h4>Delete this product from list?</h4></center>
					<hr/>
					<h4>Product Info</h4>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Product ID</th>
								<th>Brand Name</th>
								<th>Generic name</th>
								<th>Category</th>
								<th>Original Price</th>
								<th>Selling Price</th>
								<th>Quantity</th>
							</tr>
						</thead>
						<tr>
							<td><?php echo $barcode; ?></td>
							<td><?php echo $brand_name; ?></td>
							<td><?php echo $generic_name; ?></td>
							<td><?php echo $category; ?></td>
							<td><?php echo $original_price; ?></td>
							<td><?php echo $selling_price; ?></td>
							<td><?php echo $qty; ?></td>
						</tr>
					</table>
				</div>
			
			<div class="modal-footer">
				<input class="btn btn-danger" type="submit" value="Yes">
				<button class="btn btn-default" class="close" data-dismiss="modal">No</button>
			</div>
			</form>
		</div>
	</div>
</div>