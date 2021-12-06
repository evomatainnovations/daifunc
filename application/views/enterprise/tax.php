<style type="text/css">
	.btn-explore {
        background-color: #fff;
		color: #404040;
		border: 0px;
		padding: 10px 30px 10px 30px;
		border-radius: 15px;
		margin: 5px;
		font-weight: bold;
		height: 100px;
		border-radius: 10px;
		box-shadow: 0px 3px 10px #ccc;
    }

</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<?php 
			for ($i=0; $i < count($tax) ; $i++) { 
				echo '<div style="margin-left:10px;"><a class="mdl-navigation__link ani" href="'.base_url().'Enterprise/tax_edit/'.$code.'/'.$tax[$i]->ittxg_id.'"><button class="btn-explore">'.$tax[$i]->ittxg_group_name.'</button></a></div>';
			}
		?>
	</div>
	<a href="<?php echo base_url().'Enterprise/tax_add/'.$code; ?>">
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
			<i class="material-icons">add</i>
		</button>
	</a>
</main>
</div>
</body>
</html>
<script type="text/javascript">
	$(document).ready( function() {
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