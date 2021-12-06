<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/details/'.$uid.'/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Your Details</h2>
				</div>
			</div>
			</a>
		</div>
		<!--<div class="mdl-cell mdl-cell--4-col">-->
		<!--	<a href="<?php //echo base_url().'Account/create_module'; ?>">-->
		<!--	<div class="mdl-card mdl-shadow--4dp">-->
		<!--		<div class="mdl-card__title mdl-card--expand">-->
		<!--			<h2 class="mdl-card__title-text">Create your modules using Excel</h2>-->
		<!--		</div>-->
		<!--	</div>-->
		<!--</div>-->
		<!-- <div class="mdl-cell mdl-cell--4-col">
			<a href="<?php //echo base_url().'Account/user_list'; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Create users</h2>
				</div>
			</div>
		</div> -->
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/user_accounting_setting/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Accounting Setting</h2>
				</div>
			</div>
		</div>
		<!-- <div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/data_export'; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Data Export</h2>
				</div>
			</div>
		</div> -->
		<!-- <div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/module_setting/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Module Setting</h2>
				</div>
			</div>
		</div> -->
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/email_setting/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Email Setting</h2>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/invite_setting/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">My Groups</h2>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/storage_details/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">File storage</h2>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/email_template/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Email Templates</h2>
				</div>
			</div>
		</div>
		<?php
			if (isset($admin)) {
				echo '<div class="mdl-cell mdl-cell--4-col"><a href="';
				echo base_url().'Account/my_orders/'.$code;
				echo '"><div class="mdl-card mdl-shadow--4dp"><div class="mdl-card__title mdl-card--expand"><h2 class="mdl-card__title-text">My orders</h2></div></div></div>';

				echo '<div class="mdl-cell mdl-cell--4-col"><a href="';
				echo base_url().'Account/user_ref_code/'.$code;
				echo '"><div class="mdl-card mdl-shadow--4dp"><div class="mdl-card__title mdl-card--expand"><h2 class="mdl-card__title-text">Referrer code</h2></div></div></div>';
			}
		?>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/add_devices/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Add devices</h2>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/module_rename/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Module Rename</h2>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Account/mobile_users/'.$code; ?>">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand">
					<h2 class="mdl-card__title-text">Mobile Users</h2>
				</div>
			</div>
		</div>
	</div>
</main>
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function() {
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