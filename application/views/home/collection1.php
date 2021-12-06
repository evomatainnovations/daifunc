<style type="text/css">
	.demo-card-image__filename {
	  color: #000;
	  font-size: 1.5em;
	  font-weight: 500;
	}
	.modal-dialog {
        z-index: 10000000 !important;
    }
    .modal-content{
        border-radius: 0px;
        box-shadow: 1px 5px 77px #000;
    }

    .modal-header{
        padding: 30px;
        padding-bottom: 0px;
    }

    .modal{
        padding-left: 0px;
    }

    .modal-body {
	    max-height: 60%;
	    overflow-y: auto;
	}

    .btn-explore-inventory {
        background-color: #fff;
        color: #404040;
        border: 2px solid #999;
        padding: 10px 30px 10px 30px;
        border-radius: 15px;
        margin: 5px;
        font-weight: bold;
    }
    .loader {
		position: fixed;
	    border: 5px solid #f3f3f3;
		-webkit-animation: spin 2s linear infinite;
		animation: spin 1s linear infinite;
		border-top: 5px solid #555;
		border-radius: 50%;
		width: 50px;
		height: 50px;
		left: 47%;
		top: 50%;
		z-index: 1000000 !important;
	}

	.done {
	    background-color: #4CAF50;
	    border: none;
	    color: white;
	    padding: 20px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 16px;
	    margin: 4px 2px;
	    border-radius: 50%;
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
<main>
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid select">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<select id="select_collection" name="select_collection" class="mdl-textfield__input">
					<option value="none">Select collection</option>
					<option value="p_coll">Package collection</option>
					<option value="m_coll">Module collection</option>
				</select>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label cat1" style="display: none;">
				<select id="cat1_collection" name="cat2_collection" class="mdl-textfield__input"></select>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label cat2" style="display: none;">
				<select id="cat2_collection" name="cat2_collection" class="mdl-textfield__input"></select>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
			<button class="mdl-button mdl-js-button" id="my_modules" style="font-size: 1.2em;margin-right: 10px;">Renew</button>
		</div>
		<div class="mdl-cell mdl-cell--4-col" style="text-align: right;">
			<button class="mdl-button mdl-js-button" id="my_cart" style="font-size: 1.2em;"><i class="material-icons">shopping_cart</i> Cart</button>
		</div>
	</div>
	<div class="mdl-grid collection" style="width: 100%;display: flex;"></div>
	<div class="mdl-grid mod_collection" style="width: 100%;display: flex;"></div>
</main>
</body>
<div class="modal fade" id="collection_Modal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<button type="button" class="close" data-dismiss="modal"><i class="material-icons">close</i></button>	
					</div>
				</div>
				<div class="mdl-grid" id="modal_body"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal" id="cart_details_modal" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>My cart <button type="button" class="mdl-button close" data-dismiss="modal">&times;</button></h2>
            </div>
            <div class="modal-body cart"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div class="modal" id="module_details_modal" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>My modules <button type="button" class="mdl-button close" data-dismiss="modal">&times;</button></h2>
            </div>
            <div class="modal-body module"></div>
            <div class="modal-footer">
	        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pay_success" role="dialog" data-backdrop="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mdl-grid" id="modal_body">
					<div class="mdl-cell mdl-cell--12-col">
						<h1 style="color: green;text-align: center;"><button class="button done"><i class="material-icons">done</i></button>  Payment Successful.</h1>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<h4 style="text-align: center;">We have emailed you the receipt.</h4>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<?php
							if (isset($txn)) {
								echo '<table id="proposal_list" class="general_table"><tr><td>Reference ID </td><td>:</td><td>'.$txn[0]->iutxn_timestamp.'</td></tr><tr><td>Amount </td><td style="text-align:left;">:</td><td>';
								echo (int)$txn[0]->iutxn_amount/100;
								echo '</td></tr><tr><td>Payment method </td><td>:</td><td>'.$txn[0]->iutxn_method.'</td></tr></table>';
							}
						?>
					</div>
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored pic_button">Continue</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
var col_arr = [];
var cat1_arr = [];
var col_mod_arr = [];
var cart_arr = [];
var pay_arr = [];
var add = 0;
var remove = 0;
var g_price,s_price;
var group = 0;
var storage = 0;
var g_month=0,s_month=0;
var p_grand_total;
var pay_id;
var my_mod_arr = [];
var m_g_total = 0;
var ref_disc = [];
var ref_code = '';
var dis_amount = 0 ;
var m_dis_amount = 0 ;
var a_dis_amount = 0 ;
<?php
	if (isset($ref_disc)) {
		for ($i=0; $i < count($ref_disc) ; $i++) { 
			echo "ref_disc.push({'id' : '".$ref_disc[$i]->iushp_sid."' , 'for' : '".$ref_disc[$i]->iushp_for."' , 'type' : '".$ref_disc[$i]->iushp_type."' , 'amount' : '".$ref_disc[$i]->iushp_amount."' });";
		}
		echo "ref_code = '".$ref_code."';";
		echo "renew_ref_code = '".$renew_ref_code."';";
	}

	if (isset($collection)) {

		for ($i=0; $i <count($collection) ; $i++) { 
			echo "col_arr.push({'id': ".$collection[$i]->iec_id.", 'title' : '".$collection[$i]->iec_title."', 'img' : '".$collection[$i]->iec_timestamp."'});";
		}
		for ($i=0; $i <count($col_module) ; $i++) {
			echo "col_mod_arr.push({'id' : ".$col_module[$i]->im_id." , 'name' : '".$col_module[$i]->im_name."', 'desc' : '".$col_module[$i]->im_desc."', 'img' : '".$col_module[$i]->imf_file."', 'price' : '".$col_module[$i]->im_price."'});";
		}

		for ($i=0; $i <count($portal) ; $i++) {
			if ($portal[$i]->ipprice_name == 'group') {
				echo "g_price = ".$portal[$i]->ipprice_amount.";";
			}
			if ($portal[$i]->ipprice_name == 'storage') {
				echo "s_price = ".$portal[$i]->ipprice_amount.";";
			}
		}
		for ($il=0; $il < count($my_module) ; $il++) {
			$date1 = $my_module[$il]->ium_subscription_start;
			$date2 = $my_module[$il]->ium_subscription_end;

			$ts1 = strtotime($date1);
			$ts2 = strtotime($date2);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			echo "my_mod_arr.push({'mid' : ".$my_module[$il]->im_id.", 'mname' : '".$my_module[$il]->im_name."', 'price' : '".$my_module[$il]->im_price."', 'status' : '".$my_module[$il]->ium_status."', 'no_user' : '".$my_module[$il]->ium_user_limit."', 'sub' : '".$diff."'});";
		}
	}
?>
$(document).ready(function() {
	var p_key = '<?php echo $p_key; ?>';
	var p_secret = '<?php echo $p_secret; ?>';
	<?php
		if (isset($txn)) {
			echo "$('#pay_success').modal('toggle');";
		}
	?>
	display_list();
	display_mod_list();
	get_cart();
	cart_details();
	add_mod_subscription();
	var snackbarContainer = document.querySelector('#demo-toast-example');

	$('#select_collection').change(function(e) {
		e.preventDefault();
		var id = $(this).val();
		if (id != 'none') {
        	if (id == 'p_coll') {
        		$('.cat1').css('display','block');
        		$('.collection').css('display','flex');
        		$('.mod_collection').css('display','none');
				$.post('<?php echo base_url()."Home/get_collection_cat/".$code; ?>'
		        , function(d,s,x) {
		        	var d = JSON.parse(d);
		        	var out = '';
		        	out += '<option value="none">Select cat1</option>';
		        	for (var i = 0; i < d.cat1.length; i++) {
		        		out += '<option value="'+d.cat1[i].iec_cat1+'">'+d.cat1[i].iec_cat1+'</option>';
		        	}
		        	$('#cat1_collection').empty();
		        	$('#cat1_collection').append(out);
		        });
        	}else{
        		$('.mod_collection').css('display','flex');
        		$('.cat1').css('display','none');
        		$('.cat2').css('display','none');
        		$('.collection').css('display','none');
        	}
		}else{
			$('.cat').css('display','none');
		}
	});

	$('#cat1_collection').change(function (e) {
		e.preventDefault();
		var id = $(this).val();
		$.post('<?php echo base_url()."Home/get_collection_subcat/".$code; ?>',{
			'cat1' : id
		}, function(d,s,x) {
        	var d = JSON.parse(d);
        	var out = '';
        	$('.cat2').css('display','block');
        	out += '<option value="none">Select cat2</option>';
        	for (var i = 0; i < d.cat2.length; i++) {
        		out += '<option value="'+d.cat2[i].iec_cat2+'">'+d.cat2[i].iec_cat2+'</option>';
        	}
        	$('#cat2_collection').empty();
        	$('#cat2_collection').append(out);
        	col_arr = [];
        	for (var i=0; i <d.collection.length; i++) { 
				col_arr.push({id: d.collection[i].iec_id, title : d.collection[i].iec_title, img : d.collection[i].iec_timestamp});
			}
			display_list();
        });
	});

	$('#cat2_collection').change(function (e) {
		e.preventDefault();
		var cat1 = $('#cat1_collection').val();
		var cat2 = $(this).val();
		$.post('<?php echo base_url()."Home/get_collection_subcat2/".$code; ?>',{
			'cat1' : cat1,
			'cat2' : cat2
		}, function(d,s,x) {
        	var d = JSON.parse(d);
        	col_arr = [];
        	for (var i=0; i <d.collection.length; i++) { 
				col_arr.push({id: d.collection[i].iec_id, title : d.collection[i].iec_title, img : d.collection[i].iec_timestamp});
			}
			display_list();
        });
	});

	$('#my_cart').click(function (e) {
		e.preventDefault();
		$('#cart_details_modal').modal('show');
	});

	$('#my_modules').click(function (e) {
		e.preventDefault();
		$('#module_details_modal').modal('show');
	});

	$('.collection_details').click(function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		$.post('<?php echo base_url()."Home/get_collection_details/".$code."/"; ?>'+id, {
            'i' : id,
            's' : status
        }, function(d,s,x) {
        	var d = JSON.parse(d);
        	var title = d.title;
        	var img = d.img;
        	var f_data = d.file_data;
        	var a='';
        	var path = "<?php echo base_url().'assets/data/portal/explore_collection/';?>"+img;
			
			a+='<div class="mdl-cell mdl-cell--12-col collection_details"><div class="demo-card-image mdl-card mdl-shadow--2dp"><div class="mdl-card__title mdl-card--expand" style="width: 256px;height: 256px;background: linear-gradient(10deg,rgba(0,0,0,0.3),rgba(255, 15, 15, 0.3)), url('+path+');background-size: cover;background-repeat: no-repeat;"><h2 class="mdl-card__title-text" style="color: #fff;font-weight: bold;">'+title+'</h2></div>';
			a+='<div class="mdl-cell mdl-cell--12-col"><div class="mdl-card__supporting-text">'+f_data+'<div style="text-align: left;">';
				for (var i = 0; i < d.module.length; i++) {
					a+= '<p style="font-weight:bold;">'+d.module[i].im_name+' : </p><p style="margin-left: 5%;">'+ d.module[i].im_desc +'</p>';
				}
			a+='</div></div></div>';
			a+='<button class="mdl-button mdl-button--raised mdl-button--colored add_collection" id="'+d.id+'">Add to cart</button></div></div>';
		
			$('#modal_body').empty();
			$('#modal_body').append(a);	
           	$('#collection_Modal').modal('show');
        });
	});

	$('#modal_body').on('click','.add_collection',function (e) {
		e.preventDefault();
		var id = $(this).prop('id');
		$('.add_collection').prop("disabled", true);
		$.post('<?php echo base_url()."Home/add_to_cart/".$code."/"; ?>'+id, 
		function(d,s,x) {
			var d = JSON.parse(d);
			window.location = "<?php echo base_url().'Home/collection/0/'.$code;?>";
        });
	});

	$('#pay_success').on('click','.pic_button',function (e) {
		e.preventDefault();
		window.location = "<?php echo base_url()."Account/switch_account/".$code."/0";?>";
	})

	$('.close').click(function(e) {
		e.preventDefault();
		$('#cart_details_modal').hide();
		$('#module_details_modal').hide();
	});

	$('.cart').on('click','.u_remove',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < cart_arr.length; i++) {
			if(cart_arr[i].id == id){
				var add = cart_arr[i].users;
				if (add != 1) {
					cart_arr[i].users = Number(add) - 1;
				}
			}
		}
		cart_details_display();
	});

	$('.cart').on('click','.u_add',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < cart_arr.length; i++) {
			if(cart_arr[i].id == id){
				var add = cart_arr[i].users;
				cart_arr[i].users = Number(add) +1;
			}
		}
		cart_details_display();
	});

	$('.cart').on('click','.g_remove',function(e) {
		e.preventDefault();
		if (group != 0) {
			group = Number(group) - 1;
		}
		cart_details_display();
	});

	$('.cart').on('click','.g_add',function(e) {
		e.preventDefault();
		group = Number(group) + 1;
		cart_details_display();
	});

	$('.cart').on('click','.g_m_remove',function(e) {
		e.preventDefault();
		if (g_month != 0) {
			g_month = Number(g_month) - 1;
		}
		cart_details_display();
	});

	$('.cart').on('click','.g_m_add',function(e) {
		e.preventDefault();
		g_month = Number(g_month) + 1;
		cart_details_display();
	});

	$('.cart').on('click','.s_remove',function(e) {
		e.preventDefault();
		if (storage != 0) {
			storage = Number(storage) - 1;
		}
		cart_details_display();
	});

	$('.cart').on('click','.s_add',function(e) {
		e.preventDefault();
		storage = Number(storage) + 1;
		cart_details_display();
	});

	$('.cart').on('click','.s_m_remove',function(e) {
		e.preventDefault();
		if (s_month != 0) {
			s_month = Number(s_month) - 1;
		}
		cart_details_display();
	});

	$('.cart').on('click','.s_m_add',function(e) {
		e.preventDefault();
		s_month = Number(s_month) + 1;
		cart_details_display();
	});

	$('.cart').on('keyup','.u_count',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var id = $(this).prop('id');
		var c_id = id.substring(2,id.length);
		var n_u = '';
		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $('#'+id).val();	
	    }else{
	    	n_u = 0;
	    }
	    for (var i = 0; i < cart_arr.length; i++) {
			if(cart_arr[i].id == c_id){
				var add = cart_arr[i].users;
				cart_arr[i].users = Number(n_u);
			}
		}
		cart_details_display();
	});

	$('.cart').on('keyup','.g_amount',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var n_u = '';
		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $(this).val();	
	    }else{
	    	n_u = 0;
	    }
		group = Number(n_u);
		cart_details_display();
	});

	$('.cart').on('keyup','.s_amount',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var n_u = '';
		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $(this).val();	
	    }else{
	    	n_u = 0;
	    }
		storage = Number(n_u);
		cart_details_display();
	});

	$('.cart').on('keyup','.g_month',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var n_u = '';
		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $(this).val();	
	    }else{
	    	n_u = 0;
	    }
		g_month = Number(n_u);
		cart_details_display();
	});

	$('.cart').on('keyup','.s_month',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var n_u = '';
		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $(this).val();	
	    }else{
	    	n_u = 0;
	    }
		s_month = Number(n_u);
		cart_details_display();
	});

	$('.cart_module').click(function (e) {
		e.preventDefault();
		var mid = $(this).prop('id');
		$.post('<?php echo base_url()."Home/add_module_cart/".$code."/"; ?>'+mid,
		function(d,s,x) {
			if (d=='exist') {
				var data = {message: 'Module already added!'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}else{
				window.location = "<?php echo base_url().'Home/collection/0/'.$code;?>";
			}
        });
	});

	$('.cart').on('click','.c_delete',function (e) {
		e.preventDefault();
		var id = $(this).prop('id');
		$.post('<?php echo base_url()."Home/delete_module_cart/".$code.'/'; ?>'+id,
		function(d,s,x) {
			for (var i = 0; i < cart_arr.length; i++) {
				if(cart_arr[i].id == id){
					cart_arr.splice(i,1);
					break;
				}
			}
			cart_details_display();
        });
	});

	$('.cart').on('click','.u_s_remove',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < cart_arr.length; i++) {
			if(cart_arr[i].id == id){
				var add = cart_arr[i].sub;
				if (add != 0) {
					cart_arr[i].sub = Number(add) - 1;

				}
			}
		}
		cart_details_display();
	});

	$('.cart').on('click','.u_s_add',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < cart_arr.length; i++) {
			if(cart_arr[i].id == id){
				var add = cart_arr[i].sub;
				cart_arr[i].sub = Number(add) +1;
			}
		}
		cart_details_display();
	});

	$('.cart').on('keyup','.u_s_count',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var id = $(this).prop('id');
		var c_id = id.substring(2,id.length);
		var n_u = '';
		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $('#'+id).val();
	    }else{
	    	n_u = 0;
	    }
    	for (var i = 0; i < cart_arr.length; i++) {
			if(cart_arr[i].id == c_id){
				cart_arr[i].sub = n_u;
			}
		}
	    cart_details_display();
	});

	// function capture_pay(pay_id,amt) {
		// $.ajax({
		// 	url:'https://' + p_key + ':' + p_secret + '@api.razorpay.com/v1/payments/' + pay_id + '/capture',
		// 	type:"POST",             // Type of request to be send, called as method
		// 	data: {
		// 		'amount':amt
		// 	},
		// 	headers : {
		// 		'content-type' : 'application/x-www-form-urlencoded',
		// 		'cache-control' : 'no-cache',
		// 		'Access-Control-Allow-Origin' : 'http://development.evomata.in'
		// 	},
		// 	// xhrFields: {withCredentials: true},
		// 	crossDomain : true,
		// 	// dataType : "jsonp",
		// 	// contentType: "application/json",      // The content type used when sending data to the server.
		// 	// cache: false,             // To unable request pages to be cached
		// 	// processData:false,        // To send DOMDocument or non processed data file it is set to false
		// 	success: function(data)   // A function to be called if request succeeds
		// 	{
		// 		console.log(data);
		// 	},
  //           error: function (e) {
  //               console.log(e);
  //           }
		// });
		// $.post('<?php //echo base_url()."Razorpay/callback/"; ?>',{
		// 	'razorpay_payment_id' : pay_id,
		// 	'merchant_total' : amt
		// },function(d,s,x) {
		// 	console.log(d);
  //       });
	// }

	$('.cart').on('click','.c_p_t_pay',function(e){
		e.preventDefault();
		$.post('<?php echo base_url()."Home/add_module_user/".$code; ?>',
		{'cart' : cart_arr,'g_month':g_month,'group':group,'s_month':s_month,'storage':storage,'ref_disc' : ref_disc,'disc_amt' : dis_amount , 'amount' : p_grand_total.toFixed(0) , 'ref_code' : ref_code}
		,function(d,s,x) {
			if (p_grand_total == 0 & dis_amount > 0 ) {
				window.location = "<?php echo base_url().'Home/cart_module_allot/'.$code.'/';?>"+d+'/'+group+'/'+storage;
			}else{
				cart_payment(d);
			}
        });
	});

	$('.module').on('click','.m_remove',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < my_mod_arr.length; i++) {
			if(my_mod_arr[i].mid == id){
				var add = my_mod_arr[i].no_user;
				if (add != 0) {
					my_mod_arr[i].no_user = Number(add) - 1;
				}
			}
		}
		add_mod_subscription();
	});

	$('.module').on('click','.m_add',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < my_mod_arr.length; i++) {
			if(my_mod_arr[i].mid == id){
				var add = my_mod_arr[i].no_user;
				my_mod_arr[i].no_user = Number(add) +1;
			}
		}
		add_mod_subscription();
	});

	$('.module').on('keyup','.m_count',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var id = $(this).prop('id');
		var c_id = id.substring(2,id.length);
		var n_u = '';

		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $('#'+id).val();	
	    }else{
	    	n_u = 0;
	    }
    	for (var i = 0; i < my_mod_arr.length; i++) {
			if(my_mod_arr[i].mid == c_id){
				my_mod_arr[i].no_user = n_u;
			}
		}
	    add_mod_subscription();
	});

	$('.module').on('click','.m_s_remove',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < my_mod_arr.length; i++) {
			if(my_mod_arr[i].mid == id){
				var add = my_mod_arr[i].sub;
				console.log(add);
				if (add != "") {
					my_mod_arr[i].sub = Number(add) - 1;
				}
			}
		}
		add_mod_subscription();
	});

	$('.module').on('click','.m_s_add',function(e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < my_mod_arr.length; i++) {
			if(my_mod_arr[i].mid == id){
				var add = my_mod_arr[i].sub;
				my_mod_arr[i].sub = Number(add) +1;
			}
		}
		add_mod_subscription();
	});

	$('.module').on('keyup','.m_s_count',function(e) {
		e.preventDefault();
		var key = e.keyCode;
		var id = $(this).prop('id');
		var c_id = id.substring(2,id.length);
		var n_u = '';

		if ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)) {
			n_u = $('#'+id).val();	
	    }else{
	    	n_u = 0;
	    }
    	for (var i = 0; i < my_mod_arr.length; i++) {
			if(my_mod_arr[i].mid == c_id){
				my_mod_arr[i].sub = n_u;
			}
		}
	    add_mod_subscription();
	});

	$('.module').on('click','.p_t_pay',function(e){
		e.preventDefault();
		var options = {
			"key": p_key,
			"amount": m_g_total.toFixed(0),// 2000 paise = INR 20
			"name": "Evomata Innovations (OPC) Pvt Ltd",
			"description": "Daifunc Components",
			"image": "http://evomata.com/assets/images/logo-bold-620x680.png",
			"handler": function (response){
				renewal_details(response.razorpay_payment_id,m_g_total.toFixed(0));
			},
			"prefill": {
				"name": "<?php echo $uname;?>",
				"email": "<?php echo $umail;?>",
				"contact" : "<?php echo $ucont;?>"
			},
			"notes": {
				"address": "<?php echo $uadd;?>"
			},
			"theme": {
				"color": "rgb(244,67,54)"
			}
		};
		var rzp1 = new Razorpay(options);
		rzp1.open();
	});

	$('.module').on('click','.change_renew_ref_code',function (e) {
		e.preventDefault();
		var code = $('.renew_code').val();
		code = code.toUpperCase();
		$.post('<?php echo base_url()."Home/change_ref_code/".$code; ?>',{
			'ref_code' : code
		},function(d,s,x) {
			var a = JSON.parse(d);
			ref_disc = [];
			renew_ref_code = code;
			m_dis_amount = 0 ;
			if (a.ref_disc.length > 0 ) {
				for (var i = 0; i < a.ref_disc.length; i++) {
					ref_disc.push({id : a.ref_disc[i].iushp_sid , for : a.ref_disc[i].iushp_for , type : a.ref_disc[i].iushp_type , amount : a.ref_disc[i].iushp_amount });
				}
			}
			add_mod_subscription();
        });
	});

	$('.cart').on('click','.change_ref_code',function (e) {
		e.preventDefault();
		var code = $('.purchase_code').val();
		code = code.toUpperCase();
		$.post('<?php echo base_url()."Home/change_ref_code/".$code; ?>',{
			'ref_code' : code
		},function(d,s,x) {
			var a = JSON.parse(d);
			ref_disc = [];
			ref_code = code;
			dis_amount = 0 ;
			if (a.ref_disc.length > 0 ) {
				for (var i = 0; i < a.ref_disc.length; i++) {
					ref_disc.push({id : a.ref_disc[i].iushp_sid , for : a.ref_disc[i].iushp_for , type : a.ref_disc[i].iushp_type , amount : a.ref_disc[i].iushp_amount });
				}
			}
			cart_details_display();
        });
	});

	function renewal_details(payid,amt) {
		$('.loader').show();
		$.post('<?php echo base_url()."Home/renewal_details/".$code; ?>',{
			'mcart' : my_mod_arr,
			'amount' : amt,
			'pay_id' : payid,
			'disc_amt' : m_dis_amount,
			'ref_code' : renew_ref_code,
			'ref_disc' :ref_disc
		},function(d,s,x) {
			$('.loader').hide();
			if (d=='false') {
				var data = {message: 'Something wrong ! please try again !'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}else{
				window.location = "<?php echo base_url().'Home/collection/'; ?>"+d+"/<?php echo $code; ?>";
			}
        });
	}

	function cart_payment(inid) {
		var options = {
			"key": p_key,
			"amount": p_grand_total.toFixed(0),// 2000 paise = INR 20
			"name": "Evomata Innovations (OPC) Pvt Ltd",
			"description": "Daifunc Components",
			"image": "http://evomata.com/assets/images/logo-bold-620x680.png",
			"handler": function (response){
				window.location = "<?php echo base_url().'Home/pay_details/'.$code.'/'; ?>"+response.razorpay_payment_id+"/"+p_grand_total.toFixed(0)+"/"+group+"/"+g_month+"/"+storage+"/"+s_month+"/"+ref_code+"/"+dis_amount+"/purchase/"+inid;
			},
			"prefill": {
				"name": "<?php echo $uname;?>",
				"email": "<?php echo $umail;?>",
				"contact" : "<?php echo $ucont;?>"
			},
			"notes": {
				"address": "<?php echo $uadd;?>"
			},
			"theme": {
				"color": "rgb(244,67,54)"
			}
		};
		var rzp1 = new Razorpay(options);
		rzp1.open();
	}

	function display_list() {
		var a = '';
		for (var i = 0; i < col_arr.length; i++) {
			var path = "<?php echo base_url().'assets/data/portal/explore_collection/';?>"+col_arr[i].img;
			a+='<div class="mdl-cell mdl-cell--4-col collection_details" id="'+col_arr[i].id+'"><div class="demo-card-image mdl-card mdl-shadow--2dp"><div class="mdl-card__title mdl-card--expand" style="width: 256px;height: 256px;background: linear-gradient(10deg,rgba(0,0,0,0.3),rgba(255, 15, 15, 0.3)), url('+path+');background-size: cover;background-repeat: no-repeat;"><h2 class="mdl-card__title-text" style="color: #fff;font-weight: bold;">'+col_arr[i].title+'</h2></div></div></div>';
		}
		$('.collection').empty();
		$('.collection').append(a);
	}

	function display_mod_list() {
		var out = '';
		for (var i = 0; i < col_mod_arr.length; i++) {
			var path = "<?php echo base_url().'assets/data/portal/';?>"+col_mod_arr[i].name+'/details/'+col_mod_arr[i].img;
			out+='<div class="mdl-cell mdl-cell--2-col mod_collection_details" id="'+col_mod_arr[i].id+'"><div class="demo-card-image mdl-card mdl-shadow--2dp"><div class="mdl-card__title mdl-card--expand" style="width: 256px;height: 256px;background: linear-gradient(10deg,rgba(0,0,0,0.3),rgba(255, 15, 15, 0.3)), url('+path+');background-size: cover;background-repeat: no-repeat;"><h2 class="mdl-card__title-text" style="color: #fff;font-weight: bold;">'+col_mod_arr[i].name+'</h2></div><div class="mdl-card__supporting-text">'+col_mod_arr[i].desc+'</div><div class="mdl-card__actions mdl-card--border"><button class="mdl-button mdl-button--colored mdl-js-button mdl-button--raised mdl-js-ripple-effect cart_module" id="'+col_mod_arr[i].id+'">Add to cart</button></div></div></div>';
		}
		$('.mod_collection').empty();
		$('.mod_collection').append(out);
	}

	function get_cart() {
		$.post('<?php echo base_url()."Home/get_my_cart/".$code; ?>',
		function(data, status, xhr) {
    		var d = JSON.parse(data);
    		if (d != 0) {
    			$('#my_cart').append('<span class="mdl-badge" style="margin-left:15px;" data-badge="'+ d +'"></span>');
    		}
    	});
	}

	function cart_details() {
		$.post('<?php echo base_url()."Home/get_cart_details/".$code; ?>',
		function(data, status, xhr) {
    		var d = JSON.parse(data);
    		group = d.group;
    		storage = d.storage;
    		for (var i = 0; i < d.cart_details.length; i++) {
    			cart_arr.push({id : d.cart_details[i].iucm_id, mname : d.cart_details[i].im_name, users : d.cart_details[i].iucm_users, price : d.cart_details[i].im_price, sub : d.cart_details[i].iucm_sub_month});
    		}
    		cart_details_display();
    	});
	}

	function cart_details_display() {
	 	var out = '';
	 	var g_total = 0;
    		out += '<div class="mdl-grid">';
    		out += '<table id="proposal_list" class="general_table"><thead><tr><th>Module</th><th style="text-align:center;">No. of Users</th><th style="text-align:center;">Subscripation<br>(in month)</th><th>Total</th><th></th></tr></thead>';
    		if (cart_arr.length != 0) {
    			for (var i = 0; i < cart_arr.length; i++) {
    				out += '<tr><td>'+cart_arr[i].mname+'</td><td class="c_users" style="text-align:center;"><button class="mdl-button mdl-button--icon u_remove" id="'+cart_arr[i].id+'" ><i class="material-icons">remove</i></button><input class="mdl-button u_count" id="cu'+cart_arr[i].id+'" contenteditable="true" style="width:30%;" value="'+cart_arr[i].users+'"><button class="mdl-button mdl-button--icon u_add" id="'+cart_arr[i].id+'"><i class="material-icons">add</i></button></td>';
    				var m_price = Number(cart_arr[i].price)/12;
    				out +='<td style="text-align:center;"><button class="mdl-button mdl-button--icon u_s_remove" id="'+cart_arr[i].id+'" ><i class="material-icons">remove</i></button><input class="mdl-button u_s_count" id="us'+cart_arr[i].id+'" contenteditable="true" value="'+cart_arr[i].sub+'" placeholder="In months" style="width:30%;"><button class="mdl-button mdl-button--icon u_s_add" id="'+cart_arr[i].id+'"><i class="material-icons">add</i></button></td>';
    				var total = m_price * cart_arr[i].users * cart_arr[i].sub;
    				out +='<td>'+total.toFixed(2)+'</td><td><button class="mdl-button mdl-button--icon c_delete" id="'+cart_arr[i].id+'"><i class="material-icons">delete</i></button></td></tr>';
    				g_total = Number(g_total) + Number(total);
    			}
    		}
			out += '<tr><td>GROUP</td><td class="c_group" style="text-align:center;"><button class="mdl-button mdl-button--icon g_remove"><i class="material-icons">remove</i></button><input style="width:30%;" class="mdl-button g_amount" contenteditable="true" value="'+group+'"><button class="mdl-button mdl-button--icon g_add"><i class="material-icons">add</i></button></td><td style="text-align:center;"><button class="mdl-button mdl-button--icon g_m_remove"><i class="material-icons">remove</i></button><input style="width:30%;" class="mdl-button g_month" contenteditable="true" value="'+g_month+'"><button class="mdl-button mdl-button--icon g_m_add"><i class="material-icons">add</i></button></td>';
				var g_m_price = Number(g_price) / 12 ;
				var group_total = g_m_price * group;
				var g_grand_total = group_total * Number(g_month);
				out +='<td>'+g_grand_total.toFixed(2)+'</td></tr>';
			out += '<tr><td>STORAGE ( GB )</td><td class="c_group" style="text-align:center;"><button class="mdl-button mdl-button--icon s_remove"><i class="material-icons">remove</i></button><input style="width:30%;" class="mdl-button s_amount"  contenteditable="true" value="'+storage+'"><button class="mdl-button mdl-button--icon s_add"><i class="material-icons">add</i></button></td><td style="text-align:center;"><button class="mdl-button mdl-button--icon s_m_remove"><i class="material-icons">remove</i></button><input style="width:30%;" class="mdl-button s_month" contenteditable="true" value="'+s_month+'"><button class="mdl-button mdl-button--icon s_m_add"><i class="material-icons">add</i></button></td>';
				var s_m_price = Number(s_price) / 12 ;
				var storage_total = s_m_price * storage;
				var s_grand_total = storage_total * Number(s_month);
				out +='<td>'+s_grand_total.toFixed(2)+'</td></tr>';
				var grand_total = g_total + g_grand_total + s_grand_total;

			if (grand_total != 0) {
				out += '<tr><td colspan="3">TOTAL</td><td>'+grand_total.toFixed(2)+'</td><td></td></tr>';
				out += '<tr><td>DISCOUNT</td>';
				if (ref_code != 'null') {
					if (ref_disc.length > 0 ) {
						for (var i = 0; i < ref_disc.length; i++) {
							if(ref_disc[i].for == 'user'){
								if (ref_disc[i].type == 'percentage') {
									dis_amount = Number(grand_total) * ( Number(ref_disc[i].amount ) / 100 );
									a_dis_amount = Number(grand_total) - Number(dis_amount);
								}else{
									dis_amount = Number(ref_disc[i].amount);
									a_dis_amount = Number(grand_total) - Number(dis_amount);
								}
							}
						}
					}else{
						dis_amount = 0 ;
						a_dis_amount = Number(grand_total);
					}
					out += '<td colspan="2" style="text-align:center;"><input type="text" id="edit_ref_code" class="mdl-button purchase_code" placeholder="Enter referrer code" value="'+ref_code+'" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
					out += '<td style="text-align:left;">'+dis_amount.toFixed(2)+'</td></tr>';
				}else{
					out += '<td colspan="2" style="text-align:center;"><input type="text" id="edit_ref_code" class="mdl-button purchase_code" placeholder="Enter referrer code" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
					out += '<td style="text-align:left;">'+dis_amount.toFixed(2)+'</td></tr>';
					a_dis_amount = Number(grand_total);
				}
				out += '<tr><td colspan="3">GRAND TOTAL</td><td>'+a_dis_amount.toFixed(2)+'</td><td></td></tr>';


				p_grand_total = a_dis_amount * 100;
				out += '<tr><td colspan="5"><button style="width:100%;" class="mdl-button mdl-button--raised mdl-button--colored c_p_t_pay"> PROCEED TO PAY </button></td></tr>';
			}
    		out +='</table></div>';
    		$('.cart').empty();
    		$('.cart').append(out);
	}

	function add_mod_subscription() {
	 	var out = '';
	 	m_g_total = 0;
    		out += '<div class="mdl-grid">';
    		out += '<table id="m_list" class="general_table"><thead><tr><th>Module</th><th style="text-align:center;">No. of Users</th><th  style="text-align:center;">Subscripation</th><th>Total</th></tr></thead>';
    		if (my_mod_arr.length != 0) {
    			for (var i = 0; i < my_mod_arr.length; i++) {
    				if (my_mod_arr[i].status == 'suspend') {
    					out += '<tr><td style="color:red;">'+my_mod_arr[i].mname+'(expired)</td>';
    				}else{
    					out += '<tr><td>'+my_mod_arr[i].mname+'</td>';
    				}
    				out +='<td class="m_users" style="text-align:center;"><button class="mdl-button mdl-button--icon m_remove" id="'+my_mod_arr[i].mid+'" ><i class="material-icons">remove</i></button><input class="mdl-button m_count" id="mu'+my_mod_arr[i].mid+'" contenteditable="true" style="width:30%;" value="'+my_mod_arr[i].no_user+'"><button class="mdl-button mdl-button--icon m_add" id="'+my_mod_arr[i].mid+'"><i class="material-icons">add</i></button></td>';
    				var m_price = Number(my_mod_arr[i].price)/12;
    				out +='<td style="text-align:center;"><button class="mdl-button mdl-button--icon m_s_remove" id="'+my_mod_arr[i].mid+'" ><i class="material-icons">remove</i></button><input class="mdl-button m_s_count" id="ms'+my_mod_arr[i].mid+'" contenteditable="true" value="'+my_mod_arr[i].sub+'" placeholder="In months" style="width:50%;"><button class="mdl-button mdl-button--icon m_s_add" id="'+my_mod_arr[i].mid+'"><i class="material-icons">add</i></button></td>';
    				var total = m_price * my_mod_arr[i].no_user * my_mod_arr[i].sub;
    				out += '<td>'+total.toFixed(2)+'</td></tr>';
    				m_g_total = Number(m_g_total) + Number(total);
    			}
    		}
			if (m_g_total != 0) {
				if (renew_ref_code != 'null') {
					out += '<tr><td colspan="3">TOTAL</td><td>'+m_g_total.toFixed(2)+'</td></tr>';
					out += '<tr><td>DISCOUNT</td>';
					for (var i = 0; i < ref_disc.length; i++) {
						if(ref_disc[i].for == 'user'){
							if (ref_disc[i].type == 'percentage') {
								m_dis_amount = Number(m_g_total) * ( Number(ref_disc[i].amount ) / 100 );
								m_g_total = Number(m_g_total) - Number(m_dis_amount);
							}else{
								m_dis_amount = Number(ref_disc[i].amount);
								m_g_total = Number(m_g_total) - Number(m_dis_amount);
							}
						}
					}
					out += '<td colspan="2" style="text-align:center;"><input type="text" id="e_ref_code" class="mdl-button renew_code" placeholder="Enter referrer code" value="'+renew_ref_code+'" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_renew_ref_code">apply</button></td>';
					out += '<td style="text-align:left;">'+m_dis_amount.toFixed(2)+'</td></tr>';
				}else{
					out += '<tr><td colspan="3">TOTAL</td><td>'+m_g_total.toFixed(2)+'</td></tr>';
					out += '<tr><td>DISCOUNT</td>';
					out += '<td colspan="2" style="text-align:center;"><input type="text" id="e_ref_code" class="mdl-button renew_code" placeholder="Enter referrer code" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_renew_ref_code">apply</button></td>';
					out += '<td style="text-align:left;"></td></tr>';
				}
				out += '<tr><td colspan="3">GRAND TOTAL</td><td>'+m_g_total.toFixed(2)+'</td></tr>';
				out += '<tr><td colspan="4"><button style="width:100%;" class="mdl-button mdl-button--raised mdl-button--colored p_t_pay"> PROCEED TO PAY </button></td></tr>';
				m_g_total = m_g_total * 100;
			}
    		out +='</table></div>';
    		$('.module').empty();
    		$('.module').append(out);
	}
});
</script>