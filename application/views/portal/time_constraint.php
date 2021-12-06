<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Add Time Constraint Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" class="mdl-textfield__input" id="s_name" name="s_name">
								<label class="mdl-textfield__label" for="s_name">Enter Constraint Name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
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
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<label>Type Columns that will exist in the query</label>
								<ul id="myTags" class="mdl-textfield__input">
								</ul>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<textarea class="mdl-textfield__input" id="s_query" name="s_query" rows="5"></textarea>
								<label class="mdl-textfield__label" for="s_query">Enter Query</label>
							</div>
						</div>

						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="s_display" name="s_display">
									<option value="none">Select</option>
									<?php 
										for ($i=0; $i < count($display); $i++) { 
											echo "<option value='".$display[$i]->id_id."'>".$display[$i]->id_name."</option>";
										}
									?>
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
						<div class="mdl-cell mdl-cell--12-col">
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
						<div class="mdl-cell mdl-cell--12-col">
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
		<div class="mdl-cell mdl-cell--8-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">KPI Name</th>
						<th class="mdl-data-table__cell--non-numeric">Domain/Module</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($tc) ; $i++) { 
							echo '<tr id="'.$tc[$i]->itc_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$tc[$i]->itc_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$tc[$i]->idom_name.'/'.$tc[$i]->ifun_name.'</td>';
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
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});
    });
</script>
<script>
	$(document).ready(function() {
		$('.click_customer').click(function(e) {
			e.preventDefault();

			var cid = $(this).prop('id');
			$(this).css('background-color', 'green');
			$(this).css('color', 'white');

			$.post("<?php echo base_url().'Portal/get_tc_details/'; ?>" + cid,
				function(data, status, xhr) {
					var abc = JSON.parse(data);
					$('#s_name').val(abc[0].itc_name);
					$('#s_query').val(abc[0].itc_query);
				}, "text");
			
		});

		$('#s_table').change(function(e) {
			e.preventDefault();
			$.post("<?php echo base_url().'Portal/get_kpi_columns'; ?>", {
				'tbl' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#s_column').empty();
				// $('#s_column').append('<option value="' + abc[i].column_name + '">' + abc[i].column_name + '</option>');
				var tag_data = [];
				for (var i = 0; i < abc.length; i++) {
					tag_data.push(abc[i].column_name);
				}
		    	
		    		
		    	$('#myTags').tagit({
		    		autocomplete : { delay: 0, minLenght: 5},
		    		allowSpaces : true,
		    		availableTags : tag_data
		    	});
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

			var column = [];
			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					column.push(tmpstr);
				}
			});
			
			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_time_constraint/'.$kid; } else { echo base_url().'Portal/save_time_constraint'; } ?>", {
				'name' : $('#s_name').val(),
				'table' : $('#s_table').val(),
				'column' : column,
				'display' : $('#s_display').val(),
				'query' : $('#s_query').val(),
				'domain' : $('#s_domain').val(),
				'module' : $('#s_module').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Portal/create_time_constraint'; ?>"
			}, "text");
		});
	});
</script>

</html>