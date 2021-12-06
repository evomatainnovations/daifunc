<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Location Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="name" class="mdl-textfield__input" value="<?php if(isset($edit_lecture)) { echo $edit_lecture[0]->iextls_from_date; } ?>">
						<label class="mdl-textfield__label" for="name">Location Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="code" class="mdl-textfield__input" value="<?php if(isset($edit_function)) { echo $edit_function[0]->ifun_name; } ?>">
						<label class="mdl-textfield__label" for="code">Identification Code/ Barcode</label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Location</th>
						<th class="mdl-data-table__cell--non-numeric">Code</th>
						<th class="mdl-data-table__cell--non-numeric">Action</th>
					</tr>
				</thead>
				<tbody id="tdetails">
					<?php
						for ($i=0; $i < count($location) ; $i++) { 
							echo '<tr id="'.$location[$i]->iexteil_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$location[$i]->iexteil_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$location[$i]->iexteil_code.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent trash" id="'.$location[$i]->iexteil_id.'" ><i class="material-icons">delete</i></button></td>';
							echo "</tr>";
						}
					?>
				</tbody>
			</table>

		</div>
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
</body>
<script>
	$(document).ready(function() {
		var id = "N/A";
		$('.trash').click(function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			window.location = "<?php echo base_url().'Enterprise/inventory_location_manage_delete/'; ?>"+ cid;
		});

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Enterprise/expense_search/"; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#tdetails').empty();
				var out = "";
				for (var i = 0; i < abc.length; i++) {
					out+= '<tr id="' + abc[i].iexte_id + '" class="click_customer">';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iexte_details +'</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iexte_amount + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iexte_date + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent trash" id="' + abc[i].iexte_id + '" ><i class="material-icons">delete</i></button></td>';
					out+= "</tr>";

					// if(abc.inventory[i].iextei_type == "inward") {
					// 	out+='<tr style="color: #009933;font-weight: bold;" class="tbl_view_inward" id="' + abc.inventory[i].iextei_id +'">';
					// 	out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_id + '</td>';
					// 	out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_date + '</td>';
					// 	out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].ic_name + '</td>';
					// 	out+='</tr>';
					// } else {
					// 	out+='<tr style="color: #e60000;font-weight: bold;" class="tbl_view_outward" id="' + abc.inventory[i].iextei_id + '">';
					// 	out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_id + '</td>';
					// 	out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_date + '</td>';
					// 	out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].ic_name + '</td>';
					// 	out+='</tr>';
					// }
				}
				$('#tdetails').append(out);
			})
		});

		$('#tdetails').on('click','tr', function(e) {
			id = $(this).prop('id');
			$.post("<?php echo base_url().'Enterprise/inventory_location_manage_getdetail'; ?>", {
				'id' : id
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#name').val(abc[0].name);
				$('#code').val(abc[0].code);
			});			
		});

		$('#submit').click(function(e) {
			e.preventDefault();

			$.post("<?php echo base_url().'Enterprise/inventory_location_manage_save'; ?>", {
				'name' : $('#name').val(),
				'code' : $('#code').val(),
				'id' : id
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Enterprise/inventory_location_manage'; ?>"
			}, "text");
		});
	});
</script>

</html>