<style>
	td {
		padding: 5px;
	}
</style>

<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Summary Of Selected Document</h2>
				</div>
				<div class="mdl-card__supporting-text" style="font-size: 1em; text-align: left;">
					<table>
						<tr>
							<td><b>Client: </b><?php echo $doc_client; ?></td>
						</tr>
						<tr>
							<td><b>Document: </b><?php echo $doc_type; ?></td>
						</tr>
						<tr>
							<td><b>TXN ID: </b><?php echo $doc_id; ?></td>
						</tr>
						<tr>
							<td><b>Date: </b><?php echo $doc_date; ?></td>
						</tr>
						<tr>
							<td><b>Amount: </b><?php echo $doc_amount; ?></td>
						</tr>
						<tr>
							<td><b>Note: </b><?php echo $doc_note; ?></td>
						</tr>
						<tr>
							<td><b>Status: </b><?php echo $doc_status; ?></td>
						</tr>

					</table>
					
					<a href="<?php echo $doc_url; ?>" target="_blank">
						<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="add_prp" style="width: 100%;">View / Print Document</button>
					</a> <br></br>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Payment Record Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="amount" name="amount" class="mdl-textfield__input" value="<?php if(isset($edit_function)) { echo $edit_function[0]->ifun_name; } ?>">
						<label class="mdl-textfield__label" for="amount">Enter Amount</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label>Type Mode Of Payment</label>
						<ul id="categories" class="mdl-textfield__input">
						</ul>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="instrument" name="instrument" class="mdl-textfield__input" value="<?php if(isset($edit_function)) { echo $edit_function[0]->ifun_name; } ?>">
						<label class="mdl-textfield__label" for="instrument">Enter Instrument/ Txn Id</label>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input" class="mdl-textfield__input" value="<?php if(isset($edit_lecture)) { echo $edit_lecture[0]->iextls_from_date; } ?>">
							<label class="mdl-textfield__label" for="date-input">Select Date</label>
						</div>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="details" name="details" class="mdl-textfield__input" value="<?php if(isset($edit_function)) { echo $edit_function[0]->ifun_name; } ?>">
						<label class="mdl-textfield__label" for="details">Enter Details</label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
						<th class="mdl-data-table__cell--non-numeric">Amount</th>
						<th class="mdl-data-table__cell--non-numeric">Details</th>
						<th class="mdl-data-table__cell--non-numeric">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($records) ; $i++) { 
							echo '<tr id="'.$records[$i]->iextpay_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$records[$i]->iextpay_date.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$records[$i]->iextpay_amount.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$records[$i]->iextpay_mode.' '.$records[$i]->iextpay_instrument.' '.$records[$i]->iextpay_details.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent trash" id="'.$records[$i]->iextpay_id.'" ><i class="material-icons">delete</i></button></td>';
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
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	<?php
    		for ($i=0; $i < count($mode) ; $i++) { 
    			echo "tag_data.push('".$mode[$i]->ipm_mode."');";
    		}
    	?>
    	$('#categories').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data,
    		tagLimit : 1,
    		singleField : true
    	});
    });
</script>

<script>
	$(document).ready(function() {

		$('#date-input').bootstrapMaterialDatePicker({ weekStart : 0, time: false, format : 'YYYY-MM-DD' });
		var dt = new Date()
		var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
		$('#date-input').val(s_dt);

		$('.trash').click(function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			window.location = "<?php echo base_url().'Enterprise/delete_payment_record/'.$mod_id.'/'.$type.'/'.$doc_id.'/'.$cus_id.'/'; ?>"+ cid;
		});

		$('#submit').click(function(e) {
			e.preventDefault();

			var tag_info = [];
			$('#categories > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					tag_info.push(tmpstr);
				}
			});
			
			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_system_function/'.$did; } { echo base_url().'Enterprise/update_payment_record/'.$type.'/'.$doc_id.'/'.$cus_id; } ?>", {
				'mode' : tag_info,
				'amount' : $('#amount').val(),
				'instrument' : $('#instrument').val(),
				'date' : $('#date-input').val(),
				'details' : $('#details').val(),
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Enterprise/record_payment/'.$mod_id.'/'.$type.'/'.$doc_id.'/'.$cus_id; ?>"
			}, "text");
		});
	});
</script>

</html>