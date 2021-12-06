<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Location, <?php echo $sec_type; ?> and Date</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label>Enter Location Name</label>
						<ul id="i_name">
							<?php if(isset($edit_inventory)) { 
								echo "<li>".$edit_inventory[0]->ic_name."</li>";
							} ?>
						</ul>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="sec_type" class="mdl-textfield__input">
							<option value="N/A">Select</option>
							<?php for ($i=0; $i < count($inventory) ; $i++) { 
								echo "<option value='".$inventory[$i]->iextei_id."'>".$inventory[$i]->iextei_txn_id.' - '.$inventory[$i]->iextei_txn_date."</option>";
							} ?>
						</select>
						<label class="mdl-textfield__label" for="sec_type">Select Inward Transaction</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_inventory)) { echo $edit_inventory[0]->iextei_txn_date; } ?>">
						<label class="mdl-textfield__label" for="i_txn_date">Date of <?php echo $type; ?></label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Materials in Transaction</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric">Select</th>
								<th class="mdl-data-table__cell--non-numeric">Product</th>
							</tr>
						</thead>
						<tbody id="details">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var location_data = [];
    	<?php
    		for ($i=0; $i < count($locations) ; $i++) { 
    			echo "location_data.push('".$locations[$i]->iexteil_name."');";
    		}
    	?>
    	$('#i_name').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : location_data,
    		tagLimit : 1,
    		singleField : true
    	});
    	
    	$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: true });
    	<?php if (!isset($edit_inventory)) {
    		echo 'var dt = new Date();';
			echo "var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();";
			echo "$('#i_txn_date').val(s_dt);";
    	}?>
    });
</script>

<script>
	$(document).ready(function() {
		
		$('#sec_type').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Enterprise/inventory_locator_search_document/".$type; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.materials.length; i++) {
					out+='<tr><td class="mdl-data-table__cell--non-numeric"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="' + abc.materials[i].iexteid_id + '"><input type="checkbox" id="' + abc.materials[i].iexteid_id + '" name="materials[]" class="mdl-switch__input" ><span class="mdl-switch__label"></span></label></td><td class="mdl-data-table__cell--non-numeric">' + abc.materials[i].ip_product + ' - Qty: ';
					<?php if ($type == "Inward") { echo "out+=abc.materials[i].iexteid_inward + ' - S/n: ';";} else { echo "out+=abc.materials[i].iexteid_inward + ' - S/n: ';"; } ?>
					out+=abc.materials[i].iexteid_serial_number + '</td></tr>';
				}
				$('#details').append(out);
			}, "text");
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var location = [];
			$('#i_name > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					location.push(tmpstr);
				}
			});

			var b_std = [];
			var chkinp = $("input[name^='materials'");
			var a = 0;
			$("input[name^='materials'").each(function(){
				if(chkinp[a].checked) {
					b_std.push($(this).prop('id'));
				}
				a++;
			});

			var txn_no = $('#sec_type').val();
			var txn_date = $('#i_txn_date').val();

			$.post('<?php if (isset($edit_inventory)) { echo base_url()."Enterprise/update_inventory/".$type."/".$mod_id."/".$inid; } else { echo base_url()."Enterprise/save_inventory_locator/".$type."/".$mod_id; } ?>', {
				'location' : location[0],
				'txn_no' : txn_no,
				'txn_date' : txn_date,
				'products' : b_std,
			}, function(data, status, xhr) {
				<?php
					$url = base_url()."Enterprise/inventory_locator/".$mod_id."/";
				?>
				window.location = '<?php echo $url; ?>';
			}, 'text');
		});
	});
</script>
</html>