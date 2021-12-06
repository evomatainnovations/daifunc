<style type="text/css">
	.general_table {
		width: 100%;
        text-align: left;
        font-size: 1em;
        border: 1px solid #ccc;
        border-collapse: collapse;
        border-radius: 10px;
    }

	@media only screen and (max-width: 760px) {
		.general_table {
			display: block;
        	overflow: auto;
		}
	}

	.general_table > thead > tr {
		border: 1px solid #ccc;
	}

	.general_table > thead > tr > th {
		padding: 10px;
		background-color: #666;
		color: #fff;
	}

	.general_table > tbody {
		border: 1px solid #ccc;
	}
	.general_table > tbody > tr {
		border-bottom: 1px solid #ccc;
	}

	.general_table > tbody > tr > td {
		padding: 15px;
		text-align:right;
	}

	.general_table > tfoot > tr {
		border: 1px solid #ccc;
	}

	.general_table > tfoot > tr > td {
		padding: 10px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col">
					<input type="text" id="scheme_name" class="mdl-textfield__input" <?php if(isset($s_list)) { echo "value='".$s_list[0]->iush_name."';"; } else { echo "placeholder = 'Enter scheme name';";} ?> style="font-size: 3em;outline: none;">
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
						<input type="text" id="scheme_limit" class="mdl-textfield__input" style="font-size: 1.5em;" value="<?php if(isset($s_list)) { echo $s_list[0]->iush_limit; } ?>">
						<label class="mdl-textfield__label" for="scheme_limit">Scheme Limit ( -1 for unlimited )</label>
					</div>	
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> 
						<select class="mdl-textfield__input" id="scheme_type">
							<?php
								if (isset($s_list)) {
									if ($s_list[0]->iush_time == 'null') {
										echo '<option value="null" selected>Select</option>';
									}else{
										echo '<option value="null">Select</option>';
									}
									if ($s_list[0]->iush_time == 'one_time') {
										echo '<option value="one_time" selected>ONE TIME</option>';
									}else{
										echo '<option value="one_time">ONE TIME</option>';
									}
									if ($s_list[0]->iush_time == 'every_renewal') {
										echo '<option value="every_renewal" selected>EVERY RENEWAL</option>';
									}else{
										echo '<option value="every_renewal">EVERY RENEWAL</option>';
									}
									if ($s_list[0]->iush_time == 'every_txn') {
										echo '<option value="every_txn" selected>EVERY Transaction</option>';
									}else{
										echo '<option value="every_txn">EVERY Transaction</option>';
									}
								}else{
									echo '<option value="null">Select</option>';
									echo '<option value="one_time">ONE TIME</option>';
									echo '<option value="every_renewal">EVERY RENEWAL</option>';
									echo '<option value="every_renewal">EVERY Transaction</option>';
								}
							?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;">
						<select class="mdl-textfield__input" id="scheme_per_amt">
							<option value="null">Select</option>
							<option value="percentage">Percentage</option>
							<option value="amount">Amount</option>
						</select>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
						<input type="text" id="scheme_amount" class="mdl-textfield__input" style="font-size: 1.5em;">
						<label class="mdl-textfield__label" for="scheme_amount">Enter amount / percentage </label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;">
						<select class="mdl-textfield__input" id="u_type">
							<option value="null" selected>Select</option>
							<option value="user">User</option>
							<option value="referrer">Referrer</option>
						</select>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<button class="mdl-button mdl-button--colored add_parameter"><i class="material-icons">add</i> add</button>
				</div>
				<div class="mdl-cell mdl-cell--12-col display_list"></div>
			</div>
			<button class="lower-button mdl-button mdl-button--fab mdl-button--colored" id="submit"><i class="material-icons">done</i></button>
		</div>
	</div>
</main>
<script type="text/javascript">
	var para_arr = [];
	var i = 0 ;
	var edit_flg = 0 ;
	var edit_id;
	<?php
			if (isset($s_list)) {
				for ($i=0; $i < count($s_list) ; $i++) { 
					echo "para_arr.push({ 'id' : '".$i."' , 's_p_type' : '".$s_list[$i]->iushp_type."' , 's_amt' : '".$s_list[$i]->iushp_amount."' , 's_type' : '".$s_list[$i]->iushp_for."' });";
					echo "i++;";
				}
			}
	?>
	$(document).ready( function() {
		$('#scheme_name').focus();
		display_parameters();
		$('.add_parameter').click(function (e) {
			e.preventDefault();
			var p_type = $('#scheme_per_amt').val();
			var p_amt  = $('#scheme_amount').val();
			var u_type = $('#u_type').val();
			if (edit_flg == 1) {
				para_arr[edit_id].s_p_type = p_type;
				para_arr[edit_id].s_amt = p_amt;
				para_arr[edit_id].s_type = u_type;
			}else{
				para_arr.push({ id : i , s_p_type : p_type , s_amt : p_amt , s_type : u_type });
				i++;
			}
			$('#scheme_per_amt').val('null');
			$('#scheme_amount').val('');
			$('#u_type').val('null');
			edit_flg = 0 ;
			display_parameters();
		});

		$('.display_list').on('click','.delete_scheme',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			para_arr.splice(id, 1);
			display_parameters();
		});		

		$('.display_list').on('click','.edit_scheme',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			edit_flg = 1;
			edit_id = id;
			$('#scheme_per_amt').val(para_arr[id].s_p_type);
			$('#scheme_amount').val(para_arr[id].s_amt);
			$('#u_type').val(para_arr[id].s_type);
		});

		$('#submit').click(function (e) {
			e.preventDefault();
			$.post('<?php if (isset($s_list)) { echo base_url()."Portal/scheme_update/".$sid; }else{ echo base_url()."Portal/scheme_save/"; } ?>',{
				's_name' : $('#scheme_name').val(),
    			's_limit' : $('#scheme_limit').val(),
    			's_time' : $('#scheme_type').val(),
    			'p_arr' : para_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Portal/user_scheme/"; ?>';
			}, "text");
		});

		function display_parameters(){
			var out = '';
			var sr_no = 1 ;
			out += '<table class="general_table">';
			for (var i = 0; i < para_arr.length; i++) {
				out += '<tr><td>'+sr_no+'</td><td>'+para_arr[i].s_p_type+'</td><td>'+para_arr[i].s_amt+'</td><td>'+para_arr[i].s_type+'</td><td><button class="mdl-button mdl-button--colored edit_scheme" id="'+i+'"><i class="material-icons">edit</i> edit</button></td><td><button class="mdl-button mdl-button--colored delete_scheme" id="'+i+'"><i class="material-icons">delete</i> delete</button></td></tr>';
				sr_no++;
			}
			out += '</table>';
			$('.display_list').empty();
			$('.display_list').append(out);
		}
	});
</script>