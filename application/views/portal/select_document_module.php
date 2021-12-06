<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($modules_user) ; $i++) { 
							echo '<tr id="'.$modules_user[$i]->ium_m_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$modules_user[$i]->im_name;
							echo "</tr>";
						}
					?>
				</tbody>
			</table>

		</div>
	</div>
</main>
</div>
</body>
<script>
	$(document).ready(function() {
		$('.click_customer').click(function(e) {
			e.preventDefault();

			var mid = $(this).prop('id');

			window.location = "<?php echo base_url().'Portal/set_document_id/'.$cid.'/'; ?>"+ mid;
		});
	});
</script>

</html>