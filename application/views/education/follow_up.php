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
					<h2 class="mdl-card__title-text"><?php echo $module; ?> follow up details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="remarks" class="mdl-textfield__input" value="">
							<label class="mdl-textfield__label" for="remarks">Remarks</label>
						</div>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input-to" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="date-input-to">Next Remind Date</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Previous Follow ups</h2>
				</div>
				<div class="mdl-card__supporting-text" style="text-align: left;">
					<?php 
						for ($i=0; $i < count($follow) ; $i++) { 
							echo '<div class="ond-card-name mdl-cell mdl-cell--12-col">';
							echo '<span class="mdl-list__item-primary-content">';
							echo '<i class="material-icons mdl-list__item-icon">label</i></span><br>';
							echo $follow[$i]->iextfu_remarks.'<br>';
							echo $follow[$i]->iextfu_remind;
							echo '</div>';
						}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell--2-col"></div>
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

			$.post("<?php echo base_url().'education/update_follow_up/'.$module.'/'.$sid;?>", {
				'remarks' : $('#remarks').val(),
				'remind' : $('#date-input-to').val(),
				
			}, function(data, status, xhr) {
				<?php 
					if($module=="fees") {
						echo 'window.location = "'.base_url().'education/fee_details/'.$sid.'"';	
					} else if ($module=="enquiry") {
						echo 'window.location = "'.base_url().'education/enquiry"';
					}
				?>
			}, "text");			
		});

	});
</script>
</html>