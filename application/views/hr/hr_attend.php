<style type="text/css">
	.emp{
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc; 
		padding: 30px;
		text-align: center;
	}

</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col emp emp_attend">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input type="text" data-type="date" id="attend_date" class="mdl-textfield__input">
				<label class="mdl-textfield__label" for="attend_date">Select Date</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<select class="mdl-textfield__input" id="e_name" name="e_name">
					<option value="all">Select All</option>
					<?php 
						for ($i=0; $i < count($employee) ; $i++) { 
							echo "<option value='".$employee[$i]->icbd_value."'>".$employee[$i]->icbd_value."</option>";
						} 
					?>
				</select>
				<label class="mdl-textfield__label" for="s_name">Select Department Name</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col emp employee_details" style="display: none;">
			<div class="mdl-grid emp_status">
				<button class="mdl-button mdl-button--colored present"><i class="material-icons">thumb_up</i> Present all</button>
				<button class="mdl-button mdl-button--colored unpresent"><i class="material-icons">thumb_down</i> Unpresent all</button>
			</div>
			<table class="mdl-data-table mdl-js-data-table" style="width: 100%;" id="emp_list">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Present</th>
						<th class="mdl-data-table__cell--non-numeric">Employee Name</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit"><i class="material-icons">done</i></button>
		</div>
	</div>
</body>
<script>
	var emp_arr = [];
	var today = '';
	$(document).ready(function() {
		$('#attend_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();
		today = yyyy + '-' + mm + '-' + dd;

		$('#e_name').change(function (e) {
			e.preventDefault();
			var dname = $(this).val();
			$.post('<?php echo base_url()."Hr/hr_get_emp"; ?>',{
				'dname' : dname,
				'fdate' : $('#attend_date').val()
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.employee_details').css('display','block');
				emp_arr = [];
				if (a.attend_list.length > 0) {
					for (var j = 0; j < a.attend_list.length; j++) {
						for (var i = 0; i < a.emp_list.length; i++) {
							if (a.attend_list[j].ica_cid == a.emp_list[i].ic_id) {
								if (a.attend_list[j].ica_status == '1') {
									emp_arr.push({'id' : a.emp_list[i].ic_id , 'name' : a.emp_list[i].ic_name , 'status' : 'true'});
								}else{
									emp_arr.push({'id' : a.emp_list[i].ic_id , 'name' : a.emp_list[i].ic_name , 'status' : 'false'});
								}
							}
						}	
					}
				}else{
					for (var i = 0; i < a.emp_list.length; i++) {
						emp_arr.push({'id' : a.emp_list[i].ic_id , 'name' : a.emp_list[i].ic_name , 'status' : 'false'});				
					}
				}
				display_emp();
			}, 'text');
		})

		$('.present').click(function (e) {
			e.preventDefault();
			for (var i = 0; i < emp_arr.length; i++) {
				emp_arr[i].status = 'true';
			}
			display_emp();
		})
		$('.unpresent').click(function (e) {
			e.preventDefault();
			for (var i = 0; i < emp_arr.length; i++) {
				emp_arr[i].status = 'false';
			}
			display_emp();
		})
		$('#emp_list').on('click','.attend_status',function (e) {
			e.preventDefault();
			var str = $(this).prop('id');
			var status = str.substring(0, 1);
			var id = str.substring(1, str.length);
			for (var i = 0; i < emp_arr.length; i++) {
				if (emp_arr[i].id == id) {
					if (status == 'p') {
						emp_arr[i].status = 'false';
					}else{
						emp_arr[i].status = 'true';
					}
				}
			}
			display_emp();
		})

		$('#submit').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Hr/hr_attend_emp_save"; ?>',{
				'employee_list' : emp_arr,
				'attend_date' : $('#attend_date').val()
			},function(data, status, xhr) {
				window.location = "<?php echo base_url().'Hr/hr_attend';?>";
			}, 'text');
		})
	});

	function display_emp() {
		var out = '';
		if (emp_arr.length > 0 ) {
			for (var i = 0; i < emp_arr.length; i++) {
				out += '<tr>';
				out += '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--raised attend_status"';
				if (emp_arr[i].status == 'true') {
					out += 'id="p'+emp_arr[i].id+'" style="background-color:green;color:white;">Present</button>';
				}else{
					out += 'id="u'+emp_arr[i].id+'" style="background-color:red;color:white;">Unpresent</button>';
				}
				out +='</td>';
				out += '<td class="mdl-data-table__cell--non-numeric">' + emp_arr[i].name + '</td></tr>';
			}
		}else{
			out += '<h2>No employee found !</h2>';
			$('#emp_list > thead').hide();
			$('.emp_status').hide();
		}
		$('#emp_list > tbody').empty();
		$('#emp_list > tbody').append(out);
	}
</script>
</html>