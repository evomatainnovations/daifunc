<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
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
	ui-widget{
		width: 400px !important;
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

	#pro_note {
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
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" <?php if(isset($edit_cust)) { echo 'value='.$edit_cust[0]->ic_name; } ?> style="font-size: 3em;outline: none;">
					<table>
						<tbody class="proposal_table" style="text-align: left;font-size : 1em;">
							<?php
								if (isset($proposal_property)) {
									for ($i = 0; $i < count($proposal_property); $i++) {
										if ($proposal_property[$i]->iexteppt_status == 'true') {
											echo '<tr><td><input type="checkbox" id="'.$proposal_property[$i]->iexteppt_id.'" checked></td><td style="padding: 10px;"> '.$proposal_property[$i]->iexteppt_property_value.'</td></tr>';
										}else{
											echo '<tr><td><input type="checkbox" id="'.$proposal_property[$i]->iexteppt_id.'"></td><td style="padding: 10px;"> '.$proposal_property[$i]->iexteppt_property_value.'</td></tr>';
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
								<input type="text" id="i_txn_no" name="i_txn_no" class="mdl-textfield__input" value="<?php if(isset($edit_proposal)) { echo $edit_proposal[0]->iextepro_txn_id; }else{ echo $invoice_doc_id; } ?>">
								<label class="mdl-textfield__label" for="i_txn_no">Enter Transaction Number</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_proposal)) { echo $edit_proposal[0]->iextepro_txn_date; }else{ echo date('Y-m-d'); } ?>">
								<label class="mdl-textfield__label" for="i_txn_date">Select Date</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<?php 
								if(isset($edit_proposal)) {
									echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="i_txn_status">';
									if ($edit_proposal[0]->iextepro_status == "open") {
										echo '<option value="open" selected>Open</option>';
									} else {
										echo '<option value="open">Open</option>';
									}

									if ($edit_proposal[0]->iextepro_status == "discuss") {
										echo '<option value="discuss" selected>Discussion</option>';
									} else {
										echo '<option value="discuss">Discussion</option>';
									}

									if ($edit_proposal[0]->iextepro_status == "consider") {
										echo '<option value="consider" selected>May Consider</option>';
									} else {
										echo '<option value="consider">May Consider</option>';
									}

									if ($edit_proposal[0]->iextepro_status == "negotiate") {
										echo '<option value="negotiate" selected>Negotiation</option>';
									} else {
										echo '<option value="negotiate">Negotiation</option>';
									}

									if ($edit_proposal[0]->iextepro_status == "cancel") {
										echo '<option value="cancel" selected>Cancelled</option>';
									} else {
										echo '<option value="cancel">Cancelled</option>';
									}

									echo '</select> <label class="mdl-textfield__label" for="i_txn_status">Select Status</label> </div>';
								}
							?>
						</div>
						<div class="mdl-cell mdl-cell--3-col upload-btn-wrapper">
							<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
								<i class="material-icons">folder</i> Upload Document
								<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
							</div>
						</div>
					</div>
					<div class="mdl-grid" style="text-align: right; display: inline-flex;">
						<?php
							if(isset($edit_proposal)) {
								echo '<button type="button" class="mdl-button mdl-button--colored" data-toggle="collapse" style="margin-top : 10px" data-target="#demo">OWNERSHIP AND GROUP</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="follow_up">Follow Up</button></a>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_draft">Save as draft</button><br>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_send_mail"><i class="material-icons">mail</i> Mail</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_download"><i class="material-icons">cloud_download</i> Download</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_print"><i class="material-icons">print</i> Print</button>';
								echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_delete"><i class="material-icons">delete</i> Delete</button>';
							}else{
								echo '<button class="mdl-button mdl-button--accent" style="width: 100%;margin-top : 10px" id="cust_draft">Save as draft</button>';
							}
						?>
					</div>
					<div id="demo" class="collapse">
						<div class="mdl-grid" style="text-align: center;">
							<div class="mdl-cell mdl-cell--4-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
									<label>Share with users</label>
									<ul id="mutual_tag">
										<?php 
											if(isset($mutual)) {
												for ($i=0; $i <count($mutual) ; $i++) { 
													echo "<li>".$mutual[$i]->ic_name."</li>";		
												}
											}else if(isset($cust_name)){
												echo "<li>".$cust_name[0]->ic_name."</li>";
											}
										?>
									</ul>
								</div>
							</div>
							<?php
								if(isset($edit_proposal)) {
									echo '<div class="mdl-cell mdl-cell--4-col">';
									if ($pro_gid == 0) {
										echo '<button class="mdl-button mdl-button--accent grp_switch" style="margin-top : 40px"><i class="material-icons">compare_arrows</i> Transfer to group</button></a>';
									}else{
										echo '<button class="mdl-button mdl-button--accent pro_to_self" style="margin-top : 40px"><i class="material-icons">compare_arrows</i> Transfer to self</button></a>';
									}
									echo '</div><div class="mdl-cell mdl-cell--4-col"><button class="mdl-button mdl-button--accent pro_to_user" style="margin-top : 40px"><i class="material-icons">compare_arrows</i> Transfer to another user</button></a></div>';
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
	            <a href="#p_formal" class="mdl-tabs__tab is-active" id="formal" style="color:black">Formal Proposal</a>
	            <a href="#p_email" class="mdl-tabs__tab" id="email" style="color:black">Email Proposal</a>
	            <a href="#p_verbal" class="mdl-tabs__tab" id="verbal" style="color:black">Verbal Proposal</a>
            </div>
	        <div class="mdl-cell mdl-cell--12-col" id="proposal_type">
	            <div class="mdl-tabs__panel is-active" id="p_formal"> 
	        		<div class="mdl-grid">
	        			<div class="mdl-cell mdl-cell--12-col">
	        				<h3>Add Items</h3>
	        				<div class="mdl-grid">
									<div class="mdl-cel mdl-cell--2-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_name" name="prod_name" class="mdl-textfield__input inv_prod">
											<label class="mdl-textfield__label" for="prod_name">Enter Product Name</label>
										</div>
									</div>
									<div class="mdl-cel mdl-cell--2-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_rate" name="prod_rate" class="mdl-textfield__input inv_prod">
											<label class="mdl-textfield__label" for="prod_rate">Rate</label>
										</div>
									</div>
									<div class="mdl-cel mdl-cell--2-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_qty" name="prod_qty" class="mdl-textfield__input inv_prod">
											<label class="mdl-textfield__label" for="prod_qty">Qty</label>
										</div>
									</div>
									<div class="mdl-cel mdl-cell--2-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_disc" name="prod_disc" class="mdl-textfield__input inv_prod">
											<label class="mdl-textfield__label" for="prod_disc">Discount %</label>
										</div>
									</div>
									<div class="mdl-cel mdl-cell--2-col" style="margin-top:0%;margin-left:0%;">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<select class="mdl-textfield__input" id="prod_tax">
												<!-- <label class="mdl-textfield__label" for="prod_tax">Select Tax</label> -->
												<option value='null'>Select Tax</option>
												<?php for($i=0; $i < count($tax); $i++) {
									            	echo '<option value="'.$tax[$i]->ittxg_id.'">'.$tax[$i]->ittxg_group_name.'</option>';
									        	} ?>
											</select>
											<label class="mdl-textfield__label" for="prod_tax">Select Tax</label>
										</div>
									</div>
									<div class="mdl-cell mdl-cell--2-col" style="text-align: center;">
										<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" id="add_prp" ><i class="material-icons">done</i></button>
										<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="reset_prp" ><i class="material-icons">refresh</i></button>
									</div>
								</div>
	        			</div>
	        		</div>
	            	<!-- </div> -->
	            	<div class="mdl-grid">
	            		<div class="mdl-cell mdl-cell--12-col">
	            			<table id="proposal_list" class="general_table">
	            				<thead>
	            					<tr>
	            						<th></th>
	            						<th>Alias Name</th>
	            						<th>Sr. No</th>
	            						<th>Product</th>
	            						<th>Rate</th>
	            						<th>Qty</th>
	            						<th>Discount %</th>
	            						<th>Tax</th>
	            						<th>Total</th>
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
	    						<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" id="pro_formal_note" name="pro_formal_note" class="mdl-textfield__input" value="<?php if (isset($edit_proposal)) { echo $edit_proposal[0]->iextepro_note;}?>">
									<label class="mdl-textfield__label" for="pro_formal_note">Enter Note</label>
								</div> -->
	    						<div contenteditable="true" id="pro_formal_note" style="font-size: 16px;"><?php if (isset($edit_proposal)) { echo $edit_proposal[0]->iextepro_note;}?></div>
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
	            <div class="mdl-tabs__panel" id="p_email">
	            	<div class="mdl-grid">
	            		<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<!-- <b>Select Title</b>								 -->
								<select class="mdl-textfield__input" id="pro_title">
									<option value='0'>Select title</option>
									<?php for($i=0; $i < count($pro_title); $i++) {
						            	echo '<option value='.$pro_title[$i]->iuetemp_id.'>'.$pro_title[$i]->iuetemp_title.'</option>';
						        	} ?>
						        </select>
						        <label class="mdl-textfield__label" for="pro_title">Select Title</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<div contenteditable="true" class="email_body"></div>
						</div>
						<div class="mdl-cell mdl-cell--6-col" style="border: 1px solid #ccc; border-radius: 10px; ">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									    <input class="mdl-textfield__input" type="text" id="email_amount" value="<?php if(isset($edit_proposal)){ echo $edit_proposal[0]->iextepro_amount; } ?>">
									    <label class="mdl-textfield__label" for="email_amount">Enter Amount</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
									<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
										<i class="material-icons">folder</i> Upload Document
										<input type="file" name="file[]" id="multiFiles" class="upload u_multiple" multiple>
									</div>
								</div>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
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
					<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="email_submit">
						<i class="material-icons">done</i>
					</button>
	            </div>
	            <div class="mdl-tabs__panel" id="p_verbal">
	            	<div class="mdl-grid" style="width: 100%;">
	            		<div class="mdl-cell mdl-cell--12-col">
	            			<div contenteditable="true" id="pro_note"><?php if (isset($edit_proposal)) {echo $edit_proposal[0]->iextepro_note;}?></div>
	            		</div>
	            		<div class="mdl-cell mdl-cell--4-col" style="border: 1px solid #ccc; border-radius: 10px;text-align: center;">
	            			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							    <input class="mdl-textfield__input" type="text" id="pro_amount" value="<?php if(isset($edit_proposal)){ echo $edit_proposal[0]->iextepro_amount; } ?>">
							    <label class="mdl-textfield__label" for="pro_amount">Enter Amount</label>
							</div>
	            		</div>
	            		<div class="mdl-cell mdl-cell--6-col">
	            		<h3>Tags</h3>
	                		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;">
								<ul id="pro_verbal_tag">
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
					<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="note_submit">
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
<div class="modal fade" id="term_Modal" role="dialog">
		<div class="modal-dialog">
	<!-- Modal content-->
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
	<!-- Modal content-->
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
					<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="user_add"><i class="material-icons">compare_arrows</i> Transfer</button>
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
				<?php echo '<a href="'.base_url().'Enterprise/module_setting/Proposal/'.$code.'"><button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored"> Click to select template</button><a>'; ?>
			</div>
		</div>
	</div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
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
    	<?php

    		if (isset($email_ids)) {
    			for ($i=0; $i <count($email_ids) ; $i++) {
    				echo "exist_email.push({'email' : '".$email_ids[$i]->icbd_value."','status' : 'false'});";
    			}
    		}

    		for ($i=0; $i < count($customer) ; $i++) { 
    			echo "customer_data.push('".$customer[$i]->ic_name."');";
    		}
    		// for ($i=0; $i < count($tags) ; $i++) { 
    		// 	echo "tag_data.push('".$tags[$i]->it_value."');";
    		// }
    		for ($i=0; $i < count($product) ; $i++) { 
    			echo "product_data_l.push('".$product[$i]->ip_product."');";
    		}
    		if (isset($taxes) && count($taxes) > 0) {
    			for ($i=0; $i < count($taxes); $i++) { 
	    			echo "tax_arr.push({'id' : ".$taxes[$i]->itxgc_tg_id." , 'percent' : '".$taxes[$i]->itx_percent."', 't_grp' : '".$taxes[$i]->ittxg_group_name."', 's_tax' : '".$taxes[$i]->itx_name."'});";
	    		}
    		}
    		if (isset($edit_proposal)) {
    			for ($i=0; $i <count($edit_proposal) ; $i++) { 
    				echo "product_list.push({'id' : ".$i.",'product' : '".$edit_proposal[$i]->ip_product."', 'rate' : '".$edit_proposal[$i]->iexteprod_rate."', 'qty' : '".$edit_proposal[$i]->iexteprod_qty."', 'disc' : '".$edit_proposal[$i]->iexteprod_discount."', 'tax_id' : '".$edit_proposal[$i]->iexteprod_tax."' , 'alias' : '".$edit_proposal[$i]->iexteprod_alias."' });";
    			}

    			if (count($proposal_property) > 0) {
    				for ($i=0; $i <count($proposal_property) ; $i++) { 
    					echo "property_arr.push({'id' : ".$proposal_property[$i]->iexteppt_id." ,'value' : '".$proposal_property[$i]->iexteppt_property_value."','status': '".$proposal_property[$i]->iexteppt_status."' });";
    				}
    			}
    		}
    		$flg = '';
    		if (isset($p_terms)) {
    			if (count($p_terms) > 0) {
    				for ($i=0; $i <count($p_terms) ; $i++) {
    					for ($ij=0; $ij <count($term_doc) ; $ij++) {
    						if ($p_terms[$i]->iexteptm_term_id == $term_doc[$ij]->iextdt_id) {
    							echo "terms_arr.push({'id' : ".$p_terms[$i]->iextdt_id.", 'terms' : '".$p_terms[$i]->iextdt_term."', 'status' : '".$p_terms[$i]->iexteptm_status."'});";
    						}
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

    		if (isset($term_doc) && !isset($p_terms) ) {
    			if (count($term_doc) > 0) {
    				for ($i=0; $i <count($term_doc) ; $i++) {
    					echo "terms_arr.push({'id' : ".$term_doc[$i]->iextdt_id.", 'terms' : '".$term_doc[$i]->iextdt_term."', 'status' : 'false'});";
    				}
    			}
    		}

    		if (isset($edit_proposal)) {
    			if ($edit_proposal[0]->iextepro_type == 'note') {
    				echo "$('#formal').css('display','none');";
    				echo "$('#p_formal').css('display','none');";
    				echo "$('#email').css('display','none');";
    				echo "$('#p_email').css('display','none');";
    				echo "$('#verbal').addClass('is-active');";
    				echo "$('#p_verbal').addClass('is-active');";
    			}else if($edit_proposal[0]->iextepro_type == 'formal'){
    				echo "$('#verbal').css('display','none');";
    				echo "$('#email').css('display','none');";
    				echo "$('#p_email').css('display','none');";
    				echo "$('#p_verbal').css('display','none');";
    			}else if($edit_proposal[0]->iextepro_type == 'email'){
    				echo "$('#formal').css('display','none');";
    				echo "$('#verbal').css('display','none');";
    				echo "$('#p_formal').css('display','none');";
    				echo "$('#p_verbal').css('display','none');";
    				echo "$('#email').addClass('is-active');";
    				echo "$('#p_email').addClass('is-active');";
    			}
    		}

			for ($i=0; $i < count($user_connection); $i++) {
	    		echo "user_data.push({'id' : ".$user_connection[$i]->iug_id.", 'name' : '".$user_connection[$i]->iug_name."'});";
			}
    	?>
	 $(document).ready( function() {
	 	terms_append();
	 	<?php
	 		if ($oppo_id != 'null' ) {
				echo "if($('#cust_name').val() != null ){get_details($('#cust_name').val());}";
			}
	 	?>
	 	var snackbarContainer = document.querySelector('#demo-toast-example');

	 	if (product_list.length > 0) {
	 		display_product_list();
	 	}

	 	$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

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

    	$('#pro_verbal_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

    	$("#cust_name").autocomplete({
            source: function(request, response) {
		        var results = $.ui.autocomplete.filter(customer_data, request.term);
		        response(results.slice(0, 10));
		    },
            select: function(event, ui) {
                var value =  ui.item.value;
                get_details(value);
            }
        });
        
    	$("#prod_name" ).autocomplete({
            source: function(request, response) {
		        var results = $.ui.autocomplete.filter(product_data_l, request.term);
		        response(results.slice(0, 10));
		    },
            select: function(event, ui) {
                var value =  ui.item.value;
                get_prod_details(value);
            }    
        });

        $('.pro_to_self').click(function (e) {
        	e.preventDefault();
        	$.post('<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_transfer/".$code."/".$tid."/0";}?>'
			, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Sales/proposal/".$mod_id."/".$code; ?>';
			}, "text");
        });

        $('.grp_switch').click(function (e) {
			e.preventDefault();
			switch_account();
			$('#myModal_group').modal('show');
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
			$('#add_activity').modal('hide');
		});

		var a_flg = 'false';
    
        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });
        
        $('#submit').click(function(e) {
            e.preventDefault();
            if($('#search_modal').css('display') != 'none'){
                var note = $('#notes_text').html();
                $('#ATags > li').each(function(index) {
                    var tmpstr = $(this).text();
                    var len = tmpstr.length - 1;
                    if(len > 0) {
                        tmpstr = tmpstr.substring(0, len);
                        activity_tags.push(tmpstr);
                    }
                });
                var date = $('.s_date').val();
                var e_date = $('.e_date').val();
                $.post('<?php echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
                    'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
                }, function(data, status, xhr) {
                        location.reload();
                }, 'text');
            }else{
            	var note = $('#notes_text').html();
	            $('#ATags > li').each(function(index) {
	                var tmpstr = $(this).text();
	                var len = tmpstr.length - 1;
	                if(len > 0) {
	                    tmpstr = tmpstr.substring(0, len);
	                    activity_tags.push(tmpstr);
	                }
	            });
	            var date = $('.s_date').val();
	            var e_date = $('.e_date').val();
				$.post('<?php echo base_url()."Home/activity_update/".$code; ?>', {
					'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
				}, function(data, status, xhr) {
					window.location = '<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_add/".$code."/".$mod_id."/".$tid; } ?>';
				}, 'text');
            }
        });
   //      if ($('#search_modal').css('display') != 'block') {
   //      	$('#submit').click(function(e) {
			// 	e.preventDefault();
			// 	var note = $('#notes_text').html();
	  //           $('#ATags > li').each(function(index) {
	  //               var tmpstr = $(this).text();
	  //               var len = tmpstr.length - 1;
	  //               if(len > 0) {
	  //                   tmpstr = tmpstr.substring(0, len);
	  //                   activity_tags.push(tmpstr);
	  //               }
	  //           });
	  //           var date = $('.s_date').val();
	  //           var e_date = $('.e_date').val();
			// 	$.post('<?php echo base_url()."Home/activity_update/".$code; ?>', {
			// 		'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
			// 	}, function(data, status, xhr) {
			// 		window.location = '<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_add/".$code."/".$mod_id."/".$tid; } ?>';
			// 	}, 'text');
			// });
   //      }

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
			$.post('<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_transfer/".$code."/".$tid."/";}?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Sales/proposal/".$mod_id."/".$code; ?>';
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

		$('#user_add').click(function (e) {
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
			$.post('<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_transfer_user/".$code."/".$tid; } ?>', {
				'cust_name' : name[0]
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = '<?php echo base_url()."Sales/proposal/".$mod_id."/".$code; ?>';
				}else{
					var data = {message: 'User not register!'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}
			}, 'text');
		});

     	$('#pro_title').change(function (e) {
     		e.preventDefault();
     		e_title = $('#pro_title').val();
     		$.post('<?php echo base_url()."Sales/get_email_body/".$code."/";?>'+e_title
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
     		$.post('<?php echo base_url()."Sales/save_document_terms/Proposal/".$code; ?>', {
				'name' : $('#t_name').val()
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				terms_arr = [];
				for (var i = 0; i < a.terms.length; i++) {
					terms_arr.push({'id' : a.terms[i].iextdt_id , 'terms' : a.terms[i].iextdt_term , 'status' : 'false' });
				}
				terms_append();
			}, 'text');
     	});   	

     	$('.proposal_table').on('change', 'input[type=checkbox]', function(e) {
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
            		if (ischecked == true) {
            			terms_arr[i].status = "true";
            		}else{
            			terms_arr[i].status = "false";
            		}
            	}
            }
        });

    	$('#add_prp').click(function(e) {
    		e.preventDefault();
    		additemtoarray();
    		clearallfields();
    	});

		$('#prod_qty').keyup(function(e) {
    		e.preventDefault();
    		if (e.keyCode == 13) {
    			additemtoarray();
    			clearallfields();
    		}
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
		    		$('#prod_rate').val(product_list[id].rate);
		    		$('#prod_qty').val(product_list[id].qty);
		    		$('#prod_disc').val(product_list[id].disc);
		   			$('#prod_tax').val(product_list[id].tax_id);
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
    		var pro_tags = [];
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
                    pro_tags.push(tmpstr);
                }
            });
    		$.post('<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_update/formal/".$code."/".$tid; }else{ echo base_url()."Sales/proposal_save/formal/".$code."/".$oppo_id; } ?>',{
	    		'customer' : $('#cust_name').val(),
				'txn_no' : $('#i_txn_no').val(),
				'txn_date' : $('#i_txn_date').val(),
				'product' : product_list,
				'amount' : amount,
				'note' : $('#pro_formal_note').html(),
				'status' : $('#i_txn_status').val(),
				'terms' : terms_arr,
				'mutual' : mutual,
				'property' : property_arr,
				'tags' : pro_tags
			}, function(data, status, xhr) {
				upload_files(data);
			}, "text");
    	});

    	$('#cust_draft').click(function (e) {
    		e.preventDefault();

    		$.post('<?php if (isset($edit_proposal)) { echo base_url()."Sales/update_proposal_save/draft/".$code."/".$tid; } else {echo base_url()."Sales/proposal_save/draft/".$code;} ?>',{
    		'customer' : $('#cust_name').val(),
			'txn_no' : $('#i_txn_no').val(),
			'txn_date' : $('#i_txn_date').val(),
			'product' : product_list,
			'amount' : amount,
			'status' : $('#i_txn_status').val()
		}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Sales/proposal/".$mod_id."/".$code; ?>';
			}, "text");
    	});

	    $('#cust_print').click(function(e){
	    	e.preventDefault();
	    	$.post('<?php echo base_url()."Enterprise/check_template/".$code."/".$mod_id; ?>',{
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = "<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_download/p/".$code."/".$mod_id."/".$tid;} ?>" ;
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
					window.location = "<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_download/d/".$code."/".$mod_id."/".$tid;} ?>" ;
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
	    	window.location = "<?php if (isset($edit_proposal)) { echo base_url()."Sales/proposal_delete/".$code."/".$mod_id."/".$tid;} ?>" ;
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
			$.post('<?php if (isset($edit_proposal)) echo base_url()."Sales/save_proposal_mail/".$code."/".$mod_id."/".$tid; ?>',
				{'cust_mail_id' : exist_email}
				,function(data, status, xhr){
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

    	$('#note_submit').click(function (e) {
    		e.preventDefault();
    		var pro_tags = [];
    		var mutual = [];
			$('#mutual_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					mutual.push(tmpstr1);
				}
			});

    		$('#pro_verbal_tag > li').each(function(index) {
                var tmpstr = $(this).text();
                var len = tmpstr.length - 1;
                if(len > 0) {
                    tmpstr = tmpstr.substring(0, len);
                    pro_tags.push(tmpstr);
                }
            });
    		$.post('<?php if(isset($edit_proposal)){ echo base_url()."Sales/proposal_update/note/".$code."/".$tid; }else { echo base_url()."Sales/proposal_save/note/".$code; } ?>',{
    		'customer' : $('#cust_name').val(),
			'txn_no' : $('#i_txn_no').val(),
			'txn_date' : $('#i_txn_date').val(),
			'amount' : $('#pro_amount').val(),
			'note' : $('#pro_note').html(),
			'status' : $('#i_txn_status').val(),
			'property' : property_arr,
			'mutual' : mutual,
			'tags' : pro_tags
		}, function(data, status, xhr) {
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
					url: "<?php echo base_url().'Sales/pro_doc_upload/'.$code.'/null/'; ?>"+ cust_name, // Url to which the request is send
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
								repo.push({'file_name' : a.files[i].icd_file});
							}
						}
						send_upload_mail();
					}
				});
			}
    	})

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

    	function upload_files(pid){
    		var cust_name = $('#cust_name').val();
    		if($('.proposal_doc')[0].files[0]) {
				var datat = new FormData();
	            var ins = $('.proposal_doc')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.proposal_doc')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Sales/pro_doc_upload/'.$code."/";?>"+pid+'/'+cust_name, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						window.location = '<?php echo base_url()."Sales/proposal_add/".$code."/".$mod_id."/";?>'+pid;
					}
				});
			}else{
				window.location = '<?php echo base_url()."Sales/proposal_add/".$code."/".$mod_id."/";?>'+pid;
			}
    	}

    	function send_upload_mail() {
			$('.loader').show();
			var pro_tags = [];
			var mutual = [];
			$('#mutual_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					mutual.push(tmpstr1);
				}
			});

    		$('#pro_email_tag > li').each(function(index) {
                var tmpstr = $(this).text();
                var len = tmpstr.length - 1;
                if(len > 0) {
                    tmpstr = tmpstr.substring(0, len);
                    pro_tags.push(tmpstr);
                }
            });
			$.post('<?php echo base_url()."Sales/proposal_send_email/".$code; ?>', {
				'customer' : $('#cust_name').val(),
				'txn_no' : $('#i_txn_no').val(),
				'txn_date' : $('#i_txn_date').val(),
				'files' : repo,
				'email' : email_array,
				'subject' : e_title,
				'content' : $('.email_body').html(),
				'amount' : $('#email_amount').val(),
				'status' : $('#i_txn_status').val(),
				'property' : property_arr,
				'mutual' : mutual,
				'tags' : pro_tags
			}, function(data, status, xhr) {
				$('.loader').hide();
				upload_files(data);
			}, 'text');
		}

    	function clearallfields() {
    		$('#prod_rate').val("");
    		$('#prod_qty').val("");
    		$('#prod_disc').val("");
    		$('#prod_tax').val("null");
    		$('#prod_name').val("");
    		$('#prod_name').focus();
    	}

    	function additemtoarray() {
    		var product = $('#prod_name').val();
    		var rate = $('#prod_rate').val();
    		var qty = $('#prod_qty').val();
    		var disc = $('#prod_disc').val();
    		var tax_id = $('#prod_tax').val();

    		if (edit_flg == '1') {
    			product_list[edit_id]['product'] = product;
    			product_list[edit_id]['rate'] = rate;
    			product_list[edit_id]['qty'] = qty;
    			product_list[edit_id]['disc'] = disc;
    			product_list[edit_id]['tax_id'] = tax_id;
    		}else{
    			$.post('<?php echo base_url()."Sales/proposal_product_rate/".$code."/"; ?>',{
    				'p_name' : product
    			}, function(data, status, xhr) {
					var a = JSON.parse(data);
					if (a.child_prod == 'true') {
						for (var i = 0; i < a.c_prod.length; i++) {
							product_list.push({'id' : p,'product' : a.c_prod[i].ip_product , 'rate' : a.c_prod[i].ipp_sell_price, 'qty' : a.c_prod[i].ipcp_qty * qty , 'disc' : '', 'tax_id' : a.c_prod[i].ipt_t_id , 'alias' : 'false' });
							p++;
						}
					}else{
						product_list.push({'id' : p,'product' : product, 'rate' : rate, 'qty' : qty, 'disc' : disc, 'tax_id' : tax_id , 'alias' : 'false' });
    					p++;
					}
					display_product_list();
				}, "text");
    		}
    		edit_flg = '0';
    		edit_id = '0';
    		display_product_list();
		}

		function display_product_list() {
			var out = '', out2='';
			var product_total = 0;
			var grand_total = 0;
				
			for (var i = 0; i < product_list.length; i++) {
				var sr_no = i + 1;
				var total = 0;var disc_amt = 0;var total_tax = 0;
				out +='<tr class="no_border"><td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="' + i + '"> <i class="material-icons">delete</i> </button>';
				out +='<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored edit" id="' + i + '"> <i class="material-icons">edit</i> </button></td><td>';
				if (product_list[i].alias == 'true') {
					out += '<input class="mdl-checkbox__input alias_name" type="checkbox" id="'+ i +'" checked>';
				}else{
					out += '<input class="mdl-checkbox__input alias_name" type="checkbox" id="'+ i +'">';
				}
				out += '</td><td>'+sr_no+'</td>';
				out += '<td>'+product_list[i].product+'</td><td>'+product_list[i].rate+'</td><td>'+product_list[i].qty+'</td>';
				if (product_list[i].disc == '') {
					total = product_list[i].rate * product_list[i].qty;	
					out +='<td>Not selected</td>';
				}else{
					disc_amt = (product_list[i].rate * product_list[i].qty) * (product_list[i].disc / 100);
					total = product_list[i].rate * product_list[i].qty - disc_amt;
					out +='<td>'+product_list[i].disc+'</td>';
				}
				product_total = product_total + total;
				if (tax_arr.length > 0) {
					for (var j = 0; j < tax_arr.length; j++) {
						if (product_list[i].tax_id == tax_arr[j].id) {
							var tax_percent = parseFloat(tax_arr[j].percent);
							total_tax = total_tax + tax_percent;
							var tax_grp = tax_arr[j].t_grp;
						}
					}
				}
				var total_tax_amt = total * ( total_tax / 100 );
				total = total + total_tax_amt;
				grand_total = grand_total + total;
				out +='<td>'+tax_grp+'</td>';
				out +='<td>'+total+'</td>';
				out +='</tr>';
			}

			out2 +='<tr><td></td><td colspan="7">Product Value</td><td>'+product_total+'</td></tr>';
			if (product_list.length > 0) {
				if (tax_arr.length > 0) {
					for (var k = 0; k < tax_arr.length; k++) {
						var tax_amount = 0;var p_total = 0;
						var flg = 0;
						var tax_product = '';
						for (var l = 0; l < product_list.length; l++) {
							if (tax_arr[k].id == product_list[l].tax_id) {
								if (flg == 0) {
									tax_product += product_list[l].product;
									flg++;	
								}else{
									tax_product += ' ,  '+product_list[l].product;
								}
								if (product_list[l].disc == '') {
									p_total = product_list[l].rate * product_list[l].qty;	
								}else{
									disc_amt = (product_list[l].rate * product_list[l].qty) * (product_list[l].disc / 100);
									p_total = product_list[l].rate * product_list[l].qty - disc_amt;
								}
								tax_amount = tax_amount + p_total * (tax_arr[k].percent/100);
							}
						}
						if (tax_amount != 0) {
							out2 +='<tr><td></td><td>'+tax_arr[k].s_tax+'</td><td colspan="6">'+tax_product+'</td><td>'+tax_amount+'</td></tr>';
						}
					}
				}
				amount = grand_total;
				var grand_total_tax = grand_total - product_total;
				out2 +='<tr><td></td><td colspan="7">Grand Total</td><td>'+grand_total+'</td></tr>';
			}

			$('#proposal_list > tbody').empty();
			$('#proposal_list > tbody').append(out);		

			$('#proposal_list > tfoot').empty();
			$('#proposal_list > tfoot').append(out2);
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

    	function get_details(customer) {
			$.post('<?php echo base_url()."Sales/cust_details/".$code."/"; ?>',{
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

		function get_prod_details(product_name) {
			$.post('<?php echo base_url()."Enterprise/invoice_product_rate/".$code."/"; ?>',{
				'pname' : product_name
			}, function(data, status, xhr) {
					var a = JSON.parse(data);
					$('#prod_rate').focus();
					$('#prod_rate').val(a.prod_rate);
					if (a.prod_tax != '') {
						$('#prod_tax').val(a.prod_tax);
					}else{
						$('#prod_tax').val('null');
					}
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
			$('.proposal_table').empty();
			$('.proposal_table').append(out);
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
			console.log(u);
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