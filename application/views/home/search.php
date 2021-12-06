<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script> -->
<!-- <script src="<?php echo base_url().'assets/js/particle.js'; ?>"></script> -->

<style>
	.mdl-card__title {
		/*height: auto;*/
		height: 80px;
        background-color: #fff;
        /*border-bottom: 1px solid #999;*/
        color: #999;
	}

    .mdl-card__title-text {
        border-bottom: 2px solid #ff0000;
        color: #ff0000;
        padding-bottom: 15px;
    }

    .mdl-layout {
        /*background-color:#ff0000;    */
    }
    
    a {
        color: #fff;
        text-decoration: none;
    }

    a:hover {
        color: #fff;
        text-decoration: none;
    }

    .body-theme {
        color: #999;
    }

    html, body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    #particle-canvas {
        width: 100%;
        height: 100%;
        z-index: 0;
    }

    .block {
        box-shadow: 1px 1px 5px #999;
        padding: 10px;
        margin-bottom: 10px;
        margin-left: 10px;
        border-radius: 10px 10px 10px 10px;
    }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-card mdl-shadow--4dp" style="height:auto; min-height: 0px; padding: 0px;width: 100%;">
                <div class="mdl-grid" style="width: 100%;">
                    <div class="mdl-cell mdl-cell--4-col">
                        <h2><i class="material-icons">search</i> Type keywords your looking for</h2>
                    </div>
                    <div class="mdl-cell mdl-cell--8-col" style="padding-top: 15px;padding-right: 20px;">
                        <!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> -->
                        <ul id="s_name" class="mdl-textfield__input" style="width: 100%;">
                        </ul>
                        <!-- </div> -->
                    </div>
                <!-- <div  class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> -->
                    
                    <!-- <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Search <i class="material-icons">search</i></button> -->
                </div>
			</div>
		</div>
	</div>
	
	<div class="mdl-grid" id="result">
	    <!-- <div class="mdl-cell mdl-cell--12-col" style="">
            <div class="mdl-card mdl-shadow--dp">
                <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">Inventory</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <div class="mdl-grid">
                        <div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">
                            <a style="color: #fff; :hover { color: #fff; }" href="">
                                <h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> Cosmos Electronics</h3>
                                <b style="font-size: 1.3em;margin: 30px;word-break: break-word;">COS/FYGE/5622655s1f51af</b>
                                <p style="font-size: 1.2em;margin-right: 10px;text-align: right;">12/10/2017</p>
                            </a>
                        </div>
                        <div class="mdl-cell--4-col people block" style="background-color: #e60000; color: #fff; text-align: left;">
                            <a style="color: #fff; :hover { color: #fff; }" href="">
                                <h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_upward</i> Cosmos Electronics</h3>
                                <b style="font-size: 1.3em;margin: 30px;word-break: break-word;">COS/FYGE/5622655s1f51af</b>
                                <p style="font-size: 1.2em;margin-right: 10px;text-align: right;">12/10/2017</p>
                            </a>
                        </div>
                        <div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">
                            <a style="color: #fff; :hover { color: #fff; }" href="">
                                <h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> Cosmos Electronics</h3>
                                <b style="font-size: 1.3em;margin: 30px;">COS/FYGE/5622655s1f51af</b>
                                <p style="font-size: 1.2em;margin-right: 10px;text-align: right;">12/10/2017</p>
                            </a>
                        </div>
                        <div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">
                            <a style="color: #fff; :hover { color: #fff; }" href="">
                                <h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> Cosmos Electronics</h3>
                                <b style="font-size: 1.3em;margin: 30px;">COS/FYGE/5622655s1f51af</b>
                                <p style="font-size: 1.2em;margin-right: 10px;text-align: right;">12/10/2017</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
	</div>
</main>
</div>

</body>
<script type="text/javascript">
    $(document).ready( function() {
        $('.block').click(function(e) {
            console.log($(this).prop('id'));
        });

        
        var keyword_arr = [];

        var tag_data = [];
        
        <?php
            for ($i=0; $i < count($tags) ; $i++) { 
                echo "tag_data.push('".$tags[$i]->it_value."');";
            }
        ?>
        
        $('#s_name').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : tag_data,
            singleField : true,
            allowDuplicates: true,
            afterTagAdded : (function(event, ui) {
                getinfo();
            }),
            afterTagRemoved : (function(event, ui) {
                getinfo();
            }),

        });


    });

    function getinfo() {
        var txn_tags = [];
        $('#s_name > li').each(function(index) {
            var tmpstr = $(this).text();
            var len = tmpstr.length - 1;
            if(len > 0) {
                tmpstr = tmpstr.substring(0, len);
                txn_tags.push(tmpstr);
            }
        });

        $.post('<?php echo base_url()."Home/search_records"; ?>', {
            'keywords' : txn_tags
        }, function(data, status, xhr) {
            var abc = JSON.parse(data);
            console.log(abc);
            $('#result').empty();

            if(abc.customer) {
                var cust = abc.customer;
                var cust_out = '<div class="mdl-cell mdl-cell--4-col" style=""> <div class="mdl-card mdl-shadow--dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">' + abc.customer_title + '</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < cust.length; i++) {
                    cust_out = cust_out + '<div class="mdl-cell--4-col people block">';
                    cust_out = cust_out + '<a style="color: #999; :hover { color: #999; }" href="<?php if($dom == "Education") { echo base_url()."Education/student_edit/"; } elseif($dom == "Enterprise") { echo base_url()."Enterprise/customer_edit/"; } ?>'+ cust[i].id + '"> <i class="material-icons">face</i><h4>' + cust[i].name + '</h4></a> </div>';
                }
                cust_out += '</div> </div> </div> </div>';
                $('#result').append(cust_out);
            }

            if(abc.product) {
                var prod = abc.product;

                var prod_out = '<div class="mdl-cell mdl-cell--4-col" style=""> <div class="mdl-card mdl-shadow--dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">' + abc.product_title  + '</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < prod.length; i++) {
                    prod_out = prod_out + '<div class="mdl-cell--4-col people block">';
                    prod_out = prod_out + '<a style="color: #999; :hover { color: #999; }" href="<?php if($dom == "Education") { echo base_url()."Education/student_edit/"; } elseif($dom == "Enterprise") { echo base_url()."Enterprise/"; } ?>';
                    
                    if (prod[i].type == "Courses") {
                        prod_out += "course_edit";
                    } else if(prod[i].type == "Products") {
                        prod_out += "product_edit";
                    } else if(prod[i].type == "Services") {
                        prod_out += "service_edit";
                    }

                    prod_out = prod_out + "/" + prod[i].id + '"> <i class="material-icons">stars</i><h4>' + prod[i].name + '</h4></a> </div>';
                }
                prod_out += '</div> </div> </div> </div>';
                $('#result').append(prod_out);                
            }

            if(abc.et_inventory) {
                var prod = abc.et_inventory;

                var prod_out = '<div class="mdl-cell mdl-cell--12-col" style=""> <div class="mdl-card mdl-shadow--dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">Inventory</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < prod.length; i++) {
                    if(prod[i].type == "inward") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">';    
                    } else {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #e60000; color: #fff; text-align: left;">';
                    }
                    prod_out = prod_out + '<a style="color: #fff; :hover { color: #fff; }" href="<?php if($dom == "Enterprise") { echo base_url()."Enterprise/inventory_edit/"; } else { echo "#"; } ?>' + '/' + prod[i].type + '/' + abc.invt_mod_id + '/' + prod[i].id + '"><h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> ' + prod[i].name + '</h3><b style="font-size: 1.3em;margin: 30px;word-break: break-word;">' + prod[i].txnid + '</b><p style="font-size: 1.2em;margin-right: 10px;text-align: right;">' + prod[i].tdate + '</p></a> </div>';
                }
                prod_out += '</div> </div> </div> </div>';
                $('#result').append(prod_out);                
            }
            
            if(abc.et_invoice) {
                var prod = abc.et_invoice;

                var prod_out = '<div class="mdl-cell mdl-cell--12-col" style=""> <div class="mdl-card mdl-shadow--dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">Invoice</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < prod.length; i++) {
                    if(prod[i].status == "paid") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">';    
                    } else {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #e60000; color: #fff; text-align: left;">';
                    }
                    prod_out = prod_out + '<a style="color: #fff; :hover { color: #fff; }" href="<?php if($dom == "Enterprise") { echo base_url()."Enterprise/invoice_edit/"; } else { echo "#"; } ?>' + '/' + abc.invc_mod_id + '/' + prod[i].id + '"><h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> ' + prod[i].name + '</h3><b style="font-size: 1.3em;margin: 30px;word-break: break-word;">' + prod[i].txnid + '</b><p style="font-size: 1.2em;margin-right: 10px;text-align: right;">' + prod[i].tdate + '</p></a> </div>';
                }
                prod_out += '</div> </div> </div> </div>';
                $('#result').append(prod_out);                
            }
            
            if(abc.et_quotation) {
                var prod = abc.et_quotation;

                var prod_out = '<div class="mdl-cell mdl-cell--12-col" style=""> <div class="mdl-card mdl-shadow--dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">Quotation</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < prod.length; i++) {

                    if(prod[i].status == "open") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #ffcc00; color: #fff; text-align: left;">';    
                    } else if(prod[i].status == "discuss") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #ff9933; color: #fff; text-align: left;">';    
                    } else if(prod[i].status == "consider") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #ff4d4d; color: #fff; text-align: left;">';    
                    } else if(prod[i].status == "neotiate") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #0073e6; color: #fff; text-align: left;">';    
                    } else if(prod[i].status == "cancel") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #737373; color: #fff; text-align: left;">';    
                    } else {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #59b300; color: #fff; text-align: left;">';
                    }
                    prod_out = prod_out + '<a style="color: #fff; :hover { color: #fff; }" href="<?php if($dom == "Enterprise") { echo base_url()."Enterprise/quotation_edit/"; } else { echo "#"; } ?>' + '/' + abc.quot_mod_id + '/' + prod[i].id + '"><h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> ' + prod[i].name + '</h3><b style="font-size: 1.3em;margin: 30px;word-break: break-word;">' + prod[i].txnid + '</b><p style="font-size: 1.2em;margin-right: 10px;text-align: right;">' + prod[i].tdate + '</p></a> </div>';
                }
                prod_out += '</div> </div> </div> </div>';
                $('#result').append(prod_out);                
            }
            
            if(abc.et_purchase) {
                var prod = abc.et_purchase;

                var prod_out = '<div class="mdl-cell mdl-cell--12-col" style=""> <div class="mdl-card mdl-shadow--dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">Purchase</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < prod.length; i++) {
                    if(prod[i].status == "paid") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">';    
                    } else {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #e60000; color: #fff; text-align: left;">';
                    }
                    prod_out = prod_out + '<a style="color: #fff; :hover { color: #fff; }" href="<?php if($dom == "Enterprise") { echo base_url()."Enterprise/purchase_edit/"; } else { echo "#"; } ?>' + '/' + abc.purc_mod_id + '/' + prod[i].id + '"><h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> ' + prod[i].name + '</h3><b style="font-size: 1.3em;margin: 30px;word-break: break-word;">' + prod[i].txnid + '</b><p style="font-size: 1.2em;margin-right: 10px;text-align: right;">' + prod[i].tdate + '</p></a> </div>';
                }
                prod_out += '</div> </div> </div> </div>';
                $('#result').append(prod_out);                
            }
            
            if(abc.et_amc) {
                var prod = abc.et_amc;

                var prod_out = '<div class="mdl-cell mdl-cell--12-col" style=""> <div class="mdl-card mdl-shadow--dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">Maintainance Contracts</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < prod.length; i++) {
                    if(prod[i].status == "paid") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">';    
                    } else {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #e60000; color: #fff; text-align: left;">';
                    }
                    prod_out = prod_out + '<a style="color: #fff; :hover { color: #fff; }" href="<?php if($dom == "Enterprise") { echo base_url()."Enterprise/amc_edit/"; } else { echo "#"; } ?>' + '/' +  abc.amct_mod_id + '/' + prod[i].id + '"><h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> ' + prod[i].name + '</h3><b style="font-size: 1.3em;margin: 30px;word-break: break-word;">' + prod[i].txnid + '</b><p style="font-size: 1.2em;margin-right: 10px;text-align: right;">' + prod[i].tdate + '</p></a> </div>';
                }
                prod_out += '</div> </div> </div> </div>';
                $('#result').append(prod_out);                
            }
            
            if(abc.et_inventory_serial) {
                var prod = abc.et_inventory_serial;

                var prod_out = '<div class="mdl-cell mdl-cell--12-col" style=""> <div class="mdl-card mdl-shadow--4dp"> <div class="mdl-card__title"> <h2 class="mdl-card__title-text">Transaction History for S/N: ' + abc.et_inventory_serial_numbers + '</h2> </div> <div class="mdl-card__supporting-text"> <div class="mdl-grid">';
                for (var i = 0; i < prod.length; i++) {
                    if(prod[i].type == "inward") {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #009933; color: #fff; text-align: left;">';    
                    } else {
                        prod_out = prod_out + '<div class="mdl-cell--4-col people block" style="background-color: #e60000; color: #fff; text-align: left;">';
                    }
                    prod_out = prod_out + '<a style="color: #fff; :hover { color: #fff; }" href="<?php if($dom == "Enterprise") { echo base_url()."Enterprise/inventory_edit/"; } else { echo "#"; } ?>' + '/' + prod[i].type + '/' + abc.invt_mod_id + '/' + prod[i].id + '"><h3 style="padding-bottom: 10px;"><i class="material-icons">arrow_downward</i> ' + prod[i].name + '</h3><b style="font-size: 1.3em;margin: 30px;word-break: break-word;">' + prod[i].txnid + '</b><p style="font-size: 1.2em;margin-right: 10px;text-align: right;">' + prod[i].tdate + '</p></a> </div>';
                }
                prod_out += '</div> </div> </div> </div>';
                $('#result').append(prod_out);                
            }
            console.log(data);
        }, "text");


    }
</script>
</html>