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
					<a href="#Self-panel" class="mdl-tabs__tab is-active" id="self" style="color:black">Defective OUTWARD</a>
	                <a href="#All-panel" class="mdl-tabs__tab" id="all" style="color:black">Defective inward</a>
	            </div>
	            <div class="mdl-tabs__panel is-active" id="Self-panel">
	            	<div class="mdl-grid">
	            		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
	            			<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name; } ?>" placeholder="Enter Vendor name" style="font-size: 3em;outline: none;">
	            		</div>
	            		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
	            			<div  class="mdl-card mdl-shadow--4dp" style="overflow: auto;height: 50vh;">
								<table class="def_out general_table">
									<thead>
										<tr>
											<th>Action</th>
											<th>Product name</th>
											<th>Serial number</th>
											<th>Date</th>
											<th>Employee Name</th>
											<th>Warranty status</th>
											<th>Charges</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>	
	            		</div>
	            		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="text-align: center;">
	            			<button class="mdl-button mdl-button--colored mdl-button--raised mdl-button--disabled proceed_to_repaired"> Repaired <i class="material-icons">done</i></button>
	            			<button class="mdl-button mdl-button--colored mdl-button--raised mdl-button--disabled proceed_to_out"> Proceed to outward <i class="material-icons">arrow_forward_ios</i></button>
	            		</div>
	            	</div>
	            </div>
	            <div class="mdl-tabs__panel" id="All-panel">
	            	<div class="mdl-grid">
	            		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
	            			<input type="text" id="vend_name" name="vend_name" class="mdl-textfield__input" value="<?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name; } ?>" placeholder="Enter Vendor name" style="font-size: 3em;outline: none;">
	            		</div>
	            		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
	            			<div  class="mdl-card mdl-shadow--4dp" style="overflow: auto;height: 50vh;">
								<table class="def_in general_table">
									<thead>
										<tr>
											<th>Action</th>
											<th>Product name</th>
											<th>Serial number</th>
											<th>Date</th>
											<th>Vendor Name</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>	
	            		</div>
	            		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="text-align: center;">
	            			<button class="mdl-button mdl-button--colored mdl-button--raised mdl-button--disabled proceed_to_in"> Proceed to inward <i class="material-icons">arrow_forward_ios</i></button>
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
</main>
<div class="modal fade" id="warranty_Modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title">Warranty Details</h2>
				</div>
				<div class="modal-body" id="warranty_body"></div>
				<div class="modal-footer">
					<button type="button" class="mdl-button mdl-button--accent" data-dismiss="modal">close</button>
				</div>
			</div>
		</div>
</div>
<div class="modal fade" id="repaired_Modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title">Add comment's</h2>
				</div>
				<div class="modal-body">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input class="mdl-textfield__input" type="text" id="rep_cmnt">
						<label class="mdl-textfield__label" for="customer_mail">Enter comment's</label>
					</div>	
				</div>
				<div class="modal-footer">
					<button type="button" class="mdl-button mdl-button--accent add_repaired"><i class="material-icons">save</i> Save</button>
				</div>
			</div>
		</div>
</div>
<script type="text/javascript">
	var defective_arr = [];
	var def_out = [];
	var cust_list = [];
	var txn_arr = [];
	<?php
		if (isset($def_out)) {
			for ($i=0; $i < count($def_out) ; $i++) {
				echo "def_out.push({'id' : '".$def_out[$i]->iexteid_id."' , 'pid' : '".$def_out[$i]->iexteid_product_id."' , 'pname' : '".$def_out[$i]->ip_product."' , 'sn' : '".$def_out[$i]->iexteid_serial_number."', 'date' : '".$def_out[$i]->iextei_txn_date."' , 'cname' : '".$def_out[$i]->ic_name."' , 'txn_no' : '".$def_out[$i]->iextei_txn_id."' , 'flg' : 'false' , 'amt' : ''  });";
			}
		}
		if (isset($def_sys)) {
			for ($i=0; $i < count($def_sys) ; $i++) {
				echo "defective_arr.push({'id' : '".$def_sys[$i]->iextei_id."' , 'pid' : '".$def_sys[$i]->iexteid_product_id."' , 'pname' : '".$def_sys[$i]->ip_product."' , 'sn' : '".$def_sys[$i]->iexteid_serial_number."', 'date' : '".$def_sys[$i]->iextei_txn_date."' , 'cname' : '".$def_sys[$i]->ic_name."' , 'flg' : 'false' , 'warranty' : 'false' , 'amt' : ''});";
			}
		}

		if (isset($txn_details)) {
			for ($i=0; $i < count($txn_details) ; $i++) { 
				echo "txn_arr.push({'pid' : '".$txn_details[$i]['pid']."', 'sn' : '".$txn_details[$i]['sn']."' ,'warranty' : '".$txn_details[$i]['warranty']."', 'date' : '".$txn_details[$i]['date']."' , 'inid' : '".$txn_details[$i]['inid']."' });";
			}
		}

		if (isset($cust_list)) {
			for ($i=0; $i < count($cust_list) ; $i++) { 
				echo "cust_list.push('".$cust_list[$i]->ic_name."');";
			}
		}
	?>
	$(document).ready( function() {
		display_defective_product();
		display_out_product();
		$("#cust_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_list, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                display_defective_product();
            }
        });

        $("#vend_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_list, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                display_out_product();
            }
        });

		$('.def_out').on('click','.select',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < defective_arr.length; i++) {
				if(defective_arr[i].id == id){
					defective_arr[i].flg = 'true';
				}
			}
			display_defective_product();
		});

		$('.def_out').on('click','.selected',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < defective_arr.length; i++) {
				if(defective_arr[i].id == id){
					defective_arr[i].flg = 'false';
				}
			}
			display_defective_product();
		});

		$('.proceed_to_out').click(function (e) {
			e.preventDefault();
			for (var i = 0; i < defective_arr.length; i++) {
				var amt = $('#w_amt'+defective_arr[i].id).val();
				defective_arr[i].amt = amt;
			}
			$.post('<?php echo base_url()."Enterprise/proceed_to_def_out/def_out/".$code."/"; ?>',{
				'v_name' : $('#cust_name').val(),
				'prod_list' : defective_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory_edit/def_out/".$code."/".$mid."/";?>'+data;
			}, "text");
		});

		$('.proceed_to_repaired').click(function (e) {
			e.preventDefault();
			$('#repaired_Modal').modal('show');
		});

		$('#repaired_Modal').on('click','.add_repaired',function (e) {
			e.preventDefault();
			var cmt = $('#rep_cmnt').val();
			for (var i = 0; i < defective_arr.length; i++) {
				var amt = $('#w_amt'+defective_arr[i].id).val();
				defective_arr[i].amt = amt;
			}
			$.post('<?php echo base_url()."Enterprise/proceed_to_repaired/".$code."/"; ?>',{
				'v_name' : $('#cust_name').val(),
				'prod_list' : defective_arr,
				'comment' : cmt
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory_defective/".$code."/".$mid."/";?>';
			}, "text");
		});

		$('.def_in').on('click','.select',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < def_out.length; i++) {
				if(def_out[i].id == id){
					def_out[i].flg = 'true';
				}
			}
			display_out_product();
		});

		$('.def_in').on('click','.selected',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < def_out.length; i++) {
				if(def_out[i].id == id){
					def_out[i].flg = 'false';
				}
			}
			display_out_product();
		});

		$('.proceed_to_in').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/proceed_to_def_out/def_in/".$code."/"; ?>',{
				'v_name' : $('#vend_name').val(),
				'prod_list' : def_out
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/inventory_edit/def_in/".$code."/".$mid."/";?>'+data;
			}, "text");
		});

		$('.def_out').on('click','.invoice_details',function (e) {
    		e.preventDefault();
    		var inid = $(this).prop('id');
    		$.post('<?php echo base_url()."Enterprise/inventory_purchase_details/".$code."/"; ?>'+inid
    		,function(data, status, xhr) {
				var a = JSON.parse(data);
				var out = '';
				out += '<table class="general_table"><tbody>';
				out += '<tr><td>Purchase Number</td><td>'+a.in_det[0].iextep_txn_id+'</td><tr>';
				out += '<tr><td>Warranty Start Date</td><td>'+a.in_det[0].iextep_txn_date+'</td><tr>';
				var CurrentDate = new Date(a.in_det[0].iextep_txn_date);
				to_date = CurrentDate.setMonth(CurrentDate.getMonth() + Number(a.in_det[0].iextep_warranty) );
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

				$('#warranty_body').empty();
				$('#warranty_body').append(out);
				$('#warranty_Modal').modal('show');
			}, "text");
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

		function display_defective_product(){
			var out = '';
			var flg = 0;
			if (defective_arr.length > 0 ) {
				for (var i = 0; i < defective_arr.length; i++) {
					out += '<tr>';
					if (defective_arr[i].flg == 'false' ) {
						out += '<td><button class="mdl-button mdl-button--colored mdl-button--raised select" id="'+defective_arr[i].id+'">select</button></td>';
					}else{
						flg++ ;
						out += '<td><button class="mdl-button mdl-button--colored mdl-button--raised selected" style="background-color:green;" id="'+defective_arr[i].id+'">selected</button></td>';
					}
					out += '<td>'+defective_arr[i].pname+'</td>';
					out += '<td>'+defective_arr[i].sn+'</td>';
					out += '<td>'+defective_arr[i].date+'</td>';
					out += '<td>'+defective_arr[i].cname+'</td>';
					for (var j = 0; j < txn_arr.length; j++) {
						if(txn_arr[j].pid == defective_arr[i].pid && txn_arr[j].sn == defective_arr[i].sn ){
							var to_date = new Date(txn_arr[j].date);
							to_date = to_date.setMonth(to_date.getMonth() + Number(txn_arr[j].warranty) );
							to_date = new Date(to_date);
							var dd = to_date.getDate();
							var mm = to_date.getMonth()+1;
							var yyyy = to_date.getFullYear();
							if(dd<10) 
							{
							    dd='0'+dd;
							} 

							if(mm<10) 
							{
							    mm='0'+mm;
							}
							to_date = yyyy+'-'+mm+'-'+dd;

							var today = new Date();
							var dd = today.getDate();
							var mm = today.getMonth()+1; 
							var yyyy = today.getFullYear();
							if(dd<10) 
							{
							    dd='0'+dd;
							} 

							if(mm<10) 
							{
							    mm='0'+mm;
							} 
							today = yyyy+'-'+mm+'-'+dd;

							if (to_date >= today) {
								defective_arr[i].warranty = 'true';
								out += '<td><button class="mdl-button invoice_details" style="color:green;" id="'+txn_arr[j].inid+'">In Warranty</button></td>';
								break;
							}else{
								out += '<td><button class="mdl-button invoice_details" style="color:red;" id="'+txn_arr[j].inid+'">Not in Warranty</button></td>';
								defective_arr[i].warranty = 'false';
								break;
							}
						}else{
							out += '<td style="color:red">Not in Warranty</td>';
							break;
						}
					}
					out += '<td><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;"><input type="text" id="w_amt'+defective_arr[i].id+'" name="w_amt" class="mdl-textfield__input" placeholder="Enter Charges" style="outline:none;"></div></td>';
					out += '</tr>';	
				}
			}else{
				out += '<tr><td colspan = "4" style="text-align:center;">No records found !</td></tr>';
			}
			if (flg > 0 ) {
				$('.proceed_to_repaired').removeClass('mdl-button--disabled');
			}else{
				$('.proceed_to_repaired').addClass('mdl-button--disabled');
			}
			if (flg > 0 && $('#cust_name').val() != '' ) {
				$('.proceed_to_out').removeClass('mdl-button--disabled');
			}else{
				$('.proceed_to_out').addClass('mdl-button--disabled');
			}
			$('.def_out > tbody').empty();
			$('.def_out > tbody').append(out);
		}

		function display_out_product() {
			var out = '';
			var flg = 0;
			if (def_out.length > 0) {
				for (var i = 0; i < def_out.length; i++) {
					out += '<tr>';
					if (def_out[i].flg == 'false' ) {
						out += '<td><button class="mdl-button mdl-button--colored mdl-button--raised select" id="'+def_out[i].id+'">select</button></td>';
					}else{
						flg++ ;
						out += '<td><button class="mdl-button mdl-button--colored mdl-button--raised selected" style="background-color:green;" id="'+def_out[i].id+'">selected</button></td>';
					}
					out += '<td>'+def_out[i].pname+'</td>';
					out += '<td>'+def_out[i].sn+'</td>';
					out += '<td>'+def_out[i].date+'</td>';
					out += '<td>'+def_out[i].cname+'</td>';
					out += '</tr>';		
				}
			}else{
				out += '<tr><td colspan = "4" style="text-align:center;">No records found !</td></tr>';
			}
			if (flg > 0 && $('#vend_name').val() != '' ) {
				$('.proceed_to_in').removeClass('mdl-button--disabled');
			}else{
				$('.proceed_to_in').addClass('mdl-button--disabled');
			}
			$('.def_in > tbody').empty();
			$('.def_in > tbody').append(out);
		}
	});
</script>