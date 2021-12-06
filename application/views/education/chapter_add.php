<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Chapter Name</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="s_name" name="s_name" class="mdl-textfield__input">
							<?php 
								for ($i=0; $i < count($subject) ; $i++) { 
									echo '<option value="'.$subject[$i]->iexts_id.'" ';
									if(isset($edit_chapter)) {
										if($subject[$i]->iexts_id == $edit_chapter[0]->iextc_subject) {
											echo "selected";
										}
									}
									echo '>'.$subject[$i]->iexts_name.'</option>';
								}
							?>
						</select>
						<label class="mdl-textfield__label" for="s_name">Select Subject</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_chapter)) { echo $edit_chapter[0]->iextc_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Enter Chapter Name</label>
					</div>
				</div>				
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Required Time to Complete</h2>
				</div>
				<div class="mdl-card__supporting-text">
		            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="min_hr" name="min_hr" class="mdl-textfield__input" value="<?php if(isset($edit_chapter)) { echo $edit_chapter[0]->iextc_min_hours; } ?>">
						<label class="mdl-textfield__label" for="min_hr">Min Hours</label>
					</div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="max_hr" name="max_hr" class="mdl-textfield__input" value="<?php if(isset($edit_chapter)) { echo $edit_chapter[0]->iextc_max_hours; } ?>">
						<label class="mdl-textfield__label" for="max_hr">Max Hours</label>
					</div>
				</div>				
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		
		<?php 
			if(isset($edit_chapter)) {
				echo '<div class="mdl-cell mdl-cell--2-col"></div>';
				echo '<div class="mdl-cell mdl-cell--8-col" >';
				echo '<a href="'.base_url().'education/chapter_delete/'.$sid.'"><button class="mdl-button mdl-button-done mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Delete</button>';
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
			var chapter = $('#c_name').val();
			var subject = $('#s_name').val();
			console.log(subject);
			var min = $('#min_hr').val();
			var max = $('#max_hr').val();

			<?php if (isset($edit_chapter)) {
					echo "$.post('".base_url()."education/chapter_update/".$sid."', {'subject' : subject, 'chapter' : chapter, 'min': min, 'max': max }, function(data, status, xhr) { window.location = '".base_url()."education/chapters' }, 'text');";
				} else {
					echo "$.post('".base_url()."education/chapter_save', {'subject' : subject, 'chapter' : chapter, 'min': min, 'max': max  }, function(data, status, xhr) { window.location = '".base_url()."education/chapters'}, 'text');";
				}
			?>			
		});
	});
</script>
</html>