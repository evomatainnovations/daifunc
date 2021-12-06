<style>
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
	.modal-dialog {
		z-index: 10000000 !important;
	}

	.loader {
		position: fixed;
	    border: 5px solid #f3f3f3;
		-webkit-animation: spin 2s linear infinite; /* Safari */
		animation: spin 1s linear infinite;
		border-top: 5px solid #555;
		border-radius: 50%;
		width: 50px;
		height: 50px;
		left: 47%;
		top: 50%;
		z-index: 1000000 !important;
	}
	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	    0% { transform: rotate(0deg); }
	    100% { transform: rotate(360deg); }
	}

	.general_table {
		width: 100%;
        text-align: left;
        font-size: 1em;
        border: 1px solid #ccc;
        border-collapse: collapse;
        border-radius: 10px;
    }

	@media only screen and (max-width: 760px) {
		.general_table {
			display: block;
        	overflow: auto;
		}
	}

	.general_table > thead > tr {
		/*box-shadow: 0px 5px 5px #ccc;*/
		border: 1px solid #ccc;
	}

	.general_table > thead > tr > th {
		padding: 10px;
		background-color: #666;
		color: #fff;
	}

	.general_table > tbody {
		border: 1px solid #ccc;
	}
	.general_table > tbody > tr {
		/*border-bottom: 1px solid #ccc;*/
	}

	.general_table > tbody > tr > td {
		padding: 15px;
	}

	.general_table > tfoot > tr {
		border: 1px solid #ccc;
	}

	.general_table > tfoot > tr > td {
		padding: 10px;
	}

	.email_body {
		border:1px solid #ccc;
		height: 300px;
		outline: none;
		padding: 10px;
		border-radius: 10px;
		box-shadow: 0px 3px 5px #ccc inset;
		overflow-y: auto;
	}

	#pro_formal_note {
		border:1px solid #ccc;
		height: 50px;
		outline: none;
		padding: 10px;
		border-radius: 10px;
		box-shadow: 0px 3px 5px #ccc inset;
		overflow-y: auto;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell--12-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name; } ?>" placeholder="Enter <?php if($type=="inward") { echo "Vendor"; } else if($type== "outward") { echo "Customer"; } ?> name" style="font-size: 3em;outline: none;">
					<table>
						<tbody class="invoice_table" style="text-align: left;font-size : 1em;">
							<?php
								if (isset($invoice_property)) {
									for ($i = 0; $i < count($invoice_property); $i++) {
										if ($invoice_property[$i]->iexteinvept_status == 'true') {
											echo '<tr><td><input type="checkbox" id="'.$invoice_property[$i]->iexteinvept_id.'" checked></td><td style="padding: 10px;"> '.$invoice_property[$i]->iexteinvept_property_value.'</td></tr>';
										}else{
											echo '<tr><td><input type="checkbox" id="'.$invoice_property[$i]->iexteinvept_id.'"></td><td style="padding: 10px;"> '.$invoice_property[$i]->iexteinvept_property_value.'</td></tr>';
										}
										
									}
								}
							?>
						</tbody>
					</table>
					<button class="mdl-button mdl-button--accent" id="add_property"><i class="material-icons">add</i> Add Property</button>
				</div>
				<div class="mdl-cell mdl-cell--8-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--3-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="i_txn_no" name="i_txn_no" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextei_txn_id; }else{ if($type=="outward"){ echo $invoice_doc_id;}} ?>">
								<label class="mdl-textfield__label" for="i_txn_no">Enter Transaction Number</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextei_txn_date; }else{ echo date('Y-m-d');} ?>">
								<label class="mdl-textfield__label" for="i_txn_date">Select Date</label>
							</div>
						</div>
						<?php 
							if(isset($edit_invoice)) {
								echo '<div class="mdl-cell mdl-cell--3-col">';
								echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="i_txn_status">';
								if ($edit_invoice[0]->iextei_status == "pending") {
									echo '<option value="pending" selected>Pending</option>';
								} else {
									echo '<option value="pending">Pending</option>';
								}
								if ($edit_invoice[0]->iextei_status == "dispatch") {
									echo '<option value="dispatch" selected>Dispatch</option>';
								} else {
									echo '<option value="dispatch">Dispatch</option>';
								}
								if ($edit_invoice[0]->iextei_status == "bill") {
									echo '<option value="bill" selected>Bill</option>';
								} else {
									echo '<option value="bill">Bill</option>';
								}
								if ($edit_invoice[0]->iextei_status == "ready") {
									echo '<option value="ready" selected>Ready</option>';
								} else {
									echo '<option value="ready">Ready</option>';
								}
								echo '</select> <label class="mdl-textfield__label" for="i_txn_status">Select Status</label> </div>';
								echo '</div>';
							}
						?>
						<div class="mdl-cell mdl-cell--3-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="i_wrnty" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextei_warranty; } ?>">
								<label class="mdl-textfield__label" for="i_wrnty">Enter warranty in month</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--3-col upload-btn-wrapper">
							<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
								<i class="material-icons">note</i>Upload Document
								<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
							</div>
						</div>
					</div>
					<div class="mdl-grid" style="text-align: center; display: inline-flex;">
						<?php
							if(isset($edit_invoice)) {
								echo '<button type="button" class="mdl-button mdl-button--colored" data-toggle="collapse" style="margin-top : 10px" data-target="#demo">OWNERSHIP AND GROUP</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="follow_up">Follow Up</button></a>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="add_project"><i class="material-icons">add</i> Add to project</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_send_mail"><i class="material-icons">mail</i> Mail</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_download"><i class="material-icons">cloud_download</i> Download</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_print"><i class="material-icons">print</i> Print</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_delete"><i class="material-icons">delete</i> Delete</button>';
							}
						?>
					</div>
					<div id="demo" class="collapse">
						<div class="mdl-grid" style="text-align: center;">
							<div class="mdl-cell mdl-cell--4-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
									<label>Share with user</label>
									<ul id="mutual_tag">
										<?php 
											if(isset($mutual)) {
												for ($i=0; $i <count($mutual) ; $i++) { 
													echo "<li>".$mutual[$i]->ic_name."</li>";		
												}
											}
										?>
									</ul>
								</div>
							</div>
							<?php
								if(isset($edit_invoice)) {
									echo '<div class="mdl-cell mdl-cell--4-col">';
									if ($invoice_gid == 0) {
										echo '<button class="mdl-button mdl-button--accent grp_switch" style="margin-top : 40px"><i class="material-icons">compare_arrows</i> Transfer to group</button></a>';
									}else{
										echo '<button class="mdl-button mdl-button--accent pro_to_self" style="margin-top : 40px"><i class="material-icons">compare_arrows</i> Transfer to self</button></a>';
									}
									echo '</div><div class="mdl-cell mdl-cell--4-col"><button class="mdl-button mdl-button--accent pro_to_user" style="margin-top : 40px"><i class="material-icons">compare_arrows</i> Transfer to another</button></a></div>';
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar" style="width:100%">
	            <a href="#p_formal" class="mdl-tabs__tab is-active" id="formal" style="color:black">Formal <?php if($type=="inward") { echo "Inward"; } else if($type== "outward") { echo "Outward"; } ?></a>
            </div>
            <div class="mdl-cell mdl-cell--12-col" id="invoice_type">
                <div class="mdl-tabs__panel is-active" id="p_formal"> 
            		<div class="mdl-grid">
            			<div class="mdl-cell mdl-cell--12-col">
            				<h3>Add Items</h3>
            				<div class="mdl-grid">
									<div class="mdl-cel mdl-cell--3-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_name" name="prod_name" class="mdl-textfield__input inv_prod">
											<label class="mdl-textfield__label" for="prod_name">Enter Product Name</label>
										</div>
									</div>
									<div class="mdl-cel mdl-cell--3-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_qty" name="prod_qty" class="mdl-textfield__input inv_prod">
											<label class="mdl-textfield__label" for="prod_qty">Qty</label>
										</div><br>
										<span class="avl_bal" style="font-weight: bold;"></span>
									</div>
									<div class="mdl-cel mdl-cell--3-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_sn" name="prod_sn" class="mdl-textfield__input inv_prod">
											<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="prod_multiple_sn_check"> <span class="mdl-switch__label">Turn on for multiple S/N</span><input type="checkbox" id="prod_multiple_sn_check" class="mdl-switch__input"> </label>
										</div>
									</div>
									<div class="mdl-cell mdl-cell--3-col" style="text-align: center;">
										<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" id="add_prp" ><i class="material-icons">done</i></button>
										<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="reset_prp" ><i class="material-icons">refresh</i></button>
									</div>
								</div>
            			</div>
            		</div>
                	<div class="mdl-grid">
                		<div class="mdl-cell mdl-cell--12-col">
                			<table id="proposal_list" class="general_table">
                				<thead>
                					<tr>
                						<th></th>
                						<th>Alias Name</th>
                						<th>Sr. No</th>
                						<th>Product</th>
                						<th>Qty</th>
                						<th>Serial No.</th>
                					</tr>
                				</thead>
                				<tbody>
                					
                				</tbody>
                				<tfoot>
                					
                				</tfoot>
                			</table>
                		</div>
                	</div>
                	<div class="mdl-grid">
                		<div class="mdl-cell mdl-cell--6-col">
        				<h3>Add Note</h3>
        					<div class="mdl-cell--10-col" style="padding-top: 20px;">
        						<div contenteditable="true" id="pro_formal_note" style="font-size: 16px;"><?php if (isset($edit_invoice)) { echo $edit_invoice[0]->iextei_note;}?></div>
        					</div>
                		</div>
                		<div class="mdl-cell mdl-cell--6-col">
                		<h3>Tags</h3>
	                		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;">
								<ul id="pro_formal_tag">
									<?php
										if(isset($pro_tags)) {
											for ($i=0; $i <count($pro_tags) ; $i++) { 
												echo "<li>".$pro_tags[$i]->it_value."</li>";		
											}
										} 
									?>
								</ul>
							</div>
                		</div>
                	</div>
                	<div class="mdl-grid"">
                		<div class="mdl-cell mdl-cell--12-col">
                			<h3>Add Terms</h3>
                			<table class="general_table" id="terms_list">
                				<thead>
                					<tr>
                						<th>Select</th>
                						<th>Terms</th>
                					</tr>
                				</thead>
                				<tbody>

                				</tbody>
                			</table>
                			<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised" id="add_terms"><i class="material-icons">add</i> Add Terms</button>
                		</div>
                	</div>
                	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="formal_submit">
						<i class="material-icons">done</i>
					</button>
                </div>
            </div>
    	</div>	
	</div>
	<div class="mdl-grid" id="helper_div"></div>
</main>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<div class="modal fade" id="term_Modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title">Add Terms</h2>
				</div>
				<div class="modal-body">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<textarea id="t_name" name="t_name" class="mdl-textfield__input" style="outline: none;"> <?php if (isset($edit_doc)) {echo $edit_doc[0]->iextdt_term; }?> </textarea>
						<label class="mdl-textfield__label" for="t_name">Enter Terms</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="m_add_terms">Add</button>
				</div>
			</div>
		</div>
</div>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enter Email address for <?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name;} ?></h4>
			</div>
			<div class="modal-body">
				<div>
					<table id="exist_email">
					    
					</table>
				</div>
				<div id="enter_email">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 250px">
						<input class="mdl-textfield__input" type="text" id="customer_mail">
						<label class="mdl-textfield__label" for="customer_mail">Email</label>
					</div>	
					<button class="mdl-button mdl-button-done mdl-js-button mdl-button--accent" id="email_button"><i class="material-icons">add</i></button>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" id="send_mail">Send</button>
			</div>
		</div>
	</div>
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
<div class="modal fade" id="myModal_user" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enter User Name for transfer</h4>
			</div>
			<div class="modal-body" style="text-align: center;">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<ul id="user_search">
					</ul>
				</div>
				<div>
					<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="invoice_user_add"><i class="material-icons">compare_arrows</i> Transfer</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="sel_temp" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<h3 class="modal-title">Please select template.</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="text-align: center;">
				<?php echo '<a href="'.base_url().'Enterprise/module_setting/Inventory/'.$code.'"><button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored"> Click to select template</button><a>'; ?>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="project_add" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<h3 class="modal-title">Please select project . </h3>
			</div>
			<div class="modal-body" style="text-align: center;">
				<?php 
					if(isset($project_list)) {
						echo '<div class="mdl-cell mdl-cell--6-col">';
						echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="project_list">';
						echo '<option value="none">Select</option>';
						for ($i=0; $i < count($project_list) ; $i++) { 
							echo '<option value="'.$project_list[$i]->iextpp_id.'">'.$project_list[$i]->iextpp_p_name.'</option>';
						}
						echo '</select> <label class="mdl-textfield__label" for="project_list">Select Project</label> </div>';
						echo '</div>';
					}
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="save_project"><i class="material-icons">save</i> Save</button>
			</div>
		</div>
	</div>
</div>
</body>
<script type="text/javascript">
	var tag_data = [];
	var customer_data = [];
	var product_data_l = [];
	var product_list = [];
	var p = 0;
	var tax_arr = [];
	var amount = 0;
	var edit_flg = 0;
	var edit_id = 0;
	var repo = [];
	var email_array = [];
	var e_title = '';
	var customer = [];
	var user_data = [];
	var terms_arr = [];
	var property_arr =[];
	var exist_email = [];
	var pro_detail = [];
	var type = '<?php if($type=="inward") { echo "inward"; } else if($type== "outward") { echo "outward"; } ?>';
    	<?php
			for ($i=0; $i < count($user_connection); $i++) {
	    		echo "user_data.push({'id' : ".$user_connection[$i]->iug_id.", 'name' : '".$user_connection[$i]->iug_name."'});";
			}
			if (! isset($edit_invoice)) {
				for ($i=0; $i < count($tags) ; $i++) {
	    			echo "tag_data.push('".$tags[$i]->it_value."');";
	    		}
			}

    		for ($i=0; $i < count($customer) ; $i++) { 
    			echo "customer_data.push('".$customer[$i]->ic_name."');";
    		}
    		for ($i=0; $i < count($product) ; $i++) { 
    			echo "product_data_l.push('".$product[$i]->ip_product."');";
    		}

    		if (isset($product_list)) {
				for ($i=0; $i <count($product_list) ; $i++) { 
					for ($j=0; $j < count($product) ; $j++) { 
						if ($product_list[$i]['pid'] == $product[$j]->ip_id) {
							echo "pro_detail.push({'id' : '".$product[$j]->ip_id."' , 'name' : '".$product[$j]->ip_product."', 'bal' : '".$product_list[$i]['bal']."' });";
							break;
						}
					}
				}
			}

    		if (isset($edit_invoice)) {
    			for ($i=0; $i <count($edit_invoice) ; $i++) { 
    				echo "product_list.push({'id' : ".$i.",'product' : '".$edit_invoice[$i]->ip_product."', 'qty' : '".$edit_invoice[$i]->iexteid_balance."','sn' : '".$edit_invoice[$i]->iexteid_serial_number."' , 'alias' : '".$edit_invoice[$i]->iexteid_alias."' });";
    			}

    			if (count($invoice_property) > 0) {
    				for ($i=0; $i <count($invoice_property) ; $i++) { 
    					echo "property_arr.push({'id' : ".$invoice_property[$i]->iexteinvept_id." ,'value' : '".$invoice_property[$i]->iexteinvept_property_value."','status': '".$invoice_property[$i]->iexteinvept_status."' });";
    				}
    			}
    		}

    		if (isset($email_ids)) {
    			for ($i=0; $i <count($email_ids) ; $i++) {
    				echo "exist_email.push({'email' : '".$email_ids[$i]->icbd_value."','status' : 'false'});";
    			}
    		}

    		if (isset($p_terms)) {
    			if (count($p_terms) > 0) {
    				$flg = 'false';
    				for ($i=0; $i <count($p_terms) ; $i++) { 
    					for ($ij=0; $ij <count($term_doc) ; $ij++) {
    						if ($p_terms[$i]->iextdt_id == $term_doc[$ij]->iextdt_id ) {
    							$flg = 'true';
    							break;
    						}else{
    							$flg = 'false';
    						}
    					}
    					if ($flg == 'true') {
    						echo "terms_arr.push({'id' : ".$p_terms[$i]->iextdt_id.", 'terms' : '".$p_terms[$i]->iextdt_term."', 'status' : '".$p_terms[$i]->iexteinvetm_status."'});";
    					}else{
    						echo "terms_arr.push({'id' : ".$p_terms[$i]->iextdt_id.", 'terms' : '".$p_terms[$i]->iextdt_term."', 'status' : 'false'});";
    					}
    				}
    			}else{
    				if (count($term_doc) > 0) {
	    				for ($i=0; $i <count($term_doc) ; $i++) {
	    					echo "terms_arr.push({'id' : ".$term_doc[$i]->iextdt_id.", 'terms' : '".$term_doc[$i]->iextdt_term."', 'status' : 'false'});";
	    				}
	    			}	
    			}
    		}

    		if (isset($term_doc) && !isset($p_terms)) {
    			if (count($term_doc) > 0) {
    				for ($i=0; $i <count($term_doc) ; $i++) {
    					echo "terms_arr.push({'id' : ".$term_doc[$i]->iextdt_id.", 'terms' : '".$term_doc[$i]->iextdt_term."', 'status' : 'false'});";
    				}
    			}
    		}
    	?>
	 $(document).ready( function() {
	 	terms_append();
	 	var snackbarContainer = document.querySelector('#demo-toast-example');

	 	if (product_list.length > 0) {
	 		display_product_list();
	 	}

	 	$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

    	$("#cust_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(customer_data, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_details(value);
            }    
        });

        $('#mutual_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : customer_data,
    		singleField : true
    	});

    	$('#pro_formal_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

    	$("#prod_name").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(product_data_l, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_pro_details(value);
            }
        });

    	$('#add_project').click(function (e) {
    		e.preventDefault();
    		$('#project_add').modal('show');
    	});

   //  	$('#project_add').on('change','#project_list',function (e) {
   //  		e.preventDefault();
   //  		var id = $('#project_list').val();
   //  		$.post('<?php //echo base_url()."Enterprise/project_group_list/".$code."/"; ?>'+id
			// , function(data, status, xhr) {
			// 	var a = JSON.parse(data);
			// 	var out = '';
			// 	if (a.grp_list.length > 0 ) {
			// 		out += '<select class="mdl-textfield__input" id="grp_list">';
			// 		out += '<option value="none">Select</option>';
			// 		for (var i=0; i < a.grp_list.length ; i++) { 
			// 			out += '<option value="'+a.grp_list[i].pgid+'">'+a.grp_list[i].gname+'</option>';
			// 		}
			// 		out += '</select>';
			// 	}else{
			// 		out += '<select class="mdl-textfield__input" id="grp_list">';
			// 		out += '<option value="none">Select</option>';
			// 		out += '</select>';
			// 	}

			// 	$('.pro_grp_list').empty();
			// 	$('.pro_grp_list').append(out);
			// }, "text");
   //  	});

    	$('#save_project').click(function (e) {
    		e.preventDefault();
    		var pid = $('#project_list').val();
    		$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/save_to_project/".$code."/".$tid."/";}?>'+pid
			, function(data, status, xhr) {
				var data = {message: 'Added to project.'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}, "text");
    	});

    	$('.pro_to_self').click(function (e) {
        	e.preventDefault();
        	$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_transfer/".$code."/".$tid."/0";}?>'
			, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory/".$mod_id."/".$code; ?>';
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
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_transfer/".$code."/".$tid."/";}?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory/".$mod_id."/".$code; ?>';
			}, 'text');
		});

		$('.pro_to_user').click(function (e) {
			e.preventDefault();
			$('#myModal_user').modal('show');
		});

		$('#user_search').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : customer_data,
    		tagLimit : 1,
    		singleField : true
    	});

		$('#invoice_user_add').click(function (e) {
			e.preventDefault();
			var name = [];
			$('#user_search > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					name.push(tmpstr);
				}
			});
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_transfer_user/".$code."/".$tid; } ?>', {
				'cust_name' : name[0]
			}, function(data, status, xhr) {
				$('#myModal_user').modal('hide');
				if (data == 'true') {
					window.location = '<?php echo base_url()."Enterprise/inventory/".$mod_id."/".$code; ?>';
				}else{
					var data = {message: 'User not register!'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}
			}, 'text');
		});

		$('#follow_up').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."View/activity_modal/".$code."/Event/"; ?>'
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
		});

		$('.close_modal').click(function (e) {
			e.preventDefault();
			$('#add_activity').hide();
		});

		// var a_flg = 'false';
    
  //       $("#act_mail").change(function(){
  //           if($(this).prop("checked") == true){
  //               a_flg = 'true';
  //           }else{
  //               a_flg = 'false';
  //           }
  //       });

		// $('#submit').click(function(e) {
		// 	e.preventDefault();
		// 	if($('#search_modal').css('display') != 'none'){
  //               var note = $('#notes_text').html();
  //               $('#ATags > li').each(function(index) {
  //                   var tmpstr = $(this).text();
  //                   var len = tmpstr.length - 1;
  //                   if(len > 0) {
  //                       tmpstr = tmpstr.substring(0, len);
  //                       activity_tags.push(tmpstr);
  //                   }
  //               });
  //               var date = $('.s_date').val();
  //               var e_date = $('.e_date').val();
  //               $.post('<?php //echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
  //                   'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
  //               }, function(data, status, xhr) {
  //                       location.reload();
  //               }, 'text');
  //           }else{
  //           	var note = $('#notes_text').html();
	 //            $('#ATags > li').each(function(index) {
	 //                var tmpstr = $(this).text();
	 //                var len = tmpstr.length - 1;
	 //                if(len > 0) {
	 //                    tmpstr = tmpstr.substring(0, len);
	 //                    activity_tags.push(tmpstr);
	 //                }
	 //            });
	 //            var date = $('.s_date').val();
	 //            var e_date = $('.e_date').val();
		// 		$.post('<?php //echo base_url()."Home/activity_update/".$code; ?>', {
		// 			'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
		// 		}, function(data, status, xhr) {
		// 			window.location = '<?php //if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_edit/".$type."/".$code."/".$mod_id."/".$tid;} ?>';
		// 		}, 'text');
  //           }
		// });

     	$('#pro_title').change(function (e) {
     		e.preventDefault();

     		e_title = $('#pro_title').val();
     		$.post('<?php echo base_url()."Sales/get_email_body/".$code."/"; ?>'+e_title
			, function(data, status, xhr) {
					var a = JSON.parse(data);
					$('.email_body').empty();
					$('.email_body').append(a.temp_content);
			}, "text");
     	});

     	$('#add_terms').click(function (e) {
     		e.preventDefault();
     		$('#term_Modal').modal('show');
     	});

     	$('#add_property').click(function (e) {
     		var cust = $("#cust_name").val();
     		if (cust == '') {
     			var data = {message: 'Please enter customer name.'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
     		}else{
     			$.post('<?php echo base_url()."Enterprise/cust_add_property/".$code; ?>', {
					'c_name' : cust
				}, function(data, status, xhr) {
					window.location = '<?php echo base_url()."Enterprise/customer_edit/".$code."/";?>'+data;
				}, 'text');
     		}
     	});

     	$('#m_add_terms').click(function (e) {
     		e.preventDefault();
     		$.post('<?php echo base_url()."Enterprise/save_terms/Inventory/".$code; ?>', {
				'name' : $('#t_name').val()
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				terms_arr = [];
				for (var i = 0; i < a.terms.length; i++) {
					terms_arr.push({'id' : a.terms[i].iextdt_id , 'terms' : a.terms[i].iextdt_term , 'status' : 'false'});
				}
				terms_append();
			}, 'text');
     	});   	

     	$('.invoice_table').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            email_array.push(a);
            for (var i = 0; i < property_arr.length; i++) {
            	if(property_arr[i].id == a){
            		if(!ischecked){
				    	property_arr[i].status = 'false';
				    }else{
				    	property_arr[i].status = 'true';
				    }
            	}
            }
            display_details();
        });

        $('#terms_list').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < terms_arr.length; i++) {
            	if(terms_arr[i].id == a){
            		if(ischecked == 'false'){
				    	terms_arr[i].status = 'false';
				    }else{
				    	terms_arr[i].status = 'true';
				    }
            	}
            }
        });

    	$('#add_prp').click(function(e) {
    		e.preventDefault();
    		additemtoarray();
    		clearallfields();
    	});

    	$('#reset_prp').click(function(e) {
    		e.preventDefault();
    		clearallfields();
    	});

    	$('#proposal_list').on('click','.edit',function(e) {
    		e.preventDefault();
    		var id = $(this).prop('id');
    		for (var i = 0; i < product_list.length; i++) {
    			if (product_list[i].id == id) {
    				clearallfields();
		    	    $('#prod_name').val(product_list[id].product);
		    		$('#prod_qty').val(product_list[id].qty);
		    		$('#prod_sn').val(product_list[id].sn);
		   			break;
    			}
    		}
    		edit_id = id;
    		edit_flg = 1;
    	});

    	$('#proposal_list').on('click','.delete',function(e) {
    		e.preventDefault();
    		var id = $(this).prop('id');
    		product_list.splice(id, 1);
    		display_product_list();
    	});

    	$('#cust_draft').click(function (e) {
    		e.preventDefault();
    		var type = 'draft'
    		$.post('<?php if (isset($edit_invoice)) { echo base_url()."Sales/update_inventory/".$tid."/".$code."/"; } else {echo base_url()."Sales/save_inventory/".$code;} ?>'+draft,{
    		'customer' : $('#cust_name').val(),
			'txn_no' : $('#i_txn_no').val(),
			'txn_date' : $('#i_txn_date').val(),
			'product' : product_list,
			'status' : $('#i_txn_status').val(),
			'terms' : terms_arr,
			'property' : property_arr,
			'tags' : txn_tags,
			'note' : $('#pro_formal_note').html(),
			'mutual' : mutual
		}, function(data, status, xhr) {
				upload_files(data);
			}, "text");
    	});

    	$('#formal_submit').click(function (e) {
    		e.preventDefault();
    		var txn_tags = [];
    		var mutual = [];
			$('#mutual_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					mutual.push(tmpstr1);
				}
			});
			$('#pro_formal_tag > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					txn_tags.push(tmpstr);
				}
			});
    		$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/update_inventory/".$tid."/".$code."/"; }else{ echo base_url()."Enterprise/save_inventory/".$code."/";}?>'+type,{
	    		'customer' : $('#cust_name').val(),
				'txn_no' : $('#i_txn_no').val(),
				'txn_date' : $('#i_txn_date').val(),
				'product' : product_list,
				'status' : $('#i_txn_status').val(),
				'terms' : terms_arr,
				'property' : property_arr,
				'tags' : txn_tags,
				'note' : $('#pro_formal_note').html(),
				'mutual' : mutual ,
				'wrnt' : $('#i_wrnty').val()
			}, function(data, status, xhr) {
				// console.log(data);
				upload_files(data);
			}, "text");
    	});

    	// $('#cust_print').click(function(e){
	    // 	e.preventDefault();
	    // 	window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_download/p/".$code."/".$mod_id."/".$tid."/";} ?>"+type;
	    // });

		// $('#cust_download').click(function(e){
	 //    	e.preventDefault();
	 //    	window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_download/d/".$code."/".$mod_id."/".$tid."/";} ?>"+type;
	 //    });

	 	$('#cust_print').click(function(e){
	    	e.preventDefault();
	    	$.post('<?php echo base_url()."Enterprise/check_template/".$code."/".$mod_id; ?>',{
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_download/p/".$code."/".$mod_id."/".$tid."/".$type;} ?>";
				}else{
					$('#sel_temp').modal('show');
				}
			}, "text");
	    });

	    $('#cust_download').click(function(e){
	    	e.preventDefault();
	    	$.post('<?php echo base_url()."Enterprise/check_template/".$code."/".$mod_id; ?>',{
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/inventory_download/d/".$code."/".$mod_id."/".$tid."/".$type;} ?>";
				}else{
					$('#sel_temp').modal('show');
				}
			}, "text");
	    });
	    
	    $('#cust_send_mail').click(function(e){
	       	e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/check_template/".$code."/".$mod_id; ?>',{
			}, function(data, status, xhr) {
				if (data == 'true') {
			       	email_append();
					$('#myModal').modal('show');
				}else{
					$('#sel_temp').modal('show');
				}
			}, "text");
		});

		$('#cust_delete').click(function(e){
	    	e.preventDefault();
	    	window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/delete_inventory/".$code."/".$tid;} ?>" ;
	    });

	    $('#exist_email').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
    		if(!ischecked){
		    	exist_email[a].status = 'false';
		    }else{
		    	exist_email[a].status = 'true';
		    }
        });

		$('#customer_mail').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                exist_email.push({'email' : $('#customer_mail').val(), 'status' : 'true'});
                $(this).val('');
                $(this).focus();
                email_append();
            }
        });

        $('#email_button').click(function(e) {
            e.preventDefault();
            exist_email.push({'email' : $('#customer_mail').val(), 'status' : 'true'});
            $('#customer_mail').val('');
            $('#customer_mail').focus();
            email_append();
        });

		$('#send_mail').click(function(e){
			e.preventDefault();
			$('.loader').show();
			$.post('<?php if (isset($edit_invoice)) echo base_url()."Enterprise/save_inventory_mail/".$mod_id."/".$tid."/".$code."/"; ?>'+type,
				{'cust_mail_id' : exist_email}
				,function(data, status, xhr){
					$('.loader').hide();
					if (data=="true") {
				 		var data = {message: 'Email sent.'};
	    				snackbarContainer.MaterialSnackbar.showSnackbar(data);
				 	}else if(data=="enter"){
				 		var data = {message: 'Please Enter Email Setting Details'};
	    				snackbarContainer.MaterialSnackbar.showSnackbar(data);	
					}else{
						var data = {message: 'Please Try Again'};
	    				snackbarContainer.MaterialSnackbar.showSnackbar(data);	
					}
				}, 'text');
		});

    	$('#prod_sn').keypress(function(e) {
			if (e.keyCode == 13) {
				additemtoarray();
			}
		});

		$('#proposal_list').on('change', 'input[type=checkbox]', function(e) {
    		e.preventDefault();
    		var id = $(this).prop('id');
    		var ischecked= $(this).is(':checked');
    		if (ischecked == true) {
    			product_list[id].alias = true;
    		}else{
    			product_list[id].alias = false;
    		}
    	});

		function get_pro_details(p_name) {
			$.post('<?php echo base_url()."Enterprise/add_product_inventory/".$code; ?>',{
				'pname' : p_name
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				if (a.product_list.length > 0) {
					var bal = a.product_list[0]['bal'];
				}else{
					var bal = 0;
				}
				$('.avl_bal').empty();
				$('.avl_bal').append('Product balance : '+bal);
				$('#prod_qty').focus();
			}, "text");	
		}

		function clearallfields() {
    		if($('#prod_multiple_sn_check')[0].checked == true) {
	    		$('#prod_sn').val("");
	    		$('#prod_sn').focus();
    		}else{
    			$('#prod_qty').val("");
	    		$('#prod_name').val("");
	    		$('#prod_sn').val("");
	    		$('#prod_name').focus();
    		}
    	}

    	function additemtoarray() {
    		var product = $('#prod_name').val();
    		var qty = $('#prod_qty').val();
    		var sn = $('#prod_sn').val();
    		if($('#prod_multiple_sn_check')[0].checked == true) {
    			if (edit_flg == '1') {
	    			product_list[edit_id]['product'] = product;
	    			product_list[edit_id]['qty'] = qty;
	    			product_list[edit_id]['sn'] = sn;
	    			edit_flg = 0;
	    		}else{
	    			product_list.push({'id' : p,'product' : product, 'qty' : '1', 'sn' : sn ,'alias' : 'false' });
	    			p++;
	    			$('#prod_sn').val('');
	    		}
			} else {
	    		if (edit_flg == '1') {
	    			product_list[edit_id]['product'] = product;
	    			product_list[edit_id]['qty'] = qty;
	    			product_list[edit_id]['sn'] = sn;
	    			edit_flg = 0;
	    		}else{
	    			product_list.push({'id' : p,'product' : product, 'qty' : qty, 'sn' : sn ,'alias' : 'false'});
	    			p++;
	    		}
			}
			clearallfields();
    		display_product_list();
		}

		function display_product_list() {
			var out = '';
			var sr_no = 1;

			for (var i = 0; i < product_list.length; i++) {
				out +='<tr class="no_border"><td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="' + i + '"> <i class="material-icons">delete</i> </button>';
				out +='<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored edit" id="' + i + '"> <i class="material-icons">edit</i> </button></td><td>';
				if (product_list[i].alias == 'true') {
					out += '<input class="mdl-checkbox__input alias_name" type="checkbox" id="'+ i +'" checked>';
				}else{
					out += '<input class="mdl-checkbox__input alias_name" type="checkbox" id="'+ i +'">';
				}
				out += '</td><td>'+sr_no+'</td>';
				out += '<td>'+product_list[i].product+'</td><td>'+product_list[i].qty+'</td><td>'+product_list[i].sn+'</td>';
				out +='</tr>';
				sr_no++;
			}

			$('#proposal_list > tbody').empty();
			$('#proposal_list > tbody').append(out);
		}

		function terms_append(){
			var out ="";
			for (var i = 0; i < terms_arr.length; i++) {
				if (terms_arr[i].status == 'false') {
					out +='<tr><td><input type="checkbox" id="'+ terms_arr[i].id +'"></td><td>'+terms_arr[i].terms+'</td></tr>';
				}else{
					out +='<tr><td><input type="checkbox" id="'+ terms_arr[i].id +'" checked></td><td>'+terms_arr[i].terms+'</td></tr>';
				}
			}
			$('#terms_list > tbody').empty();
			$('#terms_list > tbody').append(out);
		}

    	function get_details(customer) {
			$.post('<?php echo base_url()."Enterprise/cust_details/".$code."/"; ?>',{
				'c' : customer
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				var out = '';
				property_arr = [];
				$('.details').css('display','block');
				for (var i = 0; i < a.details.length; i++) {
					property_arr.push({'id' : a.details[i].icbd_id, 'value' : a.details[i].icbd_value, 'status' : 'false'});
				}
				display_details();
			}, "text");
		}

		function display_details() {
			var out = '';
			for (var i = 0; i < property_arr.length; i++) {
				if (property_arr[i].status == 'true') {
					out +='<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2"><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input" checked></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}else{
					out +='<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2"><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input"></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}
				
			}
			$('.invoice_table').empty();
			$('.invoice_table').append(out);
		}
		function email_append(){
    		var a = '';
    		$('#exist_email').empty();
    		if (exist_email.length > 0) {
    			for (var i = 0; i < exist_email.length; i++) {
    				if (exist_email[i].status = 'true') {
    					a+='<tr><td><input type="checkbox" id="'+i+'" checked></td><td>'+ exist_email[i].email +'</td></tr>';	
    				}else{
    					a+='<tr><td><input type="checkbox" id="'+i+'" ></td><td>'+ exist_email[i].email +'</td></tr>';
    				}
    				
    			}
    			$('#exist_email').append(a);
    		}
    	}

    	function upload_files(pid){
    		var cust_name = $('#cust_name').val();
    		if($('.proposal_doc')[0].files[0]) {
				var datat = new FormData();
	            var ins = $('.proposal_doc')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.proposal_doc')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Enterprise/inventory_doc_upload/'.$code."/";?>"+pid+'/'+cust_name, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						window.location = '<?php echo base_url()."Enterprise/inventory_edit/".$type."/".$code."/".$mod_id."/"; ?>'+pid;
					}
				});
			}else{
				window.location = '<?php echo base_url()."Enterprise/inventory_edit/".$type."/".$code."/".$mod_id."/"; ?>'+pid;
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

		function exec_helper(id) {
			var u = helper_arr[id];
			$.post(u, {

			}, function(d,s,x) {
				var a = JSON.parse(d);
				if (a[0].type == "redirect") {
					window.location = "<?php echo base_url(); ?>" + a[0].value;
				}
			},"text");
		}

		var helper_arr = [];
		<?php
			if (isset($helper)) {
				$output=[];$urlstr='';
				for ($i=0; $i <count($helper) ; $i++) { 
					$urlstr=base_url().$helper[$i]->ih_func_name.'/';
					for ($j=0; $j <count($help_parameter) ; $j++) {
						if ($help_parameter[$j]->ihp_ih_id == $helper[$i]->ih_id) {
							$tmp_str=$help_parameter[$j]->ihp_value.'/';

							eval("\$urlstr .= \"$tmp_str\";");
						}
					}
					array_push($output, array('str' => '<div class="mdl-cell mdl-cell--12-col"><button class="mdl-button mdl-button--colored helper_button" id="'.$i.'">'.$helper[$i]->ih_title.'</button></div>', 'url' => $urlstr ));
				}
				for ($i=0; $i < count($output); $i++) { 
					echo '$("#helper_div").append(\''.$output[$i]['str'].'\');';
					echo 'helper_arr.push("'.$output[$i]['url'].'");';
				}
			}
		?>

		$('#helper_div').on('click', '.helper_button', function(e) {
			e.preventDefault();
			exec_helper($(this).prop('id'));
		})
    })	
</script>
</html>