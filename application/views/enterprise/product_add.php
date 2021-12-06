<style type="text/css">
	.modal-dialog {
		z-index: 10000000 !important;
	}
	.pic_button {
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc;
		margin: 20px;
		position: relative;
		overflow: hidden;
	}
	.pic_button input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<input type="text" id="p_name" name="p_name" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product[0]->ip_product; } ?>" style="font-size: 3em;outline: none;" placeholder="Enter product name">
			<!-- <div id="info_repeat" class="mdl-grid">
				<?php
					if(isset($edit_features)) {
						for ($i=0; $i < count($edit_features) ; $i++) {
							echo '<div class="mdl-cell mdl-cell--2-col"><p style="text-align:left;padding-top:16px;">'.($i + 1).'</p></div><div class="mdl-cell mdl-cell--10-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="p_feature'.$i.'" name="p_feature[]" class="mdl-textfield__input" placeholder="Enter a feature" value="'.$edit_features[$i]->ipf_feature.'"></div></div>';
						}
					}
				?>
			</div> -->
			<div class="mdl-grid" style="text-align: center;">
				<div class="mdl-cell--12-col">
					<button class="mdl-button mdl-js-button mdl-button--colored" id="add_prp"><i class="material-icons">add</i>Add Feature</button>
					<button class="mdl-button mdl-js-button mdl-button--colored" id="add_spcf"><i class="material-icons">add</i>Add Specification</button>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col mdl-shadow--4dp mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="p_alias" name="p_alias" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product_alias; } ?>">
						<label class="mdl-textfield__label" for="p_alias">Enter Alias Name</label>
					</div>	
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="p_cprice" name="p_cprice" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product_cprice; } ?>">
						<label class="mdl-textfield__label" for="p_cprice">Enter Product Cost Price</label>
					</div>	
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="p_sprice" name="p_sprice" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product_sprice; } ?>">
						<label class="mdl-textfield__label" for="p_sprice">Enter Product Sell Price</label>
					</div>	
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="p_tax" class="mdl-textfield__input">
							<option value="-">Select Tax</option>
							<?php
								for ($i=0; $i < count($tax_group) ; $i++) { 
									echo "<option value='".$tax_group[$i]->ittxg_id."'";
									if(isset($edit_product_tax)) {
										if (count($edit_product_tax) > 0) {
											if ($edit_product_tax[0]->ipt_t_id == $tax_group[$i]->ittxg_id) {
												echo " selected";
											}
										}
									}
									echo ">".$tax_group[$i]->ittxg_group_name."</option>";
								}
							?>
						</select>
						<label class="mdl-textfield__label" for="p_tax">Select Tax</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding-top: 55px;">
						<input type="text" id="p_limit" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product[0]->ip_limit; } ?>">
						<label class="mdl-textfield__label" for="p_limit" style="padding-top: 40px;">Product limit</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding-top: 55px;">
						<input type="text" id="p_barcode" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product[0]->ip_limit; } ?>">
						<label class="mdl-textfield__label" for="p_barcode" style="padding-top: 40px;">Product Barcode</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding-top: 55px;">
						<input type="text" id="p_d_qty" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product[0]->ip_limit; } ?>">
						<label class="mdl-textfield__label" for="p_d_qty" style="padding-top: 40px;">Product Default Qty</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;text-align: center;">
						<label>Enter Category</label>
						<ul id="cat_tag_p">
							<?php 
								if (isset($edit_product)) {
									if ($edit_product[0]->ip_cat_id != 0) {
										echo "<li>".$edit_product[0]->iproc_name."</li>";
									}
								}
							?>
						</ul>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col" style="padding: 50px;">
					<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="product_publish"><input type="checkbox" id="product_publish" class="mdl-switch__input" <?php if (isset($edit_product)) { if ($edit_product[0]->ip_publish == 'true') { echo "checked";}else{}} ?>><span class="mdl-switch__label">Publish product</span></label>
				</div>
				<div class="mdl-cell mdl-cell--4-col" style="padding-top: 25px;text-align: center;">
					<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
						<i class="material-icons">note</i>  Upload Document
						<input type="file" name="file[]" id="multiFiles" class="upload u_multiple" multiple>
					</div>
					<div id="uploaded_files">
						<?php
							if (isset($products) && count($products) > 0) {
								for ($i=0; $i <count($products) ; $i++) { 
									echo '<span class="mdl-chip pro_file" style="margin-right: 10px;margin-bottom: 10px;margin-top: 10px;" id="'.$products[$i]->ipp_timestamp.'"><span class="mdl-chip__text">'.$products[$i]->ipp_file.'</span></span>';
								}
							}
						?>
					</div>
				</div>
			</div>
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col">
					<button type="button" class="mdl-button mdl-button--colored" data-toggle="collapse" data-target="#demo">Product Additional Details</button>
				</div>
				<div class="mdl-cell mdl-cell--2-col">
					<button type="button" class="mdl-button mdl-button--colored" data-toggle="collapse" data-target="#demo1">Tags</button>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<?php if(isset($edit_product)) {
							if ($p_gid == 0) {
								echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent grp_switch"><i class="material-icons">compare_arrows</i> Transfer to group</button>';
							}else{
								echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent pro_to_self"><i class="material-icons">compare_arrows</i> Transfer to self</button>';
							}
					}?>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<?php if(isset($edit_product)) {
						echo "<a href='".base_url().'Enterprise/delete_product/'.$code.'/'.$pid."'";
						echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--accent"><i class="material-icons">delete</i> Delete Product</button>';
						echo "</a>";
					}?>
				</div>
				<div class="mdl-cell mdl-cell--12-col collapse" id="demo">
					<div class="mdl-grid" style="display: inline-flex;">
						<div class="mdl-cell mdl-cell--4-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding-top: 45px;">
								<input type="text" id="p_hsn" name="p_hsn" class="mdl-textfield__input" value="<?php if(isset($edit_description)) { if(count($edit_description) > 0) { echo $edit_description[0]->ipai_hsn_code; } } ?>">
								<label class="mdl-textfield__label" for="p_hsn">HSN/SAC Code</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--4-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<textarea id="p_desc" name="p_desc" class="mdl-textfield__input"><?php if(isset($edit_description)) { if(count($edit_description) > 0) { echo $edit_description[0]->ipai_description; } }?></textarea>
								<label class="mdl-textfield__label" for="p_desc">Description</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--4-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding-top: 0px;">
								<label>Add Units</label>
						        <ul id="p_unit" class="mdl-textfield__input">
		    						<?php if (isset($edit_description)) {
		    								for ($j=0; $j < count($edit_description) ; $j++) { 
		    									$x = $edit_description[$j]->ipai_unit;
		    								
		    									$y = 0;
		    									for ($ij=0; $ij < count($units) ; $ij++) { 
		    										$m = $units[$ij]->ipu_id;
		    										if($x==$m) {
		    											$y=$ij;
		    										}
		    									}
		    									echo "<li>".$units[$y]->ipu_unit_name."</li>";
		    								}
		    							}
		    						?>
		    					</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col collapse" id="demo1" style="width: 100%;">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label>Add Tags</label>
						<ul id="myTags" class="mdl-textfield__input">
							<?php if (isset($edit_preferences)) {
									for ($j=0; $j < count($edit_preferences) ; $j++) {
										echo "<li>".$tags[$j]->it_value."</li>";
									}
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;overflow: auto;height: 50vh;">
			<h4>Add child product</h4>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
				<input type="text" id="p_search" name="p_search" class="mdl-textfield__input" placeholder="Search product">
			</div>
			<table class="mdl-data-table mdl-js-data-table repo_table" style="width: 100%;">
				<tbody id="product_table"></tbody>
        	</table>
		</div>
		<div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;overflow: auto;height: 50vh;">
			<table class="mdl-data-table mdl-js-data-table" id="product_added_table" style="width: 100%;text-align: center;"></table>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="p_submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
<div class="modal fade" id="myModal_group" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Select Group for transfer</h4>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield">
				    <input class="mdl-textfield__input" type="text" id="group_search">
				    <label class="mdl-textfield__label" for="group_search">Group Name</label>
				</div>
				<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="account_search"><i class="material-icons">search</i> Search</button>
				<div id="grp_body">
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add_feature" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add feature</h4>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield">
				    <input class="mdl-textfield__input" type="text" id="feature_name">
				    <label class="mdl-textfield__label" for="feature_name">Enter a feature</label>
				</div>
				<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="add_fe"><i class="material-icons">add</i> Add</button>
				<div id="info_repeat"></div>
			</div>
			<div class="modal-footer">
				<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="fe_save"><i class="material-icons">save</i> Save</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="add_spc_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Specification</h4>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield">
				    <input class="mdl-textfield__input" type="text" id="spc_cat">
				    <label class="mdl-textfield__label" for="spc_cat">Enter a Specification name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield">
				    <input class="mdl-textfield__input" type="text" id="spc_name">
				    <label class="mdl-textfield__label" for="spc_name">Enter a Specification value</label>
				</div>
				<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="add_spc"><i class="material-icons">add</i> Add</button>
				<div id="info_repeat_spc"></div>
			</div>
			<div class="modal-footer">
				<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="spc_save"><i class="material-icons">save</i> Save</button>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	var tag_data = [];
	var user_data = [];
	var cat_arr = [];
	var pro_arr = [];
	var added_pro = [];
	var pfeature = [];
	var pspec = [];

    $(document).ready( function() {
    	<?php
    		for ($i=0; $i < count($tags) ; $i++) { 
    			echo "tag_data.push('".$tags[$i]->it_value."');";
    		}

    		for ($i=0; $i < count($user_connection); $i++) {
	    		echo "user_data.push({'id' : ".$user_connection[$i]->iug_id.", 'name' : '".$user_connection[$i]->iug_name."'});";
			}
			if (isset($p_cat)) {
				for ($i=0; $i <count($p_cat) ; $i++) { 
					echo "cat_arr.push('".$p_cat[$i]->iproc_name."');";
				}
			}
			$flg = '';
			if (isset($edit_pro_list)) {
				for ($i=0; $i < count($edit_pro_list) ; $i++) {
					for ($j=0; $j < count($child_pro_list) ; $j++) {
						$flg = 'false';
						if ($edit_pro_list[$i]->ip_id == $child_pro_list[$j]->ipcp_c_pid) {
							$flg = 'true';
							echo "added_pro.push({'id' : '".$edit_pro_list[$i]->ip_id."', 'name' : '".$edit_pro_list[$i]->ip_product."', 'qty' : '".$child_pro_list[$j]->ipcp_qty."' });";
							break;
						}
					}
					if ($flg == '') {
						$flg = 'false';
					}
					echo "pro_arr.push({'id' : '".$edit_pro_list[$i]->ip_id."', 'name' : '".$edit_pro_list[$i]->ip_product."' ,'status' : '".$flg."'});";
				}
			}

			if (isset($pro_list)) {
				for ($i=0; $i < count($pro_list) ; $i++) { 
					echo "pro_arr.push({'id' : '".$pro_list[$i]->ip_id."', 'name' : '".$pro_list[$i]->ip_product."' ,'status' : 'false'});";
				}
			}

			if (isset($edit_sp)) {
				for ($i=0; $i < count($edit_sp) ; $i++) { 
					echo "pspec.push({'name' : '".$edit_sp[$i]->ips_val."' , 'cat' : '".$edit_sp[$i]->ips_cat."'});";
				}
			}
			if (isset($edit_features)) {
				for ($i=0; $i < count($edit_features) ; $i++) { 
					echo "pfeature.push('".$edit_features[$i]->ipf_feature."');";
				}
			}
    	?>
    	display_product();
    	display_pro_added();
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

    	$('#cat_tag_p').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : cat_arr,
    		tagLimit : 1,
    		singleField : true
    	});
    	
    	var unit_data = [];
    	
    	<?php
    		for ($i=0; $i < count($units) ; $i++) { 
    			echo "unit_data.push('".$units[$i]->ipu_unit_name."');";
    		}
    	?>
    	
    	$('#p_unit').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : unit_data,
    		tagLimit : 1,
    		singleField : true,
    	});
    	
		$('#p_name').focus();

		var prp_count = 0;
		$('#add_prp').click(function(e) {
			e.preventDefault();
			add_to_feature();
			$('#add_feature').modal('show');
		});

		$('#add_feature').on('keyup','#feature_name',function(e) {
			e.preventDefault();
			if (e.keyCode == 13) {
				pfeature.push($('#feature_name').val());
				add_to_feature();
			}
		});

		$('#add_feature').on('click','#add_fe',function(e) {
			e.preventDefault();
			pfeature.push($('#feature_name').val());
			add_to_feature();
		});

		function add_to_feature(){
			$('#feature_name').val('');
			$('#feature_name').focus();
			var out = '';
			var sr_no = 0;
			for (var i = 0; i < pfeature.length; i++) {
				sr_no++;
				out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--2-col"><p style="text-align:left;">' + sr_no + '.</p></div><div class="mdl-cell mdl-cell--10-col"><p style="text-align:left;">' + pfeature[i] + '</p></div></div>';
			}
			$('#info_repeat').empty();
			$('#info_repeat').append(out);
		}

		$('#add_spcf').click(function(e) {
			e.preventDefault();
			add_to_spc();
			$('#add_spc_modal').modal('show');
		});

		$('#add_spc_modal').on('keyup','#spc_name',function(e) {
			e.preventDefault();
			if (e.keyCode == 13) {
				pspec.push({'name' : $('#spc_name').val() , 'cat' : $('#spc_cat').val()});
				add_to_spc();
			}
		});

		$('#add_spc_modal').on('click','#add_spc',function(e) {
			e.preventDefault();
			pspec.push({'name' : $('#spc_name').val() , 'cat' : $('#spc_cat').val()});
			add_to_spc();
		});

		function add_to_spc(){
			$('#spc_cat').val('');
			$('#spc_name').val('');
			$('#spc_cat').focus();
			var out = '';
			var sr_no = 0;
			for (var i = 0; i < pspec.length; i++) {
				sr_no++;
				out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--2-col"><p style="text-align:left;">' + sr_no + '.</p></div><div class="mdl-cell mdl-cell--5-col"><p style="text-align:left;">' + pspec[i].cat + '</p></div><div class="mdl-cell mdl-cell--5-col"><p style="text-align:left;">' + pspec[i].name + '</p></div></div>';
			}
			$('#info_repeat_spc').empty();
			$('#info_repeat_spc').append(out);
		}

		$('.pro_file').click(function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = "<?php echo base_url()."Account/doc_download/".$code."/"; ?>"+ id ;
		});

		$('.pro_to_self').click(function (e) {
        	e.preventDefault();
        	$.post('<?php if (isset($edit_product)) { echo base_url()."Enterprise/product_transfer/".$code."/".$pid."/0";}?>'
			, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/products/".$mid."/".$code; ?>';
			}, "text");
        });

        $('.grp_switch').click(function (e) {
			e.preventDefault();
			switch_account();
			$('#myModal_group').modal('show');
		});

		$('#myModal_group').on('click','#account_search',function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Home/account_search/".$code; ?>', {
        		's_account' : $('#group_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		user_data = [];
        		for (var i=0; i < d.account.length; i++) {
            		user_data.push({'id' : d.account[i].iug_id, 'name' : d.account[i].iug_name});
        		}
        		switch_account();
        	});
		});

		$('#grp_body').on('click','.transfer_to_group',function (e) {
			e.preventDefault();
			var gid = $(this).prop('id');
			$.post('<?php if (isset($edit_product)) { echo base_url()."Enterprise/product_transfer/".$code."/".$pid."/";}?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Enterprise/products/".$mid."/".$code; ?>';
			}, 'text');
		});

		$('#product_table').on('click','.add_product',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < pro_arr.length; i++) {
				if(pro_arr[i].id == id){
					added_pro.push({'id' : pro_arr[i].id , 'name' : pro_arr[i].name });
					pro_arr[i].status = 'true';
					break;
				}
			}
			display_product();
			display_pro_added();
		});

		$('#product_added_table').on('click','.remove_prod',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < added_pro.length; i++) {
				if(added_pro[i].id == id){
					added_pro.splice(i, 1);
					for (var i = 0; i < pro_arr.length; i++) {
						if(pro_arr[i].id == id){
							pro_arr[i].status = 'false';
							break;
						}
					}
					break;
				}
			}
			display_product();
			display_pro_added();
		});

		$('#p_search').keyup(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/product_search/".$code; ?>', {
        		'search' : $('#p_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		pro_arr = [];
        		for (var i = 0; i < d.product.length; i++) {
        			for (var j = 0; j < added_pro.length; j++) {
        				var flg = 'false';
        				if(added_pro[j].id == d.product[i].ip_id ){
        					flg = 'true';
        					break;
        				}
        			}
        			pro_arr.push({'id' : d.product[i].ip_id , 'name' : d.product[i].ip_product , 'status' : flg});
        		}
				display_product();
        	});
		});

		$('#spc_save').click(function(e) {
			e.preventDefault();
			save_product_details();
		});

		$('#fe_save').click(function(e) {
			e.preventDefault();
			save_product_details();
		});

		function save_product_details(){
			$.post('<?php echo base_url()."Enterprise/save_product_details/".$code."/"; ?>', {
        		'sp_arr' : pspec,
        		'fe_arr' : pfeature
        	}, function(data, status, xhr) {
        		window.location = "<?php echo base_url().'Enterprise/product_edit/'.$code."/"; ?>";
        	});
		}

		$('#p_submit').click(function(e) {
			e.preventDefault();

			for (var i = 0; i < added_pro.length; i++) {
				var qty = $('#p_q'+added_pro[i].id).val();
				added_pro[i].qty = qty;
			}

			var product_name = $('#p_name').val();
			var product_tags = [];

			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					product_tags.push(tmpstr);
				}
			});

			var product_units = [];

			$('#p_unit > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					product_units.push(tmpstr);
				}
			});

			var product_alias = $('#p_alias').val();
			var product_cprice = $('#p_cprice').val();
			var product_sprice = $('#p_sprice').val();
			
			var product_hsn = $('#p_hsn').val();
			var product_desc = $('#p_desc').val();
			
			var cat = [];
			$('#cat_tag_p > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					cat.push(tmpstr1);
				}
			});

			if ($("#product_publish").prop("checked") == true) {
				var p_publish = 'true';
			}else{
				var p_publish = 'false';
			}

			$.post('<?php if (isset($edit_product)) { echo base_url()."Enterprise/update_product/".$pid."/".$code; } else { echo base_url()."Enterprise/save_product/".$code; } ?>', {
				'pcat' : cat,
				'name' : product_name,
				'alias' : product_alias,
				'cprice' : product_cprice,
				'sprice' : product_sprice,
				'tax' : $('#p_tax').val(),
				'hsn_sac' : product_hsn,
				'desc' : product_desc,
				'units' : product_units,
				'feature' : pfeature,
				'p_spsf' : pspec,
				'tags' : product_tags,
				'pro_list' : added_pro,
				'p_limit' : $('#p_limit').val(),
				'p_d_qty' : $('#p_d_qty').val(),
				'p_barcode' : $('#p_barcode').val(),
				'p_publish' : p_publish
			}, function(data, status, xhr) {
					file_upload(data);
			}, 'text');
		});

		function file_upload(id){
			if($('.u_multiple')[0].files[0]) {
				var datat = new FormData();
	            var ins = $('.u_multiple')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.u_multiple')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Enterprise/product_doc_upload/'.$code.'/'; ?>" + id, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						window.location = "<?php echo base_url().'Enterprise/product_details/'.$code."/"; ?>" + id;
					}
				});
			} else {
				window.location = "<?php echo base_url().'Enterprise/product_details/'.$code."/"; ?>" + id;
			}
		}

		function switch_account(){
			var out = '';
			if (user_data.length > 0) {
				for (var i=0; i < user_data.length; i++) {
	        		if (gid == user_data[i].id) {
	        			out+= '<button class="mdl-button mdl-button--raised mdl-button--colored transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
	        		}else{
	        			out+= '<button class="mdl-button transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
	        		}
	    		}
			}else{
				out +='<h3>No records found !!</h3>'
			}
			$('#grp_body').empty();
	    	$('#grp_body').append(out); 
		}

		function display_product(){
			var out = '';
			if (pro_arr.length > 0) {
				for (var i = 0; i < pro_arr.length; i++) {
					if (pro_arr[i].status == 'false') {
						out +='<tr class="tbl_view"><td class="mdl-data-table__cell--non-numeric">'+pro_arr[i].name+'</td><td><button class="mdl-button mdl-button--colored add_product" id="'+pro_arr[i].id+'"><i class="material-icons">add</i> add</button></td></tr>';
					}
				}
			}else{
				out +='<tr><td style="text-align:left;">No records !</td></tr>';
			}
			$('#product_table').empty();
			$('#product_table').append(out);
		}

		function display_pro_added(){
			var out = '';
			if (added_pro.length > 0) {
				out += '<thead><th style="text-align:left;">Product Name</th><th style="text-align:center;">Product qty</th><th style="text-align:right;">Action</th></thead>';
				out += '<tbody>';
				for (var i = 0; i < added_pro.length; i++) {
					out += '<tr>';
					out += '<td style="text-align:left;">'+added_pro[i].name+'</td>';
					if (added_pro[i].qty == undefined ) {
						out += '<td style="text-align:center;"><input type="text" id="p_q'+added_pro[i].id+'" class="mdl-textfield__input prod_qty" style="outline:none;" placeholder="Enter product qty" ></td>';
					}else{
						out += '<td style="text-align:center;"><input type="text" id="p_q'+added_pro[i].id+'" class="mdl-textfield__input prod_qty" value="'+added_pro[i].qty+'" style="outline:none;" placeholder="Enter product qty" ></td>';
					}
					out += '<td style="text-align:right;"><button id="'+added_pro[i].id+'" class="mdl-button mdl-button--colored remove_prod"><i class="material-icons">close</i> remove</button></td>';
					out += '</tr>';
				}
				out += '</tbody>';
			}else{
				out +='<h3 style="text-align:center;">No child product added !</h3>';
			}
			$('#product_added_table').empty();
			$('#product_added_table').append(out);
		}
	});
</script>
</html>
