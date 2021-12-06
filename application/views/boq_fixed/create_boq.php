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

	.general_table > tfoot > tr {
		border: 1px solid #ccc;
	}

	.general_table > tfoot > tr > td {
		padding: 10px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<input type="text" id="title_name" name="title_name" class="mdl-textfield__input" placeholder="Enter Title" style="font-size: 2.5em;outline: none;">
			<div style="display: flex;">
				<?php
					if (isset($edit_boq)) {
						echo '<button class="mdl-button mdl-button--colored print_boq"><i class="material-icons">print</i>print</button><button class="mdl-button mdl-button--colored send_mail_boq"><i class="material-icons">send</i>Send mail</button>';
					}
				?>
			</div>
		</div>
        <div class="mdl-cell mdl-cell--4-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
            <select class="mdl-textfield__input boq_temp_list" style="outline: none;">
            	<option value="null">Select Template</option>
            	<?php
            		if (isset($boq_temp_list)) {
            			for ($i=0; $i <count($boq_temp_list) ; $i++) { 
            				echo '<option value="'.$boq_temp_list[$i]->iextetboqt_id.'">'.$boq_temp_list[$i]->iextetboqt_title.'</option>';
            			}
            		}
            	?>
            </select>
        </div>
        <div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
			<button class="mdl-button mdl-button--colored add_boq_cat"><i class="material-icons">add</i>Add Category</button>
		</div>
		<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 65vh;overflow-y: scroll;width: 100%;">
			<div class="mdl-grid boq_cat_list"></div>
		</div>
		<button class="mdl-button lower-button mdl-button--fab mdl-button--colored save_boq"><i class="material-icons">done</i></button>
	</div>
</main>
<div class="modal fade" id="boq_add_details" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-lg" style="width: 1000px;">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<h3 class="modal-title"></h3>
			</div>
			<div class="modal-body" style="text-align: center;">
				<div class="mdl-cell mdl-cell--12-col" style="display: center;">
					<button class="mdl-button mdl-button--colored add_item_cat"><i class="material-icons">add</i> Add category</button>
				</div>
				<div class="mdl-grid item_cat_list" style="height: 60vh;overflow: auto;"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button add_grand_total" data-dismiss="modal"><i class="material-icons">close</i>close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="send_mail" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3>Send BOQ</h3><hr>
				<div class="mdl-grid">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="send_name" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="send_name">Enter Name</label>
					</div>
					<div class="mdl-cell mdl-cell--12-col boq_details" style="display: none;">
						<table style="width: 100%;">
							<tbody class="boq_details_table" style="text-align: left;font-size : 1em;">
							</tbody>
						</table>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label email_add_not_found" style="display: none;">
						<input type="text" id="send_email" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="send_name">Not found email plz enter email</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="send_subject" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="send_subject">Enter Subject</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<textarea id="send_content" class="mdl-textfield__input" style="outline: none;"></textarea>
						<label class="mdl-textfield__label" for="send_content">Enter Content</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i>close</button>
				<button type="button" class="mdl-button send_mail" data-dismiss="modal"><i class="material-icons">send</i>send mail</button>
			</div>
		</div>
	</div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
	var boq_cat_arr = [];
	var edit_cat_id = null;
	var cat_flg = 0;
	var item_cat_flg = 0;
	var edit_detail_cat_id = null;
	var grand_total = 0;
	var cust_arr = [];
	var property_arr = [];
	$(document).ready( function() {

		var snackbarContainer = document.querySelector('#demo-toast-example');

		<?php
			if (isset($edit_boq)) {
				echo "get_boq_json(".$edit_boq[0]->iextetboqf_id.");";
			}
			if (isset($c_list)) {
				for ($i=0; $i < count($c_list) ; $i++) { 
					echo "cust_arr.push('".$c_list[$i]->ic_name."');";
				}
			}
		?>

		$("#send_name").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(cust_arr, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_details(value);
            }
        });

        function get_details(customer) {
			$.post('<?php echo base_url()."BOQ_fixed/cust_details/".$code."/"; ?>', {
				'c' : customer,
				}, function(data, status, xhr) {
				var a = JSON.parse(data);
				property_arr = [];
				if (a.details.length > 0 ) {
					for (var i = 0; i < a.details.length; i++) {
						property_arr.push({'id' : i,'value' : a.details[i], 'status' : 'false'});
					}
					$('.email_add_not_found').css('display','none');
					$('.boq_details').css('display','block');
				}else{
					$('.email_add_not_found').css('display','block');
				}
				display_email_list();
			}, "text");
		}

		function display_email_list() {
			var out = '';
			for (var i = 0; i < property_arr.length; i++) {
				if (property_arr[i].status == 'true') {
					out +='<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2"><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input" checked></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}else{
					out +='<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2"><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input"></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}
			}
			$('.boq_details_table').empty();
			$('.boq_details_table').append(out);
		}

		$('.boq_details_table').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < property_arr.length; i++) {
            	if(property_arr[i].id == a){
            		if(ischecked == false){
				    	property_arr[i].status = 'false';
				    }else{
				    	property_arr[i].status = 'true';
				    }
            	}
            }
        });

		$('#send_mail').on('click','.send_mail', function(e) {
            e.preventDefault();
            $('.loader').show();
        	$.post('<?php if(isset($edit_boq)) echo base_url()."BOQ_fixed/boq_send_mail/".$code."/".$edit_boq[0]->iextetboqf_id; ?>', {
				'email' : property_arr,
				'subject' : $('#send_subject').val(),
				'content' : $('#send_content').val()
			}, function(data, status, xhr) {
				$('.loader').hide();
				var data = {message: 'Email Send !'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}, 'text');
    	});

		function get_boq_json(id){
			$('.loader').show();
			$.post('<?php echo base_url()."BOQ_fixed/get_boq_details/".$code."/"; ?>'+id
			, function(data, status, xhr) {
				var a = JSON.parse(data);
				cat_flg=0;
				$('.loader').hide();
				boq_cat_arr = [];
				if (a.title) {
					$('#title_name').val(a.title);
				}
				if (a.boq) {
					for (var i = 0; i < a.boq.length; i++) {
	        			boq_cat_arr.push({'cat_name' : a.boq[i].cat_name , 'id' : cat_flg , 'item_arr' : [] });
	        			cat_flg++;
	        			for (var j = 0; j < boq_cat_arr.length; j++) {
	        				if(boq_cat_arr[j].id == a.boq[i].id){
	        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
	        						boq_cat_arr[i]['item_arr'].push({
	        							'particular' : a.boq[i]['item_arr'][ij]['particular'] , 
	        							'unit' : a.boq[i]['item_arr'][ij]['unit'] , 
	        							'qty' : a.boq[i]['item_arr'][ij]['qty'] ,
	        							'rate' : a.boq[i]['item_arr'][ij]['rate'] ,
	        							'amount' : a.boq[i]['item_arr'][ij]['amount'] ,
	        							'detail_arr' : []
	        						});
	        					}
	        				}
	        			}

	        			for (var j = 0; j < boq_cat_arr.length; j++) {
	        				if(boq_cat_arr[j].id == a.boq[i].id){
	        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
	        						if (a.boq[i]['item_arr'][ij]['detail_arr']) {
	        							for (var k = 0; k < boq_cat_arr[j]['item_arr'].length; k++) {
	        								if (k == ij) {
	        									boq_cat_arr[j]['item_arr'][k]['detail_arr'] = a.boq[i]['item_arr'][ij]['detail_arr'];
	        									item_cat_flg++;
	        								}
	        							}
	        						}
	        					}
	        				}
	        			}

	        			for (var j = 0; j < boq_cat_arr.length; j++) {
	        				if(boq_cat_arr[j].id == a.boq[i].id){
	        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
	        						if (a.boq[i]['item_arr'][ij]['detail_arr']) {
	        							for (var k = 0; k < boq_cat_arr[j]['item_arr'].length; k++) {
	        								if (k == ij) {
		        								for (var m = 0; m < boq_cat_arr[j]['item_arr'][k]['detail_arr'].length; m++) {
		        									for (var mn = 0; mn < boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'].length; mn++) {
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['particular'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['particular'];

		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['unit'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['unit'];

		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['qty'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['qty'];;

		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['length'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['length'];;

		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['breadth'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['breadth'];;

		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['height'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['height'];;

		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['total'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['total'];;
		        									}
		        								}
		        							}
	        							}
	        						}
	        					}
	        				}
	        			}
	        		}
				}
        		display_cat_list();
			}, 'text');
		}

		$('.print_boq').click(function (e){
			e.preventDefault();
			window.location = '<?php if(isset($edit_boq)) echo base_url()."BOQ_fixed/boq_download/".$code."/".$edit_boq[0]->iextetboqf_id; ?>';
		});

		$('.send_mail_boq').click(function (e){
			e.preventDefault();
			$('#send_mail').modal('show');
		});

		$('.save_boq').click(function (e) {
        	e.preventDefault();
        	$.post('<?php if(isset($edit_boq)){ echo base_url()."BOQ_fixed/boq_update/".$code."/".$edit_boq[0]->iextetboqf_id; }else { echo base_url()."BOQ_fixed/boq_save/".$code; } ?>',{
        		'title' : $('#title_name').val(),
    			'boq_arr' : boq_cat_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."BOQ_fixed/home/0/".$code; ?>';
			}, "text");
        });

		$('.add_boq_cat').click(function (e) {
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}
			boq_cat_arr.push({'id' : cat_flg, 'cat_name' : '' , 'item_arr' : []});
			cat_flg++;
			display_cat_list();
        });

		$('.boq_temp_list').change(function (e){
			e.preventDefault();
			$('.loader').show();
			var id = $(this).val();
			$.post('<?php echo base_url()."BOQ_fixed/get_boq_template/".$code."/"; ?>'+id
			, function(data, status, xhr) {
				var a = JSON.parse(data);
				cat_flg=0;
				$('.loader').hide();
				boq_cat_arr = [];
				if (a.boq) {
					for (var i = 0; i < a.boq.length; i++) {
	        			boq_cat_arr.push({'cat_name' : a.boq[i].cat_name , 'id' : cat_flg , 'item_arr' : [] });
	        			cat_flg++;
	        			for (var j = 0; j < boq_cat_arr.length; j++) {
	        				if(boq_cat_arr[j].id == a.boq[i].id){
	        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
	        						boq_cat_arr[i]['item_arr'].push({
	        							'particular' : a.boq[i]['item_arr'][ij]['particular'] , 
	        							'unit' : a.boq[i]['item_arr'][ij]['unit'] , 
	        							'qty' : '',
	        							'rate' : '',
	        							'amount' : '',
	        							'detail_arr' : []
	        						});
	        					}
	        				}
	        			}

	        			for (var j = 0; j < boq_cat_arr.length; j++) {
	        				if(boq_cat_arr[j].id == a.boq[i].id){
	        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
	        						if (a.boq[i]['item_arr'][ij]['detail_arr']) {
	        							for (var k = 0; k < boq_cat_arr[j]['item_arr'].length; k++) {
	        								if (k == ij) {
	        									boq_cat_arr[j]['item_arr'][k]['detail_arr'] = a.boq[i]['item_arr'][ij]['detail_arr'];
	        									item_cat_flg++;
	        								}
	        							}
	        						}
	        					}
	        				}
	        			}

	        			for (var j = 0; j < boq_cat_arr.length; j++) {
	        				if(boq_cat_arr[j].id == a.boq[i].id){
	        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
	        						if (a.boq[i]['item_arr'][ij]['detail_arr']) {
	        							for (var k = 0; k < boq_cat_arr[j]['item_arr'].length; k++) {
	        								if (k == ij) {
		        								for (var m = 0; m < boq_cat_arr[j]['item_arr'][k]['detail_arr'].length; m++) {
		        									for (var mn = 0; mn < boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'].length; mn++) {
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['particular'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['particular'];
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['unit'] = boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['unit'];
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['qty'] = '';
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['length'] = '';
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['breadth'] = '';
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['height'] = '';
		        										boq_cat_arr[j]['item_arr'][k]['detail_arr'][m]['item_arr'][mn]['total'] = '';
		        									}
		        								}
		        							}
	        							}
	        						}
	        					}
	        				}
	        			}
	        		}
				}
        		display_cat_list();
			}, 'text');
		});

		$('.boq_cat_list').on('click','.add_boq_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}

        	var id = $(this).prop('id');
        	var particular = $('#particular'+id).val();
        	var unit = $('#boq_unit'+id).val();
        	var qty = $('#boq_qty'+id).val();
        	var rate = $('#boq_rate'+id).val();
        	var amount = Number(qty) * Number(rate);

        	if (edit_cat_id == null) {
        		for (var i = 0; i < boq_cat_arr.length; i++) {
	        		if(boq_cat_arr[i].id == id ){
	        			boq_cat_arr[i]['item_arr'].push({'particular' : particular , 'unit' : unit , 'qty' : qty , 'rate' : rate , 'amount' : amount ,'detail_arr' : [] });
	        		}
	        	}
        	}else{
        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['particular'] = particular;
        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['unit'] = unit;
        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['qty'] = qty;
        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['rate'] = rate;
        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['amount'] = amount;
        		edit_cat_id = null;
				edit_item_id = null;
        	}
        	display_cat_list();
        	$('#particular'+id).focus();
        });

        $('.boq_cat_list').on('keyup','.boq_rate',function(e){
        	e.preventDefault();
        	if (e.keyCode == 13) {
        		for (var i = 0; i < boq_cat_arr.length; i++) {
	        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
	        		boq_cat_arr[i].cat_name = cat_name;
	        	}

	        	var id = $(this).data('boq');
	        	var particular = $('#particular'+id).val();
	        	var unit = $('#boq_unit'+id).val();
	        	var qty = $('#boq_qty'+id).val();
	        	var rate = $('#boq_rate'+id).val();
	        	var amount = Number(qty) * Number(rate);

	        	if (edit_cat_id == null) {
	        		for (var i = 0; i < boq_cat_arr.length; i++) {
		        		if(boq_cat_arr[i].id == id ){
		        			boq_cat_arr[i]['item_arr'].push({'particular' : particular , 'unit' : unit , 'qty' : qty , 'rate' : rate , 'amount' : amount ,'detail_arr' : [] });
		        		}
		        	}
	        	}else{
	        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['particular'] = particular;
	        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['unit'] = unit;
	        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['qty'] = qty;
	        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['rate'] = rate;
	        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['amount'] = amount;
	        		edit_cat_id = null;
					edit_item_id = null;
	        	}
	        	display_cat_list();
	        	$('#particular'+id).focus();
        	}
        });

        $('.boq_cat_list').on('click','.edit_boq_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	p_val = boq_cat_arr[id]['item_arr'][sub_id]['particular'];
        	b_val = boq_cat_arr[id]['item_arr'][sub_id]['unit'];
        	r_val = boq_cat_arr[id]['item_arr'][sub_id]['rate'];
        	q_val = boq_cat_arr[id]['item_arr'][sub_id]['qty'];
        	a_val = boq_cat_arr[id]['item_arr'][sub_id]['amount'];
        	$('#particular'+id).val(p_val);
        	$('#boq_unit'+id).val(b_val);
        	$('#boq_rate'+id).val(r_val);
        	$('#boq_qty'+id).val(q_val);
        	$('#boq_amount'+id).val(a_val);
        	$('#particular'+id).focus();
        	edit_cat_id = id;
        	edit_item_id = sub_id;
        });

        $('.boq_cat_list').on('click','.delete_boq_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	boq_cat_arr[id]['item_arr'].splice(sub_id, 1);
        	display_cat_list();
        });

        $('.boq_cat_list').on('click','.add_boq_details',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}
        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	detail_cat_id = id;
        	detail_item_id = sub_id;
        	$('.modal-title').empty();
        	$('.modal-title').append(boq_cat_arr[id]['item_arr'][sub_id]['particular']);
        	display_item_cat_list();
        	$('#boq_add_details').modal('show');
        });

		function display_cat_list(){
        	var out = '';
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		out += '<div class="mdl-cell mdl-cell--12-col">';
        		out += '<input type="text" id="cat_title'+boq_cat_arr[i].id+'" class="mdl-textfield__input" placeholder="Enter Category Name" ';
        		if (boq_cat_arr[i].cat_name != '') {
        			out += 'value = "'+boq_cat_arr[i].cat_name+'"';
        		}
        		out += 'style="outline: none;font-size:1.5em;">';
        		
        		out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--4-col mdl-cell--4-col--tablet">';
        		out += '<input type="text" id="particular'+boq_cat_arr[i].id+'" class="mdl-textfield__input" placeholder="Enter Particular" style="outline: none;">';
        		out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--2-col mdl-cell--4-col--tablet">';
        		out += '<input type="text" id="boq_unit'+boq_cat_arr[i].id+'" data-boq = "'+boq_cat_arr[i].id+'" class="mdl-textfield__input boq_unit" placeholder="Enter Unit" style="outline: none;">';
        		out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--2-col mdl-cell--4-col--tablet">';
        		out += '<input type="text" id="boq_qty'+boq_cat_arr[i].id+'" data-boq = "'+boq_cat_arr[i].id+'" class="mdl-textfield__input boq_qty" placeholder="Enter Qty" style="outline: none;">';
        		out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--2-col mdl-cell--4-col--tablet">';
        		out += '<input type="text" id="boq_rate'+boq_cat_arr[i].id+'" data-boq = "'+boq_cat_arr[i].id+'" class="mdl-textfield__input boq_rate" placeholder="Enter Rate" style="outline: none;">';
        		out += '</div>';
        		// out += '<div class="mdl-cell mdl-cell--2-col mdl-cell--4-col--tablet">';
        		// out += '<input type="text" id="boq_unit'+boq_cat_arr[i].id+'" data-boq = "'+boq_cat_arr[i].id+'" class="mdl-textfield__input boq_amount" placeholder="Enter Amount" style="outline: none;">';
        		// out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--2-col mdl-cell--4-col--tablet" style="text-align:center;">';
        		out += '<button class="mdl-button mdl-button--colored add_boq_item" id="'+boq_cat_arr[i].id+'"><i class="material-icons">add</i>add</button>';
        		out += '</div>';
        		out += '<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;"><thead><tr><th style="text-align:left;">Sr. No.</th><th style="text-align:left;">Particulars</th><th style="text-align:left;">Units</th><th style="text-align:left;">Qty</th><th style="text-align:left;">Rate</th><th style="text-align:left;">Amount</th><th style="text-align:center;">Action</th></tr></thead><tbody id="boq_item_list">';
        		for (var ij = 0; ij < boq_cat_arr[i]['item_arr'].length; ij++) {
        			srno = ij + 1;
        			out += '<tr>';
        			out += '<td style="text-align:left;">'+srno+'</td>';
        			out += '<td style="text-align:left;">'+boq_cat_arr[i]['item_arr'][ij]['particular']+'</td>';
        			out += '<td style="text-align:left;">'+boq_cat_arr[i]['item_arr'][ij]['unit']+'</td>';
        			out += '<td style="text-align:left;">'+boq_cat_arr[i]['item_arr'][ij]['qty']+'</td>';
        			out += '<td style="text-align:left;">'+boq_cat_arr[i]['item_arr'][ij]['rate']+'</td>';
        			out += '<td style="text-align:left;">'+boq_cat_arr[i]['item_arr'][ij]['amount']+'</td>';
        			out += '<td style="text-align:center;"><button class="mdl-button mdl-button--colored edit_boq_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">edit</i></button><button class="mdl-button mdl-button--colored delete_boq_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">delete</i></button><button class="mdl-button mdl-button--colored add_boq_details" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">add</i> Add details</button></td></tr>';
        		}
        		out += '</tbody></table>';
        		out += '<div class="mdl-cell mdl-cell--12-col" style="border-top:1px solid #000;width:100%;"></div>';
        	}
        	$('.boq_cat_list').empty();
        	$('.boq_cat_list').append(out);
        }

        $('.add_item_cat').click(function (e) {
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}
        	boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].push({'id' : item_cat_flg, 'cat_name' : '' , 'item_arr' : []});
			item_cat_flg++;
			display_item_cat_list();
        });

        $('.item_cat_list').on('keyup','.item_height',function(e){
        	e.preventDefault();
        	if (e.keyCode == 13) {
        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
	        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
	        	}

        		var id = $(this).data('boq');
	        	var particular = $('#item_particular'+id).val();
	        	var unit = $('#item_unit'+id).val();
	        	var qty = $('#item_qty'+id).val();
	        	var length = $('#item_length'+id).val();
	        	var breadth = $('#item_breadth'+id).val();
	        	var height = $('#item_height'+id).val();
	        	var total = Number(qty) * Number(length) * Number(breadth) * Number(height);

	        	if (edit_detail_cat_id == null) {
	        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
		        		if(boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id'] == id ){
		        			boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'].push({
		        				'particular' : particular , 
		        				'unit' : unit ,
		        				'qty' : qty ,
		        				'length' : length ,
		        				'breadth' : breadth ,
		        				'height' : height ,
		        				'total' : total ,
		        				'detail_arr' : []
		        			});
		        		}
		        	}
	        	}else{
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['particular'] = particular;
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['unit'] = unit;

	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['qty'] = qty;
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['length'] = length;
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['breadth'] = breadth;
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['height'] = height;
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['total'] = total;

	        		edit_detail_cat_id = null;
					edit_detail_item_id = null;
	        	}
	        	display_item_cat_list();
	        	$('#item_particular'+id).focus();
        	}
        });

        $('.item_cat_list').on('click','.add_item_list',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}

    		var id = $(this).prop('id');
        	var particular = $('#item_particular'+id).val();
        	var unit = $('#item_unit'+id).val();
        	var qty = $('#item_qty'+id).val();
        	var length = $('#item_length'+id).val();
        	var breadth = $('#item_breadth'+id).val();
        	var height = $('#item_height'+id).val();
        	var total = Number(qty) * Number(length) * Number(breadth) * Number(height);

        	if (edit_detail_cat_id == null) {
        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
	        		if(boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id'] == id ){
	        			boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'].push({
	        				'particular' : particular , 
	        				'unit' : unit ,
	        				'qty' : qty ,
	        				'length' : length ,
	        				'breadth' : breadth ,
	        				'height' : height ,
	        				'total' : total ,
	        				'detail_arr' : []
	        			});
	        		}
	        	}
        	}else{
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['particular'] = particular;
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['unit'] = unit;

        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['qty'] = qty;
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['length'] = length;
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['breadth'] = breadth;
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['height'] = height;
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['total'] = total;
        		edit_detail_cat_id = null;
				edit_detail_item_id = null;
        	}
        	display_item_cat_list();
        	$('#item_particular'+id).focus();
        });

        $('.item_cat_list').on('click','.edit_detail_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');

        	var p_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['particular'];
        	var u_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['unit'];
        	var q_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['qty'];
        	var l_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['length'];
        	var h_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['height'];
        	var b_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['breadth'];

        	$('#item_particular'+id).val(p_val);
        	$('#item_unit'+id).val(u_val);
        	$('#item_qty'+id).val(q_val);
        	$('#item_length'+id).val(l_val);
        	$('#item_breadth'+id).val(b_val);
        	$('#item_height'+id).val(h_val);

        	$('#item_particular'+id).focus();

        	edit_detail_cat_id = id;
			edit_detail_item_id = sub_id;
        });

        $('.item_cat_list').on('click','.delete_detail_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'].splice(sub_id,1);
        	display_item_cat_list();
        });

        $('#boq_add_details').on('click','.add_grand_total',function(e){
        	e.preventDefault();
        	console.log(grand_total);
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}
        	boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['qty'] = grand_total;
        	var rate = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['rate'];
        	boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['amount'] = Number(rate) * Number(grand_total);
        	grand_total = 0;
        	display_cat_list();
        });

        function display_item_cat_list(){
        	var out = '';
        	grand_total = 0;
        	if(boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr']) {
        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
	        		out += '<div class="mdl-cell mdl-cell--12-col">';
	        		out += '<input type="text" id="cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input" placeholder="Enter Category Name" ';
	        		if (boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] != '') {
	        			out += 'value = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name']+'"';
	        		}
	        		out += 'style="outline: none;font-size:1.5em;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<input type="text" id="item_particular'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input" placeholder="Enter Particular" style="outline: none;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<input type="text" id="item_unit'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" data-boq = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input item_unit" placeholder="Enter Unit" style="outline: none;">';
	        		out += '</div>';

	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<input type="text" id="item_qty'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" data-boq = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input item_qty" placeholder="Enter Qty" style="outline: none;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<input type="text" id="item_length'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" data-boq = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input item_length" placeholder="Enter Length" style="outline: none;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<input type="text" id="item_breadth'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" data-boq = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input item_breadth" placeholder="Enter Breadth" style="outline: none;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<input type="text" id="item_height'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" data-boq = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input item_height" placeholder="Enter Height" style="outline: none;">';
	        		out += '</div>';

	        		out += '<div class="mdl-cell mdl-cell--12-col" style="text-align:center;">';
	        		out += '<button class="mdl-button mdl-button--colored add_item_list" id="'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'"><i class="material-icons">add</i>add</button>';
	        		out += '</div>';
	        		out += '<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;"><thead><tr><th style="text-align:left;">Sr. No.</th><th style="text-align:left;">Particulars</th><th style="text-align:left;">Units</th><th style="text-align:left;">Qty</th><th style="text-align:left;">Length</th><th style="text-align:left;">Breadth</th><th style="text-align:left;">Height</th><th style="text-align:left;">Total</th><th style="text-align:center;">Action</th></tr></thead><tbody id="boq_item_list">';
	    			for (var ij = 0; ij < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'].length; ij++) {
	        			srno = ij + 1;
	        			out += '<tr>';
	        			out += '<td style="text-align:left;">'+srno+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['particular']+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['unit']+'</td>';

	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['qty']+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['length']+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['breadth']+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['height']+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['total']+'</td>';
	        			grand_total = Number(grand_total) + Number(boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['total']); 
	        			out += '<td style="text-align:center;"><button class="mdl-button mdl-button--colored edit_detail_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">edit</i></button><button class="mdl-button mdl-button--colored delete_detail_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">delete</i></button></td></tr>';
	        		}
	        		out += '</tbody></table>';
	        		out += '<div class="mdl-cell mdl-cell--12-col" style="border-top:1px solid #000;width:100%;"></div>';
	        	}
        	}
        	$('.item_cat_list').empty();
        	$('.item_cat_list').append(out);
        }
	});
</script>