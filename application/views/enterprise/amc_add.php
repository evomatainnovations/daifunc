<style>
	.modal-dialog {
		z-index: 10000000 !important;
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
		height: 365px;
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
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell--12-col">
			<div class="mdl-card">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
						<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name; } ?>" placeholder="Enter customer name" style="font-size: 3em;outline: none;">
						<table>
							<tbody class="invoice_table" style="text-align: left;font-size : 1em;">
							</tbody>
						</table>
						<button class="mdl-button mdl-button--accent" id="add_property"><i class="material-icons">add</i> Add Property</button>
					</div>
					<div class="mdl-cell mdl-cell--8-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">
						<div class="mdl-grid">
							<div class="mdl-cell mdl-cell--4-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" id="i_txn_no" name="i_txn_no" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextamc_txn_id; }else{ echo $invoice_doc_id; } ?>">
									<label class="mdl-textfield__label" for="i_txn_no">Enter Transaction Number</label>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextamc_period_from; }else{ echo date('Y-m-d'); } ?>">
									<label class="mdl-textfield__label" for="i_txn_date">Select start Date</label>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" data-type="date" id="amc_end_date" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextamc_period_to; } ?>">
									<label class="mdl-textfield__label" for="amc_end_date">Select end Date</label>
								</div>
							</div>
							<?php 
								if(isset($edit_invoice)) {
									echo '<div class="mdl-cell mdl-cell--4-col">';
									echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="i_txn_status">';
									if ($edit_invoice[0]->iextamc_status == "open") {
										echo '<option value="open" selected>Open</option>';
									} else {
										echo '<option value="open">Open</option>';
									}
									if ($edit_invoice[0]->iextamc_status == "sheduled") {
										echo '<option value="sheduled" selected>Scheduled</option>';
									} else {
										echo '<option value="sheduled">Scheduled</option>';
									}
									if ($edit_invoice[0]->iextamc_status == "active") {
										echo '<option value="active" selected>Active</option>';
									} else {
										echo '<option value="active">Active</option>';
									}
									if ($edit_invoice[0]->iextamc_status == "expired") {
										echo '<option value="expired" selected>Expired</option>';
									} else {
										echo '<option value="expired">Expired</option>';
									}
									if ($edit_invoice[0]->iextamc_status == "terminate") {
										echo '<option value="terminate" selected>Terminate</option>';
									} else {
										echo '<option value="terminate">Terminate</option>';
									}
									if ($edit_invoice[0]->iextamc_status == "cb_client") {
										echo '<option value="cb_client" selected>Confirm by client</option>';
									} else {
										echo '<option value="cb_client">Confirm by client</option>';
									}
									if ($edit_invoice[0]->iextamc_status == "cancel") {
										echo '<option value="cancel" selected>Cancel</option>';
									} else {
										echo '<option value="cancel">Cancel</option>';
									}

									echo '</select> <label class="mdl-textfield__label" for="i_txn_status">Select Status</label></div></div>';
								}
							?>
							<div class="mdl-cell mdl-cell--4-col">
								<?php 
									if(isset($edit_invoice)) {
										echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="amc_duration">';
										if ($edit_invoice[0]->iextamc_sheduled == "monthly") {
											echo '<option value="monthly" selected>Monthly</option>';
										} else {
											echo '<option value="monthly">Monthly</option>';
										}
										if ($edit_invoice[0]->iextamc_sheduled == "by_monthly") {
											echo '<option value="by_monthly" selected>Once in two months</option>';
										} else {
											echo '<option value="by_monthly">Once in two months</option>';
										}
										if ($edit_invoice[0]->iextamc_sheduled == "quarterly") {
											echo '<option value="quarterly" selected>Quarterly</option>';
										} else {
											echo '<option value="quarterly">Quarterly</option>';
										}
										if ($edit_invoice[0]->iextamc_sheduled == "half_year") {
											echo '<option value="half_year" selected>Half Year</option>';
										} else {
											echo '<option value="half_year">Half Year</option>';
										}
										echo '</select> <label class="mdl-textfield__label" for="i_txn_status">Select Duration</label></div>';
									}else{
										echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="amc_duration">';
										echo '<option value="monthly">Monthly</option>';
										echo '<option value="by_monthly">By monthly</option>';
										echo '<option value="quarterly">Quarterly</option>';
										echo '<option value="half_year">Half Year</option>';
										echo '</select> <label class="mdl-textfield__label" for="i_txn_status">Select Duration</label></div>';
									}
								?>
							</div>
							<div class="mdl-cell mdl-cell--4-col">
								<?php 
									if(isset($edit_invoice)) {
										echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="amc_type">';
										if ($edit_invoice[0]->iextamc_amc_type == "com") {
											echo '<option value="com" selected>Comprehensive</option>';
										} else {
											echo '<option value="com">Comprehensive</option>';
										}
										if ($edit_invoice[0]->iextamc_amc_type == "non_com") {
											echo '<option value="non_com" selected>Non Comprehensive</option>';
										} else {
											echo '<option value="non_com">Non Comprehensive</option>';
										}
										echo '</select> <label class="mdl-textfield__label" for="amc_type">Select Amc type</label></div>';
									}else{
										echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="amc_type"><option value="com">Comprehensive</option><option value="non_com">Non Comprehensive</option></select> <label class="mdl-textfield__label" for="amc_type">Select Amc type</label></div>';
									}
								?>
							</div>
							<div class="mdl-cell mdl-cell--4-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" id="txn_amt" name="txn_amt" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextamc_amount; } ?>">
									<label class="mdl-textfield__label" for="txn_amt">Enter Total Amount</label>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--4-col">
								<?php 
									if(isset($taxes)) {
										echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="amc_tax">';
										if (isset($edit_invoice)) {
											if($edit_invoice[0]->iextamc_tax == null || $edit_invoice[0]->iextamc_tax == '0'){
													echo '<option value="0" selected>Select tax</option>';
													for ($i=0; $i < count($taxes) ; $i++) { 
														echo '<option value="'.$taxes[$i]->ittxg_id.'">'.$taxes[$i]->ittxg_group_name.'</option>';
													}
											}else{
												echo '<option value="0" selected>Select tax</option>';
												for ($i=0; $i < count($taxes) ; $i++) {
													if($edit_invoice[0]->iextamc_tax == $taxes[$i]->ittxg_id){
														echo '<option value="'.$taxes[$i]->ittxg_id.'" selected>'.$taxes[$i]->ittxg_group_name.'</option>';
													}else{
														echo '<option value="'.$taxes[$i]->ittxg_id.'">'.$taxes[$i]->ittxg_group_name.'</option>';
													}
												}
											}
										}else{
											echo '<option value="0" selected>Select tax</option>';
											for ($i=0; $i < count($taxes) ; $i++) { 
												echo '<option value="'.$taxes[$i]->ittxg_id.'">'.$taxes[$i]->ittxg_group_name.'</option>';
											}
										}
										echo '</select> <label class="mdl-textfield__label" for="amc_tax">Select Subscription tax</label></div>';
									}else{
										echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="amc_type"><option value="com">Comprehensive</option><option value="non_com">Non Comprehensive</option></select> <label class="mdl-textfield__label" for="amc_type">Select Amc type</label></div>';
									}
								?>
							</div>
							<div class="mdl-cell mdl-cell--4-col upload-btn-wrapper">
								<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
									<i class="material-icons">note</i>  Upload Document
									<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
								</div>
							</div>
						</div>
						<div class="mdl-grid" style="text-align: center; display: inline-flex;">
							<?php
								if(isset($edit_invoice)) {
									echo '<button type="button" class="mdl-button mdl-button--colored" data-toggle="collapse" style="margin-top : 10px" data-target="#demo">OWNERSHIP AND GROUP</button>';
									echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="tx_payment">Add payment</button></a>';
									echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="follow_up">Follow Up</button></a>';
									if ($edit_invoice[0]->iextamc_type != 'email') {
										echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_send_mail"><i class="material-icons">mail</i> Mail</button>';
										echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_download"><i class="material-icons">cloud_download</i> Download</button>';
										echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_print"><i class="material-icons">print</i> Print</button>';	
									}
									echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_delete"><i class="material-icons">delete</i> Delete</button>';
								}else{
									echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_draft">Save as draft</button><br>';
								}
							?>
						</div>
						<div id="demo" class="collapse">
							<div class="mdl-grid" style="text-align: center;">
								<div class="mdl-cell mdl-cell--4-col">
									<div class="mdl-cell mdl-cell--12-col">
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
	</div>
	<div class="mdl-grid">
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar" style="width:100%">
            	<?php
            		if (isset($edit_invoice)) {
            			if ($edit_invoice[0]->iextamc_type == 'formal') {
            				echo '<a href="#p_formal" class="mdl-tabs__tab is-active" id="formal" style="color:black">Formal Subscription</a>';
            			}else{
            				echo '<a href="#p_email" class="mdl-tabs__tab is_active" id="email" style="color:black">Email Subscription</a>';
            			}
            		}else{
            			echo '<a href="#p_formal" class="mdl-tabs__tab is-active" id="formal" style="color:black">Formal Subscription</a><a href="#p_email" class="mdl-tabs__tab " id="email" style="color:black">Email Subscription</a>';
            		}
            	?>
            </div>
            <div class="mdl-cell mdl-cell--12-col" id="invoice_type">
                <div class="mdl-tabs__panel <?php if(isset($edit_invoice)){if($edit_invoice[0]->iextamc_type == 'formal' ){ echo 'is-active'; }}else{echo 'is-active';} ?> " id="p_formal"> 
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
										</div>
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
        						<div contenteditable="true" id="pro_formal_note" style="font-size: 16px;"><?php if (isset($edit_invoice)) { echo $edit_invoice[0]->iextamc_note;}?></div>
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
                	<div class="mdl-grid">
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
                <div class="mdl-tabs__panel <?php if(isset($edit_invoice)){if($edit_invoice[0]->iextamc_type == 'email' ){ echo 'is-active'; }} ?> " id="p_email">
                	<div class="mdl-grid">
                		<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="pro_title">
									<option value='0'>Select title</option>
									<?php for($i=0; $i < count($pro_title); $i++) {
						            	echo '<option value='.$pro_title[$i]->iuetemp_id.'>'.$pro_title[$i]->iuetemp_title.'</option>';
						        	} ?>
						        </select>
						        <label class="mdl-textfield__label" for="pro_title">Select Title</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--8-col">
							<div contenteditable="true" class="email_body"><?php if (isset($edit_invoice)) {echo $edit_invoice[0]->iextamc_note;} ?></div>
						</div>
						<div class="mdl-cell mdl-cell--4-col" style="border: 1px solid #ccc; border-radius: 10px; ">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
										<i class="material-icons">note</i>  Upload Document
										<input type="file" name="file[]" id="multiFiles" class="upload u_multiple" multiple>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
		                		<h3>Tags</h3>
			                		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;">
										<ul id="pro_email_tag">
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
						</div>
                	</div>
					<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="email_submit">
						<i class="material-icons">done</i>
					</button>
                </div>
            </div>
    	</div>	
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<?php
				if (isset($amc_act)) {
					echo '<h3>Activity List  </h3>';
					echo '<table id="act_list" class="general_table"><thead><tr><th></th><th>Title</th><th>Categories</th><th>Start date</th><th>End date</th><th>Status</th></tr></thead><tbody>';
					$sr = 1 ;
					if (count($amc_act)) {
						for ($i=0; $i < count($amc_act) ; $i++) {
							$sdate = date('Y-m-d',strtotime($amc_act[$i]->iua_date));
							$edate = date('Y-m-d',strtotime($amc_act[$i]->iua_end_date));
							echo '<tr><td>'.$sr.'</td><td>'.$amc_act[$i]->iua_title.'</td><td>';
							if ($amc_act[$i]->iua_categorise != '') {
								echo $amc_act[$i]->iua_categorise;
							}else{
								echo 'N/A';
							}
							echo '</td><td>'.$sdate.'</td><td>'.$edate.'</td><td>'.$amc_act[$i]->iua_status.'</td></tr>';
							$sr++;
						}	
					}else{
						echo '<tr><td colspan="6" style="text-align:center;">No records found !</td></tr>';
					}
					echo '</tbody></table>';
					$act_count = intval($d_flg) - intval(count($amc_act));
					echo '<h3>Pending subscription : '.$act_count.'</h3>';
				}
			?>
		</div>
	</div>
</main>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enter Email address for <?php if(isset($edit_amc)) { echo $edit_amc[0]->ic_name;} ?></h4>
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
				<?php echo '<a href="'.base_url().'Enterprise/module_setting/Subscription/'.$code.'"><button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored"> Click to select template</button><a>'; ?>
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
	var type = '';
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
    		if (isset($edit_invoice)) {
    			for ($i=0; $i <count($edit_invoice) ; $i++) { 
    				echo "product_list.push({'id' : ".$i.",'product' : '".$edit_invoice[$i]->ip_product."', 'qty' : '".$edit_invoice[$i]->iextamcpd_qty."','sn' : '".$edit_invoice[$i]->iextamcpd_serial_number."' , 'alias' : '".$edit_invoice[$i]->iextamcpd_alias."' });";
    			}

    			if (count($invoice_property) > 0) {
    				for ($i=0; $i <count($invoice_property) ; $i++) { 
    					echo "property_arr.push({'id' : ".$invoice_property[$i]->iextamcpt_id." ,'value' : '".$invoice_property[$i]->iextamcpt_property_value."','status': '".$invoice_property[$i]->iextamcpt_status."' });";
    				}
    			}
    			for ($i = 0; $i < count($e_details); $i++) {
					echo "exist_email.push({'id' : ".$e_details[$i]->icbd_id.", 'email' : '".$e_details[$i]->icbd_value."' , 'status' : 'false'});";
				}
    		}

    		if (isset($p_terms)) {
    			if (count($p_terms) > 0) {
    				for ($i=0; $i <count($p_terms) ; $i++) {
    					$flg = 'false';
    					for ($ij=0; $ij <count($term_doc) ; $ij++) {
    						if ($p_terms[$i]->iextdt_id == $term_doc[$i]->iextdt_id) {
    							$flg = 'true';
    							break;
    						}else{
    							$flg = 'false';
    						}
    					}
    					if ($flg == 'true') {
    						echo "terms_arr.push({'id' : ".$p_terms[$i]->iextdt_id.", 'terms' : '".$p_terms[$i]->iextdt_term."', 'status' : '".$p_terms[$i]->iextamctm_status."'});";
    					}else{
    						echo "terms_arr.push({'id' : ".$p_terms[$i]->iextdt_id.", 'terms' : '".$p_terms[$i]->iextdt_term."', 'status' : 'false'});";
    					}
    				}
    			}else{
    				for ($i=0; $i <count($term_doc) ; $i++) {
    					echo "terms_arr.push({'id' : ".$term_doc[$i]->iextdt_id.", 'terms' : '".$term_doc[$i]->iextdt_term."', 'status' : 'false'});";
    				}
    			}
    		}

    		if (isset($term_doc) && !isset($p_terms) ) {
    			if (count($term_doc) > 0) {
    				for ($i=0; $i <count($term_doc) ; $i++) {
    					echo "terms_arr.push({'id' : ".$term_doc[$i]->iextdt_id.", 'terms' : '".$term_doc[$i]->iextdt_term."', 'status' : 'false'});";
    				}
    			}
    		}
    	?>
	 $(document).ready( function() {
	 	console.log(terms_arr);
	 	terms_append();
	 	display_details();
	 	var snackbarContainer = document.querySelector('#demo-toast-example');

	 	if (product_list.length > 0) {
	 		display_product_list();
	 	}
	 	$('#pay_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	 	$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	 	$('#amc_end_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

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

    	$('#pro_email_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});
        
    	$("#prod_name" ).autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(product_data_l, request.term);
                response(results.slice(0, 10));
            }
        });

        var pay_edit = 0;
    	$('#tx_payment').click(function (e) {
			e.preventDefault();
			$('#modial_payment').modal('show');
		});

		$('.pay_save').click(function (e) {
			e.preventDefault();
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/pay_save/".$mod_id."/".$code."/".$inid."/";}?>'+pay_edit,{
				'p_mode':$('#pay_mod').val(),
				'p_date':$('#pay_date').val(),
				'p_amt':$('#pay_amt').val(),
				'p_vno':$('#pay_vno').val(),
				'p_desc':$('#pay_desc').val()
			}, function(data, status, xhr) {
				window.location = '<?php if (isset($edit_invoice)) echo base_url()."Enterprise/amc_edit/".$mod_id."/".$code."/".$inid; ?>';
			}, "text");
		});

		$('.pay_delete').click(function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/pay_delete/".$mod_id."/".$code."/";}?>'+id,
			function(data, status, xhr) {
				window.location = '<?php if (isset($edit_invoice)) echo base_url()."Enterprise/amc_edit/".$mod_id."/".$code."/".$inid; ?>';
			}, "text");
		});

		$('.pay_edit').click(function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/pay_edit/".$mod_id."/".$code."/";}?>'+id,
			function(data, status, xhr) {
				var d = JSON.parse(data);
				pay_edit = d.pay_details[0].iextepay_id;
				$('#pay_mod').val(d.pay_details[0].iextepay_mode);
				$('#pay_date').val(d.pay_details[0].iextepay_date);
				$('#pay_amt').val(d.pay_details[0].iextepay_amount);
				$('#pay_vno').val(d.pay_details[0].iextepay_vno);
				$('#pay_desc').val(d.pay_details[0].iextepay_desc);
			}, "text");
		});

    	$('.pro_to_self').click(function (e) {
        	e.preventDefault();
        	$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/amc_transfer/".$code."/".$inid."/0";}?>'
			, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/amc/".$mod_id."/".$code; ?>';
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
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/amc_transfer/".$code."/".$inid."/";}?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Enterprise/amc/".$mod_id."/".$code; ?>';
			}, 'text');
		});

		$('.pro_to_user').click(function (e) {
			e.preventDefault();
			$('#myModal_user').modal('show');
		});

		$('#pro_title').change(function (e) {
     		e.preventDefault();
     		e_title = $('#pro_title').val();
     		$.post('<?php echo base_url()."Enterprise/get_email_body/".$code."/";?>'+e_title
			, function(data, status, xhr) {
				var a = JSON.parse(data);
				$('.email_body').empty();
				$('.email_body').append(a.temp_content);
			}, "text");
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
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/amc_transfer_user/".$inid."/".$code; } ?>', {
				'cust_name' : name[0]
			}, function(data, status, xhr) {
				$('#myModal_user').modal('hide');
				if (data == 'true') {
					window.location = '<?php echo base_url()."Enterprise/amc/".$mod_id."/".$code; ?>';
				}else{
					var data = {message: 'User not register!'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}
			}, 'text');
		});

		// $('#follow_up').click(function (e) {
		// 	e.preventDefault();
		// 	$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/follow_up/".$mod_id."/".$inid."/".$code;}?>',
		// 	function(data, status, xhr) {
  //       		window.location = '<?php echo base_url()."Enterprise/amc/".$mod_id."/".$code; ?>';
  //       	});
		// })

     	$('#pro_title').change(function (e) {
     		e.preventDefault();
     		e_title = $('#pro_title').val();
     		$.post('<?php echo base_url()."Sales/get_email_body/".$code;  ?>'+e_title
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
     		$.post('<?php echo base_url()."Enterprise/save_terms/AMC/".$code; ?>', {
				'name' : $('#t_name').val()
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				terms_arr = [];
				for (var i = 0; i < a.terms.length; i++) {
					terms_arr.push({'id' : a.terms[i].iextdt_id , 'terms' : a.terms[i].iextdt_term, 'status' : 'false' });
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
            		if(!ischecked){
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



    	$('#formal_submit').click(function (e) {
    		e.preventDefault();
    		$('.loader').show();
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
    		$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/update_amc/formal/".$inid."/".$code; }else{ echo base_url()."Enterprise/save_amc/formal/".$code;}?>',{
	    		'customer' : $('#cust_name').val(),
				'txn_no' : $('#i_txn_no').val(),
				'txn_date' : $('#i_txn_date').val(),
				'end_date' : $('#amc_end_date').val(),
				'duration' : $('#amc_duration').val(),
				'product' : product_list,
				'status' : $('#i_txn_status').val(),
				'amc_type' : $('#amc_type').val(),
				'terms' : terms_arr,
				'property' : property_arr,
				'tags' : txn_tags,
				'note' : $('#pro_formal_note').html(),
				'mutual' : mutual,
				'txn_amt' : $('#txn_amt').val(),
				'amc_tax' : $('#amc_tax').val()
			}, function(data, status, xhr) {
				// console.log(data);
				upload_files(data);
			}, "text");
    	});

    	$('#email_submit').click(function (e) {
    		e.preventDefault();
    		var cust_name = $('#cust_name').val();
    		if($('.u_multiple')[0].files[0]) {
				var datat = new FormData();
	            var ins = $('.u_multiple')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.u_multiple')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Enterprise/amc_email_doc_upload/'.$code.'/'; ?>"+ cust_name, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{	
						var a = JSON.parse(data);
						repo = [];
						if (a.files.length > 0) {
							for (var i = 0; i < a.files.length; i++) {
								repo.push({'file_name' : a.files[i].icd_timestamp});
							}
						}
						send_upload_mail();
					}
				});
			}else{
				send_upload_mail();
			}
    	});

    	function send_upload_mail() {
			$('.loader').show();
			var txn_tags = [];
			$('#pro_email_tag > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					txn_tags.push(tmpstr);
				}
			});
			var mutual = [];
			$('#mutual_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					mutual.push(tmpstr1);
				}
			});
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/amc_send_email/".$code."/".$tid; }else{ echo base_url()."Enterprise/amc_send_email/".$code; } ?>', {
				'customer' : $('#cust_name').val(),
				'txn_no' : $('#i_txn_no').val(),
				'txn_date' : $('#i_txn_date').val(),
				'e_date' : $('#amc_end_date').val(),
				'amount' : $('#txn_amt').val(),
				'status' : $('#i_txn_status').val(),
				'amc_type' : $('#amc_type').val(),
				'content' : $('.email_body').html(),
				'files' : repo,
				'tags' : txn_tags,
				'property' : property_arr,
				'mutual' : mutual,
				'duration' : $('#amc_duration').val()
			}, function(data, status, xhr) {
				$('.loader').hide();
				upload_files(data);
			}, 'text');
		}

    	$('#follow_up').click(function (e) {
			e.preventDefault();
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."View/activity_modal/".$code."/subscription/".$inid; } ?>'
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

    	$('#cust_draft').click(function (e) {
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

    		$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/update_amc/draft/".$inid."/".$code; }else{ echo base_url()."Enterprise/save_amc/draft/".$code;}?>',{
    		'customer' : $('#cust_name').val(),
			'txn_no' : $('#i_txn_no').val(),
			'txn_date' : $('#i_txn_date').val(),
			'product' : product_list,
			'status' : $('#i_txn_status').val(),
			'terms' : terms_arr,
			'property' : property_arr,
			'tags' : txn_tags,
			'note' : $('#pro_formal_note').html(),
			'mutual' : mutual,
			'txn_amt' : $('#txn_amt').val()
    		},function(data, status, xhr) {
				upload_files(data);
			}, "text");
    	});

    	$('#cust_print').click(function(e){
	    	e.preventDefault();
	    	$.post('<?php echo base_url()."Enterprise/check_template/".$code."/".$mod_id; ?>',{
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/amc_download/p/".$mod_id."/".$inid."/".$code;} ?>" ;
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
					window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/amc_download/d/".$mod_id."/".$inid."/".$code;} ?>" ;
				}else{
					$('#sel_temp').modal('show');
				}
			}, "text");
	    });

	    var snackbarContainer = document.querySelector('#demo-toast-example');
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
	    	window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/delete_amc/".$inid."/".$code;} ?>" ;
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
			$.post('<?php if (isset($edit_invoice)) echo base_url()."Enterprise/amc_mail/".$mod_id."/".$inid."/".$code; ?>',
				{'cust_mail_id' : exist_email}
				,function(data, status, xhr){
					$('.loader').hide();
					if (data=="true") {
				 		var data = {message: 'Email sent.'};
	    				snackbarContainer.MaterialSnackbar.showSnackbar(data);
				 	}else if(data=="enter"){
				 		var data = {message: 'Please Enter Email Setting Details'};
	    				snackbarContainer.MaterialSnackbar.showSnackbar(data);	
					}else if(data=="false"){
				 		var data = {message: 'Please Select Email address'};
	    				snackbarContainer.MaterialSnackbar.showSnackbar(data);	
					}else{
						var data = {message: 'Please Try Again'};
	    				snackbarContainer.MaterialSnackbar.showSnackbar(data);	
					}
				}, 'text');
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

    	function clearallfields() {
    		if($('#prod_multiple_sn_check')[0].checked == true) {
    			$('#prod_qty').val("");
	    		$('#prod_sn').val("");
	    		$('#prod_sn').focus();
    		}else{
    			$('#prod_qty').val("");
	    		$('#prod_name').val("");
	    		$('#prod_sn').val("");
	    		$('#prod_name').focus();
    		}
    	}

    	$('#prod_sn').keypress(function(e) {
			if (e.keyCode == 13) {
				additemtoarray();	
			}
		});

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
	    			product_list.push({'id' : p,'product' : product, 'qty' : '1', 'sn' : sn , 'alias' : false});
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
	    			product_list.push({'id' : p,'product' : product, 'qty' : qty, 'sn' : sn , 'alias' : false});
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
					url: "<?php echo base_url().'Enterprise/amc_doc_upload/'.$code.'/';?>"+pid+'/'+cust_name, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{	$('.loader').show();
						window.location = '<?php echo base_url()."Enterprise/amc_edit/".$mod_id."/".$code."/"; ?>'+pid;
					}
				});
			}else{
				$('.loader').show();
				window.location = '<?php echo base_url()."Enterprise/amc_edit/".$mod_id."/".$code."/"; ?>'+pid;
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
    })	
</script>
</html>