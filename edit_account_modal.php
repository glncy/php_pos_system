<script type="text/javascript">
	function verify<?php echo $id;?>(){
		var pw = document.getElementById('pw<?php echo $id;?>').value;
		var confirm_pw = document.getElementById('confirm_pw<?php echo $id;?>').value;
		var x = document.getElementById('error<?php echo $id;?>');
		x.style.display = 'none';
		if (pw==confirm_pw)
		{
			document.getElementById('submit<?php echo $id;?>').disabled=false;
			x.style.display = 'none';
		}
		else if (confirm_pw==""){
			x.style.display = 'none';
			document.getElementById('submit<?php echo $id;?>').disabled=true;
		}
		else
		{
			document.getElementById('submit<?php echo $id;?>').disabled=true;
			x.style.display = 'block';
		}
	}
</script>

<script type="text/javascript">
		
</script>

<div class="modal fade" id="edit_account<?php echo $id;?>" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Edit Account</h4>
			</div>
			<form action="edit_account_process.php?id=<?php echo $id;?>" method="POST">
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<h6>Account Role</h6>
							<?php 
								if ($user_name=="admin"){
									$status="disabled"; 
								}
								else
								{
									$status="";
								}
							?>
							<select name="role" class="form-control">
								<?php
								if ($role=='Admin')
								{
									echo "<option value='Admin' selected='selected'>Admin</option><option value='Cashier'".$status.">Cashier</option>";
								}
								else
								{
									echo "<option value='Admin'>Admin</option><option value='Cashier' selected='selected'>Cashier</option>";
								}
								?>
							</select>
						</div>
						<div class="col-sm-12">
							<h6>Username</h6>
							<input type="text" name="user_name" class="form-control" value="<?php echo $user_name ?>" disabled>
						</div>
						<div class="col-sm-12">
							<h6>Password</h6>
							<input type="password" name="pw" class="form-control" value="<?php echo $pw; ?>" id="pw<?php echo $id;?>">
						</div>
						<div class="col-sm-12">
							<h6>Confirm Password</h6>
							<input type="password" name="confirm_pw" class="form-control" id="confirm_pw<?php echo $id;?>" onkeyup="verify<?php echo $id;?>()">
						</div>
						<div class="col-sm-12" id="error<?php echo $id;?>" style="display: none;">
							<h6 style="background-color: #ff6d66;padding: 10px;">Mismatch Password</h6>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" value="Update" class="btn btn-default" id="submit<?php echo $id;?>" disabled>
				</div>
			</form>
		</div>
	</div>
</div>