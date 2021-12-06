<style>
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
		<div class="mdl-cell mdl-cell--12-col" style="width: 100%;overflow: auto;">
			<table class="general_table" style="width: 100%;">
				<thead>
					<tr>
						<th>Ticket Id</th>
						<th>Date</th>
						<th>Subject</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
					if (isset($support)) {
						for ($i=0; $i < count($support) ; $i++) {
							echo '<tr style="font-weight: bold;" class="tbl_view" id="'.$support[$i]->ies_id.'">';
							echo '<td>'.$support[$i]->ies_ticket_id.'</td>';
							echo '<td>'.$support[$i]->ies_date.'</td>';
							echo '<td>'.$support[$i]->ies_subject.'</td>';
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
						
						<h4>Subscription details</h4><hr>
						<table><tbody class="details_table" style="text-align: left;font-size : 1em;"></tbody></table>
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
					</div>
					<!-- <div class="mdl-cell mdl-cell--12-col">
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
					</div> -->
					<div class="mdl-cell mdl-cell--12-col">
						<button class="mdl-button mdl-button--colored mdl-button--raised submit_support" style="width: 100%;">Done</button>
						<button class="mdl-button mdl-button--colored mdl-button--raised" data-dismiss="modal" style="width: 100%;">Close</button>
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

		if (isset($s_status)) {
			for ($i=0; $i < count($s_status) ; $i++) { 
				echo "cat_data.push('".$s_status[$i]->ies_category."');";
			}
		}

		if (isset($amc)) {
			if (count($amc) > 0 ) {
				echo "invoice_arr.push({'s_date' : '".$amc[0]->iextamc_period_from."' , 'e_date' : '".$amc[0]->iextamc_period_to."' , 'status' : '".$amc[0]->iextamc_status."', 'type' : '".$amc[0]->iextamc_amc_type."' });";
			}
		}
	?>
	$(document).ready(function() {
		display_details();

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
    		$.post('<?php echo base_url()."Mobile_app/cosmos_support_save/".$code.'/'.$tkt_id; ?>',{
				'sp_date' : $('#sp_date').val(),
				'sp_cat' : $('#sp_cat').val(),
				'sp_sub' : $('#sp_sub').val(),
				'sp_desc' : $('#sp_desc').val(),
				'sp_status' : star_rat
			}, function(data, status, xhr) {
				$('.loader').hide();
				window.location = '<?php echo base_url()."Mobile_app/cosmos_support_home/".$mid."/".$code;?>';
			}, "text");
    	});

		$('.tbl_view').click(function (e) {
			e.preventDefault();
			var sid = $(this).prop('id');
			window.location = '<?php echo base_url()."Mobile_app/cosmos_support_details/".$code."/" ;?>'+sid;
		});

		function display_details() {
			var out = '';
			if (invoice_arr.length > 0 ) {
				out +='<tr><td>Start Date  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+invoice_arr[0].s_date+'</td></tr>';
				out +='<tr><td>End Date  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+invoice_arr[0].e_date+'</td></tr>';
				out +='<tr><td>Status  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> '+invoice_arr[0].status+'</td></tr>';
				if (invoice_arr[0].type == 'com' ) {
					out +='<tr><td>Type  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> Comprehensive</td></tr>';
				}else{
					out +='<tr><td>Type  </td><td style="padding-left: 10px;">:</td><td style="padding: 10px;"> Non Comprehensive</td></tr>';
				}
			}else{
				out +='<tr><td colspan="3" style="text-align:center;">Not found ! </td></tr>';
			}
			$('.details_table').empty();
			$('.details_table').append(out);
		}
	});
</script>