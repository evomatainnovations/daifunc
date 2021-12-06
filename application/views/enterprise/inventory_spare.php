<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
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

	.general_table > tbody > tr > td {
		padding: 15px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
					<a href="#Self-panel" class="mdl-tabs__tab is-active" id="self" style="color:black">Spare Allot</a>
	                <a href="#All-panel" class="mdl-tabs__tab" id="all" style="color:black">Provide Replace</a>
	            </div>
	            <div class="mdl-tabs__panel is-active" id="Self-panel">
	            	<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
								<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name; } ?>" placeholder="Enter Employee name" style="font-size: 3em;outline: none;">
						</div>
						<div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--4-col" style="margin-top: 40px;">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input type="text" id="i_txn_no" name="i_txn_no" class="mdl-textfield__input" value="<?php if(isset($doc_id)) echo $doc_id; ?>">
										<label class="mdl-textfield__label" for="i_txn_no">Enter Transaction Number</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--4-col" style="margin-top: 40px;">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextei_txn_date; }else{ echo date('Y-m-d');} ?>">
										<label class="mdl-textfield__label" for="i_txn_date">Select Date</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--4-col">
					        		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					        			<span>Tags</span>
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
								<div class="mdl-cell mdl-cell--12-col" style="text-align: center; display: inline-flex;">
									<?php
										if(isset($edit_invoice)) {
											echo '<button class="mdl-button mdl-button--accent" style="margin-top : 10px;width : 50%;margin-left : 25%;" id="cust_delete"><i class="material-icons">delete</i> Delete</button>';
										}
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="mdl-grid spare_list" style="display: none;">
						<div class="mdl-cell mdl-cell--12-col spare_title" style="width: 100%;"></div>
						<div class="mdl-cell mdl-cell--12-col" style="width: 100%;">
							<table id="p_list" class="general_table">
								<thead>
									<tr>
										<th>Sr. No</th>
										<th>Date</th>
										<th>Product</th>
										<th>Qty</th>
										<th>Serial No.</th>
										<th>Type</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
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
											<label class="mdl-textfield__label " for="prod_qty">Enter Qty</label>
										</div><br>
										<span class="avl_bal" style="font-weight: bold;"></span>
									</div>
									<div class="mdl-cel mdl-cell--3-col">
										<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
											<input type="text" id="prod_sn" name="prod_sn" class="mdl-textfield__input inv_prod">
											<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="prod_multiple_sn_check"> 
											<span class="mdl-switch__label">Turn on for multiple S/N</span><input type="checkbox" id="prod_multiple_sn_check" class="mdl-switch__input"> </label>
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
										<th>Sr. No</th>
										<th>Product</th>
										<th>Qty</th>
										<th>Serial No.</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
					<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="formal_submit"><i class="material-icons">done</i></button>
	            </div>
	            <div class="mdl-tabs__panel" id="All-panel">
	            	<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;">
										<input type="text" id="e_name" name="e_name" class="mdl-textfield__input">
										<label class="mdl-textfield__label" for="e_name">Employee Name</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
									<div  class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;height: 40vh;">
										<p style="border-bottom: 1px solid #ccc;font-size: 1.5em;margin: 15px;padding: 10px; text-align: center;">Product list of employee </p>
										<div id="d_data" style="overflow: auto;"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;">
										<input type="text" id="c_name" name="c_name" class="mdl-textfield__input">
										<label class="mdl-textfield__label" for="c_name">Customer Name</label>
									</div>
								</div>
								<div class="mdl-cell mdl-cell--12-col">
									<div  class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;height: 40vh;">
										<p style="border-bottom: 1px solid #ccc;font-size: 1.5em;margin: 15px;padding: 10px;">Product list of customer</p>
										<div id="d_property" style="overflow: auto;"></div>
									</div>	
								</div>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--4-col" style="margin-top: 10%;text-align: center;">
							<button class="mdl-button mdl-button--colored re_pro" style="font-size: 1.5em;">Replace <i class="material-icons">arrow_forward_ios</i></button>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div  class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;height: 30vh;">
								<p style="border-bottom: 1px solid #ccc;font-size: 1.5em;margin: 15px;padding: 10px;">Replacement list</p>
								<div class="mdl-grid" id="selected_data" style="width: 100%;overflow: auto;"></div>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col" style="">
							<div  class="mdl-card mdl-shadow--4dp" style="border-radius: 15px;height: 30vh;">
								<p style="border-bottom: 1px solid #ccc;font-size: 1.5em;margin: 15px;padding: 10px;">Ticket list</p>
								<div class="mdl-grid" id="tb_sel_data" style="width: 100%;overflow: auto;"></div>
							</div>		
						</div>
						<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="replace_pro"><i class="material-icons">check</i></button>
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</main>
<div class="modal fade" id="warranty_Modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" id="warranty_body"></div>
				<div class="modal-footer">
					<button type="button" class="mdl-button mdl-button--accent" data-dismiss="modal">close</button>
				</div>
			</div>
		</div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
	<div class="mdl-snackbar__text"></div>
	<button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
	var pro_arr = [];
	var pro_detail = [];
	var cust_list = [];
	var edit_flg = 0;
	var product_list = [];
	var p = 0;
	var tag_data = [];
	var emp_pro_arr = [];
	var cust_pro_arr = [];
	var cust_tkt_arr = [];
	var sel_e_pro = [];
	var sel_c_pro = [];
	var sel_c_tkt = [];
	var replace_arr = [];
	var emp_spare_arr = [];
	var rp_id = 0;
	var tag_sn = [];
	var snackbarContainer = document.querySelector('#demo-toast-example');
	<?php

		if (isset($product_list)) {
			for ($i=0; $i <count($product_list) ; $i++) { 
				for ($j=0; $j < count($product) ; $j++) { 
					if ($product_list[$i]['pid'] == $product[$j]->ip_id) {
						echo "pro_arr.push('".$product[$j]->ip_product."');";
						echo "pro_detail.push({'id' : '".$product[$j]->ip_id."' , 'name' : '".$product[$j]->ip_product."', 'bal' : '".$product_list[$i]['bal']."' });";
					}
				}
			}
		}

		if (isset($edit_invoice)) {
			for ($i=0; $i <count($edit_invoice) ; $i++) { 
				echo "product_list.push({'id' : ".$i.",'pid' : '".$edit_invoice[$i]->ip_id."' ,'product' : '".$edit_invoice[$i]->ip_product."', 'qty' : '".$edit_invoice[$i]->iexteid_balance."','sn' : '".$edit_invoice[$i]->iexteid_serial_number."'});";
			}
		}

		for ($i=0; $i < count($tags) ; $i++) {
			echo "tag_data.push('".$tags[$i]->it_value."');";
		}

		// for ($i=0; $i < count($balance_list) ; $i++) {
		// 	if ($balance_list[$i]->iextei_type == 'inward' || $balance_list[$i]->iextei_type == 'def_in' ) {
		// 		echo "tag_sn.push('".$balance_list[$i]->iexteid_serial_number."');";
		// 	}
		// }

		if (isset($cust_list)) {
			for ($i=0; $i < count($cust_list) ; $i++) { 
				echo "cust_list.push('".$cust_list[$i]->ic_name."');";
			}
		}
	?>

	$(document).ready( function() {
		display_product_list();
		$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		$("#cust_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_list, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_emp_details(value);
            }
        });

        $("#c_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_list, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                cust_pro_details(value);
            }
        });

        $("#e_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_list, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                emp_pro_details(value);
            }
        });

        $("#prod_name" ).autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(pro_arr, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_details(value);
            } 
        });

        $('#cust_delete').click(function(e){
	    	e.preventDefault();
	    	window.location = "<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/delete_inventory/".$code."/".$tid;} ?>" ;
	    });

        $('#pro_formal_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

    	$('#pro_sn_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		tagLimit : 1,
    		availableTags : tag_sn
    	});

        $('#add_prp').click(function(e) {
    		e.preventDefault();
    		additemtoarray();
    	});

		$('#prod_qty').keypress(function(e) {
    		if (e.keyCode == 13) {
    			e.preventDefault();
    			additemtoarray();
    		}
    	});

    	$('#prod_sn').keypress(function(e) {
    		if (e.keyCode == 13) {
    			e.preventDefault();
    			additemtoarray();
    		}
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
			var add_qty = product_list[id].qty;
			var add_pid = product_list[id].pid;

			product_list.splice(id,1);
    		for (var j = 0; j < pro_detail.length; j++) {
				if(pro_detail[j].id == add_pid ){
					pro_detail[j].bal = Number(pro_detail[j].bal) + Number(add_qty);
					break;
				}
			}
    		display_product_list();
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
            }
        });

    	$('#formal_submit').click(function (e) {
    		e.preventDefault();
    		var txn_tags = [];
    		// var mutual = [];
			// $('#mutual_tag > li').each(function(index) {
			// 	var tmpstr1 = $(this).text();
			// 	var len1 = tmpstr1.length - 1;
			// 	if(len1 > 0) {
			// 		tmpstr1 = tmpstr1.substring(0, len1);
			// 		mutual.push(tmpstr1);
			// 	}
			// });
			$('#pro_formal_tag > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					txn_tags.push(tmpstr);
				}
			});
			var type = 'spare';
    		$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/update_inventory/".$tid."/".$code."/"; }else{ echo base_url()."Enterprise/save_inventory/".$code."/";}?>'+type,{
	    		'customer' : $('#cust_name').val(),
				'txn_no' : $('#i_txn_no').val(),
				'txn_date' : $('#i_txn_date').val(),
				'product' : product_list,
				'tags' : txn_tags
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory/".$mid."/".$code;?>';
			}, "text");
    	});

    	$('#d_property').on('click','.invoice_details',function (e) {
    		e.preventDefault();
    		var inid = $(this).prop('id');
    		$.post('<?php echo base_url()."Enterprise/inventory_invoice_details/".$code."/"; ?>'+inid,{
    			'pro_det' : cust_pro_arr
    		},function(data, status, xhr) {
				var a = JSON.parse(data);
				var out = '';
				console.log(a.sub_det);
				out += '<h3>Warranty details</h3>';
				out += '<table class="general_table"><tbody>';
				out += '<tr><td>Invoice Number</td><td>'+a.in_det[0].iextein_txn_id+'</td><tr>';
				out += '<tr><td>Warranty Start Date</td><td>'+a.in_det[0].iextein_txn_date+'</td><tr>';
				var CurrentDate = new Date(a.in_det[0].iextein_txn_date);
				to_date = CurrentDate.setMonth(CurrentDate.getMonth() + Number(a.in_det[0].iextein_warranty) );
				var to_date = new Date(to_date);
				var dd = to_date.getDate();
				var mm = to_date.getMonth()+1;
				var yyyy = to_date.getFullYear();
				if(dd<10){
				    dd='0'+dd;
				} 
				if(mm<10) {
				    mm='0'+mm;
				}
				to_date = yyyy+'-'+mm+'-'+dd;
				out += '<tr><td>Warranty End Date</td><td>'+to_date+'</td><tr>';
				out += '</tbody></table>';

				out += '<h3>Subscription details</h3>';
				if (a.sub_det.length > 0 ) {
					out += '<table class="general_table"><tbody>';
					out += '<tr><td>Subscription Number</td><td>'+a.sub_det[0].iextamc_txn_id+'</td><tr>';
					out += '<tr><td>Subscription Start Date</td><td>'+a.sub_det[0].iextamc_period_from+'</td><tr>';
					out += '<tr><td>Subscription End Date</td><td>'+a.sub_det[0].iextamc_period_to+'</td><tr>';
					if (a.sub_det[0].iextamc_amc_type == 'com') {
						out += '<tr><td>Subscription Type</td><td>Compressive</td><tr>';
					}else{
						out += '<tr><td>Subscription Type</td><td>Non Compressive</td><tr>';
					}
					out += '</tbody></table>';
				}else{
					out += '<h4 style="text-align:center;">Not found subscription details ! </h4>';
				}

				$('#warranty_body').empty();
				$('#warranty_body').append(out);
				$('#warranty_Modal').modal('show');
			}, "text");
    	});

    	$('#d_data').on('click','.p_list',function (e) {
    		e.preventDefault();
    		sel_e_pro = [];
    		$('.p_list').css('background-color','white');
    		$('.p_list').css('color','red');

    		var id = $(this).prop('id');

    		$(this).css('background-color','red');
    		$(this).css('color','white');
    		sel_e_pro.push(id);
    	});

    	$('#d_property').on('click','.c_list',function (e) {
    		e.preventDefault();
    		var id = $(this).prop('id');
    		sel_c_pro = [];
    		$('.c_list').css('background-color','white');
    		$('.c_list').css('color','red');

    		var id = $(this).prop('id');

    		$(this).css('background-color','red');
    		$(this).css('color','white');
    		sel_c_pro.push(id);
    	});

    	$('#tb_sel_data').on('click','.tkt_list',function (e) {
    		e.preventDefault();
    		var id = $(this).prop('id');
    		sel_c_tkt = [];
    		$('.tkt_list').css('background-color','white');
    		$('.tkt_list').css('color','red');

    		var id = $(this).prop('id');

    		$(this).css('background-color','red');
    		$(this).css('color','white');
    		sel_c_tkt.push(id);
    	});

    	$('.re_pro').click(function (e) {
    		e.preventDefault();
    		if (sel_e_pro[0] != undefined && sel_c_pro[0] != undefined ) {
    			replace_arr.push({id : rp_id , e_r_id : sel_e_pro[0] , c_r_id : sel_c_pro[0] , amt : '0' , flg : 'false' });
    			rp_id ++;
    			for (var i = 0; i < emp_pro_arr.length; i++) {
	    			if(emp_pro_arr[i].id == sel_e_pro[0] ){
	    				if (emp_pro_arr[i].bal > 1) {
	    					emp_pro_arr[i].bal = Number(emp_pro_arr[i].bal) - 1;
	    				}else{
	    					emp_pro_arr[i].flg = 'false';
	    					break;
	    				}
	    			}
	    		}
	    		for (var i = 0; i < cust_pro_arr.length; i++) {
	    			if(cust_pro_arr[i].id == sel_c_pro[0] ){
	    				if (cust_pro_arr[i].bal > 1 ) {
	    					cust_pro_arr[i].bal = Number(cust_pro_arr[i].bal) - 1;
	    				}else{
	    					cust_pro_arr[i].flg = 'false';
	    					break;
	    				}
	    			}
	    		}
	    		sel_c_pro = [];
	    		$('.c_list').css('background-color','white');
	    		$('.c_list').css('color','red');

	    		sel_e_pro = [];
	    		$('.p_list').css('background-color','white');
	    		$('.p_list').css('color','red');
	    		display_details();
    		}
    	});

    	$('#selected_data').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var id = $(this).prop('id');
            var status = $(this)[0].checked;
            for (var i = 0; i < replace_arr.length; i++) {
            	if(replace_arr[i].id == id ){
            		replace_arr[i].flg = status;
            		break;
            	}
            }
        });

    	$('#replace_pro').click(function (e) {
    		e.preventDefault();
    		for (var i = 0; i < replace_arr.length; i++) {
    			var amt = $('#w_amt'+replace_arr[i].id).val();
    			if (amt == undefined) {
    				replace_arr[i].amt = '0';
    			}else{
    				replace_arr[i].amt = amt;
    			}
    		}
			$.post('<?php echo base_url()."Enterprise/replace_spare_inventory/".$code."/"; ?>',{
				'cust_name' : $('#c_name').val(),
				'emp_name' : $('#e_name').val(),
	    		'sel_data' : replace_arr,
	    		'sel_c_tkt' : sel_c_tkt
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory_spare/".$code."/".$mid;?>';
			}, "text");
    	});

    	$('#p_list').on('click','.add_defective',function (e) {
    		e.preventDefault();
    		var sid = $(this).prop('id');
    		$.post('<?php echo base_url()."Enterprise/add_spare_defective/".$code."/"; ?>'+sid,
			function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory_spare/".$code."/".$mid;?>';
			}, "text");
    	});
	});

	function additemtoarray() {
		var product = $('#prod_name').val();
		var qty = $('#prod_qty').val();
		var sn = $('#prod_sn').val();
		$('.avl_bal').empty();
		var pro_bal = 0;
		var pro_id = 0;
		for (var i = 0; i < pro_detail.length; i++) {
			if(pro_detail[i].name == product){
				pro_bal = pro_detail[i].bal;
				break;
			}
		}

		if (qty <= pro_bal && qty != 0 ) {
			if($('#prod_multiple_sn_check')[0].checked == true) {
				qty = '1';
			}
			for (var i = 0; i < pro_detail.length; i++) {
				if(pro_detail[i].name == product){
					pro_id = pro_detail[i].id;
					pro_detail[i].bal = Number(pro_detail[i].bal) - Number(qty) ;
					break;
				}
			}

			if (edit_flg == '1') {
    			product_list[edit_id]['product'] = product;
    			product_list[edit_id]['qty'] = qty;
    			product_list[edit_id]['sn'] = sn;
    			edit_flg = 0;
    		}else{
    			product_list.push({'id' : p,'pid' : pro_id ,'product' : product, 'qty' : qty, 'sn' : sn});
    			p++;
    		}
    		clearallfields();
			display_product_list();
		}else{
			var data = {message: 'Please check product qty !'};
	    	snackbarContainer.MaterialSnackbar.showSnackbar(data);
		}
	}

	function clearallfields() {
		if($('#prod_multiple_sn_check')[0].checked == true) {
			$('#prod_qty').val("1");
    		$('#prod_sn').val("");
    		$('#prod_sn').focus();
		}else{
			$('#prod_qty').val("");
    		$('#prod_name').val("");
    		$("#prod_sn").val("");
    		$('#prod_name').focus();
		}
	}

	function display_product_list() {
		var out = '';
		var sr_no = 1;

		for (var i = 0; i < product_list.length; i++) {
			out +='<tr class="no_border"><td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="' + i + '"> <i class="material-icons">delete</i> </button>';
			out +='<button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored edit" id="' + i + '"> <i class="material-icons">edit</i> </button></td><td>'+sr_no+'</td>';
			out += '<td>'+product_list[i].product+'</td><td>'+product_list[i].qty+'</td><td>'+product_list[i].sn+'</td>';
			out +='</tr>';
			sr_no++;
		}

		$('#proposal_list > tbody').empty();
		$('#proposal_list > tbody').append(out);
	}

	function get_details(p_name) {
		$.post('<?php echo base_url()."Enterprise/product_bal_details/".$code; ?>', {
			'p_name' : p_name
		}, function(data, status, xhr) {
			var a = JSON.parse(data);
			tag_sn = [];
			for (var i=0; i < a.balance_list.length ; i++) {
				if (a.balance_list[i].iextei_type == 'inward' || a.balance_list[i].iextei_type == 'def_in' || a.balance_list[i].iextei_type == 'repaired' ) {
					tag_sn.push(a.balance_list[i].iexteid_serial_number);
				}
			}

			$("#prod_sn").autocomplete({
	            source: function(request, response) {
	                var results = $.ui.autocomplete.filter(tag_sn, request.term);
	                response(results.slice(0, 10));
	            },select: function(event, ui) {
	                var value =  ui.item.value;
	                additemtoarray();
	                $(this).val("");
	                return false;
	            }
	        });
			for (var i = 0; i < pro_detail.length; i++) {
				if(pro_detail[i].name == p_name){
					$('.avl_bal').append('Product balance : '+pro_detail[i].bal);
					$('#prod_qty').focus();
					break;
				}
			}
		});
	}

	function get_emp_details(e_name) {
		$.post('<?php echo base_url()."Enterprise/emp_spare_details/".$code; ?>', {
			'e_name' : e_name
		}, function(data, status, xhr) {
			var a = JSON.parse(data);
			var sr_no = 1;
			var out = '';
			emp_spare_arr = [];
			$('.spare_list').css('display','block');
			$('.spare_title').empty();
			$('.spare_title').append('<h3>Spare details of '+e_name+'</h3>');
			for (var i = 0; i < a.defective_list.length; i++) {
				if (a.defective_list[i]['qty'] >= '1') {
					emp_spare_arr.push({id : a.defective_list[i]['inid'] , date : a.defective_list[i]['date'] , pname : a.defective_list[i]['pname'] , sn : a.defective_list[i]['sn'] , bal : a.defective_list[i]['qty'] , type : a.defective_list[i]['type'] });
				}
			}
			display_spare_pro();
		});
	}

	function display_spare_pro() {
		var out = '';
		var sr_no = 1;
		for (var i = 0; i < emp_spare_arr.length; i++) {
			if (emp_spare_arr[i].type == 'defective') {
				out +='<tr class="no_border"><td>'+sr_no+'</td><td>'+emp_spare_arr[i].date+'</td><td>'+emp_spare_arr[i].pname+'</td><td>'+emp_spare_arr[i].bal+'</td><td>'+emp_spare_arr[i].sn+'</td><td>'+emp_spare_arr[i].type+'</td><td><button class="mdl-button mdl-button--raised mdl-button--colored add_defective" id = "'+emp_spare_arr[i].id+'"> add to defective </button></tb></tr>';	
			}else{
				out +='<tr class="no_border"><td>'+sr_no+'</td><td>'+emp_spare_arr[i].date+'</td><td>'+emp_spare_arr[i].pname+'</td><td>'+emp_spare_arr[i].bal+'</td><td>'+emp_spare_arr[i].sn+'</td><td>'+emp_spare_arr[i].type+'</td><td><button class="mdl-button mdl-button--raised mdl-button--colored mdl-button--disabled"> add to defective </button></tb></tr>';	
			}
			sr_no++;
		}
		$('#p_list > tbody').empty();
		$('#p_list > tbody').append(out);
	}

	function emp_pro_details(e_name) {
		$.post('<?php echo base_url()."Enterprise/emp_details/".$code; ?>', {
			'e_name' : e_name
		}, function(data, status, xhr) {
			var a = JSON.parse(data);
			var sr_no = 1;
			var out = '';
			emp_pro_arr = [];
			for (var i = 0; i < a.spare_list.length; i++) {
				if (a.spare_list[i]['type'] != 'defective' ) {
					emp_pro_arr.push({id : a.spare_list[i]['inid'] , pid : a.spare_list[i]['pid'] , p_name : a.spare_list[i]['pname'] , p_sn : a.spare_list[i]['sn'] , flg : 'true' , bal : a.spare_list[i]['qty'] });
				}
			}
			display_details();
		});
	}

	function cust_pro_details(c_name) {
		$.post('<?php echo base_url()."Enterprise/cust_pro_details/".$code; ?>', {
			'e_name' : c_name
		}, function(data, status, xhr) {
			var a = JSON.parse(data);
			var sr_no = 1;

			cust_pro_arr = [];
			cust_tkt_arr = [];
			for (var i = 0; i < a.spare_list.length; i++) {
				cust_pro_arr.push({id : a.spare_list[i]['inid'] , pid : a.spare_list[i]['pid'] , p_name : a.spare_list[i]['pname'] , p_sn : a.spare_list[i]['sn'] , flg : 'true' , bal : a.spare_list[i]['qty'] ,warranty : 'false' , inid : '0' , amc_id : '0' });
			}
			for (var i = 0; i < a.txn_details.length; i++) {
				for (var j = 0; j < cust_pro_arr.length; j++) {
					if(cust_pro_arr[j].pid == a.txn_details[i].pid && cust_pro_arr[j].p_sn == a.txn_details[i].sn ){
						cust_pro_arr[j].inid = a.txn_details[i].inid;
						cust_pro_arr[j].amc_id = a.txn_details[i].amc_id;
						var CurrentDate = new Date(a.txn_details[i].date);
						to_date = CurrentDate.setMonth(CurrentDate.getMonth() + Number(a.txn_details[i].warranty) );
						if (to_date > new Date(a.txn_details[i].date)) {
							cust_pro_arr[j].warranty = 'true';
						}
					}
				}
			}
			if (a.comp_list.length > 0) {
				for (var i = 0; i < a.comp_list.length; i++) {
					cust_tkt_arr.push({sid : a.comp_list[i].ies_id , tkt_no : a.comp_list[i].ies_ticket_id , tkt_date : a.comp_list[i].ies_date , flg : 'true' });
				}
			}
			display_details();
		});
	}

	function display_details() {
		var out = '';
		if (emp_pro_arr.length > 0) {
			for (var i = 0; i < emp_pro_arr.length; i++) {
				if (emp_pro_arr[i].flg == 'true') {
					for (var j = 0; j < emp_pro_arr[i].bal ; j++) {
						out += '<button class="mdl-button mdl-button--colored p_list" id = "'+emp_pro_arr[i].id+'" style="width:100%;">'+emp_pro_arr[i].p_name+' - S/N : '+emp_pro_arr[i].p_sn+'</button>';
					}
				}
			}
		}
		$('#d_data').empty();
		$('#d_data').append(out);

		var out = '';
		if (cust_pro_arr.length > 0) {
			out += '<table><tbody>';
			for (var i = 0; i < cust_pro_arr.length; i++) {
				if (cust_pro_arr[i].flg == 'true') {
					for (var j = 0; j < cust_pro_arr[i].bal ; j++) {
						out += '<tr>';
						out += '<td><button class="mdl-button mdl-button--colored c_list" id = "'+cust_pro_arr[i].id+'" style="width:100%;">'+cust_pro_arr[i].p_name+' - S/N : '+cust_pro_arr[i].p_sn+'</button></td>';
						if (cust_pro_arr[i].warranty == 'true') {
							out += '<td><button class="mdl-button mdl-button--colored invoice_details" id="'+cust_pro_arr[i].id+'" style="width:100%;color:green;">In warranty</button></td>';
						}else{
							out += '<td><button class="mdl-button mdl-button--colored invoice_details" id="'+cust_pro_arr[i].id+'"  style="width:100%;">Not in warranty</button></td>';
						}
						out += '</tr>';
					}
				}
			}
			out += '</tbody></table>';
		}
		$('#d_property').empty();
		$('#d_property').append(out);

		var out = '';
		if (cust_tkt_arr.length > 0) {
			for (var i = 0; i < cust_tkt_arr.length; i++) {
				out += '<button class="mdl-button mdl-button--colored tkt_list" id = "'+cust_tkt_arr[i].sid+'" style="width:100%;">'+cust_tkt_arr[i].tkt_no+' / '+cust_tkt_arr[i].tkt_date+'</button>';
			}
		}
		$('#tb_sel_data').empty();
		$('#tb_sel_data').append(out);

		var out = '';
		if (replace_arr.length > 0) {
			out += '<table class="general_table"><thead><th>From product id</th><th>To product id</th><th>Defective or not</th><th>Charges</th></thead><tbody>';
			for (var j = 0; j < replace_arr.length; j++) {
				out += '<tr>'
				for (var i = 0; i < emp_pro_arr.length; i++) {
					if (replace_arr[j].e_r_id == emp_pro_arr[i].id) {
						out += '<td>'+emp_pro_arr[i].p_name+' - S/N : '+emp_pro_arr[i].p_sn+'</td>';
					}
				}
				for (var i = 0; i < cust_pro_arr.length; i++) {
					if (replace_arr[j].c_r_id == cust_pro_arr[i].id) {
						out += '<td>'+cust_pro_arr[i].p_name+' - S/N : '+cust_pro_arr[i].p_sn+'</td>';
						out += '<td><input type = "checkbox" id = "'+replace_arr[j].id+'" class = "mdl-checkbox__input"></h4></td>';
						if (cust_pro_arr[i].warranty == 'false' ) {
							out += '<td><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;"><input type="text" id="w_amt'+replace_arr[j].id+'" name="w_amt" class="mdl-textfield__input" placeholder="Enter Charges" style="outline:none;"></div></td>';
						}else{
							out += '<td>No Charges</td>';
						}
					}
				}
				out += '</tr>'
			}
			out += '</tbody></table>';
		}

		$('#selected_data').empty();
		$('#selected_data').append(out);
	}
</script>