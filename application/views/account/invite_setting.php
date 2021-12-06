<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
	.list_table {
		width: 100%;
        text-align: left;
        font-size: 1.2em;
        border: 0px solid #ccc;
        border-collapse: collapse;
    }
	@media only screen and (max-width: 760px) {
		.list_table {
			display: block;
        	overflow: auto;
		}
	}

	.list_table > thead > tr {
		box-shadow: 0px 5px 5px #ccc;
	}

	.list_table > thead > tr > th {
		padding: 10px;
	}

	.list_table > tbody > tr {
		border-bottom: 1px solid #ccc;
	}

	.list_table > tbody > tr > td {
		padding: 15px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid" id="load" >
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield" style="width: 80%;">
							<input type="text" id="inv_group" class="mdl-textfield__input" style="font-size: 3em;outline: none;" placeholder="Group Name">
						</div>
						<?php
							if (isset($g_limit)) {
								if ($g_limit > $g_created) {
									echo "<p>Now you can create only ";
									if (isset($g_limit)) {echo $g_limit - $g_created;}
									echo " group</p>";
								}else{
									echo "<p>If you want to create more group ! Please buy more group.</p>";
								}
							}
						?>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;" id="user_mod">
							<thead>
								<tr>
									<th class="mdl-data-table__cell--non-numeric">Group Name</th>
									<th class="mdl-data-table__cell--non-numeric">Action</th>
								</tr>
							</thead>
							<tbody id="user_group">
								<?php
									for ($i=0; $i < count($user_con) ; $i++) { 
										echo '<tr id="'.$user_con[$i]->iug_id.'" class="click_customer">';
										echo '<td class="mdl-data-table__cell--non-numeric">'.$user_con[$i]->iug_name;
										if (isset($admin)) {
											echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="'.$user_con[$i]->iug_id.'"> <i class="material-icons">delete</i> </button>';
										}else{
											echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored exit" id="'.$user_con[$i]->iug_id.'"> <i class="material-icons">exit_to_app</i> </button>';
										}
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col add_user">
			<div class="mdl-card mdl-shadow--4dp" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">
				<h2>Add User</h2>
				<div class="panel-group" id="accordion" style="width: 100%;margin-left: 10px;"></div>
			</div>
		</div>
		<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
		  <div class="mdl-snackbar__text"></div>
		  <button class="mdl-snackbar__action" type="button"></button>
		</div>
		<div class="mdl-cell mdl-cell--4-col" id="create_group" style="display: none;">
			<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent"  id="submit_list"><i class="material-icons">done</i></button>
		</div>
	</div>
</main>
<div class="modal fade" id="add_myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enter Email address for selected name</h4>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 250px">
				    <input class="mdl-textfield__input" type="text" id="customer_mail">
					<label class="mdl-textfield__label" for="customer_mail">Email</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="add_email">Add</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="purchase_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" id="u_no" type="text" pattern="-?[0-9]*(\.[0-9]+)?">
				    <label class="mdl-textfield__label" for="u_no">Enter number of user</label>
				    <span class="mdl-textfield__error">Input is not a number!</span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="purchase_user">Proceed</button>
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal"><i class="material-icons">close</i> close</button>
			</div>
		</div>
	</div>
</div>
</body>	
<script type="text/javascript">
	var btn_array=[];
	var user_array = [];
	var m_user_array = [];
	var options = [];
	var user_data = [];
	var cust_id = "";
	var edit_flag=false;
	var module_id = 0;
	var user_limit = 'true';
	var flg = 1;
	var limit_arr = [];
	var pur_usr = [];
	var select_module = 0 ;
	<?php
		for ($i=0; $i <count($user_list) ; $i++) {
			echo "options.push('".$user_list[$i]->ic_name."');";
		}
		if (isset($g_limit)) {
			if ($g_limit > $g_created) {
				echo "$('#create_group').css('display','block');";
			}else{
				echo "$('#create_group').css('display','none');";
			}
		}
		for ($i=0; $i < count($modules) ; $i++) {
			$m_limit = $modules[$i]->m_limit - 1 ;
			echo "btn_array.push({ 'mid' : ".$modules[$i]->mid.", 'status' : 'null', 'mname' : '".$modules[$i]->mname."', 'limit' : '".$m_limit."' , 'alias' : '".$modules[$i]->m_alias."' });";
		}
		for ($j=0; $j <count($modules_limit) ; $j++) {
			echo "limit_arr.push({'mid' : '".$modules_limit[$j]->mid."', 'm_limit' : '".$modules_limit[$j]->mid_limit."' });";
		}
	?>
$(document).ready( function() {

	if (limit_arr.length > 0) {
		for (var i = 0; i < limit_arr.length; i++) {
			for (var j = 0; j < btn_array.length; j++) {
				if (limit_arr[i].mid == btn_array[j].mid) {
					btn_array[j].limit = btn_array[j].limit - limit_arr[i].m_limit;
				}
			}
		}
	}

	var snackbarContainer = document.querySelector('#demo-toast-example');
	module_list();
	var g_flg = 'false';

	$(document).on('keyup', '.add_user', function() {
		$(this).autocomplete({
		    source: function(request, response) {
		        var results = $.ui.autocomplete.filter(options, request.term);
		        response(results.slice(0, 10));
		    }
		})
	});

    $(document).on('click','.add_button',function(e) {
        e.preventDefault();
        flg = 1;
        mid = $(this).prop('id');
        user = $('#a'+mid).val();
        $(".add_user").val('');
        $(".add_user").focus();
         $.post('<?php echo base_url()."Account/invite_users_list/".$code."/"; ?>'+mid,{
			'i_users' : user
		},function(data, status, xhr) {
			var a = JSON.parse(data);
				var limit = 0;
				if (a.c_details.length != 0) {
					for (var i = 0; i < a.c_details.length; i++) {
						for (var k = 0; k < btn_array.length; k++) {
							if(btn_array[k].mid == mid){
								limit = btn_array[k].limit;
							}
						}
						for (var ij = 0; ij< m_user_array.length; ij++) {
							if(m_user_array[ij].mid == mid){
								flg = flg + 1;
							}
						}
						if (flg <= limit) {
							if (a.c_details[i].icbd_value == null) {
								$('#add_myModal').modal('show');
								module_id = mid;
								cust_id = a.c_details[i].ic_id;
							}else{
								if (a.c_details[i].i_uname == null) {
									m_user_array.push({'id' : a.c_details[i].icbd_customer_id ,'name' : a.c_details[i].ic_name , 'email' : a.c_details[i].icbd_value, 'status' : 'Not registered', 'admin' : 'false', 'mid' : mid, 'limit' : 'ture','flg':'new'});
								}else{
									m_user_array.push({'id' : a.c_details[i].icbd_customer_id ,'name' : a.c_details[i].ic_name , 'email' : a.c_details[i].icbd_value, 'status' : 'Registered', 'admin' : 'false', 'mid' : mid, 'limit' : 'ture','flg':'new'});
								}
							}
						}
					}
				}else{
					$('#add_myModal').modal('show');
					module_id = mid;
					cust_id = a.ic_id;
				}
				user_append();
			}, "text");	
    });

    $('#add_email').click(function(e) {
        e.preventDefault();
        $.post('<?php echo base_url()."Account/invite_email_add/".$code; ?>',{
			'cust_email' : $('#customer_mail').val(),
			'cust_id' : cust_id
		},function(data, status, xhr) {
			var a = JSON.parse(data);
			console.log(a);
			for (var i = 0; i < a.c_details.length; i++) {
				if (a.status == 'register') {
					m_user_array.push({'id' : a.c_details[i].icbd_customer_id ,'name' : a.c_details[i].ic_name , 'email' : a.c_details[i].icbd_value, 'status' : 'Registered', 'admin' : 'false', 'mid' : mid, 'limit' : 'ture','flg':'new'});
				}else{
					m_user_array.push({'id' : a.c_details[i].icbd_customer_id ,'name' : a.c_details[i].ic_name , 'email' : a.c_details[i].icbd_value, 'status' : 'Not registered', 'admin' : 'false', 'mid' : mid, 'limit' : 'ture','flg':'new'});
				}
			}
			user_append();
		}, "text");	

    });

    $('#accordion').on('click', '.l_delete', function(e){
    	e.preventDefault();
    	var l_id=$(this).prop('id');
		var str = l_id.indexOf('/');
		var mid = l_id.substring(0, str);
		var uid = l_id.substring(str+1, l_id.length)
    	for (var i = 0; i < m_user_array.length; i++) {
    		if(m_user_array[i].email == uid && m_user_array[i].mid == mid){
    			if (m_user_array[i].flg == 'new') {
    				m_user_array.splice(i, 1);
    			}else{
    				m_user_array.splice(i, 1);
    				$.post('<?php echo base_url()."Account/invite_user_delete/".$code; ?>',
					{'mid' : mid,'uid' : uid, 'gid' : edit_user},function(data, status, xhr){
						var data = {message: 'user deleted !'};
		 				snackbarContainer.MaterialSnackbar.showSnackbar(data);
					}, "text");
    			}
    			break;
    		}
    	}
    	user_append();
    });

    $(document).on('change', '.make_admin', function () {
	 	var id = $(this).prop('id');
        var status = $(this)[0].checked;
        var str = id.indexOf('/');
		
		var mid = id.substring(0, str);
		var uid = id.substring(str+1, id.length)

    	for (var i = 0; i < m_user_array.length; i++) {
       		if (m_user_array[i].mid == mid && m_user_array[i].email == uid) {
       			if (m_user_array[i].flg == 'new') {
       				m_user_array[i].admin = status;
       			}else{
       				m_user_array[i].admin = status;
       				$.post('<?php echo base_url()."Account/invite_user_admin/".$code; ?>',
					{'mid' : mid,'uid' : uid, 'gid' : edit_user, 'status' : status},function(data, status, xhr){
						var data = {message: 'Change successfully done !'};
		 				snackbarContainer.MaterialSnackbar.showSnackbar(data);
					}, "text");
       			}
       		}
       	}
	});

    $(document).on('click','.pur_add',function (e) {
    	e.preventDefault();
    	select_module = $(this).prop('id');
    	$('#purchase_modal').modal('show');
    });

    $('#purchase_user').click(function (e) {
    	e.preventDefault();
    	var uno = $('#u_no').val();
    	$.post('<?php echo base_url()."Account/purchase_user_payment/".$code."/"; ?>'+uno+"/"+select_module,
		function(data, status, xhr){
			window.location = '<?php echo base_url()."Home/collection/0/".$code."/1"; ?>';
		}, "text");
    });

	function module_list() {
		var a = '';
		for (var i = 0; i < btn_array.length; i++) {
			var str = btn_array[i].mname ;
			var mname = str.replace(' ', '_');
			if (btn_array[i].alias == '') {
				btn_array[i].alias = btn_array[i].mname;
			}
			a+='<div class="panel panel-default"><div class="panel-heading aul'+btn_array[i].mid+'" style="text-align:left;"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#'+mname+'">'+btn_array[i].alias+'</a></h4></div><div id="'+mname+'" class="panel-collapse collapse"><div class="panel-body"><div class="mdl-grid">';
			a+='</div><div class="mdl-cell mdl-cell--12-col" style="padding-left: 20px;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;"><input type="text" id="a'+btn_array[i].mid+'" class="mdl-textfield__input add_user" ><label class="mdl-textfield__label" for="'+btn_array[i].mid+'">Add User</label></div></div><div><button class="mdl-button mdl-button-done mdl-js-button mdl-button--accent add_button" id="'+btn_array[i].mid+'"><i class="material-icons">add</i></button><div id="aul'+btn_array[i].mid+'">';
			a+='</div></div></div></div></div>';
		}
		$('#accordion').empty();
		$('#accordion').append(a);
	}

	function user_append() {
		var a = '';
		var limit = '';
		var mflg = 0;
		for (var ij = 0; ij < btn_array.length; ij++) {
			a+='<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width:100%"><thead><tr><th style="text-align: left;">Name</th><th style="text-align: left;">Email</th><th>Admin</th><th>Action</th></tr></thead><tbody>';
			for (var i = 0; i < m_user_array.length; i++) {
				if (m_user_array[i].mid == btn_array[ij].mid) {
					if (m_user_array[i].status == 'Not registered') {
		        		a+='<tr><td style="text-align: left;color : red;">Not registered</td>';
		        		a+='<td style="text-align: left;color : red;">'+ m_user_array[i].email +'</td>';
		        	}else{
		        		a+='<tr><td style="text-align: left;">'+ m_user_array[i].name +'</td>';
		        		a+='<td style="text-align: left;">'+ m_user_array[i].email +'</td>';
		        	}
		        	if (edit_flag == true) {
		        		if (m_user_array[i].admin == 'true') {
		            		a+='<td><input type="checkbox" id="'+btn_array[ij].mid+'/'+m_user_array[i].email+'" class="mdl-checkbox__input make_admin" checked ></td>';
		            	}else{
		            		a+='<td><input type="checkbox" id="'+btn_array[ij].mid+'/'+m_user_array[i].email+'" class="mdl-checkbox__input make_admin"></td>';
		            	}
		        	}else{
		        		if (m_user_array[i].admin == 'true') {
		            		a+='<td><input type="checkbox" id="'+btn_array[ij].mid+'/'+m_user_array[i].email+'" class="mdl-checkbox__input make_admin" checked></td>';
		            	}else{
		            		a+='<td><input type="checkbox" id="'+btn_array[ij].mid+'/'+m_user_array[i].email+'" class="mdl-checkbox__input make_admin"></td>';	
		            	}
		        	}
		            a+='<td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored l_delete" id="'+btn_array[ij].mid+'/'+ m_user_array[i].email +'"><i class="material-icons">delete</i> </button></td></tr>'; 
					mflg ++;
				}
			}
			if (mflg >= btn_array[ij].limit) {
				a+='<tr><td colspan="4" style="text-align:left;">For more user add plz purchase user  <button class="mdl-button mdl-button--colored pur_add" id="'+btn_array[ij].mid+'"><i class="material-icons">add</i> purchase user</button></td></tr>';
			}
			if (mflg != 0) {
				$('.aul'+btn_array[ij].mid).css('background-color','rgb(176, 168, 0)');	
			}
			a+='</tbody></table>';
			$('#aul'+btn_array[ij].mid).empty();
			$('#aul'+btn_array[ij].mid).append(a);
			a = '';
			limit = '';
			mflg = 0;
		}
	}
	
	var edit_user=0;
	$('.click_customer').click(function(e) {
		e.preventDefault();
		var cid = $(this).prop('id');
		edit_user = cid;
		edit_flag=true;
		flg = 1;
		$('#submit_list').css('display','block');
		$.post('<?php echo base_url()."Account/invite_edit/".$code; ?>',
		{'id' : cid},function(data, status, xhr){
			var b=JSON.parse(data);
			var lflg = '';
			m_user_array = [];
			// btn_array = [];
			if (b.create_group == 'true') {
				$('#create_group').css('display','block');
			}else{
				$('#create_group').css('display','none');
			}
			$('#inv_group').val(b.g_name[0].iug_name);
				for (var i = 0; i < b.user_list.length; i++) {
					if (b.user_list[i].i_uname == '' || b.user_list[i].ic_name == null) {
						m_user_array.push({'id' : b.user_list[i].icbd_customer_id ,'name' : b.user_list[i].ic_name , 'email' : b.user_list[i].icbd_value, 'status' : 'Not registered' ,'admin' : b.user_list[i].ium_admin , 'g_uid' : b.user_list[i].ium_u_id, 'mid' : b.user_list[i].ium_m_id, 'limit' : 'true','flg' : 'old'});
					}else{
						m_user_array.push({'id' : b.user_list[i].icbd_customer_id ,'name' : b.user_list[i].ic_name , 'email' : b.user_list[i].icbd_value, 'status' : 'Registered' ,'admin' : b.user_list[i].ium_admin , 'g_uid' : b.user_list[i].ium_u_id, 'mid' : b.user_list[i].ium_m_id, 'limit' : 'true','flg' : 'old'});
					}
				}
			module_list();
			user_append();
		}, "text");
	});

	$('.click_customer').on('click', '.delete', function(e) {
		e.preventDefault();
		var gid = $(this).prop('id');
		$.post('<?php echo base_url()."Account/invite_delete/".$code."/"; ?>'+ gid,
			function(data,status,xhr){
				window.location = '<?php echo base_url()."account/invite_setting/".$code; ?>';
			}, "text");
	});

	$('.click_customer').on('click', '.exit', function(e) {
		e.preventDefault();
		var gid = $(this).prop('id');
		window.location = '<?php echo base_url()."Account/invite_exit/".$code."/"; ?>'+ gid;
	});

	$('#submit_list').click(function(e) {
		e.preventDefault();
		if (edit_flag==false) {
			$('.loader').show();
			$.post('<?php echo base_url()."Account/group_invite_send/".$code; ?>',{
				'inv_group':$('#inv_group').val(),
				'users' : m_user_array,
				'group' : g_flg
			},function(data, status, xhr) {
				if (data=="true") {
				 	window.location = '<?php echo base_url()."Account/invite_setting/".$code ?>';
				 	// $('#load').show();
				 	$('.loader').hide();
			 	}else{
					var data = {message: 'Email not sent,please try again'};
		 			snackbarContainer.MaterialSnackbar.showSnackbar(data);
		 			// $('#load').show();
					$('.loader').hide();
				}
			}, "text");
		} else {
			$('.loader').show();
			$.post('<?php echo base_url()."Account/update_invite_send/".$code."/"; ?>' + edit_user, {
				'users' : m_user_array,
				'gname' : $('#inv_group').val(),
				'group' : g_flg
			},function(data, status, xhr) {
				if (data=="true") {
		   			window.location = '<?php echo base_url()."Account/invite_setting/".$code ?>';	
		   			// $('#load').show();
		   			$('.loader').hide();
			 	} else{
					var data = {message: 'An Unknown Error occured. Please try again'};
		 			snackbarContainer.MaterialSnackbar.showSnackbar(data);
		 			// $('#load').show();
					$('.loader').hide();
				}
			}, "text");
		}
		
	});
});	
</script>
</html>