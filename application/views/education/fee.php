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
		<!-- GENERAL DETAILS -->
		<?php 
			for ($i=0; $i < count($customer) ; $i++) { 
				echo '<div class="ond-card-name mdl-cell mdl-cell--2-col" id="'.$customer[$i]->ic_id.'"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">person</i>'.$customer[$i]->ic_name.'</span></div>';
			}
		?>
	</div>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		$('#details').on('click', '.ond-card-name', (function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Education/fee_details/'; ?>" + $(this).prop('id');
		}));

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Education/fee_search/"; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.customer.length; i++) {
					out+='<div class="ond-card-name mdl-cell mdl-cell--2-col" id="' + abc.customer[i].ic_id + '"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">star</i>' + abc.customer[i].ic_name + '</span></div>';
				}

				$('#details').append(out);
			})
		});
	})
</script>
</html>