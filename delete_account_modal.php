<div class="modal fade" id="delete_account<?php echo $id;?>" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Delete Product</h4>
			</div>
			<form method="POST" action='delete_account_process.php?id=<?php echo $id;?>'>
				<div class="modal-body">
					<center><h4>Delete this account from list?</h4></center>
					<hr/>
					<h4>System Account Information</h4>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Username</th>
								<th>role</th>
							</tr>
						</thead>
						<tr>
							<td><?php echo $user_name; ?></td>
							<td><?php echo $role; ?></td>
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