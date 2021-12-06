<style type="text/css">

.pic_button {
	/*height: 100px;*/
	border-radius: 10px;
	box-shadow: 0px 4px 10px #ccc;
	margin: 20px;
	position: relative;
	overflow: hidden;
	/*margin: 10px;*/
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
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Contact Details</h2>
						</div>
						<div class="mdl-card__supporting-text">
						    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_section" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->ic_section; } ?>">
								<label class="mdl-textfield__label" for="c_section">Type of Contact</label>
			        		</div>
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->ic_name; } ?>">
								<label class="mdl-textfield__label" for="c_name">Enter Customer Name</label>
							</div>
							<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
								<i class="material-icons">face</i> Choose Display photo
								<input type="file" name="attach_file" class="upload" id="profile_pic">
							</div>
							<?php
			        			if (isset($edit_customer)) {
			        				echo '<div style="text-align: center;padding-top:20px;padding-bottom:20px;">';
			        				echo '<a href="'.base_url().'Enterprise/delete_customer/'.$code.'/'.$cid.'"><button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent" style="width:100%;margin-left:0px !important;margin-right:0px !important;">Delete</button></a>';
			        				echo '</div>';
			        				
			        			}
			        		?>
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Tags</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<ul id="myTags" class="mdl-textfield__input">
									<?php 
										if (isset($edit_preferences)) {
											if (count($edit_preferences) > 0 && count($tags) > 0) {
												for ($j=0; $j < count($edit_preferences) ; $j++) { 
													echo "<li>".$edit_preferences[$j]->it_value."</li>";
												}
											}
										}
									?>
								</ul>
								</div>
							</div>			
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Uplaod details</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
								<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
									<i class="material-icons">folder</i>  Upload Document's
									<input type="file" name="file[]" id="multiFiles" class="upload u_multiple" multiple>
								</div>
								<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="file" name="file[]" id="multiFiles" class="upload u_multiple" multiple>
								 </div> -->
								<div id="uploaded_files">
									<?php
											if (isset($user_files) && count($user_files) > 0) {
												for ($i=0; $i <count($user_files) ; $i++) { 
													echo '<span class="mdl-chip" style="margin-right: 10px;margin-bottom: 10px;margin-top: 10px;"><span class="mdl-chip__text">'.$user_files[$i]->icd_file.'</span></span>';
												}
											}
									?>
								</div>
							</div>			
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Basic Information</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div id="info_repeat" class="mdl-grid">
								<?php 
									for ($i=0; $i < count($property) ; $i++) {
										$prop = $property[$i]->ip_property;
										$pid = $property[$i]->ip_id;
										$val = "";

										if(isset($edit_basic_details)) {
											for ($ij=0; $ij < count($edit_basic_details) ; $ij++) { 
												$cpid = $edit_basic_details[$ij]->icbd_property;
												
												if ($cpid==$pid) {
													$val = $edit_basic_details[$ij]->icbd_value;
												}
											}
										}
										echo '<div class="mdl-cell mdl-cell--12-col" style="display:flex;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="c_val'.$pid.'" name="c_val[]" class="mdl-textfield__input" value="'.$val.'"><label class="mdl-textfield__label" for="c_val'.$pid.'">'.$prop.'</label></div></div>';
									}
								?>
							</div>
							<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
								<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="add_prp">Add Property</button>
							</div>			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--4-col" style="display: none;">
		<div class="mdl-card mdl-shadow--4dp">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Connect Related Contacts</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div style="">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					    <label>Select Contact</label>
						<ul id="c_relation_contact" class="mdl-textfield__input">
						</ul>
					</div>
				</div>
				<div style="">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					    <input type="text" id="c_relation" name="c_relation" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { $edit_customer[0]->ic_name; } ?>">
					    <label class="mdl-textfield__label" for="c_relation">Relationship with Contact</label>
					</div>
				</div>
				<div>
				    <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent" style="width:100%;" id="btn_relation">Add to list</button>
				</div>
				<table id="relation_table" style="border:1px solid #999;width:100%; text-align:left;" border="1">
				    <thead style="background-color:#999; color:#fff;">
				        <tr>
				            <th>Action</th>
					        <th>Contact</th>
					        <th>Relation</th>
					    </tr>
				    </thead>
				    <tbody>
				        <?php if(isset($edit_relations)) {
				           for($i=0;$i< count($edit_relations); $i++) {
				               echo "<tr>";
				               echo "<td><button class='mdl-button mdl-js-button mdl-button--icon delete' id='".$i."'><i class='material-icons'>delete</i></button></td>";
				               echo "<td>".$edit_relations[$i]->ic_name."</td>";
				               echo "<td>".$edit_relations[$i]->icr_relation."</td>";
				               echo "</tr>";
				           } 
				        }?>
				    </tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- <div class="mdl-cell mdl-cell--4-col">
		<div class="mdl-card mdl-shadow--4dp">
			<div class="mdl-card__title">
				<h2 class="mdl-card__title-text">Tags</h2>
			</div>
			<div class="mdl-card__supporting-text">
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<ul id="myTags" class="mdl-textfield__input">
						<?php 
							if (isset($edit_preferences)) {
								if (count($edit_preferences) > 0 && count($tags) > 0) {
									for ($j=0; $j < count($edit_preferences) ; $j++) { 
										echo "<li>".$edit_preferences[$j]->it_value."</li>";
									}
								}
							}
						?>
					</ul>
					</div>
				</div>			
			</div>
		</div>
	</div> -->
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit_contact">
		<i class="material-icons">done</i>
	</button>
</div>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	var options = [];

    	<?php
			for ($j=0; $j < count($section); $j++) {
				echo "options.push('".$section[$j]->ic_section."');";
			}	
		?>
		$("#c_section" ).autocomplete({
            source: options
        });
    	
    	<?php
    		for ($i=0; $i < count($tags) ; $i++) { 
    			echo "tag_data.push('".$tags[$i]->it_value."');";
    		}
    	?>
    	
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});
    	
    	var contact_data = [];
    	
    	<?php
    		for ($i=0; $i < count($customer) ; $i++) { 
    			echo "contact_data.push('".$customer[$i]->ic_name."');";
    		}
    	?>
    	
    	$('#c_relation_contact').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : contact_data,
    		allowDuplicates: true,
    		tagLimit : 1,
    		singleField : true
    	});

    var rel_contact_arr = [];
	var rel_desc_arr = [];
	    
	<?php if(isset($edit_relations)) {
       for($i=0;$i< count($edit_relations); $i++) {
           echo "rel_contact_arr.push('".$edit_relations[$i]->ic_name."');";
           echo "rel_desc_arr.push('".$edit_relations[$i]->icr_relation."');";
       } 
    }?>

	 //    var acc_act = document.getElementsByClassName("accordion_activity");
		// var i;

		// for (i = 0; i < acc_act.length; i++) {
		// 	acc_act[i].addEventListener("click", function() {
		// 	this.classList.toggle("active");
		// 	var panel = this.nextElementSibling;
		// 	    if (panel.style.maxHeight){
		// 	      panel.style.maxHeight = null;
		// 	    } else {
		// 	      panel.style.maxHeight = panel.scrollHeight + "px";
		// 	    } 
		// 	});
		// }

		// var acc_act = document.getElementsByClassName("accordion_activity");

		// for (i = 0; i < acc_act.length; i++) {
		// 	acc_act[i].addEventListener("click", function() {
		// 	this.classList.toggle("active");
		// 	var panel = this.nextElementSibling;
		// 	    if (panel.style.maxHeight){
		// 	      panel.style.maxHeight = null;
		// 	    } else {
		// 	      panel.style.maxHeight = panel.scrollHeight + "px";
		// 	    } 
		// 	});
		// }

		$('#c_name').focus();	

        $('#btn_relation').click(function(e) {
            e.preventDefault();
            
			push_array_relations();
            load_table();
            reset_relation_inputs();
        });
        
        function load_table() {
            $('#relation_table > tbody').empty();
            var out="";
            for(var i=0; i < rel_contact_arr.length; i++) {
                out+="<tr><td><button class='mdl-button mdl-js-button mdl-button--icon delete' id='" + i + "'><i class='material-icons'>delete</i></button></td><td>"+ rel_contact_arr[i] + "</td><td>" + rel_desc_arr[i] + "</td></tr>";
            }
            $('#relation_table > tbody').append(out);
            
        }
        
        function reset_relation_inputs() {
            $('#c_relation_contact > .tagit-choice').remove();
    		$('#c_relation').val("");

    		$('#c_relation_contact').data("ui-tagit").tagInput.focus();
        }
        
        function push_array_relations() {
            $('#c_relation_contact > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					rel_contact_arr.push(tmpstr);
				}
			});
			
            rel_desc_arr.push($('#c_relation').val());
        }
        
        function remove_array_relations(id) {
            rel_contact_arr.splice(id, 1);
            rel_desc_arr.splice(id, 1);
        }
        
		$('#relation_table').on('click','.delete', function(e) {
			e.preventDefault();
			remove_array_relations($(this).prop('id'));
			load_table();
			reset_relation_inputs();
			
		});

		$('.upload').bind('change', function(){
			// console.log(this.files[0].size);
			// if(this.files[0].size > 3000000) {
			// 	$('#error').append("Cannot upload files greater than 3mb");
			// } else {
			// 	$('#error').val('');
			// }
		});

		var prp_count = 0;
		$('#add_prp').click(function(e) {
			e.preventDefault();
			var tmpcprp = 'c_n_val'+prp_count;
			$('#info_repeat').append('<div class="mdl-cell mdl-cell--6-col"><input type="text" name="c_n_prp[]" class="mdl-textfield__input" placeholder="Property"></div><div class="mdl-cell mdl-cell--6-col"><input type="text" name="c_n_val[]" class="mdl-textfield__input" placeholder="Value"></div>');
			tmpcprp = "#" + tmpcprp;
			$(tmpcprp).focus();
			prp_count++;
		});

		$('#submit_contact').click(function(e) {
			e.preventDefault();
			
			var c_new_prp = [];
			var c_new_val = [];
			$("input[name^='c_n_val']").each(function(){
				c_new_val.push($(this).val());
			});

			$("input[name^='c_n_prp']").each(function(){
				c_new_prp.push($(this).val());
			});

			var c_new_data = [];
			c_new_data.push({'n_p' : c_new_prp, 'n_v' : c_new_val});

			var c_value = [];
			$("input[name^='c_val']").each(function(){
				var pp = $(this).prop('id');
				var l = pp.length;
				pp = pp.substr(5,l);	
				c_value.push({'p': $(this).val(), 'v' : pp });
			});
			
			var customer_name = $('#c_name').val();
			var customer_info = [];

			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					customer_info.push(tmpstr);
				}
			});
			
			var stid = "";
            $.post('<?php if (isset($edit_customer)) { echo base_url()."Enterprise/update_customer/".$cid."/".$code; } else { echo base_url()."Enterprise/save_customer/".$code; } ?>',{
                'name' : customer_name,
                'new_property' : c_new_data,
                'value' : c_value,
                'tags' : customer_info,
                'rel_contact' : rel_contact_arr,
                'rel_desc' : rel_desc_arr,
                'section' : $('#c_section').val()
            }, function(data, status, xhr) { 
            	// console.log(data);
                uploadfiledata(data);
            }, 'text');
		});

		// var a_flg = 'false';
        
  //       $("#act_mail").change(function(){
  //           if($(this).prop("checked") == true){
  //               a_flg = 'true';
  //           }else{
  //               a_flg = 'false';
  //           }
  //       });

  //        $('#submit').click(function(e) {
  //           e.preventDefault();
  //           if($('#search_modal').css('display') != 'none'){
  //               var note = $('#notes_text').html();
  //               $('#ATags > li').each(function(index) {
  //                   var tmpstr = $(this).text();
  //                   var len = tmpstr.length - 1;
  //                   if(len > 0) {
  //                       tmpstr = tmpstr.substring(0, len);
  //                       activity_tags.push(tmpstr);
  //                   }
  //               });
  //               var date = $('.s_date').val();
  //               var e_date = $('.e_date').val();
  //               $.post('<?php //echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
  //                   'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
  //               }, function(data, status, xhr) {
  //                       location.reload();
  //               }, 'text');
  //           }
  //       });
	});
	

    function uploadfiledata(stid) {
    	var datat = new FormData();
    	if($('.upload')[0].files.length > 0 ) {
    		datat.append("use", $('.upload')[0].files[0]);
    		
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
    				flnm = data.toString();
    				$('.upload').val('');
    				file_upload(stid);
    			}
    		});
    	} else {
    		file_upload(stid);
    	}
    }

    function file_upload(id){
		if($('.u_multiple')[0].files.length > 0 ) {
			var datat = new FormData();
            var ins = $('.u_multiple')[0].files.length;
            for (var x = 0; x < ins; x++) {
                datat.append("used[]", $('.u_multiple')[0].files[x]);
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
					window.location = '<?php echo base_url()."Enterprise/customer_edit/".$code."/"; ?>'+id;
				}
			});
		} else {
			window.location = '<?php echo base_url()."Enterprise/customer_edit/".$code."/"; ?>'+id;
		}
	}

</script>
</html>