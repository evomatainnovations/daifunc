<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp display_list" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="mdl-data-table__cell--non-numeric">Modules</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
		<a href="<?php echo base_url().'Portal/explore_collection_add'; ?>">
			<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
				<i class="material-icons">add</i>
			</button>
		</a>
	</div>
</main>
</div>
</body>
<script>
	var col_arr = [];
	var mod_arr = [];
	<?php
		if (isset($collection)) {
			for ($i=0; $i <count($collection) ; $i++) { 
				echo "col_arr.push({'id':".$collection[$i]->iec_id.",'title' : '".$collection[$i]->iec_title."'});";
			}

			for ($i=0; $i <count($module) ; $i++) { 
				echo "mod_arr.push({'id' : ".$module[$i]->iecm_ec_id." , 'name' : '".$module[$i]->im_name."'});";
			}
		}
	?>
	$(document).ready(function() {
		display_list();
		$('.click_module').click(function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			window.location = "<?php echo base_url().'Portal/explore_collection_add/';?>"+cid;
		});

		function display_list(){
			var a = '';

			for (var i = 0; i < col_arr.length; i++) {
				a+= '<tr class="click_module" id="'+col_arr[i].id+'"><td class="mdl-data-table__cell--non-numeric">'+col_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">';
					var flg = 0;
					for (var j = 0; j < mod_arr.length; j++) {
						if(mod_arr[j].id == col_arr[i].id){
							if (flg == 0) {
								a+= mod_arr[j].name;
								flg = 1;
							}else{
								a+=', '+mod_arr[j].name;
							}
						}
					}
				a+='</td></tr>';	
			}
			$('.display_list > tbody').empty();
			$('.display_list > tbody').append(a);
		}
	});
</script>

</html>