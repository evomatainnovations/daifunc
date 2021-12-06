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
					<h2 class="mdl-card__title-text">Provide Lecture Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="b_name" name="b_name" class="mdl-textfield__input">
								<option value="all">Select</option>
								<?php 
									for ($i=0; $i < count($batch) ; $i++) { 
										echo '<option value="'.$batch[$i]->iextb_id.'" ';
										if(isset($edit_lecture)) {
											if($batch[$i]->iextb_id == $edit_lecture[0]->iextls_batch_id) {
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
										if(isset($edit_lecture)) {
											if($subject[$i]->iexts_id == $edit_lecture[0]->iextls_subject_id) {
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
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="c_name" name="c_name" class="mdl-textfield__input">
								<option value="all">Select</option>
								<?php 
									if(isset($edit_lecture)) {
										for ($i=0; $i < count($chapter) ; $i++) { 
											echo '<option value="'.$chapter[$i]->iextc_id.'" ';
											if($chapter[$i]->iextc_id == $edit_lecture[0]->iextls_chapter_id) {
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
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="t_name" name="t_name" class="mdl-textfield__input">
								<option value="all">Select</option>
								<?php 
									for ($i=0; $i < count($teacher) ; $i++) { 
										echo '<option value="'.$teacher[$i]->ic_id.'" ';
										if(isset($edit_lecture)) {
											if($teacher[$i]->ic_id == $edit_lecture[0]->iextls_teacher_id) {
												echo "selected";
											}
										}
										echo '>'.$teacher[$i]->ic_name.'</option>';
									}
								?>
							</select>
							<label class="mdl-textfield__label" for="t_name">Select Teacher</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input-from" class="mdl-textfield__input" value="<?php if(isset($edit_lecture)) { echo $edit_lecture[0]->iextls_from_date; } ?>">
							<label class="mdl-textfield__label" for="date-input-from">From Date and Time</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input-to" class="mdl-textfield__input" value="<?php if(isset($edit_lecture)) { echo $edit_lecture[0]->iextls_to_date; } ?>">
							<label class="mdl-textfield__label" for="date-input-to">To Date and Time</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="notes" class="mdl-textfield__input" value="<?php if(isset($edit_lecture)) { echo $edit_lecture[0]->iextls_notes; } ?>">
							<label class="mdl-textfield__label" for="notes">Information for the lecture</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Lectures on selected date</h2>
				</div>
				<div class="mdl-card__supporting-text  record_detail_ert">
				</div>
			</div>
		</div>
		<div class="mdl-cell--2-col"></div>
		<hr>
		<div class="mdl-cell--4-col"></div>
		<div class="mdl-cell--4-col">
		<?php 
			if (isset($edit_lecture)) {
				echo '<a href="'.base_url().'education/delete_lecture/'.$lid.'"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;"><i class="material-icons">delete</i>Delete Lecture</button></a>';
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

		$('#date-input-from').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss' });
		$('#date-input-to').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD HH:mm:ss' });

		$('#submit').click(function(e) {
			e.preventDefault();

			$.post("<?php if (isset($edit_lecture)) { echo base_url().'education/update_lecture/'.$lid; } else { echo base_url().'education/save_lecture'; } ; ?>", {
				'batch' : $('#b_name').val(),
				'subject' : $('#s_name').val(),
				'chapter' : $('#c_name').val(),
				'teacher' : $('#t_name').val(),
				'from_date' : $('#date-input-from').val(),
				'to_date' : $('#date-input-to').val(),
				'notes' : $('#notes').val()
				
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'education/lecture_schedule'; ?>";
			}, "text");			
		});

		$('#date-input-from').change(function(e) {
			e.preventDefault();

			var dat = new Date($('#date-input-from').val());
			var dt = dat.getFullYear() + '-' + (dat.getMonth() + 1) + '-' + dat.getDate();
			$.post('<?php echo base_url()."education/get_lectures/"; ?>' + dt,
				function(data, status, xhr) {
					console.log(data);

					var abc = JSON.parse(data);
					$('.record_detail_ert').empty()
					for (var i = 0; i < abc.length; i++) {
						$('.record_detail_ert').append('<div class="ond-card-name mdl-cell mdl-cell--12-col"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">label</i></span><br>' + abc[i].iexts_name + '<br>' + abc[i].iextc_name + '<br>' + abc[i].ic_name + '<br>' + abc[i].iextls_from_date + '</div>');
					}
				}, "text");
		});

		$('#s_name').change(function(e) {
			e.preventDefault();

			var sid = $('#s_name').val();

			$.post('<?php echo base_url()."education/get_chapters/"; ?>' + sid,
				function(data, status, xhr) {
					console.log(data);

					var abc = JSON.parse(data);
					$('#c_name').empty()
					for (var i = 0; i < abc.length; i++) {
						$('#c_name').append('<option value="' + abc[i].iextc_id + '">' + abc[i].iextc_name + '</option>')	
					}
				}, "text");
		});
	});
</script>
</html>