<style>
    h3{
        text-align: left;
    }
	#search_modal {
        background-color:#fff;
        display: none;
        opacity: 0;
        width: 0px;
        height:0px;
        top: 0px;
        right:0px;
        z-index: 1000000;
        position: absolute;
        background-image: url(<?php echo base_url()."assets/images/test.svg"; ?>);
        background-repeat: no-repeat;
        background-size: cover;
    }
    
    #search_irene {
        border-bottom-color: #ccc;
        color: #777;
        font-size: 4em;
        font-weight: bold;
        outline : none; 
    }
    
    #close_irene {
        font-size:4em;
        color: #777;
    }

    @media screen and (max-width:700px) {
        #search_irene {
            font-size: 2em;
        }
    }
    
    .search_card {
        background-color: #fff;
        color: #777;
        border-bottom: 1px solid;
        height: 70px;
    }
    
    .block {
        box-shadow: 1px 1px 5px #999;
        padding: 10px;
        margin-bottom: 10px;
        margin-left: 10px;
        border-radius: 10px 10px 10px 10px;
    }
    
    #redirect_modal {
        background-color:#fff;
        display: block;
        opacity: 0;
        width: 0px;
        height:0px;
        top: 0px;
        right:0px;
        position: absolute;
    }

    #redirect_modal > img {
        display: none;
    }
    
    
    .speech_result_text {
        font-size: 5em;
        font-weight: bold;
    }

    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
      color: #ccc;
    }
</style>
	<div class="mdl-grid" id="search_modal" style="z-index: 1000000 !important;margin-left: 70%;">
        <div class="mdl-cell mdl-cell--12-col" style="display:flex;">
			<input type="text" id="search_irene" class="mdl-textfield__input" style="width: 95%;" placeholder="Ask or Search for anything..">
			<button class="mdl-button mdl-js-button mdl-button--icon" id="close_irene" style="display: none"><i class="material-icons">close</i></button>
		</div>
		<div class="mdl-cell mdl-cell--12-col" id="result" style="text-align:center;overflow-y: auto;height: 85vh;"></div>
	</div>
	
	<div class="mdl-grid" id="redirect_modal">
	    <img src="<?php echo base_url().'assets/images/Logo_icon_black.gif'; ?>" style="margin-left:45%; margin-top: 20%;">
	</div>
</main>
</body>
<script>
    var amc_id;
    var mod_arr = [],details_arr=[],notification_arr = [];
    <?php 
            if (isset($mod)) {
                for ($i=0; $i <count($mod) ; $i++) { 
                    echo "mod_arr.push({'id': ".$mod[$i]->mid.",'f_name': '".$mod[$i]->function."','d_name' : '".$mod[$i]->domain."'});";
                }
            }
    ?>
    $(document).ready(function() {
        get_notification();
        $('#redirect_modal').animate({
            opacity: '0',
            width: '0px',
            height: '0px'
        }, 300);
            
        $('#ask_irene').click(function(e) {
            e.preventDefault();
            $('#search_modal').css('display','block');
            $('#close_irene').css('display','block');
            $('#search_modal').animate({
                opacity: '1',
                height: '100vh',
                width: '100%'
            }, 300, function() {
                $('#search_irene').focus();
            });
        });
        
        $('#close_irene').click(function(e) {
            e.preventDefault();
            $('#close_irene').css('display','none');
            $('#search_modal').animate({
                opacity: '0',
                width: '0px',
                height: '0px'
            }, 300, function() { $('#search_modal').modal('hide'); $('#search_irene').val('');});
        });
        
        $('.ani').click(function(e) {
            e.preventDefault();
            var u = $(this).prop('href');
            $('#redirect_modal > img').css('display','block');
            $('#redirect_modal').animate({
                opacity: '1',
                height: '100vh',
                width: '100%',
            }, 300, function() { $('#redirect_modal > img').css('display','none'); window.location = u; });
        });

        // $('#submit').click(function(e) {
        //     e.preventDefault();
        //     var note = $('#notes_text').html();
        //     $('#ATags > li').each(function(index) {
        //         var tmpstr = $(this).text();
        //         var len = tmpstr.length - 1;
        //         if(len > 0) {
        //             tmpstr = tmpstr.substring(0, len);
        //             activity_tags.push(tmpstr);
        //         }
        //     });
        //     var date = $('.s_date').val();
        //     var e_date = $('.e_date').val();
        //     $.post('<?php //echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
        //         'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
        //     }, function(data, status, xhr) {
        //             window.location = "<?php //echo base_url().'Home/activity/'.$code; ?>";
        //     }, 'text');
        // });
        
        $('#search_irene').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                $('#pre-load-div').css('display', 'none');
                var query_text = $(this).val();
                $.ajax({
                    url: 'https://api.dialogflow.com/v1/query?v=20150910',
                    headers: {
                        'Authorization':'Bearer 94095c6e995e4c1589c2a3a63ee31560',
                        'Content-Type':'application/json'
                    },
                    method: 'POST',
                    dataType: 'json',
                    data: JSON.stringify({
                        "lang" : "en",
                        "query" : query_text,
                        "sessionId" : "<?php echo $oid; ?>",
                        "timeZone" : "Asia/Calcutta"
                    }),
                    success: function(data){
                        $('#result').empty();
                        if (data.result.fulfillment.speech) {
                            var parameters = [];
                            if(data.result.parameters) {
                                parameters.push(data.result.parameters);
                            }
                            get_txn_info(data.result.metadata.intentName, data.result.action, parameters,data.result.fulfillment.speech, query_text);
                        } else {
                            $('#result').append('<h3 class="speech_result_text">I guess there is some issue right now. Can you try again after a while ?.</h3>');
                        }
                    }
                });
            }
        });
        function get_txn_info(intent, action, parameters,speech, query_text) {
            $.post("<?php echo base_url().'Home/fetch_views/'.$code; ?>", {
                "intent" : intent,
                "action" : action,
                "parameters" : JSON.stringify(parameters)
            }, function(data, status, xhr) {
                if(status == "success") {
                    if(data == "no_records" || data=="speech") {
                        get_txn_tags(query_text, speech);
                    } else {
                        setTimeout(function() {
                            $('#result').append(data);
                        }, 1000);
                    }
                }
            });
        }
        $('#result').on('click','.notify_redirect', function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            var path = '';
            var in_id = '';

            for (var i = 0; i < notification_arr.length; i++) {
                if (notification_arr[i].type_id == id) {
                    for (var j = 0; j < mod_arr.length; j++) {
                        if (notification_arr[i].mid == mod_arr[j].id) {
                            if(notification_arr[i].type_name == 'inward' || notification_arr[i].type_name == 'outward'){
                                path = null;
                                path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/'+mod_arr[j].f_name+'/'+notification_arr[i].type_name+'/'+"<?php echo $code;?>"+'/'+mod_arr[j].id;
                                in_id = notification_arr[i].in_id;
                            }else if(notification_arr[i].type_name == 'product'){
                                path = null;
                                path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/'+mod_arr[j].f_name+'/'+"<?php echo $code;?>";
                                in_id = notification_arr[i].in_id;
                            }else{
                                path = null;
                                path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/'+mod_arr[j].f_name+'/'+mod_arr[j].id+'/'+"<?php echo $code;?>";
                                in_id = notification_arr[i].in_id;
                            }
                        }else if (notification_arr[i].mid == 0){
                            path = "<?php echo base_url()."Home/activity/".$code."/";?>"+id;
                            in_id = notification_arr[i].in_id;
                        }
                    }   
                    break;   
                }
            }
            $.post('<?php echo base_url()."Home/notification_update/".$code."/";?>'+in_id,
            function(data, status, xhr) {
                if (path != null) {
                    window.location = path;
                }
            });
        });

        // $('#result').on('click','.search_redirect', function(e){
        //     e.preventDefault();
        //     var id = $(this).prop('id');
        //     for (var i = 0; i < details_arr.length; i++) {
        //         if (details_arr[i].type_id == id) {
        //             for (var j = 0; j < mod_arr.length; j++) {
        //                 if (details_arr[i].mid == mod_arr[j].id) {
        //                     if (details_arr[i].type_name == 'customers') {
        //                         var path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/customer_edit/'+"<?php echo $code;?>"+id;
        //                     }else if(details_arr[i].type_name == 'inward' || details_arr[i].type_name == 'outward'){
        //                         var path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/'+mod_arr[j].f_name+'_edit/'+details_arr[i].type_name+'/'+mod_arr[j].id+'/'+id;
        //                     }else if(details_arr[i].type_name == 'product'){
        //                         var path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/'+mod_arr[j].f_name+'_edit/'+id;
        //                     }else if(details_arr[i].type_name == 'invoice'){
        //                         var path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/'+mod_arr[j].f_name+'_add/'+mod_arr[j].id+'/'+"<?php echo $code; ?>"+'/'+id;
        //                     }else{
        //                         var path = "<?php echo base_url();?>"+mod_arr[j].d_name+'/'+mod_arr[j].f_name+'_edit/'+mod_arr[j].id+'/'+id;
        //                     }
        //                 }else if (details_arr[i].mid == 0){
        //                     var path = '<?php echo base_url()."Home/activity/".$code."/";?>'+id;
        //                 }
        //             }
        //             window.location = path;
        //             break;   
        //         }
        //     }
        // });

        $('#result').on('click','.close_button', function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            $.post('<?php echo base_url()."Home/notification_update/".$code."/"; ?>'+id,
            function(d,s,x) {
                get_notification();
            },'text');
        });

        function get_txn_tags(txn_tags, speech) {
            $.post('<?php echo base_url()."Home/search_records/".$code; ?>', {
            'keywords' : txn_tags
            }, function(data, status, xhr) {
                var abc = JSON.parse(data);
                var path = '';
                $('#result').empty();
                if(abc.tags.length > 0) {
                    details_arr = [];
                    var cust_out = '';
                    var speechflg = true;
                    for (var i = 0; i < abc.tags.length; i++) {
                        details_arr.push({'type_id': abc.tags[i].iet_type_id,'type_name' : abc.tags[i].iet_type,'mid':abc.tags[i].iet_m_id});
                    }
                    if(abc.customer.length > 0) {
                        cust_out += '<h1>Contact</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'customers') {
                                for (var j = 0; j < abc.customer.length; j++) {
                                    if (details_arr[i].type_id == abc.customer[j].ic_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col" id="'+abc.customer[j].ic_id+'"><a href="<?php echo base_url().'Enterprise/customer_edit/'.$code.'/'; ?>'+abc.customer[j].ic_id+'"><div class="mdl-card__title mdl-card--expand"><div class="mdl-card__title"><h2 class="mdl-card__title-text"><i class="material-icons">person</i>'+abc.customer[j].ic_name+'</h2></div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div>';
                        speechflg=false;
                    }
                    if(abc.product.length > 0) {
                        cust_out += '<h1>Product</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'products') {
                                for (var j = 0; j < abc.product.length; j++) {
                                    if (details_arr[i].type_id == abc.product[j].ip_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.product[j].ip_id+'"><a href="<?php echo base_url().'Enterprise/product_edit/'.$code.'/'; ?>'+abc.product[j].ip_id+'"><div class="mdl-card__title mdl-card--expand"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.product[j].ip_product+'</h2></div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div>';
                        speechflg=false;
                    }
                    if(abc.invoice.length > 0) {
                        cust_out += '<h1>Invoice</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'invoice') {
                                for (var j = 0; j < abc.invoice.length; j++) {
                                    if (details_arr[i].type_id == abc.invoice[j].iextein_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.invoice[j].iextein_id+'"><a href="<?php echo base_url().'Enterprise/invoice_add/0/'.$code.'/'; ?>'+abc.invoice[j].iextein_id+'"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.invoice[j].iextein_txn_id+'</h2></div><div class="mdl-card__supporting-text">'+abc.invoice[j].iextein_txn_date+'<br>'+abc.invoice[j].iextein_status+'</div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div>';
                        speechflg=false;
                    }
                    if(abc.inventory.length > 0) {
                        cust_out += '<h1>Inventory</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'inward' || details_arr[i].type_name == 'outward') {
                                for (var j = 0; j < abc.inventory.length; j++) {
                                    if (details_arr[i].type_id == abc.inventory[j].iextei_id) {
                                            cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.inventory[j].iextei_id+'">';
                                            if (details_arr[i].type_name == 'inward') {
                                                cust_out += '<a href="<?php echo base_url().'Enterprise/inventory_edit/inward/'.$code.'/0/'; ?>'+abc.inventory[j].iextei_id+'">';
                                            }else{
                                                cust_out += '<a href="<?php echo base_url().'Enterprise/inventory_edit/outward/'.$code.'/0/'; ?>'+abc.inventory[j].iextei_id+'">';
                                            }
                                            cust_out += '<div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.inventory[j].iextei_txn_id+'</h2></div><div class="mdl-card__supporting-text">'+abc.inventory[j].iextei_txn_date+'<br>'+abc.inventory[j].iextei_status+'</div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }
                    if(abc.amc.length > 0) {
                        cust_out += '<h1>Subscription</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'subscription') {
                                for (var j = 0; j < abc.amc.length; j++) {
                                    if (details_arr[i].type_id == abc.amc[j].iextamc_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.amc[j].iextamc_id+'"><a href="<?php echo base_url().'Enterprise/amc_edit/0/'.$code.'/'; ?>'+abc.amc[j].iextamc_id+'"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.amc[j].iextamc_txn_id+'</h2></div><div class="mdl-card__supporting-text">'+abc.amc[j].iextamc_txn_date+'<br>'+abc.amc[j].iextamc_status+'</div></div></a></div>';   
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }
                    if(abc.purchase.length > 0) {
                        cust_out += '<h1>Purchase</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'purchase') {
                                for (var j = 0; j < abc.purchase.length; j++) {
                                    if (details_arr[i].type_id == abc.purchase[j].iextep_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.purchase[j].iextep_id+'"><a href="<?php echo base_url().'Enterprise/purchase_add/'.$code.'/0/'; ?>'+abc.purchase[j].iextep_id+'"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.purchase[j].iextep_txn_id+'</h2></div><div class="mdl-card__supporting-text">'+abc.purchase[j].iextep_txn_date+'<br>'+abc.purchase[j].iextep_status+'</div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }
                    if(abc.expenses.length > 0) {
                        cust_out += '<h1>Expenses</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'expenses') {
                                for (var j = 0; j < abc.expenses.length; j++) {
                                    if (details_arr[i].type_id == abc.expenses[j].iextete_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.expenses[j].iextete_id+'"><a href="<?php echo base_url().'Enterprise/expenses/0/'.$code.'/'; ?>'+abc.expenses[j].iextete_id+'"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.expenses[j].iextete_details+'</h2></div><div class="mdl-card__supporting-text">'+abc.expenses[j].iextete_amount+'</div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }
                    if(abc.opportunity.length > 0) {
                        cust_out += '<h1>Opportunity</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'opportunity') {
                                for (var j = 0; j < abc.opportunity.length; j++) {
                                    if (details_arr[i].type_id == abc.opportunity[j].iextetop_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.opportunity[j].iextetop_id+'"><a href="<?php echo base_url().'Sales/opportunity_details/'.$code.'/edit/'; ?>'+abc.opportunity[j].iextetop_id+'"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.opportunity[j].iextetop_title+'</h2></div><div class="mdl-card__supporting-text">'+abc.opportunity[j].iextetop_status+'</div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }
                    if(abc.proposal.length > 0) {
                        cust_out += '<h1>Proposal</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'proposal') {
                                for (var j = 0; j < abc.proposal.length; j++) {
                                    if (details_arr[i].type_id == abc.proposal[j].iextepro_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.proposal[j].iextepro_id+'"><a href="<?php echo base_url().'Sales/proposal_add/'.$code.'/0/'; ?>'+abc.proposal[j].iextepro_id+'"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.proposal[j].iextepro_txn_id+'</h2></div><div class="mdl-card__supporting-text">'+abc.proposal[j].iextepro_txn_date+'<br>'+abc.proposal[j].iextepro_status+'</div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }
                    if(abc.project.length > 0) {
                        cust_out += '<h1>Project</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'project') {
                                for (var j = 0; j < abc.project.length; j++) {
                                    if (details_arr[i].type_id == abc.project[j].iextpp_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.project[j].iextpp_id+'"><a href="<?php echo base_url().'Projects/edit_project/'; ?>'+abc.project[j].iextpp_id+'/<?php echo $code; ?>"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.project[j].iextpp_p_name+'</h2></div><div class="mdl-card__supporting-text">'+abc.project[j].iextpp_p_description+'<br>'+abc.project[j].iextpp_p_status+'</div></div></a></div>';
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }
                    if(abc.activity.length > 0) {
                        cust_out += '<h1>Activity</h1><hr><div class="mdl-grid">';
                        for (var i = 0; i < details_arr.length; i++) {
                            if (details_arr[i].type_name == 'activity') {
                                for (var j = 0; j < abc.activity.length; j++) {
                                    
                                    if (details_arr[i].type_id == abc.activity[j].iua_id) {
                                        cust_out += '<div class="mdl-cell mdl-cell--2-col search_redirect" id="'+abc.activity[j].iua_id+'"><a href="<?php echo base_url().'Home/activity/'.$code.'/'; ?>'+abc.activity[j].iua_id+'"><div class="demo-card-wide mdl-card mdl-shadow--2dp"><div class="mdl-card__title"><h2 class="mdl-card__title-text">'+abc.activity[j].iua_title+'</h2></div><div class="mdl-card__supporting-text">'+abc.activity[j].iua_date+'<br>'+abc.activity[j].iua_status+'</div></div></a></div>';     
                                    }
                                }
                            }
                        }cust_out += '</div> </div> </div> </div>';
                        speechflg=false;
                    }

                    $('#result').empty();
                    if (speechflg == true) {
                        $('#result').append('<h3>' + speech + '</h3>');
                    }
                    $('#result').append(cust_out);
                }
                else {
                    $('#result').empty();
                    $('#result').append('<h2 class="speech_result_text">' + speech + '</h2>');
                }
            });
        }

        $('#result').on('click','.sub_act',function (e) {
            e.preventDefault();
            amc_id = $(this).prop('id');
            $.post('<?php echo base_url()."View/activity_modal/".$code."/subscription/"; ?>'+amc_id
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
        });

        $('#result').on('click','.create_sub',function (e) {
            e.preventDefault();
            invoice_id = $(this).prop('id');
            $.post('<?php echo base_url()."MH/transfer_invoice_subscription/".$code."/"; ?>'+invoice_id,
            function(d,s,x) {
                var a = JSON.parse(d);
                window.location = "<?php echo base_url(); ?>"+a[0]['value'];
            },'text');
        });

        var a_flg = 'false';
        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

        setInterval(function(){
            get_notification();
        }, 100000);

        function get_notification() {
            var today = new Date();
            var d = today.getDate();
            var m = today.getMonth() + 1;
            var y = today.getFullYear();
            var h = today.getHours();
            var i = today.getMinutes();

            $.post('<?php echo base_url()."Home/getnotification/".$code."/"; ?>'+y+'/'+m+'/'+d+'/'+h+'/'+i+'/true',
            function(d, status, xhr) {
                var abc = JSON.parse(d);
                var cust_out = '';
                notification_arr = [];
                $('#result').empty();
                if (abc.notification.length > 0) {
                    for (var i = 0; i < abc.notification.length; i++) {
                        notification_arr.push({'inid' : abc.notification[i].inid ,'type': abc.notification[i].type,'type_id' : abc.notification[i].type_id,'content' : abc.notification[i].content,'mid':abc.notification[i].mid, 'status' : abc.notification[i].status, 'person' : abc.notification[i].person});
                    }

                    for (var i = 0; i < notification_arr.length; i++) {
                        cust_out += '<div class="mdl-grid">';
                        if (notification_arr[i].type == 'sub_act') {
                            notifyMe('Sheduled activity for subscription '+notification_arr[i].content+' .');
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col sub_act" id="'+notification_arr[i].inid+'"><h3>Sheduled activity for subscription '+notification_arr[i].content+' .</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }

                        if (notification_arr[i].type == 'create_sub') {
                            notifyMe('Invoice '+notification_arr[i].content+'  warranty expired in one month. To create subscription click on same .');
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col create_sub" id="'+notification_arr[i].inid+'"><h3>Invoice '+notification_arr[i].content+'  warranty expired in one month. To create subscription click on same .</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }

                        if (notification_arr[i].type == 'activity') {
                            notifyMe('You tagged in activity '+notification_arr[i].content+' .');
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col notify_redirect" id="'+notification_arr[i].inid+'"><h3>You tagged in activity '+notification_arr[i].content+' .</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }

                        if (notification_arr[i].type == 'invoice') {
                            notifyMe('You tagged in invoice '+notification_arr[i].content+' .');
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col notify_redirect" id="'+notification_arr[i].inid+'"><h3>You tagged in invoice '+notification_arr[i].content+' .</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }

                        if (notification_arr[i].type == 'inward' || notification_arr[i].type == 'outward') {
                            notifyMe('You tagged in Inventory '+notification_arr[i].content+' .');
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col notify_redirect" id="'+notification_arr[i].inid+'"><h3>You tagged in Inventory '+notification_arr[i].content+' .</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }

                        if (notification_arr[i].type == 'subscription') {
                            notifyMe('You tagged in Subscription '+notification_arr[i].content+' .');
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col notify_redirect" id="'+notification_arr[i].inid+'"><h3>You tagged in Subscription '+notification_arr[i].content+' .</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }

                        if (notification_arr[i].type == 'proposal') {
                            notifyMe('You tagged in Proposal '+notification_arr[i].content+' .');
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col notify_redirect" id="'+notification_arr[i].inid+'"><h3>You tagged in Proposal '+notification_arr[i].content+' .</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }

                        if (notification_arr[i].type == 'messaging') {
                            notifyMe(notification_arr[i].content);
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--8-col mdl-shadow--8dp" style="border-radius:15px;text-align:left;">';
                            cust_out += '<div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col"><h3>'+notification_arr[i].content+'</h3></div>';
                            cust_out +='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-button--icon close_button" id="'+notification_arr[i].inid+'" ><i class="material-icons">close</i></button></div>';
                            cust_out += '</div></div>';
                            cust_out += '<div class="mdl-cell mdl-cell--2-col"></div>';
                        }
                        cust_out += '</div>';
                    }
                    $('#result').append(cust_out);
                }
            },'text');
        }
    function notifyMe(msg) {
        if (Notification.permission === "granted") {// If it's okay let's create a notification
            var notification = new Notification(msg);
        }else if (Notification.permission !== "denied") {// Otherwise, we need to ask the user for permission
            Notification.requestPermission().then(function (permission) {// If the user accepts, let's create a notification
                if (permission === "granted") {
                    var notification = new Notification("Welcome to daifunc !");
                }
            });
        }
    }

    });
</script>
</html>