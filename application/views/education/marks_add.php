<main class="mdl-layout__content">
	<div class="mdl-grid" style="padding: 0px;">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-grid" style="padding: 0px;">
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Select Event</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-cell--12-col">
								 <div class="mdl-grid">
									<div class="mdl-cell--6-col">
										<button style="width: 100%;" id="btn_internal" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Internal Exams</button>
									</div>
									<div class="mdl-cell--6-col">
										<button style="width: 100%;" id="btn_external" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-js-ripple-effect mdl-button--accent">External Exams</button>
									</div>
								</div>
							</div>
							<div class="mdl-cell--12-col" id="div_internal">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<select id="internal" name="internal" class="mdl-textfield__input">
										<option value="none">Select</option>
										<?php 
											for ($i=0; $i < count($exam) ; $i++) { 
												echo '<option value="'.$exam[$i]->iextes_id.'"';

												if(isset($edit_marks)) {
													if($edit_marks[0]->iextm_event == "internal") {
														if($edit_marks[0]->iextm_event_id == $exam[$i]->iextes_id) {
															echo " selected";
														}
													}
												}

												echo '>'.$exam[$i]->iextb_batch_name.' - '.$exam[$i]->iexts_name.' - ';
												if ($exam[$i]->iextes_type == "chapter") {
													echo $exam[$i]->iextc_name.' - ';
												} else if($exam[$i]->iextes_type == 'preliem') {
													echo $exam[$i]->iextp_preliem_name.' - ';
												}
												echo $exam[$i]->iextes_from_date;

												
												echo '</option>';
											}
										?>
									</select>
									<label class="mdl-textfield__label" for="internal">Select Internal Exam</label>
								</div>
							</div>
							<div class="mdl-cell--12-col" id="div_external">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<select id="external" name="external" class="mdl-textfield__input">
										<option value="none">Select</option>
										<?php 
											for ($i=0; $i < count($exam_external) ; $i++) { 
												echo '<option value="'.$exam_external[$i]->iextee_id.'"';
												if(isset($edit_marks)) {
													if($edit_marks[0]->iextm_event == "external") {
														if($edit_marks[0]->iextm_event_id == $exam_external[$i]->iextee_id) {
															echo " selected";
														}
													}
												}
												echo '>'.$exam_external[$i]->iextb_batch_name.' - '.$exam_external[$i]->iexts_name.' - '.$exam_external[$i]->iextee_name.' - '.$exam_external[$i]->iextee_date.'</option>';
											}
										?>
									</select>
									<label class="mdl-textfield__label" for="external">Select External Exam</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Tags</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<ul id="myTags" class="mdl-textfield__input">
									<?php if (isset($edit_marks_tags)) {
											for ($j=0; $j < count($edit_marks_tags) ; $j++) { 
												$x = $edit_marks_tags[$j]->iextemt_tag_id;
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
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Enter Marks Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div id="info_repeat" class="mdl-grid">
						<?php 
							if(isset($edit_marks_record)) {
								for ($i=0; $i < count($edit_marks_record) ; $i++) { 
									echo '<div class="mdl-cell mdl-cell--4-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="'.$edit_marks_record[$i]->ic_id.'" name="s_name[]" class="mdl-textfield__input" readonly="true" value="'.$edit_marks_record[$i]->ic_name.'"><label class="mdl-textfield__label" for="'.$edit_marks_record[$i]->ic_id.'">Student Name</label></div></div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="o'.$edit_marks_record[$i]->ic_id.'" name="s_obtained[]" class="mdl-textfield__input" value="'.$edit_marks_record[$i]->iextmr_marks_obt.'"><label class="mdl-textfield__label" for="o'.$edit_marks_record[$i]->ic_id.'">Obtained</label> </div> </div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="t'.$edit_marks_record[$i]->ic_id.'" name="s_outof[]" class="mdl-textfield__input" value="'.$edit_marks_record[$i]->iextmr_out_of.'"><label class="mdl-textfield__label" for="t'.$edit_marks_record[$i]->ic_id.'">Out Of</label> </div> </div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="g'.$edit_marks_record[$i]->ic_id.'" name="s_grade[]" class="mdl-textfield__input" value="'.$edit_marks_record[$i]->iextmr_grade.'"><label class="mdl-textfield__label" for="g'.$edit_marks_record[$i]->ic_id.'">Grade</label></div> </div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="d'.$edit_marks_record[$i]->ic_id.'" name="s_details[]" class="mdl-textfield__input" value="'.$edit_marks_record[$i]->iextmr_details.'"><label class="mdl-textfield__label" for="internal">Details</label></div></div>';
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col"></div>
			<div class="mdl-cell mdl-cell--4-col">
			<?php if(isset($edit_product)) {
				echo "<a href='".base_url().'Education/delete_course/'.$pid."'";
				echo '<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Delete Course</button>';
				echo "</a>";
			}?>
			</div>
			<div class="mdl-cell mdl-cell--4-col"></div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
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

	<?php 
		if(isset($edit_marks)) {
			if($edit_marks[0]->iextm_event == "internal") {
				echo 'var sel_view = "internal";';
				echo "$('#btn_internal').addClass('mdl-button--raised');";
				echo "$('#btn_external').removeClass('mdl-button--raised');";
				echo "$('#div_internal').show();";
				echo "$('#div_external').hide();";
			} else if($edit_marks[0]->iextm_event == "external") {
				echo 'var sel_view = "external";';
				echo "$('#btn_external').addClass('mdl-button--raised');";
				echo "$('#btn_internal').removeClass('mdl-button--raised');";
				echo "$('#div_external').show();";
				echo "$('#div_internal').hide();";
			}
		} else {
			echo 'var sel_view = "internal";';
			echo "$('#btn_internal').addClass('mdl-button--raised');";
			echo "$('#btn_external').removeClass('mdl-button--raised');";
			echo "$('#div_internal').show();";
			echo "$('#div_external').hide();";
		}
	?>
	$('.view-click').click(function(e) {
		e.preventDefault();
		var chk = $(this).prop('id');
		if(chk=="btn_internal") {
			$('#btn_internal').addClass('mdl-button--raised');
			$('#btn_external').removeClass('mdl-button--raised');
			$('#div_internal').show();
			$('#div_external').hide();
			sel_view = "internal";
		} else if (chk=="btn_external") {
			$('#btn_internal').removeClass('mdl-button--raised');
			$('#btn_external').addClass('mdl-button--raised');
			$('#div_internal').hide();
			$('#div_external').show();
			sel_view = "external";
		}
	});
	$(document).ready(function() {
		$('#p_name').focus();	

		var prp_count = 0;
		$('#internal').change(function(e) {
			e.preventDefault();
			var eveid = $(this).val();

			$.post('<?php echo base_url()."Education/get_internal_exam_students/"; ?>' + eveid,
				function(data, status, xhr) {
					var abc = JSON.parse(data);
					$('#info_repeat').empty();
					for (var i = 0; i < abc.length; i++) {
						$('#info_repeat').append('<div class="mdl-cell mdl-cell--4-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="' + abc[i].ic_id + '" name="s_name[]" class="mdl-textfield__input" readonly="true" value="' + abc[i].ic_name + '"><label class="mdl-textfield__label" for="' + abc[i].ic_id + '">Student Name</label></div></div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="o' + abc[i].ic_id + '" name="s_obtained[]" class="mdl-textfield__input"><label class="mdl-textfield__label" for="o' + abc[i].ic_id + '">Obtained</label> </div> </div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="t' + abc[i].ic_id + '" name="s_outof[]" class="mdl-textfield__input"><label class="mdl-textfield__label" for="t' + abc[i].ic_id + '">Out Of</label> </div> </div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="g' + abc[i].ic_id + '" name="s_grade[]" class="mdl-textfield__input"><label class="mdl-textfield__label" for="g' + abc[i].ic_id + '">Grade</label></div> </div> <div class="mdl-cell mdl-cell--2-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <input type="text" id="d' + abc[i].ic_id + '" name="s_details[]" class="mdl-textfield__input"><label class="mdl-textfield__label" for="internal">Details</label></div></div>');
						}
					}, "text");
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			

			var sname = [];
			$("input[name^='s_name'").each(function(){
				sname.push($(this).prop('id'));
			});
			
			var sobt = [];
			$("input[name^='s_obtained'").each(function(){
				sobt.push($(this).val());
			});
			
			var stot = [];
			$("input[name^='s_outof'").each(function(){
				stot.push($(this).val());
			});
			
			var sgrd = [];
			$("input[name^='s_grade'").each(function(){
				sgrd.push($(this).val());
			});
			
			var sdet = [];
			$("input[name^='s_details'").each(function(){
				sdet.push($(this).val());
			});

			var sel_id = 0;

			if(sel_view == "internal") {
				sel_id = $('#internal').val();
			} else if(sel_view == "external") {
				sel_id = $('#external').val();
			}

			var product_tags = [];

			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					product_tags.push(tmpstr);
				}
			});

			$.post('<?php if (isset($edit_marks)) { echo base_url()."Education/update_marks/".$m_id; } else { echo base_url()."Education/save_marks"; } ?>', {
				'event' : sel_view,
				'event_id' : sel_id,
				'students' : sname,
				'obtained' : sobt,
				'outof' : stot,
				'grade' : sgrd,
				'details' : sdet,
				'tags' : product_tags 
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Education/marks"; ?>';
			}, 'text');

		});
	});
</script>
</html>