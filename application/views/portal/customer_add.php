<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Customer Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->iud_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Customer Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_company" name="c_company" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->iud_company; } ?>">
						<label class="mdl-textfield__label" for="c_company">Company Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_email" name="c_email" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->iud_email; } ?>">
						<label class="mdl-textfield__label" for="c_email">Email</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_phone" name="c_phone" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->iud_phone; } ?>">
						<label class="mdl-textfield__label" for="c_phone">Phone</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_address" name="c_address" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->iud_address; } ?>">
						<label class="mdl-textfield__label" for="c_address">Address</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="cust_storage" name="cust_storage" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->i_storage; } ?>">
						<label class="mdl-textfield__label" for="cust_storage">User Storage(in MB)</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="cust_g_limit" name="cust_g_limit" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->i_g_limit; } ?>">
						<label class="mdl-textfield__label" for="cust_g_limit">Group Creation Limit</label>
					</div>
					<?php if(isset($edit_customer)) { 
							echo '<div><a href="';
							echo base_url().'Portal/customer_password_reset/'.$cid;
							echo '"><button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Regenerate Password</button></a></div>';

							echo '<div style="margin-top:20px;"><a href="';
							echo base_url().'Portal/delete_customer/'.$cid;
							echo '"><button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Delete Customer</button></a></div>';
						}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Subscription</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="c_active">
								<input type="checkbox" id="c_active" class="mdl-switch__input" <?php if (isset($edit_customer)) { if ($edit_customer[0]->i_status== "true") {echo "checked"; } } else { echo "checked";} ?>>
								<span class="mdl-switch__label">Subscription Status
									<?php 
										// if (isset($edit_customer)) {
										// 	if ($edit_customer[0]->i_status!= "true") {
										// 		echo "<br><b style='color:white;background-color:red;padding:5px;'>".$edit_customer[0]->i_status."</b>";
										// 	}
										// } 
									?>
									</span>
							</label>
						</div>
						<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="c_sub_start" name="c_sub_start" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->i_subscription_start; } ?>">
							<label class="mdl-textfield__label" for="c_sub_start">Subscription Start Date (YYYY-MM-DD)</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="c_duration" name="c_duration" class="mdl-textfield__input" value="<?php if(isset($edit_customer)) { echo $edit_customer[0]->i_duration; } ?>">
							<label class="mdl-textfield__label" for="c_duration">Duration (days)</label>
						</div> -->
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
										$x = $edit_preferences[$j]->iacp_tag_id;
									
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
    			echo "tag_data.push('".$tags[$i]->iat_value."');";
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
		$('#submit').click(function(e) {
			e.preventDefault();
			
			var name = $('#c_name').val();
			var company = $('#c_company').val();
			var email = $('#c_email').val();
			var phone = $('#c_phone').val();
			var address = $('#c_address').val();
			var g_limit = $('#cust_g_limit').val();
			var status = $('#c_active').prop('checked');
			var subscription = $('#c_sub_start').val();
			var duration = $('#c_duration').val();
			var cust_storage = $('#cust_storage').val();

			var renewal = calc();
			
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
				if (isset($edit_customer)) {
					//echo"edit";
					echo "$.post('".base_url()."Portal/update_customer/".$cid."', {'name' : name, 'company' : company, 'email' : email, 'phone' : phone, 'address' : address, 'status': status, 'subscription': subscription, 'duration' : duration, 'renewal' : renewal, 'tags' : customer_info, 'cust_storage' : cust_storage, 'cust_g_limit' : g_limit}, function(data, status, xhr) {window.location = '".base_url()."Portal/customers'}, 'text');";
				} else {
					// echo "save";
					echo "$.post('".base_url()."Portal/save_customer', {'name' : name, 'company' : company, 'email' : email, 'phone' : phone, 'address' : address, 'status': status, 'subscription': subscription, 'duration' : duration, 'renewal' : renewal, 'tags' : customer_info, 'cust_storage' : cust_storage, 'cust_g_limit' : g_limit}, function(data, status, xhr) {window.location = '".base_url()."Portal/customers'}, 'text');";
				}
			?>
		});

	});

	function calc() {
		var start = new Date($('#c_sub_start').val());
		var duration = parseInt($('#c_duration').val());
		
		var renewal = new Date();
		renewal.setDate(start.getDate() + duration);
		
		return renewal.getFullYear() + '-' + (renewal.getMonth() + 1) + '-' + renewal.getDate();
	}
</script>
</html>