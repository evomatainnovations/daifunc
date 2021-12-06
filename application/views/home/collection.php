<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style type="text/css">
	.demo-card-image__filename {
	  color: #000;
	  font-size: 1.5em;
	  font-weight: 500;
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

	.general_table {
		width: 100%;
        text-align: left;
        font-size: 1em;
        border: 1px solid #ccc;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: auto;
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
		border: 1px solid #ccc;
	}

	.general_table > tbody > tr > td {
		padding: 15px;
		border: 1px solid #ccc;
	}

	.general_table > tfoot > tr {
		border: 1px solid #ccc;
	}

	.general_table > tfoot > tr > td {
		padding: 10px;
	}	
	.pay_table{
		width: 100%;
	}
	.pay_table > tbody > tr {
		width: 100%;
	}
	.pay_table > tbody > tr > td {
		padding: 15px;
		width: 25%;
		text-align: left;
	}

	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	    0% { transform: rotate(0deg); }
	    100% { transform: rotate(360deg); }
	}
	.cart {
		display: none;
	}
	.renew_cart {
		display: none;
	}
	.modal-backdrop.in {
		opacity: 0; 
	}
	.modal-backdrop {
		position: relative;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		z-index: 1040;
		background-color: #ccc;
	}
</style>
<main>
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid select">
		<div class="mdl-cell mdl-cell--3-col">
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
		<div class="mdl-cell mdl-cell--3-col" style="text-align: center;">
			<button class="mdl-button mdl-js-button" id="my_modules" style="font-size: 1.2em;margin-right: 10px;">Renew</button>
		</div>
		<div class="mdl-cell mdl-cell--3-col" style="text-align: center;">
			<button class="mdl-button mdl-js-button" id="change_group" style="font-size: 1.2em;margin-right: 10px;">Change Group Config</button>
		</div>
		<div class="mdl-cell mdl-cell--3-col" style="text-align: right;">
			<button class="mdl-button mdl-js-button" id="my_cart" style="font-size: 1.2em;"></button>
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
            <div class="modal-body" style="height: 75vh;overflow: auto;">
            	<div class="cart cart1 w3-animate-left">
            		<div class="mdl-grid">
            			<div class="mdl-cell mdl-cell--6-col">
	            			<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="cart_mod_grp">
	            				<input type="checkbox" id="cart_mod_grp" class="mdl-switch__input">
	            				<span class="mdl-switch__label">Create Group</span>
	            			</label>
	            		</div>
		 				<div class="mdl-cell mdl-cell--6-col">
		 					<select class="mdl-textfield__input" id="module_sub" style="height:2em;outline: none;">
		 						<option value="0">Select subscription</option>
		 						<option value="3">3 Month</option>
		 						<option value="6">6 Month</option>
		 						<option value="12">12 Month</option>
		 					</select>
		 				</div>
		 				<div class="mdl-cell mdl-cell--12-col" style="display:flex;">
		 					<h4 style="width:50%;">Enter Storage in GB </h4>
		 					<input class="mdl-textfield__input" type="text" id="mod_storage" style="outline: none;border-bottom: 1px solid #666;color:#000;width:50%;" placeholder="Enter Storage In GB">
		 				</div>
		 				<div class="mdl-grid cart1_table" style="width: 100%;"></div>
            		</div>
            	</div>
            	<div class="cart cart2 w3-animate-left"><div class="mdl-grid cart2_table" style="width: 100%;"></div></div>
            	<div class="mdl-grid cart cart3 w3-animate-left"></div>
            </div>
            <div class="modal-footer cart_footer"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="module_details_modal" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>My modules <button type="button" class="mdl-button close" data-dismiss="modal">&times;</button></h2>
            </div>
            <div class="modal-body" style="height: 75vh;overflow: auto;">
            	<div class="renew_cart renew_pay w3-animate-left"></div>
            	<div class="mdl-grid renew_cart renew_group w3-animate-left"></div>
            </div>
            <div class="modal-footer renew_footer"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="group_details_modal" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2>My Groups <button type="button" class="mdl-button close" data-dismiss="modal">&times;</button></h2>
            </div>
            <div class="modal-body" style="height: 75vh;overflow: auto;">
            	<div class="mdl-grid group_cart change_group_cart w3-animate-left">welcome</div>
            	<div class="mdl-grid group_cart change_group_pay w3-animate-left"></div>
            </div>
            <div class="modal-footer group_cart_footer"></div>
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

var slideIndex = 1;
var slide = 1;
var slide2 = 1;
var cart_grp_create = 'false';
var cart_user_arr = [];
var cart_access_arr = [];
var cart_admin_arr = [];
var cart_user_flg = 0;
var access_flg = 0;
var admin_flg = 0;
var subscription_flg = 0;
var user_arr = [];
var tax_name = 'N/A';
var tax_amount = 0;
var group_arr = [];
var grp_flg = 0;
var sub_bal = 0;
var group_count = 0;
var mod_user_count = [];
var r_cost = 0;
var remain_cost = 0;
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
			echo "my_mod_arr.push({'mid' : '".$my_module[$il]->im_id."', 'mname' : '".$my_module[$il]->im_name."', 'price' : '".$my_module[$il]->im_price."', 'status' : '".$my_module[$il]->ium_status."', 'no_user' : '".$my_module[$il]->ium_user_limit."', 'sub' : '".$diff."'});";
		}

		for ($i=0; $i < count($user_data) ; $i++) { 
			echo "user_arr.push('".$user_data[$i]->ic_name."');";
		}
		if (isset($credit_amt)) {
			echo "r_cost = ".$credit_amt.";";
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
		cart_details();
	});

	$('#my_modules').click(function (e) {
		e.preventDefault();
		$.post('<?php echo base_url()."Home/get_cart_details/".$code."/renew"; ?>',
		function(data, status, xhr) {
    		var d = JSON.parse(data);
    		$('.cart_footer').empty();
    		group = d.group;
    		storage = d.storage;
    		subscription_flg = d.sub;
			cart_arr = [];
    		for (var i = 0; i < d.cart_details.length; i++) {
				cart_arr.push({ id : d.cart_details[i].iucm_id, mname : d.cart_details[i].im_name, users : d.cart_details[i].iucm_users, price : d.cart_details[i].im_price, sub : d.cart_details[i].iucm_sub_month ,mid : d.cart_details[i].iucm_mid});
    		}
    		slide = 1;
			showDivs1(slide);
    		renew_pay_view();
			$('#module_details_modal').modal('show');
    	});
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
	});


	$('.cart_module').click(function (e) {
		e.preventDefault();
		var mid = $(this).prop('id');
		$.post('<?php echo base_url()."Home/add_module_cart/".$code."/"; ?>'+mid,
		function(d,s,x) {
			if (d=='exist') {
				var data = {message: 'Module already added !'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}else{
				var data = {message: 'Module added to cart !'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
	    		get_cart();
			}
        });
	});

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
    			$('#my_cart').empty();
    			$('#my_cart').append('<i class="material-icons">shopping_cart</i> Cart<span class="mdl-badge" style="margin-left:15px;" data-badge="'+ d +'"></span>');
    		}else{
    			$('#my_cart').append('<i class="material-icons">shopping_cart</i> Cart');
    		}
    	});
	}

	function cart_details() {
		$.post('<?php echo base_url()."Home/get_cart_details/".$code; ?>',
		function(data, status, xhr) {
    		var d = JSON.parse(data);
    		$('.cart_footer').empty();
    		group = d.group;
    		storage = d.storage;
			cart_arr = [];

    		for (var i = 0; i < d.cart_details.length; i++) {
				cart_arr.push({ id : d.cart_details[i].iucm_id, mname : d.cart_details[i].im_name, users : d.cart_details[i].iucm_users, price : d.cart_details[i].im_price, sub : d.cart_details[i].iucm_sub_month });
    		}

    		group_arr.push({temp_gid : grp_flg, gname : '' , users : [] });
    		for (var i = 0; i < group_arr.length; i++) {
    			if(group_arr[i]['temp_gid'] == grp_flg){
    				group_arr[i]['users'].push({uid : 0 , email : 'owner' , module_access : []});
				}
    		}

			for (var i = 0; i < group_arr.length; i++) {
    			if(group_arr[i]['temp_gid'] == grp_flg){
    				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
    					if (group_arr[i]['users'][ij]['uid'] == 0) {
    						for (var j = 0; j < cart_arr.length; j++) {
    							group_arr[i]['users'][ij]['module_access'].push({mid : cart_arr[j].id,access : 'true',admin : 'true'});
    						}
    					}
    				}
				}
    		}

			slideIndex = 1;
			showDivs(slideIndex);
			$('#cart_details_modal').modal('show');
    		cart_details_display();
    	});
	}

	showDivs(slideIndex);
	function plusDivs(n) {
		showDivs(slideIndex += n);
	}
	function showDivs(n) {
	  var i;
	  var x = document.getElementsByClassName("cart");
	  if (n > x.length) {slideIndex = 1} 
	  if (n < 1) {slideIndex = x.length} ;
	  for (i = 0; i < x.length; i++) {
	    x[i].style.display = "none";
	  }
	  x[slideIndex-1].style.display = "block";
	}

	$('#module_sub').change(function (e) {
		e.preventDefault();
		var id = $(this).val();
		subscription_flg = id;
	});

	$('.cart_footer').on('click','.cart1_next',function (e) {
		e.preventDefault();
		if (subscription_flg == 0) {
		}else{
			if (cart_grp_create == 'false') {
				cart_pay_view();
				plusDivs(2);
			}else{
				cart_grp_view();
				plusDivs(1);
			}
		}
	});

	$('.cart_footer').on('click','.cart2_back',function (e) {
		e.preventDefault();
		cart_details_display();
		plusDivs(-1);
	});

	$('.cart_footer').on('click','.cart2_next',function (e) {
		e.preventDefault();
		cart_pay_view();
		plusDivs(1);
	});

	$('.cart_footer').on('click','.cart3_back',function (e) {
		e.preventDefault();
		if (cart_grp_create == 'false') {
			cart_details_display();
			plusDivs(-2);
		}else{
			cart_grp_view();
			plusDivs(-1);
		}
	});

	$("#cart_mod_grp").change(function(){
        if($(this).prop("checked") == true){
            cart_grp_create = 'true';
        }else{
            cart_grp_create = 'false';
        }
    });

    $('.cart1_table').on('click','.m_list_delete',function (e) {
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

    $('.cart2_table').on('click','.add_user_cart',function (e) {
    	e.preventDefault();
    	save_val();
    	cart_user_flg++;
    	var gid = $(this).data('gid');
    	for (var i = 0; i < group_arr.length; i++) {
    		if (group_arr[i]['temp_gid'] == gid) {
    			group_arr[i]['users'].push({uid : cart_user_flg , email : '' , module_access : []});
    		}
    	}

    	for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == gid){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == cart_user_flg) {
						for (var j = 0; j < cart_arr.length; j++) {
							group_arr[i]['users'][ij]['module_access'].push({mid : cart_arr[j].id,access : 'false',admin : 'false'});
						}
					}
				}
			}
		}

		cart_grp_view();
    });

    $('.cart2_table').on('click','.access_click',function(e){
    	e.preventDefault();
    	save_val();
    	var gid = $(this).data('gid');
    	var uid = $(this).data('uid');
    	var mid = $(this).data('mid');

    	for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == gid){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == uid) {
						for (var j = 0; j < group_arr[i]['users'][ij]['module_access'].length; j++) {
							if (group_arr[i]['users'][ij]['module_access'][j]['mid'] == mid) {
								if (group_arr[i]['users'][ij]['module_access'][j]['access'] == 'true') {
									group_arr[i]['users'][ij]['module_access'][j]['access'] = 'false';
									group_arr[i]['users'][ij]['module_access'][j]['admin'] = 'false';
								}else{
									group_arr[i]['users'][ij]['module_access'][j]['access'] = 'true';
								}
							}
						}
					}
				}
			}
		}
		cart_grp_view();
    });

    $('.cart2_table').on('click','.admin_click',function(e){
    	e.preventDefault();
    	save_val();
    	var gid = $(this).data('gid');
    	var uid = $(this).data('uid');
    	var mid = $(this).data('mid');

    	for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == gid){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == uid) {
						for (var j = 0; j < group_arr[i]['users'][ij]['module_access'].length; j++) {
							if (group_arr[i]['users'][ij]['module_access'][j]['mid'] == mid) {
								if (group_arr[i]['users'][ij]['module_access'][j]['admin'] == 'true') {
									group_arr[i]['users'][ij]['module_access'][j]['admin'] = 'false';
								}else{
									group_arr[i]['users'][ij]['module_access'][j]['admin'] = 'true';
									group_arr[i]['users'][ij]['module_access'][j]['access'] = 'true';
								}
							}
						}
					}
				}
			}
		}
		cart_grp_view();
    });

    function save_val(){
    	for (var i = 0; i < group_arr.length; i++) {
			var gname = $('#cart_grp_name'+group_arr[i]['temp_gid']).val();
			group_arr[i]['gname'] = gname;
			for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
				if (ij != 0) {
					var uname = $('#cart_usr_name'+ij).val();
					group_arr[i]['users'][ij]['email'] = uname;
				}
			}
		}
    }

	$('.cart_footer').on('click','.cart2_grp_add',function(e){
    	e.preventDefault();
    	save_val();
    	if (group_arr.length > 0 ) {
    		grp_flg++;
    		cart_user_flg++;
    	}else{
    		grp_flg = 0;
    		cart_user_flg = 0;
    	}
    	group_arr.push({temp_gid : grp_flg, gname : '' , users : [] });
		for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == grp_flg){
				group_arr[i]['users'].push({uid : cart_user_flg , email : 'owner' , module_access : []});
			}
		}

		for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == grp_flg){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == cart_user_flg) {
						for (var j = 0; j < cart_arr.length; j++) {
							group_arr[i]['users'][ij]['module_access'].push({mid : cart_arr[j].id,access : 'true',admin : 'true'});
						}
					}
				}
			}
		}
		cart_grp_view();
    });

    $('.cart3').on('click','.change_ref_code',function (e) {
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
			cart_pay_view();
        });
	});

	$('.renew_pay').on('click','.change_ref_code',function (e) {
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
			renew_pay_view();
        });
	});


	$('#change_group').click(function (e) {
		e.preventDefault();
		$.post('<?php echo base_url()."Home/get_cart_details/".$code."/renew"; ?>',
		function(data, status, xhr) {
    		var d = JSON.parse(data);
    		group = d.group;
    		storage = d.storage;
    		subscription_flg = d.sub;
			cart_arr = [];
    		for (var i = 0; i < d.cart_details.length; i++) {
				cart_arr.push({ id : d.cart_details[i].iucm_id, mname : d.cart_details[i].im_name, users : d.cart_details[i].iucm_users, price : d.cart_details[i].im_price, sub : d.cart_details[i].iucm_sub_month ,mid : d.cart_details[i].iucm_mid});
    		}
    		get_group_details();
    	});
	});

	showDivs2(slide2);
	function showDivs2(n) {
		var i;
		var x = document.getElementsByClassName("group_cart");
		if (n > x.length) {slide2 = 1} 
		if (n < 1) {slide2 = x.length} ;
		for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		}
		x[slide2-1].style.display = "block";
	}

	function get_group_details(){
		$.post('<?php echo base_url()."Home/get_renew_details/".$code; ?>',
		function(d,s,x) {
			var a = JSON.parse(d);
			group_count = a.grp_count;
			for (var i = 0; i < a.mod_list.length; i++) {
				mod_user_count.push({'mid' : a.mod_list[i].mid ,'users' : (a.mod_list[i].count+group_count) });
			}

			for (var i = 0; i < cart_arr.length; i++) {
				var flg = 'false';
				for (var ij = 0; ij < mod_user_count.length; ij++) {
					if (cart_arr[i].id == mod_user_count[ij].mid) {
						flg = 'true';
					}
				}
				if (flg == 'false') {
					mod_user_count.push({'mid' : cart_arr[i].id ,'users' : group_count });
				}
			}

			group_arr = [];
			grp_flg = 0;
			sub_bal = a.sub_bal;
			for (var i = 0; i < a.grp_list.length; i++) {
				grp_flg = a.grp_list[i].iug_id;
				group_arr.push({temp_gid : grp_flg, gname : a.grp_list[i].iug_name , users : [] });

				for (var j = 0; j < group_arr.length; j++) {
					if(group_arr[j]['temp_gid'] == grp_flg){
						group_arr[j]['users'].push({uid : 0 , email : 'owner' , module_access : []});
					}
				}

				for (var j = 0; j < group_arr.length; j++) {
					if(group_arr[j]['temp_gid'] == grp_flg){
						for(var ij = 0 ; ij < group_arr[j]['users'].length; ij++){
							if (group_arr[j]['users'][ij]['uid'] == 0) {
								for (var jk = 0; jk < cart_arr.length; jk++) {
									group_arr[j]['users'][ij]['module_access'].push({mid : cart_arr[jk].id,access : 'true',admin : 'true'});
								}
							}
						}
					}
				}

				for (var j = 0; j < group_arr.length; j++) {
					if(group_arr[j]['temp_gid'] == grp_flg){
						for (var ij = 0; ij < a.u_list.length; ij++) {
							if(a.u_list[ij].gid == grp_flg){
								var flg = 'false';
								for (var k = 0; k < group_arr[j]['users'].length; k++) {
									if (group_arr[j]['users'][k]['uid'] == a.u_list[ij].uid && grp_flg == a.u_list[ij].gid) {
										flg = 'true';
									}
								}
								if (flg == 'false') {
									group_arr[j]['users'].push({uid : a.u_list[ij].uid , email : a.u_list[ij].uname , module_access : []});
								}
							}
						}
					}
				}

				for (var j = 0; j < group_arr.length; j++) {
					if(group_arr[j]['temp_gid'] == grp_flg){
						for(var ij = 0 ; ij < group_arr[j]['users'].length; ij++){
							u_flg = group_arr[j]['users'][ij]['uid'];
							if (group_arr[j]['users'][ij]['uid'] == u_flg && group_arr[j]['users'][ij]['uid'] != 0) {
								for (var jk = 0; jk < cart_arr.length; jk++) {
									for (var m = 0; m < a.u_list.length; m++) {
										if (grp_flg == a.u_list[m].gid && a.u_list[m].uid == u_flg && cart_arr[jk].mid == a.u_list[m].mid ) {
											if (a.u_list[m].admin == 'true') {
												var admin = 'true';
											}else{
												var admin = 'false';
											}
											group_arr[j]['users'][ij]['module_access'].push({mid : cart_arr[jk].id,access : 'true',admin :admin});
										}
									}
								}
							}
						}
					}
				}

				for (var j = 0; j < group_arr.length; j++) {
					if(group_arr[j]['temp_gid'] == grp_flg){
						for(var ij = 0 ; ij < group_arr[j]['users'].length; ij++){
							u_flg = group_arr[j]['users'][ij]['uid'];
							if (group_arr[j]['users'][ij]['uid'] == u_flg && group_arr[j]['users'][ij]['uid'] != 0) {
								for (var jk = 0; jk < cart_arr.length; jk++) {
									var flg = 'true';
									for (var m = 0; m < group_arr[j]['users'][ij]['module_access'].length; m++) {
										if (cart_arr[jk].id == group_arr[j]['users'][ij]['module_access'][m]['mid'] ) {
											flg = 'false';
										}	
									}
									if (flg == 'true') {
										group_arr[j]['users'][ij]['module_access'].push({mid : cart_arr[jk].id,access : 'false',admin :'false'});
									}
								}
							}
						}
					}
				}
			}
			if (a.max_gid) {
				grp_flg = a.max_gid;
			}
			if (a.max_uid) {
				cart_user_flg = a.max_uid;
			}
	   		slide2 = 1;
			showDivs2(slide2);
	    	chnage_group_config();
			$('#group_details_modal').modal('show');
		})
	}

	$('.group_cart_footer').on('click','.cart2_grp_add',function(e){
    	e.preventDefault();
    	save_val();
    	if (group_arr.length > 0 ) {
    		grp_flg++;
    		cart_user_flg++;
    	}else{
    		grp_flg = 0;
    		cart_user_flg = 0;
    	}
    	group_arr.push({temp_gid : grp_flg, gname : '' , users : [] });
		for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == grp_flg){
				group_arr[i]['users'].push({uid : cart_user_flg , email : 'owner' , module_access : []});
			}
		}

		for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == grp_flg){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == cart_user_flg) {
						for (var j = 0; j < cart_arr.length; j++) {
							group_arr[i]['users'][ij]['module_access'].push({mid : cart_arr[j].id,access : 'true',admin : 'true'});
						}
					}
				}
			}
		}
		chnage_group_config();
    });

    $('.change_group_cart').on('click','.add_user_cart',function (e) {
    	e.preventDefault();
    	save_val();
    	cart_user_flg++;
    	var gid = $(this).data('gid');
    	for (var i = 0; i < group_arr.length; i++) {
    		if (group_arr[i]['temp_gid'] == gid) {
    			group_arr[i]['users'].push({uid : cart_user_flg , email : '' , module_access : []});
    		}
    	}
    	for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == gid){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == cart_user_flg) {
						for (var j = 0; j < cart_arr.length; j++) {
							group_arr[i]['users'][ij]['module_access'].push({mid : cart_arr[j].id,access : 'false',admin : 'false'});
						}
					}
				}
			}
		}
		chnage_group_config();
    });

    $('.change_group_cart').on('click','.access_click',function(e){
    	e.preventDefault();
    	save_val();
    	var gid = $(this).data('gid');
    	var uid = $(this).data('uid');
    	var mid = $(this).data('mid');

    	for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == gid){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == uid) {
						for (var j = 0; j < group_arr[i]['users'][ij]['module_access'].length; j++) {
							if (group_arr[i]['users'][ij]['module_access'][j]['mid'] == mid) {
								if (group_arr[i]['users'][ij]['module_access'][j]['access'] == 'true') {
									group_arr[i]['users'][ij]['module_access'][j]['access'] = 'false';
									group_arr[i]['users'][ij]['module_access'][j]['admin'] = 'false';
								}else{
									group_arr[i]['users'][ij]['module_access'][j]['access'] = 'true';
								}
							}
						}
					}
				}
			}
		}
		chnage_group_config();
    });

    $('.change_group_cart').on('click','.admin_click',function(e){
    	e.preventDefault();
    	save_val();
    	var gid = $(this).data('gid');
    	var uid = $(this).data('uid');
    	var mid = $(this).data('mid');

    	for (var i = 0; i < group_arr.length; i++) {
			if(group_arr[i]['temp_gid'] == gid){
				for(var ij = 0 ; ij < group_arr[i]['users'].length; ij++){
					if (group_arr[i]['users'][ij]['uid'] == uid) {
						for (var j = 0; j < group_arr[i]['users'][ij]['module_access'].length; j++) {
							if (group_arr[i]['users'][ij]['module_access'][j]['mid'] == mid) {
								if (group_arr[i]['users'][ij]['module_access'][j]['admin'] == 'true') {
									group_arr[i]['users'][ij]['module_access'][j]['admin'] = 'false';
								}else{
									group_arr[i]['users'][ij]['module_access'][j]['admin'] = 'true';
									group_arr[i]['users'][ij]['module_access'][j]['access'] = 'true';
								}
							}
						}
					}
				}
			}
		}
		chnage_group_config();
    });

    $('.change_group_cart').on('click','.renew_delete_grp',function (e) {
    	e.preventDefault();
		var id = $(this).prop('id');
		group_arr.splice(id,1);
		chnage_group_config();
    });

    $('.change_group_pay').on('click','.change_ref_code',function (e) {
		e.preventDefault();
		var code = $('.grp_purchase_code').val();
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
			chnage_group_pay();
        });
	});

    $('.group_cart_footer').on('click','.cart2_next',function (e) {
		e.preventDefault();
		slide2 = 2;
		showDivs2(slide2);
		chnage_group_pay();
		for (var i = 0; i < group_arr.length; i++) {
			var gid = group_arr[i]['temp_gid']
			group_arr[i]['gname'] = $('#cart_grp_name'+gid).val();
		}
	});

	$('.group_cart_footer').on('click','.cart3_back',function (e) {
		e.preventDefault();
		slide2 = 1;
		showDivs2(slide2);
		chnage_group_config();
	});

	$('.group_cart_footer').on('click','.group_pay_amount',function (e) {
		e.preventDefault();
		if (p_grand_total == 0) {
			send_payment_mail('0','modify');
			// console.log('send_mail');
		}else{
			cart_payment('modify');
			// console.log('cart');
		}
	});

	$('.renew_footer').on('click','.renew_payment',function (e) {
		e.preventDefault();
		// if (p_grand_total == 0 ) {
			send_payment_mail('0','renew');
		// }else{
		// 	cart_payment('renew');
		// }
	});

	showDivs1(slide);
	function showDivs1(n) {
	  var i;
	  var x = document.getElementsByClassName("renew_cart");
	  if (n > x.length) {slide = 1} 
	  if (n < 1) {slide = x.length} ;
	  for (i = 0; i < x.length; i++) {
	    x[i].style.display = "none";
	  }
	  x[slide-1].style.display = "block";
	}

    $('.cart_footer').on('click','.cart3_next',function (e) {
		e.preventDefault();
		if (p_grand_total == 0 & dis_amount > 0 ) {
			send_payment_mail('0','purchase');
		}else{
			cart_payment('purchase');
		}
	});

	function send_payment_mail(payment_id,type){
		$('.loader').css('display','block');
		$.post('<?php echo base_url()."Home/send_payment_mail/".$code.'/'; ?>'+type,{
			'cart' : cart_arr,
			'group' : group_arr.length,
			'storage' : $('#mod_storage').val(),
			'subscription' : subscription_flg,
			'ref_disc' : ref_disc,
			'disc_amt' : dis_amount,
			'amount' : p_grand_total.toFixed(0),
			'ref_code' : ref_code,
			'payment_id' : payment_id,
			'amount' : p_grand_total,
			'group_arr' : group_arr,
			'credit_amt' : r_cost
		},function(d,s,x) {
			var a = JSON.parse(d);
			if (type == 'renew') {
				add_sub_module(a.inid);
			}else if (type == 'modify') {
				update_module(a.inid);
			}else{
				allot_module(a.inid);
			}
        });
	}

	function update_module(inid){
		$.post('<?php echo base_url()."Home/update_module_subscription/".$code.'/'; ?>'+inid,{
			'cart' : cart_arr,
			'group' : group_arr.length,
			'storage' : $('#change_storage').val(),
			'subscription' : subscription_flg,
			'ref_disc' : ref_disc,
			'disc_amt' : dis_amount,
			'amount' : p_grand_total.toFixed(0),
			'ref_code' : ref_code,
			'amount' : p_grand_total,
			'group_arr' : group_arr,
			'credit_amt' : r_cost,
			'remain_cost' : remain_cost
		},function(d,s,x) {
			$('.loader').css('display','none');
			window.location = "<?php echo base_url().'Home/collection/';?>"+inid+"/<?php echo $code; ?>";
        });
	}

	function add_sub_module(inid){
		$.post('<?php echo base_url()."Home/add_subuscription_module/".$code.'/'; ?>'+inid,{
			'cart' : cart_arr,
			'group' : group_arr.length,
			'storage' : $('#mod_storage').val(),
			'subscription' : subscription_flg,
			'ref_disc' : ref_disc,
			'disc_amt' : dis_amount,
			'amount' : p_grand_total.toFixed(0),
			'ref_code' : ref_code,
			'amount' : p_grand_total,
			'group_arr' : group_arr,
			'remain_cost' : remain_cost
		},function(d,s,x) {
			$('.loader').css('display','none');
			window.location = "<?php echo base_url().'Home/collection/';?>"+inid+"/<?php echo $code; ?>";
        });
	}

	function allot_module(inid){
		$.post('<?php echo base_url()."Home/module_allot/".$code.'/'; ?>'+inid,{
			'cart' : cart_arr,
			'group' : group_arr.length,
			'storage' : $('#mod_storage').val(),
			'subscription' : subscription_flg,
			'ref_disc' : ref_disc,
			'disc_amt' : dis_amount,
			'amount' : p_grand_total.toFixed(0),
			'ref_code' : ref_code,
			'amount' : p_grand_total,
			'group_arr' : group_arr,
			'remain_cost' : remain_cost
		},function(d,s,x) {
			$('.loader').css('display','none');
			window.location = "<?php echo base_url().'Home/collection/';?>"+inid+"/<?php echo $code; ?>";
        });
	}

	function cart_payment(type) {
		var options = {
			"key": p_key,
			"amount": p_grand_total,// 2000 paise = INR 20
			"name": "Evomata Innovations (OPC) Pvt Ltd",
			"description": "Daifunc Components",
			"image": "http://evomata.com/assets/images/logo-bold-620x680.png",
			"handler": function (response){
				send_payment_mail(response.razorpay_payment_id,type);
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

	function cart_details_display() {
	 	var out = '';
	 	out += '<div class="mdl-cell mdl-cell--12-col"><table id="module_list" class="general_table"><thead><tr><th>Module</th><th style="text-align:center;">Action</th></tr></thead>';
		if (cart_arr.length != 0) {
			for (var i = 0; i < cart_arr.length; i++) {
				out += '<tr><td>'+cart_arr[i].mname+'</td>';
				out +='<td style="text-align:center;"><button class="mdl-button mdl-button--colored m_list_delete" id="'+cart_arr[i].id+'"><i class="material-icons">close</i> Remove</button></td></tr>';
			}
		}
		out += '</table></div>';
	 	$('.cart1_table').empty();
	 	$('.cart1_table').append(out);
	 	out = '<div style="text-align:right;width:100%;"><button class="mdl-button mdl-button--raised cart_close" data-dismiss="modal">close</button>';
	 	out += '<button class="mdl-button mdl-button--raised cart1_next" style="background-color:green;color:#fff;">next</button></div>';
		$('.cart_footer').empty();
	 	$('.cart_footer').append(out);
	}

	function cart_grp_view() {
	 	var out = '';
		for (var i = 0; i < group_arr.length; i++) {
			out += '<div class="mdl-cell mdl-cell--12-col" style="width:100%;">';
			if (group_arr[i]['gname'] == '') {
				out += '<input type="text" id="cart_grp_name'+group_arr[i]['temp_gid']+'" style="width: 100%;font-size: 2em;outline: none;border-top: 0px;border-right: 0px;border-left: 0px;" placeholder="Enter Group Name">';
			}else{
				out += '<input type="text" id="cart_grp_name'+group_arr[i]['temp_gid']+'" style="width: 100%;font-size: 2em;outline: none;border-top: 0px;border-right: 0px;border-left: 0px;" placeholder="Enter Group Name" value="'+group_arr[i]['gname']+'">';
			}
			out += '<table id="module_user_list" class="general_table" style="overflow:auto;display:block;border:0px;border-radius:0px; padding-top:20px;">';
		 	out += '<thead><tr>';
		 	out += '<th style="background-color:#fff;color:#000;" rowspan="2">Module</th>';
		 	for (var ij = 0; ij < group_arr[i]['users'].length; ij++) {
		 		if (ij == 0) {
					out += '<th style="text-align:center;background-color:#fff;color:#000;border: 1px solid #ccc;" colspan="2">You</th>';
		 		}else{
		 			out += '<th style="text-align:center;background-color:#fff;color:#000;border: 1px solid #ccc;" colspan="2"><input type="text" id="cart_usr_name'+ij+'" class="cart_usr_name" style="width: 100%;font-size: 1em;outline: none;border-top: 0px;border-right: 0px;border-left: 0px;"';
		 			if (group_arr[i]['users'][ij]['email'] != '') {
		 				out += 'placeholder="Enter User Name"';
		 				out += 'value="'+group_arr[i]['users'][ij]['email']+'"';
		 			}else{
		 				out += 'placeholder="Enter User Name"';
		 			}
		 			out += '></th>';
		 		}
		 	}
		 	out += '<th style="background-color:#fff;color:#000;"><button class="mdl-button mdl-button--colored add_user_cart" data-gid="'+group_arr[i]['temp_gid']+'"><i class="material-icons">add</i> Add users</button></th>';
		 	out += '</tr></thead>';
		 	out += '<tbody>';
 			out += '<tr><td></td>';
		 	for (var ij = 0; ij < group_arr[i]['users'].length; ij++) {
		 		out += '<td>Access</td><td>Admin</td>';
		 	}
		 	out += '</tr>';
		 	if (cart_arr.length != 0) {
				for (var ij = 0; ij < cart_arr.length; ij++) {
					out += '<tr>';
					out += '<td>'+cart_arr[ij].mname+'</td>';
					if (group_arr[i]['users'].length > 0 ) {
						for (var k = 0; k < group_arr[i]['users'].length; k++) {
							if (group_arr[i]['users'][k]['email'] == 'owner') {
								out += '<td style="text-align:center;background-color:green;"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
								out += '<td style="text-align:center;background-color:green;"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
							}else{
								for (var jk = 0; jk < group_arr[i]['users'][k]['module_access'].length; jk++) {
									if (cart_arr[ij]['id'] == group_arr[i]['users'][k]['module_access'][jk]['mid'] ) {
										if (group_arr[i]['users'][k]['module_access'][jk]['access'] == 'true') {
											out += '<td style="text-align:center;background-color:green;" class="access_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
										}else{
											out += '<td style="text-align:center;background-color:red;" class="access_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">close</i></td>';
										}

										if (group_arr[i]['users'][k]['module_access'][jk]['admin'] == 'true') {
											out += '<td style="text-align:center;background-color:green;" class="admin_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
										}else{
											out += '<td style="text-align:center;background-color:red;" class="admin_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">close</i></td>';
										}
									}
								}
							}
						}
					}
					out += '</tr>';
				}
				out += '</tbody></table></div>';
				if (group_arr.length > 1) {
					out += '<div class="mdl-cell mdl-cell--12-col" style="width:100%;padding-top:3px;border-bottom:1px solid #000;"></div>';
				}
			}
		}
	 	$('.cart2_table').empty();
	 	$('.cart2_table').append(out);
	 	out = '<div style="text-align:right;width:100%;"><button class="mdl-button mdl-button--raised cart2_back">Back</button>';
	 	out += '<button class="mdl-button mdl-button--raised cart2_grp_add">Add more group</button>';
	 	out += '<button class="mdl-button mdl-button--raised cart2_next" style="background-color:green;color:#fff;">next</button></div>';
		$('.cart_footer').empty();
	 	$('.cart_footer').append(out);

	 	$(".cart_usr_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(user_arr, request.term);
                response(results.slice(0, 10));
            }
        });
	}

	function cart_pay_view() {
	 	var out = '';
	 	var group_total;
	 	out += '<div>';
	 	out += '<h3>Group : </h3>';
	 	var g_m_price = Number(g_price) / 12 ;
	 	if (cart_grp_create == 'true') {
	 		group_total = g_m_price * group_arr.length;
	 	}else{
	 		group_total = g_m_price;
	 	}
		var g_grand_total = group_total * Number(subscription_flg);
	 	out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>No. Of Group</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+g_m_price.toFixed(2)+'</td><td>'+group_arr.length+'</td><td style="text-align:right;">'+g_grand_total.toFixed(2)+'</td></tr></table>';
	 	out += '<h3>Storage : </h3>';

	 	if ($('#mod_storage').val() == '') {
	 		var st_no = 0;
	 	}else{
	 		var st_no = $('#mod_storage').val();
	 	}

	 	var s_m_price = Number(s_price) / 12 ;
		var storage_total = s_m_price * Number(st_no);
		var s_grand_total = storage_total * Number(subscription_flg);
		out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>Storage in GB</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+s_m_price.toFixed(2)+'</td><td>'+st_no+'</td><td style="text-align:right;">'+s_grand_total.toFixed(2)+'</td></tr></table>';

		out += '<h3>Module : </h3>';
		out += '<table class="pay_table"><tr><td>Module Name</td><td>Subscription in month</td><td>No. of Users</td><td>Rate / month</td><td style="text-align:right;">Total</td></tr>';
		var g_total = 0;
		for (var i = 0; i < cart_arr.length; i++) {
			var m_price = cart_arr[i].price;
			var m_m_price = cart_arr[i].price / 12;
			var u_flg = 0;

			for (var m = 0; m < group_arr.length; m++) {
				for(var mn = 0 ; mn < group_arr[m]['users'].length; mn++){
					for (var n = 0; n < group_arr[m]['users'][mn]['module_access'].length; n++) {
						if (cart_arr[i]['id'] == group_arr[m]['users'][mn]['module_access'][n]['mid'] ) {
							if(group_arr[m]['users'][mn]['module_access'][n]['access'] == 'true'){
								u_flg++;
							}
						}
					}
				}
			}
			var m_total = Number(u_flg) * Number(subscription_flg) * Number(m_m_price);
			out += '<tr><td>'+cart_arr[i].mname+'</td><td>'+subscription_flg+'</td><td>'+u_flg+'</td><td>'+m_m_price.toFixed(2)+'</td><td style="text-align:right;">'+m_total.toFixed(2)+'</td></tr>';
			g_total = Number(g_total) + Number(m_total);
		}
		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Module Total</td><td style="text-align:right;">'+g_total.toFixed(2)+'</td></tr>';
		var grand_total = Number(g_total) + Number(g_grand_total) + Number(s_grand_total);
		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Total (Storage + Group + Module)</td><td>'+grand_total.toFixed(2)+'</td></tr>';
		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Credit Amount</td><td>-'+r_cost.toFixed(2)+'</td></tr>';
		out += '</table>';
		out += '<table class="pay_table"><tr>';
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
			out += '<td style="width:30%;text-align:left;padding-left:0px;"><h3>Apply coupon code : </h3></td><td style="text-align:center;width:50%;"><input type="text" id="edit_ref_code" class="mdl-button purchase_code" placeholder="Enter referrer code" value="'+ref_code+'" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
			out += '<td style="text-align:right;">- '+dis_amount.toFixed(2)+'</td>';
		}else{
			out += '<td style="width:30%;text-align:left;padding-left:0px;"><h3>Apply coupon code : </h3></td><td style="text-align:center;width:50%;"><input type="text" id="edit_ref_code" class="mdl-button purchase_code" placeholder="Enter referrer code" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
			out += '<td style="text-align:right;">- '+dis_amount.toFixed(2)+'</td>';
			a_dis_amount = Number(grand_total);
		}
		
		out += '</tr></table><table class="pay_table">';
		out += '<tr><td style="width:40%;text-align:left;padding-left:0px;"><h3>Tax : </h3></td><td style="width:40%;">'+tax_name+'</td><td style="text-align:right;">'+tax_amount+'</td></tr></table>';
		if (grand_total < r_cost) {
			remain_cost = Number(r_cost) - grand_total + Number(r_cost);
		}
		if (a_dis_amount != 0) {
			a_dis_amount = Number(a_dis_amount) - Number(r_cost.toFixed(2));
		}
		if (a_dis_amount < 0 ) {
			a_dis_amount = 0;
		}
		out += '<table class="pay_table" style="font-size:1.5em;border-top:1px solid #ccc;"><tr><td style="width:80%;padding-left:0px;">Grand Total : </td><td style="text-align:right;width:20%;">'+a_dis_amount+'</td></tr></table>';
		p_grand_total = Number(a_dis_amount) * 100;
	 	$('.cart3').empty();
	 	$('.cart3').append(out);
	 	out = '<div style="text-align:right;width:100%;"><button class="mdl-button mdl-button--raised cart3_back">back</button>';
	 	out += '<button class="mdl-button mdl-button--raised cart3_next" style="background-color:green;color:#fff;">Proceed to payment</button></div>';
		$('.cart_footer').empty();
	 	$('.cart_footer').append(out);
	}

	function renew_pay_view() {
	 	var out = '';
	 	out += '<div>';
	 	out += '<h3>Group : </h3>';
	 	var g_m_price = Number(g_price) / 12 ;
		var g_grand_total = Number(group) * Number(subscription_flg) * g_m_price;
	 	out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>No. Of Group</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+g_m_price.toFixed(2)+'</td><td>'+group+'</td><td style="text-align:right;">'+g_grand_total.toFixed(2)+'</td></tr></table>';
	 	out += '<h3>Storage : </h3>';

	 	var s_m_price = Number(s_price) / 12 ;
		var storage_total = s_m_price * Number(storage);
		var s_grand_total = storage_total * Number(subscription_flg);
		out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>Storage in GB</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+s_m_price.toFixed(2)+'</td><td>'+storage+'</td><td style="text-align:right;">'+s_grand_total.toFixed(2)+'</td></tr></table>';

		out += '<h3>Module : </h3>';
		out += '<table class="pay_table"><tr><td>Module Name</td><td>Subscription in month</td><td>No. of Users</td><td>Rate / month</td><td style="text-align:right;">Total</td></tr>';
		var g_total = 0;
		for (var i = 0; i < cart_arr.length; i++) {
			var m_price = cart_arr[i].price;
			var m_m_price = cart_arr[i].price / 12;
			var u_flg = cart_arr[i].users;
			var m_total = Number(u_flg) * Number(subscription_flg) * Number(m_m_price);
			out += '<tr><td>'+cart_arr[i].mname+'</td><td>'+subscription_flg+'</td><td>'+u_flg+'</td><td>'+m_m_price.toFixed(2)+'</td><td style="text-align:right;">'+m_total.toFixed(2)+'</td></tr>';
			g_total = Number(g_total) + Number(m_total);
		}

		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Module Total</td><td style="text-align:right;">'+g_total.toFixed(2)+'</td></tr>';
		var grand_total = g_total + g_grand_total + s_grand_total;
		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Total (Storage + Group + Module)</td><td>'+grand_total.toFixed(2)+'</td></tr>';
		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Credit Amount</td><td>-'+r_cost.toFixed(2)+'</td></tr>';
		out += '</table>';
		out += '<table class="pay_table"><tr>';
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
				a_dis_amount = grand_total;
			}
			out += '<td style="width:30%;text-align:left;padding-left:0px;"><h3>Apply coupon code : </h3></td><td style="text-align:center;width:50%;"><input type="text" id="edit_ref_code" class="mdl-button purchase_code" placeholder="Enter referrer code" value="'+ref_code+'" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
			out += '<td style="text-align:right;">- '+dis_amount.toFixed(2)+'</td>';
		}else{
			out += '<td style="width:30%;text-align:left;padding-left:0px;"><h3>Apply coupon code : </h3></td><td style="text-align:center;width:50%;"><input type="text" id="edit_ref_code" class="mdl-button purchase_code" placeholder="Enter referrer code" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
			out += '<td style="text-align:right;">- '+dis_amount.toFixed(2)+'</td>';
			a_dis_amount = grand_total;
		}
		var temp_amt = 0;
		temp_amt = Number(a_dis_amount) - Number(r_cost.toFixed(2));
		if (a_dis_amount != 0) {
			a_dis_amount = Number(a_dis_amount) - Number(r_cost.toFixed(2));
		}
		if (a_dis_amount < 0 ) {
			remain_cost = Number(r_cost.toFixed(2)) - Number(temp_amt);
			a_dis_amount = 0;
		}

		out += '</tr></table><table class="pay_table">';
		out += '<tr><td style="width:40%;text-align:left;padding-left:0px;"><h3>Tax : </h3></td><td style="width:40%;">'+tax_name+'</td><td style="text-align:right;">'+tax_amount+'</td></tr></table>';

		out += '<table class="pay_table" style="font-size:1.5em;border-top:1px solid #ccc;"><tr><td style="width:80%;padding-left:0px;">Grand Total : </td><td style="text-align:right;width:20%;">'+a_dis_amount+'</td></tr></table>';
		p_grand_total = a_dis_amount * 100;
	 	$('.renew_pay').empty();
	 	$('.renew_pay').append(out);
	 	out = '<div style="text-align:right;width:100%;">';
	 	// out += '<button class="mdl-button mdl-button--raised renew_edit">Edit</button>';
	 	out += '<button class="mdl-button mdl-button--raised renew_payment" style="background-color:green;color:#fff;">Proceed to payment</button></div>';
		$('.renew_footer').empty();
	 	$('.renew_footer').append(out);
	}

	function chnage_group_config() {
	 	var out = '';
	 	out += '<div class="mdl-cell mdl-cell--6-col" style="width:100%;display:flex;"><h4 style="width:15%;">Storage  :  </h4><input type="text" id="change_storage" style="width: 50%;font-size: 1em;outline: none;border-top: 0px;border-right: 0px;border-left: 0px;" placeholder="Enter Storage in GB"></div><hr>';

		for (var i = 0; i < group_arr.length; i++) {
			out += '<div class="mdl-cell mdl-cell--12-col" style="width:100%;display:flex;"><div style="width:80%;">';
			if (group_arr[i]['gname'] == '') {
				out += '<input type="text" id="cart_grp_name'+group_arr[i]['temp_gid']+'" style="width: 100%;font-size: 2em;outline: none;border-top: 0px;border-right: 0px;border-left: 0px;" placeholder="Enter Group Name">';
			}else{
				out += '<input type="text" id="cart_grp_name'+group_arr[i]['temp_gid']+'" style="width: 100%;font-size: 2em;outline: none;border-top: 0px;border-right: 0px;border-left: 0px;" placeholder="Enter Group Name" value="'+group_arr[i]['gname']+'">';
			}
			out += '</div><div style="width:20%;text-align:center;"><button class="mdl-button mdl-button--colored mdl-button--icon renew_delete_grp" id="'+i+'"><i class="material-icons">delete</i></button></div></div><div class="mdl-cell mdl-cell--12-col" style="width:100%;"><table id="module_user_list" class="general_table" style="overflow:auto;display:block;border:0px;border-radius:0px; padding-top:20px;">';
		 	out += '<thead><tr>';
		 	out += '<th style="background-color:#fff;color:#000;" rowspan="2">Module</th>';
		 	for (var ij = 0; ij < group_arr[i]['users'].length; ij++) {
		 		if (ij == 0) {
					out += '<th style="text-align:center;background-color:#fff;color:#000;border: 1px solid #ccc;" colspan="2">You</th>';
		 		}else{
		 			out += '<th style="text-align:center;background-color:#fff;color:#000;border: 1px solid #ccc;" colspan="2"><input type="text" id="cart_usr_name'+ij+'" class="cart_usr_name" style="width: 100%;font-size: 1em;outline: none;border-top: 0px;border-right: 0px;border-left: 0px;"';
		 			if (group_arr[i]['users'][ij]['email'] != '') {
		 				out += 'placeholder="Enter User Name"';
		 				out += 'value="'+group_arr[i]['users'][ij]['email']+'"';
		 			}else{
		 				out += 'placeholder="Enter User Name"';
		 			}
		 			out += '></th>';
		 		}
		 	}
		 	out += '<th style="background-color:#fff;color:#000;"><button class="mdl-button mdl-button--colored add_user_cart" data-gid="'+group_arr[i]['temp_gid']+'"><i class="material-icons">add</i> Add users</button></th>';
		 	out += '</tr></thead>';
		 	out += '<tbody>';
 			out += '<tr><td></td>';
		 	for (var ij = 0; ij < group_arr[i]['users'].length; ij++) {
		 		out += '<td>Access</td><td>Admin</td>';
		 	}
		 	out += '</tr>';
		 	if (cart_arr.length != 0) {
				for (var ij = 0; ij < cart_arr.length; ij++) {
					out += '<tr>';
					out += '<td>'+cart_arr[ij].mname+'</td>';
					if (group_arr[i]['users'].length > 0 ) {
						for (var k = 0; k < group_arr[i]['users'].length; k++) {
							if (group_arr[i]['users'][k]['email'] == 'owner') {
								out += '<td style="text-align:center;background-color:green;"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
								out += '<td style="text-align:center;background-color:green;"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
							}else{
								for (var jk = 0; jk < group_arr[i]['users'][k]['module_access'].length; jk++) {
									if (cart_arr[ij]['id'] == group_arr[i]['users'][k]['module_access'][jk]['mid'] ) {
										if (group_arr[i]['users'][k]['module_access'][jk]['access'] == 'true') {
											out += '<td style="text-align:center;background-color:green;" class="access_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
										}else{
											out += '<td style="text-align:center;background-color:red;" class="access_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">close</i></td>';
										}

										if (group_arr[i]['users'][k]['module_access'][jk]['admin'] == 'true') {
											out += '<td style="text-align:center;background-color:green;" class="admin_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">done</i></td>';
										}else{
											out += '<td style="text-align:center;background-color:red;" class="admin_click" data-gid="'+group_arr[i]['temp_gid']+'" data-uid="'+group_arr[i]['users'][k]['uid']+'" data-mid="'+cart_arr[ij]['id']+'"><i class="material-icons" style="color:#fff;font-size:2em;">close</i></td>';
										}
									}
								}
							}
						}
					}
					out += '</tr>';
				}
				out += '</tbody></table></div>';
				if (group_arr.length > 1) {
					out += '<hr>';
				}
			}
		}
	 	$('.change_group_cart').empty();
	 	$('.change_group_cart').append(out);
	 	out = '<button class="mdl-button mdl-button--raised cart2_grp_add">Add more group</button>';
	 	out += '<button class="mdl-button mdl-button--raised cart2_next" style="background-color:green;color:#fff;">next</button></div>';
		$('.group_cart_footer').empty();
	 	$('.group_cart_footer').append(out);

	 	$(".cart_usr_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(user_arr, request.term);
                response(results.slice(0, 10));
            }
        });
	}

	function chnage_group_pay() {
	 	var out = '';
	 	// var group_amount = 0;
	 	// var storage_amount = 0;
	 	var module_amount = 0;

	 	subscription_flg = Math.round(sub_bal / 30);
	 	out += '<div>';
	 	out += '<h3>Group : </h3>';

	 	var g_m_price = Number(g_price) / 12 ;
	 	var g_grand_total = 0;
	 	var grp_remove_cost = 0;
	 	if (group_count == group_arr.length) {
	 		var g_count = 0;
			g_grand_total = 0;
		 	out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>No. Of Group</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+g_m_price.toFixed(2)+'</td><td>'+g_count+'</td><td style="text-align:right;">'+g_grand_total.toFixed(2)+'</td></tr></table>';
	 	}else if(group_count > group_arr.length){
			var g_count = Number(group_count) - Number(group_arr.length) ;
			grp_remove_cost = Number(g_m_price) * Number(g_count) * Number(subscription_flg);
		 	out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>No. Of Group</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+g_m_price.toFixed(2)+'</td><td>-'+g_count+'</td><td style="text-align:right;">-'+grp_remove_cost.toFixed(2)+'</td></tr></table>';
	 	}else if(group_count < group_arr.length){
	 		var g_count = Number(group_arr.length) - Number(group_count);
			g_grand_total = Number(g_m_price) * Number(g_count) * Number(subscription_flg);
		 	out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>No. Of Group</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+g_m_price.toFixed(2)+'</td><td>'+g_count+'</td><td style="text-align:right;">'+g_grand_total.toFixed(2)+'</td></tr></table>';
	 	}

	 	out += '<h3>Storage : </h3>';

	 	if ($('#change_storage').val() == '') {
	 		var st_no = 0;
	 	}else{
	 		var st_no = $('#change_storage').val();
	 	}

	 	var s_m_price = Number(s_price) / 12 ;
		var s_grand_total = Number(s_m_price) * Number(st_no) * Number(subscription_flg);
		out += '<table class="pay_table"><tr><td>&nbsp;</td><td>Subscription in month</td><td>Rate / month</td><td>Storage in GB</td><td style="text-align:right;">Total</td></tr><tr style="border-top:1px solid #ccc;"><td>&nbsp;</td><td>'+subscription_flg+'</td><td>'+s_m_price.toFixed(2)+'</td><td>'+st_no+'</td><td style="text-align:right;">'+s_grand_total.toFixed(2)+'</td></tr></table>';

		out += '<h3>Module : </h3>';
		out += '<table class="pay_table"><tr><td>Module Name</td><td>Subscription in month</td><td>No. of Users</td><td>Rate / month</td><td style="text-align:right;">Total</td></tr>';
		var m_grand_total = 0;
		var mod_remove_cost = 0;
		for (var i = 0; i < cart_arr.length; i++) {
			var m_price = cart_arr[i].price;
			var m_m_price = cart_arr[i].price / 12;
			var u_flg = 0;

			for (var m = 0; m < group_arr.length; m++) {
				for(var mn = 0 ; mn < group_arr[m]['users'].length; mn++){
					for (var n = 0; n < group_arr[m]['users'][mn]['module_access'].length; n++) {
						if (cart_arr[i]['id'] == group_arr[m]['users'][mn]['module_access'][n]['mid'] ) {
							if(group_arr[m]['users'][mn]['module_access'][n]['access'] == 'true'){
								u_flg++;
							}
						}
					}
				}
			}
			var m_total = 0;
		 	for (var ij = 0; ij < mod_user_count.length; ij++) {
		 		if (cart_arr[i]['mid'] == mod_user_count[ij]['mid']) {
		 			remove_flg = 0;
				 	if (u_flg == mod_user_count[ij]['users']) {
				 		u_flg = 0;
				 		m_total = 0;
				 		out += '<tr><td>'+cart_arr[i].mname+'</td><td>'+subscription_flg+'</td><td>'+u_flg+'</td><td>'+m_m_price.toFixed(2)+'</td><td style="text-align:right;">'+m_total.toFixed(2)+'</td></tr>';
				 	}else if (u_flg > mod_user_count[ij]['users']) {
				 		u_flg = u_flg - mod_user_count[ij]['users'];
						m_total = Number(u_flg) * Number(subscription_flg) * Number(m_m_price);
						out += '<tr><td>'+cart_arr[i].mname+'</td><td>'+subscription_flg+'</td><td>'+u_flg+'</td><td>'+m_m_price.toFixed(2)+'</td><td style="text-align:right;">'+m_total.toFixed(2)+'</td></tr>';

						m_grand_total = Number(m_grand_total) + Number(m_total);
				 	}else if (u_flg < mod_user_count[ij]['users']) {
				 		u_flg = mod_user_count[ij]['users'] - u_flg;
						m_total = 0;
						remove_flg = Number(mod_remove_cost) + ( Number(u_flg) * Number(subscription_flg) * Number(m_m_price) );
						out += '<tr><td>'+cart_arr[i].mname+'</td><td>'+subscription_flg+'</td><td>-'+u_flg+'</td><td>'+m_m_price.toFixed(2)+'</td><td style="text-align:right;">-'+remove_flg.toFixed(2)+'</td></tr>';

						mod_remove_cost = Number(mod_remove_cost) + Number(remove_flg);
				 	}
		 		}
		 	}
		}

		var m_purchase_amount = 0;
		if (m_grand_total == mod_remove_cost) {
			out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Module Total</td><td style="text-align:right;">'+mod_remove_cost.toFixed(2)+'</td></tr>';
			// console.log('p_amt 1'+m_purchase_amount);
		}else if(m_grand_total < mod_remove_cost) {
			m_purchase_amount = Number(mod_remove_cost) - Number(m_grand_total);
			// console.log('p_amt 2'+m_purchase_amount);

			out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Module Total</td><td style="text-align:right;">-'+m_purchase_amount.toFixed(2)+'</td></tr>';
		}else if(m_grand_total > mod_remove_cost) {
			m_purchase_amount = Number(m_grand_total) - Number(mod_remove_cost);
			// console.log('p_amt 3'+m_purchase_amount);
			out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Module Total</td><td style="text-align:right;">'+m_purchase_amount.toFixed(2)+'</td></tr>';
		}

		var grand_total = Number(g_grand_total) + Number(m_purchase_amount) + Number(s_grand_total) - Number(grp_remove_cost);

		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Total (Storage + Group + Module)</td><td style="text-align:right;">'+grand_total.toFixed(2)+'</td></tr>';
		// console.log('var grand_total = '+ grand_total);
		out += '<tr style="border-top:1px solid #ccc;"><td colspan="4">Credit Amount</td><td>-'+r_cost.toFixed(2)+'</td></tr>';
		var pay_cost = grand_total - r_cost;
		out += '</table>';
		out += '<table class="pay_table"><tr>';
		if (ref_code != 'null') {
			if (ref_disc.length > 0 ) {
				for (var i = 0; i < ref_disc.length; i++) {
					if(ref_disc[i].for == 'user'){
						if (ref_disc[i].type == 'percentage') {
							dis_amount = Number(pay_cost) * ( Number(ref_disc[i].amount ) / 100 );
							a_dis_amount = Number(pay_cost) - Number(dis_amount);
						}else{
							dis_amount = Number(ref_disc[i].amount);
							a_dis_amount = Number(pay_cost) - Number(dis_amount);
						}
					}
				}
			}else{
				dis_amount = 0 ;
				a_dis_amount = pay_cost;
			}
			out += '<td style="width:30%;text-align:left;padding-left:0px;"><h3>Apply coupon code : </h3></td><td style="text-align:center;width:50%;"><input type="text" id="edit_ref_code" class="mdl-button grp_purchase_code" placeholder="Enter referrer code" value="'+ref_code+'" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
			out += '<td style="text-align:right;">- '+dis_amount.toFixed(2)+'</td>';
		}else{
			out += '<td style="width:30%;text-align:left;padding-left:0px;"><h3>Apply coupon code : </h3></td><td style="text-align:center;width:50%;"><input type="text" id="edit_ref_code" class="mdl-button grp_purchase_code" placeholder="Enter referrer code" style="width:80%;background-color:lightyellow;color:black;"><button class="mdl-button mdl-button--colored change_ref_code">apply</button></td>';
			out += '<td style="text-align:right;">- '+dis_amount.toFixed(2)+'</td>';
			a_dis_amount = pay_cost;
		}
		
		out += '</tr></table><table class="pay_table">';
		out += '<tr><td style="width:40%;text-align:left;padding-left:0px;"><h3>Tax : </h3></td><td style="width:40%;">'+tax_name+'</td><td style="text-align:right;">'+tax_amount+'</td></tr></table>';
		if (grand_total == 0) {
			remain_cost = Number(mod_remove_cost) + Number(grp_remove_cost) + Number(r_cost);
		}
		if (a_dis_amount < 0 ) {
			a_dis_amount = 0;
		}
		out += '<table class="pay_table" style="font-size:1.5em;border-top:1px solid #ccc;"><tr><td style="width:80%;padding-left:0px;">Grand Total : </td><td style="text-align:right;width:20%;">'+a_dis_amount.toFixed(2)+'</td></tr></table>';
		p_grand_total = a_dis_amount.toFixed(2) * 100;
	 	$('.change_group_pay').empty();
	 	$('.change_group_pay').append(out);
	 	out = '<div style="text-align:right;width:100%;"><button class="mdl-button mdl-button--raised cart3_back">back</button>';
	 	out += '<button class="mdl-button mdl-button--raised group_pay_amount" style="background-color:green;color:#fff;">Proceed to payment</button></div>';
		$('.group_cart_footer').empty();
	 	$('.group_cart_footer').append(out);
	}
});
</script>