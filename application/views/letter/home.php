<style>
@media only screen and (max-width: 760px) {
	.general_table {
		display: block;
    	overflow: auto;
	}
}

.general_table thead > tr > th {
	background-color: #666;
	color: #fff;
}

.panel {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Txn No</th>
						<th class="mdl-data-table__cell--non-numeric">Customer name</th>
						<th class="mdl-data-table__cell--non-numeric">Subject</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
						if (isset($letter)) {
							for ($i=0; $i < count($letter) ; $i++) { 
								echo '<tr class="tbl_view" id="'.$letter[$i]->iextel_id.'">';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$letter[$i]->iextel_txn_id.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$letter[$i]->ic_name.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$letter[$i]->iextel_subject.'</td>';
								echo '<td class="">'.$letter[$i]->iextel_date.'</td>';
								echo '</tr>';
							}	
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
		<i class="material-icons">add</i>
	</button>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		$('#add').click(function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Letter/letter_add/'.$code; ?>";
		});

		$('#details').on('click', '.tbl_view', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');
			window.location = "<?php echo base_url().'Letter/letter_add/'.$code.'/'; ?>"+tid;
		}));

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/invoice_search/".$code; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.invoice.length; i++) {
					if(abc.invoice[i].iextein_status == "paid") {
						out+='<tr style="color: #009933;font-weight: bold;" class="tbl_view" id="' + abc.invoice[i].iextein_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].ic_name + '</td>';
						out+='<td class="">' + abc.invoice[i].iextein_amount + '</td>';
						out+='</tr>';
					} else {
						out+='<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="' + abc.invoice[i].iextein_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].ic_name + '</td>';
						out+='<td class="">' + abc.invoice[i].iextein_amount + '</td>';
						out+='</tr>';
					}
				}
				$('#details').append(out);
			})
		});
	});
</script>
</html>