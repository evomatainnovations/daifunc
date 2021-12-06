<style type="text/css">
.pic_button {
	border-radius: 10px;
	box-shadow: 0px 4px 10px #ccc;
	margin: 10px;
	position: relative;
	overflow: hidden;
	width: 50%;
	margin-left: 0px;
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
</style>
<main>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;height: 90vh;overflow: auto;padding: 30px;">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" class="mdl-textfield__input" id="mu_company_name">
					<label class="mdl-textfield__label" for="mu_company_name">Enter Company Name</label>
				</div>
				<div type="button" class="mdl-button mdl-js-button pic_button">
					<input type="file" name="attach_file" class="upload">
					<i class="material-icons">image</i> Upload Company Logo
				</div>
				<div style="width: 100%;" class="logo_preview"></div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" class="mdl-textfield__input" id="mu_owner_name">
					<label class="mdl-textfield__label" for="mu_owner_name">Enter Owner Name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" class="mdl-textfield__input" id="mu_login_f">
					<label class="mdl-textfield__label" for="mu_login_f">Enter Login Function Name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" class="mdl-textfield__input" id="mu_verify_f">
					<label class="mdl-textfield__label" for="mu_verify_f">Enter After Verify Function Name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" class="mdl-textfield__input" id="mu_color">
					<label class="mdl-textfield__label" for="mu_color">Enter Color Combination</label>
				</div>
				<button class="mdl-button mdl-button--colored" id="submit"><i class="material-icons">save</i> save</button>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;text-align: center;height: 90vh;overflow: auto;">
				<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Id</th>
						<th class="mdl-data-table__cell--non-numeric">Company Name</th>
						<th class="mdl-data-table__cell--non-numeric">Owner Name</th>
						<th colspan="2">Action</th>
					</tr>
				</thead>
				<tbody class="mobile_body"></tbody>
			</table>
			</div>
		</div>
	</div>
</main>
<script>
	var customer_data = [];
	var mobile_list = [];
	var edit_mu_id = 0;
	<?php
		if (isset($u_list)) {
			for ($i=0; $i < count($u_list) ; $i++) {
				echo 'customer_data.push("'.$u_list[$i]->i_uname.'");';
			}
		}
		if (isset($m_list)) {
			for ($i=0; $i < count($m_list) ; $i++) {
				echo 'mobile_list.push({"id" : "'.$m_list[$i]->iextetm_id.'" , "c_name" : "'.$m_list[$i]->iextetm_company_name.'" ,"o_name" : "'.$m_list[$i]->i_uname.'" , "log_f" : "'.$m_list[$i]->iextetm_login_function.'" , "ver_f" : "'.$m_list[$i]->iextetm_verify_function.'" , "color" : "'.$m_list[$i]->iextetm_color.'" });';
			}
		}
	?>
$(document).ready(function() {
	display_mobile_list();
	$("#mu_owner_name").autocomplete({
		source: function(request, response) {
            var results = $.ui.autocomplete.filter(customer_data, request.term);
            response(results.slice(0, 10));
        }
    });

    $('.upload').change(function (e) {
        e.preventDefault();
        var ins = $('.upload')[0].files.length;
        var input = $('.upload')[0];
        $('.logo_preview').empty();
        for (var i = 0; i < input.files.length; i++) {
            if (input.files && input.files[i]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.logo_preview').append('<div style="width:100%;height:100px;padding-top:20px;"><img class="upload_view" src="'+ e.target.result+'" style="max-width:100%;max-height:100%;border: 0px solid #000;" alt="your image" /></div>');
                };
                reader.readAsDataURL(input.files[i]);
            }
        }
    });

    $('.mobile_body').on('click','.mobile_list_edit',function(e){
    	e.preventDefault();
    	var id = $(this).prop('id');
    	edit_mu_id = id;
    	for (var i = 0; i < mobile_list.length; i++) {
    		if(mobile_list[i].id == id){
    			$('#mu_company_name').val(mobile_list[i].c_name);
				$('#mu_owner_name').val(mobile_list[i].o_name);
				$('#mu_login_f').val(mobile_list[i].log_f);
				$('#mu_verify_f').val(mobile_list[i].ver_f);
				$('#mu_color').val(mobile_list[i].color);
    		}
    	}
    });

    $('.mobile_body').on('click','.mobile_list_delete',function(e){
    	e.preventDefault();
    	var id = $(this).prop('id');
    	var path = '<?php echo base_url()."Portal/mobile_users_delete/"; ?>'+id;
		$.post(path,
		function(data, status, xhr) {
			window.location = "<?php echo base_url().'portal/mobile_users/'; ?>";
		}, 'text');
    });

	$('#submit').click(function(e){
		e.preventDefault();
		if (edit_mu_id == 0) {
			var path = '<?php echo base_url()."Portal/mobile_users_save/"; ?>';
		}else{
			var path = '<?php echo base_url()."Portal/mobile_users_update/"; ?>'+edit_mu_id;
		}
		$.post(path,{
			'company_name' : $('#mu_company_name').val(),
			'owner_name' : $('#mu_owner_name').val(),
			'login_f' : $('#mu_login_f').val(),
			'verify_f' : $('#mu_verify_f').val(),
			'color' : $('#mu_color').val()
		}, function(data, status, xhr) {
			if (data == 'false') {
				alert('plz enter correct uname !');
			}else{
				file_upload(data);
			}
		}, 'text');
	});

	var datat = new FormData();
	function file_upload(id) {
		var t_flg = 0;
		for(var i=0; i < $('.upload').length; i++) {
		    if($('.upload')[i].files[0]) {
    		    datat.append(i, $('.upload')[i].files[0]);
    		    t_flg = 1;
		    }
		}
		if (t_flg == 1) {
			var url ='<?php echo base_url()."Portal/mobile_logo_upload/"; ?>'+id;
			flnm = "";
			$.ajax({
				url: url, // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data){
					window.location = "<?php echo base_url().'portal/mobile_users'; ?>";
				},
				error: function(x,s,e){
					alert('choose proper file');
				} 
			});
		}else{
			window.location = "<?php echo base_url().'portal/mobile_users'; ?>";
		}
	}

	function display_mobile_list(){
		var out = '';
		for (var i = 0; i < mobile_list.length; i++) {
			out += '<tr>';
			out += '<td class="mdl-data-table__cell--non-numeric">'+mobile_list[i]['id']+'</td>';
			out += '<td class="mdl-data-table__cell--non-numeric">'+mobile_list[i]['c_name']+'</td>';
			out += '<td class="mdl-data-table__cell--non-numeric">'+mobile_list[i]['o_name']+'</td>';
			out += '<td><button class="mdl-button mdl-button--colored mobile_list_edit" id="'+mobile_list[i]['id']+'"><i class="material-icons">edit</i>edit</button><button class="mdl-button mdl-button--colored mobile_list_delete" id="'+mobile_list[i]['id']+'"><i class="material-icons">delete</i>delete</button></td>';
			out += '</tr>';
		}

		$('.mobile_body').empty();
		$('.mobile_body').append(out);
	}
});

</script>