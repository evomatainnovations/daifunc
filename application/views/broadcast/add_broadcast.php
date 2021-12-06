<style type="text/css">
	.cust_table {
		width: 100%;
        text-align: left;
        font-size: 1.2em;
        border: 0px solid #ccc;
        border-collapse: collapse;
    }
	@media only screen and (max-width: 760px) {
		.cust_table {
			display: block;
        	overflow: auto;
		}
	}

	.cust_table > thead > tr {
		box-shadow: 0px 5px 5px #ccc;
	}

	.cust_table > thead > tr > th {
		padding: 10px;
	}

	.cust_table > tbody > tr {
		border-bottom: 1px solid #ccc;
	}

	.cust_table > tbody > tr > td {
		padding: 15px;
	}

	#mail_content {
		border:1px solid #ccc;
		height: 600px;
		outline: none;
		padding: 10px;
		border-radius: 10px;
		box-shadow: 0px 3px 5px #ccc inset;
		overflow-y: auto;
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
		<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--8-col">
					<input type="text" id="camp_name" class="mdl-textfield__input" placeholder="Campaign name" style="font-size: 3em;outline: none;width: 90%;">
				</div>
				<div class="mdl-cell mdl-cell--4-col" style="margin-top: 20px;">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="camp_date" class="mdl-textfield__input" value="">
						<label class="mdl-textfield__label" for="camp_date">Select Publish Date</label>
					</div>
				</div>	
			</div>	
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;padding: 30px;">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;margin-top: 15px;">
				<select class="mdl-textfield__input" id="c_type">
					<option value="null">Select contact type</option>
					<?php 
						if (isset($c_list)) {
							for ($i=0; $i <count($c_list) ; $i++) { 
								echo '<option value="'.$c_list[$i]->ic_section.'">'.$c_list[$i]->ic_section.'</option>';
							}
						}
					?>
				</select>
				<label class="mdl-textfield__label" for="c_type">Select contact type</label>
			</div>
			<div class="mdl-grid cust_details">
				
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;padding: 30px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;">
						<select class="mdl-textfield__input" id="email_temp">
							<option value="null">Select email template</option>
							<?php
								if (isset($email_temp)) {
									for ($i=0; $i <count($email_temp) ; $i++) { 
										echo '<option value="'.$email_temp[$i]->iuetemp_id.'">'.$email_temp[$i]->iuetemp_title.'</option>';
									}
								}
							?>
						</select>
						<label class="mdl-textfield__label" for="text_type">Select email template</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;">
						<select class="mdl-textfield__input" id="text_type">
							<option value="null">Select content type</option>
							<option value="html">HTML</option>
							<option value="text">TEXT</option>
						</select>
						<label class="mdl-textfield__label" for="text_type">Select content type</label>
					</div>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--12-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
				    <input class="mdl-textfield__input" type="text" id="mail_sub">
				    <label class="mdl-textfield__label" for="mail_sub">Enter subject</label>
				 </div>
			</div>
			<div class="mdl-cell mdl-cell--12-col">
				<textarea id="mail_content" style="width: 100%;font-size: 1.2em;"></textarea>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--6-col">
						<button class="mdl-button mdl-button--raised mdl-button--colored test_mail" style="width: 100%;">Test Mail</button>
					</div>
					<div class="mdl-cell mdl-cell--6-col">
						<button class="mdl-button mdl-button--raised mdl-button--colored send_mail" style="width: 100%;">Send Mail</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mdl-grid">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 250px">
						<input class="mdl-textfield__input" type="text" id="customer_mail">
						<label class="mdl-textfield__label" for="customer_mail">Email</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--raised" data-dismiss="modal" id="test_send_mail">Send</button>
				<button type="button" class="mdl-button mdl-button--raised mdl-button--colored close" data-dismiss="modal" style="margin-left: 15px;"><i class="material-icons">close</i></button>
			</div>
		</div>
	</div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
	var cust_list = [];

	$(document).ready( function() {
		var snackbarContainer = document.querySelector('#demo-toast-example');
		$('#camp_date').bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm'});

		$('#email_temp').change(function (e) {
			e.preventDefault();
			var id = $(this).val();
			if (id == 'null') {
				$('#mail_sub').val('');
	        	$('#mail_content').val('');
			}else{
				$.post('<?php echo base_url()."Broadcast/email_temp/".$code."/"; ?>'+id,
	        	function(data, status, xhr) {
	        		var d = JSON.parse(data);
	        		var title = d.temp_title;
	        		var content = d.temp_content;
	        		$('#mail_sub').val(title);
	        		$('#mail_content').val(content);
	        	});
			}
		});

		$('#c_type').change(function (e) {
			e.preventDefault();
			var ctype = $(this).val();
			$.post('<?php echo base_url()."Broadcast/broadcast_list/".$code; ?>', {
        		'ctype' : ctype
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		cust_list = [];
        		for (var i = 0; i < d.ctype_list.length; i++) {
        			cust_list.push({'id' : d.ctype_list[i].ic_id ,'name' : d.ctype_list[i].ic_name, 'email' : d.ctype_list[i].icbd_value, 'status' : 'false'});
        		}
        		cust_display();
        	});
		});

		$('.cust_details').on('change','.check',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			var status = '';
			if (this.checked) {
				status = 'true';
		    }else{
		    	status = 'false';
		    }
		    for (var i = 0; i < cust_list.length; i++) {
		    	if(cust_list[i].id == id){
		    		cust_list[i].status = status;
		    	}
		    }
		});

		$('.cust_details').on('click','.select',function (e) {
			e.preventDefault();
			for (var i = 0; i < cust_list.length; i++) {
				cust_list[i].status = 'true';
			}
			cust_display();
		});

		$('.cust_details').on('click','.d_select',function (e) {
			e.preventDefault();
			for (var i = 0; i < cust_list.length; i++) {
				cust_list[i].status = 'false';
			}
			cust_display();
		});

		$('.send_mail').click(function (e) {
			e.preventDefault();
			$('.loader').show();
			var text_type = $('#text_type').val();
			var t_content = $('#mail_content').val();
			var m_subject = $('#mail_sub').val();
			$.post('<?php echo base_url()."Broadcast/broadcast_mail/".$code; ?>', {
				'camp_name' : $('#camp_name').val(),
        		'camp_date' : $('#camp_date').val(),
        		't_type' : text_type,
        		't_content' : t_content,
        		'm_user' : cust_list,
        		'm_subject' : m_subject
        	}, function(data, status, xhr) {
   				$('.loader').hide();
    			window.location = "<?php echo base_url().'Broadcast/home/null/'.$code.'/'; ?>";
        	});
		});

		$('.test_mail').click(function (e) {
			e.preventDefault();
			$('#myModal').modal('show');
		});

		$('#test_send_mail').click(function (e) {
			e.preventDefault();
			$('.loader').show();
			var text_type = $('#text_type').val();
			var t_content = $('#mail_content').val();
			var m_subject = $('#mail_sub').val();
			$.post('<?php echo base_url()."Broadcast/broadcast_test_mail/".$code; ?>', {
        		't_type' : text_type,
        		't_content' : t_content,
        		'm_user' : $('#customer_mail').val(),
        		'm_subject' : m_subject
        	}, function(data, status, xhr) {
   				$('.loader').hide();
    			var data = {message: 'Mail sent!'};
    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
        	});
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
	function cust_display() {
		var out = '';
		if (cust_list.length > 0) {
			out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button--raised select">Select all</button></div><div class="mdl-cell mdl-cell--6-col"><button style="margin-left:10px;" class="mdl-button mdl-button--raised d_select">Deselect all</button></div></div>';
			out += '<div class="mdl-cell mdl-cell--12-col"><table id="customer_list" class="cust_table"><thead><tr><th>Name</th><th>Select</th></tr></thead>';
			for (var i = 0; i < cust_list.length; i++) {
				out +='<tr><td>'+cust_list[i].name+'</td><td><input type="checkbox" id="'+cust_list[i].id+'" class="mdl-checkbox__input check" ';
				if(cust_list[i].status == 'true'){
					out += 'checked';
				}
				out +='></td></tr>';
			}
			out += '</table></div>';
		}else{
			out += '<h3>No Contact found !</h3>'
		}
		$('.cust_details').empty();
		$('.cust_details').append(out);
	}
</script>