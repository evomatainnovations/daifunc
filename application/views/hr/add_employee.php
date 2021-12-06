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

    .person_icon{
        font-size: 950%;
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
		.person_icon {
			font-size: 750%;
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
			<button class="mdl-button mdl-button--colored add_dept"><i class="material-icons">add</i> Add Department</button>
			<button class="mdl-button mdl-button--colored add_shift"><i class="material-icons">add</i> Add Shift</button>
		</div>
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;">
			<div class="emp_profile" style="border: 1px solid #ccc;border-radius: 50%;margin-left: 33%; width: 33%;">
				<i class="material-icons person_icon" style="color: #ccc;">person</i>
			</div>
			<div type="button" class="mdl-button pic_button"><i class="material-icons">photo_camera</i> Upload<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc"></div>
			<div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	    			<select class="mdl-textfield__input" id="emp_device">
	    				<option value="null">Select Device</option>
						<?php for($i=0; $i < count($device_list); $i++) {
			            	echo '<option value="'.$device_list[$i]->iu_d_id.'">'.$device_list[$i]->iu_d_name.'</option>';
			        	} ?>
					</select>
				</div>
			</div>
			<div>
				<h3 class="card_no" style="text-align: center;"></h3>
			</div>
			<div class="details">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" id="emp_name" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="emp_name">Enter Employee</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" id="dept_tag" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="dept_tag">Enter Department Name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" id="shift_tag" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="shift_tag">Enter Shift Name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" id="emp_sal" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="emp_sal">Enter Salary per month</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" id="emp_unit" class="mdl-textfield__input" >
					<label class="mdl-textfield__label" for="emp_unit">Enter Unit</label>
				</div>
				<div>
					<button class="mdl-button mdl-button--colored save_emp"><i class="material-icons">save</i> Save</button>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;height: 80vh;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--10-col">
					<input type="text" id="emp_search" class="mdl-textfield__input" style="outline: none;" placeholder="Search Employee">
				</div>
				<div class="mdl-cell mdl-cell--2-col">
					<button class="mdl-button mdl-button--colored emp_search_btn"><i class="material-icons">add</i> Search</button>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="height: 70vh;overflow: auto;">
					<table class="general_table emp_list_display"><tbody></tbody></table>
				</div>
			</div>
		</div>
	</div>
</main>
<div class="modal fade" id="add_dept_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3 class="modal-title" style="text-align: center;">Add Department</h3>
				<hr>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="emp_dept_name" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="emp_dept_name">Enter Department Name</label>
					</div>
					<button type="button" class="mdl-button mdl-button--colored" id="save_dept">add</button>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<table class="general_table dept_table">
						<thead>
							<th>Department Name</th>
							<th colspan="2">Action</th>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add_shift_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3 class="modal-title" style="text-align: center;">Add Shift</h3>
				<hr>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="emp_shift_name" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="emp_shift_name">Enter Shift Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="emp_shift_in" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="emp_shift_in">Enter In time</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="emp_shift_out" class="mdl-textfield__input" >
						<label class="mdl-textfield__label" for="emp_shift_out">Enter Out time</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<button type="button" class="mdl-button mdl-button--colored" id="save_shift">Save</button>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<table class="general_table shift_table">
						<thead>
							<th>Shift Name</th>
							<th>In time</th>
							<th>Out time</th>
							<th colspan="2">Action</th>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
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
	var aval_card_id = 0 ;
	var emp_arr = [];
	var emp_auto = [];
	var edit_status = 0;

	var dept_arr = [];
	var shift_arr = [];
	var sel_dept_id = 0;
	var sel_shift_id = 0;
	<?php
		if (isset($dept_list)) {
			for ($i=0; $i < count($dept_list) ; $i++) {
				echo "dept_data.push('".$dept_list[$i]->iextethd_dept_name."');";
				echo "dept_arr.push({'id' : '".$dept_list[$i]->iextethd_id."' , 'name' : '".$dept_list[$i]->iextethd_dept_name."' });";
			}
		}

		if (isset($shift_list)) {
			for ($i=0; $i < count($shift_list) ; $i++) {
				echo "shift_data.push('".$shift_list[$i]->iexteths_shift_name."');";
				echo "shift_arr.push({'id' : '".$shift_list[$i]->iexteths_id."' , 'name' : '".$shift_list[$i]->iexteths_shift_name."' ,'in_time' : '".$shift_list[$i]->iexteths_in_time."' ,'out_time' : '".$shift_list[$i]->iexteths_out_time."'});";
			}
		}

		if (isset($emp_list)) {
			for ($i=0; $i <count($emp_list) ; $i++) {
				echo "emp_arr.push({'id' : '".$emp_list[$i]->iexteth_id."' , 'name' : '".$emp_list[$i]->ic_name."' , 'dept' : '".$emp_list[$i]->iextethd_dept_name."', 'file' : '".$emp_list[$i]->icd_timestamp."'});";
				echo "emp_auto.push('".$emp_list[$i]->ic_name."');";
			}
		}
	?>
	$(document).ready(function() {
		emp_list_display();
		display_shift();
		display_dept();
		var snackbarContainer = document.querySelector('#demo-toast-example');

		$("#emp_shift_out").bootstrapMaterialDatePicker({ weekStart : 0, date: false , time : true, format: 'HH:mm'});
		$("#emp_shift_in").bootstrapMaterialDatePicker({ weekStart : 0, date: false , time : true, format: 'HH:mm'});
		if (aval_card_id == 0 ) {
			$('.details').css('display','none');
		}

    	$("#dept_tag").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(dept_data, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#emp_search").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(emp_auto, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#shift_tag").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(shift_data, request.term);
                response(results.slice(0, 10));
            }
        });

    	$('#emp_device').change(function (e) {
            e.preventDefault();
            var device = $(this).val();
			$.post('<?php echo base_url()."Hr/get_card_details/".$code.'/'; ?>'+device,
			function(data, status, xhr) {
        		var a = JSON.parse(data);
        		var out = '';
        		if (a.card_list.length > 0 ) {
        			aval_card_id = a.card_list[0].ica_card_id;
        			out = 'Card serial number : '+aval_card_id;
        			$('.details').css('display','block');
        		}else{
        			out = 'No cards available !';
        			$('.details').css('display','none');
        		}
        		$('.card_no').empty();
        		$('.card_no').append(out);
        	});
        });

		$('.upload').change(function (e) {
            e.preventDefault();
            var ins = $('.upload')[0].files.length;
            $('#no_of_files').empty();
            if (ins > 1) {
                $('#no_of_files').append(ins+' files selected');
            }else{
                $('#no_of_files').append(ins+' file selected');
            }
            var input = $('.upload')[0];
            $('.emp_profile').empty();

            for (var i = 0; i < input.files.length; i++) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.emp_profile').append('<img class="upload_view" src="'+ e.target.result+'" style="border-radius:50%;max-width:100%;max-height:100%;height:160px;width:160px;" alt="your image" />');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
        });

        $('.add_dept').click(function (e) {
        	e.preventDefault();
        	$('#add_dept_modal').modal('show');
        });

        $('.add_shift').click(function (e) {
        	e.preventDefault();
        	$('#add_shift_modal').modal('show');
        });

        $('#add_shift_modal').on('click','#save_shift',function (e) {
        	e.preventDefault();
        	$('.loader').show();
        	if (sel_shift_id == 0) {
        		var path = '<?php echo base_url()."Hr/save_shift/".$code; ?>';
        	}else{
        		var path = '<?php echo base_url()."Hr/save_shift/".$code.'/'; ?>'+sel_shift_id;
        	}
        	$.post(path,{
				'name' : $('#emp_shift_name').val(),
				'in_time' : $('#emp_shift_in').val(),
				'out_time' : $('#emp_shift_out').val(),
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				shift_data.push($('#emp_shift_name').val());
				shift_arr = [];
				$('#emp_shift_name').val('');
				$('#emp_shift_in').val('');
				$('#emp_shift_out').val('');
				for (var i=0; i < a.shift_list.length ; i++) {
					shift_arr.push({'id' : a.shift_list[i].iexteths_id , 'name' : a.shift_list[i].iexteths_shift_name , 'in_time' : a.shift_list[i].iexteths_in_time , 'out_time' : a.shift_list[i].iexteths_out_time });
				}
				display_shift();
			}, 'text');
        });

        $('#add_dept_modal').on('click','#save_dept',function (e) {
        	e.preventDefault();
        	if (sel_dept_id != 0) {
        		update_dept();
        	}else{
        		save_dept();
        	}
        });

        $('#add_dept_modal').on('keyup','#emp_dept_name',function (e) {
        	e.preventDefault();
        	if (e.keyCode == 13) {
        		if (sel_dept_id != 0) {
	        		update_dept();
	        	}else{
	        		save_dept();
	        	}
        	}
        });

        function save_dept() {
		    $('.loader').show();
    		$.post('<?php echo base_url()."Hr/save_department/".$code; ?>',{
				'name' : $('#emp_dept_name').val()
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				sel_dept_id = 0;
				dept_data.push($('#emp_dept_name').val());
				$('#emp_dept_name').val('');
				dept_arr = [];
				for (var i=0; i < a.dept_list.length ; i++) {
					dept_arr.push({'id' : a.dept_list[i].iextethd_id , 'name' : a.dept_list[i].iextethd_dept_name });
				}
				display_dept();
			}, 'text');        	
        }

        function update_dept() {
		    $('.loader').show();
    		$.post('<?php echo base_url()."Hr/save_department/".$code.'/'; ?>'+sel_dept_id,{
				'name' : $('#emp_dept_name').val()
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				sel_dept_id = 0;
				dept_data.push($('#emp_dept_name').val());
				$('#emp_dept_name').val('');
				dept_arr = [];
				for (var i=0; i < a.dept_list.length ; i++) {
					dept_arr.push({'id' : a.dept_list[i].iextethd_id , 'name' : a.dept_list[i].iextethd_dept_name });
				}
				display_dept();
			}, 'text');        	
        }

        $('.save_emp').click(function (e) {
        	e.preventDefault();
        	$('.loader').show();
        	var path = '';
        	if (edit_status == 0) {
        		path = '<?php echo base_url()."Hr/save_employee/".$code; ?>';
        	}else{
        		path = '<?php echo base_url()."Hr/update_employee/".$code.'/'; ?>'+edit_status;
        	}
        	$.post(path,{
				'e_name' : $('#emp_name').val(),
				'e_sal' : $('#emp_sal').val(),
				'e_unit' : $('#emp_unit').val(),
				'e_dept' : $('#dept_tag').val(),
				'e_shift' : $('#shift_tag').val(),
				'card_no' : aval_card_id
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				edit_status = 0;
				if($('.proposal_doc')[0].files[0]) {
					upload_file(a.emp_list[0].iexteth_id);
				}else{
					emp_arr = [];
					for (var i=0; i < a.emp_list.length ; i++) {
						emp_arr.push({'id' : a.emp_list[i].iexteth_id , 'name' : a.emp_list[i].ic_name , 'dept' : a.emp_list[i].iextethd_dept_name, 'file' : a.emp_list[i].icd_timestamp });
					}
					clear_all();
					$('.loader').hide();
					emp_list_display();
				}
			}, 'text');
        });

        function clear_all(){
        	$('#emp_name').val('');
        	$('#emp_sal').val('');
			$('#emp_unit').val('');
			$('#dept_tag').val('');
			$('#shift_tag').val('');
			$('.emp_profile').empty();
			$('.emp_profile').append('<i class="material-icons person_icon" style="color: #ccc;">person</i>');
			$('#emp_search').val('');
        }

        $('#emp_search').keyup(function (e) {
        	e.preventDefault();
        	if (e.keyCode == 13) {
        		$('.loader').show();
        		$.post('<?php echo base_url()."Hr/search_emp/".$code; ?>',{
					'name' : $('#emp_search').val()
				},function(data, status, xhr) {
					var a = JSON.parse(data);
					$('.loader').hide();
					emp_arr = [];
					for (var i=0; i < a.emp_list.length ; i++) {
						emp_arr.push({'id' : a.emp_list[i].iexteth_id , 'name' : a.emp_list[i].ic_name , 'dept' : a.emp_list[i].iextethd_dept_name, 'file' : a.emp_list[i].icd_timestamp });
					}
					emp_list_display();
				}, 'text');
        	}
        });

        $('.emp_search_btn').click(function (e) {
        	e.preventDefault();
        	$('.loader').show();
    		$.post('<?php echo base_url()."Hr/search_emp/".$code; ?>',{
				'name' : $('#emp_search').val()
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				emp_arr = [];
				for (var i=0; i < a.emp_list.length ; i++) {
					emp_arr.push({'id' : a.emp_list[i].iexteth_id , 'name' : a.emp_list[i].ic_name , 'dept' : a.emp_list[i].iextethd_dept_name, 'file' : a.emp_list[i].icd_timestamp });
				}
				emp_list_display();
			}, 'text');
        });

        function upload_file(e_id){
			var datat = new FormData();
            var ins = $('.proposal_doc')[0].files.length;
            for (var x = 0; x < ins; x++) {
                datat.append("used[]", $('.proposal_doc')[0].files[x]);
            }
			$.ajax({
				url: "<?php echo base_url().'Hr/hr_doc_upload/'.$code."/";?>"+e_id,
				type: "POST",
				data: datat,
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){
					var a = JSON.parse(data);
					emp_arr = [];
					for (var i=0; i < a.emp_list.length ; i++) {
						emp_arr.push({'id' : a.emp_list[i].iexteth_id , 'name' : a.emp_list[i].ic_name , 'dept' : a.emp_list[i].iextethd_dept_name, 'file' : a.emp_list[i].icd_timestamp });
					}
					emp_list_display();
					clear_all();
					$('.loader').hide();
				}
			});
        }

        function emp_list_display(){
        	var out = '';
        	var path = '<?php echo base_url().'assets/uploads/'.$oid.'/'; ?>';
        	for (var i = 0; i < emp_arr.length; i++) {
        		out += '<tr>';
        		out += '<td>';
        		if (emp_arr[i].file == '' || emp_arr[i].file == null) {
        			out += '<button class="mdl-button" style="border-radius:50%;border:1px solid #666;max-width:100%;max-height:100%;height:65px;width:65px;"><i class="material-icons" style="font-size: 30px;">person</i></button> ';
        		}else{
        			out += '<img class="upload_view" src="'+ path + emp_arr[i].file + '" style="border-radius:50%;border:1px solid #666;max-width:100%;max-height:200%;height:65px;width:65px;" alt="your image" />';
        		}
        		out += '</td><td><h4>'+emp_arr[i].name+'</h4></td>';
        		out += '<td><button class="mdl-button delete_emp" id="'+emp_arr[i].id+'"><i class="material-icons">delete</i> delete</button></td>';
        		out += '<td><button class="mdl-button edit_emp" id="'+emp_arr[i].id+'"><i class="material-icons">edit</i> edit</button></td>';
        		out += '</tr>';	
        	}

        	$('.emp_list_display > tbody').empty();
        	$('.emp_list_display > tbody').append(out);
        }

		$('.emp_list_display').on('click','.edit_emp',function (e) {
        	e.preventDefault();
        	$('.loader').show();
        	var id = $(this).prop('id');
        	edit_status = id;
        	$.post('<?php echo base_url()."Hr/edit_emp/".$code.'/'; ?>'+id,
			function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				var path = '<?php echo base_url().'assets/uploads/'.$oid.'/'; ?>';
				$('.details').css('display','block');
				$('#emp_name').val(a.emp_list[0].ic_name);
	        	$('#emp_sal').val(a.emp_list[0].iexteth_salary);
				$('#emp_unit').val(a.emp_list[0].iexteth_unit);
				$('#dept_tag').val(a.emp_list[0].iextethd_dept_name);
				$('#shift_tag').val(a.emp_list[0].iexteths_shift_name);
				if (a.emp_list[0].icd_timestamp != '' || a.emp_list[0].icd_timestamp != null ) {
					$('.emp_profile').empty();
					$('.emp_profile').append('<img class="upload_view" src="'+ path + a.emp_list[0].icd_timestamp +'" style="border-radius:50%;max-width:100%;max-height:100%;height:160px;width:160px;" alt="your image" />');
				}
			}, 'text');
        });

        $('.emp_list_display').on('click','.delete_emp',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	$('.loader').show();
    		$.post('<?php echo base_url()."Hr/delete_emp/".$code.'/'; ?>'+id,
			function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				emp_arr = [];
				clear_all();
				for (var i=0; i < a.emp_list.length ; i++) {
					emp_arr.push({'id' : a.emp_list[i].iexteth_id , 'name' : a.emp_list[i].ic_name , 'dept' : a.emp_list[i].iextethd_dept_name, 'file' : a.emp_list[i].icd_timestamp });
				}
				emp_list_display();
			}, 'text');
        });

		$('.dept_table').on('click','.delete_dept',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	$('.loader').show();
    		$.post('<?php echo base_url()."Hr/delete_department/".$code.'/'; ?>'+id,
			function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				dept_arr = [];
				for (var i=0; i < a.dept_list.length ; i++) {
					dept_arr.push({'id' : a.dept_list[i].iextethd_id , 'name' : a.dept_list[i].iextethd_dept_name });
				}
				display_dept();
			}, 'text');
        });

        $('.dept_table').on('click','.edit_dept',function (e) {
        	e.preventDefault();
        	sel_dept_id = $(this).prop('id');
        	for (var i=0; i < dept_arr.length ; i++) {
				if (dept_arr[i].id == sel_dept_id) {
					$('#emp_dept_name').val(dept_arr[i].name);
				}
			}
        });

        $('.shift_table').on('click','.delete_shift',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	$('.loader').show();
    		$.post('<?php echo base_url()."Hr/delete_shift/".$code.'/'; ?>'+id,
			function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.loader').hide();
				shift_arr = [];
				for (var i=0; i < a.shift_list.length ; i++) {
					shift_arr.push({'id' : a.shift_list[i].iexteths_id , 'name' : a.shift_list[i].iexteths_shift_name , 'in_time' : a.shift_list[i].iexteths_in_time , 'out_time' : a.shift_list[i].iexteths_out_time });
				}
				display_shift();
			}, 'text');
        });

        $('.shift_table').on('click','.edit_shift',function (e) {
        	e.preventDefault();
        	sel_shift_id = $(this).prop('id');
        	for (var i=0; i < shift_arr.length ; i++) {
				if (shift_arr[i].id == sel_shift_id) {
					$('#emp_shift_name').val(shift_arr[i].name);
					$('#emp_shift_in').val(shift_arr[i].in_time);
					$('#emp_shift_out').val(shift_arr[i].out_time);
				}
			}
        });
    });
		function display_shift() {
        	var out = '';
        	for (var i = 0; i < shift_arr.length; i++) {
        		out += '<tr>';
        		out += '<td>'+shift_arr[i].name+'</td>';
        		out += '<td>'+shift_arr[i].in_time+'</td>';
        		out += '<td>'+shift_arr[i].out_time+'</td>';
        		out += '<td><button class="mdl-button mdl-button--icon delete_shift" id="'+shift_arr[i].id+'"><i class="material-icons">delete</i></button></td>';
        		out += '<td><button class="mdl-button mdl-button--icon edit_shift" id="'+shift_arr[i].id+'"><i class="material-icons">edit</i></button></td>';
        		out += '<tr>';
        	}
        	$('.shift_table > tbody').empty();
        	$('.shift_table > tbody').append(out);
        }

        function display_dept() {
        	var out = '';
        	for (var i = 0; i < dept_arr.length; i++) {
        		out += '<tr>';
        		out += '<td>'+dept_arr[i].name+'</td>';
        		out += '<td><button class="mdl-button mdl-button--icon delete_dept" id="'+dept_arr[i].id+'"><i class="material-icons">delete</i></button></td>';
        		out += '<td><button class="mdl-button mdl-button--icon edit_dept" id="'+dept_arr[i].id+'"><i class="material-icons">edit</i></button></td>';
        		out += '<tr>';
        	}
        	$('.dept_table > tbody').empty();
        	$('.dept_table > tbody').append(out);
        }
</script>