<style type="text/css">
.field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Email Details</h2>
				</div>
				<div class="mdl-grid" style="display: flex;text-align: left;">
					<div class="mdl-card__supporting-text">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="dom_name" class="mdl-textfield__input" value="<?php if(isset($u_mail)){echo $u_mail[0]->iumail_domain;} ?>">
							<label class="mdl-textfield__label" for="dom_name">SMTP server</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="dom_email" class="mdl-textfield__input" value="<?php if(isset($u_mail)){echo $u_mail[0]->iumail_mail;} ?>">
							<label class="mdl-textfield__label" for="dom_email">Email</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="password" id="dom_pass" class="mdl-textfield__input" value="<?php if(isset($u_mail)){echo $u_mail[0]->iumail_password;} ?>">
							<label class="mdl-textfield__label" for="dom_pass">Password</label>
						</div>
						<button class="mdl-button mdl-button--icon toggle-password"><i class="material-icons show_pass" style="display: block;">visibility_off</i><i class="material-icons hide_pass" style="display: none;">visibility</i></button>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="port_no" class="mdl-textfield__input" value="<?php if(isset($u_mail)){echo $u_mail[0]->iumail_port;} ?>">
							<label class="mdl-textfield__label" for="port_no">SMTP Port Number</label>
						</div>
					</div>
				</div>
			</div>
		</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
		<div class="mdl-cell mdl-cell--4-col">
			<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent"  id="submit_email"><i class="material-icons">done</i></button>
		</div>
	</div>
	
</main>

<script type="text/javascript">
$(document).ready( function() {

	var snackbarContainer = document.querySelector('#demo-toast-example');

	$('.show_pass').click(function (e) {
		e.preventDefault();
		$(this).css('display','none');
		$('.hide_pass').css('display','block');
		$('#dom_pass').prop('type','text');
	})

	$('.hide_pass').click(function (e) {
		e.preventDefault();
		$(this).css('display','none');
		$('.show_pass').css('display','block');
		$('#dom_pass').prop('type','password');
	})

	$('#submit_email').click(function(e) {
		e.preventDefault();
		$.post('<?php echo base_url()."Account/email_save/".$code; ?>',{	
			'dom_name': $('#dom_name').val(),
			'dom_email':$('#dom_email').val(),
			'dom_pass':$('#dom_pass').val(),
			'port_no':$('#port_no').val()
		}, function(data, status, xhr) {
			var type = '<?php echo $type; ?>';
			if (type == 'home') {
				window.location = "<?php echo base_url().'Home/index/'.$code.'/email'; ?>";
			}else{
				if (data=="true") {
				 	var data = {message: 'Email Setting Save.'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data); 		
			 	}else if(data=="false"){
				 	var data = {message: 'Email Setting Not Save.Please Try Again.'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data); 	
				}
			}
		}, "text");
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