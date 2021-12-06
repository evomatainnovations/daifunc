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
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_type" name="s_type">
									<option value="all">Select</option>
									<option value="entity">Entity</option>
									<option value="module">Module</option>
								</select>
								<label class="mdl-textfield__label" for="s_type">Select Type</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_module" name="s_module">
									<option value="all">Select</option>
								</select>
								<label class="mdl-textfield__label" for="s_module">Select Module Name</label>
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
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" class="mdl-textfield__input" id="s_name" name="s_name" >
								<label class="mdl-textfield__label" for="s_name">Enter Column Name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="s_default">
									<input type="checkbox" class="mdl-switch__input" id="s_default" name="s_default" >
									<span class="mdl-switch__label" for="s_default">Default Option</span>
								</label>
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
						<th class="mdl-data-table__cell--non-numeric">Module</th>
						<th class="mdl-data-table__cell--non-numeric">Table</th>
						<th class="mdl-data-table__cell--non-numeric">Column</th>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
						<th class="mdl-data-table__cell--non-numeric">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($index) ; $i++) { 
							echo '<tr id="t'.$index[$i]->ici_id.'">';
							if ($index[$i]->ici_type == "entity") {
								echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->ici_module_entity_id.'</td>';	
							} else if ($index[$i]->ici_type=="module") {
								echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->im_name.'</td>';
							}
							
							echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->ici_table_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->ici_column_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$index[$i]->ici_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent edit" id="'.$index[$i]->ici_id.'" ><i class="material-icons">edit</i></button><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent trash" id="'.$index[$i]->ici_id.'" ><i class="material-icons">delete</i></button></td>';
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

		$('#s_type').change(function(e) {
			e.preventDefault();
			$.post("<?php echo base_url().'Portal/get_entity_module'; ?>", {
				'detail' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				if($('#s_type').val() == "entity") {
					$('#s_module').empty();
					$('#s_module').append('<option value="all">Select</option>');
					for (var i = 0; i < abc.length; i++) {
						$('#s_module').append('<option value="' + abc[i].ic_section + '">' + abc[i].ic_section + '</option>');
					}
				} else if ($('#s_type').val() == "module") {
					$('#s_module').empty();
					$('#s_module').append('<option value="all">Select</option>');
					for (var i = 0; i < abc.length; i++) {
						$('#s_module').append('<option value="' + abc[i].im_id + '">' + abc[i].im_name + '</option>');
					}
				}
			}, "text");
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_kpi/'.$kid; } else { echo base_url().'Portal/save_index'; } ?>", {
				'type' : $('#s_type').val(),
				'module' : $('#s_module').val(),
				'name' : $('#s_name').val(),
				'table' : $('#s_table').val(),
				'column' : $('#s_column').val(),
				'default' : $('#s_default').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Portal/column_index'; ?>"
			}, "text");
		});
	});
</script>

</html>