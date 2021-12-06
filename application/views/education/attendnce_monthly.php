<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
					<div class="mdl-card--expand" style="text-align: left;padding: 30px;">
					<h6>Name:</h6>
					<h3><?php echo $customer[0]->ic_name; ?></h3>
				</div>
				
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card--expand" style="text-align: center;padding: 20px;">
					<h6>Attendance Summary</h6>
					<h3>
						<input type="text" id="c_total" name="c_total" class="mdl-textfield__input" value="<?php if (isset($fees)) { if (count($fees)>0) { echo $fees[0]->iextf_total_fee; } else { echo "N/A";} } ?>" style="font-size: 1em; text-align: center;">
					</h3>
				</div>
				
				</div>
			</div>
			<div class="mdl-cell mdl-cell--2-col">
			<div class="mdl-card mdl-shadow--4dp">
					<div class="mdl-card--expand" style="text-align: center;padding: 20px;color:#fff; background-color: red;font-size: 100%;">
					<h6>Balance:</h6>
					<h3>
						<input type="text" id="c_bal" name="c_bal" class="mdl-textfield__input" value="<?php if (isset($fees)) { if (count($fees)>0) { $a = count($fees)-1; echo $fees[$a]->iextf_balance_fee; } else { echo "N/A";} } ?>" style="font-size: 1em; text-align: center;">
					</h3>
				</div>
				
				</div>
			</div>
			<div class="mdl-cell mdl-cell--4-col">
				<div class="mdl-card mdl-shadow--4dp">

				</div>
			</div>
			
			<div class="mdl-cell mdl-cell--2-col"></div>
			<div class="mdl-cell mdl-cell--8-col">
				<h3>Add new record</h3>
				<div class="mdl-card mdl-shadow--4dp" style="padding: 10px;">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--3-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="c_amt" name="c_amt" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="c_amt">Amount</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--3-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="c_dt" name="c_dt" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="c_dt">Date (YYYY-MM-DD)</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--3-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="c_medium" class="mdl-textfield__input">
							<option value="cheque">Cheque</option>
							<option value="transfer">Bank Transfer</option>
							<option value="cash">Cash</option>
						</select>
							<label class="mdl-textfield__label" for="c_medium">Medium</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--3-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="c_details" name="c_details" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="c_details">Details</label>
						</div>
					</div>
					</div>
					<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="add_fees">Add Record</button>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--2-col"></div>
			

		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--8-col">
			<h3>Additional Details</h3>
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th>Action</th>
						<th>Amt</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
						<th class="mdl-data-table__cell--non-numeric">Details</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (count($fees) > 0) {
							for ($i=0; $i < count($fees) ; $i++) { 
								if($fees[$i]->iextf_status == "Paid") {
									echo '<tr style="color: #009933;font-weight: bold;">';
									echo '<td class="mdl-data-table__cell--non-numeric">';
									// echo '<a href="#">';
									echo '<i id="'.$fees[$i]->iextf_id.'" class="material-icons md-24 delete" style="color: #009933;margin-right: 15px;">delete</i>';
									// echo '</a>';
									// echo '<a href="#">';
									echo '<i id="'.$fees[$i]->iextf_id.'" class="material-icons md-24 paid" style="color: #009933;margin-left: 15px;">done</i>';
									// echo '</a>';
									echo '</td>';
									echo '<td>'.$fees[$i]->iextf_paid_fee.'</td>';
									echo '<td class="mdl-data-table__cell--non-numeric">'.$fees[$i]->iextf_paid_date.'</td>';
									echo '<td class="mdl-data-table__cell--non-numeric">Mode: '.$fees[$i]->iextf_medium.'<br>'.$fees[$i]->iextf_details.'</td>';
									echo '</tr>';
								} else {
									echo '<tr style="color: #e60000;font-weight: bold;">';
									echo '<td class="mdl-data-table__cell--non-numeric">';
									// echo '<a href="#">';
									echo '<i id="'.$fees[$i]->iextf_id.'" class="material-icons md-24 delete" style="color: #e60000;margin-right: 15px;">delete</i>';
									// echo '</a>';
									// echo '<a href="#">';
									echo '<i id="'.$fees[$i]->iextf_id.'" class="material-icons md-24 paid" style="color: #e60000;margin-left: 15px;">done</i>';
									// echo '</a>';
									echo '</td>';
									echo '<td>'.$fees[$i]->iextf_paid_fee.'</td>';
									echo '<td class="mdl-data-table__cell--non-numeric">'.$fees[$i]->iextf_paid_date.'</td>';
									echo '<td class="mdl-data-table__cell--non-numeric">Mode: '.$fees[$i]->iextf_medium.'<br>'.$fees[$i]->iextf_details.'</td>';
									echo '</tr>';
								}
							}
							
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</div>
</div>
</body>
<script>
	$(document).ready(function() {
		
		$('#add_fees').click(function(e) {
			e.preventDefault();

			var amt = $('#c_amt').val();
			var dt = new Date($('#c_dt').val());
			var n_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + (dt.getDate());
			var medium = $('#c_medium').val();
			var detail = $('#c_details').val();
			
			$.post('<?php echo base_url()."education/update_fee_details/".$c_id; ?>', {
					'amt' : amt,
					'dt' : n_dt,
					'medium' : medium,
					'detail' : detail
				}, function(data, status, xhr) {
					var abc = JSON.parse(data);

					$('tbody').empty();
					for (var i = 0; i < abc.length; i++) {
						if(abc[i].status == "Paid") {
							var app = '<tr style="color: #009933;font-weight: bold;"><td class="mdl-data-table__cell--non-numeric"><i class="material-icons md-24 delete" id="' + abc[i].id +'" style="color: #009933;margin-right: 15px;">delete</i><i id="' + abc[i].id + '" class="material-icons md-24 paid" style="color: #009933;margin-left: 15px;">done</i></td><td>' + abc[i].amount + '</td><td class="mdl-data-table__cell--non-numeric">' + abc[i].date + '</td><td class="mdl-data-table__cell--non-numeric">Mode: ' + abc[i].medium + '<br>' + abc[i].detail + '</td></tr>';
						} else {
							var app = '<tr style="color: #e60000;font-weight: bold;"><td class="mdl-data-table__cell--non-numeric"><i class="material-icons md-24 delete" id="' + abc[i].id +'" style="color: #e60000;margin-right: 15px;">delete</i><i id="' + abc[i].id + '" class="material-icons md-24 paid" style="color: #e60000;margin-left: 15px;">done</i></td><td>' + abc[i].amount + '</td><td class="mdl-data-table__cell--non-numeric">' + abc[i].date + '</td><td class="mdl-data-table__cell--non-numeric">Mode: ' + abc[i].medium + '<br>' + abc[i].detail + '</td></tr>';
						}

						$('tbody').append(app);
					}
				}, 'text');

		});

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var total = $('#c_total').val();
			
			$.post('<?php echo base_url()."education/reconcile_fee_details/".$c_id; ?>', {
					'total' : total,
				}, function(data, status, xhr) {
					window.location = '<?php base_url()."education/fee_details/".$c_id; ?>';
				}, 'text');			
		});

		$('.paid').click(function(e) {
			e.preventDefault();
			
			var txnid = $(this).prop('id');
			
			$.post('<?php echo base_url()."education/update_fee_status/"; ?>' + txnid + '/' + <?php echo $c_id; ?>,
				function(data, status, xhr) {
					var abc = JSON.parse(data);

					$('tbody').empty();
					for (var i = 0; i < abc.length; i++) {
						if(abc[i].status == "Paid") {
							var app = '<tr style="color: #009933;font-weight: bold;"><td class="mdl-data-table__cell--non-numeric"><i class="material-icons md-24 delete" id="' + abc[i].id +'" style="color: #009933;margin-right: 15px;">delete</i><i id="' + abc[i].id + '" class="material-icons md-24 paid" style="color: #009933;margin-left: 15px;">done</i></td><td>' + abc[i].amount + '</td><td class="mdl-data-table__cell--non-numeric">' + abc[i].date + '</td><td class="mdl-data-table__cell--non-numeric">Mode: ' + abc[i].medium + '<br>' + abc[i].detail + '</td></tr>';
						} else {
							var app = '<tr style="color: #e60000;font-weight: bold;"><td class="mdl-data-table__cell--non-numeric"><i class="material-icons md-24 delete" id="' + abc[i].id +'" style="color: #e60000;margin-right: 15px;">delete</i><i id="' + abc[i].id + '" class="material-icons md-24 paid" style="color: #e60000;margin-left: 15px;">done</i></td><td>' + abc[i].amount + '</td><td class="mdl-data-table__cell--non-numeric">' + abc[i].date + '</td><td class="mdl-data-table__cell--non-numeric">Mode: ' + abc[i].medium + '<br>' + abc[i].detail + '</td></tr>';
						}

						$('tbody').append(app);
					}
				}, 'text');			
		});

		$('.delete').click(function(e) {
			e.preventDefault();
			
			var txnid = $(this).prop('id');
			
			$.post('<?php echo base_url()."education/delete_fee_txn/"; ?>' + txnid + '/' + <?php echo $c_id; ?>,
				function(data, status, xhr) {
					var abc = JSON.parse(data);

					$('tbody').empty();
					for (var i = 0; i < abc.length; i++) {
						if(abc[i].status == "Paid") {
							var app = '<tr style="color: #009933;font-weight: bold;"><td class="mdl-data-table__cell--non-numeric"><i class="material-icons md-24 delete" id="' + abc[i].id +'" style="color: #009933;margin-right: 15px;">delete</i><i id="' + abc[i].id + '" class="material-icons md-24 paid" style="color: #009933;margin-left: 15px;">done</i></td><td>' + abc[i].amount + '</td><td class="mdl-data-table__cell--non-numeric">' + abc[i].date + '</td><td class="mdl-data-table__cell--non-numeric">Mode: ' + abc[i].medium + '<br>' + abc[i].detail + '</td></tr>';
						} else {
							var app = '<tr style="color: #e60000;font-weight: bold;"><td class="mdl-data-table__cell--non-numeric"><i class="material-icons md-24 delete" id="' + abc[i].id +'" style="color: #e60000;margin-right: 15px;">delete</i><i id="' + abc[i].id + '" class="material-icons md-24 paid" style="color: #e60000;margin-left: 15px;">done</i></td><td>' + abc[i].amount + '</td><td class="mdl-data-table__cell--non-numeric">' + abc[i].date + '</td><td class="mdl-data-table__cell--non-numeric">Mode: ' + abc[i].medium + '<br>' + abc[i].detail + '</td></tr>';
						}

						$('tbody').append(app);
					}
				}, 'text');	
		});


	});
</script>
</html>