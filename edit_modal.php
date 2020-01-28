<div class="modal fade" id="product_edit<?php echo $id;?>" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Edit Product</h4>
			</div>
			<form action="edit_process.php?id=<?php echo $id;?>" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<h6>Product ID</h6>
							<input type="text" name="barcode" class="form-control" value="<?php echo $barcode;?>" required>
						</div>
						<div class="col-sm-6">
							<h6>Brand Name</h6>
							<input type="text" name="brand_name" class="form-control" value="<?php echo $brand_name;?>" required>
						</div>
						<div class="col-sm-6">
							<h6>Generic Name</h6>
							<input type="text" name="generic_name" class="form-control" value="<?php echo $generic_name;?>" required>
						</div>
						<div class="col-sm-6">
							<h6>Category</h6>
							<select class="form-control" name="category" required>
								<?php
								include('connection.php');
								$query_edit="SELECT * FROM tblcategory";
								$get_edit=mysql_query($query_edit);
								while ($row = mysql_fetch_array($get_edit))
								{
									echo "<option value=".$row['category'].">".$row['category']."</option>";
								}
								mysql_close();
								?>
							</select>
						</div>
						<!--<div class="col-sm-12">
							<h6>Arrival Date</h6>
							<input type="date" name="arrival_date" class="form-control" value="<?php //echo $arrival_date;?>" required>
						</div>-->
					</div>
					<hr/>     
					<div class="row">
						<div class="col-sm-3">
							<h6>Original Price</h6>
							<input type="number" name="original_price" class="form-control" id="orig_price<?php echo $id;?>" onkeyup="editsum('<?php echo $id;?>')" value="<?php echo $original_price;?>" required>
						</div>
						<div class="col-sm-3">
							<h6>Selling Price</h6>
							<input type="number" name="selling_price" class="form-control" id="sell_price<?php echo $id;?>" onkeyup="edit_sum('<?php echo $id;?>')" value="<?php echo $selling_price;?>" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>VAT Price</h6>
							<input type="number" name="vat_price" class="form-control" id="vat_price<?php echo $id;?>" readonly onkeyup="edit_sum('<?php echo $id;?>')" value="<?php echo $vat_price;?>" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Quantity</h6>
							<input type="number" name="qty" class="form-control" id="qty<?php echo $id;?>" readonly onkeyup="edit_sum('<?php echo $id;?>')" value="<?php echo $qty;?>" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Total Price (with VAT)</h6>
							<input type="number" name="total_price" class="form-control" readonly id="total_price<?php echo $id;?>" value="<?php echo $total_price;?>" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Profit (Per Piece)</h6>
							<input type="number" name="profit_per_piece" class="form-control" readonly id="profit<?php echo $id;?>" value="<?php echo $profit_per_piece;?>" required step="0.01">
						</div>
						<div class="col-sm-3">
							<h6>Total Profit</h6>
							<input type="number" name="profit_all_qty" class="form-control" readonly id="profit_all<?php echo $id;?>" required step="0.01" value="<?php echo $profit_all_qty;?>">
						</div>
						<div class="col-sm-3">
							<h6>Total VAT</h6>
							<input type="number" name="total_vat" class="form-control" readonly id="total_vat<?php echo $id;?>" required step="0.01" value="<?php echo $total_vat;?>">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" value="Update" class="btn btn-default">
				</div>
			</form>
		</div>
	</div>
</div>