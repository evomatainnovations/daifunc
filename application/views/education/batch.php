<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<div>
				<h5>Batch Details</h5>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input type="text" id="b_name" name="b_name" class="mdl-textfield__input" value="<?php if(isset($edit_batch)) { echo $edit_batch[0]->iextb_batch_name; } ?>">
				<label class="mdl-textfield__label" for="b_name">Enter Batch Name</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<select class="mdl-textfield__input" id="b_course">
					<option value="none">Select</option>
					<?php for ($i=0; $i < count($course) ; $i++) { 
						echo '<option value="'.$course[$i]->ip_id.'"';
						if (isset($edit_batch)) {
							if ($course[$i]->ip_id == $edit_batch[0]->iextb_course) {
								echo " selected";
							}
						}
						echo '>'.$course[$i]->ip_product.'</option>';
					} ?>
				</select>
				<label class="mdl-textfield__label" for="b_course">Select Course for this batch</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input type="text" id="b_year" name="b_year" class="mdl-textfield__input" value="<?php if(isset($edit_batch)) { echo $edit_batch[0]->iextb_year; } ?>">
				<label class="mdl-textfield__label" for="b_year">Batch Year</label>
			</div>
			<div>
				<h6>Batch Status</h6>
			</div>
			<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="b_active">
				<input type="checkbox" id="b_active" class="mdl-switch__input" <?php if (isset($edit_batch)) { if ($edit_batch[0]->iextb_status== "true") {echo "checked"; } } else { echo "checked";} ?>>
				<span class="mdl-switch__label">Active</span>
			</label>
			<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
				<i class="material-icons">done</i>
			</button>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<hr>
			<h4>Batches</h4>
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%;">
				<thead>
					<tr>
						<th>Action</th>
						<th class="mdl-data-table__cell--non-numeric">Batch</th>
						<th>Year</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if (count($batch) > 0) {
							for ($i=0; $i < count($batch) ; $i++) { 
								if($batch[$i]->iextb_status == "true") {
									echo '<tr style="color: #009933;font-weight: bold;">';
									echo '<td class="mdl-data-table__cell--non-numeric">';
									echo '<a href="'.base_url().'education/edit_batch/'.$batch[$i]->iextb_id.'">';
									echo '<i class="material-icons md-24" style="color: #009933;">create</i>';
									echo '</a>';
									echo '</td>';
									echo '<td class="mdl-data-table__cell--non-numeric">'.$batch[$i]->iextb_batch_name.'</td>';
									echo '<td>'.$batch[$i]->iextb_year.'</td>';
									echo '</tr>';
								} else {
									echo '<tr style="color: #e60000;font-weight: bold;">';
									echo '<td class="mdl-data-table__cell--non-numeric">';
									echo '<a href="'.base_url().'education/edit_batch/'.$batch[$i]->iextb_id.'">';
									echo '<i class="material-icons md-24" style="color: #e60000;">create</i>';
									echo '</a>';
									echo '</td>';
									echo '<td class="mdl-data-table__cell--non-numeric">'.$batch[$i]->iextb_batch_name.'</td>';
									echo '<td>'.$batch[$i]->iextb_year.'</td>';
									echo '</tr>';
								}
							}
							
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
	</div>
</div>
</div>
</body>

<script>
	$(document).ready(function() {

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var batch = $('#b_name').val();
			var year = $('#b_year').val();
			var course = $('#b_course').val();

			var active = $('#b_active').prop('checked');


			// if (active!== "true") {
			// 	active = "false";
			// }

			<?php if (isset($edit_batch)) {
					echo "$.post('".base_url()."education/update_batch/".$bid."', {'batch' : batch, 'year' : year, 'course' : course,  'active' : active }, function(data, status, xhr) {window.location = '".base_url()."education/batch'}, 'text');";
				} else {
					echo "$.post('".base_url()."education/save_batch', {'batch' : batch, 'year' : year, 'course' : course, 'active' : active }, function(data, status, xhr) {window.location = '".base_url()."education/batch'}, 'text');";
				}
			?>
		});
	});
</script>
</html>