<div class="mdl-grid" style="overflow: auto;height: 100vh;">
	<div class="mdl-cell mdl-cell--12-col">
		<?php
			if ($product[0]->ipp_timestamp != '') {
				$path = base_url()."assets/uploads/".$oid."/".$product[0]->ipp_timestamp;
				echo '<div class="mdl-card__title mdl-card--expand" style="color:#fff;background : linear-gradient(rgba(20,20,20,.3),rgba(20,20,20, .3)), url('.$path.') no-repeat;background-size: 100%;"></div>';
			}else{
				echo '<div class="mdl-card__title mdl-card--expand" style="background-color: rgba(173, 213, 184, 0.49)">image not found</div>';
			}
		?>
	</div>
	<div class="mdl-cell mdl-cell--4-col">
		<?php
			echo "<p style='font-size:1.5em;'>".$product[0]->ip_product."</p>";
		?>
	</div>
	<div class="mdl-cell mdl-cell--4-col" style="display: flex;font-size: 1em;">
		<div style="width: 60%;text-align: center;">
			<button class="mdl-button mdl-button--icon remove_qty" style="width: 15%;"><i class="material-icons">remove</i></button>
			<input type="text" id="pro_qty" style="width: 30%;text-align: center;outline: none;" value="1">
			<button class="mdl-button mdl-button--icon add_qty" style="width: 15%;"><i class="material-icons">add</i></button>
		</div>
		<div style="width: 40%;text-align: right;">
			<?php
				echo "<p style='font-size:1em;' class='pro_price'>Rs. ".$product[0]->ipp_sell_price."</p>";
			?>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--4-col" style="overflow: auto;">
		<hr>
		<?php
			echo "<p style='font-size:1em;'>".$product[0]->ipai_description."</p>";
		?>
	</div>
	<div class="mdl-cell mdl-cell--4-col" style="overflow: auto;">
		<?php
			for ($i=0; $i < count($p_f) ; $i++) {
				echo "<p style='font-size:1em;'>".$p_f[$i]->ipf_feature."</p>";
			}
		?>
	</div>
</div>
<div class="mdl-grid" style="height: 10vh;width: 100%;">
	<button class="mdl-button mdl-button--raised add_to_cart" style="border-radius: 10px;width: 100%;background-color: rgba(255, 98, 114, 0.9);color: #fff;"><i class="material-icons">add</i> Add to cart</button>
</div>
<script type="text/javascript">
	var p_price = 0;
	var d = 0;
	<?php
		if (isset($product)) {
			echo "p_price = '".$product[0]->ipp_sell_price."';";
		}
	?>
	$(document).ready(function(){

		$('#pro_qty').keyup(function(e){
			e.preventDefault();
			var val = Number($('#pro_qty').val());
			var t_amt = val * p_price;
			$('#pro_qty').val(val);
			$('.pro_price').empty();
			$('.pro_price').append('Rs. '+t_amt);
		});

		$('.add_qty').click(function(e){
			e.preventDefault();
			var val = Number($('#pro_qty').val()) + 1;
			var t_amt = val * p_price;
			$('#pro_qty').val(val);
			$('.pro_price').empty();
			$('.pro_price').append('Rs. '+t_amt);
		});

		$('.remove_qty').click(function(e){
			e.preventDefault();
			var val = Number($('#pro_qty').val()) - 1;
			var t_amt = val * p_price;
			$('#pro_qty').val(val);
			$('.pro_price').empty();
			$('.pro_price').append('Rs. '+t_amt);
		});

		$('.add_to_cart').click(function(e){
			e.preventDefault();
			$('.loader').show();
			$.post("<?php echo base_url().'Mobile_app/cosmos_add_cart/'.$code.'/'.$product[0]->ip_id; ?>",{
				'p_qty' : $('#pro_qty').val()
			},function(data,xhr,status){
				$('.loader').hide();
				$('#mobile_cart').empty();
				$('#mobile_cart').append('<i class="material-icons">shopping_cart</i> Cart<span class="mdl-badge" style="margin-left:15px;" data-badge="'+ data +'"></span>');
			},'text')
		});
	});
</script>