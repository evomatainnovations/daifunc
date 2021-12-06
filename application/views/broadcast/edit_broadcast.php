<style type="text/css">
	.emp{
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc; 
		padding: 30px;
	}
	h3{
		margin-top: -10px;
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
		z-index: 1000000 !important;
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
		/*background-color: #666;*/
		/*color: #fff;*/
	}

	.general_table > tbody {
		border: 1px solid #ccc;
	}
	.general_table > tbody > tr {
		/*border-bottom: 1px solid #ccc;*/
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
		<div class="mdl-cell mdl-cell--10-col">
			<h3  style="margin-left: 20px;"><?php echo $brod_list[0]->iebrod_name; ?></h3>
		</div>
		<div class="mdl-cell mdl-cell--2-col">
			<button class="mdl-button mdl-button--colored delete"><i class="material-icons">delete</i> DELETE</button>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col emp read">
			<h3>Read</h3>
			<h5 id="t_read"></h5>
			<hr>
			<div id="read"></div>
		</div>
		<div class="mdl-cell mdl-cell--4-col emp send">
			<h3>Send</h3>
			<h5 id="t_send"></h5>
			<hr>
			<div id="send"></div>
		</div>
		<div class="mdl-cell mdl-cell--4-col emp fail">
			<h3>Fail to send</h3>
			<h5 id="t_fail"></h5>
			<hr>
			<div id="resend_Action"></div>
			<div id="fail"></div>
		</div>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
	var cust_list = [];
	var camp_arr = [];
	var status_arr = [];
	var cust_list = [];
	<?php
			if (isset($brod_list)) {
				for ($i=0; $i <count($brod_list) ; $i++) { 
					echo "camp_arr.push({'id' : '".$brod_list[$i]->iebrod_id."', 'name' : '".$brod_list[$i]->iebrod_name."', 'date' : '".$brod_list[$i]->iebrod_date."'});";
				}
			}
			if (isset($status_list)) {
				for ($i=0; $i <count($status_list) ; $i++) { 
					echo "status_arr.push({'id' : '".$status_list[$i]->iebrodc_brod_id."','contact_id' : '".$status_list[$i]->iebrodc_id."','name' : '".$status_list[$i]->ic_name."','email' : '".$status_list[$i]->icbd_value."','status' : '".$status_list[$i]->iebrodc_status."'});";
				}
			}
	?>
	$(document).ready( function() {
		send_display();
		var snackbarContainer = document.querySelector('#demo-toast-example');

		$('#resend_Action').on('click','.resend',function (e) {
			e.preventDefault();
			if (cust_list.length > 0) {
				$('.loader').show();
				$.post('<?php echo base_url()."Broadcast/fail_broadcast_mail/".$code."/".$inid; ?>', {
	        		'm_user' : cust_list
	        	}, function(data, status, xhr) {
	        		var d = JSON.parse(data);
	   				$('.loader').hide();
	        		if (d == 'true') {
	        		window.location = "<?php echo base_url().'Broadcast/edit_broadcast/'.$code.'/'.$inid; ?>";
	        		}else{
	        			var data = {message: 'Please check internet connection!'};
		    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
	        		}
	        	});
			}else{
				var data = {message: 'No contact available !'};
		    	snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}
		});

		$('#resend_Action').on('click','.discard_all',function (e) {
			e.preventDefault();
			if (cust_list.length > 0) {
	        	window.location = "<?php echo base_url().'Broadcast/discard_broadcast_list/'.$code.'/'.$inid; ?>";
			}else{
				var data = {message: 'No contact available !'};
		    	snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}
		});

		$('#fail').on('click','.discard',function (e) {
			e.preventDefault();
			var id = $('.discard').prop('id');
        	$.post('<?php echo base_url()."Broadcast/discard_broadcast/".$code."/"; ?>'+id
        	, function(data, status, xhr) {
        		window.location = "<?php echo base_url().'Broadcast/edit_broadcast/'.$code.'/'.$inid; ?>";
        	});
		});

		$('.delete').on('click',function (e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Broadcast/delete_broadcast/'.$code.'/'.$inid; ?>";
		});

		 var a_flg = 'false';

        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

         $('#submit').click(function(e) {
            e.preventDefault();
            if($('#search_modal').css('display') != 'none'){
                var note = $('#notes_text').html();
                $('#ATags > li').each(function(index) {
                    var tmpstr = $(this).text();
                    var len = tmpstr.length - 1;
                    if(len > 0) {
                        tmpstr = tmpstr.substring(0, len);
                        activity_tags.push(tmpstr);
                    }
                });
                var date = $('.s_date').val();
                var e_date = $('.e_date').val();
                $.post('<?php echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
                    'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
                }, function(data, status, xhr) {
                        location.reload();
                }, 'text');
            }
        });
	});

	function send_display() {
		var out = '';
		var total = 0;
		out += '<div class="mdl-cell mdl-cell--12-col"><table class="general_table" style="width:100%;"><thead><tr><th>Name</th><th>Email</th></tr></thead>';
		for (var i = 0; i < status_arr.length; i++) {
			if(status_arr[i].status == 'true' || status_arr[i].status == 'view'){
				out +='<tr><td >'+status_arr[i].name+'</td><td >'+status_arr[i].email+'</td></tr>';
				total = Number(total) + 1;
			}
		}
		out += '</table></div>';
		$('#send').empty('');
		$('#t_send').append('Total : '+total);
		$('#send').append(out);

		var out = '';
		total = 0 ;
		out += '<div class="mdl-cell mdl-cell--12-col"><table class="general_table" style="width:100%;"><thead><tr><th>Name</th><th>Email</th></tr></thead>';
		for (var i = 0; i < status_arr.length; i++) {
			if(status_arr[i].status == 'view'){
				out +='<tr><td >'+status_arr[i].name+'</td><td >'+status_arr[i].email+'</td></tr>';
				total = Number(total) + 1;
			}
		}
		out += '</table></div>';
		$('#read').empty('');
		$('#t_read').append('Total : '+total);
		$('#read').append(out);

		var out = '';
		total = 0 ;

		out += '<div class="mdl-cell mdl-cell--12-col"><table class="general_table" style="width:100%;"><thead><tr><th >Name</th><th >Email</th><th ></th></tr></thead>';
		for (var i = 0; i < status_arr.length; i++) {
			if(status_arr[i].status == 'false'){
				out +='<tr><td >'+status_arr[i].name+'</td><td >'+status_arr[i].email+'</td><td><button class="mdl-button mdl-button--colored discard" id="'+status_arr[i].contact_id+'" style="width:100%;"><i class="material-icons">delete</i></button></td></tr>';
				cust_list.push({id : status_arr[i].id, email : status_arr[i].email });
				total = Number(total) + 1;
			}
		}
		out += '</table></div>';
		var a = '';
		if (Number(total) > 0) {
			a+='<div class="mdl-grid"><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button--colored resend" style="width:100%;">Resend</button></div><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button--colored discard_all" style="width:100%;">Discard All</button></div></div>';
		}
		$('#resend_Action').empty('');
		$('#resend_Action').append(a);
		$('#fail').empty('');
		$('#t_fail').append('Total : '+total);
		$('#fail').append(out);
	}
</script>