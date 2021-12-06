<main class="mdl-layout__content">
	<div class="mdl-grid">
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
			<thead>
				<tr>
					<th class="mdl-data-table__cell--non-numeric">Email title</th>
				</tr>
			</thead>
			<tbody id="details">
				<?php
					for ($i=0; $i < count($e_temp) ; $i++) { 
						if(count($e_temp) > 0) {
							echo '<tr style="color: #009933;font-weight: bold;" class="email_view" id="'.$e_temp[$i]->iuetemp_id.'">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$e_temp[$i]->iuetemp_title.'</td>';
							echo '</tr>';
						}else{
							echo '<tr style="color: #009933;font-weight: bold;">';
							echo 'Email Template Not Created</tr>';
						}
					}
				?>
			</tbody>
		</table>
	</div>

	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
		<i class="material-icons">add</i>
	</button>
</main>
<script type="text/javascript">
$(document).ready( function() {

	$('#add').click(function(e) {
		window.location = "<?php echo base_url().'Account/email_template_add/'.$code; ?>";
	});

	$('.email_view').click(function (e) {
		var temp_id = $(this).prop('id');
		window.location = "<?php echo base_url().'Account/email_template_add/'.$code.'/'; ?>"+temp_id;
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