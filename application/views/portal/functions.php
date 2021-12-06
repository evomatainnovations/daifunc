<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Create A Function</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="d_name" name="d_name">
							<option value="all">Select</option>
							<?php for ($i=0; $i < count($domain); $i++) { 
								echo "<option value='".$domain[$i]->idom_id."'";
								if(isset($edit_function)) {if($edit_function[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
								echo ">".$domain[$i]->idom_name."</option>";
							} ?>
						</select>
						<label class="mdl-textfield__label" for="d_name">Select Domain Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_function)) { echo $edit_function[0]->ifun_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Enter Function Name</label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Domain</th>
						<th class="mdl-data-table__cell--non-numeric">Function</th>
						<th class="mdl-data-table__cell--non-numeric">Created</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($function) ; $i++) { 
							echo '<tr id="'.$function[$i]->ifun_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$function[$i]->idom_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$function[$i]->ifun_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$function[$i]->ifun_created.'</td>';
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

			window.location = "<?php echo base_url().'Portal/edit_system_function/'; ?>"+ cid;
		});

		$('#submit').click(function(e) {
			e.preventDefault();

			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_system_function/'.$did; } { echo base_url().'Portal/save_system_function'; } ?>", {
				'domain' : $('#d_name').val(),
				'func' : $('#c_name').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Portal/system_functions'; ?>"
			}, "text");
		});
	});
</script>

</html>