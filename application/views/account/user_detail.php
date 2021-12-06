<style type="text/css">
.pic_button {
	border-radius: 10px;
	box-shadow: 0px 4px 10px #ccc;
	margin: 20px;
	position: relative;
	overflow: hidden;
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
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Customer Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($user_info)) { echo $user_info[0]->iud_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Customer Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_company" name="c_company" class="mdl-textfield__input" value="<?php if(isset($user_info)) { echo $user_info[0]->iud_company; } ?>">
						<label class="mdl-textfield__label" for="c_company">Company Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_email" name="c_email" class="mdl-textfield__input" value="<?php if(isset($user_info)) { echo $user_info[0]->iud_email; } ?>">
						<label class="mdl-textfield__label" for="c_email">Email</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_phone" name="c_phone" class="mdl-textfield__input" value="<?php if(isset($user_info)) { echo $user_info[0]->iud_phone; } ?>">
						<label class="mdl-textfield__label" for="c_phone">Phone</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_address" name="c_address" class="mdl-textfield__input" value="<?php if(isset($user_info)) { echo $user_info[0]->iud_address; } ?>">
						<label class="mdl-textfield__label" for="c_address">Address</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_gst" name="c_gst" class="mdl-textfield__input" value="<?php if(isset($user_info)) { echo $user_info[0]->iud_gst; } ?>">
						<label class="mdl-textfield__label" for="c_gst">GST Number</label>
					</div>
					
					<?php if(isset($user_info)) { 
							echo '<a href="';
							echo base_url().'Account/reset_password/'.$uid.'/'.$code;
							echo '"><button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Change Password</button></a>';					
						}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-grid" style="padding: 0px;margin: 0px;">
				<div class="mdl-cell mdl-cell--12-col" style="margin: 0px;">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Your Logo</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
								Choose logo
								<input type="file" name="attach_file" class="upload">
							</div>
							<hr>
							<img src="<?php if(isset($logo)) echo $logo; ?>" style="width: 100%;">
						</div>
					</div>
				</div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit_user">
			<i class="material-icons">done</i>
		</button>
	</div>
</div>
</div>
</body>
<script>
	$(document).ready(function() {
		$('#submit_user').click(function(e) {
			e.preventDefault();
			
			var name = $('#c_name').val();
			var company = $('#c_company').val();
			var email = $('#c_email').val();
			var phone = $('#c_phone').val();
			var address = $('#c_address').val();
			var gst = $('#c_gst').val();

			<?php 
				echo "$.post('".base_url()."Account/update_details/".$uid."/".$code."', {'name' : name, 'company' : company, 'email' : email, 'phone' : phone, 'address' : address, 'gst' : gst}, function(data, status, xhr) {}, 'text');";
			?>

			var datat = new FormData();
			if($('.upload')[0].files[0]) {
				datat.append("use", $('.upload')[0].files[0]);
				
				flnm = "";
				$.ajax({
					url: "<?php echo base_url().'Account/logo_upload/'.$uid.'/'.$code; ?>", // Url to which the request is send
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
						// window.location = '<?php echo base_url()."Account/details/"; ?>'+data+'/'+'<?php echo $code; ?>';
					}
				});
			} else {
				window.location = '<?php echo base_url()."Account/details/".$uid."/".$code; ?>';
			}
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
</script>
</html>