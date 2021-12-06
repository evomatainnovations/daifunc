<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
						<th class="mdl-data-table__cell--non-numeric">Email</th>
						<th class="mdl-data-table__cell--non-numeric">Phone</th>
						<th class="mdl-data-table__cell--non-numeric">Company</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($customer) ; $i++) { 
							echo '<tr id="'.$customer[$i]->i_uid.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$customer[$i]->iud_name;
							echo '<td class="mdl-data-table__cell--non-numeric">'.$customer[$i]->iud_email;
							echo '<td class="mdl-data-table__cell--non-numeric">'.$customer[$i]->iud_phone;
							echo '<td class="mdl-data-table__cell--non-numeric">'.$customer[$i]->iud_company;
							echo "</tr>";
						}
					?>
				</tbody>
			</table>

		</div>
		<a href="<?php echo base_url().'Portal/customer_add'; ?>">
			<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
				<i class="material-icons">add</i>
			</button>
		</a>
	</div>
</main>
</div>
</body>
<script>
	$(document).ready(function() {
		$('.click_customer').click(function(e) {
			e.preventDefault();

			var cid = $(this).prop('id');

			window.location = "<?php echo base_url().'Portal/select_document_module/'; ?>"+ cid;
		});
	});
</script>

</html>