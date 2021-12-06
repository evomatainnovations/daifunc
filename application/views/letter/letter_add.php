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
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell--12-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<input type="text" id="cust_name" name="cust_name" class="mdl-textfield__input" <?php if(isset($cname)) { echo 'value='.$cname; }else{ echo 'placeholder = "Enter Customer Name"';} ?> style="font-size: 3em;outline: none;">
					<table>
						<tbody class="proposal_table" style="text-align: left;font-size : 1em;"></tbody>
					</table>
					<button class="mdl-button mdl-button--accent" id="add_property"><i class="material-icons">add</i> Add Property</button>
				</div>
				<div class="mdl-cell mdl-cell--8-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--3-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" id="i_txn_no" name="i_txn_no" class="mdl-textfield__input" value="<?php if(isset($edit_letter)) { echo $edit_letter[0]->iextel_txn_id; }else{ echo $invoice_doc_id; } ?>">
								<label class="mdl-textfield__label" for="i_txn_no">Enter Transaction Number</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input type="text" data-type="date" id="i_txn_date" class="mdl-textfield__input" value="<?php if(isset($edit_letter)) { echo $edit_letter[0]->iextel_date; }else{ echo date('Y-m-d'); } ?>">
								<label class="mdl-textfield__label" for="i_txn_date">Select Date</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<?php
								if (isset($edit_letter)) {
									echo '<button class="mdl-button mdl-button--accent add_to_email_temp" style="margin-top: 15px;">Add to email template</button>';
								}
							?>
						</div>
						<div class="mdl-cell mdl-cell--3-col">
							<?php
								if (isset($edit_letter)) {
									echo '<button class="mdl-button mdl-button--accent letter_temp_print" style="margin-top: 15px;"><i class="material-icons">print</i> letter print</button>';
								}
							?>
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<select class="mdl-textfield__input" id="pro_title" style="height: 30px;width: 50%;">
				    </select>
				</div>
				<div class="mdl-grid" style="width: 100%;display: flex;">
					<div class="mdl-cell mdl-cell--1-col">
						<h3 style="margin-top: 0px;">Subject </h3>
					</div>
					<div class="mdl-cell mdl-cell--11-col">
						<input type="text" id="i_subject" style="width: 100%;outline: none;" class="mdl-textfield__input" value="<?php if(isset($edit_letter)) { echo $edit_letter[0]->iextel_subject; } ?>" placeholder="Enter Letter Subject" >
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="width: 100%;margin-top:10px;border:1px solid #ccc;">
					<div class="mdl-textfield__input" contenteditable="true" palceholder="Enter Letter content" id="letter_text" style="width: 100%;height:55vh;outline: none;overflow: auto;margin-left: 10px;margin-top:10px;margin-right: 30px;border: none;font-size: 18px;"><?php if(isset($letter_content)){echo $letter_content; }?></div>
				</div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-button--fab mdl-button--accent save_letter"><i class="material-icons">done</i></button>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
	<div class="mdl-snackbar__text"></div>
	<button class="mdl-snackbar__action" type="button"></button>
</div>
<div class="modal fade" id="letter_Modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title">Enter title for email template</h2>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" id="temp_title" class="mdl-textfield__input">
					<label class="mdl-textfield__label" for="temp_title">Enter template title</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="add_to_template"><i class="material-icons">add</i>Add</button>
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal"><i class="material-icons">close</i>close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var cust_data = [];
	var property_arr = [];
	var temp_arr = [];
	<?php
		if (isset($customer)) {
			for ($i=0; $i < count($customer) ; $i++) { 
				echo "cust_data.push('".$customer[$i]->ic_name."');";
			}
		}

		if (isset($pro_title)) {
			for($i=0; $i < count($pro_title); $i++) {
				echo "temp_arr.push({'id' : '".$pro_title[$i]->iuetemp_id."' , 'val' : '".$pro_title[$i]->iuetemp_title."' });";
    		}	
		}

		if (isset($p_details)) {
			for ($i=0; $i < count($p_details) ; $i++) { 
				echo "property_arr.push({'id' : '".$i."' , 'value' : '".$p_details[$i]->iexteld_d_val."' , 'status' : 'true'});";
			}
		}
	?>
	$(document).ready( function() {
		display_details();
		display_temp();
		var snackbarContainer = document.querySelector('#demo-toast-example');

		$('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

    	$("#cust_name").autocomplete({
            source: function(request, response) {
		        var results = $.ui.autocomplete.filter(cust_data, request.term);
		        response(results.slice(0, 10));
		    },
            select: function(event, ui) {
                var value =  ui.item.value;
                get_details(value);
            }
        });

        $('#pro_title').change(function (e) {
     		e.preventDefault();
     		e_title = $('#pro_title').val();
     		$.post('<?php echo base_url()."Letter/get_email_body/".$code."/";?>'+e_title
			, function(data, status, xhr) {
				var a = JSON.parse(data);
				$('#letter_text').empty();
				$('#letter_text').val(a.temp_content);
				$('#letter_text').focus();
			}, "text");
     	});

     	$('.proposal_table').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < property_arr.length; i++) {
            	if(property_arr[i].id == a){
            		if(!ischecked){
				    	property_arr[i].status = 'false';
				    }else{
				    	property_arr[i].status = 'true';
				    }
            	}
            }
            display_details();
        });

     	$('.save_letter').click(function (e) {
     		e.preventDefault();
     		$.post('<?php if (isset($edit_letter)) { echo base_url()."Letter/letter_update/".$code."/".$lid; } else { echo base_url()."Letter/letter_save/".$code; } ?>',{
     			'cname' : $('#cust_name').val(),
     			'txn_id' : $('#i_txn_no').val(),
     			'date' : $('#i_txn_date').val(),
     			'content' : $('#letter_text').html(),
     			'details' : property_arr,
     			'subject' : $('#i_subject').val(),
     		}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Letter/letter_add/".$code."/";?>'+data;
			}, "text");
     	});

     	$('#add_property').click(function (e) {
     		e.preventDefault();
     		var cust = $("#cust_name").val();
     		if (cust == '') {
     			var data = {message: 'Please enter customer name.'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
     		}else{
     			window.location = '<?php echo base_url()."Sales/cust_add_property/".$code."/";?>'+cust;	
     		}
     	});

     	$('.add_to_email_temp').click(function (e) {
     		e.preventDefault();
     		$('#letter_Modal').modal('show');
     	});

     	$('#add_to_template').click(function (e) {
     		e.preventDefault();
     		if ($('#temp_title').val() == '') {
     			var data = {message: 'Please enter template title !'};
		    	snackbarContainer.MaterialSnackbar.showSnackbar(data);
     		}else{
     			$.post('<?php if (isset($edit_letter)){ echo base_url()."Letter/add_to_email_temp/".$code."/".$lid; } ?>',{
	     			'content' : $('#letter_text').html(),
	     			'title' : $('#temp_title').val()
	     		}, function(data, status, xhr) {
	     			$('#temp_title').val('');
	     			var a = JSON.parse(data);
	     			temp_arr = [];
	     			for (var i = 0; i < a.pro_title.length; i++) {
	     				temp_arr.push({id : a.pro_title[i].iuetemp_id , val : a.pro_title[i].iuetemp_title });
	     			}
	     			display_temp();
	     			var data = {message: 'Added to email template !'};
		    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}, "text");
     		}
     	});

     	$('.letter_temp_print').click(function (e) {
     		e.preventDefault();
     		window.location = '<?php if (isset($edit_letter)){ echo base_url()."Letter/letter_template_print/".$code."/".$lid; } ?>';
     	});

        function get_details(cust_name) {
        	$.post('<?php echo base_url()."Letter/cust_details/".$code."/"; ?>',{
        		'c' : cust_name
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				var out = '';
				property_arr = [];
				$('.details').css('display','block');
				for (var i = 0; i < a.details.length; i++) {
					property_arr.push({'id' : a.details[i].icbd_id, 'value' : a.details[i].icbd_value, 'status' : 'false'});
				}
				display_details();
			}, "text");
        }

        function display_details() {
			var out = '';
			for (var i = 0; i < property_arr.length; i++) {
				if (property_arr[i].status == 'true') {
					out +='<tr><td><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input" checked></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}else{
					out +='<tr><td><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input"></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}
				
			}
			$('.proposal_table').empty();
			$('.proposal_table').append(out);
		}

		function display_temp() {
			var out = '';
			out +='<option value="0">Select email template</option>';
			for (var i = 0; i < temp_arr.length; i++) {
				out += '<option value='+temp_arr[i].id+'>'+temp_arr[i].val+'</option>';
			}
			$('#pro_title').empty();
			$('#pro_title').append(out);
		}
    });
</script>