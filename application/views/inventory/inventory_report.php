<style type="text/css">
.timeline {
	position: relative;
	max-width: 1200px;
	margin: 0 auto;
}
.timeline::after {
	content: '';
	position: absolute;
	width: 6px;
	background-color: #000;
	top: 0;
	bottom: 0;
	left: 50%;
	margin-left: -3px;
}

.container {
	padding: 10px 40px;
	position: relative;
	background-color: inherit;
	width: 98%;
}

.container::after {
	content: '';
	position: absolute;
	width: 25px;
	height: 25px;
	right: -17px;
	background-color: white;
	border: 4px solid #FF9F55;
	top: 15px;
	border-radius: 50%;
	z-index: 1;
}

.left {
	left: -50%;
}

.right {
	left: 46%;
}

.left::before {
	content: " ";
	height: 0;
	position: absolute;
	top: 22px;
	width: 0;
	z-index: 1;
	right: 30px;
	border: medium solid white;
	border-width: 10px 0 10px 10px;
	border-color: transparent transparent transparent white;
}

.right::before {
	content: " ";
	height: 0;
	position: absolute;
	top: 22px;
	width: 0;
	z-index: 1;
	left: 30px;
	border: medium solid white;
	border-width: 10px 10px 10px 0;
	border-color: transparent white transparent transparent;
}

.right::after {
	left: 0%;
}

.content {
	padding: 20px 30px;
	background-color: white;
	position: relative;
	border-radius: 6px;
	box-shadow: 0px 3px 5px #ccc;
	width: 25em;
}
@media screen and (max-width: 600px) {
	.timeline::after {
		left: 31px;
	}
	.left::before {
		display: none;
	}
	.right::before {
		display: none;
	}

	.left::after, .right::after {
		left: 1%;
	}

	.right {
		left: 5%;
	}
	.left {
		left: 5%;
	}

	.content {
		width: 15em;
	}
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<main class="mdl-layout__content">
    <div class="mdl-grid">
    	<div class="mdl-cell mdl-cell--3-col">
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <select class="mdl-textfield__input" id="in_report">
                    <option value="0">Select Report</option>
                    <option value="in_out_report">Inward-Outward</option>
                    <option value="most_least_report">Most And Least Product Purchase by vendor</option>
                    <option value="pop_in_out_report">Popular Product Inward And Outward</option>
                    <option value="get_product_track">View Product track</option>
                    <option value="get_doc_track">View Document track</option>
                    <option value="get_product_limit">Product Stock bellow limit</option>
                </select>
            </div>
    	</div>
    	<div class="mdl-cell mdl-cell--3-col">
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="Date" id="fr_date" value="<?php echo date('Y-m-d'); ?>">
                <label class="mdl-textfield__label" for="fr_date">From Date</label>
            </div>
    	</div>
    	<div class="mdl-cell mdl-cell--3-col">
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="Date" id="to_date" value="<?php echo date('Y-m-d'); ?>">
                <label class="mdl-textfield__label" for="to_date">To Date</label>
            </div>
    	</div>
    	<div class="mdl-cell mdl-cell--3-col pro_barcode_field">
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="pro_barcode" >
                <label class="mdl-textfield__label" for="pro_barcode">Product Barcode</label>
            </div>
    	</div>
        <div class="mdl-cell mdl-cell--3-col pro_doc_field" style="display: none;">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="pro_txn" >
                <label class="mdl-textfield__label" for="pro_txn">Enter Txn Number</label>
            </div>
        </div>
    </div>
    <div class="mdl-grid report_display"></div>
</main>
<script type="text/javascript">
    $(document).ready(function() {
        $( "#fr_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $( "#to_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        $('#in_report').change(function(e){
        	e.preventDefault();
        	if ($('#in_report').val() != 'get_product_track' && $('#in_report').val() != 'get_doc_track') {
        		get_data();
        	}

            if ($('#in_report').val() == 'get_doc_track') {
                $('.pro_barcode_field').css('display','none');
                $('.pro_doc_field').css('display','block');
            }
        });

        $('#fr_date').change(function(e){
        	e.preventDefault();
        	if($('#fr_date').val() > $('#to_date').val()){
        		$('#to_date').val($('#fr_date').val());
        	}
        	if ($('#pro_barcode').val() != '' && $('#in_report').val() != 'null') {
        		get_data();
        	}
        });

        $('#to_date').change(function(e){
        	e.preventDefault();
        	if($('#fr_date').val() > $('#to_date').val()){
        		$('#fr_date').val($('#to_date').val());
        	}
        	if ($('#pro_barcode').val() != '' && $('#in_report').val() != 'null') {
        		get_data();
        	}
        });

        $('#pro_barcode').keyup(function(e){
        	e.preventDefault();
        	if (e.keyCode == 13) {
        		get_data();
        	}
        });

        $('#pro_txn').keyup(function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                get_data();
            }
        });

        function get_data(){
        	var r_type = $('#in_report').val();
        	if (r_type != '0') {
        		url = '<?php echo base_url()."Inventory/"; ?>'+r_type+'/<?php echo $code; ?>';
	        	$.post(url,{
	        		'fr_date' : $('#fr_date').val(),
	        		'to_date' : $('#to_date').val(),
	        		'pro_barcode' : $('#pro_barcode').val(),
                    'pro_txn' : $('#pro_txn').val()
	        	},function(data,xhr,status){
	        		var d = JSON.parse(data);
	        		if (r_type == 'in_out_report') {
	        			in_out_report(d);
	        		}
	        		if (r_type == 'most_least_report') {
	        			most_least_report(d);
	        		}
	        		if (r_type == 'pop_in_out_report') {
	        			pop_in_out_report(d);
	        		}
	        		if (r_type == 'get_product_track') {
	        			$('#pro_barcode').focus();
	        			get_product_track(d);
	        		}
                    if (r_type == 'get_doc_track') {
                        $('#pro_txn').focus();
                        get_doc_track(d);
                    }
                    if (r_type == 'get_product_limit') {
                        get_product_limit(d);
                    }
	        	},'text');
        	}else{
        		$('.report_display').empty();
        	}
        }

        function in_out_report(d){
        	var out = '';
        	out += '<table class="general_table"><thead><tr><th>Sr. No</th><th>Product Name</th><th>Opening stock</th><th>Inward</th><th>Outward</th><th>Closing stock</th></tr></thead><tbody>';
        	if (d.in_out.length > 0 ) {
        		var sr_no = 0;
        		for (var i = 0; i < d.in_out.length; i++) {
        			sr_no++;
        			out += '<tr><td>'+sr_no+'</td><td>'+d.in_out[i].pname+'</td><td>'+d.in_out[i].s_stock+'</td><td>'+d.in_out[i].in+'</td><td>'+d.in_out[i].out+'</td><td>'+d.in_out[i].bal+'</td></tr>';
        		}
        	}else{
        		out += '<tr><td colspan ="6">No Records Found !</td></tr>';
        	}
			out += '</tbody></table>';

			$('.report_display').empty();
			$('.report_display').append(out);
        }

        function most_least_report(d){
        	var out = '';
        	out += '<div class="mdl-cell mdl-cell--12-col">';
        	if (d.in_out.length > 0 ) {
        		out += '<h4>Most Product Purchase By Vendor : '+d.in_out[0].pname+'</h4>';
        		out += '<h4>Least Product Purchase By Vendor : '+d.in_out[d.in_out.length-1].pname+'</h4>';
        	}
        	out += '</div><div class="mdl-cell mdl-cell--6-col" style="height:70%;overflow:auto;background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;">';
        	out += '<table class="general_table"><thead><tr><th>Sr. No</th><th>Product Name</th><th>Qty</th></tr></thead><tbody>';
        	if (d.in_out.length > 0 ) {
        		var sr_no = 0;
    			for (var i = 0; i < d.in_out.length; i++) {
        			sr_no++;
        			out += '<tr><td>'+sr_no+'</td><td>'+d.in_out[i].pname+'</td><td>'+d.in_out[i].out+'</td></tr>';
        		}
        	}else{
        		out += '<tr><td colspan ="3">No Records Found !</td></tr>';
        	}
			out += '</tbody></table></div><div class="mdl-cell mdl-cell--6-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;"><div class="mdl-grid" style="text-align:center;"><div class="mdl-cell mdl-cell--2-col"></div><div class="mdl-cell mdl-cell--8-col"><canvas id="ch1" width="60" height="60"></canvas></div></div></div>';
			$('.report_display').empty();
			$('.report_display').append(out);

			var ctx = document.getElementById("ch1").getContext("2d");
			color_arr=[];
			for (var i = 0; i < d.pro.length; i++) {
	    		r = Math.floor(Math.random() * 254);
				g = Math.floor(Math.random() * 254);
				b = Math.floor(Math.random() * 254);
				color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
	    		color_arr.push(color);
	    	}
			var myChart = new Chart(ctx, {type: "pie", data: {labels: d.pro, datasets: [{ label: d.pro, data: d.out, backgroundColor: color_arr }] }, options: { title : { display: true, text: "Product Purchase By Vendor" } , rotation : -0.1 * Math.PI } });
        }

        function pop_in_out_report(d){
        	var out = '';
        	out += '<div class="mdl-cell mdl-cell--6-col" style="height:70%;overflow:auto;background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;"><h3>Popular product in inward</h3>';
        	out += '<table class="general_table"><thead><tr><th>Sr. No</th><th>Product Name</th><th>Qty</th></tr></thead><tbody>';
        	if (d.in.length > 0 ) {
        		var sr_no = 0;
        		for (var i = 0; i < d.in.length; i++) {
        			sr_no++;
        			out += '<tr><td>'+sr_no+'</td><td>'+d.in[i].pname+'</td><td>'+d.in[i].qty+'</td></tr>';
        		}
        	}else{
        		out += '<tr><td colspan ="6">No Records Found !</td></tr>';
        	}
			out += '</tbody></table>';
        	out += '</div>';
        	out += '<div class="mdl-cell mdl-cell--6-col" style="height:70%;overflow:auto;background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;"><h3>Popular product in outward</h3>';
        	out += '<table class="general_table"><thead><tr><th>Sr. No</th><th>Product Name</th><th>Qty</th></tr></thead><tbody>';
        	if (d.out.length > 0 ) {
        		var sr_no = 0;
        		for (var i = 0; i < d.out.length; i++) {
        			sr_no++;
        			out += '<tr><td>'+sr_no+'</td><td>'+d.out[i].pname+'</td><td>'+d.out[i].qty+'</td></tr>';
        		}
        	}else{
        		out += '<tr><td colspan ="6">No Records Found !</td></tr>';
        	}
			out += '</tbody></table>';
        	out += '</div>';
			$('.report_display').empty();
			$('.report_display').append(out);
        }

        function get_product_track(d){
        	var out = '';
        	if (d.pro_tarck.length > 0 ) {
        		out += '<div class="timeline">';
        		var flg = 0;
        		for (var i = 0; i < d.pro_tarck.length; i++) {
        			if (flg == 0 ) {
        				out += '<div class="container left">';
        				flg = 1;
        			}else{
        				out += '<div class="container right">';
        				flg = 0;
        			}
				    out += '<div class="content"><h3>'+d.pro_tarck[i].ip_product+'</h3><h4>'+d.pro_tarck[i].iin_created+'</h4>';
				    var from = '';
        			if (d.pro_tarck[i].iin_from_type == 'account') {
        				for (var ij = 0; ij < d.account.length; ij++) {
        					if(d.pro_tarck[i].iin_from == d.account[ij].iia_id){
        						from = d.account[ij].iia_name;
        					}
        				}
        			}else if (d.pro_tarck[i].iin_from_type == 'contact') {
        				for (var ij = 0; ij < d.cust.length; ij++) {
        					if(d.pro_tarck[i].iin_from == d.cust[ij].ic_id){
        						from = d.cust[ij].ic_name;
        					}
        				}
        			}else{
        				for (var ij = 0; ij < d.location.length; ij++) {
        					if(d.pro_tarck[i].iin_from == d.location[ij].id){
        						from = d.location[ij].text;
        					}
        				}
        			}
        			var to = '';
        			if (d.pro_tarck[i].iin_to_type == 'account') {
        				for (var ij = 0; ij < d.account.length; ij++) {
        					if(d.pro_tarck[i].iin_to == d.account[ij].iia_id){
        						to = d.account[ij].iia_name;
        					}
        				}
        			}else if (d.pro_tarck[i].iin_to_type == 'contact') {
        				for (var ij = 0; ij < d.cust.length; ij++) {
        					if(d.pro_tarck[i].iin_to == d.cust[ij].ic_id){
        						to = d.cust[ij].ic_name;
        					}
        				}
        			}else{
        				for (var ij = 0; ij < d.location.length; ij++) {
        					if(d.pro_tarck[i].iin_to == d.location[ij].id){
        						to = d.location[ij].text;
        					}
        				}
        			}
				    out += '<p>From : '+from+' <br> To : '+to+'</p></div></div>';
				}
				out += '</div>';
        	}else{
        		out += '<h3>Records Not Found !</h3>';
        	}
			$('.report_display').empty();
			$('.report_display').append(out);
        }

        $('.report_display').on('click','#follow_up',function (e) {
            e.preventDefault();
            $.post('<?php echo base_url()."View/activity_modal/".$code."/purchase_order/"; ?>'
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
        });

        function get_doc_track(d){
            var out = '';
            if (d.inv_list.length > 0 ) {
                out += '<div class="timeline">';
                var flg = 0;
                for (var i = 0; i < d.inv_list.length; i++) {
                    if (d.inv_list[i].iextemt_from_mid == d.mid) {
                        out += '<div class="container left"><div class="content"><h2>Inventory</h2>';
                        out += '<h3>'+d.inv[0].iextei_txn_id+'</h3>';
                        out += '<h3>'+d.inv[0].iextei_created+'</h3></div></div>';

                        out += '<div class="container right"><div class="content">';
                        for (var j = 0; j < d.module.length; j++) {
                            if(d.module[j].mid == d.inv_list[i].iextemt_to_mid){
                                if (d.module[j].mname == 'Invoice') {
                                    for (var ij = 0; ij < d.invoice.length; ij++) {
                                        if(d.invoice[ij].iextein_id == d.inv_list[i].iextemt_to_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.invoice[ij].iextein_txn_id+'</h3>';
                                            out += '<h3>'+d.invoice[ij].iextein_created+'</h3></div></div>';
                                        }
                                    }
                                }
                                if (d.module[j].mname == 'Proposal') {
                                    for (var ij = 0; ij < d.proposal.length; ij++) {
                                        if(d.proposal[ij].iextepro_id == d.inv_list[0].iextemt_to_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.proposal[0].iextepro_txn_id+'</h3>';
                                            out += '<h3>'+d.proposal[0].iextepro_created+'</h3></div></div>';
                                        }
                                    }
                                }
                                if (d.module[j].mname == 'Purchase') {
                                    for (var ij = 0; ij < d.purchase.length; ij++) {
                                        if(d.purchase[ij].iextep_id == d.inv_list[0].iextemt_to_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.purchase[0].iextep_ixn_id+'</h3>';
                                            out += '<h3>'+d.purchase[0].iextep_created+'</h3></div></div>';
                                        }
                                    }
                                }
                                if (d.module[j].mname == 'Order') {
                                    for (var ij = 0; ij < d.order.length; ij++) {
                                        if(d.order[ij].iextetor_id == d.inv_list[0].iextemt_to_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.order[0].iextetor_txn_id+'</h3>';
                                            out += '<h3>'+d.order[0].iextetor_created+'</h3></div></div>';
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        out += '<div class="container left"><div class="content">';
                        for (var j = 0; j < d.module.length; j++) {
                            if(d.module[j].mid == d.inv_list[i].iextemt_from_mid){
                                if (d.module[j].mname == 'Invoice') {
                                    for (var ij = 0; ij < d.invoice.length; ij++) {
                                        if(d.invoice[ij].iextein_id == d.inv_list[i].iextemt_from_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.invoice[ij].iextein_txn_id+'</h3>';
                                            out += '<h3>'+d.invoice[ij].iextein_created+'</h3></div></div>';
                                        }
                                    }
                                }
                                if (d.module[j].mname == 'Proposal') {
                                    for (var ij = 0; ij < d.proposal.length; ij++) {
                                        if(d.proposal[ij].iextepro_id == d.inv_list[0].iextemt_from_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.proposal[0].iextepro_txn_id+'</h3>';
                                            out += '<h3>'+d.proposal[0].iextepro_created+'</h3></div></div>';
                                        }
                                    }
                                }
                                if (d.module[j].mname == 'Purchase') {
                                    for (var ij = 0; ij < d.purchase.length; ij++) {
                                        if(d.purchase[ij].iextep_id == d.inv_list[0].iextemt_from_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.purchase[0].iextep_ixn_id+'</h3>';
                                            out += '<h3>'+d.purchase[0].iextep_created+'</h3></div></div>';
                                        }
                                    }
                                }
                                if (d.module[j].mname == 'Order') {
                                    for (var ij = 0; ij < d.order.length; ij++) {
                                        if(d.order[ij].iextetor_id == d.inv_list[0].iextemt_from_txn){
                                            out += '<h2>'+d.module[j].mname+'</h2>';
                                            out += '<h3>'+d.order[0].iextetor_txn_id+'</h3>';
                                            out += '<h3>'+d.order[0].iextetor_created+'</h3></div></div>';
                                        }
                                    }
                                }
                            }
                        }

                        out += '<div class="container right"><div class="content"><h2>Inventory</h2>';
                        out += '<h3>'+d.inv[0].iextei_txn_id+'</h3>';
                        out += '<h3>'+d.inv[0].iextei_created+'</h3></div></div>';
                    }
                    out += '</div></div>';
                }
                out += '</div>';
            }else{
                out += '<h3>Records Not Found !</h3>';
            }
            $('.report_display').empty();
            $('.report_display').append(out);
        }

        function get_product_limit(d){
            var out = '';
            out += '<div class="mdl-cell mdl-cell--6-col" style="height:70%;overflow:auto;background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;">';
            out += '<button class="mdl-button mdl-button--colored" id="follow_up"><i class="material-icons">watch_later</i> Schedule purchase order</button>';
            out += '<table class="general_table"><thead><tr><th>Sr. No</th><th>Product Name</th><th>Qty</th></tr></thead><tbody>';
            if (d.in_out.length > 0 ) {
                var sr_no = 0;
                for (var i = 0; i < d.in_out.length; i++) {
                    sr_no++;
                    out += '<tr><td>'+sr_no+'</td><td>'+d.in_out[i].pname+'</td><td>'+d.in_out[i].out+'</td></tr>';
                }
            }else{
                out += '<tr><td colspan ="3">No Records Found !</td></tr>';
            }
            out += '</tbody></table></div>';
            out += '<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;"><div class="mdl-grid" style="text-align:center;"><div class="mdl-cell mdl-cell--2-col"></div><div class="mdl-cell mdl-cell--8-col"><canvas id="ch2" width="60" height="60"></canvas></div></div></div>';
            $('.report_display').empty();
            $('.report_display').append(out);

            var ctx = document.getElementById("ch2").getContext("2d");
            color_arr=[];
            for (var i = 0; i < d.pro.length; i++) {
                r = Math.floor(Math.random() * 254);
                g = Math.floor(Math.random() * 254);
                b = Math.floor(Math.random() * 254);
                color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
                color_arr.push(color);
            }
            var myChart = new Chart(ctx, {type: "pie", data: {labels: d.pro, datasets: [{ label: d.pro, data: d.out, backgroundColor: color_arr }] }, options: { title : { display: true, text: "Product Stock bellow limit" } , rotation : -0.1 * Math.PI } });
        }
    });
</script>