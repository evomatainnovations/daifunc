<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text"><?php echo $title; ?> Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

						<label>Enter Customer Name</label>
						<ul id="i_name">
							<?php if(isset($edit_invoice)) { 
								echo "<li>".$edit_invoice[0]->ic_name."</li>";
							} ?>
						</ul>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="i_txn_no" name="i_txn_no" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iexteq_txn_id; } 
							else { 
								$abc = '';
								for ($i=0; $i < count($syntax) ; $i++) { 
									if($syntax[$i]->iumdi_variable == 'true') {
										$abc .= ${$syntax[$i]->iumdi_doc_syntax};	
									} else {
										$abc .= $syntax[$i]->iumdi_doc_syntax;
									}
								}
								echo $abc;
							} ?>">
						<label class="mdl-textfield__label" for="i_txn_no">Enter Transaction Number</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iexteq_txn_date; } ?>">
						<label class="mdl-textfield__label" for="i_txn_date">Select Transaction Date</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="i_txn_amt" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iexteq_amount; } ?>">
						<label class="mdl-textfield__label" for="i_txn_amt">Final Amount</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="i_txn_disc" class="mdl-textfield__input" value="">
						<label class="mdl-textfield__label" for="i_txn_disc">Discount (incase of discount percentage put a % after)</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="i_txn_note" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iexteq_note; } ?>">
						<label class="mdl-textfield__label" for="i_txn_note">Note</label>
					</div>
					<?php if(isset($edit_invoice_details)) {
						echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> <select class="mdl-textfield__input" id="i_txn_status">';
						if ($edit_invoice[0]->iexteq_status == "open") {
							echo '<option value="open" selected>Open</option>';
						} else {
							echo '<option value="open">Open</option>';
						}

						if ($edit_invoice[0]->iexteq_status == "discuss") {
							echo '<option value="discuss" selected>Discussion</option>';
						} else {
							echo '<option value="discuss">Discussion</option>';
						}

						if ($edit_invoice[0]->iexteq_status == "consider") {
							echo '<option value="consider" selected>May Consider</option>';
						} else {
							echo '<option value="consider">May Consider</option>';
						}

						if ($edit_invoice[0]->iexteq_status == "negotiate") {
							echo '<option value="negotiate" selected>Negotiation</option>';
						} else {
							echo '<option value="negotiate">Negotiation</option>';
						}

						if ($edit_invoice[0]->iexteq_status == "close") {
							echo '<option value="close" selected>Closed</option>';
						} else {
							echo '<option value="close">Closed</option>';
						}

						if ($edit_invoice[0]->iexteq_status == "cancel") {
							echo '<option value="cancel" selected>Cancelled</option>';
						} else {
							echo '<option value="cancel">Cancelled</option>';
						}

						echo '</select> <label class="mdl-textfield__label" for="i_txn_status">Quotation Status</label> </div>'; 
						echo '<a href="'.base_url().'Enterprise/follow_up/'.$mod_id.'/'.$inid.'">';
						
					}
					if(isset($edit_invoice_details)) {
						echo '<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Follow Up</button></a>';
						echo '<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;margin-top : 10px" id="cust_draft">Save as draft</button>';
						echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_mail"><i class="material-icons">mail</i></button>';
						echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_download"><i class="material-icons">cloud_download</i></button>';
						echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px" id="cust_print"><i class="material-icons">print</i></button>';
					}else{
						echo '<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;margin-top : 10px" id="cust_draft">Save as draft</button>';
					}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Product Details</h2>
				</div>
				<div class="mdl-card__supporting-text" style="width: 90%;">
					<div id="info_repea" class="mdl-grid">
						<!-- <div class="mdl-cell--4-col"></div>
						<div class="mdl-cell--4-col"></div> -->
						<div class="mdl-cell--12-col">
							<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;width:100%;">
								<select class="mdl-textfield__input" id="outward">
									
								</select>
								<label class="mdl-textfield__label" for="outward">Select Transaction Date</label>
							</div> -->
						</div>

						<div class="mdl-cel mdl-cell--4-col" style="margin:0px;padding:0px;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;width:100%;">
								<b>Type Product Name</b>
								<ul class="inv_prod" id="prod_name">
								</ul>
							</div>
						</div>
						<div class="mdl-cel mdl-cell--2-col" style="margin-top:0%;margin-left:0%;padding:0px;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;width:90%;">
								<b>Rate</b>
								<input type="text" id="prod_rate" class="" value="" style="text-align: center;width: 100%; padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 16px 0px 16px 0px; border: 1px solid #999;">
							</div>
						</div>
						<div class="mdl-cel mdl-cell--2-col" style="margin-top:0%;margin-left:0%;padding:0px;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;width:90%;">
								<b>Qty</b>
								<input type="text" id="prod_qty" class="" value="" style="text-align: center;width: 100%; padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 16px 0px 16px 0px; border: 1px solid #999;">
							</div>
						</div>
						<div class="mdl-cel mdl-cell--2-col" style="margin-top:0%;margin-left:0%;margin-right: 5px;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;width:90%;">
								<b>Disc</b>
								<input type="text" id="prod_disc" class="" value="" style="text-align: center;width: 100%; padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 16px 0px 16px 0px; border: 1px solid #999;">
							</div>
						</div>
						<div class="mdl-cel mdl-cell--2-col" style="margin-top:0%;margin-left:0%;margin-right: 5px;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding-top:0px; padding-bottom: 9px; text-align:left;width:100%;">
								<b>Select TAX</b>								

								<select class="mdl-textfield__input" id="prod_tax" style="text-align: center;width: 100%; padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 15px 0px 16px 0px; border: 1px solid #999;">
									<label class="mdl-textfield__label" for="prod_tax">Select Tax</label>
									<option value='null'>Select</option>
									<?php for($i=0; $i < count($tax); $i++) {
						            	echo '<option value="'.$tax[$i]->ittxg_id.'">'.$tax[$i]->ittxg_group_name.'</option>';
						        	} ?>
								</select>
							</div>
						</div>
						<!-- <div class="mdl-cel mdl-cell--4-col" style="margin:0px;padding:0px;">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;width:100%;">
								<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="prod_multiple_sn_check"> <span class="mdl-switch__label"><b>Multiple S/N.</b></span> <input type="checkbox" id="prod_multiple_sn_check" class="mdl-switch__input"> </label>
								<input type="text" id="prod_sn" class="" style="text-align: center;width: 100%; padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 10px 0px 16px 0px; border: 1px solid #999;" value="">
							</div>
						</div> -->
						<?php 
							if(isset($edit_invoice_details)) {
							// 	for ($i=0; $i < count($edit_invoice_details) ; $i++) { 
							// 		echo '<div class="mdl-grid" style="border-top:1px solid #999;"><div class="mdl-cell mdl-cell--1-col"	style="border-top: 0px solid #999;padding-top: 10px;"><b>Action</b><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--icon-colored delete_record" id="b'.$edit_invoice_details[$i]->iexteinpd_id.'"><i class="material-icons">delete</i></button></div><div class="mdl-cell mdl-cell--5-col"	style="border-top: 0px solid #999;padding-top: 10px;"><b>Type Product Name</b><ul id="'.($i+1).'" name="product[]" class="type_product"><li>'.$edit_invoice_details[$i]->ip_product.'</li></ul></div><div class="mdl-cell mdl-cell--2-col"	style="border-top: 0px solid #999;padding-top: 10px;"><b style="margin: 10px;">Qty</b><input type="text" id="q'.($i+1).'" name="qty[]" class="mdl-textfield qty_class" style="text-align: center; width: 72%; margin-top: 15px; margin-bottom: 10px; padding: 7px 0px 7px 0px; border-radius: 5px; border: 1px #999 solid;" value="'.$edit_invoice_details[$i]->iexteinpd_qty.'"></div><div class="mdl-cell mdl-cell--2-col"	style="border-top: 0px solid #999;padding-top: 10px;"><b style="margin: 5px;">Rate</b><input type="text" id="r'.($i+1).'" name="rate[]" class="price_class" style="text-align: center; width: 72%; margin-top: 15px; margin-bottom: 10px; padding: 8px 0px 8px 0px; border-radius: 5px;border:1px solid #999;" value="'.$edit_invoice_details[$i]->iexteinpd_rate.'"></div><div class="mdl-cell mdl-cell--2-col"	style="border-top: 0px solid #999;padding-top: 10px;"><b style="margin: 5px;">Discount</b><input type="text" id="d'.($i+1).'" name="disc[]" class="disc_class" style="text-align: center; width: 72%; margin-top: 15px; margin-bottom: 10px; padding: 8px 0px 8px 0px; border-radius: 5px;border:1px solid #999;" value="'.$edit_invoice_details[$i]->iexteinpd_discount.'"></div></div>';
							// 	}
							}
						?>
						<div class="mdl-cell--8-col"></div>
						<div class="mdl-cell mdl-cell--2-col" style="text-align: center;">
							<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="add_prp" style="width: 100%;">Add</button>
						</div>
						<div class="mdl-cell mdl-cell--2-col" style="text-align: center;">
							<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="reset_prp" style="width: 100%;">Reset</button>
						</div>
					</div>
					<div class="mdl-grid">
						<table class="purchase_table">
							<thead>
								<tr style="border: 1px solid #999; box-shadow: 0px 3px 5px #999;">
									<th>Action</th>
									<th>Alias Name</th>
									<th>Product Name</th>
									<th>Rate</th>
									<th>Qty</th>
									<th>Disc</th>
									<th>TAX</th>
								</tr>
							</thead>

							<tbody id="tbl_item">
								<?php 
									if(isset($edit_invoice_details)) {
										for ($i=0; $i < count($edit_invoice_details) ; $i++) { 
											// echo "<tr id='".$i."' style=''>";
											// echo '<td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored  delete" id="'.$i.'"> <i class="material-icons">delete</i> </button><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored edit" id="'.$i.'"> <i class="material-icons">edit</i> </button></td>';
											// echo '<td><input type="checkbox" id="'.$i.'" name="alias[]" ';
											// if ($edit_invoice_details[$i]->iexteqpd_alias == "true") {
											// 	echo "checked";
											// }
											// echo '></td>';
											// echo "<td>".$edit_invoice_details[$i]->ip_product."</td>";
											// echo "<td>".$edit_invoice_details[$i]->iexteqpd_rate."</td>";
											// echo "<td>".$edit_invoice_details[$i]->iexteqpd_qty."</td>";
											// echo "<td>".$edit_invoice_details[$i]->iexteqpd_discount."</td>";
											// // echo "<td style='word-break:break-word;'>".$edit_invoice_details[$i]->iexteinpd_serial_number."</td>";
											// echo "</tr>";

										}
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
		    <div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Select Terms</h2>
				</div>
				<div class="mdl-card__supporting-text">
			        <table style="width:100%;text-align:left;border-spacing:20px;">
                        <tbody id="q_terms">
                            
                        </tbody>			            
			        </table>
			        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	                    <input type="text" id="i_q_terms" class="mdl-textfield__input" value="">
		                <label class="mdl-textfield__label" for="i_q_terms">Enter New Terms here</label>
		            </div>
			    </div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Tags</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<ul id="myTags" class="mdl-textfield__input">
							<?php if (isset($edit_preferences)) {
									for ($j=0; $j < count($edit_preferences) ; $j++) { 
										$x = $edit_preferences[$j]->iexteqt_tag_id;
									
										$y = 0;
										for ($ij=0; $ij < count($tags) ; $ij++) { 
											$m = $tags[$ij]->it_id;
											if($x==$m) {
												$y=$ij;
											}
										}
										echo "<li>".$tags[$y]->it_value."</li>";
									}
								}
							?>
						</ul>
						</div>
					</div>			
				</div>
			</div>
		</div>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--4-col"></div>
			<div class="mdl-cell mdl-cell--4-col">
			<?php if(isset($edit_product)) {
				echo "<a href='".base_url().'Enterprise/delete_invoice/'.$pid."'";
				echo '<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Delete Product</button>';
				echo "</a>";
			}?>
			</div>
			<div class="mdl-cell mdl-cell--4-col"></div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
	<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Enter Email address for <?php if(isset($edit_invoice)) { echo $edit_invoice[0]->ic_name;} ?></h4>
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
    var terms_arr = [];
   	var email_array = [];
    
    $(document).ready( function() {
        
    	var tag_data = [];
    	
    	<?php
    		if (isset($email_ids)) {
    			for ($i=0; $i <count($email_ids) ; $i++) {
    				echo "email_array.push({'email' : '".$email_ids[$i]->icbd_value."','status' : 'false'});";
    			}
    		}

    		for ($i=0; $i < count($tags) ; $i++) { 
    			echo "tag_data.push('".$tags[$i]->it_value."');";
    		}
    	?>
    	email_append();
    	function email_append(){
    		var a = '';
    		$('#exist_email').empty();
    		if (email_array.length > 0) {
    			for (var i = email_array.length - 1; i >= 0; i--) {
    				a+='<tr><td><input type="checkbox" id="'+ i +'"/></td><td>'+ email_array[i].email +'</td></tr>';
    			}
    			$('#exist_email').append(a);
    		}
    	}

    	$('#customer_mail').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                email_array.push({'email' : $('#customer_mail').val(), 'status' : 'true'});
                $(this).val('');
                $(this).focus();
                email_append();
            }
        });

        $('#email_button').click(function(e) {
            e.preventDefault();
            
            email_array.push({'email' : $('#customer_mail').val(), 'status' : 'true'});
            $('#customer_mail').val('');
            $('#customer_mail').focus();
            email_append();
        });

        $('#exist_email').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            email_array[a].status = $(this)[0].checked;
            // console.log(email_array);
        })

    	
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

    	var customer_data = [];
    	<?php
    		for ($i=0; $i < count($customer) ; $i++) { 
    			echo "customer_data.push('".$customer[$i]->ic_name."');";
    		}
    	?>
    	$('#i_name').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : customer_data,
    		tagLimit : 1,
    		singleField : true,
    		afterTagAdded : (function(event, ui) {
    			getoutward(ui.tag[0].innerText);
    		})
    	});

    	var main_tax_array =[];
		<?php for($i=0; $i < count($tax); $i++) {
			echo 'main_tax_array.push({ "tid" : '.$tax[$i]->ittxg_id.', "tname" : "'.$tax[$i]->ittxg_group_name.'"});';
		} ?>


    	var product_data_l = [];
    	<?php
    		for ($i=0; $i < count($product) ; $i++) { 
    			echo "product_data_l.push('".$product[$i]->ip_product."');";
    		}
    	?>
    	$('#prod_name').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : product_data_l,
    		tagLimit : 1,
    		singleField : true,
    		allowDuplicates: true,
    		afterTagAdded : (function(event, ui) {
    			getprice(ui.tag[0].innerText, event.target.id);
    		})
    	});
    	
    	$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

    	<?php 
    		if(!isset($edit_invoice)) {
    			echo "var dt = new Date();";
				echo "var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();";
				echo "$('#i_txn_date').val(s_dt);";
    		}
    	?>

		var product_array=[];
		var alias_array=[];
		var rate_array=[];
    	var qty_array=[];
    	var disc_array=[];
    	// var sn_array=[];
    	var tax_array=[];
    	var tax_id_array=[];
        var edit_index = 0;
        var edit_flag = false;
        var common_disc_flag = false;
        
        
    	<?php 
			if(isset($edit_invoice_details)) {
				for ($i=0; $i < count($edit_invoice_details) ; $i++) { 
					echo "product_array.push('".$edit_invoice_details[$i]->ip_product."');";
					echo "alias_array.push('".$edit_invoice_details[$i]->iexteqpd_alias."');";
					echo "rate_array.push('".$edit_invoice_details[$i]->iexteqpd_rate."');";
					echo "qty_array.push('".$edit_invoice_details[$i]->iexteqpd_qty."');";
					echo "disc_array.push('".$edit_invoice_details[$i]->iexteqpd_discount."');";
					// echo "sn_array.push('".$edit_invoice_details[$i]->iexteinpd_serial_number."');";
					echo "tax_id_array.push('".$edit_invoice_details[$i]->iexteqpd_tax."');";
				}
			}
		?>

        <?php if(isset($terms)) { 
            for($i=0; $i< count($terms); $i++) {
                echo "terms_arr.push('".$terms[$i]->iextdt_term."');";
            } 
        } else if(isset($edit_terms)) {
            for($i=0; $i< count($edit_terms); $i++) {
                echo "terms_arr.push('".$edit_terms[$i]->iexteqtm_terms."');";
            }
        }?>
        
        addtolist();
        
        // $('#i_q_terms').change(function(e) {
        //     e.preventDefault();
            
        //     add_to_array();
        //     load_list();
        //     reset_inputs();
        // });
        
        // $('#q_terms').on('click', ".delete", function(e) {
        //     e.preventDefault();
            
        //     remove_from_array($(this).prop('id'));
        //     load_list();
        //     reset_inputs();
        // });
        
        // function add_to_array() {
        //     terms_arr.push($('#i_q_terms').val());
        // }
        
        // function remove_from_array(id) {
        //     terms_arr.splice(id,1);
        // }
        
        // function load_list() {
        //     $('#q_terms').empty();
            
        //     var out="";
        //     for(var i=0; i < terms_arr.length; i++) {
        //         out+= '<tr><td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="' + i + '"> <i class="material-icons">delete</i> </button></td><td><textarea style="width:100%;resize:vertical;overflow:auto;">' + terms_arr[i] + '</textarea></td></tr>'
        //     }
        //     $('#q_terms').append(out);
        //     componentHandler.upgradeDom();
            
        // }
        
        // function reset_inputs() {
        //     $('#i_q_terms').val('');
        //     $('#i_q_terms').focus();
        // }
        
        
		$('#i_txn_disc').change(function(e) {
		    e.preventDefault();
		    if($(this).val() != "") {
		        common_disc_flag = true;
		    } else {
		        common_disc_flag = false;
		    }
		    
		    $('#prod_disc').val($(this).val());
		});

		$('#cust_print').click(function(e){
	    	e.preventDefault();
	    	window.location = "<?php if (isset($edit_invoice_details)) { echo base_url()."Enterprise/quotation_download/p/".$mod_id."/".$inid;} ?>" ;
	    });

		$('#cust_download').click(function(e){
	    	e.preventDefault();
	    	window.location = "<?php if (isset($edit_invoice_details)) { echo base_url()."Enterprise/quotation_download/d/".$mod_id."/".$inid;} ?>" ;
	    });

	    $('#cust_draft').click(function(e) {
			e.preventDefault();
			
			var customer = [];
			$('#i_name > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					customer.push(tmpstr);
				}
			});

			var txn_no = $('#i_txn_no').val();
			var txn_date = $('#i_txn_date').val();
			var txn_amt = $('#i_txn_amt').val();

			// var products = [];
			// $("ul[name^='product']").each(function(){
			// 	var tmpstr = $(this).text();
			// 	var len = tmpstr.length - 1;
			// 	if(len > 0) {
			// 		tmpstr = tmpstr.substring(0, len);
			// 		products.push(tmpstr);
			// 	}
			// });

			// var qtys = [];
			// $("input[name^='qty'").each(function(){
			// 	qtys.push($(this).val());
			// });

			// var rates = [];
			// $("input[name^='rate'").each(function(){
			// 	rates.push($(this).val());
			// });

			// var disc = [];
			// $("input[name^='disc'").each(function(){
			// 	disc.push($(this).val());
			// });

			// var sn = [];
			// // $("input[name^='sn'").each(function(){
			// // 	sn.push($(this).val());
			// // });

			var txn_tags = [];
			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					txn_tags.push(tmpstr);
				}
			});

			var alias_arr = [];
			$("input[name^='alias']").each(function(){
				alias_arr.push($(this)[0].checked);
			});


			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/update_quotation/1/".$mod_id."/".$inid; } else { echo base_url()."Enterprise/save_quotation/1/".$mod_id; } ?>', {
				'customer' : customer[0],
				'txn_no' : txn_no,
				'txn_date' : txn_date,
				'txn_amt' : txn_amt,
				'txn_note' : $('#i_txn_note').val(),
				'txn_status' : $('#i_txn_status').val(),
				'products' : product_array,
				'qty' : qty_array,
				'rate' : rate_array,
				'disc' : disc_array,
				// 'sn' : sn_array,
				'tax_id' :tax_id_array,
				'alias' : alias_arr,
				'tags' : txn_tags,
				'terms' : terms_arr
			}, function(data, status, xhr) {
				if(status == "success") {
					window.location = '<?php echo base_url()."Enterprise/quotation/".$mod_id."/"; ?>';
				}
			}, 'text');
		});

		function getoutward(customer) {
			$.post('<?php echo base_url()."Enterprise/invoice_inventory_outward"; ?>', {
				'customer' : customer
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#outward').empty();
				var out = "<option value='N/A'>Select</option>";
				for (var i = 0; i < abc.outward.length; i++) {
					out+='<option value="' + abc.outward[i].iextei_id + '">' + abc.outward[i].iextei_txn_id + ' - ' + abc.outward[i].iextei_txn_date + '</option>';
				}

				$('#outward').append(out);
			}, "text");
		}

		function getoutwarddetails(txnid) {
			$.post('<?php echo base_url()."Enterprise/invoice_inventory_outward_details"; ?>', {
				'txnid' : txnid
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				cleararray();
				for (var i = 0; i < abc.details.length; i++) {
					product_array.push(abc.details[i].ip_product);
					alias_array.push('');
		    		rate_array.push(abc.details[i].ipp_sell_price);
		    		qty_array.push(abc.details[i].iexteid_outward);
		    		disc_array.push('');
		    		// sn_array.push(abc.details[i].iexteid_serial_number);
				}

				addtolist();
			}, "text");
		}

		function cleararray() {
			product_array=[];
			alias_array=[];
			rate_array=[];
	    	qty_array=[];
	    	disc_array=[];
	    	// sn_array=[];
	    	tax_array=[];
	    	tax_id_array=[];
		}

		function additemtoarray() {
			product_array.push($('#prod_name')[0].innerText);
			alias_array.push('');
    		rate_array.push($('#prod_rate').val());
    		qty_array.push($('#prod_qty').val());
    		disc_array.push($('#prod_disc').val());
    		// sn_array.push($('#prod_sn').val());
    		tax_id_array.push($('#prod_tax').val());
    		// tax_array=[];
	    	// tax_id_array=[];
		}
    	
    	function addtolist() {
			$('#tbl_item').empty(); var out="";
			for (var i = 0; i < product_array.length; i++) {
				if (alias_array[i] == "true") {
					out+='<tr><td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="' + i + '"> <i class="material-icons">delete</i> </button><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored edit" id="' + i + '"> <i class="material-icons">create</i> </button></td><td><input type="checkbox" id="' + i + '" name="alias[]" checked></td><td>' + product_array[i] + '</td><td>' + rate_array[i] + '</td><td>' + qty_array[i] + '</td><td>' + disc_array[i] + '</td><td style="word-break : break-word;">';
					for (var j = 0; j < main_tax_array.length; j++) {
						if (main_tax_array[j].tid == tax_id_array[i]) {
							out+=main_tax_array[j].tname;
							break;
						}
					}
					out+='</td></tr>';	
				} else {
					out+='<tr><td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="' + i + '"> <i class="material-icons">delete</i> </button><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored edit" id="' + i + '"> <i class="material-icons">create</i> </button></td><td><input type="checkbox" id="' + i + '" name="alias[]"></td><td>' + product_array[i] + '</td><td>' + rate_array[i] + '</td><td>' + qty_array[i] + '</td><td>' + disc_array[i] + '</td><td style="word-break : break-word;">';
					for (var j = 0; j < main_tax_array.length; j++) {
						if (main_tax_array[j].tid == tax_id_array[i]) {
							out+=main_tax_array[j].tname;
							break;
						}
					}
					out+='</td></tr>';
				}
			}
			$('#tbl_item').append(out);
    	}
    	// /*<td style="word-break : break-word;">' + sn_array[i] + '</td>*/
    	function clearallfields() {
    		$('#prod_name > .tagit-choice').remove();
    		$('#prod_rate').val("");
    		$('#prod_qty').val("");
    		if(common_disc_flag == false) {
    		    $('#prod_disc').val("");    
    		}// $('#prod_sn').val("");
    		$('#prod_tax').val("");
    		$('#prod_name').data("ui-tagit").tagInput.focus();
    	}

    	function clearonlysn() {
			$('#prod_sn').val("");
			$('#prod_sn').focus();    		
    	}

    	function deleteitem(id) {
    		product_array.splice(id, 1);
    		alias_array.splice(id, 1);
    		rate_array.splice(id, 1);
    		qty_array.splice(id, 1);
    		disc_array.splice(id, 1);
    		// sn_array.splice(id, 1);
    		tax_array.splice(id,1);
    		tax_id_array.splice(id, 1);
    	}
        
        function edititem(id) {
    	    clearallfields();
    	    
    	    $('#prod_name').append('<li class="tagit-choice ui-widget-content ui-state-default ui-corner-all tagit-choice-editable"><span class="tagit-label">' + product_array[id] + '</span><a class="tagit-close"><span class="text-icon">×</span><span class="ui-icon ui-icon-close"></span></a></li>');
    		$('#prod_rate').val(rate_array[id]);
    		$('#prod_qty').val(qty_array[id]);
    		$('#prod_disc').val(disc_array[id]);
    // 		$('#prod_sn').val(sn_array[id]);
   			$('#prod_tax').val(tax_id_array[id]);

    		edit_index = id;
    		edit_flag = true;
    	}

        function editlist(id) {
            product_array[id] = $('#prod_name')[0].innerText;
			alias_array[id] = "";
    		rate_array[id] = $('#prod_rate').val();
    		qty_array[id] = $('#prod_qty').val();
    		disc_array[id] = $('#prod_disc').val();
    // 		sn_array[id] = $('#prod_sn').val();
        	tax_id_array[id]=$('#prod_tax').val();

        }
        
    	$('#outward').change(function(e) {
    		getoutwarddetails($(this).val());
    	})

    	$('#tbl_item').on('click', '.delete', function(e) {
			e.preventDefault();
			deleteitem($(this).prop('id'));
			addtolist();
		});

		$('#tbl_item').on('click', '.edit', function(e) {
			e.preventDefault();
			//console.log("Okay");
			edititem($(this).prop('id'));

		});


		$('#reset_prp').click(function(e) {
			e.preventDefault();
            edit_index = 0;
            edit_flag = false;
			clearallfields();
		})


		$('#prod_qty').keypress(function(e) {
			if (e.keyCode == 13) {
				if(edit_flag == true) {
			        editlist(edit_index);
			        edit_index = 0;
			        edit_flag = false;
			    } else {
			        additemtoarray();    
			    }
				addtolist();
				// if($('#prod_multiple_sn_check')[0].checked == true) {
				// 	clearonlysn();
				// } else {
					clearallfields();	
				// }	
			}
		});

		$('#prod_sn').keypress(function(e) {
			if (e.keyCode == 13) {
				if(edit_flag == true) {
			        editlist(edit_index);
			        edit_index = 0;
			        edit_flag = false;
			    } else {
			        additemtoarray();    
			    }
				addtolist();
				// if($('#prod_multiple_sn_check')[0].checked == true) {
				// 	clearonlysn();
				// } else {
					clearallfields();	
				// }	
			}
		});

		$('#prod_disc').keypress(function(e) {
			if (e.keyCode == 13) {
				if(edit_flag == true) {
			        editlist(edit_index);
			        edit_index = 0;
			        edit_flag = false;
			    } else {
			        additemtoarray();    
			    }
				addtolist();
				// if($('#prod_multiple_sn_check')[0].checked == true) {
				// 	clearonlysn();
				// } else {
					clearallfields();	
				// }	
			}
		});



		$('#add_prp').click(function(e) {
			e.preventDefault();

			if(edit_flag == true) {
		        editlist(edit_index);
		        edit_index = 0;
		        edit_flag = false;
		    } else {
		        additemtoarray();    
		    }
			addtolist();
			// if($('#prod_multiple_sn_check')[0].checked == true) {
			// 	console.log("SN");
			// 	clearonlysn();
			// } else {
				// console.log("ALL");
				clearallfields();	
			// }

			// prp_count++;
			// var tmppfeature = prp_count;
			// tmppfeature = "#" + tmppfeature;

			// qty_id = "#q" + prp_count;
			// rate_id = "#r" + prp_count;

			// var appenddata = '<div class="mdl-cell mdl-cell--6-col"	style="border-top: 1px solid #999;padding-top: 10px;"><b>Type Product Name</b><ul id="' + prp_count + '" name="product[]" class="type_product"></ul></div><div class="mdl-cell mdl-cell--2-col"	style="border-top: 1px solid #999;padding-top: 10px;"><b style="margin: 5px;">Qty</b><input type="text" id="q' + prp_count + '" name="qty[]" class="mdl-textfield qty_class" style="text-align: center; width: 72%; margin-top: 15px; margin-bottom: 10px; padding: 7px 0px 7px 0px; border-radius: 5px; border: 1px #999 solid;"></div><div class="mdl-cell mdl-cell--2-col"	style="border-top: 1px solid #999;padding-top: 10px;"><b style="margin: 5px;">Rate</b><input type="text" id="r' + prp_count + '" name="rate[]" class="price_class" style="text-align: center; width: 72%; margin-top: 15px; margin-bottom: 10px; padding: 8px 0px 8px 0px; border-radius: 5px;border:1px solid #999;"></div><div class="mdl-cell mdl-cell--2-col"	style="border-top: 1px solid #999;padding-top: 10px;"><b style="margin: 5px;">Discount</b><input type="text" id="d' + prp_count + '" name="disc[]" class="disc_class" style="text-align: center; width: 72%; margin-top: 15px; margin-bottom: 10px; padding: 8px 0px 8px 0px; border-radius: 5px;border:1px solid #999;"></div>'

			// // var appenddata = '<div class="mdl-cell mdl-cell--6-col" style="margin:0px;padding:0px;border:1px #000 solid;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;"><b>Type Product Name</b><ul id="' + tmppfeature + '" name="product[]" class="type_product"></ul></div></div><div class="mdl-cell mdl-cell--3-col" style="margin:1%;width:48%;border:1px #000 solid;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;"><b>Qty</b><input type="text" id="q' + prp_count + '" name="qty[]" class="qty_class" style="text-align: center;width: padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 16px 0px 16px 0px; border: 1px solid #999;"></div></div><div class="mdl-cell mdl-cell--3-col" style="margin:1%;border:1px #000 solid;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;"><b>Rate</b><input type="text" id="r' + prp_count + '" name="rate[]" class="price_class" style="text-align: center;width: 100%; padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 16px 0px 16px 0px; border: 1px solid #999;"></div></div>';

			// <?php 
			// 	// echo 'appenddata+=\'<div class="mdl-cel mdl-cell--8-co" style="margin:0px;padding:0px;width:100%;"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="padding:0px;text-align:left;width:100%;"><b>S/N</b><input type="text" id="s';
			// 	// echo ' + prp_count + ';
			// 	// echo '" name="sn[]" class="" style="text-align: center;width: 100%; padding-top: 9px; padding-bottom: 9px; border-radius: 5px 5px; margin: 16px 0px 16px 0px; border: 1px solid #999;"></div></div>\';';
			// ?>

			// $('#info_repeat').append(appenddata);


			

			// $('#info_repeat').find('ul').css('border', '1px solid #999');
			// var section = [];
			// $('#info_repeat').find('ul').tagit({
	  //   		autocomplete : { delay: 0, minLenght: 5},
	  //   		allowSpaces : true,
	  //   		availableTags : product_data,
	  //   		tagLimit : 1,
	  //   		singleField : true,
	  //   		afterTagAdded : (function(event, ui) {
	  //   			getprice(ui.tag[0].innerText, event.target.id);
	  //   		}),
	  //   		afterTagRemoved : (function(event, ui) {

	  //   		})
	  //   	});

	  //   	$('#info_repeat').find('ul').focus();
			
		});

		function getprice(product, id) {
			$.post('<?php echo base_url()."Enterprise/quotation_get_price/"; ?>', {
				"product" : product
			}, function(data, status, xhr) {
				if(status == "success") {
					$('#prod_rate').val(data);
				}
			}, "text");
		}

		// $('#info_repeat').on('change', '.qty_class', function() {
		// 	var qty = $(this).val();

		// 	var rid = $(this).prop('id');
		// 	rid = rid.substring(1,rid.length);
		// 	rid = "#r" + rid;

		// 	var rate = $(rid).val();

		// 	var amt = qty * rate;

		// 	console.log(amt);
		// });

		<?php 
			// if(isset($edit_invoice_details)) {
			// 	echo "$('#info_repeat').on('click', '.delete_record', function() {";
			// 	echo "var txid = $(this).prop('id');";
			// 	echo "txid = txid.substring(1,txid.length);";
			// 	echo "	$.post('".base_url()."Enterprise/invoice_delete_product/', {";
			// 	echo "'txnid' : txid,";
			// 	echo "'docid' : ".$inid.",";
			// 	echo "}, function(data, status, xhr) {";
			// 	echo "}, 'text');";
			// 	echo "});";
			// }
		?>

		//////////////////////send mail 24/07/2018//////////////////
		var snackbarContainer = document.querySelector('#demo-toast-example');
	    $('#cust_mail').click(function(e){
	       	e.preventDefault();
			$('#myModal').modal('show');
		});

		$('#send_mail').click(function(e){
			e.preventDefault();
			$.post('<?php if (isset($edit_invoice)) echo base_url()."Enterprise/save_quotation_mail/".$mod_id."/".$inid; ?>',
				{'cust_mail_id' : email_array}
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

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var customer = [];
			$('#i_name > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					customer.push(tmpstr);
				}
			});

			var txn_no = $('#i_txn_no').val();
			var txn_date = $('#i_txn_date').val();
			var txn_amt = $('#i_txn_amt').val();

			// var products = [];
			// $("ul[name^='product']").each(function(){
			// 	var tmpstr = $(this).text();
			// 	var len = tmpstr.length - 1;
			// 	if(len > 0) {
			// 		tmpstr = tmpstr.substring(0, len);
			// 		products.push(tmpstr);
			// 	}
			// });

			// var qtys = [];
			// $("input[name^='qty'").each(function(){
			// 	qtys.push($(this).val());
			// });

			// var rates = [];
			// $("input[name^='rate'").each(function(){
			// 	rates.push($(this).val());
			// });

			// var disc = [];
			// $("input[name^='disc'").each(function(){
			// 	disc.push($(this).val());
			// });

			// var sn = [];
			// // $("input[name^='sn'").each(function(){
			// // 	sn.push($(this).val());
			// // });

			var txn_tags = [];
			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					txn_tags.push(tmpstr);
				}
			});

			var alias_arr = [];
			$("input[name^='alias']").each(function(){
				alias_arr.push($(this)[0].checked);
			});


			$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/update_quotation/0/".$mod_id."/".$inid; } else { echo base_url()."Enterprise/save_quotation/0/".$mod_id; } ?>', {
				'customer' : customer[0],
				'txn_no' : txn_no,
				'txn_date' : txn_date,
				'txn_amt' : txn_amt,
				'txn_note' : $('#i_txn_note').val(),
				'txn_status' : $('#i_txn_status').val(),
				'products' : product_array,
				'qty' : qty_array,
				'rate' : rate_array,
				'disc' : disc_array,
				// 'sn' : sn_array,
				'tax_id' :tax_id_array,
				'alias' : alias_arr,
				'tags' : txn_tags,
				'terms' : terms_arr
			}, function(data, status, xhr) {
				if(status == "success") {
					window.location = '<?php echo base_url()."Enterprise/quotation_edit/".$mod_id."/"; ?>' + data;
				}
			}, 'text');
		});
	});
</script>
</html>