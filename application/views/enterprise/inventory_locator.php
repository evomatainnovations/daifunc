
<style>
	.block {
        box-shadow: 1px 1px 5px #999;
        padding: 0px;
        margin-bottom: 10px;
        margin-left: 10px;
        border-radius: 10px 10px 10px 10px;
    }

    .mdl-card__supporting-text {
    	width: 98%;
    }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col">
			<a href="<?php echo base_url().'Enterprise/inventory_location_manage/'; ?>">
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Manage Locations</button>
			</a>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<a href="<?php echo base_url().'Enterprise/inventory_locator_add/store/'.$mod_id; ?>">
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Store Material</button>
			</a>
		</div>
		<!-- <div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Enterprise/inventory_locator_add/dispatch/'.$mod_id; ?>">
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Dispatch Material</button>
			</a>
		</div> -->
	</div>
		<div class="mdl-grid" id="search_block" style="background-color: #fff; color: #4e4e4e; padding: 0px 20px 0px 20px; border-radius: 5px; margin: 12px; /*border: 1px solid #999;*/ box-shadow: 0px 0px 5px #999 inset; ">
			<div class="mdl-cell mdl-cell--4-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<select id="type_search" class="mdl-textfield__input" style="">
						<option value="product" selected>Product</option>
						<option value="location">Location</option>
					</select>
					<label class="mdl-textfield__label" for="i_txn_start_date">Select Type of Search</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--4-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
					<input type="text" id="name" class="mdl-textfield__input" style="width: 100%;" value="<?php if(isset($edit_amc)) { echo $edit_amc[0]->iextamc_period_to; } ?>">
					<label class="mdl-textfield__label" for="name">Type to Search</label>
				</div>
			</div>
			<div class="mdl-cell mdl-cell--4-col" style="padding-top: 15px;">		
				<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;" id="search">Search <i class="material-icons">search</i></button>
			</div>
		</div>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<div class="mdl-card mdl-shadow--4dp" id="detail_container" style="display: one;">
					<div class="mdl-card__title">
						<h2 class="mdl-card__title-text">Items present in selected location</h2>
					</div>
					<div class="mdl-card__supporting-text" style="padding: 3px;">
						<div class="mdl-grid" id="details">
						</div>
						<hr>
						<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
							<div class="mdl-tabs__tab-bar">
								<a href="#dispatch_material_tab"  style=" color: #000;" class="mdl-tabs__tab is-active" >Disptach Materials</a>
								<a href="#update_location_tab"  style=" color: #000;" class="mdl-tabs__tab">Update Locations</a>
							</div>
							<div class="mdl-tabs__panel is-active" id="dispatch_material_tab">
								<h4>Select outward order details and proceed to dispatch</h4>
								<div class="mdl-grid" id="dispatch_block" style="background-color: #fff; color: #4e4e4e; padding: 0px 20px 0px 20px; border-radius: 5px; margin: 12px; /*border: 1px solid #999;*/ box-shadow: 0px 0px 5px #999 inset; ">
									<div class="mdl-cell mdl-cell--4-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<select id="sec_type" class="mdl-textfield__input">
												<option value="N/A">Select</option>
												<?php for ($i=0; $i < count($outward) ; $i++) { 
													echo "<option value='".$outward[$i]->iextei_id."'>".$outward[$i]->ic_name.'('.$outward[$i]->iextei_txn_id.' - '.$outward[$i]->iextei_txn_date.")</option>";
												} ?>
											</select>
											<label class="mdl-textfield__label" for="i_txn_start_date">Select Outward Order</label>
										</div>
									</div>
									<div class="mdl-cell mdl-cell--4-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="">
											<label class="mdl-textfield__label" for="i_txn_date">Date of dispatch</label>
										</div>
									</div>
									<div class="mdl-cell mdl-cell--4-col" style="padding-top: 15px;">		
										<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;" id="dispatch">Proceed to dispatch <i class="material-icons">send</i></button>
									</div>
								</div>
								<div><ul id="outward_details"></ul></div>
							</div>
							<div class="mdl-tabs__panel" id="update_location_tab">
								<h4>Enter the location name to update the selected items</h4>
								<div class="mdl-grid" id="location_block" style="background-color: #fff; color: #4e4e4e; padding: 0px 20px 0px 20px; border-radius: 5px; margin: 12px; /*border: 1px solid #999;*/ box-shadow: 0px 0px 5px #999 inset; ">
									<div class="mdl-cell mdl-cell--4-col" style="margin-top: 0px;padding-top: 5px;">
										<h5>Select Outward Order</h5>
									</div>
									<div class="mdl-cell mdl-cell--4-col">
										 <ul id="location_update"></ul>
									</div>
									<div class="mdl-cell mdl-cell--4-col" style="padding-top: 15px;">		
										<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;" id="update_location">Update location <i class="material-icons">done</i></button>
									</div>
								</div>
							</div>

								
						
					</div>
				</div>
			</div>
			<!-- <div class="mdl-cell mdl-cell--4-col">
				<div class="mdl-card mdl-shadow--4dp" id="detail_container" style="display: non;">
					<div class="mdl-card__title">
						<h2 class="mdl-card__title-text">Items selected for dispatch</h2>
					</div>
					<div class="mdl-card__supporting-text">
						<div id="selected_test">
							
						</div>
					</div>
				</div>
			</div> -->
		</div>
	</div>
	
</main>
</div>
</body>

<script type="text/javascript">

	var location_data = [];
	<?php
		for ($i=0; $i < count($location) ; $i++) { 
			echo "location_data.push('".$location[$i]->iexteil_name."');";
		}
	?>
	$('#location_update').tagit({
		autocomplete : { delay: 0, minLenght: 5},
		allowSpaces : true,
		availableTags : location_data,
		tagLimit : 1,
		singleField : true,
		allowDuplicates: true,
	});
	


	$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: true });
	<?php if (!isset($edit_inventory)) {
		echo 'var dt = new Date();';
		echo "var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();";
		echo "$('#i_txn_date').val(s_dt);";
	}?>
	var selected_item = [];

	$(document).ready(function() {
		$('#details').on('click', '.item', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');

			var sel = false;
			var sel_loc = 0;
			for (var i = 0; i < selected_item.length; i++) {
				if (tid == selected_item[i]) {
					sel = true;
					sel_loc = i;
				}
			}

			if (sel == false) {
				$(this).css('background-color','#000');
				$(this).css('color','#ffbb00');
				selected_item.push(tid);	
			} else {
				$(this).css('background-color','#ffbb00');
				$(this).css('color','#000');
				selected_item.splice(sel_loc, 1);
			}
			// displaylist();
		}));

		$('#dispatch').click(function(e) {
			e.preventDefault();
			
			$.post('<?php echo base_url()."Enterprise/inventory_locator_dispatch_update/".$mod_id; ?>', {
				'items' : selected_item,
				'outward' : $('#sec_type').val(),
				'outward_date' : $('#i_txn_date').val()
			}, function(data, status, xhr) {
				$('#details').empty();
				$('#location_update > .tagit-choice').remove();
				selected_item = [];
			}, "text");
		});

		$('#update_location').click(function(e) {
			e.preventDefault();

			var loc = [];
			$('#location_update > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					loc.push(tmpstr);
				}
			});

			$.post('<?php echo base_url()."Enterprise/inventory_locator_location_update/".$mod_id; ?>', {
				'items' : selected_item,
				'location' : loc[0]
			}, function(data, status, xhr) {
				$('#details').empty();
				$('#location_update > .tagit-choice').remove();
				selected_item = [];
			}, "text");
		});

		$('#sec_type').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Enterprise/inventory_locator_getoutward_items"; ?>', {
				'txn_no' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#outward_details').empty();
				var out = "";
				for (var i = 0; i < abc.length; i++) {
					out+="<li>" + abc[i].product + " / Qty: " + abc[i].qty + " / SN: " + abc[i].sn + "</li>"
				}

				$('#outward_details').append(out);

			}, "text");
		})
		$('#search').click(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Enterprise/inventory_locator_search/"; ?>', {
				'search' : $('#name').val(),
				'type_search' : $('#type_search').val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.inventory.length; i++) {
					out = out + '<div class="mdl-cell--2-col people block item" id="' + abc.inventory[i].id + '"';
					var flg = false;
					for (var j = 0; j < selected_item.length; j++) {
						if (selected_item[j] == abc.inventory[i].id) {
							out += 'style="background-color: #000; color: #ffbb00; text-align: left;padding: 20px;"';
							flg = true;
							break;
						}
					}

					if (flg == false) {
						out+= 'style="background-color: #ffbb00; color: #000; text-align: left;padding: 20px;"';
					}

					out+='> <i class="material-icons">receipt</i> <b style="font-size: 1.3em;">' + abc.inventory[i].location + '</b> <h5 style="word-break: break-word;">' + abc.inventory[i].product + '</h5> <hr style="border: 0px solid #000; background-color: #000;"> Txn No:' + abc.inventory[i].txnno + ' <hr style="border: 0px solid #000; background-color: #000;"> <p style="font-size: 1.2em;margin-right: 10px; background-color: #fff; border-radius: 5px;padding: 8px;text-align: center;">Qty: ' + abc.inventory[i].qty + '</p> <p style="font-size: 1.2em;margin-right: 10px;word-break: break-word;">S/n: ' + abc.inventory[i].srno + '</p> </div>'; 
				}
				$('#detail_container').css('display', 'flex');
				$('#details').append(out);
			})
		});
	})
</script>
</html>