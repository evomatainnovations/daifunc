<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Domain Name</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_domain)) { echo $edit_domain[0]->idom_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Enter Domain Name</label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($domain) ; $i++) { 
							echo '<tr id="'.$domain[$i]->idom_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$domain[$i]->idom_name;
							echo "</tr>";
						}
					?>
				</tbody>
			</table>

		</div>
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
</body>
<script>
	$(document).ready(function() {
		$('.click_customer').click(function(e) {
			e.preventDefault();

			var cid = $(this).prop('id');

			window.location = "<?php echo base_url().'Portal/edit_system_domain/'; ?>"+ cid;
		});

		$('#submit').click(function(e) {
			e.preventDefault();

			$.post("<?php if(isset($edit_domain)) { echo base_url().'Portal/update_system_domain/'.$did; } { echo base_url().'Portal/save_system_domain'; } ?>", {
				'domain' : $('#c_name').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Portal/system_domains'; ?>"				
			}, "text");
		});
	});
</script>

</html>