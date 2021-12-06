<main class="mdl-layout__content">
	<div class="mdl-grid"  style="overflow: auto;height: 80vh;">
		<div class="mdl-cell mdl-cell--12-col">
			<table class="general_table">
				<thead>
					<tr>
						<th>Sr. NO.</th>
						<th>Product Name</th>
						<th>Qty</th>
						<th>Rate</th>
						<th>Tax</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody class="cart_details"></tbody>
			</table>
		</div>
	</div>
	<div class="mdl-grid" style="height: 10vh;width: 100%:">
		<button class="mdl-button mdl-button--raised place_order" style="border-radius: 10px;width: 100%;background-color: rgba(255, 98, 114, 0.9);color: #fff;">Place order</button>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
	var cart_arr = [];
	var tax_arr = [];
	var grand_total = 0;
	<?php
		if (isset($cart)) {
			for ($i=0; $i < count($cart) ; $i++) { 
				echo "cart_arr.push({'c_id' : '".$cart[$i]->iextetmc_id."' ,'pid' : '".$cart[$i]->iextetmc_pid."' ,'pname' : '".$cart[$i]->ip_product."' , 'qty' : '".$cart[$i]->iextetmc_qty."' , 'rate' : '".$cart[$i]->ipp_sell_price."' , 'tax' : '".$cart[$i]->ittxg_group_name."' , tax_id : '".$cart[$i]->ittxg_id."'});";
			}
		}

		for($m=0; $m < count($taxes); $m++){
			echo "tax_arr.push({'tax' : '".$taxes[$m]->itx_percent."' , 't_gid' : '".$taxes[$m]->itxgc_tg_id."' });";
		}
	?>
	$(document).ready(function(){
		var snackbarContainer = document.querySelector('#demo-toast-example');
		display_cart();
		$('.cart_details').on('keyup','.pro_qty',function(e){
			e.preventDefault();
			var val = Number($(this).val());
			var id = $(this).prop('id');
			cart_arr[id].qty = val;
			display_cart();
		});

		$('.cart_details').on('click','.add_qty',function(e){
			e.preventDefault();
			var id = $(this).prop('id');
			var val = Number($('.product_btn'+id).val()) + 1;
			cart_arr[id].qty = val;
			display_cart();
		});

		$('.cart_details').on('click','.remove_qty',function(e){
			e.preventDefault();
			var id = $(this).prop('id');
			var val = Number($('.product_btn'+id).val()) - 1;
			cart_arr[id].qty = val;
			display_cart();
		});

		$('.place_order').click(function(e){
			e.preventDefault();
			$('.loader').show();
			$.post("<?php echo base_url().'Mobile_app/cosmos_place_order/'.$code; ?>",{
				'cart' : cart_arr,
				'tax' : tax_arr,
				'total_amt' : grand_total
			},function(data,xhr,status){
				$('.loader').hide();
				window.location = '<?php echo base_url().'Mobile_app/cosmos_mobile_cart/'.$code ?>';
			},'text');
		});

	});
	function display_cart(){
		var out = '';
		var sr_no = 0;
		if (cart_arr.length > 0 ) {
			for (var i = 0; i < cart_arr.length; i++) {
				sr_no++;
				out += '<tr>';
				out += '<td>'+sr_no+'</td>';
				out += '<td>'+cart_arr[i].pname+'</td>';
				out += '<td style="width:60%;display:flex;"><button class="mdl-button mdl-button--icon remove_qty" id="'+i+'"><i class="material-icons">remove</i></button><input type="text" class="pro_qty product_btn'+i+'" id="'+i+'" style="width: 80%;text-align: center;outline: none;" value="'+cart_arr[i].qty+'"><button class="mdl-button mdl-button--icon add_qty" id="'+i+'"><i class="material-icons">add</i></button></td>';
				out += '<td>'+cart_arr[i].rate+'</td>';
				out += '<td>'+cart_arr[i].tax+'</td>';
				var tax = 0;
				for (var ij = 0; ij < tax_arr.length; ij++) {
					if(tax_arr[ij].t_gid == cart_arr[i].tax_id){
						tax = Number(tax) + Number(tax_arr[ij].tax);
					}
				}
				var amount = cart_arr[i].qty * cart_arr[i].rate;
				var tax_amount = amount * (tax / 100);
				var Total = amount + tax_amount;
				grand_total = Total + grand_total;
				out += '<td style="text-align:right;">'+Total+'</td>';
				out += '</tr>';
			}
			out += '<tr><td>Total</td><td colspan="5" style="text-align:right;">'+grand_total+'</td></tr>';
		}else{
			out += '<tr><td colspan="6" style="text-align:center;">No Records Found !</td></tr>';
			$('.place_order').css('display','none');
		}
		$('.cart_details').empty();
		$('.cart_details').append(out);
	}
</script>