<style type="text/css">
	.general_table {
		width: 100%;
        text-align: center;
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
		<div class="panel-group" id="accordion" style="width: 100%;margin-left: 10px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#support">Support ticket</a>
                    </h4>
                </div>
                <div id="support" class="panel-collapse collapse">
                    <div class="panel-body"><table id="support_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;"></table></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#project">Project</a>
                    </h4>
                </div>
                <div id="project" class="panel-collapse collapse">
                    <div class="panel-body"><table id="project_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;"></table></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#invoice">Invoice</a>
                    </h4>
                </div>
                <div id="invoice" class="panel-collapse collapse">
                    <div class="panel-body"><table id="invoice_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;"></table></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#proposal">Proposal</a>
                    </h4>
                </div>
                <div id="proposal" class="panel-collapse collapse">
                    <div class="panel-body"><table id="proposal_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;"></table></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#amc">Subscription</a>
                    </h4>
                </div>
                <div id="amc" class="panel-collapse collapse">
                    <div class="panel-body"><table id="amc_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;"></table></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#inventory">Inventory</a>
                    </h4>
                </div>
                <div id="inventory" class="panel-collapse collapse">
                    <div class="panel-body"><table id="inv_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;"></table></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#BOQ">BOQ</a>
                    </h4>
                </div>
                <div id="BOQ" class="panel-collapse collapse">
                    <div class="panel-body"><table id="boq_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;"></table></div>
                </div>
            </div>
        </div>
	</div>
</main>
<div class="modal fade" id="boq_modal" role="dialog">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            	<h3 class="boq_title"></h3>
                <hr>
				<table class="boq_det_table" style="width: 100%;border: 1px solid #ccc;"></table>
            </div>
            <div class="modal-footer">
            	<button type="button" class="mdl-button send_boq" data-dismiss="modal"><i class="material-icons">save</i> Save</button>
            	<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var support = [];
	var project = [];
	var invoice = [];
	var proposal = [];
	var amc = [];
	var inv = [];
	var boq = [];
	var table_arr = [];
	var sel_boq = 0;
	<?php
		for ($i=0; $i < count($support) ; $i++) { 
			echo "support.push({'id' : '".$support[$i]->ies_id."' , 'tkt_id' : '".$support[$i]->ies_ticket_id."' , 'subject' : '".$support[$i]->ies_subject."' , 'date' : '".$support[$i]->ies_date."' , 'priority' : '".$support[$i]->ies_priority."'});";
		}

		for ($i=0; $i < count($project) ; $i++) { 
			echo "project.push({'id' : '".$project[$i]->iextpp_id."' , 'name' : '".$project[$i]->iextpp_p_name."' , 's_date' : '".$project[$i]->iextpp_p_start_date."' , 'e_date' : '".$project[$i]->iextpp_p_end_date."' , 'status' : '".$project[$i]->iextpp_p_status."' });";
		}

		for ($i=0; $i < count($invoice) ; $i++) { 
			echo "invoice.push({'id' : '".$invoice[$i]->iextein_id."' , 'txn_id' : '".$invoice[$i]->iextein_txn_id."' , 's_date' : '".$invoice[$i]->iextein_txn_date."' , 'warranty' : '".$invoice[$i]->iextein_warranty."' , 'status' : '".$invoice[$i]->iextein_status."' , 'amt' : '".$invoice[$i]->iextein_amount."' });";
		}

		for ($i=0; $i < count($proposal) ; $i++) { 
			echo "proposal.push({'id' : '".$proposal[$i]->iextepro_id."' , 'txn_id' : '".$proposal[$i]->iextepro_txn_id."' , 's_date' : '".$proposal[$i]->iextepro_txn_date."' , 'status' : '".$proposal[$i]->iextepro_status."' , 'amt' : '".$proposal[$i]->iextepro_amount."' });";
		}

		for ($i=0; $i < count($amc) ; $i++) { 
			echo "amc.push({'id' : '".$amc[$i]->iextamc_id."' , 'txn_id' : '".$amc[$i]->iextamc_txn_id."' , 's_date' : '".$amc[$i]->iextamc_period_from."' , 'e_date' : '".$amc[$i]->iextamc_period_to."' , 'status' : '".$amc[$i]->iextamc_status."' , 'amt' : '".$amc[$i]->iextamc_amount."' });";
		}

		for ($i=0; $i < count($inv) ; $i++) { 
			echo "inv.push({'id' : '".$inv[$i]->iextei_id."' , 'txn_id' : '".$inv[$i]->iextei_txn_id."' , 's_date' : '".$inv[$i]->iextei_txn_date."' , 'warranty' : '".$inv[$i]->iextei_warranty."' , 'status' : '".$inv[$i]->iextei_status."' });";
		}

		for ($i=0; $i < count($boq) ; $i++) {
			for ($ij=0; $ij < count($boq_details) ; $ij++) {
				if ($boq_details[$ij]->iextetboqm_boq_id == $boq[$i]->iextetboq_id ) {
					$status = $boq_details[$ij]->iextetboqm_status;
				}
			}
			echo "boq.push({'id' : '".$boq[$i]->iextetboq_id."' , 'title' : '".$boq[$i]->iextetboq_title."' , 's_date' : '".$boq[$i]->iextetboq_created."' , 'status' : '".$status."' });";
		}
	?>

	$(document).ready( function() {
		display_details();

		function display_details() {
			var out = '';
			out += '<thead><tr><th>Sr. no. </th><th>Ticket ID</th><th>Subject</th><th>Date</th><th>Priority</th></tr></thead>';
			out += '<tbody>';
			if (support.length > 0 ) {
				var srno = 1;
				for (var i = 0; i < support.length; i++) {
					out += '<tr><td>'+srno+'</td><td>'+support[i].tkt_id+'</td><td>'+support[i].subject+'</td><td>'+support[i].date+'</td><td>'+support[i].priority+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="5">No records found !</td></tr>';
			}
			out += '</tbody>';
			$('#support_table').empty();
			$('#support_table').append(out);

			out = '';
			out += '<thead><tr><th>Sr. no. </th><th>Name</th><th>Start date</th><th>End date</th><th>Status</th></tr></thead>';
			out += '<tbody>';
			if (project.length > 0 ) {
				var srno = 1;
				for (var i = 0; i < project.length; i++) {
					out += '<tr><td>'+srno+'</td><td>'+project[i].name+'</td><td>'+project[i].s_date+'</td><td>'+project[i].e_date+'</td><td>'+project[i].status+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
			}
			out += '</tbody>';
			$('#project_table').empty();
			$('#project_table').append(out);

			out = '';
			out += '<thead><tr><th>Sr. no. </th><th>Txn ID</th><th>Start date</th><th>Warranty(in month)</th><th>Status</th><th>Amount</th></tr></thead>';
			out += '<tbody>';
			if (invoice.length > 0 ) {
				var srno = 1;
				for (var i = 0; i < invoice.length; i++) {
					out += '<tr><td>'+srno+'</td><td>'+invoice[i].txn_id+'</td><td>'+invoice[i].s_date+'</td><td>'+invoice[i].warranty+'</td><td>'+invoice[i].status+'</td><td>'+invoice[i].amt+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
			}
			out += '</tbody>';
			$('#invoice_table').empty();
			$('#invoice_table').append(out);

			out = '';
			out += '<thead><tr><th>Sr. no. </th><th>Txn ID</th><th>Start date</th><th>Status</th><th>Amount</th></tr></thead>';
			out += '<tbody>';
			if (proposal.length > 0 ) {
				var srno = 1;
				for (var i = 0; i < proposal.length; i++) {
					out += '<tr><td>'+srno+'</td><td>'+proposal[i].txn_id+'</td><td>'+proposal[i].s_date+'</td><td>'+proposal[i].status+'</td><td>'+proposal[i].amt+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
			}
			out += '</tbody>';
			$('#proposal_table').empty();
			$('#proposal_table').append(out);

			out = '';
			out += '<thead><tr><th>Sr. no. </th><th>Txn ID</th><th>Start date</th><th>End date</th><th>Status</th><th>Amount</th></tr></thead>';
			out += '<tbody>';
			if (amc.length > 0 ) {
				var srno = 1;
				for (var i = 0; i < amc.length; i++) {
					out += '<tr><td>'+srno+'</td><td>'+amc[i].txn_id+'</td><td>'+amc[i].s_date+'</td><td>'+amc[i].e_date+'</td><td>'+amc[i].status+'</td><td>'+amc[i].amt+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
			}
			out += '</tbody>';
			$('#amc_table').empty();
			$('#amc_table').append(out);

			out = '';
			out += '<thead><tr><th>Sr. no. </th><th>Txn ID</th><th>Start date</th><th>Warranty</th><th>Status</th></tr></thead>';
			out += '<tbody>';
			if (inv.length > 0 ) {
				var srno = 1;
				for (var i = 0; i < inv.length; i++) {
					out += '<tr><td>'+srno+'</td><td>'+inv[i].txn_id+'</td><td>'+inv[i].s_date+'</td><td>'+inv[i].warranty+'</td><td>'+inv[i].status+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
			}
			out += '</tbody>';
			$('#inv_table').empty();
			$('#inv_table').append(out);

			out = '';
			out += '<thead><tr><th>Sr. no. </th><th>Name</th><th>Date</th><th>Status</th></tr></thead>';
			out += '<tbody>';
			if (boq.length > 0 ) {
				var srno = 1;
				for (var i = 0; i < boq.length; i++) {
					out += '<tr class="boq_table_id" id="'+boq[i].id+'"><td>'+srno+'</td><td>'+boq[i].title+'</td><td>'+boq[i].s_date+'</td><td>'+boq[i].status+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
			}
			out += '</tbody>';
			$('#boq_table').empty();
			$('#boq_table').append(out);
		}

		$('#boq_table').on('click','.boq_table_id',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			sel_boq = id;
			$.post('<?php echo base_url()."Home/get_boq_details/".$code."/";?>'+id
            , function(data, status, xhr) {
                var a = JSON.parse(data);
                table_arr = [];
                for (var i = 0; i < boq.length; i++) {
                	if (boq[i].id == id) {
                		$('.boq_title').append(boq[i].title);
                	}
                }
                for (var i=0; i < a.length ; i++) {
                    table_arr.push({'id' : a[i]['id'] , 'title' : '' , 'level' : a[i]['level'] , 'full_width' : a[i]['full_width'] , 'row_data' : [] });
                    for (var ij=0; ij < a[i]['row_data'].length ; ij++) {
                        table_arr[i]['row_data'].push({'data' : a[i]['row_data'][ij]['data']});
                    }
                }
                display_boq_form();
            }, "text");
		});

		function display_boq_form() {
			var out = '';
            out += '<thead style="border: 1px solid #ccc;">';
            var count_flg = 0;
            for (var i = 0; i < table_arr.length; i++) {
                if (i == 0) {
                    count_flg = table_arr[i]['row_data'].length;
                }else if(table_arr[i]['row_data'].length > count_flg){
                    count_flg = table_arr[i]['row_data'].length;
                }
            }

            for (var i = 0; i < table_arr.length; i++) {
                out+= '<tr style="border: 1px solid #ccc;">';
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    if (table_arr[i]['full_width'] == 'yes') {
                        out += '<th colspan="'+count_flg+'">';    
                    }else{
                        out += '<th colspan="">';
                    }
                    if (table_arr[i]['row_data'][ij]['data'] == '') {
                    	out += '<input type="text" class="mdl-textfield__input col_text" id="'+i+'/'+ij+'" value="'+table_arr[i]['row_data'][ij]['data']+'" style="outline:none;text-align:center;" placeholder="Enter ">';
                    }else{
                    	out += '<p style="text-align:center;font-weight:bold;">'+table_arr[i]['row_data'][ij]['data']+'</p>';
                    }
                    out += '</th>';
                }
                out+= '</tr>';
            }
            out += '</thead>';
            $('.boq_det_table').empty();
            $('.boq_det_table').append(out);
            $('#boq_modal').modal('show');
		}

		$('.boq_det_table').on('keyup','.col_text',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            var val = $(this).val();

            var index_id = id.search("/");
            var level_id = id.substring(0, index_id);
            var column_id = id.substring(index_id + 1,id.length);
            for (var i = 0; i < table_arr.length; i++) {
                if(table_arr[i]['id'] == level_id){
                    table_arr[i]['row_data'][column_id]['data'] = val;
                }
            }
        });

		$('#boq_modal').on('click','.send_boq',function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Home/send_boq_details/".$code."/";?>'+sel_boq,{
				'table_arr' : table_arr
			}, function(data, status, xhr) {
                window.location = '<?php echo base_url().'Home/client_view/'.$code; ?>';
            }, "text");
		});

	});
</script>





