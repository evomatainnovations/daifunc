<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col scroll-auto" style="overflow: auto;">
			<table class="general_table" style="width: 100%;">
				<thead>
					<tr>
						<th>Txn No</th>
						<th>Date</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
						for ($i=0; $i < count($invoice) ; $i++) { 
							if($invoice[$i]->iextein_status == "paid") {
								echo '<tr style="color: #009933;" class="tbl_view" id="'.$invoice[$i]->iextein_id.'">';
								echo '<td>'.$invoice[$i]->iextein_txn_id.'</td>';
								echo '<td>'.$invoice[$i]->iextein_txn_date.'</td>';
								echo '<td>'.$invoice[$i]->iextein_amount.'</td>';
								echo '</tr>';
							} else {
								echo '<tr style="color: #e60000;" class="tbl_view" id="'.$invoice[$i]->iextein_id.'">';
								echo '<td>'.$invoice[$i]->iextein_txn_id.'</td>';
								echo '<td>'.$invoice[$i]->iextein_txn_date.'</td>';
								echo '<td>'.$invoice[$i]->iextein_amount.'</td>';
								echo '</tr>';
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var snackbarContainer = document.querySelector('#demo-toast-example');
		$('.tbl_view').click(function(e){
			e.preventDefault();
			var tid = $(this).prop('id');
			$.post('<?php echo base_url()."Mobile_app/check_template/".$code."/".$mid; ?>',{
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = "<?php echo base_url()."Mobile_app/invoice_download/p/".$mid."/".$code."/";  ?>"+tid;
				}else{
					var data = {message: 'Please contact owner for invoice copy !'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}
			}, "text");
		});

	});
</script>