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
			for ($i=0; $i < count($files) ; $i++) { 
				echo '<div class="ond-card-name mdl-cell mdl-cell--2-col" id="'.$files[$i]->ic_id.'"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">person</i>'.$customer[$i]->ic_name.'</span></div>';
			}
		?>
	</div>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		$('.ond-card-name').click(function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'education/fee_details/'; ?>" + $(this).prop('id');

		})
	})
</script>
</html>