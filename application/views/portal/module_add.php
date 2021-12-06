<main class="mdl-layout__content">
	<div class="mdl-grid">

		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Module Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin-bottom: 5%;">
						<div class="mdl-cell mdl-cell--4-col" id="publish">
							<?php
								if (isset($edit_module)) {
									if ($edit_module[0]->im_publish == 0) {
										echo '<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="publish_tag"><input type="checkbox" id="publish_tag" class="mdl-switch__input"><span class="mdl-switch__label">Publish Module</span></label>';
									}else{
										echo '<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="publish_tag"><input type="checkbox" id="publish_tag" class="mdl-switch__input" checked><span class="mdl-switch__label">Publish Module</span></label>';
									}
								}
							?>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="c_domain" name="c_domain" class="mdl-textfield__input">
								<option value="none">Select</option>
								<?php 
									for ($i=0; $i < count($domain) ; $i++) { 
										echo "<option value='".$domain[$i]->idom_id."'";
										if(isset($edit_module)) {
											if ($edit_module[0]->im_domain==$domain[$i]->idom_id) {
												echo " selected";
											}
										}
										echo ">".$domain[$i]->idom_name."</option>";
									}
								?>
							</select>
							<label class="mdl-textfield__label" for="c_domain">Select Domain</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="c_function" name="c_function" class="mdl-textfield__input">
								<option value="none">Select</option>
								<?php 
									if(isset($edit_module)) {
										for ($i=0; $i < count($func) ; $i++) { 
											echo "<option value='".$func[$i]->ifun_id."'";
											if($edit_module[0]->im_function==$func[$i]->ifun_id) {
												echo " selected";
											}
											echo ">".$func[$i]->ifun_name."</option>";
										}
									}
								?>
							</select>
							<label class="mdl-textfield__label" for="c_function">Select Function</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select class="mdl-textfield__input" id="c_table" name="c_table">
								<option value="all">Select</option>
								<?php for ($i=0; $i < count($tables); $i++) { 
									echo "<option value='".$tables[$i]->table_name."'";
									if(isset($edit_kpi)) {if($edit_kpi[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
									echo ">".$tables[$i]->table_name."</option>";
								} ?>
							</select>
							<label class="mdl-textfield__label" for="c_table">Select Table Name</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_module)) { echo $edit_module[0]->im_name; } ?>">
							<label class="mdl-textfield__label" for="c_name">Module Name</label>
						</div>
					</div>
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--4-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="m_price" name="m_price" class="mdl-textfield__input" value="<?php if(isset($edit_module)) { echo $edit_module[0]->im_price;}?>">
								<label class="mdl-textfield__label" for="m_price">Module Price (in Rs.)</label>
							</div>	
						</div>
						<div class="mdl-cell mdl-cell--8-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="m_subscription" name="m_subscription" class="mdl-textfield__input" value="<?php if(isset($edit_module)) { echo $edit_module[0]->im_subscription;}?>">
								<label class="mdl-textfield__label" for="m_subscription">Module Subscription (in months)</label>
							</div>
						</div>
					</div>
					<?php
						if (isset($edit_module)) {
							echo '<div class="mdl-cell mdl-cell--12-col"><button class="mdl-button mdl-button--colored m_delete" style="width: 100%;"><i class="material-icons">delete</i> Delete</button></div>';		
						}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Description</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
						<div class="mdl-textfield mdl-js-textfield">
						    <textarea class="mdl-textfield__input" type="text" rows= "3" id="m_desc"><?php if(isset($edit_module)) { echo $edit_module[0]->im_desc; } ?></textarea>
						    <label class="mdl-textfield__label" for="m_desc">Description</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield">
						    <textarea class="mdl-textfield__input" type="text" rows= "3" id="m_benefit"><?php if(isset($edit_module)) { echo $edit_module[0]->im_benefit; } ?></textarea>
						    <label class="mdl-textfield__label" for="m_benefit">Benefit</label>
						</div>
						<div>
							<input type="file" name="file[]" id="multiFiles" class="upload" multiple>
						</div>
					</div>			
				</div>
			</div>
			<div class="mdl-card mdl-shadow--4dp" style="margin-top: 20px;">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Preferences</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<ul id="myTags" class="mdl-textfield__input">
							<?php if (isset($edit_preferences)) {
									for ($j=0; $j < count($edit_preferences) ; $j++) { 
										$x = $edit_preferences[$j]->imp_tag_id;
									
										$y = 0;
										for ($ij=0; $ij < count($tags) ; $ij++) { 
											$m = $tags[$ij]->iat_id;
											if($x==$m) {
												$y=$ij;
											}
										}
										echo "<li>".$tags[$y]->iat_value."</li>";
									}
								}
							?>
						</ul>
						</div>
					</div>			
				</div>
			</div>
		</div>
		<!-- <div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col"></div>
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
										$x = $edit_preferences[$j]->imp_tag_id;
									
										$y = 0;
										for ($ij=0; $ij < count($tags) ; $ij++) { 
											$m = $tags[$ij]->iat_id;
											if($x==$m) {
												$y=$ij;
											}
										}
										echo "<li>".$tags[$y]->iat_value."</li>";
									}
								}
							?>
						</ul>
						</div>
					</div>			
				</div>
			</div>
		</div> -->
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</div>
</div>
</body>
<script type="text/javascript">
	var publish_flg=0;
    $(document).ready( function() {
    	var tag_data = [];
    	
    	<?php
    		for ($i=0; $i < count($tags) ; $i++) { 
    			echo "tag_data.push('".$tags[$i]->iat_value."');";
    		}
    		if (isset($edit_module)) {
				if ($edit_module[0]->im_publish == 0) {
					echo 'publish_flg=0;';
				}else{
					echo 'publish_flg=1;';
				}
			}
    	?>
    	
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

		$('#publish').on('change', 'input[type=checkbox]', function(e) {
            if($(this).is(":checked")){
                publish_flg = 1;
            }else if($(this).is(":not(:checked)")){
                publish_flg = 0;
            }
        });

		$('#c_domain').change(function(e) {
			e.preventDefault();

			$.post("<?php echo base_url().'Portal/get_functions'; ?>", {
				'domain' : $(this).val()
			}, function(data, status, xhr) {
				$('#c_function').empty();
				$('#c_function').append('<option value="none">Select</option>');
				
				var abc = JSON.parse(data);
				for (var i = 0; i < abc.length; i++) {
					$('#c_function').append('<option value="'+abc[i].ifun_id+'">' + abc[i].ifun_name + '</option>');
				}
			})
		});

		$('.m_delete').click(function (e) {
			e.preventDefault();
			$.post("<?php if(isset($edit_module)) { echo base_url().'Portal/delete_module/'.$mid; } ?>"
			, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Portal/modules"; ?>';
			})
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var name = $('#c_name').val();
			var domain = $('#c_domain').val();
			var func = $('#c_function').val();
			var table = $('#c_table').val();
			var desc = $('#m_desc').val();
			var price = $('#m_price').val();
			var subscription = $('#m_subscription').val();
			var m_benefit = $('#m_benefit').val();
			
			var customer_info = [];
			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					customer_info.push(tmpstr);
				}
			});

			<?php 
				if (isset($edit_module)) {
					echo "$.post('".base_url()."Portal/update_module/".$mid."', {'name' : name, 'domain' : domain, 'func':func, 'tags' : customer_info, 'table' : table ,'desc' : desc ,'price' : price, 'subscription' : subscription, publish : publish_flg, 'benefit': m_benefit}, function(data, status, xhr) { file_upload(data); }, 'text');";
				} else {
					echo "$.post('".base_url()."Portal/save_module', {'name' : name, 'domain' : domain, 'func':func, 'tags' : customer_info, 'table': table ,'desc' : desc ,'price' : price, 'subscription' : subscription, publish : publish_flg, 'benefit': m_benefit}, function(data, status, xhr) { file_upload(data); }, 'text');";
				}
			?>
		});

		function file_upload(id){

			if($('.upload')[0].files[0]) {

				var datat = new FormData();
                var ins = document.getElementById('multiFiles').files.length;
                for (var x = 0; x < ins; x++) {
                    datat.append("use[]", document.getElementById('multiFiles').files[x]);
                }

				$.ajax({
					url: "<?php echo base_url().'Portal/module_upload/'; ?>" + id, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						window.location = '<?php echo base_url()."Portal/modules"; ?>';
					}
				});
			} else {
				window.location = '<?php echo base_url()."Portal/modules"; ?>';
			}
		}

	});
</script>
</html>