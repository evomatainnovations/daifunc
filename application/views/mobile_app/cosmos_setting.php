<main>
	<div id="signup_page" class="mdl-grid" style="text-align: center;">
		<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="c_name" value="<?php if(isset($u_data)) echo $u_data[0]->iextetmu_name; ?>">
				<label class="mdl-textfield__label" for="c_name">Your Name</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="c_company" value="<?php if(isset($u_data)) echo $u_data[0]->iextetmu_company; ?>">
				<label class="mdl-textfield__label" for="c_company">Company</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="c_email" value="<?php if(isset($u_data)) echo $u_data[0]->iextetmu_email; ?>">
				<label class="mdl-textfield__label" for="c_email">Email</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="c_phone" value="<?php if(isset($u_data)) echo $u_data[0]->iextetmu_phone_no; ?>">
				<label class="mdl-textfield__label" for="c_phone">Phone</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="c_address" value="<?php if(isset($u_data)) echo $u_data[0]->iextetmu_address; ?>">
				<label class="mdl-textfield__label" for="c_address">Address</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="c_gst" value="<?php if(isset($u_data)) echo $u_data[0]->iextetmu_gst_no; ?>">
				<label class="mdl-textfield__label" for="c_gst">GST Number</label>
			</div>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect" id="setting_update" style="width: 100%;">Save</button>
		</div>
	</div>
</main>
<script type="text/javascript">
	$(document).ready(function() {
		$('#setting_update').click(function(e){
			e.preventDefault();
			var email = $('#c_email').val();
			var name = $('#c_name').val();
			var company = $('#c_company').val();
			var phone = $('#c_phone').val();
			var address = $('#c_address').val();
			var gst = $('#c_gst').val();
			var pwd = $('#pwd').val();
			$('.loader').show();
			$.post('<?php echo base_url()."Mobile_app/setting_update_user/".$code; ?>', {
				'email' : email , 'name' : name , 'company' : company , 'phone' : phone , 'address' : address , 'gst' : gst , 'pwd' :pwd
			}, function(data, status, xhr) {
				$('.loader').hide();
				window.location = '<?php echo base_url().'Mobile_app/cosmos_setting/'.$code; ?>';
			}, 'text');
		});
	});
</script>