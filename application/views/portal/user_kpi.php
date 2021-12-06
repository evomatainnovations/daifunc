<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-grid  mdl-shadow--4dp" style="border-radius: 15px;">
				<div class="mdl-cell mdl-cell--10-col">
					<input type="text" class="mdl-textfield__input" id="title" style="font-size: 3em;outline: none;padding: 15px;" placeholder="Enter title" value="<?php if(isset($edit_kpi)){ echo $edit_kpi[0]->iukpi_title; } ?>">
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
						<input type="text" class="mdl-textfield__input" id="desc" name="title" value="<?php if(isset($edit_kpi)){ echo $edit_kpi[0]->iukpi_desc; } ?>">
						<label class="mdl-textfield__label" for="title">Enter Description</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="domain" name="domain">
							<option value="all">Select</option>
							<?php for ($i=0; $i < count($domain); $i++) { 
								echo "<option value='".$domain[$i]->idom_id."'";
								if(isset($edit_kpi)) {if($edit_kpi[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
								echo ">".$domain[$i]->idom_name."</option>";
							} ?>
						</select>
						<label class="mdl-textfield__label" for="domain">Select Domain</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="modules" name="modules">
							<option value="all">Select</option>
							<?php for ($i=0; $i < count($modules); $i++) { 
								echo "<option value='".$modules[$i]->im_id."'";
								if(isset($edit_kpi)) {if($edit_kpi[0]->im_id == $modules[$i]->im_id) { echo "selected";}}
								echo ">".$modules[$i]->im_name."</option>";
							} ?>
						</select>
						<label class="mdl-textfield__label" for="modules">Select Module</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="display" name="display">
							<option value="none" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "none") { echo "selected";} } ?>>Select</option>
							<option value="number" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "number") { echo "selected";} } ?>>Number Board</option>
							<option value="bar" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "bar") { echo "selected";} } ?>>Bar Chart</option>
							<option value="line" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "line") { echo "selected";} } ?>>Line Chart</option>
							<option value="histogram" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "histogram") { echo "selected";} } ?>>Histogram</option>
							<option value="pie" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "pie") { echo "selected";} } ?>>Pie Chart</option>
							<option value="geographic" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "geographic") { echo "selected";} } ?>>Geographic</option>
							<option value="table" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "table") { echo "selected";} } ?>>Table</option>
							<option value="scatter" <?php if(isset($edit_kpi)){ if ($edit_kpi[0]->iukpi_display_type == "scatter") { echo "selected";} } ?>>Scatter Plot</option>
						</select>
						<label class="mdl-textfield__label" for="display">Select Display</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" class="mdl-textfield__input" id="analytics" name="analytics" value="<?php if(isset($edit_kpi)){ echo $edit_kpi[0]->iukpi_analytics_trigger; } ?>">
						<label class="mdl-textfield__label" for="analytics">Enter Analytics Trigger</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
						<textarea class="mdl-textfield__input" id="query" name="query" rows="3"><?php if(isset($edit_kpi)){ echo $edit_kpi[0]->iukpi_query; } ?></textarea>
						<label class="mdl-textfield__label" for="query">Enter Query</label>
					</div>
				</div>
			</div>
			<div class="mdl-grid mdl-shadow--4dp" style="border-radius: 15px;height: 300px;">
				<h5 style="margin-left: 20px;">Enter php code</h5>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
						<textarea class="mdl-textfield__input" id="kpi_code" name="query" rows="3"><?php if(isset($edit_kpi)){ echo $kpi_code; } ?></textarea>
						<label class="mdl-textfield__label" for="kpi_code">Enter php code</label>
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
						<th class="mdl-data-table__cell--non-numeric">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($kpi) ; $i++) { 
							echo '<tr id="'.$kpi[$i]->iukpi_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$kpi[$i]->iukpi_title.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$kpi[$i]->idom_name.'/'.$kpi[$i]->im_name.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric"><div class="mdl-grid"><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button--icon edit" id="'.$kpi[$i]->iukpi_id.'"><i class="material-icons">edit</i></button></div><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button--icon delete" id="'.$kpi[$i]->iukpi_id.'"><i class="material-icons">delete</i></button></div></div></td>';
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i></button>
	</div>
</main>
</body>
<style type="text/css">
	
</style>
<script>
	var c_array = [];
	var p_array = [];
	var c_id = 0;
	var s_id  = 0;

	$(document).ready(function() {
		// buildNestedList(c_array, -1);
		$('.click_customer').on('click','.edit',function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			$(this).css('background-color', 'green');
			$(this).css('color', 'white');
			window.location = "<?php echo base_url().'Portal/create_user_kpi/'; ?>" + cid;
		});

		$('.click_customer').on('click','.delete',function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			$(this).css('background-color', 'green');
			$(this).css('color', 'white');
			window.location = "<?php echo base_url().'Portal/delete_kpi/'; ?>" + cid;
		});

		// $('#chart_view').on('change','.c_view',function (e) {
		// 	e.preventDefault();
		// 	var val = $(this).val();
		// 	var id = $(this).prop('id');
		// 		for (var i = 0; i < c_array.length; i++) {
		// 			if(c_array[i].id == id){
		// 				if (val != 'title' && val != 'chart' && val != 'desc') {
		// 					if (val == 'grid') {
		// 						c_array[i].name = '<div class="mdl-'+val+'">';

		// 					}else{
		// 						c_array[i].name = '<div class="mdl-cell mdl-cell--'+val+'">';
		// 					}
		// 					c_array[i].val = val;
		// 				}else{
		// 					c_array[i].val = val;
		// 					c_array[i].name = '$'+val;
		// 				}
		// 				break;
		// 			}
		// 		}
		// 	buildNestedList(c_array, -1);
		// });

		// $('#chart_view').on('click','.child',function (e) {
		// 	e.preventDefault();
		// 	var id = $(this).prop('id');
		// 	c_array.push({id : c_id ,parent : id,name : '',val : ''});
		// 	c_id++;
		// 	chart_view();
		// });

		// $('.c_btn').on('click','.main',function (e) {
		// 	e.preventDefault();
		// 	c_array.push({id : c_id ,parent : -1,name : '',val : ''});
		// 	c_id++;
		// 	chart_view();
		// });

		// function buildNestedList(treeNodes, rootId) {
		//   var nodesByParent = {};

		//   $.each(treeNodes, function(i, node) {
		//     if (!(node.parent in nodesByParent)) nodesByParent[node.parent] = [];
		//     nodesByParent[node.parent].push(node);
		//   });

		//   function buildTree(children) {
		//     var $container = $('<ul style="list-style-type: none;">');

		//     if (!children) return;
		//     $.each(children, function(i, child) {
		//       $('<li>', {text: child.name})
		//       .appendTo($container)
		//       .append( buildTree(nodesByParent[child.id]) );
		//     });
		//     $('.preview').empty();
		//     $('.preview').append($container);
		//     return $container;
		//   }
		//   return buildTree(nodesByParent[rootId]);
		// }

		$('#submit').click(function(e) {
			e.preventDefault();
			var timedep = "false";
			// if ($('#time_dep')[0].checked == "true") {
			// 	timedep = "true";
			// }

			$.post("<?php if(isset($edit_kpi)) { echo base_url().'Portal/update_kpi/'.$kid; } else { echo base_url().'Portal/save_user_kpi'; } ?>", {
				'title' : $('#title').val(),
				'domain' : $('#domain').val(),
				'module' : $('#modules').val(),
				'query' : $('#query').val(),
				'display' : $('#display').val(),
				'time' : timedep,
				'analytics' : $('#analytics').val(),
				'type' : $('#type').val(),
				'desc' : $('#desc').val(),
				'kpi_code' : $('#kpi_code').val()
			}, function(data, status, xhr) {
					window.location = "<?php echo base_url().'Portal/create_user_kpi'; ?>";
			}, "text");
		});

		// function chart_view() {
		// 	var a='';
		// 	a+='<div class="mdl-grid">';
		// 	for (var i = 0; i < c_array.length; i++) {
		// 		if (c_array[i].val != '') {
		// 			a+='<div class="mdl-cell mdl-cell--12-col">';
		// 			a+='<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><select class="mdl-textfield__input c_view" id="'+c_array[i].id+'" sname="modules">';
		// 			if (c_array[i].val == 'none') {
		// 				a+='<option value="none" selected>Select</option>';
		// 			}else{
		// 				a+='<option value="none">Select</option>';
		// 			}
		// 			if (c_array[i].val == 'grid') {
		// 				a+='<option value="grid" selected>grid</option>';
		// 			}else{
		// 				a+='<option value="grid">grid</option>';
		// 			}
		// 			if (c_array[i].val == '4-col') {
		// 				a+='<option value="4-col" selected>4-col</option>';
		// 			}else{
		// 				a+='<option value="4-col">4-col</option>';
		// 			}
		// 			if (c_array[i].val == '6-col') {
		// 				a+='<option value="6-col" selected>6-col</option>';
		// 			}else{
		// 				a+='<option value="6-col">6-col</option>';
		// 			}
		// 			if (c_array[i].val == '12-col') {
		// 				a+='<option value="12-col" selected>12-col</option>';
		// 			}else{
		// 				a+='<option value="12-col">12-col</option>';
		// 			}
		// 			if (c_array[i].val == 'title') {
		// 				a+='<option value="title" selected>title</option>';
		// 			}else{
		// 				a+='<option value="title">title</option>';
		// 			}
		// 			if (c_array[i].val == 'desc') {
		// 				a+='<option value="desc" selected>desc</option>';
		// 			}else{
		// 				a+='<option value="desc">desc</option>';
		// 			}
		// 			if (c_array[i].val == 'chart') {
		// 				a+='<option value="chart" selected>chart</option>';
		// 			}else{
		// 				a+='<option value="chart">chart</option>';
		// 			}
		// 			a+='</select></div>';
		// 			a+= '<button class="mdl-button child" id="'+c_array[i].id+'"><i class="material-icons">add</i> child</button><button class="mdl-button m_child" id="'+c_array[i].id+'"><i class="material-icons">delete</i></button></div>';
		// 		}else{
		// 			a+='<div class="mdl-cell mdl-cell--12-col">'
		// 			a+='<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><select class="mdl-textfield__input c_view" id="'+c_array[i].id+'" sname="modules">';
		// 			a+='<option value="none">Select</option><option value="grid">grid</option><option value="4-col">4-col</option><option value="6-col">6-col</option><option value="12-col">12-col</option><option value="title">title</option><option value="desc">desc</option><option value="chart">chart</option>';
		// 			a+='</select></div>';
		// 			a+= '<button class="mdl-button child" id="'+c_array[i].id+'"><i class="material-icons">add</i> child</button><button class="mdl-button m_child" id="'+c_array[i].id+'"><i class="material-icons">delete</i></button></div>';
		// 		}
		// 		a+='</div>';
		// 	}
		// 	a+='</div>';
		// 	$('#chart_view').empty();
		// 	$('#chart_view').append(a);
		// }
	});
</script>

</html>