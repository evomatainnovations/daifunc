<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Subject Name</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_subject)) { echo $edit_subject[0]->iexts_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Enter Subject Name</label>
					</div>
				</div>				
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		
		<?php 
			if(isset($edit_subject)) {
				echo '<div class="mdl-cell mdl-cell--2-col"></div>';
				echo '<div class="mdl-cell mdl-cell--8-col" >';
				echo '<a href="'.base_url().'education/subject_delete/'.$sid.'"><button class="mdl-button mdl-button-done mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Delete</button>';
				echo '</div>';
				echo '<div class="mdl-cell mdl-cell--2-col"></div>';
			}
		?>
		
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</div>
</div>
</body>
<script>
	$(document).ready(function() {
		$('#submit').click(function(e) {
			e.preventDefault();
			var customer_name = $('#c_name').val();
			<?php if (isset($edit_subject)) {
					echo "$.post('".base_url()."education/subject_update/".$sid."', {'name' : customer_name }, function(data, status, xhr) { window.location = '".base_url()."education/subjects' }, 'text');";
				} else {
					echo "$.post('".base_url()."education/subject_save', {'name' : customer_name }, function(data, status, xhr) { window.location = '".base_url()."education/subjects'}, 'text');";
				}
			?>			
		});
	});
</script>
</html>