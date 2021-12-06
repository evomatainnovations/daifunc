<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-grid" id="display_cat"></div>
			<div class="mdl-grid" id="display_product"></div>
		</div>
	</div>
</main>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
</body>
<script type="text/javascript">

	var cat_arr = [];
	var product_arr = [];
	var cat_list = [];
	<?php
		if (isset($cat_list)) {
			for ($i=0; $i <count($cat_list) ; $i++) { 
				echo "cat_list.push({'id':'".$cat_list[$i]->iproc_id."','name':'".$cat_list[$i]->iproc_name."','img':'".$cat_list[$i]->iproc_img."'});";
			}
		}

		if (isset($product)) {
			for ($i=0; $i <count($product) ; $i++) { 
				echo "product_arr.push({'id':'".$product[$i]->ip_id."','name':'".$product[$i]->ip_product."','img':'".$product[$i]->ipp_timestamp."' , 'amt' : '".$product[$i]->ipp_sell_price."' });";
			}
		}
	?>
	$(document).ready(function() {
		console.log(product_arr);
		var snackbarContainer = document.querySelector('#demo-toast-example');
		display_cat();
		$('#display_cat').on('click','.categories',function (e) {
			e.preventDefault();
			window.location = '<?php echo base_url()."Mobile_app/cosmos_product_home/".$mid."/".$code."/";?>'+$(this).prop('id');
		});

		$('#display_product').on('click', '.products', (function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Mobile_app/cosmos_product_details/'.$code."/"; ?>" + $(this).prop('id');
		}));

		function display_cat(){
			var a='';
			if (cat_list.length > 0 ) {
				for (var i=0; i < cat_list.length ; i++) {
					a+='<div class="mdl-cell mdl-cell--4-col categories" id="'+cat_list[i].id+'">';
					a+='<div class= mdl-card mdl-shadow--4dp" style="border-radius:10px;min-height:20%;">';
					if(cat_list[i].img != '') {
						var path = '<?php echo base_url()."assets/uploads/".$oid."/"; ?>'+cat_list[i].img;
						a+='<div class="mdl-card__title mdl-card--expand" style="height:50px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url('+path+');background-size: 100%;">';
					} else {
						a+='<div class="mdl-card__title mdl-card--expand" style="height:40px;">';
					}
					a+='<h2 class="mdl-card__title-text">'+cat_list[i].name+'</h2>';
					a+='</div>';
					a+='</div>';
					a+='</div>';
				}
				$('#display_cat').empty();
				$('#display_cat').append(a);
			}else{
				$('#display_cat').css('display','none');
			}	
			a= '';
			if (product_arr.length > 0 ) {
				if (cat_list.length > 0 ) {
					a+= '<h4>Products</h4>';
				}
				for (var i = 0; i < product_arr.length; i++) {
					a+='<div class="mdl-cell mdl-cell--4-col products" id="'+product_arr[i].id+'">';
					a+='<div class= mdl-card mdl-shadow--4dp" style="border-radius:10px;min-height:20%;">';
					if(product_arr[i].img != '') {
						var path = '<?php echo base_url()."assets/uploads/".$oid."/"; ?>'+product_arr[i].img;
						a+='<div class="mdl-card__title mdl-card--expand" style="height:50px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url('+path+');background-size: 100%;">';
					} else {
						a+='<div class="mdl-card__title mdl-card--expand" style="height:20%;">';
					}
					a+= '<h2 class="mdl-card__title-text">'+product_arr[i].name+'</h2>';
					a+= '</div>';
					a+='</div>';
					a+='</div>';	
				}
			}
			$('#display_product').empty();
			$('#display_product').append(a);
		}
	});
</script>
</html>