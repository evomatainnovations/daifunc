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
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" <?php if(isset($edit_cust)) { echo "value=".$edit_cust[0]->ic_name; }else{echo "placeholder='Enter customer name'";}?> style="font-size: 3em;outline: none;">
			<table>
				<tbody class="invoice_table" style="text-align: left;font-size : 1em;"></tbody>
			</table>
			<button class="mdl-button mdl-button--accent" id="add_property"><i class="material-icons">add</i> Add Property</button>
		</div>
		<div class="mdl-cell mdl-cell--8-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="i_txn_no" name="i_txn_no" class="mdl-textfield__input" value="<?php if(isset($edit_orders)) { echo $edit_orders[0]->iextetor_txn_id; }else{echo $invoice_doc_id;} ?>">
						<label class="mdl-textfield__label" for="i_txn_no">Enter Transaction Number</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_orders)) { echo $edit_orders[0]->iextetor_date; }else{echo date('Y-m-d'); } ?>">
						<label class="mdl-textfield__label" for="i_txn_date">Select Date</label>
					</div>
				</div>
				<?php 
					if(isset($edit_orders)) {
						echo '<div class="mdl-cell mdl-cell--3-col">';
						echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="i_txn_status">';
						if ($edit_orders[0]->iextetor_status == "pending") {
							echo '<option value="pending" selected>Pending</option>';
						} else {
							echo '<option value="pending">Pending</option>';
						}

						if ($edit_orders[0]->iextetor_status == "approved") {
							echo '<option value="approved" selected>Approved</option>';
						} else {
							echo '<option value="approved">Approved</option>';
						}
						echo '</select><label class="mdl-textfield__label" for="i_txn_status">Select Order Status</label></div>';
						echo '</div>';
					}
				?>
				<div class="mdl-cell mdl-cell--3-col upload-btn-wrapper">
					<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
						<i class="material-icons">note</i>  Upload Document
						<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
					</div>
				</div>
			</div>
			<div class="mdl-grid" style="text-align: right; display: inline-flex;">
				<?php
					if(isset($edit_orders)) {
						echo '<button type="button" class="mdl-button mdl-button--colored" data-toggle="collapse" style="margin-top : 10px" data-target="#demo">OWNERSHIP AND GROUP</button>';
						// echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="tx_payment">Add payment</button></a>';
						echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="follow_up">Follow Up</button></a>';
						// echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_draft">Save as draft</button><br>';
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
				<div class="mdl-grid" style="text-align: left;">
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
						if(isset($edit_orders)) {
							echo '<div class="mdl-cell mdl-cell--4-col" style="margin-top:30px;text-align:center;">';
							if ($invoice_gid == 0) {
								echo '<button class="mdl-button mdl-button--accent grp_switch" style="margin-top : 10px"><i class="material-icons">compare_arrows</i> Transfer to group</button></a>';
							}else{
								echo '<button class="mdl-button mdl-button--accent pro_to_self" style="margin-top : 10px"><i class="material-icons">compare_arrows</i> Transfer to self</button></a>';
							}
							echo '</div><div class="mdl-cell mdl-cell--4-col" style="margin-top:30px;"><button class="mdl-button mdl-button--accent pro_to_user" style="margin-top : 10px"><i class="material-icons">compare_arrows</i> Transfer to another user</button></a></div>';
						}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-cell mdl-cell--12-col" id="invoice_type">
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
									<input type="text" id="prod_rate" name="prod_rate" class="mdl-textfield__input inv_prod">
									<label class="mdl-textfield__label" for="prod_rate">Rate</label>
								</div>
							</div>
							<div class="mdl-cel mdl-cell--2-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" id="prod_qty" name="prod_qty" class="mdl-textfield__input inv_prod">
									<label class="mdl-textfield__label" for="prod_qty">Qty</label>
								</div><br>
								<span class="avl_bal" style="font-weight: bold;"></span>
							</div>
							<div class="mdl-cel mdl-cell--2-col">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input type="text" id="prod_apr" name="prod_apr" class="mdl-textfield__input inv_prod">
									<label class="mdl-textfield__label" for="prod_apr">Approved Qty</label>
								</div>
							</div>
							<div class="mdl-cell mdl-cell--2-col" style="text-align: center;">
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
            						<th>Rate</th>
            						<th>Qty</th>
            						<th>Approved Qty</th>
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
    						<div contenteditable="true" id="pro_formal_note" style="font-size: 16px;"><?php if (isset($edit_orders)) { echo $edit_orders[0]->iextetor_note;}?></div>
    					</div>
            		</div>
            		<div class="mdl-cell mdl-cell--6-col">
    					<h3>Tags</h3>
                		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;">
							<ul id="order_formal_tag">
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
            				<tbody></tbody>
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
						<textarea id="t_name" name="t_name" class="mdl-textfield__input" style="outline: none;"></textarea>
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
					<?php echo '<a href="'.base_url().'Enterprise/module_setting/Orders/'.$code.'"><button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored"> Click to select template</button><a>'; ?>
				</div>
			</div>
		</div>
	</div>
</body>
<style type="text/css">
	.modal-dialog {
		z-index: 10000000 !important;
	}
	.purchase_table {
		width: 100%;
        text-align: left;
        font-size: 1.5em;
        border: 0px solid #ccc;
        border-collapse: collapse;
    }

	@media only screen and (max-width: 760px) {
		.purchase_table {
			display: block;
        	overflow: auto;
		}
	}

	.purchase_table > thead > tr {
		box-shadow: 0px 5px 5px #ccc;
	}

	.purchase_table > thead > tr > th {
		padding: 10px;
	}

	.purchase_table > tbody > tr {
		border-bottom: 1px solid #ccc;
	}

	.purchase_table > tbody > tr > td {
		padding: 15px;
	}
</style>
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

    		for ($i=0; $i < count($product) ; $i++) { 
    			echo "product_data_l.push('".$product[$i]->ip_product."');";
    		}

			for ($i=0; $i < count($tags) ; $i++) {
    			echo "tag_data.push('".$tags[$i]->it_value."');";
    		}
    		
    		if (isset($edit_orders)) {
    			for ($i=0; $i <count($edit_orders) ; $i++) {
    				echo "product_list.push({'id' : ".$i.",'product' : '".$edit_orders[$i]->ip_product."', 'rate' : '".$edit_orders[$i]->iextetodp_rate."', 'qty' : '".$edit_orders[$i]->iextetodp_qty."', 'alias' : '".$edit_orders[$i]->iextetodp_alias."' , 'ap_qty' : '".$edit_orders[$i]->iextetodp_approved_qty."' });";
    			}
    		}

    		if (isset($invoice_property)) {
    			if (count($invoice_property) > 0) {
    				for ($i=0; $i <count($invoice_property) ; $i++) { 
    					echo "property_arr.push({'id' : ".$invoice_property[$i]->iextetorp_id." ,'value' : '".$invoice_property[$i]->iextetorp_property_value."','status': '".$invoice_property[$i]->iextetorp_status."' });";
    				}
    			}
    		}

    		if (isset($p_terms)) {
    			if (count($p_terms) > 0) {
    				for ($i=0; $i <count($p_terms) ; $i++) { 
    					echo "terms_arr.push({'id' : '".$p_terms[$i]->iextdt_id."', 'terms' : '".$p_terms[$i]->iextdt_term."', 'status' : '".$p_terms[$i]->iextetort_status."'});";
    				}
    			}
    		}

    		if (isset($term_doc)) {
    			if (count($term_doc) > 0) {
    				for ($i=0; $i <count($term_doc) ; $i++) {
    					echo "terms_arr.push({'id' : ".$term_doc[$i]->iextdt_id.", 'terms' : '".$term_doc[$i]->iextdt_term."', 'status' : 'false'});";
    				}
    			}
    		}

    		// if (isset($edit_invoice)) {
    		// 	if($edit_invoice[0]->iextein_type == 'formal'){
    		// 		echo "$('#p_email').css('display','none');";
    		// 		echo "$('#email').css('display','none');";
    		// 	}else if($edit_invoice[0]->iextein_type == 'email'){
    		// 		echo "$('#formal').css('display','none');";
    		// 		echo "$('#p_formal').css('display','none');";
    		// 		echo "$('#email').addClass('is-active');";
    		// 		echo "$('#p_email').addClass('is-active');";
    		// 	}
    		// }

			for ($i=0; $i < count($user_connection); $i++) {
	    		echo "user_data.push({'id' : ".$user_connection[$i]->iug_id.", 'name' : '".$user_connection[$i]->iug_name."'});";
			}
    	?>
	 $(document).ready( function() {
	 	terms_append();
	 	display_details();
	 	var snackbarContainer = document.querySelector('#demo-toast-example');
	 	if (product_list.length > 0) {
	 		display_product_list();
	 	}

	 	$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

	 	$('#pay_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

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

        $('#order_formal_tag').tagit({
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
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_prod_details(value);
            }    
        });

        $('#mutual_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : customer_data,
    		singleField : true
    	});

    	$('.pro_to_self').click(function (e) {
        	e.preventDefault();
        	$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/invoice_transfer/".$code."/".$tid."/0";}?>'
			, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/invoice/".$mod_id."/".$code; ?>';
			}, "text");
        });

    	var pay_edit = 0;
    	$('#tx_payment').click(function (e) {
			e.preventDefault();
			$('#modial_payment').modal('show');
		});

		$('.pay_save').click(function (e) {
			e.preventDefault();
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/pay_save/".$mod_id."/".$code."/".$tid."/";}?>'+pay_edit,{
				'p_mode':$('#pay_mod').val(),
				'p_date':$('#pay_date').val(),
				'p_amt':$('#pay_amt').val(),
				'p_vno':$('#pay_vno').val(),
				'p_desc':$('#pay_desc').val()
			}, function(data, status, xhr) {
				window.location = '<?php if (isset($edit_invoice)) echo base_url()."Enterprise/invoice_add/".$mod_id."/".$code."/".$tid; ?>';
			}, "text");
		});

		$('.pay_delete').click(function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/pay_delete/".$mod_id."/".$code."/";}?>'+id,
			function(data, status, xhr) {
				window.location = '<?php if (isset($edit_invoice)) echo base_url()."Enterprise/invoice_add/".$mod_id."/".$code."/".$tid; ?>';
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

        $('.grp_switch').click(function (e) {
			e.preventDefault();
			switch_account();
			$('#myModal_group').modal('show');
		});

		$('#myModal_group').on('click','#account_search',function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Home/account_search"; ?>', {
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
			$.post('<?php if (isset($edit_orders)) { echo base_url()."Orders/orders_transfer/".$code."/".$tid."/";}?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Orders/home/".$mod_id."/".$code; ?>';
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
			$.post('<?php if (isset($edit_orders)) { echo base_url()."Orders/orders_transfer_user/".$code."/".$tid; } ?>', {
				'cust_name' : name[0]
			}, function(data, status, xhr) {
				$('#myModal_user').modal('hide');
				if (data == 'true') {
					window.location = '<?php echo base_url()."Orders/home/".$mod_id."/".$code; ?>';
				}else{
					var data = {message: 'User not register!'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}
			}, 'text');
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
     			window.location = '<?php echo base_url()."Enterprise/cust_add_property/".$code."/";?>'+cust;	
     		}
     	});

     	$('#m_add_terms').click(function (e) {
     		e.preventDefault();
     		$.post('<?php echo base_url()."Enterprise/save_terms/Orders/".$code; ?>', {
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
		    		$('#prod_rate').val(product_list[id].rate);
		    		$('#prod_qty').val(product_list[id].qty);
		    		$('#prod_apr').val(product_list[id].ap_qty);
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
    		$.post('<?php if (isset($edit_orders)) { echo base_url()."Orders/orders_update/self/".$tid."/".$code; }else{ echo base_url()."Orders/orders_save/self/".$code; } ?>',{
	    		'customer' : $('#cust_name').val(),
				'txn_no' : $('#i_txn_no').val(),
				'txn_date' : $('#i_txn_date').val(),
				'product' : product_list,
				'ord_amt' : amount,
				'status' : $('#i_txn_status').val(),
				'terms' : terms_arr,
				'property' : property_arr,
				'tags' : txn_tags,
				'note' : $('#pro_formal_note').html(),
				'mutual' : mutual,
				'wrt_mnt' : $('#i_wrnty').val()
			}, function(data, status, xhr) {
				upload_files(data);
			}, "text");
    	});

    	function upload_files(pid){
    		if($('.proposal_doc')[0].files.length > 0) {
    			var cust_name = $('#cust_name').val();
				var datat = new FormData();
	            var ins = $('.proposal_doc')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.proposal_doc')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Orders/orders_doc_upload/'.$code.'/';?>"+pid+'/'+cust_name,
					type: "POST",
					data: datat,
					contentType: false,
					cache: false,
					processData:false,
					success: function(data){
						window.location = '<?php echo base_url()."Orders/orders_add/".$mod_id."/".$code."/"; ?>'+pid;
					}
				});
			}else{
				window.location = '<?php echo base_url()."Orders/orders_add/".$mod_id."/".$code."/"; ?>'+pid;
			}
    	}

    	$('#follow_up').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."View/activity_modal/".$code."/Event/"; ?>'
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
		});

    	$('#cust_print').click(function(e){
	    	e.preventDefault();
	    	$.post('<?php echo base_url()."Enterprise/check_template/".$code."/".$mod_id; ?>',{
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = "<?php if (isset($edit_orders)) { echo base_url()."Orders/orders_download/p/".$tid."/".$code;} ?>";
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
					window.location = "<?php if (isset($edit_orders)) { echo base_url()."Orders/orders_download/d/".$tid."/".$code;} ?>";
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
	    	window.location = "<?php if (isset($edit_orders)) { echo base_url()."Orders/orders_delete/".$code."/".$tid;} ?>" ;
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
			$.post('<?php if (isset($edit_orders)) echo base_url()."Orders/send_orders_email/".$mod_id."/".$tid."/".$code; ?>',
				{'cust_mail_id' : exist_email}
			,function(data, status, xhr){
				console.log(data);
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

    	$('#prod_apr').keyup(function(e) {
    		e.preventDefault();
    		if (e.keyCode == 13) {
    			additemtoarray();
    			clearallfields();
    		}
    	});

    	$('#prod_qty').keyup(function(e) {
    		e.preventDefault();
    		if (e.keyCode == 13) {
    			additemtoarray();
    			clearallfields();
    		}
    	});

    	function clearallfields() {
			$('#prod_rate').val("");
    		$('#prod_qty').val("");
    		$('#prod_name').val("");
    		$('#prod_apr').val("");
    		$('#prod_name').focus();
    	}

    	function additemtoarray() {
    		var product = $('#prod_name').val();
    		var rate = $('#prod_rate').val();
    		var qty = $('#prod_qty').val();
    		var ap_qty = $('#prod_apr').val();

    		if (ap_qty == '') {
    			ap_qty = qty;
    		}
    		if (edit_flg == '1') {
    			product_list[edit_id]['product'] = product;
    			product_list[edit_id]['rate'] = rate;
    			product_list[edit_id]['qty'] = qty;
    			product_list[edit_id]['ap_qty'] = ap_qty;
    		}else{
    			product_list.push({'id' : p,'product' : product, 'rate' : rate, 'qty' : qty, 'ap_qty' : ap_qty , 'alias' : false });
    			p++;
    		}
    		display_product_list();
		}

		function display_product_list() {
			var out = '', out2='';
			var product_total = 0;
			var grand_total = 0;
			amount = 0;
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
				out +='<td>'+product_list[i].ap_qty+'</td>';
				total = product_list[i].rate * product_list[i].ap_qty;
				product_total = product_total + total;
				amount = total + amount;
				out +='<td>'+total+'</td>';
				out +='</tr>';
			}
			out2 +='<tr><td></td><td colspan="6">Grand Total</td><td>'+product_total+'</td></tr>';

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
					out +='<tr><td><input type="checkbox" id="'+property_arr[i].id+'" checked></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}else{
					out +='<tr><td><input type="checkbox" id="'+property_arr[i].id+'" ></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}
				
			}
			$('.invoice_table').empty();
			$('.invoice_table').append(out);
		}

		function get_prod_details(product_name) {
			$.post('<?php echo base_url()."Orders/orders_product_rate/".$code."/"; ?>',{
				'pname' : product_name
			}, function(data, status, xhr) {
				if (data == 'false') {
					$('#prod_rate').focus();
				}else{
					var a = JSON.parse(data);
					if (a.product_list.length > 0) {
						var bal = a.product_list[0]['bal'];
					}else{
						var bal = 0;
					}
					$('#prod_rate').focus();
					$('#prod_rate').val(a.prod_rate);
					$('.avl_bal').empty();
					$('.avl_bal').append('Available balance is '+bal);
				}
			}, "text");
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