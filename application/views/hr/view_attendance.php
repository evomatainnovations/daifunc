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
		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
						<input type="text" id="emp_name" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="emp_name">Enter Employee</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
						<input type="text" id="attend_from_date" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="attend_from_date">From date</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
						<input type="text" id="attend_to_date" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="attend_to_date">To date</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
						<input type="text" id="dept_name" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="dept_name">Enter Department Name</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
						<input type="text" id="shift_name" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="shift_name">Enter Shift Name</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
						<input type="text" id="emp_unit" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="emp_unit">Enter Unit</label>
					</div>
				</div>
				<div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="rport_type">
							<option value='in_out'>In - Out time</option>
							<option value='present_absent'>Present - Absent</option>
						</select>
						<label class="mdl-textfield__label" for="prod_tax">Select report type</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<button class="mdl-button mdl-button--colored get_attend_report"><i class="material-icons">search</i> search</button>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;height: 60vh;overflow: auto;">
			<table class="general_table emp_list_display" style="overflow: auto;"></table>
		</div>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
	var shift_data = [];
	var dept_data = [];
	var emp_data = [];
	var unit_data = [];
	var aval_card_id = 0 ;
	var emp_arr = [];
	var edit_status = 0;
	<?php
		if (isset($dept_list)) {
			for ($i=0; $i < count($dept_list) ; $i++) {
				echo "dept_data.push('".$dept_list[$i]->iextethd_dept_name."');";
			}
		}

		if (isset($shift_list)) {
			for ($i=0; $i < count($shift_list) ; $i++) {
				echo "shift_data.push('".$shift_list[$i]->iexteths_shift_name."');";
			}
		}

		if (isset($unit_list)) {
			for ($i=0; $i < count($unit_list) ; $i++) {
				echo "unit_data.push('".$unit_list[$i]->iexteth_unit."');";
			}
		}

		if (isset($emp_list)) {
			for ($i=0; $i < count($emp_list) ; $i++) {
				echo "emp_data.push('".$emp_list[$i]->ic_name."');";
			}
		}
	?>
	$(document).ready(function() {
		emp_list_display();

		$("#attend_from_date").bootstrapMaterialDatePicker({ weekStart : 0, time : false});
		$("#attend_to_date").bootstrapMaterialDatePicker({ weekStart : 0, time : false});

    	$("#dept_name").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(dept_data, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#shift_name").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(shift_data, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#emp_name").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(emp_data, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#emp_unit").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(unit_data, request.term);
                response(results.slice(0, 10));
            }
        });

        $('.get_attend_report').click(function (e) {
        	e.preventDefault();
        	$('.loader').show();
        	var type_report = $('#rport_type').val();
    		$.post('<?php echo base_url()."Hr/get_attend_report/".$code; ?>',{
				'name' : $('#emp_name').val(),
				'dept_name' : $('#dept_name').val(),
				'shift_name' : $('#shift_name').val(),
				'from_date' : $('#attend_from_date').val(),
				'to_date' : $('#attend_to_date').val(),
				'emp_unit' : $('#emp_unit').val()				
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				var out = '<thead><tr><th>Employee Name</th>';
				if (type_report == 'in_out') {
					for (var i = 0; i < a.date_list.length; i++) {
						out += '<th colspan="2">'+a.date_list[i]+'</th>';
					}
					out += '<th>Total days</th><th>Present days</th><th>Absent days</th>';
					out += '</tr>';
					out += '<tr><th></th>';
					for (var i = 0; i < a.date_list.length; i++) {
						out += '<th>In Time</th>';
						out += '<th>Out Time</th>';
					}
					out += '<th>-</th><th>-</th><th>-</th>';
					out += '</tr>';
					out += '</thead>';
					out += '<tbody>';
					for (var i = 0; i < a.emp_list.length; i++) {
						out += '<tr>';
						out += '<td>'+a.emp_list[i].ic_name+'</td>';
						var flg_count = 0;
						var t_flg = a.date_list.length;
						var p_flg = 0;
						var a_flg = 0;
						for (var ik = 0; ik < a.date_list.length; ik++) {
							var dt1 = 0;var dt2 = 0;
							for (var m = 0; m < a.emp_attend.length; m++) {
								if(a.emp_attend[m].ica_date == a.date_list[ik] && a.emp_attend[m].ica_card_id == a.emp_list[i].ic_card_id){
									flg_count++;
									if (dt1 == 0) {
										dt1 = a.emp_attend[m].time;
									}else{
										dt2 = a.emp_attend[m].time;
									}
								}
							}
							if (dt1 == 0) {
								a_flg++;
								out += '<td colspan="2" style="color:red;text-align:center;">Absent</td>';
							}else{
								p_flg++;
								out += '<td>'+dt1+'</td>';
								out += '<td>'+dt2+'</td>';
							}
						}
						out += '<td>'+t_flg+'</td>';
						out += '<td>'+p_flg+'</td>';
						out += '<td>'+a_flg+'</td>';
						out += '</tr>';
					}
					out += '</tbody>';
				}else{
					for (var i = 0; i < a.date_list.length; i++) {
						out += '<th>'+a.date_list[i]+'</th>';
					}
					out += '<th>Total days</th><th>Present days</th><th>Absent days</th>';
					out += '</tr>';
					out += '</thead>';
					out += '<tbody>';
					for (var i = 0; i < a.emp_list.length; i++) {
						out += '<tr>';
						out += '<td>'+a.emp_list[i].ic_name+'</td>';
						var flg_count = 0;
						var t_flg = a.date_list.length;
						var p_flg = 0;
						var a_flg = 0;
						for (var ik = 0; ik < a.date_list.length; ik++) {
							var dt1 = 0;var dt2 = 0;
							for (var m = 0; m < a.emp_attend.length; m++) {
								if(a.emp_attend[m].ica_date == a.date_list[ik] && a.emp_attend[m].ica_card_id == a.emp_list[i].ic_card_id){
									flg_count++;
									if (dt1 == 0) {
										dt1 = a.emp_attend[m].time;
									}else{
										dt2 = a.emp_attend[m].time;
									}
								}
							}
							if (dt1 == 0) {
								a_flg++;
								out += '<td style="color:red;">Absent</td>';
							}else{
								out += '<td style="color:green;">Present</td>';
								p_flg++;
							}

						}
						out += '<td>'+t_flg+'</td>';
						out += '<td>'+p_flg+'</td>';
						out += '<td>'+a_flg+'</td>';
						out += '</tr>';
					}
					out += '</tbody>';
				}
				$('.emp_list_display').css('display','block');
				$('.emp_list_display').empty();
				$('.emp_list_display').append(out);
				$('.loader').hide();
			}, 'text');
        });

        function emp_list_display(){
        	var out = '';
        	if (emp_arr.length > 0 ) {
        		for (var i = 0; i < emp_arr.length; i++) {
	        		out += '<tr>';
	        		out += '<td>'+emp_arr[i].name+'</td>';
	        		out += '<td></td>';
	        		out += '<td></td>';
	        		out += '</tr>';	
	        	}
	        	$('.emp_list_display').css('display','block');
	        	$('.emp_list_display > tbody').empty();
	        	$('.emp_list_display > tbody').append(out);
        	}else{
        		$('.emp_list_display').css('display','none');
        	}
        }
    });
</script>