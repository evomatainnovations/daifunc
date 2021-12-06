<style type="text/css">
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
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-grid">
				<div class="mdl-cel mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="prod_name" class="mdl-textfield__input inv_prod">
						<label class="mdl-textfield__label" for="prod_name">Enter Product Name</label>
					</div>
				</div>
				<div class="mdl-cel mdl-cell--3-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="prod_title" class="mdl-textfield__input inv_prod">
						<label class="mdl-textfield__label" for="prod_name">Enter title</label>
					</div>
				</div>
				<div class="mdl-cel mdl-cell--2-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="prod_qty" class="mdl-textfield__input inv_prod">
						<label class="mdl-textfield__label" for="prod_qty">Qty</label>
					</div><br>
					<span class="avl_bal" style="font-weight: bold;"></span>
				</div>
				<div class="mdl-cel mdl-cell--2-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="prod_code" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="prod_code">Enter Code</label>
					</div>
				</div>
				<div class="mdl-cel mdl-cell--2-col" style="text-align: center;">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="barcode_type">
							<option value="none">Select</option>
							<option value="individual">Individual</option>
							<option value="same">Same</option>
						</select>
						<label class="mdl-textfield__label" for="barcode_type">Select Barcode Type</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<button class="mdl-button mdl-button--raised" id="add_prp" style="width: 100%;" ><i class="material-icons">done</i></button>
				</div>
			</div>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cel mdl-cell--12-col" style="overflow: auto;">
			<table class="general_table">
				<thead>
					<tr>
						<th>Sr. no</th>
						<th>Product name</th>
						<th>Date</th>
						<th>Qty</th>
						<th>Barcode Type</th>
						<th>Title</th>
						<th>Code</th>
						<th>Print</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody class="barcode_list"></tbody>
			</table>
		</div>
	</div>
	<div class="mdl-grid barcode_img" style="margin: auto;text-align: center;margin-top: 10%;margin-left: 10%;"></div>
</main>
<script type="text/javascript">
	var product_data_l = [];
	var barcode_arr = [];
	var edit_flg = 0 ;
	var edit_id = 0 ;
	<?php
		if (isset($barcode)) {
			for ($i=0; $i < count($barcode) ; $i++) {
				$flg = 0;
				for ($ij=0; $ij < count($product) ; $ij++) { 
					if ($product[$ij]->ip_id == $barcode[$i]->iextb_pid ) {
						echo "barcode_arr.push({'id' : '".$barcode[$i]->iextb_id."' , 'pname' : '".$product[$ij]->ip_product."' , 'qty' : '".$barcode[$i]->iextb_qty."' , 'type' : '".$barcode[$i]->iextb_barcode_type."' , 'code' : '".$barcode[$i]->iextb_code."' , 'date' : '".date('Y-m-d' , strtotime($barcode[$i]->iextb_created) )."' , 'title' : '".$barcode[$i]->iextb_title."' });";
					}else{
						$flg = 1;
					}
				}
				if ($flg == 1) {
					echo "barcode_arr.push({'id' : '".$barcode[$i]->iextb_id."' , 'pname' : '' , 'qty' : '".$barcode[$i]->iextb_qty."' , 'type' : '".$barcode[$i]->iextb_barcode_type."' , 'code' : '".$barcode[$i]->iextb_code."' , 'date' : '".date('Y-m-d' , strtotime($barcode[$i]->iextb_created) )."' , 'title' : '".$barcode[$i]->iextb_title."' });";
				}
			}
		}

		if ($product) {
			for ($i=0; $i < count($product) ; $i++) { 
    			echo "product_data_l.push('".$product[$i]->ip_product."');";
    		}
		}
	?>
	$(document).ready( function() {
		display_barcode_details();
		$("#prod_name" ).autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(product_data_l, request.term);
                response(results.slice(0, 10));
            }
        });

        $('#add_prp').click(function (e) {
        	e.preventDefault();
        	var url = '';
        	if (edit_flg == 1) {
        		url = '<?php echo base_url()."Barcoding/update_barcode/".$code."/"; ?>'+edit_id;
        	}else{
				url = '<?php echo base_url()."Barcoding/save_barcode/".$code."/"; ?>';
        	}
        	$.post(url,{
				'p_name' : $('#prod_name').val(),
				'p_qty' : $('#prod_qty').val(),
				'p_type' : $('#barcode_type').val(),
				'p_title' : $('#prod_title').val(),
				'p_code' : $('#prod_code').val()
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				barcode_arr = [];
				edit_flg = 0 ;
				$('#prod_name').val('');
				$('#prod_qty').val('');
				$('#barcode_type').val('none');
				$('#prod_code').val('');
				$('#prod_title').val('');
				$('#prod_name').focus();
				if (a.barcode_list.length > 0 ) {
					for (var i = 0; i < a.barcode_list.length; i++) {
						var flg = 0;
						for (var ij = 0; ij < a.product.length; ij++) {
							if(a.product[ij].ip_id == a.barcode_list[i].iextb_pid ){
								barcode_arr.push({id : a.barcode_list[i].iextb_id , pname : a.product[ij].ip_product , qty : a.barcode_list[i].iextb_qty , type : a.barcode_list[i].iextb_barcode_type , code : a.barcode_list[i].iextb_code , date : a.barcode_list[i].date1 ,title : a.barcode_list[i].iextb_title});
							}else{
								flg = 1;
							}
						}
						if (flg = 1) {
							barcode_arr.push({id : a.barcode_list[i].iextb_id , pname : '' , qty : a.barcode_list[i].iextb_qty , type : a.barcode_list[i].iextb_barcode_type , code : a.barcode_list[i].iextb_code , date : a.barcode_list[i].date1 ,title : a.barcode_list[i].iextb_title});
						}
					}
				}
				display_barcode_details();
			}, "text");	
        });

        $('.barcode_list').on('click','.barcode_delete',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	$.post('<?php echo base_url()."Barcoding/delete_barcode/".$code."/"; ?>'+id,
			function(data, status, xhr) {
				var a = JSON.parse(data);
				barcode_arr = [];
				if (a.barcode_list.length > 0 ) {
					for (var i = 0; i < a.barcode_list.length; i++) {
						var flg = 0;
						for (var ij = 0; ij < a.product.length; ij++) {
							if(a.product[ij].ip_id == a.barcode_list[i].iextb_pid ){
								barcode_arr.push({id : a.barcode_list[i].iextb_id , pname : a.product[ij].ip_product , qty : a.barcode_list[i].iextb_qty , type : a.barcode_list[i].iextb_barcode_type , code : a.barcode_list[i].iextb_code , date : a.barcode_list[i].date1 ,title : a.barcode_list[i].iextb_title});
							}else{
								flg = 1;
							}
						}
						if (flg = 1) {
							barcode_arr.push({id : a.barcode_list[i].iextb_id , pname : '' , qty : a.barcode_list[i].iextb_qty , type : a.barcode_list[i].iextb_barcode_type , code : a.barcode_list[i].iextb_code , date : a.barcode_list[i].date1 ,title : a.barcode_list[i].iextb_title});
						}
					}
				}
				display_barcode_details();
			}, "text");	
        });

        $('.barcode_list').on('click','.barcode_print',function (e) {
        	e.preventDefault();
        	$('.loader').show();
        	var id = $(this).prop('id');
        	$.post('<?php echo base_url()."Barcoding/print_barcode/".$code."/"; ?>'+id,
			function(data, status, xhr) {
				$('.loader').hide();
				window.location = '<?php echo base_url().'assets/data/'.$oid.'/barcode/'; ?>'+data;
			}, "text");	
        });


        $('.barcode_list').on('click','.barcode_edit',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	for (var i = 0; i < barcode_arr.length; i++) {
        		if(barcode_arr[i].id == id){
        			$('#prod_name').val(barcode_arr[i].pname);
					$('#prod_qty').val(barcode_arr[i].qty);
					$('#barcode_type').val(barcode_arr[i].type);
					$('#prod_code').val(barcode_arr[i].code);
					$('#prod_title').val(barcode_arr[i].title);
					break;
        		}
        	}
        	edit_flg = 1;
        	edit_id = id;
        });

		function display_barcode_details() {
			var out = '';
			var srno = 1;
			if (barcode_arr.length > 0 ) {
				for (var i = 0; i < barcode_arr.length; i++) {
					out += '<tr>';
					out += '<td>'+srno+'</td>';
					out += '<td>'+barcode_arr[i].pname+'</td>';
					out += '<td>'+barcode_arr[i].date+'</td>';
					out += '<td>'+barcode_arr[i].qty+'</td>';
					out += '<td>'+barcode_arr[i].type+'</td>';
					out += '<td>'+barcode_arr[i].title+'</td>';
					out += '<td>'+barcode_arr[i].code+'</td>';
					out += '<td><button class="mdl-button mdl-button--colored barcode_print" id="'+barcode_arr[i].id+'"><i class="material-icons">print</i> Print</button></td>';
					out += '<td><button class="mdl-button mdl-button--colored barcode_edit" id="'+barcode_arr[i].id+'"><i class="material-icons">edit</i> Edit</button><button class="mdl-button mdl-button--colored barcode_delete" id="'+barcode_arr[i].id+'"><i class="material-icons">delete</i> delete</button></td>';
					out += '</tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="8" style="text-align:center;">No records found !</td></tr>';
			}

			$('.barcode_list').empty();
			$('.barcode_list').append(out);
		}
	});
</script>