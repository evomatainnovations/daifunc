<style type="text/css">
	.ond-card-name {
		box-shadow: 1px 1px 2px #999!important;
		border-radius: 2px!important;
		/*width: 100%;*/
		padding: 10px;
	}
</style>

<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;color: black;">
					<h2 class="mdl-card__title-text">
						<div class="mdl-cell mdl-cell--6-col">
							Choose a subject to filter	
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select id="s_name" name="s_name" class="mdl-textfield__input">
									<option value="all" selected="true">All</option>
									<?php 
										for ($i=0; $i < count($subject) ; $i++) { 
											echo '<option value="'.$subject[$i]->iexts_id.'">'.$subject[$i]->iexts_name.'</option>';
										}
									?>
								</select>
								<label class="mdl-textfield__label" for="s_name" style="font: 5em;"></label>
							</div>
						</div>
					</h2>
				</div>
				<div class="mdl-card__supporting-text mdl-grid">
					<?php 
						for ($i=0; $i < count($teacher) ; $i++) { 
							echo '<div class="ond-card-name mdl-cell mdl-cell--3-col" id="'.$teacher[$i]->ic_id.'"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">person</i>'.$teacher[$i]->ic_name.'</span></div>';
						}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
	</div>
	<hr>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Education/general_properties/Teachers'; ?>">
				<button style="width: 100%;" class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">General Properties</button>
			</a>
		</div>
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	
	<a href="<?php echo base_url().'education/teacher_add'; ?>">
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
		<i class="material-icons">add</i>
	</button>
	</a>
	
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		$('#s_name').val('all');

		$('.mdl-card__supporting-text').on('click','.ond-card-name', (function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'education/teacher_edit/'; ?>" + $(this).prop('id');

		}));

		$('#s_name').change(function(e) {
			e.preventDefault();

			$.post("<?php echo base_url().'education/select_subject_teacher/'; ?>" + $(this).val(),
				function(data, status, xhr) {
					var abc = JSON.parse(data);

					var ert = "";
					$('.mdl-card__supporting-text').empty()
					for (var i = 0; i < abc.length; i++) {
						ert+= '<div class="ond-card-name mdl-cell mdl-cell--2-col" id="' + abc[i].ic_id + '"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">person</i>' + abc[i].ic_name + '</span></div>';
					}

					$('.mdl-card__supporting-text').append(ert);
				}, "text");

		});


	})
</script>
</html>