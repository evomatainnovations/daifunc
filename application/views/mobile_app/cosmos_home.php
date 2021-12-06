<main>
	<div class="mdl-grid">
		<?php
			if (isset($act_list)) {
				for ($i=0; $i < count($act_list) ; $i++) {
					$aid = $act_list[$i]->iua_id;
					$c_name = '';
					for ($j=0; $j < count($act_person) ; $j++) {
						if ($aid == $act_person[$j]->iuap_a_id) {
							$c_name = $act_person[$j]->ic_name;
						}
					}
					$a_date = date_create($act_list[$i]->iua_date);
					$title = '';
					$flg = 'false';
					for ($j=0; $j < count($support) ; $j++) { 
						if ($aid == $support[$j]->iesa_aid) {
							$title = $support[$j]->ies_subject;
							$flg = 'true';
						}
					}
					if (date_format($a_date ,"H:i") == '00:00') {
						$a_date = date_format($a_date,"jS F , Y");
					}else{
						$a_date = date_format($a_date,"jS F , Y @ H:i");
					}

					if ($flg == 'false') {
						$title = $act_list[$i]->iua_title;
					}
					$content = '<div class="mdl-cell mdl-cell--12-col"><div class="mdl-card" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 15px;height:auto;min-height: auto !important;text-align:left;"><h4 style="font-weight:bold;">'.$title.'</h4><hr style="padding-top:0px;margin: 0.5em 0;">';
					$content .= '<div style="display:flex;"><p><i class="material-icons">person</i></p><p> '.$c_name.'</p></div>';
					$content .= '<div style="display:flex;"><p><i class="material-icons">access_time</i></p><p> arrvie till '.$a_date.'</p></div>';
					if ($act_list[$i]->iua_status != 'pending') {
						$content .= '<div style="display:flex;"><p><i class="material-icons">show_chart</i></p><p> '.$act_list[$i]->iua_status.'</p></div>';
					}
					if ($act_list[$i]->iua_status == 'done') {
						$flg1 = 0;
						for ($ij=0; $ij < count($act_log) ; $ij++) {
							if ($aid == $act_log[$ij]->iual_a_id) {
								$flg1 = $act_log[$ij]->iual_id;
							}
						}
						if ($flg1 != 0) {
							$content .= '<div style="display:flex;"><button class="mdl-button mdl-button--colored feedback_btn" id="'.$flg1.'">give feedback</button></div>';
							$content .= '</div></div>';
							echo $content;
						}
					}else{
						$content .= '</div></div>';
						echo $content;
					}

				}
			}
		?>
	</div>
	<div class="modal fade" id="feedback_modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col details" style="">

						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
								<input type="text" id="sp_remark" class="mdl-textfield__input">
								<label class="mdl-textfield__label" for="sp_remark">Remarks</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
		                    <button class="mdl-button mdl-button--icon star_rat" id="star1"><i class="material-icons">star</i></button>
		                    <button class="mdl-button mdl-button--icon star_rat" id="star2"><i class="material-icons">star</i></button>
		                    <button class="mdl-button mdl-button--icon star_rat" id="star3"><i class="material-icons">star</i></button>
		                    <button class="mdl-button mdl-button--icon star_rat" id="star4"><i class="material-icons">star</i></button>
		                    <button class="mdl-button mdl-button--icon star_rat" id="star5"><i class="material-icons">star</i></button>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<button class="mdl-button mdl-button--colored mdl-button--raised submit_support" style="width: 100%;">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<script type="text/javascript">
	var feedback_id = 0;
	var star_rat = 0;
	$(document).ready(function() {
		$('.feedback_btn').click(function(e){
			e.preventDefault();
			feedback_id = $(this).prop('id');
			$('#feedback_modal').modal('show');

			$.post('<?php echo base_url()."Mobile_app/get_feedback_detail/".$code.'/';?>'+feedback_id,
	 		function(data, status, xhr) {
     			var a = JSON.parse(data);
     			var out = '';
     			if (a.act_title) {
     				out += '<p style="font-weight:bold;font-size:1.2em;"> '+a.act_title+'</p><hr>';
     			}
     			if (a.action_taken) {
     				out += '<p style="font-size:1em;">'+a.action_taken+'</p>';
     			}
     			if (a.act_person) {
     				out += '<p><i class="material-icons">person</i> '+a.act_person+'</p>';
     			}
     			$('.details').empty();
     			$('.details').append(out);
	       	});
		});

		$('.star_rat').click(function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            id = id.substring(4,5);
            star_rat = id;
            $('.star_rat').css('color','black');
            for (var i = 1; i <= id; i++) {
                $('#star'+i).css('color','red');
            }
        });

        $('.submit_support').click(function(e){
			e.preventDefault();
			$('.loader').show();
			$.post('<?php echo base_url()."Mobile_app/get_feedback_update/".$code.'/';?>'+feedback_id,{
				'remark' : $('#sp_remark').val(),
				'rat' : star_rat
	 		},function(data, status, xhr) {
	 			$('.loader').hide();
     			window.location = '<?php echo base_url().'Mobile_app/cosmos_home/'.$code; ?>';
	       	});
		});
	});
</script>

