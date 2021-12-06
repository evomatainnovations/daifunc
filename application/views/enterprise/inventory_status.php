<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
	.mdl-card__title {
		height: 170px;
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
        padding: 15px;
        border: 1px solid #ccc;
    }

    .general_table > tbody {
        border: 1px solid #ccc;
    }
    .general_table > tbody > tr {
        /*border-bottom: 1px solid #ccc;*/
    }

    .general_table > tbody > tr > td {
        padding: 15px;
        border: 1px solid #ccc;
    }

    .general_table > tfoot > tr {
        border: 1px solid #ccc;
    }

    .general_table > tfoot > tr > td {
        padding: 15px;
    }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
            <div class="">
                <label>Type Products</label>
                <ul id="product" class="mdl-textfield__input">
                </ul>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--4-col">
            <div class="">
                <label>Filter By Customers/Vendors</label>
                <ul id="customer" class="mdl-textfield__input">
                </ul>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--4-col">
            <!-- <label>If you find irregular records, click here</label>
            <button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="reconcile" style="width: 100%;">Reconcile Stocks</button> -->
            <div class="">
                <label>Filter By Serial Number</label>
                <ul id="serial_no" class="mdl-textfield__input">
                </ul>
            </div>
        </div>

    </div>
    <hr>
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col" id="result1" style="box-shadow: 0px 3px 10px #ccc;display: flex;overflow: auto;display: flex;">
            <?php
                echo '<table class="general_table" style="width:50%;"><thead><tr><th>Product</th><th>Available Qty</th></tr></thead><tbody>';
                for ($i=0; $i < count($products) ; $i++) {
                    for ($j=0; $j < count($product_list) ; $j++) { 
                        if ($products[$i]->ip_id == $product_list[$j]['pid'] ) {
                            echo "<tr><td>".$products[$i]->ip_product."</td><td>".$product_list[$j]['bal']."</td></tr>";
                        }
                    }
                }
                echo "</tbody></table>";

                echo '<table class="general_table" style="width:50%;">';
                echo "<tbody>";
                echo "<tr><td>Total Balance</td><td>".$bal."</td></tr>";
                echo "<tr><td>Total Spare</td><td>".$spare."</td></tr>";
                echo "<tr><td>Total Defective</td><td>".$def."</td></tr>";
                echo "<tr><td>Customer Count</td><td>".$c_co."</td></tr>";
                echo "<tr><td>Vendor Defective Count</td><td>".$ven."</td></tr>";
                echo "</tbody>";
                echo "</table>";
            ?>
        </div>
    </div>
    <div id="res_bal"></div>
    <div id="result_inv" style="box-shadow: 0px 3px 10px #ccc; display: flex;height: 65vh;overflow: auto;"></div>
    <div id="demo-snackbar-example" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>
    <style>
        td {
            padding: 10px;
        }
    </style>
</main>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var product_data = [];
        <?php
            for ($i=0; $i < count($products) ; $i++) { 
                echo "product_data.push('".$products[$i]->ip_product."');";
            }
        ?>

        $('#product').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : product_data,
            afterTagAdded : (function(event, ui) {
                getrecords();
            }),
            afterTagRemoved : (function(event, ui) {
                getrecords();
            })
        });

        var customer_data = [];
        <?php
            for ($i=0; $i < count($customers) ; $i++) { 
                echo "customer_data.push('".$customers[$i]->ic_name."');";
            }
        ?>
        
        $('#customer').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : customer_data,
            afterTagAdded : (function(event, ui) {
                getrecords();
            }),
            afterTagRemoved : (function(event, ui) {
                getrecords();
            })
        });

        var sn_data = [];
        <?php
            for ($i=0; $i < count($sn) ; $i++) { 
                echo "sn_data.push('".$sn[$i]->sn."');";
            }
        ?>
        
        $('#serial_no').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : sn_data,
            afterTagAdded : (function(event, ui) {
                getrecords();
            }),
            afterTagRemoved : (function(event, ui) {
                getrecords();
            })
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
    	
    	function getrecords() {
            var product = [];
            $('#product > li').each(function(index) {
                var tmpstr = $(this).text();
                var len = tmpstr.length - 1;
                if(len > 0) {
                    tmpstr = tmpstr.substring(0, len);
                    product.push(tmpstr);
                }
            });

            var customer = [];
            $('#customer > li').each(function(index) {
                var tmpstr = $(this).text();
                var len = tmpstr.length - 1;
                if(len > 0) {
                    tmpstr = tmpstr.substring(0, len);
                    customer.push(tmpstr);
                }
            });

            var sn = [];
            $('#serial_no > li').each(function(index) {
                var tmpstr = $(this).text();
                var len = tmpstr.length - 1;
                if(len > 0) {
                    tmpstr = tmpstr.substring(0, len);
                    sn.push(tmpstr);
                }
            });

            $.post('<?php echo base_url()."Enterprise/inventory_get_status/".$code; ?>', {
                "product" : product,
                "customer" : customer,
                "sn" : sn
            }, function(data, status, xhr) {
                if (status == "success") {
                    $('#result_inv').empty();
                    $('#result1').css('display','none');
                    var abcd = JSON.parse(data);
                    if (abcd.type == "none") {
                        $('#res_bal').css('display','none');
                        var pqr = '';
                        pqr += '<table class="general_table" style="width:50%;"><thead><tr><th>Product</th><th>Available Qty</th></tr></thead><tbody>';
                        for (var i=0; i < abcd.products.length ; i++) {
                            for (var j=0; j < abcd.product_list.length ; j++) { 
                                if (abcd.products[i].ip_id == abcd.product_list[j]['pid'] ) {
                                    pqr += "<tr><td>"+abcd.products[i].ip_product+"</td><td>"+abcd.product_list[j]['bal']+"</td></tr>";
                                }
                            }
                        }
                        pqr += "</tbody></table>";

                        pqr += '<table class="general_table" style="width:50%;">';
                        pqr += "<tbody>";
                        pqr += "<tr><td>Total Balance</td><td>"+abcd.bal+"</td></tr>";
                        pqr += "<tr><td>Total Spare</td><td>"+abcd.spare+"</td></tr>";
                        pqr += "<tr><td>Total Defective</td><td>"+abcd.def+"</td></tr>";
                        pqr += "<tr><td>Customer Count</td><td>"+abcd.c_co+"</td></tr>";
                        pqr += "<tr><td>Vendor Defective Count</td><td>"+abcd.ven+"</td></tr>";
                        pqr += "</tbody>";
                        pqr += "</table>";

                        $('#result_inv').append(pqr);
                    } else {
                        var abc = abcd.result;
                        var in_invoice = abcd.in_wrnt;
                        var p_invoice = abcd.p_wrnt;
                        var r_invoice = abcd.r_invoice;
                        var pqr = "";
                        if (abcd.balance != undefined) {
                            pqr = abcd.balance;                            
                        }
                        $('#res_bal').css('display','block');
                        $('#res_bal').empty();
                        $('#res_bal').append(pqr);
                        pqr = '';
                        pqr = '<table class="general_table"><thead><tr style="border: 1px solid #999; box-shadow: 0px 3px 5px #999;"><th>Name</th><th>Warranty status</th><th>Txn ID</th><th>Date</th><th>Type</th><th>Product</th><th>Serial Number</th><th>Inward</th><th>Outward</th><th>Balance</th></tr></thead><tbody>';
                        for (var i = 0; i < abc.length; i++) {
                            pqr += '<tr><td>' + abc[i].ic_name + '</td>';
                            if (abc[i].iextei_type == 'inward' || abc[i].iextei_type == 'spare' || abc[i].iextei_type == 'defective' || abc[i].iextei_type == 'def_sys' || abc[i].iextei_type == 'def_out' || abc[i].iextei_type == 'def_in' || abc[i].iextei_type == 'not_defective' || abc[i].iextei_type == 'not_def_ret' ) {
                                for (var ij = 0; ij < p_invoice.length; ij++) {
                                    if(p_invoice[ij].iexteppd_product_id == abc[i].iexteid_product_id && p_invoice[ij].iexteppd_serial_number == abc[i].iexteid_serial_number ){
                                        var wrt_month = p_invoice[ij].iextep_warranty;
                                        var st_date = new Date(p_invoice[ij].iextep_txn_date);
                                        to_date = st_date.setMonth(st_date.getMonth() + Number(wrt_month) );
                                        var CurrentDate = new Date();
                                        if (to_date > CurrentDate ) {
                                            pqr += '<td style="color:green">In Warranty</td>';
                                        }else{
                                            pqr += '<td style="color:red">Not in Warranty</td>';
                                        }
                                    }
                                }
                            }else if (abc[i].iextei_type == 'def_return') {
                                for (var j = 0; j < r_invoice.length; j++) {
                                    if(r_invoice[j].iexteir_to_serial_number == abc[i].iexteid_serial_number && r_invoice[j].iexteir_to_pid == abc[i].iexteid_product_id){
                                        var r_pid = r_invoice[j].iexteir_from_pid;
                                        var r_sn = r_invoice[j].iexteir_from_serial_number;
                                        for (var ij = 0; ij < in_invoice.length; ij++) {
                                            if(in_invoice[ij].iexteinpd_product_id == r_pid && in_invoice[ij].iexteinpd_serial_number == r_sn ){
                                                var wrt_month = in_invoice[ij].iextein_warranty;
                                                var st_date = new Date(in_invoice[ij].iextein_txn_date);
                                                to_date = st_date.setMonth(st_date.getMonth() + Number(wrt_month) );
                                                var CurrentDate = new Date();
                                                if (to_date > CurrentDate ) {
                                                    pqr += '<td style="color:green">In Warranty</td>';
                                                }else{
                                                    pqr += '<td style="color:red">Not in Warranty</td>';
                                                }
                                            }
                                        }
                                        break;
                                    }
                                }
                            }else{
                                for (var ij = 0; ij < in_invoice.length; ij++) {
                                    if(in_invoice[ij].iexteinpd_product_id == abc[i].iexteid_product_id && in_invoice[ij].iexteinpd_serial_number == abc[i].iexteid_serial_number ){
                                        var wrt_month = in_invoice[ij].iextein_warranty;
                                        var st_date = new Date(in_invoice[ij].iextein_txn_date);
                                        to_date = st_date.setMonth(st_date.getMonth() + Number(wrt_month) );
                                        var CurrentDate = new Date();
                                        if (to_date > CurrentDate ) {
                                            pqr += '<td style="color:green">In Warranty</td>';
                                        }else{
                                            pqr += '<td style="color:red">Not in Warranty</td>';
                                        }
                                    }
                                }
                            }
                            pqr +='<td>' + abc[i].iextei_txn_id + '</td><td>' + abc[i].iextei_txn_date + '</td><td>' + abc[i].iextei_type + '</td><td>' + abc[i].ip_product + '</td><td>' + abc[i].iexteid_serial_number + '</td>';
                            var inward = 0 ;
                            var outward = 0 ;
                            if (abc[i].iextei_type == 'inward') {
                                inward = inward + Number(abc[i].iexteid_balance) ;
                            }
                            if (abc[i].iextei_type == 'outward') {
                                outward = outward + Number(abc[i].iexteid_balance) ;
                            }
                            if (abc[i].iextei_type == 'spare') {
                                outward = outward + Number(abc[i].iexteid_balance) ;
                            }
                            if (abc[i].iextei_type == 'defective') {
                                inward = inward + Number(abc[i].iexteid_balance) ;
                            }
                            if (abc[i].iextei_type == 'def_return') {
                                outward = outward + Number(abc[i].iexteid_balance) ;
                            }
                            if (abc[i].iextei_type == 'def_sys') {
                                inward = inward + Number(abc[i].iexteid_balance) ;
                            }
                            if (abc[i].iextei_type == 'def_out') {
                                outward = outward + Number(abc[i].iexteid_balance) ;
                            }
                            if (abc[i].iextei_type == 'def_in') {
                                inward = inward + Number(abc[i].iexteid_balance) ;
                            }
                            pqr += '<td>' + inward  + '</td>';
                            pqr += '<td>' + outward + '</td>';
                            pqr += '<td>' + abc[i].iexteid_balance + '</td></tr>';
                        }
                        pqr += "</tbody></table>";

                        $('#result_inv').append(pqr);
                    }
                }
            }, "text");

            
        }
    });
</script>
</html>