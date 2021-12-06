<style>
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

.ui-widget-content{
	z-index: 1111 !important;
}

.panel {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}

.loader {
	position: fixed;
    border: 5px solid #f3f3f3;
	-webkit-animation: spin 2s linear infinite; /* Safari */
	animation: spin 1s linear infinite;
	border-top: 5px solid #555;
	border-radius: 50%;
	width: 50px;
	height: 50px;
	left: 47%;
	top: 50%;
	z-index: 1111111 !important;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 88vh;overflow: auto;">
			<table class="general_table" style="width: 100%;">
				<thead>
					<tr>
						<th>Sr. no</th>
						<th>Mobile App Name</th>
					</tr>
				</thead>
				<tbody id="app_details">
					<?php
					if (isset($mobile_set)) {
						for ($i=0; $i < count($mobile_set) ; $i++) {
							echo '<tr class="mobile_view" id="'.$mobile_set[$i]->iextetm_id.'">';
							echo '<td>'.$mobile_set[$i]->iextetm_id.'</td>';
							echo '<td>'.$mobile_set[$i]->iextetm_company_name.'</td>';
							echo '</tr>';
						}	
					}
					?>
				</tbody>
			</table>
		</div>
		<div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding-left: 30px;height: 88vh;overflow: auto;">
			<div class="mdl-grid mu_setting_btn" style="display: none;">
				<div class="mdl-cell mdl-cell--10-col">
					<h2 class="mobile_title" style="font-weight: bolder;"></h2>
				</div>
				<div class="mdl-cell mdl-cell--2-col" style="text-align: right;">
					<button class="mdl-button mdl-button--colored mu_setting"><i class="material-icons" style="font-size: 2em;">settings</i> Setting</button>
				</div>
				<div class="mdl-cell mdl-cell--10-col">
					<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" placeholder="Search User Name" style="font-size: 1.2em;outline: none;">
				</div>
				<div class="mdl-cell mdl-cell--2-col">
					<button class="mdl-button mdl-button--colored mu_search"><i class="material-icons" style="font-size: 2em;">search</i> search</button>
				</div>
			</div>
			<div class="mdl-grid mu_user_list"></div>
		</div>
	</div>
</main>
</div>
</body>
<div class="modal fade" id="user_details" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col"><h2>User Deatils</h2><hr></div>
					<div class="mdl-cell mdl-cell--12-col details_table"></div>
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;display: flex;">
						<button class="mdl-button mdl-button--colored mdl-button--raise submit_block" style="display: none;">Block</button>
						<button class="mdl-button mdl-button--colored mdl-button--raise submit_unblock" style="display: none;">UnBlock</button>
						<button class="mdl-button mdl-button--colored mdl-button--raise submit_delete">Delete</button>
						<button class="mdl-button mdl-button--colored mdl-button--raise" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="user_setting" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col"><h3>Mobile Users setting </h3><hr></div>
					<div class="mdl-cell mdl-cell--6-col" style="text-align: center;">
						<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="mu_otp_status" style="margin-left: 40%;">
							<input type="checkbox" id="mu_otp_status" class="mdl-switch__input" <?php if (isset($mobile_set)) { if ($mobile_set[0]->iextetm_feedback_type == 'true') { echo "checked";}} ?>>
                		</label>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="text-align: left;">
						<p>On for Mobile App base verify </p><p>Off for OTP base verify</p>
					</div>
					<div class="mdl-cell mdl-cell--12-col" style="text-align: left;"><hr>
						<label style="font-size: 1.2em;">Share with user</label>
							<ul id="mutual_tag">
								<?php
									if (isset($grp_name)) {
										echo "<li>".$grp_name."</li>";
									}
								?>
							</ul>
					</div>
					<div class="mdl-cell mdl-cell--12-col" style="text-align: right;"><hr>
						<button class="mdl-button mdl-button--colored save_otp_status"><i class="material-icons">save</i>save</button>
						<button class="mdl-button mdl-button--colored" data-dismiss="modal"><i class="material-icons">close</i>close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var user_arr = [];
	var group_arr = [];
	var index_id = 0;
	var usr_id = 0;
	var mobile_id = 0;
	<?php
		if (isset($mob_group)) {
			for ($i=0; $i < count($mob_group) ; $i++) { 
				echo "group_arr.push('".$mob_group[$i]->iug_name."');";
			}
		}
	?>
	$(document).ready(function() {
		$('#mutual_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : group_arr,
    		singleField : true,
    		tagLimit : 1
    	});

		$('.mobile_view').click(function(e){
			e.preventDefault();
			mobile_id = $(this).prop('id');
			$('.loader').show();
    		$.post('<?php echo base_url()."Account/get_mobile_users/".$code.'/'; ?>'+mobile_id
    		, function(data, status, xhr) {
    			$('.loader').hide();
				var a = JSON.parse(data);
				if (a.mob_user.length > 0 ) {
					for (var i=0; i < a.mob_user.length ; i++) { 
						user_arr.push({'id' : a.mob_user[0].iextetmu_id , 'name' : a.mob_user[0].iextetmu_name , 'email' : a.mob_user[0].iextetmu_email, 'company' : a.mob_user[0].iextetmu_company , 'gst_no' : a.mob_user[0].iextetmu_gst_no , 'phone' : a.mob_user[0].iextetmu_phone_no , 'add' : a.mob_user[0].iextetmu_address ,'status': a.mob_user[0].iextetmu_status});
					}
				}
				display_mobile_user_list();
				if (a.mobile_set.length > 0) {
					$('.mobile_title').append(a.mobile_set[0].iextetm_company_name);
				}
			}, "text");
		});

		$('.submit_block').click(function (e) {
    		e.preventDefault();
    		$('.loader').show();
    		$.post('<?php echo base_url()."Account/mobile_user_update/".$code.'/'; ?>'+usr_id+'/block'
    		, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Account/mobile_users/".$code; ?>';
			}, "text");
    	});

    	$('.submit_unblock').click(function (e) {
    		e.preventDefault();
    		$('.loader').show();
    		$.post('<?php echo base_url()."Account/mobile_user_update/".$code.'/'; ?>'+usr_id
    		, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Account/mobile_users/".$code; ?>';
			}, "text");
    	});

    	$('.submit_delete').click(function (e) {
    		e.preventDefault();
    		$('.loader').show();
    		$.post('<?php echo base_url()."Account/mobile_user_delete/".$code.'/'; ?>'+usr_id
    		, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Account/mobile_users/".$code; ?>';
			}, "text");
    	});

		$('.mu_user_list').on('click','.tbl_view',function (e) {
			e.preventDefault();
			usr_id = $(this).prop('id');
			for (var i = 0; i < user_arr.length; i++) {
				if(user_arr[i].id == usr_id){
					index_id = i;
				}
			}
			display_details();
			$('#user_details').modal('show');
		});

		$('.mu_setting_btn').on('keyup','#cust_name',function (e) {
			e.preventDefault();
			var c_name = $(this).val();
			$.post('<?php echo base_url()."Account/search_mobile_users/".$code.'/'; ?>'+mobile_id,{
				'c_name' : c_name
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				user_arr = [];
				if (a.mob_user.length > 0 ) {
					for (var i=0; i < a.mob_user.length ; i++) { 
						user_arr.push({'id' : a.mob_user[0].iextetmu_id , 'name' : a.mob_user[0].iextetmu_name , 'email' : a.mob_user[0].iextetmu_email, 'company' : a.mob_user[0].iextetmu_company , 'gst_no' : a.mob_user[0].iextetmu_gst_no , 'phone' : a.mob_user[0].iextetmu_phone_no , 'add' : a.mob_user[0].iextetmu_address ,'status': a.mob_user[0].iextetmu_status});
					}
				}
				display_mobile_user_list();
			}, "text");
		});

		$('.mu_setting').click(function (e) {
			e.preventDefault();
			$('#user_setting').modal('show');
		});

		$('#user_setting').on('click', '.save_otp_status', function(e) {
            var status = $('#mu_otp_status')[0].checked;
            var grp_name = [];
            $('#mutual_tag > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					grp_name.push(tmpstr);
				}
			});
			console.log(grp_name);
            $.post('<?php echo base_url()."Account/mobile_user_feedback_type/".$code.'/'; ?>',{
            	'status' : status , 
            	'group' : grp_name
    		}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Account/mobile_users/".$code; ?>';
			}, "text");
        });
		function display_mobile_user_list() {
			var out = '';
			$('.mu_setting_btn').css('display','');
			out += '<div class="mdl-cell mdl-cell--12-col"><table class="general_table" style="width: 100%;"><thead><tr><th>User Id</th><th>Name</th><th>Email</th></tr></thead><tbody id="details">';
			if (user_arr.length > 0 ) {
				for (var i=0; i < user_arr.length ; i++) {
					if (user_arr[i].status == 'block') {
						out += '<tr style="font-weight: bold;color:red;" class="tbl_view" id="'+user_arr[i].id+'">';
					}else{
						out += '<tr style="font-weight: bold;" class="tbl_view" id="'+user_arr[i].id+'">';
					}
					out += '<td>'+user_arr[i].id+'</td>';
					out += '<td>'+user_arr[i].name+'</td>';
					out += '<td>'+user_arr[i].email+'</td>';
					out += '</tr>';
				}
			}else{
				out += '<tr><td colspan="3" style="text-align:center;">No records found !</td></tr>';
			}
			out += '</tbody></table>';
			$('.mu_user_list').empty();
			$('.mu_user_list').append(out);
		}

		function display_details() {
			var out = '';
			if (user_arr.length > 0 ) {
				out +='<tr><td>Name  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+user_arr[index_id].name+'</td></tr>';
				out +='<tr><td>Email  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+user_arr[index_id].email+'</td></tr>';
				out +='<tr><td>Company  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+user_arr[index_id].company+'</td></tr>';
				out +='<tr><td>Gst No.  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+user_arr[index_id].gst_no+'</td></tr>';
				out +='<tr><td>Phone  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+user_arr[index_id].phone+'</td></tr>';
				out +='<tr><td>Address  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+user_arr[index_id].add+'</td></tr>';
				if (user_arr[index_id].status == 'block') {
					$('.submit_unblock').css('display','block');
				}else{
					$('.submit_block').css('display','block');
				}
			}else{
				out +='<tr><td colspan="3" style="text-align:center;">Not found ! </td></tr>';
			}
			$('.details_table').empty();
			$('.details_table').append(out);
		}
	});
</script>