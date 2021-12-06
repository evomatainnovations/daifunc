<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<main class="mdl-layout__content">
	<div class="mdl-grid">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;" id="mod">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Select</th>
						<th class="mdl-data-table__cell--non-numeric">Module</th>
						<th class="mdl-data-table__cell--non-numeric">User limit</th>
						<th class="mdl-data-table__cell--non-numeric">Subscription start</th>
						<th class="mdl-data-table__cell--non-numeric">Months</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
		</div>
		<div class="mdl-grid" style="<?php if ($subcid==null) { echo 'display: block;'; } else { echo 'display: none;'; } ?>">
			<h3>Invited User List</h3>
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;" id="usr">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">User Name</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($user_list) ; $i++) { 
							echo '<tr id="'.$user_list[$i]->iui_u_id.'" class="click_user">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$user_list[$i]->iui_email;
							echo "</tr>";
						}
					?>		
				</tbody>
			</table>
		</div>
		<!-- <a href="<?php echo base_url().'Portal/update_modules_customer'; ?>"> -->
			<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
				<i class="material-icons">done</i>
			</button>
		<!-- </a> -->
	</div>
</main>
</div>
</body>
<script>
	var btn_array = [];

	$(document).ready(function() {
//		$('#m_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		<?php for ($i=0; $i < count($modules) ; $i++) { 
				$flg = "";
				$u_count = "";
				$sub = '';
				$month = '';
				$diff = '';
				for ($k=0; $k < count($modules_user); $k++) { 
					if ($modules_user[$k]->ium_m_id == $modules[$i]->im_id) {
						if ($modules_user[$k]->ium_status == "active") {
							$flg="a";
							$u_count = $modules_user[$k]->ium_user_limit;
							$sub = $modules_user[$k]->ium_subscription_start;
							$month = $modules_user[$k]->ium_subscription_end;
							$ts1 = strtotime($sub);
							$ts2 = strtotime($month);

							$year1 = date('Y', $ts1);
							$year2 = date('Y', $ts2);

							$month1 = date('m', $ts1);
							$month2 = date('m', $ts2);

							$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						} else if ($modules_user[$k]->ium_status == "suspend") {
							$flg="s";
							$u_count = $modules_user[$k]->ium_user_limit;
							$sub = $modules_user[$k]->ium_subscription_start;
							$month = $modules_user[$k]->ium_subscription_end;
							$ts1 = strtotime($sub);
							$ts2 = strtotime($month);

							$year1 = date('Y', $ts1);
							$year2 = date('Y', $ts2);

							$month1 = date('m', $ts1);
							$month2 = date('m', $ts2);

							$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						} else if ($modules_user[$k]->ium_status == "terminate") {
							$flg="t";
							$u_count = $modules_user[$k]->ium_user_limit;
							$sub = $modules_user[$k]->ium_subscription_start;
							$month = $modules_user[$k]->ium_subscription_end;
							$ts1 = strtotime($sub);
							$ts2 = strtotime($month);

							$year1 = date('Y', $ts1);
							$year2 = date('Y', $ts2);

							$month1 = date('m', $ts1);
							$month2 = date('m', $ts2);

							$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
						}
					}
				}
				if ($flg=="a") {
					echo "btn_array.push({ 'mid' : ".$modules[$i]->im_id.", 'status' : 'active', 'mname' : '".$modules[$i]->im_name."', 'limit' : '".$u_count."', 'sub' : '".$sub."' , 'month' : '".$diff."'});";
				} 
				else if($flg=="s") {
					echo "btn_array.push({ 'mid' : ".$modules[$i]->im_id.", 'status' : 'suspend', 'mname' : '".$modules[$i]->im_name."', 'limit' : '".$u_count."', 'sub' : '".$sub."' , 'month' : '".$diff."'});";
				} else if($flg=="t") {
					echo "btn_array.push({ 'mid' : ".$modules[$i]->im_id.", 'status' : 'terminate', 'mname' : '".$modules[$i]->im_name."', 'limit' : '".$u_count."', 'sub' : '".$sub."' , 'month' : '".$diff."'});";
				} else if($flg=="") {
					echo "btn_array.push({ 'mid' : ".$modules[$i]->im_id.", 'status' : 'null', 'mname' : '".$modules[$i]->im_name."', 'limit' : '".$u_count."', 'sub' : '".$sub."' , 'month' : '".$diff."'});";
				}
			}
		?>

		module_table_load();
		$("#mod").on('click','button', function(e){
			e.preventDefault();
			var a=$(this).prop('id');
			console.log(a);
			var status = a.substring(0, 1);
			var mid = a.substring(1, a.length);
			
			for (var i = 0; i < btn_array.length; i++) {
				if (btn_array[i].mid == mid) {
					console.log(btn_array[i].mid);
					if (status == "a") {
						btn_array[i].status="active";
					} else if(status=="s"){
						btn_array[i].status="suspend";
					} else if (status=="t"){
						btn_array[i].status="terminate";
					} else{
						btn_array[i].status="null";
					}	
				}
			}
			module_table_load();
		});
		
		$('.click_user').click(function(e) {
			e.preventDefault();
			var a = $(this).prop('id');
			window.location = "<?php echo base_url().'Portal/allot_modules_customer/'.$cid.'/'; ?>" + a;
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			var detail_arr = [];
			for (var i = 0; i < btn_array.length; i++) {
				if (btn_array[i].status == 'active') {
					var sub = $('#m_date'+btn_array[i].mid).val();
					var month = $('#m_month'+btn_array[i].mid).val();
					detail_arr.push({mid : btn_array[i].mid, sub : sub ,moths: month});
				}
			}
			$.post("<?php echo base_url().'Portal/update_modules_customer/'.$cid.'/'.$subcid; ?>", {
				'module' : btn_array,
				'detail' : detail_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Portal/allot_modules"; ?>'
			}, "text");
		});

		$(".u_count").keyup(function(){
		    var mid = $(this).prop('id');
		    var u_count = $(this).val();

		    for (var i = 0; i < btn_array.length; i++) {
				if (btn_array[i].mid == mid) {
					btn_array[i].limit = u_count;
				}
			}
		});
		
		$('body').on('focus',".dates", function(e){
			e.preventDefault();
			var id = $(this).prop('id');
			$(this).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}).datepicker("show");
		});

		// $('body').on('focus',".e_dates", function(e){
		// 	e.preventDefault();
		// 	var id = $(this).prop('id');
		// 	$(this).datepicker({ changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd'}).datepicker("show");
		// });

		function module_table_load() {
			var a="";
			for (var i = 0; i < btn_array.length; i++) {
				a+='<tr><td class="mdl-data-table__cell--non-numeric">' + btn_array[i].mname + '</td><td class="mdl-data-table__cell--non-numeric">';
				if (btn_array[i].status == "active") {
					a+='<button type="button" id="a' + btn_array[i].mid + '" class="mdl-button mdl-button--raised mdl-button--colored">Active</button>';
					a+='<button type="button" id="s' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Suspend</button>';
					a+='<button type="button" id="t' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Terminate</button>';
				}
				 else if (btn_array[i].status == "suspend") {
					a+='<button type="button" id="a' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Active</button>';
					a+='<button type="button" id="s' + btn_array[i].mid + '" class="mdl-button mdl-button--raised mdl-button--colored">Suspend</button>';
					a+='<button type="button" id="t' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Terminate</button>';
				} else if (btn_array[i].status == "terminate") {
					a+='<button type="button" id="a' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Active</button>';
					a+='<button type="button" id="s' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Suspend</button>';
					a+='<button type="button" id="t' + btn_array[i].mid + '" class="mdl-button mdl-button--raised mdl-button--colored">Terminate</button>';
				} else {
					a+='<button type="button" id="a' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Active</button>';
					a+='<button type="button" id="s' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Suspend</button>';
					a+='<button type="button" id="t' + btn_array[i].mid + '" class="mdl-button mdl-button--raised">Terminate</button>';
				} 
				a+='</td>';
				a+='<td class="mdl-data-table__cell--non-numeric">';
				a+='<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input id="'+btn_array[i].mid+'" class="mdl-textfield__input u_count" type="text" pattern="-?[0-9]*(\.[0-9]+)?" value="'+btn_array[i].limit+'"><label class="mdl-textfield__label" for="sample4">User limit</label><span class="mdl-textfield__error">Input is not a number!</span></div>';
				a+='</td>';
				a+='<td style="text-align:left;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" data-type="date" id="m_date'+btn_array[i].mid+'" value="'+btn_array[i].sub+'" class="mdl-textfield__input dates"><label class="mdl-textfield__label" for="m_sub">Select Subscription start</label></div></td>';

				a+='<td style="text-align:left;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="m_month'+btn_array[i].mid+'" value="'+btn_array[i].month+'" name="m_month" class="mdl-textfield__input e_dates"><label class="mdl-textfield__label" for="m_month">Enter month</label></div></td>';
				a+='</tr>';
			}
			$('#mod > tbody').empty();
			$('#mod > tbody').append(a);
		}
	});
</script>

</html>