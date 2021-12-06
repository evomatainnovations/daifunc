<style type="text/css">
	.fileUpload {
			position: relative;
			overflow: hidden;
			/*margin: 10px;*/
		}
		.fileUpload input.upload {
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
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Student Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->ic_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Enter Student Name</label>
					</div>
					<b>Choose Display Photo</b>
					<input type="file" name="attach_file" class="upload">					
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		<?php
			if (isset($edit_customer)) {
				echo '<div class="mdl-cell mdl-cell--4-col"></div>';
				echo '<div class="mdl-cell mdl-cell--2-col" style="text-align: center;">';
				echo '<a href="';
				echo base_url().'education/fee_details/'.$cid;
				echo '"><button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%;margin-left:0px !important;margin-right:0px !important;">Fees</button></a>';
				echo '</div>';
				echo '<div class="mdl-cell mdl-cell--2-col" style="text-align: center;">';
				echo '<a href="';
				echo base_url().'education/delete_student/'.$cid;
				echo '"><button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width:100%;margin-left:0px !important;margin-right:0px !important;">Delete</button></a>';
				echo '</div>';
				echo '<div class="mdl-cell mdl-cell--4-col"></div>';

			}
		?>
		
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
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

								echo '<div class="mdl-cell mdl-cell--6-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="c_val'.$pid.'" name="c_val[]" class="mdl-textfield__input" value="'.$val.'"><label class="mdl-textfield__label" for="c_val'.$pid.'">'.$prop.'</label></div></div>';
							}
						?>
					</div>
					<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">';
						<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="add_prp">Add Property</button>
					</div>			
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Preferences</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<ul id="myTags" class="mdl-textfield__input">
							<?php if (isset($edit_preferences)) {
									for ($j=0; $j < count($edit_preferences) ; $j++) { 
										$x = $edit_preferences[$j]->ictp_tag_id;
									
										$y = 0;
										for ($ij=0; $ij < count($tags) ; $ij++) { 
											$m = $tags[$ij]->it_id;
											if($x==$m) {
												$y=$ij;
											}
										}
										echo "<li>".$tags[$y]->it_value."</li>";
									}
								}
							?>
						</ul>
						</div>
					</div>			
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</div>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	
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
    });
</script>

<script>
	$(document).ready(function() {
		$('#c_name').focus();	

		$('#test').click(function(e) {
			e.preventDefault();
			
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
			$('#info_repeat').append('<div class="mdl-cell mdl-cell--6-col"><input type="text" name="c_n_prp[]" class="mdl-textfield__input" placeholder="Property"><input type="text" name="c_n_val[]" class="mdl-textfield__input" placeholder="Value"></div>');
			tmpcprp = "#" + tmpcprp;
			$(tmpcprp).focus();
			prp_count++;
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var c_new_prp = [];
			var c_new_val = [];
			$("input[name^='c_n_val'").each(function(){
				console.log($(this).val());
				c_new_val.push($(this).val());
			});

			$("input[name^='c_n_prp'").each(function(){
				console.log($(this).val());
				c_new_prp.push($(this).val());
			});

			var c_new_data = [];
			c_new_data.push({'n_p' : c_new_prp, 'n_v' : c_new_val});

			var c_value = [];
			$("input[name^='c_val'").each(function(){
				var pp = $(this).prop('id');
				var l = pp.length;
				pp = pp.substr(5,l);	
				c_value.push({'p': $(this).val(), 'v' : pp });
			});

			console.log(c_value);
			
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

			<?php if (isset($edit_customer)) {
					echo "$.post('".base_url()."education/update_student/".$cid."', {'name' : customer_name, 'new_property' : c_new_data, 'value' : c_value, 'tags' : customer_info }, function(data, status, xhr) { uploadfiledata(".$cid.");/*window.location = '".base_url()."education/students'*/ }, 'text');";
				} else {
					echo "$.post('".base_url()."education/save_student', {'name' : customer_name, 'new_property' : c_new_data, 'value' : c_value, 'tags' : customer_info }, function(data, status, xhr) { uploadfiledata(data); /*window.location = '".base_url()."education/students'*/}, 'text');";
				}
			?>

			
		});
	});

function uploadfiledata(stid) {
	var datat = new FormData();
	if($('.upload')[0].files[0]) {
		datat.append("use", $('.upload')[0].files[0]);
		
		flnm = "";
		$.ajax({
			url: "<?php echo base_url().'education/uploadfile/'; ?>" + stid, // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				console.log("Recd: " + data);
				flnm = data.toString();
				$('.upload').val('');
				window.location = '<?php echo base_url()."education/students"; ?>';
			}
		});
	} else {
		window.location = '<?php echo base_url()."education/students"; ?>';
	}
}
</script>
</html>