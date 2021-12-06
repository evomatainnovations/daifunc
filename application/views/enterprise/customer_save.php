<div class="mdl-grid" style="margin-bottom: -20px;">
	<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
		<h4>Update Profile</h4>
		<?php
			if (isset($doc_profile) ) {
				echo '<div class="person_icon" style="border: 1px solid #ccc;border-radius: 50%;height: 120px;width: 80%;margin-left: 10%;text-align: center;background: url('.base_url().'assets/uploads/'.$oid.'/'.$doc_profile[0]->icd_timestamp.');background-size:100%;"></div>';
			}else{
				echo '<div class="person_icon" style="border: 1px solid #ccc;border-radius: 50%;height: 120px;width: 80%;margin-left: 10%;text-align: center;"><i class="material-icons" style="color: #ccc;font-size: 8em;">person</i></div>';
			}
		?>
		<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
			<i class="material-icons">camera_alt</i>
			<input type="file" name="file[]" class="upload">
		</div>
	</div>
	<div class="mdl-cell mdl-cell--8-col">
		<input type="text" id="contact_name" class="mdl-textfield__input" placeholder="Enter Contact Name" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name; }?>" style="font-size: 2.5em;outline: none;margin-bottom: 10px;">
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input type="text" id="contact_type" class="mdl-textfield__input" placeholder="Enter contact type" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_section; }?>" style="outline: none;">
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input type="text" id="contact_parent" class="mdl-textfield__input" placeholder="Enter contact parent name" value="<?php if(isset($edit_cust_parent)) { echo $edit_cust_parent[0]->ic_name; }?>" style="outline: none;">
		</div>
		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			<input type="text" id="contact_rel" class="mdl-textfield__input" placeholder="Enter Parent relation" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_p_rel; }?>" style="outline: none;">
		</div>
	</div>
</div>
<hr>
<div style="display: flex;">
	<div style="width: 10%;margin-left: 5px;">
		<i class="material-icons" style="margin: 0px;">location_city</i>
	</div>
	<div style="width: 20%;">
		<h4 style="margin: 0px;"> Address</h4>
	</div>
	<div style="width: 70%;text-align: center;">
		<div class="address_list">
			<?php
				if (isset($cust_details)) {
					$flg = 0;
					for ($i=0; $i < count($cust_details) ; $i++) {
						for ($ij=0; $ij < count($address_prop) ; $ij++) { 
							if ($cust_details[$i]->icbd_property == $address_prop[$ij]->ip_id ) {
								$flg++;
								echo '<textarea type="text" id="'.$address_prop[$ij]->ip_property.'" class="mdl-textfield__input" placeholder="Enter Address 1" style="outline: none;">'.$cust_details[$i]->icbd_value.'</textarea>';
							}
						}
					}
					if ($flg == 0) {
						echo '<textarea type="text" id="address1" class="mdl-textfield__input" placeholder="Enter Address 1" style="outline: none;"></textarea>';
					}
				}else{
					echo '<textarea type="text" id="address1" class="mdl-textfield__input" placeholder="Enter Address 1" style="outline: none;"></textarea>';
				}
			?>
		</div>
		<div>
			<button class="mdl-button mdl-button--colored add_address_prp"><i class="material-icons">add</i> Address</button>
		</div>
	</div>
</div>
<hr>
<div style="display: flex;">
	<div style="width: 10%;margin-left: 5px;">
		<i class="material-icons" style="margin: 0px;">phone</i>
	</div>
	<div style="width: 20%;">
		<h4 style="margin: 0px;"> Phone No.</h4>
	</div>
	<div style="width: 70%;text-align: center;">
		<div class="phone_list">
			<?php
				if (isset($cust_details)) {
					$flg = 0;
					for ($i=0; $i < count($cust_details) ; $i++) {
						for ($ij=0; $ij < count($phone_prop) ; $ij++) { 
							if ($cust_details[$i]->icbd_property == $phone_prop[$ij]->ip_id ) {
								$flg++;
								echo '<input type="text" id="'.$phone_prop[$ij]->ip_property.'" class="mdl-textfield__input" placeholder="Enter Phone no. 1" style="outline: none;" value="'.$cust_details[$i]->icbd_value.'">';
							}
						}
					}
					if ($flg == 0) {
						echo '<input type="text" id="phone1" class="mdl-textfield__input" placeholder="Enter Phone no. 1" style="outline: none;">';
					}
				}else{
					echo '<input type="text" id="phone1" class="mdl-textfield__input" placeholder="Enter Phone no. 1" style="outline: none;">';
				}
			?>
		</div>
		<div>
			<button class="mdl-button mdl-button--colored add_phone"><i class="material-icons">add</i> phone</button>
		</div>
	</div>
</div>
<hr>
<div style="display: flex;">
	<div style="width: 10%;margin-left: 5px;">
		<i class="material-icons" style="margin: 0px;">alternate_email</i>
	</div>
	<div style="width: 20%;">
		<h4 style="margin: 0px;"> Email</h4>
	</div>
	<div style="width: 70%;text-align: center;">
		<div class="email_list">
			<?php
				if (isset($cust_details)) {
					$flg = 0;
					for ($i=0; $i < count($cust_details) ; $i++) {
						for ($ij=0; $ij < count($email_prop) ; $ij++) { 
							if ($cust_details[$i]->icbd_property == $email_prop[$ij]->ip_id ) {
								$flg++;
								echo '<input type="text" id="'.$email_prop[$ij]->ip_property.'" class="mdl-textfield__input" placeholder="Enter Email 1" style="outline: none;" value="'.$cust_details[$i]->icbd_value.'">';
							}
						}
					}
					if ($flg == 0) {
						echo '<input type="text" id="email1" class="mdl-textfield__input" placeholder="Enter Email 1" style="outline: none;">';
					}
				}else{
					echo '<input type="text" id="email1" class="mdl-textfield__input" placeholder="Enter Email 1" style="outline: none;">';
				}
			?>
		</div>
		<div>
			<button class="mdl-button mdl-button--colored add_email"><i class="material-icons">add</i> Email</button>
		</div>
	</div>
</div>
<hr>
<div class="mdl-cell mdl-cell--12-col custom_list">
	<?php
		if (isset($cust_details)) {
			for ($i=0; $i < count($cust_details) ; $i++) {
				for ($ij=0; $ij < count($custom_prop) ; $ij++) { 
					if ($cust_details[$i]->icbd_property == $custom_prop[$ij]->ip_id ) {
						echo '<input type="text" id="c_l'.$custom_prop[$ij]->ip_property.'" class="mdl-textfield__input" placeholder="Enter '.$custom_prop[$ij]->ip_property.'" style="outline: none;width:50%;" value="'.$cust_details[$i]->icbd_value.'">';
					}
				}
			}
		}
	?>
</div>
<div class="mdl-cell mdl-cell--12-col">
	<button class="mdl-button mdl-button--colored add_custom_property"> Add Custom property</button>
</div>
<hr>
<div class="display_more_output">
	<?php
    	if (isset($edit_doc)) {
    		if (count($edit_doc) > 0 ) {
    			echo '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons attach_icon">attach_file</i></div><div style="width: 30%;display: flex;"><h4 style="margin-top: 2px;">  Attachment</h4></div><div style="width:60%;display:flex;">';
	    		echo '<button type="button" class="mdl-button mdl-js-button mdl-button--colore pic_button" style="margin-top:0px;"> Upload file<input type="file" name="attach_file" class="upload upload_doc" id="contact_attach_file" multiple/></button><p style="margin-left:10px;" id="contact_no_files">no files selected</p>';
	    		echo '</div></div><div class="mdl-grid" style="width:100%;margin-top:10px;display:flex;" id="contact_file_view">';
	    		for ($i=0; $i < count($edit_doc) ; $i++) {
	    			echo '<div style="width:25%;height:100px;margin-top:5px;"><img class="upload_view" src="';
	    			echo base_url().'assets/uploads/'.$oid.'/'.$edit_doc[$i]->icd_timestamp;
	    			echo '"; style="max-width:100%;max-height:100%;border: 1px solid #000;" alt="your image" /></div>';
	    		}
	    		echo '</div><hr style="width: 100%;">';	
    		}    		
    	}

    	if (isset($edit_tags) ){
    		if(count($edit_tags) > 0 ) {
	    		echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;"><label>Share with user</label><ul id="contact_tag">';
					for ($i=0; $i <count($edit_tags) ; $i++) { 
						echo "<li>".$edit_tags[$i]->it_value."</li>";
					}
				echo '</ul></div>';
			}
    	}
    ?>
</div>
<div class="mdl-cell mdl-cell--12-col">
	<button class="mdl-button mdl-button--colored more_contact" tabindex="0" data-toggle="popover" data-trigger="focus" style="color: #000;border-radius: 15px;">More ...</button>
</div>
<?php
	if (isset($edit_cust)) {
		echo '<div class="mdl-cell mdl-cell--12-col" style="text-align: center;"><button class="mdl-button mdl-button--colored mdl-button--raised delete_contact" data-dismiss="modal" >Delete</button></div>';
	}
?>
<script>
	var upload_status = 'true';
	var tag_status = 'true';
	var old_custom = [];
	var phone_flg = 1;
	var email_flg = 1;
	var address_flg = 1;
	var custom_prp_flg = 0;
	var contact_content = [];
	<?php
		if (isset($cust_details)) {
			echo "address_flg=0;";
			echo "phone_flg=0;";
			echo "email_flg=0;";
			$p_flg = 0;
			$e_flg = 0;
			$adr_flg = 0;
			for ($i=0; $i < count($cust_details) ; $i++) {
				for ($ij=0; $ij < count($phone_prop) ; $ij++) { 
					if ($cust_details[$i]->icbd_property == $phone_prop[$ij]->ip_id ) {
						echo "phone_flg++;";
						$p_flg++;
					}
				}
			}
			if ($p_flg == 0 ) {
				echo "phone_flg=1;";
			}
			for ($i=0; $i < count($cust_details) ; $i++) {
				for ($ij=0; $ij < count($email_prop) ; $ij++) { 
					if ($cust_details[$i]->icbd_property == $email_prop[$ij]->ip_id ) {
						echo "email_flg++;";
						$e_flg++;
					}
				}
			}
			if ($e_flg == 0 ) {
				echo "email_flg=1;";
			}
			for ($i=0; $i < count($cust_details) ; $i++) {
				for ($ij=0; $ij < count($address_prop) ; $ij++) { 
					if ($cust_details[$i]->icbd_property == $address_prop[$ij]->ip_id ) {
						echo "address_flg++;";
						$adr_flg++;
					}
				}
			}
			if ($adr_flg == 0 ) {
				echo "address_flg=1;";
			}

			for ($i=0; $i < count($cust_details) ; $i++) {
				for ($ij=0; $ij < count($custom_prop) ; $ij++) {
					if ($cust_details[$i]->icbd_property == $custom_prop[$ij]->ip_id ) {
						echo "old_custom.push({'lable' : '".$custom_prop[$ij]->ip_property."' , 'val' : '".$cust_details[$i]->icbd_value."' });";
					}
				}
			}

			if (count($edit_doc) > 0) {
				echo "upload_status = 'false';";
			}else{
				echo "upload_status = 'true';";
			}

			if (count($edit_tags) > 0) {
				echo "tag_status = 'false';";
			}else{
				echo "tag_status = 'true';";
			}
		}
	?>
	$(document).ready(function() {
		$('#contact_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});
		contact_content.push({'id' : '1' , 'val' : '<button class="mdl-button add_contact_more" id="1" style="width:100%;text-align:left;">Upload document</button>', 'status' : upload_status});
		contact_content.push({'id' : '2' , 'val' : '<button class="mdl-button add_contact_more" id="2" style="width:100%;text-align:left;">Tag</button>', 'status' : tag_status});

        $('.delete_contact').click(function (e) {
        	e.preventDefault();
        	$.post('<?php if (isset($edit_cust)) { echo base_url()."Enterprise/delete_cust/".$code."/".$cid; } ?>'
	        , function(data, status, xhr) {
	            var a = JSON.parse(data);
            	cust_arr = [];
            	for (var i=0; i < a.customer.length ; i++) {
					cust_arr.push({'id' : a.customer[i].ic_id , 'name' : a.customer[i].ic_name , 'type' : a.customer[i].ic_section });
				}
				display_cust_list();
	        }, 'text');
        });

    	$("#contact_parent").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_parent, request.term);
                response(results.slice(0, 10));
            }  
        });

    	$("#contact_type").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_sec, request.term);
                response(results.slice(0, 10));
            }  
        });

    	$('#add_cust_modal').on('change','.upload',function (e) {
            e.preventDefault();
            var ins = $('.upload')[0].files.length;
            $('#no_of_files').empty();
            if (ins > 1) {
                $('#no_of_files').append(ins+' files selected');
            }else{
                $('#no_of_files').append(ins+' file selected');
            }
            var input = $('.upload')[0];
            $('.person_icon').empty();

            for (var i = 0; i < input.files.length; i++) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.person_icon').css('background' ,'url('+e.target.result+')');
                        $('.person_icon').css('background-size' ,'100%');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
        });
    	$('.add_phone').click(function(e){
    		e.preventDefault();
        	phone_flg++;
        	var out = '';
        	out+= '<input type="text" id="phone'+phone_flg+'" class="mdl-textfield__input" placeholder="Enter Phone no. '+phone_flg+'" style="outline: none;margin-top:5px;">';
    		$('.phone_list').append(out);
    	});

    	$('.add_email').click(function(e){
    		e.preventDefault();
    		email_flg++;
    		var out = '';
        	out+= '<input type="text" id="email'+email_flg+'" class="mdl-textfield__input" placeholder="Enter email '+email_flg+'" style="outline: none;margin-top:5px;">';
    		$('.email_list').append(out);
    	});

    	$('.add_address_prp').click(function(e){
    		e.preventDefault();
    		address_flg++;
    		// console.log('add_flg_on_click '+address_flg);
    		var out = '';
        	out+= '<textarea type="text" id="address'+address_flg+'" class="mdl-textfield__input" placeholder="Enter Address '+address_flg+'" style="outline: none;margin-top:5px;"></textarea>';
    		$('.address_list').append(out);
    	});

    	$('.add_custom_property').click(function(e){
    		e.preventDefault();
    		custom_prp_flg++;
    		var out = '';
        	out+= '<div style="display:flex;margin-top:5px;"><input type="text" id="lable'+custom_prp_flg+'" class="mdl-textfield__input" placeholder="Enter Label Name" style="outline: none;width:50%;">';
        	out+= '<input type="text" id="l_val'+custom_prp_flg+'" class="mdl-textfield__input" placeholder="Enter Value" style="outline: none;width:50%;"></div>';
    		$('.custom_list').append(out);
    	});

    	$('.more_contact').popover({
            trigger: 'click',
            html: true,
            title: function() {
                return $(this).parent().find('.po-title').html();
            },
            content: function() {
                var out = '';
                var pop_flg = 0;
				for (var i = 0; i < contact_content.length; i++) {
                    if(contact_content[i].status == 'true'){
                        out += contact_content[i].val;
                        pop_flg ++;
                    }
                }
                if (pop_flg == 0 ) {
                    out = 'No More !';
                }
                return out;
            },
            placement: 'right'
        }).on('shown.bs.popover', function () {
            $('.add_contact_more').click(function (e) {
                e.preventDefault();
                var id = $(this).prop('id');
                $(this).css('display','none');
                for (var i = 0; i < contact_content.length; i++) {
                    if(contact_content[i].id == id){
                        contact_content[i].status = 'false';
                    }
                }
                if (id == '1') {
                    add_contact_uplaod();
                }else{
                	add_contact_tag();
                }
                $('.more_contact').popover('hide');
            });
        });

        function add_contact_uplaod(){
        	var out = '';
            out +=  '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons attach_icon">attach_file</i></div><div style="width: 30%;display: flex;"><h4 style="margin-top: 2px;">  Attachment</h4></div><div style="width:60%;display:flex;">';
            out += '<button type="button" class="mdl-button mdl-js-button mdl-button--colore pic_button" style="margin-top:0px;"> Upload file<input type="file" name="attach_file" class="upload upload_doc" id="contact_attach_file" multiple/></button><p style="margin-left:10px;" id="contact_no_files">no files selected</p>';
            out +=  '</div></div><div class="mdl-grid" style="width:100%;margin-top:10px;display:flex;" id="contact_file_view"></div><hr style="width: 100%;">';
            $('.display_more_output').append(out);
        }

        function add_contact_tag(){
        	var out = '';
        	out += '<div class="mdl-cell mdl-cell--12-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;"><label>Add tag</label><ul id="contact_tag"></ul></div></div><hr>';
        	$('.display_more_output').append(out);
        	$('#contact_tag').tagit({
	    		autocomplete : { delay: 0, minLenght: 5},
	    		allowSpaces : true,
	    		availableTags : tag_data
	    	});
        }

        $('.display_more_output').on('change','.upload_doc',function (e) {
            e.preventDefault();
            var ins = $('.upload_doc')[0].files.length;
            $('#contact_no_files').empty();
            if (ins > 1) {
                $('#contact_no_files').append(ins+' files selected');
            }else{
                $('#contact_no_files').append(ins+' file selected');
            }
            var input = $('.upload_doc')[0];
            for (var i = 0; i < input.files.length; i++) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#contact_file_view').append('<div style="width:25%;height:100px;margin-top:5px;"><img class="upload_view" src="'+ e.target.result+'" style="max-width:100%;max-height:100%;border: 1px solid #000;" alt="your image" /></div>');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
        });

        $('#submit_contact').click(function(e) {
			e.preventDefault();
			$('.loader').show();
			var cust_prop = [];
			for (var i = 1; i <= custom_prp_flg; i++) {
				var p = 'lable'+i;
				var v = 'l_val'+i;
				cust_prop.push({'prop' : $('#'+p).val() ,'val' : $('#'+v).val() });
			}

			for (var i = 1; i <= phone_flg; i++) {
				var v = 'phone'+i;
				cust_prop.push({'prop' : v ,'val' : $('#'+v).val() });	
			}
			for (var i = 1; i <= address_flg; i++) {
				var v = 'address'+i;
				cust_prop.push({'prop' : v ,'val' : $('#'+v).val() });	
			}

			for (var i = 1; i <= email_flg; i++) {
				var v = 'email'+i;
				cust_prop.push({'prop' : v ,'val' : $('#'+v).val() });
			}
			var customer_name = $('#contact_name').val();
			var customer_info = [];

			$('#contact_tag > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					customer_info.push(tmpstr);
				}
			});
			var old_custom_info = [];
			for (var i = 0; i < old_custom.length; i++) {
				var id = 'c_l'+old_custom[i].lable;
				var vl = $('#'+id).val();
				old_custom_info.push({'lable' : old_custom[i].lable , 'val' : vl });
			}
			
			var stid = "";
            $.post('<?php if (isset($edit_cust)) { echo base_url()."Enterprise/update_customer/".$cid."/".$code; } else { echo base_url()."Enterprise/save_customer/".$code; } ?>',{
                'name' : customer_name,
                'property' : cust_prop,
                'old_property' : old_custom_info,
                'tags' : customer_info,
                'section' : $('#contact_type').val(),
                'cust_parent' : $('#contact_parent').val(),
                'p_rel' : $('#contact_rel').val()
            }, function(data, status, xhr) {
            	var a = JSON.parse(data);
            	cust_arr = [];
            	$('.loader').hide();
            	for (var i=0; i < a.customer.length ; i++) {
					cust_arr.push({'id' : a.customer[i].ic_id , 'name' : a.customer[i].ic_name , 'type' : a.customer[i].ic_section });
				}
				cust_parent.push(customer_name);
				display_cust_list();
                uploadfiledata(a.cid);
            }, 'text');
		});

		function uploadfiledata(stid) {
	    	var datat = new FormData();
	    	if($('.upload')[0].files.length > 0) {
	    		datat.append("use[]", $('.upload')[0].files[0]);
	    		flnm = "";
	    		$.ajax({
	    			url: "<?php echo base_url().'Enterprise/uploadfile/'.$code."/"; ?>" + stid, // Url to which the request is send
	    			type: "POST",             // Type of request to be send, called as method
	    			data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
	    			contentType: false,       // The content type used when sending data to the server.
	    			cache: false,             // To unable request pages to be cached
	    			processData:false,        // To send DOMDocument or non processed data file it is set to false
	    			success: function(data)   // A function to be called if request succeeds
	    			{	
	    				if (contact_content[0].status == 'false') {
	    					file_upload(stid);
	    				}else{
	    					$('.loader').hide();
	    				}
	    			}
	    		});
	    	} else {
	    		if (contact_content[0].status == 'false') {
					file_upload(stid);
				}else{
					$('.loader').hide();
				}
	    	}
	    }

	    function file_upload(id){
			if($('.upload_doc')[0].files.length > 0 ) {
				var datat = new FormData();
	            var ins = $('.upload_doc')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.upload_doc')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Enterprise/cust_doc_upload/'.$code."/"; ?>" + id, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$('.loader').hide();
					}
				});
			}else{
				$('.loader').hide();
			}
		}

		function display_cust_list(){
			var out = '';
			var sr_no = 0;
			out+= '<table class="general_table">';
			out+= '<thead><th>Sr. No.</th><th>Name</th><th>Type</th><th colspan="2" style="text-align:center;">Action</th></thead>';
			out+= '<tbody>';
			if (cust_arr.length > 0 ) {
				for (var i = 0; i < cust_arr.length; i++) {
					sr_no++;
					out+= '<tr><td>'+sr_no+'</td><td>'+cust_arr[i].name+'</td><td>'+cust_arr[i].type+'</td><td style="width:10%;"><button class="mdl-button mdl-button--colored edit_cust" id="'+cust_arr[i].id+'"><i class="material-icons">edit</i> Edit</button></td><td style="width:10%;"><button class="mdl-button mdl-button--colored cust_view_detail" id="'+cust_arr[i].id+'"><i class="material-icons">remove_red_eye</i> View</button></td></tr>';
				}
			}else{
				out+='<tr><td colspan="4" style="text-align:center;">No Records Found!</td></tr>'
			}
			out+= '</tbody>';
			out+= '</table>';

			$('#details').empty();
			$('#details').append(out);
		}
	});
</script>