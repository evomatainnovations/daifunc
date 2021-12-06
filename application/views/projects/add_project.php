<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Project Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col" style="padding-left: 20px;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
								<input type="text" id="p_name" name="p_name" class="mdl-textfield__input" value="<?php if(isset($edit_project)) { echo $edit_project[0]->iextpp_p_name; } ?>">
								<label class="mdl-textfield__label" for="p_name">Project Name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col" style="padding-left: 20px;">	
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
								<textarea id="p_description" name="p_description" class="mdl-textfield__input"><?php if(isset($edit_project)) { echo $edit_project[0]->iextpp_p_description; } ?></textarea>
								<label class="mdl-textfield__label" for="p_description">Description</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--6-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
										<input type="text" data-type="date" id="p_start_date" class="mdl-textfield__input" value="<?php if(isset($edit_project)) { echo $edit_project[0]->iextpp_p_start_date; }else{ echo date('Y-m-d'); } ?>">
										<label class="mdl-textfield__label" for="p_start_date">Select start Date</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--6-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
										<input type="text" data-type="date" id="p_end_date" class="mdl-textfield__input" value="<?php if(isset($edit_project)) { echo $edit_project[0]->iextpp_p_end_date; } ?>">
										<label class="mdl-textfield__label" for="p_end_date">Select end Date</label>
									</div>
								</div>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col" style="text-align: left;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label>Tags</label>
								<ul id="pro_tag">
									<?php 
										if(isset($pro_tags)) {
											for ($i=0; $i <count($pro_tags) ; $i++) { 
												echo "<li>".$pro_tags[$i]->it_value."</li>";
											}
										}
									?>
								</ul>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<?php 
								echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;margin-top:20px;"> <select class="mdl-textfield__input" id="p_status">';
								if(isset($edit_project)) {
									if ($edit_project[0]->iextpp_p_status == "open") {
										echo '<option value="open" selected>Open</option>';
									} else {
										echo '<option value="open">Open</option>';
									}

									if ($edit_project[0]->iextpp_p_status == "closed") {
										echo '<option value="closed" selected>Closed</option>';
									} else {
										echo '<option value="closed">Closed</option>';
									}
								}else{
									echo '<option value="open">Open</option><option value="closed">Closed</option>';
								}
								echo '</select><label class="mdl-textfield__label" for="p_status">Select Status</label></div>';
							?>	
						</div>
						<?php
							if (isset($edit_project)) {
								echo '<div class="mdl-cell mdl-cell--6-col" style="padding-left: 20px;">';
								if ($edit_project[0]->iextpp_gid == 0) {
									echo '<button class="mdl-button mdl-button--colored grp_modal"><i class="material-icons">compare_arrows</i>Transfer to Group</button>';
								}else if (isset($userflow)) {
									if ($userflow == 'true') {
										echo '<button class="mdl-button mdl-button--colored transfer_to_self_acc"><i class="material-icons">compare_arrows</i> Transfer to my account</button>';
									}
								}
								echo '</div><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button--colored project_delete"><i class="material-icons">delete</i></button></div>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col project_users">
			<div class="mdl-grid">
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
					<thead>
						<tr>
							<th class="mdl-data-table__cell--non-numeric">Name</th>
							<th class="mdl-data-table__cell--non-numeric">Add</th>
							<th class="mdl-data-table__cell--non-numeric">Admin</th>
						</tr>
					</thead>
					<tbody id="user_list">

					</tbody>
				</table>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="p_submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>

<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Select Group for transfer</h4>
				</div>
				<div class="modal-body">
					<div class="mdl-textfield mdl-js-textfield">
					    <input class="mdl-textfield__input" type="text" id="g_search">
					    <label class="mdl-textfield__label" for="g_search">Group</label>
					</div>
					<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="account_search"><i class="material-icons">search</i> Search</button>
					<div id="grp_body">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	var user_array = [];
	var contact_array = [];
	var options = [];
	var edit_flag=false;
	var gid = '';
	var add_arr = [];
	var admin_arr = [];
	var user_data = [];
	var tag_data = [];
	<?php
		for ($i=0; $i < count($user_connection); $i++) {
    		echo "user_data.push({'id' : '".$user_connection[$i]->iug_id."', 'name' : '".$user_connection[$i]->iug_name."'});";
		}

		for ($i=0; $i < count($tags) ; $i++) { 
			echo "tag_data.push('".$tags[$i]->it_value."');";
		}
	
		if (isset($edit_user_list)) {
			for ($i=0; $i <count($edit_user_list) ; $i++) {
				if ($edit_user_list[$i]->ium_admin == 'true' || $edit_user_list[$i]->i_uid == $oid) {
					if ($edit_user_list[$i]->ic_name == '') {
						echo "user_array.push({'id' : '".$edit_user_list[$i]->i_uid."', 'email' : '".$edit_user_list[$i]->i_uname."', 'admin' : 'true', 'project' : 'true', 'group' : 'true'});";
					}else{
						echo "user_array.push({'id' : '".$edit_user_list[$i]->i_uid."', 'email' : '".$edit_user_list[$i]->ic_name."', 'admin' : 'true','project' : 'true', 'group' : 'true'});";	
					}
				}else if ($edit_user_list[$i]->i_uid != $oid){
					if ($edit_user_list[$i]->iextprour_project == 'true') {
						$project = 'true';
					}else{
						$project = 'false';
					}
					if ($edit_user_list[$i]->iextprour_group == 'true') {
						$group = 'true';
					}else{
						$group = 'false';
					}
					if ($edit_user_list[$i]->ic_name == '') {
						echo "user_array.push({'id' : '".$edit_user_list[$i]->i_uid."', 'email' : '".$edit_user_list[$i]->i_uname."', 'admin' : 'false','project' : '".$project."', 'group' : '".$group."'});";
					}else{
						echo "user_array.push({'id' : '".$edit_user_list[$i]->i_uid."', 'email' : '".$edit_user_list[$i]->ic_name."', 'admin' : 'false','project' : '".$project."', 'group' : '".$group."'});";
					}
				}
			}
		}else{
			if (!isset($p_user_list)) {
				echo "$('.project_users').css('display','none');";
			}
		}

		if (isset($p_user_list)) {
			if (count($p_user_list) > 0) {
				for ($i=0; $i <count($p_user_list) ; $i++) {
					if ($p_user_list[$i]->ium_admin == 'true' && $p_user_list[$i]->i_uid != $oid) {
						if ($p_user_list[$i]->ic_name == '') {
							if ($p_user_list[$i]->i_uname == '') {
								echo "user_array.push({'id' : '".$p_user_list[$i]->i_uid."', 'email' : '".$p_user_list[$i]->i_uname."', 'admin' : 'true', 'project' : 'true', 'group' : 'true'});";
							}else{
								echo "user_array.push({'id' : '".$p_user_list[$i]->i_uid."', 'email' : '".$p_user_list[$i]->ium_u_id."', 'admin' : 'true', 'project' : 'true', 'group' : 'true'});";
							}
						}else{
							echo "user_array.push({'id' : '".$p_user_list[$i]->i_uid."', 'email' : '".$p_user_list[$i]->ic_name."', 'admin' : 'true','project' : 'true', 'group' : 'true'});";	
						}
					}else if ($p_user_list[$i]->i_uid != $oid){
						if ($p_user_list[$i]->ic_name == '') {
							if ($p_user_list[$i]->i_uname == '') {
								echo "user_array.push({'id' : '".$p_user_list[$i]->i_uid."', 'email' : '".$p_user_list[$i]->i_uname."', 'admin' : 'false','project' : 'false', 'group' : 'false'});";
							}else{
								echo "user_array.push({'id' : '".$p_user_list[$i]->i_uid."', 'email' : '".$p_user_list[$i]->ium_u_id."', 'admin' : 'true', 'project' : 'true', 'group' : 'true'});";
							}
						}else{
							echo "user_array.push({'id' : '".$p_user_list[$i]->i_uid."', 'email' : '".$p_user_list[$i]->ic_name."', 'admin' : 'false','project' : 'false', 'group' : 'false'});";
						}
					}
					
				}
			}
		}else{
			if (!isset($edit_user_list)) {
				echo "$('.project_users').css('display','none');";
			}
		}
	?>
	$(document).ready(function() {
		append_user();

		$('#p_start_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		$('#p_end_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		$('#p_submit').click(function(e) {
			e.preventDefault();
			var tags = [];
			$('#pro_tag > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					tags.push(tmpstr);
				}
			});

			$.post('<?php if(isset($edit_project)) { echo base_url()."Projects/update_project/".$pid."/".$code; } else { echo base_url()."Projects/save_project/".$code; } ?>', {
				'name' : $('#p_name').val(),
				'description':$('#p_description').val(),
				'users' : user_array,
				'tags' : tags,
				's_date' : $("#p_start_date").val(),
				'e_date' : $("#p_end_date").val(),
				'p_status' : $("#p_status").val()
			}, function(data, status, xhr) {
					window.location = '<?php echo base_url()."Projects/edit_project_details/".$code."/"; ?>' + data;
			}, 'text');
		});

		$('.grp_modal').click(function (e) {
			e.preventDefault();
			switch_account();
			$('#myModal').modal('show');
		});

		$('#pro_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data,
    		singleField : true
    	});

		$('#grp_body').on('click','.transfer_to_group',function (e) {
			e.preventDefault();
			var gid = $(this).prop('id');
			$.post('<?php echo base_url()."Projects/project_transfer/".$pid."/".$code."/"; ?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Projects/view/null/".$code; ?>';
			}, 'text');
		});

		$('.transfer_to_self_acc').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Projects/project_transfer/".$pid."/".$code."/0" ; ?>'
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Projects/view/null/".$code; ?>';
			}, 'text');
		});

		$('.project_delete').click(function (e) {
			e.preventDefault();
			window.location = '<?php echo base_url()."Projects/project_delete/".$pid."/".$code;?>';
		});

		$('#myModal').on('click','#account_search',function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Home/account_search/".$code; ?>', {
        		's_account' : $('#g_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		user_data = [];
        		for (var i=0; i < d.account.length; i++) {
            		user_data.push({'id' : d.account[i].iug_id, 'name' : d.account[i].iug_name});
        		}
        		switch_account();
        	});
		});

	    $('#user').on('change', 'input[type=checkbox]', function(e) {
	        var id = $(this).prop('id');
	        $('#user').removeAttr('checked');
	        $(this).addAttr('checked');
	    });

	    $('#user_list').on('click','.add',function (e){
	    	var a = $(this).prop('id');
			var status = a.substring(0, 3);
			var mid = a.substring(3, a.length);
			
			if (status == 'adm') {
				for (var i = 0; i < user_array.length; i++) {
					if(user_array[i].id == mid){
						if (user_array[i].project == 'true') {
							user_array[i].project = 'false';
						}else{
							user_array[i].project = 'true';
							user_array[i].group = 'true';
						}
					}
				}
			}else{
				for (var i = 0; i < user_array.length; i++) {
					if(user_array[i].id == mid){
						if (user_array[i].group == 'true') {
							user_array[i].group = 'false';
							user_array[i].project = 'false';
						}else{
							user_array[i].group = 'true';
						}
					}
				}
			}
			append_user();
	    });

		function append_user(){
	        var a = "";
	        console.log(user_array);
	        if(user_array.length > 0){
	        	for (var i = 0; i < user_array.length; i++) {
	        		a +='<tr><td class="mdl-data-table__cell--non-numeric"><h4>'+user_array[i].email+'</h4></td>';
	        		a +='<td class="mdl-data-table__cell--non-numeric">';
	        		if (user_array[i].admin == 'true') {
	        			a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="'+user_array[i].id+'"><i class="material-icons">add</i></button>';
	        			a +='</td><td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="'+user_array[i].id+'"><i class="material-icons">person</i></button>';
	        		}else if (user_array[i].project == 'true') {
        				a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored add" id="add'+user_array[i].id+'"><i class="material-icons">add</i></button>';
        				a +='</td><td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored add" id="adm'+user_array[i].id+'"><i class="material-icons" >person</i></button>';
	        		}else if (user_array[i].group == 'true') {
	        			a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored add" id="add'+user_array[i].id+'"><i class="material-icons">add</i></button>';
        				a +='</td><td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised add" id="adm'+user_array[i].id+'"><i class="material-icons" >person</i></button>';
	        		}else {
	        			a+='<button class="mdl-button mdl-js-button mdl-button--raised add" id="add'+user_array[i].id+'"><i class="material-icons">add</i></button>';
        				a +='</td><td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised add" id="adm'+user_array[i].id+'"><i class="material-icons" >person</i></button>';
	        		}
	        		a +='</td></tr>';
	        	}
	        }
	        $('#user_list').empty();
	        $('#user_list').append(a);

	    }

	    function switch_account(){
			var out = '';
			if (user_data.length > 0) {
				for (var i=0; i < user_data.length; i++) {
	        		if (gid == user_data[i].id) {
	        			out+= '<button class="mdl-button mdl-button--raised mdl-button--colored transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
	        		}else{
	        			out+= '<button class="mdl-button transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
	        		}
	    		}
			}else{
				out +='<h3>No records found !!</h3>'
			}
			
    		$('#grp_body').empty();
        	$('#grp_body').append(out); 

		}

	});
</script>
</html>