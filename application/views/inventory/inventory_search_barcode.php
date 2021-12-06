<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 15px;">
			<input type="text" id="barcode_search" class="mdl-textfield__input" style="font-size: 2em;outline: none;" placeholder="Search by barcode">
		</div>
		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet barcode_details" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 15px;height: 75vh;overflow: auto;"></div>
	</div>
</main>
<div class="modal fade" id="cust_name_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<h3 class="modal-title">Please enter customer name </h3>
			</div>
			<div class="modal-body" style="text-align: center;">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" data-type="date" id="c_name" class="mdl-textfield__input">
					<label class="mdl-textfield__label" for="c_name">Enter customer name</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="p_t_out"><i class="material-icons">arrow_forward</i> Proceed</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var acc_name = '';
	var acc_product = [];
	var customer_data = [];
	var acc_arr = [];
	var barcode_type = '';
	<?php
		for ($i=0; $i < count($customer) ; $i++) { 
			echo "customer_data.push('".$customer[$i]->ic_name."');";
		}
	?>
	$(document).ready(function (){

		$("#c_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(customer_data, request.term);
                response(results.slice(0, 10));
            }
        });

		$('#barcode_search').keyup(function(e){
			e.preventDefault();
			if (e.keyCode == 13) {
				$.post('<?php echo base_url()."Inventory/get_barcode_details/".$code; ?>',{
					'barcode' : $(this).val()
				},function(data,status,xhr){
					var a = JSON.parse(data);
					acc_product = [];
					if (a.acc_det) {
						acc_name = a.acc_det[0].iia_name;
						for (var i = 0; i < a.acc_pro.length; i++) {
							acc_product.push({'id' : a.acc_pro[i].id , 'name' : a.acc_pro[i].name , 'bal' : a.acc_pro[i].bal , 'flg' : 'false'});
						}
						barcode_type = 'account';
						display_account_product_list();
					}else{
						acc_arr = [];
						barcode_type = 'product';
						pro_name = a.pro_det[0].ip_product;
						for (var i = 0; i < a.pro_acc.length; i++) {
							acc_arr.push({'id' : a.pro_acc[i].aid , 'name' : a.pro_acc[i].account , 'bal' : a.pro_acc[i].bal , 'flg' : 'false'});
						}
						display_product_account_list();
					}
				},'text');
			}
		});

		$('.barcode_details').on('click','.select',function(e){
			e.preventDefault();
			var id = $(this).prop('id');
			acc_product[id].flg = 'true';
			display_account_product_list();
		});

		$('.barcode_details').on('click','.selected',function(e){
			e.preventDefault();
			var id = $(this).prop('id');
			acc_product[id].flg = 'false';
			display_account_product_list();
		});

		$('.barcode_details').on('click','.pro_to_outward',function(e){
			e.preventDefault();
			$('#cust_name_modal').modal('show')
		});

		$('#cust_name_modal').on('click','#p_t_out',function(e){
			e.preventDefault();
			if (barcode_type == 'account') {
				account_to_outward();
			}else{
				product_to_outward();
			}
		});

		function account_to_outward(){
			$.post('<?php echo base_url()."Inventory/proceed_to_outward/".$code; ?>',{
				'c_name' : $('#c_name').val(),
				'p_arr' : acc_product,
				'acc_name' : acc_name
			},function(data,status,xhr){
				window.location = '<?php echo base_url()."Inventory/inventory_edit/outward/".$code."/".$mod_id."/"; ?>'+data;
			},'text');
		}

		function product_to_outward(){
			$.post('<?php echo base_url()."Inventory/proceed_to_outward_product/".$code; ?>',{
				'c_name' : $('#c_name').val(),
				'p_name' : pro_name,
				'acc_arr' : acc_arr
			},function(data,status,xhr){
				window.location = '<?php echo base_url()."Inventory/inventory_edit/outward/".$code."/".$mod_id."/"; ?>'+data;
			},'text');
		}

		$('.barcode_details').on('click','.select_acc',function(e){
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < acc_arr.length; i++) {
				acc_arr[i].flg = 'false';
			}
			acc_arr[id].flg = 'true';
			display_product_account_list();
		});

		function display_account_product_list(){
			var out = "";
			out += '<div><h3>'+acc_name+'</h3></div>';
			flg = 'false';
			for (var i = 0; i < acc_product.length; i++) {
				if (acc_product[i].flg == 'true') {
					flg = 'true';
				}
			}
			if (flg == 'true') {
				out += '<div style="padding:20px;"><button class="mdl-button mdl-button--colored mdl-button--raised pro_to_outward" style="background-color:green;"><i class="material-icons">arrow_forward</i>Proceed to outward</button></div>';
			}
			out += '<table class="general_table">';
			out += '<thead><th>Sr. No.</th><th>Product Name</th><th>Balance</th><th>Select</th></thead><tbody>';
			var sr_no = 1;
			if (acc_product.length > 0 ) {
				for (var i = 0; i < acc_product.length; i++) {
					out += '<tr><td>'+sr_no+'</td><td>'+acc_product[i].name+'</td><td>'+acc_product[i].bal+'</td><td>';
					if (acc_product[i].flg == 'false') {
						out += '<button class="mdl-button mdl-button--colored mdl-button--raised select" id="'+i+'"><i class="material-icons">clear</i></button>';
					}else{
						out += '<button class="mdl-button mdl-button--colored mdl-button--raised selected" id="'+i+'" style="background-color:green;"><i class="material-icons">add</i></button>';
					}
					out += '</td></tr>';
					sr_no++;
				}
			}
			out += '</tbody></table>';
			$('.barcode_details').empty();
			$('.barcode_details').append(out);
		}

		function display_product_account_list(){
			var out = "";
			out += '<div><h3>'+pro_name+'</h3></div>';
			flg = 'false';
			for (var i = 0; i < acc_arr.length; i++) {
				if (acc_arr[i].flg == 'true') {
					flg = 'true';
				}
			}
			if (flg == 'true') {
				out += '<div style="padding:20px;"><button class="mdl-button mdl-button--colored mdl-button--raised pro_to_outward" style="background-color:green;"><i class="material-icons">arrow_forward</i>Proceed to outward</button></div>';
			}
			out += '<table class="general_table">';
			out += '<thead><th>Sr. No.</th><th>Account Name</th><th>Balance</th><th>Select</th></thead><tbody>';
			var sr_no = 1;
			if (acc_arr.length > 0 ) {
				for (var i = 0; i < acc_arr.length; i++) {
					out += '<tr><td>'+sr_no+'</td><td>'+acc_arr[i].name+'</td><td>'+acc_arr[i].bal+'</td><td>';
					if (acc_arr[i].flg == 'false') {
						out += '<button class="mdl-button mdl-button--colored mdl-button--raised select_acc" id="'+i+'"><i class="material-icons">clear</i></button>';
					}else{
						out += '<button class="mdl-button mdl-button--colored mdl-button--raised select_acc" id="'+i+'" style="background-color:green;"><i class="material-icons">add</i></button>';
					}
					out += '</td></tr>';
					sr_no++;
				}
			}
			out += '</tbody></table>';
			$('.barcode_details').empty();
			$('.barcode_details').append(out);
		}
	});
</script>