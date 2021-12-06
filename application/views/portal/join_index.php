<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Add Column Index</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<select class="mdl-textfield__input" id="s_table1" name="s_table1">
											<option value="all">Select</option>
											<?php for ($i=0; $i < count($tables); $i++) { 
												echo "<option value='".$tables[$i]->table_name."'";
												if(isset($edit_kpi)) {if($edit_kpi[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
												echo ">".$tables[$i]->table_name."</option>";
											} ?>
										</select>
										<label class="mdl-textfield__label" for="s_table1">Select Table Name</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<select class="mdl-textfield__input" id="s_column1" name="s_column1">
											<option value="all">Select</option>
										</select>
										<label class="mdl-textfield__label" for="s_column1">Select Column Name</label>
									</div>
								</div>
							</div>
						</div>								
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<select class="mdl-textfield__input" id="s_table2" name="s_table2">
											<option value="all">Select</option>
											<?php for ($i=0; $i < count($tables); $i++) { 
												echo "<option value='".$tables[$i]->table_name."'";
												if(isset($edit_kpi)) {if($edit_kpi[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
												echo ">".$tables[$i]->table_name."</option>";
											} ?>
										</select>
										<label class="mdl-textfield__label" for="s_table2">Select Table Name</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<select class="mdl-textfield__input" id="s_column2" name="s_column2">
											<option value="all">Select</option>
										</select>
										<label class="mdl-textfield__label" for="s_column2">Select Column Name</label>
									</div>
								</div>
							</div>
						</div>

						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" class="mdl-textfield__input" id="s_name" name="s_name" >
								<label class="mdl-textfield__label" for="s_name">Enter Relation Name</label>
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
						<th class="mdl-data-table__cell--non-numeric">Table 1</th>
						<th class="mdl-data-table__cell--non-numeric">Table 2</th>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
						<th class="mdl-data-table__cell--non-numeric">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($index) ; $i++) { 
							echo '<tr id="t'.$index[$i]->iji_id.'">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->iji_table1.'.'.$index[$i]->iji_column1.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->iji_table2.'.'.$index[$i]->iji_column2.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->iji_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent edit" id="'.$index[$i]->iji_id.'" ><i class="material-icons">edit</i></button><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent trash" id="'.$index[$i]->iji_id.'" ><i class="material-icons">delete</i></button></td>';
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
		$('.edit').click(function(e) {
			e.preventDefault();

			var cid = $(this).prop('id');
			$.post("<?php echo base_url().'Portal/get_ci_details/'; ?>" + cid,
				function(data, status, xhr) {
					var abc = JSON.parse(data);
					$('#s_type').val(abc[0].ici_type);
					$('#s_module').val(abc[0].ici_module_entity_id);
					$('#s_table').val(abc[0].ici_table_name);
					$('#s_column').val(abc[0].ici_column_name);
					$('#s_name').val(abc[0].ici_name);
					$('#s_default').prop('checked', abc[0].ici_default);
					
				}, "text");
			
		});

		$('.trash').click(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Portal/delete_column_index"; ?>', {
				'del' : $(this).prop('id')
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				var file = "<tr>";
				for (var i = abc.length - 1; i >= 0; i--) {
					
					if (abc[i].ici_type == "entity") {
						file += '<td class="mdl-data-table__cell--non-numeric">' + abc[i].ici_module_entity_id + '</td>';	
					} else if (abc[i].ici_type=="module") {
						file += '<td class="mdl-data-table__cell--non-numeric">' + index[i].im_name + '</td>';
					}	
					
					file += '<td class="mdl-data-table__cell--non-numeric">' + abc[i].ici_table_name + '</td>';
					file += '<td class="mdl-data-table__cell--non-numeric">' + abc[i].ici_column_name + '</td>';
					file += '<td class="mdl-data-table__cell--non-numeric">' + abc[i].ici_name + '</td>';
					file += '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent edit" id="' + abc[i].ici_id +'" ><i class="material-icons">edit</i></button><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent trash" id="' + abc[i].ici_id + '" ><i class="material-icons">delete</i></button></td>';
					file += "</tr>";

				}

				$('tbody').append(file);
			}, "text");
		});

		$('#s_table1').change(function(e) {
			e.preventDefault();
			$.post("<?php echo base_url().'Portal/get_kpi_columns'; ?>", {
				'tbl' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#s_column1').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#s_column1').append('<option value="' + abc[i].column_name + '">' + abc[i].column_name + '</option>');
				}
			}, "text");
		});

		$('#s_table2').change(function(e) {
			e.preventDefault();
			$.post("<?php echo base_url().'Portal/get_kpi_columns'; ?>", {
				'tbl' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#s_column2').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#s_column2').append('<option value="' + abc[i].column_name + '">' + abc[i].column_name + '</option>');
				}
			}, "text");
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_join_index/'.$kid; } else { echo base_url().'Portal/save_join_index'; } ?>", {
				'name' : $('#s_name').val(),
				'table1' : $('#s_table1').val(),
				'column1' : $('#s_column1').val(),
				'table2' : $('#s_table2').val(),
				'column2' : $('#s_column2').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Portal/join_index'; ?>"
			}, "text");
		});
	});
</script>

</html>