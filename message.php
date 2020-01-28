<div class="row" id="notif">
	<div class="col-sm-12">
		<?php
		if ($_SESSION['status']=='SUCCESS') {
			echo '<h5 style="background-color: lightgreen; color: black; padding: 10px;" class="collapse show" id="notifcollapse">'.$_SESSION['notification'].'</h5>';
		}
		elseif ($_SESSION['status']=='FAILED') {
			echo '<h5 style="background-color: #ff5454; color: white; padding: 10px;">'.$_SESSION['notification'].'</h5>';	
		}
		?>
	</div>
</div>

<?php
unset($_SESSION['notification']);
unset($_SESSION['status']);
?>