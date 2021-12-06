<style>
.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.active, .accordion:hover {
    box-shadow: 0px 5px 0px #ccc;
    border-radius: 10px;
}
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
	/*background-color: #666;*/
	/*color: #fff;*/
}

.general_table > tbody {
	border: 1px solid #ccc;
}
.general_table > tbody > tr {
	border-bottom: 1px solid #ccc;
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

.ui-widget-content{
	z-index: 1111 !important;
}

.panel {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}

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
	z-index: 1111111 !important;
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
		<div class="mdl-cell mdl-cell--12-col">
			<button class="accordion btn-lg" style="font-size: 1.5em; text-align: left;box-shadow: 0px 5px 0px #ccc;border-radius: 10px;padding-top: 0px;"><i class="material-icons">filter_list</i> Filter Records</button>
	        <div class="panel">
	        	<div class="mdl-grid">
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="Date" id="fr_date" name="from">
						    <label class="mdl-textfield__label" for="fr_date">From Date</label>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="Date" id="to_date" name="to">
							<label class="mdl-textfield__label" for="to_date">To Date</label>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--2-col">
	                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
	                        <input class="mdl-textfield__input" type="text" id="in_created">
	                        <label class="mdl-textfield__label" for="in_created">Customer name</label>
	                    </div>
	                </div>
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
		        			<label class="mdl-textfield__label" for="in_status">Status</label>
		        			<select class="mdl-textfield__input" id="in_status">
								<?php for($i=0; $i < count($status); $i++) {
					            	echo '<option value="'.$status[$i]->ies_category.'">'.$status[$i]->ies_category.'</option>';
					        	} ?>
							</select>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
	        			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="check"><i class="material-icons">search</i> Filter</button>
	        		</div>
	        	</div>
			</div>	
		</div>
		<!-- <div class="mdl-cell mdl-cell--1-col" style="text-align: center;">
			<button class="mdl-button" style="border-radius: 50px 50px;padding-top: 0px;" id="invoice_setting"><i class="material-icons" style="font-size: 2.5em;">settings</i></button>
		</div> -->
		<div class="mdl-cell mdl-cell--12-col">
			<table class="general_table" style="width: 100%;">
				<thead>
					<tr>
						<th>Ticket Id</th>
						<th>Date</th>
						<th>Customer</th>
						<th>Category</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
					if (isset($support)) {
						for ($i=0; $i < count($support) ; $i++) {
							echo '<tr style="font-weight: bold;" class="tbl_view" id="'.$support[$i]->ies_id.'">';
							echo '<td>'.$support[$i]->ies_ticket_id.'</td>';
							echo '<td>'.$support[$i]->ies_date.'</td>';
							echo '<td>'.$support[$i]->ic_name.'</td>';
							echo '<td>'.$support[$i]->ies_category.'</td>';
							echo '</tr>';
						}	
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
		<i class="material-icons">add</i>
	</button>
</main>
</div>
</body>
<div class="modal fade" id="reg_comp" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<h2>Ticket ID : <?php if(isset($tkt_id)) { echo $tkt_id; }?></h2>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<input type="text" id="sp_cust" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="sp_cust">Enter customer name</label>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--6-col">
									<h4>Customer details</h4><hr>
									<table><tbody class="invoice_table" style="text-align: left;font-size : 1em;"></tbody></table>
								</div>
								<div class="mdl-cell mdl-cell--6-col">
									<h4>Subscription details</h4><hr>
									<table><tbody class="details_table" style="text-align: left;font-size : 1em;"></tbody></table>		
								</div>
							</div>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<input type="text" id="sp_cat" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="sp_cat">Enter complaint category</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<input type="text" id="sp_sub" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="sp_sub">Enter Subject</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield" style="width: 100%;">
						    <textarea class="mdl-textfield__input" type="text" rows= "4" id="sp_desc" ></textarea>
						    <label class="mdl-textfield__label" for="sample5">Enter Description</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--6-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<input type="text" data-type="date" id="sp_date" class="mdl-textfield__input" value="<?php if(isset($edit_invoice)) { echo $edit_invoice[0]->iextein_txn_date; }else{echo date('Y-m-d'); } ?>">
							<label class="mdl-textfield__label" for="sp_date">Select Date</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="text-align: center;">
						<p>Give priority</p>
	                    <button class="mdl-button mdl-button--icon star_rat" id="star1"><i class="material-icons">star</i></button>
	                    <button class="mdl-button mdl-button--icon star_rat" id="star2"><i class="material-icons">star</i></button>
	                    <button class="mdl-button mdl-button--icon star_rat" id="star3"><i class="material-icons">star</i></button>
	                    <button class="mdl-button mdl-button--icon star_rat" id="star4"><i class="material-icons">star</i></button>
	                    <button class="mdl-button mdl-button--icon star_rat" id="star5"><i class="material-icons">star</i></button>
						<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"> 
							<select class="mdl-textfield__input" id="sp_status">
								<option value="0">Select priority</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</div> -->
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<input type="text" id="sp_contact" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="sp_contact">Contact person</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<input type="text" id="sp_remark" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="sp_remark">Remarks</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<button class="mdl-button mdl-button--colored mdl-button--raised submit_support" style="width: 100%;">Done</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var c_data = [];
	var property_arr = [];
	var invoice_arr = [];
	var cat_data = [];
	var star_rat;
	<?php
			if (isset($cust_data)) {
				for ($i=0; $i < count($cust_data) ; $i++) { 
					echo "c_data.push('".$cust_data[$i]->ic_name."');";
				}
			}

			if (isset($s_status)) {
				for ($i=0; $i < count($s_status) ; $i++) { 
					echo "cat_data.push('".$s_status[$i]->ies_category."');";
				}
			}
	?>
	$(document).ready(function() {
		$('#add').click(function (e) {
			e.preventDefault();
			$('#reg_comp').modal('show');
		});

		$("#sp_cat").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(cat_data, request.term);
                response(results.slice(0, 10));
            }
        });

  		$("#sp_cust").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(c_data, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_prod_details(value);
            }
        });

        $("#in_created").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(c_data, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_prod_details(value);
            }
        });

        $('.star_rat').click(function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            star_rat = id.substring(4, id.length)
            $('.star_rat').css('color','black');
            for (var i = 1; i <= star_rat; i++) {
                $('#star'+i).css('color','red');
            }
        });

		$('#sp_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		$('#fr_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		$('#to_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			    if (panel.style.maxHeight){
			      panel.style.maxHeight = null;
			    } else {
			      panel.style.maxHeight = panel.scrollHeight + "px";
			    }
			});
		}

		$('.submit_support').click(function (e) {
    		e.preventDefault();
    		$('.loader').show();
    		$.post('<?php if (isset($edit_invoice)) { echo base_url()."Enterprise/invoice_update/formal/".$tid."/".$code; }else{ echo base_url()."Support/save_support/".$code.'/'.$tkt_id; } ?>',{
	    		'sp_cust' : $('#sp_cust').val(),
				'sp_date' : $('#sp_date').val(),
				'sp_cat' : $('#sp_cat').val(),
				'sp_sub' : $('#sp_sub').val(),
				'sp_desc' : $('#sp_desc').val(),
				'sp_status' : star_rat,
				'sp_person' : $('#sp_contact').val(),
				'sp_remark' : $('#sp_remark').val()
			}, function(data, status, xhr) {
					window.location = '<?php echo base_url()."Support/home/".$mid."/".$code;?>';
			}, "text");
    	});

    	$('#check').click(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Support/support_filter/".$code; ?>', {
				'from' : $('#fr_date').val(),
				'to': $('#to_date').val(),
				'in_status'	 : $('#in_status').val(),
				'in_created' : $('#in_created').val()
			}, function(data, status, xhr) {
			 	var abc = JSON.parse(data);
				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.filter.length; i++) {
					out+='<tr style="font-weight: bold;" class="tbl_view" id="' + abc.filter[i].ies_id + '">';
					out+='<td>' + abc.filter[i].ies_ticket_id + '</td>';
					out+='<td>' + abc.filter[i].ies_date + '</td>';
					out+='<td>' + abc.filter[i].ic_name + '</td>';
					out+='<td>' + abc.filter[i].ies_category + '</td>';
					out+='</tr>';
				}
				$('#details').append(out);
			})
		});


		$('.tbl_view').click(function (e) {
			e.preventDefault();
			var sid = $(this).prop('id');
			window.location = '<?php echo base_url()."Support/support_details/".$code."/" ;?>'+sid;
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

		function get_prod_details(customer){
			$.post('<?php echo base_url()."Enterprise/cust_details/".$code."/"; ?>',{
				'c' : customer
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				var out = '';
				property_arr = [];
				$('.details').css('display','block');
				for (var i = 0; i < a.details.length; i++) {
					property_arr.push({'id' : a.details[i].icbd_id, 'value' : a.details[i].icbd_value, 'status' : 'false'});
				}
				
				if (a.amc.length > 0 ) {
					invoice_arr.push({'s_date' : a.amc[0].iextamc_period_from , 'e_date' : a.amc[0].iextamc_period_to , 'status' : a.amc[0].iextamc_status, 'type' : a.amc[0].iextamc_amc_type });
				}
				display_details();
			}, "text");
		}

		function display_details() {
			var out = '';
			for (var i = 0; i < property_arr.length; i++) {
				if (property_arr[i].status == 'true') {
					out +='<tr><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}else{
					out +='<tr><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
				}
				
			}
			$('.invoice_table').empty();
			$('.invoice_table').append(out);

			var out = '';
			if (invoice_arr.length > 0 ) {
				out +='<tr><td>Start Date  </td><td style="padding: 10px;"> '+invoice_arr[0].s_date+'</td></tr>';
				out +='<tr><td>End Date  </td><td style="padding: 10px;"> '+invoice_arr[0].e_date+'</td></tr>';
				out +='<tr><td>Status  </td><td style="padding: 10px;"> '+invoice_arr[0].status+'</td></tr>';
				if (invoice_arr[0].type == 'com' ) {
					out +='<tr><td>Type  </td><td style="padding: 10px;"> Comprehensive</td></tr>';
				}else{
					out +='<tr><td>Type  </td><td style="padding: 10px;"> Non Comprehensive</td></tr>';
				}
			}else{
				out +='<tr><td colspan="2" style="text-align:center;">Not found ! </td></tr>';
			}
			$('.details_table').empty();
			$('.details_table').append(out);
		}

	});
</script>