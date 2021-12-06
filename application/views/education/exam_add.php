<style type="text/css">
	.ond-card-name {
		box-shadow: 1px 1px 2px #999!important;
		border-radius: 2px!important;
		/*width: 100%;*/
		padding: 10px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid" style="margin-bottom: 60px;">
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Provide Exam Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="b_name" name="b_name" class="mdl-textfield__input">
								<option value="all">Select</option>
								<?php 
									for ($i=0; $i < count($batch) ; $i++) { 
										echo '<option value="'.$batch[$i]->iextb_id.'" ';
										if(isset($edit_exam)) {
											if($batch[$i]->iextb_id == $edit_exam[0]->iextes_batch_id) {
												echo "selected";
											}
										}
										echo '>'.$batch[$i]->iextb_batch_name.'</option>';
									}
								?>
							</select>
							<label class="mdl-textfield__label" for="b_name">Select Batch</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="s_name" name="s_name" class="mdl-textfield__input">
								<option value="all">Select</option>
								<?php 
									for ($i=0; $i < count($subject) ; $i++) { 
										echo '<option value="'.$subject[$i]->iexts_id.'" ';
										if(isset($edit_exam)) {
											if($subject[$i]->iexts_id == $edit_exam[0]->iextes_subject_id) {
												echo "selected";
											}
										}
										echo '>'.$subject[$i]->iexts_name.'</option>';
									}
								?>
							</select>
							<label class="mdl-textfield__label" for="s_name">Select Subject</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-grid">
							<div class="mdl-cell--6-col">
								<button style="width: 100%;" id="chapter" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Chapter</button>
							</div>
							<div class="mdl-cell--6-col">
								<button style="width: 100%;" id="preliem" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-js-ripple-effect mdl-button--accent">Preliem</button>
							</div>
						</div>
					</div>
					<div class="mdl-cell--12-col" id="div_chapter">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="c_name" name="c_name" class="mdl-textfield__input">
								<option value="all">Select</option>
								<?php 
									if(isset($edit_exam)) {
										for ($i=0; $i < count($chapter) ; $i++) { 
											echo '<option value="'.$chapter[$i]->iextc_id.'" ';
											if($chapter[$i]->iextc_id == $edit_exam[0]->iextes_chapter_id) {
												echo "selected";
											}
											echo '>'.$chapter[$i]->iextc_name.'</option>';
										}
									}
								?>
							</select>
							<label class="mdl-textfield__label" for="c_name">Select Chapter</label>
						</div>
					</div>
					<div class="mdl-cell--12-col" id="div_preliems" style="display: none;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="p_name" name="p_name" class="mdl-textfield__input">
								<option value="all">Select</option>
								<?php 
									if(isset($edit_exam)) {
										for ($i=0; $i < count($preliem) ; $i++) { 
											echo '<option value="'.$preliem[$i]->iextp_id.'" ';
											if($preliem[$i]->iextp_id == $edit_exam[0]->iextes_preliem_id) {
												echo "selected";
											}
											echo '>'.$preliem[$i]->iextp_preliem_name.'</option>';
										}
									}
								?>
								<option value="add">Add New.</option>
							</select>
							<label class="mdl-textfield__label" for="p_name">Select Preliem</label>
						</div>
					</div>
					
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input-from" class="mdl-textfield__input" value="<?php if(isset($edit_exam)) { echo $edit_exam[0]->iextes_from_date; } ?>">
							<label class="mdl-textfield__label" for="date-input-from">From Date and Time</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input-to" class="mdl-textfield__input" value="<?php if(isset($edit_exam)) { echo $edit_exam[0]->iextes_to_date; } ?>">
							<label class="mdl-textfield__label" for="date-input-to">To Date and Time</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="notes" class="mdl-textfield__input" value="<?php if(isset($edit_exam)) { echo $edit_exam[0]->iextes_notes; } ?>">
							<label class="mdl-textfield__label" for="notes">Information for the exam</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Exams on selected date</h2>
				</div>
				<div class="mdl-card__supporting-text  record_detail_ert" style="text-align: left;">
				<?php if (isset($edit_exam)) {
					for ($i=0; $i < count($current) ; $i++) { 
						$dfg = "";
						$dfg .= '<div class="ond-card-name mdl-cell mdl-cell--12-col"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">label</i></span><br>'.$current[$i]->iexts_name;
						if ($current[$i]->iextes_type == "preliem") {
							$dfg.= '<br>'.$current[$i]->iextp_preliem_name;
						} else  {
							$dfg.= '<br>'.$current[$i]->iextc_name;
						}
						$dfg.='<br>'.$current[$i]->iextes_from_date.'</div>';

						echo $dfg;
					}
				} ?>
				</div>
			</div>
		</div>
		<div class="mdl-cell--2-col"></div>
		<hr>
		<div class="mdl-cell--4-col"></div>
		<div class="mdl-cell--4-col">
		<?php 
			if (isset($edit_exam)) {
				echo '<a href="'.base_url().'education/delete_exam/'.$eid.'"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;"><i class="material-icons">delete</i>Delete Exam</button></a>';
			}
		?>
		</div>
		<div class="mdl-cell--4-col"></div>
	</div>		
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
		<i class="material-icons">done</i>
	</button>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		var sel_view = "chapter";

		$('.view-click').click(function(e) {
			e.preventDefault();
			var chk = $(this).prop('id');
			if(chk=="chapter") {
				$('#chapter').addClass('mdl-button--raised');
				$('#preliem').removeClass('mdl-button--raised');
				$('#div_chapter').show();
				$('#div_preliems').hide();
				sel_view = "chapter";
			} else if (chk=="preliem") {
				$('#chapter').removeClass('mdl-button--raised');
				$('#preliem').addClass('mdl-button--raised');
				$('#div_chapter').hide();
				$('#div_preliems').show();
				sel_view = "preliem";
			}
		});

		<?php
			if (isset($edit_exam)) {
				if($edit_exam[0]->iextes_type == "preliem") {
					echo "$('#chapter').removeClass('mdl-button--raised');$('#preliem').addClass('mdl-button--raised');$('#div_chapter').hide();$('#div_preliems').show();sel_view = 'preliem';";
				} else {
					echo "$('#chapter').addClass('mdl-button--raised');$('#preliem').removeClass('mdl-button--raised');$('#div_chapter').show();$('#div_preliems').hide();sel_view = 'chapter';";
				}

				
			}
		?>

		$('#date-input-from').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss' });
		$('#date-input-to').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss' });

		$('#submit').click(function(e) {
			e.preventDefault();
			if (sel_view=="chapter") {
				var chp = $('#c_name').val();
				var pre = '';
			} else if(sel_view=="preliem") {
				var chp = '';
				var pre = $('#p_name').val();
			}

			$.post("<?php if (isset($edit_exam)) { echo base_url().'education/update_exam/'.$eid; } else { echo base_url().'education/save_exam'; } ; ?>", {
				'batch' : $('#b_name').val(),
				'subject' : $('#s_name').val(),
				'type' : sel_view,
				'chapter' : chp,
				'preliem' : pre,
				'from_date' : $('#date-input-from').val(),
				'to_date' : $('#date-input-to').val(),
				'notes' : $('#notes').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'education/exam_schedule'; ?>";
			}, "text");			
		});

		$('#date-input-from').change(function(e) {
			e.preventDefault();

			var dat = new Date($('#date-input-from').val());
			var dt = dat.getFullYear() + '-' + (dat.getMonth() + 1) + '-' + dat.getDate();
			$.post('<?php echo base_url()."education/get_exams/"; ?>' + dt,
				function(data, status, xhr) {
					console.log(data);

					var abc = JSON.parse(data);
					$('.record_detail_ert').empty()
					for (var i = 0; i < abc.length; i++) {
						var file = '<div class="ond-card-name mdl-cell mdl-cell--12-col"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">label</i></span><br>' + abc[i].iexts_name;

						if (abc[i].iextes_type == "preliem") {
							file += '<br>' + abc[i].iextp_preliem_name;
						} else  {
							file += '<br>' + abc[i].iextc_name;
						}
						file += '<br>' + abc[i].iextes_from_date + '</div>';
						$('.record_detail_ert').append(file);
					}
				}, "text");
		});

		$('#s_name').change(function(e) {
			e.preventDefault();

			var sid = $('#s_name').val();

			$.post('<?php echo base_url()."education/get_exam_chapters/"; ?>' + sid,
				function(data, status, xhr) {
					console.log(data);

					var abc = JSON.parse(data);
					$('#c_name').empty()
					$('#c_name').append('<option value="all">Select all</option>');
					for (var i = 0; i < abc.length; i++) {
						$('#c_name').append('<option value="' + abc[i].iextc_id + '">' + abc[i].iextc_name + '</option>')	
					}
				}, "text");

			$.post('<?php echo base_url()."education/get_exam_preliem/"; ?>' + sid,
				function(data, status, xhr) {
					console.log(data);

					var abc = JSON.parse(data);
					$('#p_name').empty()
					$('#p_name').append('<option value="all">Select all</option>');
					for (var i = 0; i < abc.length; i++) {
						$('#p_name').append('<option value="' + abc[i].iextp_id + '">' + abc[i].iextp_preliem_name + '</option>')	
					}
					$('#p_name').append('<option value="add">Add New...</option>');
				}, "text");
		});

		$('#p_name').change(function(e) {
			e.preventDefault();

			var sid = $('#p_name').val();
			if(sid == "add") {
				var ert = prompt("Enter the preliem name");
				$('#p_name').append('<option id="' + ert + '">' + ert + '</option>');
			}
			
		});
	});
</script>
</html>



