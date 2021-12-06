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
		<?php 
			for ($i=0; $i < count($tips) ; $i++) { 
				echo '<div class="ond-card-name mdl-cell mdl-cell--4-col" id="'.$tips[$i]->iexttp_id.'"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">label</i>'.$tips[$i]->iexttp_tip.'</span></div>';
			}
		?>
	</div>
	<a href="<?php echo base_url().'education/tip_add'; ?>">
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
		<i class="material-icons">add</i>
	</button>
	</a>
	
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		$('.ond-card-name').click(function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'education/edit_tip/'; ?>" + $(this).prop('id');

		})
	})
</script>
</html>