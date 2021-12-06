<style type="text/css">
	.ond-card-name {
		box-shadow: 1px 1px 2px #999!important;
		border-radius: 2px!important;
		/*width: 100%;*/
		padding: 10px;
	}
</style>

<main class="mdl-layout__content">
	<div class="mdl-grid" id="details">
		<?php 
			for ($i=0; $i < count($product) ; $i++) { 
				echo '<div class="ond-card-name mdl-cell mdl-cell--2-col" id="'.$product[$i]->ip_id.'"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">star</i>'.$product[$i]->ip_product.'</span></div>';
			}
		?>
	</div>
	<a href="<?php echo base_url().'Enterprise/service_add'; ?>">
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
		<i class="material-icons">add</i>
	</button>
	</a>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		$('#details').on('click', '.ond-card-name', (function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Enterprise/service_edit/'; ?>" + $(this).prop('id');
		}));

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Enterprise/service_search/"; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.product.length; i++) {
					out+='<div class="ond-card-name mdl-cell mdl-cell--2-col" id="' + abc.product[i].ip_id + '"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">star</i>' + abc.product[i].ip_product + '</span></div>';
				}

				$('#details').append(out);
			})
		});
	})
</script>
</html>