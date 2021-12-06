<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
					<div class="mdl-card--expand" style="text-align: left;padding: 20px;color:#999; background-color: ;font-size: 100%;">
					<h1>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="month" class="mdl-textfield__input">
								<option value="1" <?php if($month=="01") {echo "selected";} ?>>January</option>
								<option value="2" <?php if($month=="02") {echo "selected";} ?>>February</option>
								<option value="3" <?php if($month=="03") {echo "selected";} ?>>March</option>
								<option value="4" <?php if($month=="04") {echo "selected";} ?>>April</option>
								<option value="5" <?php if($month=="05") {echo "selected";} ?>>May</option>
								<option value="6" <?php if($month=="06") {echo "selected";} ?>>June</option>
								<option value="7" <?php if($month=="07") {echo "selected";} ?>>July</option>
								<option value="8" <?php if($month=="08") {echo "selected";} ?>>August</option>
								<option value="9" <?php if($month=="09") {echo "selected";} ?>>September</option>
								<option value="10" <?php if($month=="10") {echo "selected";} ?>>October</option>
								<option value="11" <?php if($month=="11") {echo "selected";} ?>>November</option>
								<option value="12" <?php if($month=="12") {echo "selected";} ?>>December</option>
							</select>
							<label class="mdl-textfield__label" for="month">Select Month to view</label>
						</div>
						
					</h1>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col">
			<div class="mdl-card mdl-shadow--4dp">
					<div class="mdl-card--expand" style="text-align: center;padding: 20px;color:#fff; background-color: red;font-size: 100%;">
					<h6>Absent:</h6>
					<h1>
						<?php echo $absent; ?>
					</h1>
				</div>			
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col">
			<div class="mdl-card mdl-shadow--4dp">
					<div class="mdl-card--expand" style="text-align: center;padding: 20px;color:#fff; background-color: green;font-size: 100%;">
					<h6>Present:</h6>
					<h1>
						<?php echo $present; ?>
					</h1>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<h6>Graph:</h6>
				
			</div>
		</div>
		
		<div class="mdl-cell mdl-cell--12-col">

			<?php
				if($absent==0) {
					echo '<h1 style="text-align:"><div class="mdl-cell--6-col" style="center;width:100%;"><img src="'.base_url().'assets/images/thumbup.png" style="width:50%;" /></div><div class="mdl-cell--6-col" style="center;width:100%;">Great!! Not a single day absent.</div></h1>'; 
				} else {
					echo '<h3>Absent on events:</h3>';
					echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">';
					echo '<thead>';
					echo '<tr>';
					echo '<th class="mdl-data-table__cell--non-numeric">Date</th>';
					echo '<th class="mdl-data-table__cell--non-numeric">Event</th>';
					echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
					
					for ($i=0; $i < count($attendance_lec) ; $i++) { 
						echo '<tr>';
						echo '<td class="mdl-data-table__cell--non-numeric">'.$attendance_lec[$i]->ieea_date.'</td>';
						echo '<td class="mdl-data-table__cell--non-numeric">Lecture: '.$attendance_lec[$i]->iexts_name.'-'.$attendance_lec[$i]->iextc_name.'-'.$attendance_lec[$i]->iextt_name.'</td>';
						echo '</tr>';
					}
					for ($i=0; $i < count($attendance_exam) ; $i++) { 
						echo '<tr>';
						echo '<td class="mdl-data-table__cell--non-numeric">'.$attendance_exam[$i]->ieea_date.'</td>';
						echo '<td class="mdl-data-table__cell--non-numeric">Exam: '.$attendance_exam[$i]->iexts_name.'-'.$attendance_exam[$i]->iextc_name.'-'.$attendance_exam[$i]->iextp_preliem_name.'</td>';
						echo '</tr>';
					}

					echo '</tbody>';
					echo '</table>';
				}
			?>
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