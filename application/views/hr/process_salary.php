<style type="text/css">
	.pic_button {
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc;
		margin: 20px;
		position: relative;
		overflow: hidden;
	}
	.pic_button input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}
	@media screen and (max-width: 500px) {
        .person_icon{
            font-size: 80px;
        }
    }
    .person_icon{
        font-size: 150px;
    }
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
		<div class="mdl-cell mdl-cell--12-col">
			<button class="mdl-button mdl-button--colored add_policies"><i class="material-icons">add</i> Add Policies / rules</button>
		</div>
		<div class="mdl-grid" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;width: 100%;">
			<div class="mdl-cell mdl-cell--3-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
					<input type="text" id="emp_name" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="emp_name">Enter Employee</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--3-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
					<input type="text" id="sal_from_date" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="sal_from_date">From date</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--3-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
					<input type="text" id="sal_to_date" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="sal_to_date">To date</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--3-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label details">
					<input type="text" id="dept_name" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="dept_name">Enter Department Name</label>
				</div>
			</div>
			<!-- <div class="mdl-cell mdl-cell--3-col">
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
			</div> -->
			<!-- <div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<select class="mdl-textfield__input" id="rport_type">
						<option value='in_out'>In - Out time</option>
						<option value='present_absent'>Present - Absent</option>
					</select>
					<label class="mdl-textfield__label" for="prod_tax">Select report type</label>
				</div>
			</div> -->
			<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
				<button class="mdl-button mdl-button--colored get_sal_report"><i class="material-icons">search</i> search</button>
			</div>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col emp_sal_display" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;width: 100%;height: 60vh;"></div>
	</div>
</main>
<div class="modal fade" id="add_sal_policies" role="dialog">
	<div class="modal-dialog" style="width: 65%;">
		<div class="modal-content">
			<div class="modal-body">
				<h3 class="modal-title" style="text-align: center;">Add Policies / rules</h3>
				<hr>
				<div class="mdl-cell mdl-cell--12-col">
					<p> 1) If employee come <input type="text" id="in_time_exeed" style="outline: none;text-align: center;" value="<?php
					if(isset($edit_policies)){echo $edit_policies[0]->iextethp_late;} ?>"> minutes late from In time , <input type="text" id="in_time_exeed_deduct" style="outline: none;text-align: center;" value="<?php
					if(isset($edit_policies)){echo $edit_policies[0]->iextethp_late_deduct;} ?>"> Rs. amount will be deducted from salary.</p>
					<p> 2) If employee exceed <input type="text" id="absent_exeed" style="outline: none;text-align: center;" value="<?php
					if(isset($edit_policies)){echo $edit_policies[0]->iextethp_absent;} ?>"> number of absent days , <input type="text" id="absent_exeed_deduct" style="outline: none;text-align: center;" value="<?php
					if(isset($edit_policies)){echo $edit_policies[0]->iextethp_absent_deduct;} ?>"> Rs. amount will be deducted from salary.</p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="save_pol">Save</button>
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
	var shift_data = [];
	var dept_data = [];
	var emp_data = [];
	var in_time_exeed = 0;
	var in_time_exeed_deduct = 0 ;
	var absent_exeed = 0 ;
	var absent_exeed_deduct = 0 ;

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

		if (isset($emp_list)) {
			for ($i=0; $i <count($emp_list) ; $i++) {
				echo "emp_data.push('".$emp_list[$i]->ic_name."');";
			}
		}

		if (isset($edit_policies)) {
			echo "in_time_exeed = ".$edit_policies[0]->iextethp_late.";";
			echo "in_time_exeed_deduct = ".$edit_policies[0]->iextethp_late_deduct.";";
			echo "absent_exeed = ".$edit_policies[0]->iextethp_absent.";";
			echo "absent_exeed_deduct = ".$edit_policies[0]->iextethp_absent_deduct.";";
		}
	?>
	$(document).ready(function() {
		var snackbarContainer = document.querySelector('#demo-toast-example');

		$("#sal_to_date").bootstrapMaterialDatePicker({ weekStart : 0, date: true , time : false});
		$("#sal_from_date").bootstrapMaterialDatePicker({ weekStart : 0, date: true , time : false});

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


		$('.add_policies').click(function (e) {
			e.preventDefault();
			$('#add_sal_policies').modal('show');
		});


		$('.get_sal_report').click(function (e) {
        	e.preventDefault();
        	$('.loader').show();
    		$.post('<?php echo base_url()."Hr/get_salary_report/".$code; ?>',{
				'name' : $('#emp_name').val(),
				'dept_name' : $('#dept_name').val(),
				'from_date' : $('#sal_from_date').val(),
				'to_date' : $('#sal_to_date').val()
			},function(data, status, xhr) {
				$('.loader').hide();
				var a = JSON.parse(data);
				var out = '<div style="text-align:right;"><button class="mdl-button mdl-button--colore mdl-button--raised print_all_salary_slip">Print All</button></div>';
				out += '<table class="general_table"><thead><tr><th>Employee Name</th>';
				out += '<th>Salary per month</th><th>Present days</th><th>Absent days</th><th>Late Mark</th><th>Advance Taken</th><th>Allowance</th><th>Loans</th><th>Total Salary</th><th>Action</th>';
				out += '</tr>';
				out += '</thead>';
				out += '<tbody>';
				for (var i = 0; i < a.emp_list.length; i++) {
					var flg_count = 0;
					var t_flg = a.date_list.length;
					var p_flg = 0;
					var a_flg = 0;
					var in_time = 0;
					for (var ik = 0; ik < a.shift_list.length; ik++) {
						if (a.emp_list[i].iexteth_shift_id == a.shift_list[ik].iexteths_id) {
							in_time = a.shift_list[ik].iexteths_in_time;
						}
					}
					var lt_mark = 0;

					for (var ik = 0; ik < a.date_list.length; ik++) {
						var dt1 = 0;var dt2 = 0;
						for (var m = 0; m < a.emp_attend.length; m++) {
							if(a.emp_attend[m].ica_date == a.date_list[ik] && a.emp_attend[m].ica_card_id == a.emp_list[i].ic_card_id){
								flg_count++;
								if (dt1 == 0) {
									dt1 = a.emp_attend[m].time;
									if (dt1 > in_time) {
										lt_mark++;
									}
								}else{
									dt2 = a.emp_attend[m].time;
								}
							}
						}
						if (dt1 == 0) {
							a_flg++;
						}else{
							p_flg++;
						}
					}
					out += '<tr>';
					out += '<td>'+a.emp_list[i].ic_name+'</td>';
					out += '<td>'+a.emp_list[i].iexteth_salary+'</td>';
					out += '<td>'+p_flg+'</td>';
					out += '<td>'+a_flg+'</td>';
					out += '<td>'+lt_mark+'</td>';
					out += '<td>-</td>';
					out += '<td>-</td>';
					out += '<td>-</td>';
					var sal_per_day = Number(a.emp_list[i].iexteth_salary) / Number(t_flg);
					var t_sal = Number(sal_per_day) * Number(p_flg);
					t_sal = Number(t_sal) - ( Number( lt_mark ) * Number( in_time_exeed_deduct ) );
					if (absent_exeed < a_flg) {
						t_sal = Number(t_sal) -  Number( absent_exeed_deduct ) ;
					}
					out += '<td>'+t_sal.toFixed(2)+'</td>';
					out += '<td><button class="mdl-button mdl-button--colored print_salary_slip" id="'+a.emp_list[i].iexteth_id+'">Print</button></td>';
					out += '</tr>';
				}
				out += '</tbody></table>';

				$('.emp_sal_display').empty();
				$('.emp_sal_display').append(out);
			});
    	});

    	$('.emp_sal_display').on('click','.print_salary_slip',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	window.location = '<?php echo base_url()."Hr/get_salary_slip/".$code.'/'; ?>'+id+'/'+$('#sal_from_date').val()+'/'+$('#sal_to_date').val();
    	});

    	$('.emp_sal_display').on('click','.print_all_salary_slip',function (e) {
        	e.preventDefault();
        	var dept = null;
        	if ($('#dept_name').val() != '') {
        		dept = $('#dept_name').val();
        	}
        	var e_name = null;
        	if ($('#emp_name').val() != '') {
        		e_name = $('#emp_name').val();
        	}
        	window.location = '<?php echo base_url()."Hr/get_salary_slip_all/".$code.'/'; ?>'+$('#sal_from_date').val()+'/'+$('#sal_to_date').val()+'/'+dept+'/'+e_name;
    	});

    	$('#add_sal_policies').on('click','#save_pol',function(e){
    		e.preventDefault();
        	$('.loader').show();
    		$.post('<?php echo base_url()."Hr/save_salary_policies/".$code; ?>',{
				'in_time_exeed' : $('#in_time_exeed').val(),
				'in_time_exeed_deduct' : $('#in_time_exeed_deduct').val(),
				'absent_exeed' : $('#absent_exeed').val(),
				'absent_exeed_deduct' : $('#absent_exeed_deduct').val()
			},function(data, status, xhr) {
				$('.loader').hide();
			});
    	});
    });
</script>