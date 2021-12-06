<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Add KPI Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" class="mdl-textfield__input" id="s_name" name="s_name">
								<label class="mdl-textfield__label" for="s_name">Enter KPI Name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_table" name="s_table">
									<option value="all">Select</option>
									<?php for ($i=0; $i < count($tables); $i++) { 
										echo "<option value='".$tables[$i]->table_name."'";
										if(isset($edit_kpi)) {if($edit_kpi[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
										echo ">".$tables[$i]->table_name."</option>";
									} ?>
								</select>
								<label class="mdl-textfield__label" for="s_table">Select Table Name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_column" name="s_column">
									<option value="all">Select</option>
								
								</select>
								<label class="mdl-textfield__label" for="s_column">Select Column Name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<textarea class="mdl-textfield__input" id="s_query" name="s_query" rows="5"></textarea>
								<label class="mdl-textfield__label" for="s_query">Enter Query</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_display" name="s_display">
									<option value="none">Select</option>
									<option value="number">Number Board</option>
									<option value="bar">Bar Chart</option>
									<option value="line">Line Chart</option>
									<option value="histogram">Histogram</option>
									<option value="pie">Pie Chart</option>
									<option value="geographic">Geographic</option>
									<option value="table">Table</option>
									<option value="scatter">Scatter Plot</option>
								</select>
								<label class="mdl-textfield__label" for="s_display">Select Display</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_function" name="s_function">
									<option value="none">Select</option>
									<option value="sum">Sum</option>
									<option value="avg">Average</option>
									<option value="frequency">Frequency</option>
									<option value="forecast">Forecast</option>
									<option value="mean">Mean</option>
									<option value="median">Median</option>
									<option value="growthpercent">Growth Percent</option>
								</select>
								<label class="mdl-textfield__label" for="s_function">Select Function</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_domain" name="s_domain">
									<option value="none">Select</option>
									<?php for ($i=0; $i < count($domain); $i++) { 
										echo "<option value='".$domain[$i]->idom_id."'";
										if(isset($edit_kpi)) {if($edit_function[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
										echo ">".$domain[$i]->idom_name."</option>";
									} ?>
								</select>
								<label class="mdl-textfield__label" for="s_domain">Select Domain</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_module" name="s_module">
									<option value="none">Select</option>
								</select>
								<label class="mdl-textfield__label" for="s_module">Select Module</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">KPI Name</th>
						<th class="mdl-data-table__cell--non-numeric">Domain/Module</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($kpi) ; $i++) { 
							echo '<tr id="'.$kpi[$i]->ikpi_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$kpi[$i]->ikpi_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$kpi[$i]->idom_name.'/'.$kpi[$i]->ifun_name.'</td>';
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
			$(this).css('background-color', 'green');
			$(this).css('color', 'white');

			$.post("<?php echo base_url().'Portal/get_kpi_details/'; ?>" + cid,
				function(data, status, xhr) {
					var abc = JSON.parse(data);
					$('#s_name').val(abc[0].ikpi_name);
					$('#s_query').val(abc[0].ikpi_query);
					$('#s_display').val(abc[0].ikpi_display);
					$('#s_function').val(abc[0].ikpi_type);
				}, "text");
			
		});

		$('#s_table').change(function(e) {
			e.preventDefault();
			$.post("<?php echo base_url().'Portal/get_kpi_columns'; ?>", {
				'tbl' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#s_column').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#s_column').append('<option value="' + abc[i].column_name + '">' + abc[i].column_name + '</option>');
				}
			}, "text");
		});

		$('#s_domain').change(function(e) {
			e.preventDefault();
			$.post("<?php echo base_url().'Portal/get_kpi_modules'; ?>", {
				'domain' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#s_module').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#s_module').append('<option value="' + abc[i].im_id + '">' + abc[i].im_name + '</option>');
				}
			}, "text");
		});

		$('#submit').click(function(e) {
			e.preventDefault();

			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_kpi/'.$kid; } else { echo base_url().'Portal/save_kpi'; } ?>", {
				'name' : $('#s_name').val(),
				'table' : $('#s_table').val(),
				'column' : $('#s_column').val(),
				'query' : $('#s_query').val(),
				'func' : $('#s_function').val(),
				'display' : $('#s_display').val(),
				'domain' : $('#s_domain').val(),
				'module' : $('#s_module').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Portal/create_kpi'; ?>"
			}, "text");
		});
	});
</script>

</html>