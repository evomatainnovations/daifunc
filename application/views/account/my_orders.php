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
</style>
<main class="mdl-layout__content" style="z-index:3;">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--8-col" style="text-align: right;">
        </div>
        <div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="text-align: center;height: auto;background-color: rgba(255, 255, 109, 0.4);">
            <p style="font-size: 2em;padding-top: 0.3em;">Credit Amount : <?php echo number_format($credit_amt,2); ?></p>
        </div>
    </div>
    <div class="mdl-grid">
        <table class="general_table" style="width: 100%;" id="mod">
            <thead>
                <tr>
                    <th>Order no.</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($txn)) {
                        for ($i=0; $i <count($txn) ; $i++) { 
                            echo '<tr id="'.$txn[$i]->iutxn_id.'" class="order_details"><td>'.$txn[$i]->iutxn_timestamp.'</td><td>'.date("d F Y", strtotime($txn[$i]->iutxn_date)).'</td><td>';
                            echo $txn[$i]->iutxn_amount/100;
                            echo '</td></tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</main>
<div class="modal fade" id="order_details" role="dialog">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Order details</h4>
            </div>
            <div class="modal-body" id="order_list">
                
            </div>
        </div>
    </div>
</div>
<script>
    var order_arr = [];
    var group = '';
    var storage = '';
    var g_amount = '';
    var s_amount = '';
    var g_month = '';
    var s_month = '';
    var disc_amount = 0;
    var ref_code = '';
    $(document).ready(function() {
        $('.general_table').on('click','.order_details',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            $.post('<?php echo base_url()."Account/order_details/".$code."/"; ?>'+id,
            function(data, status, xhr) {
                var d = JSON.parse(data);
                order_arr = [];
                group = d.group;
                storage = d.storage;
                g_month = d.g_month;
                s_month = d.s_month;
                g_amount = d.g_amount[0].ipprice_amount;
                s_amount = d.s_amount[0].ipprice_amount;
                disc_amount = d.disc_amount;
                ref_code = d.ref_code;
                for (var i = 0; i < d.order.length; i++) {
                    order_arr.push({id : d.order[i].iucm_id, mid : d.order[i].iucm_mid, user : d.order[i].iucm_users, month : d.order[i].iucm_sub_month, mname : d.order[i].im_name, mprice : d.order[i].im_price });
                }
                display_order();
            });
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

        function display_order() {
            var out = '';
            var g_total = 0;
            $('#order_details').modal('show');
            out += '<div class="mdl-grid">';
            out += '<table id="proposal_list" class="general_table"><thead><tr><th>module</th><th style="text-align:center;">No. of Users</th><th>Total</th></tr></thead>';
            var total = 0;
            for (var i = 0; i < order_arr.length; i++) {
                out += '<tr><td>'+order_arr[i].mname+'</td><td class="c_users" style="text-align:center;">'+order_arr[i].user+'</td>';
                var m_price = Number(order_arr[i].mprice)/12;
                var total = (Number(m_price)*Number(order_arr[i].month)) * Number(order_arr[i].user);
                out +='<td>'+total.toFixed(2)+'</td></tr>';
                g_total = g_total + total;
            }
            out += '<tr><td>Storage (in GB)</td><td style="text-align:center;">'+Number(storage)+'</td>';
            s_amount = Number(s_amount) / 12;
            var storage_total = Number(storage) * Number(s_month) * Number(s_amount);
            out +='<td>'+storage_total.toFixed(2)+'</td></tr>';
            out += '<tr><td>Group</td><td style="text-align:center;">'+Number(group)+'</td>';
            g_amount = Number(g_amount) / 12;
            var group_total = Number(group) * Number(g_amount) * Number(g_month);
            out +='<td>'+group_total.toFixed(2)+'</td></tr>';
            var grand_total = Number(group_total) + Number(storage_total) + Number(g_total);
            out += '<tr><td colspan="2">Total</td><td>'+ grand_total.toFixed(2) +'</td></tr>';
            if (ref_code != 'null') {
                out += '<tr><td>Discount Amount</td><td style="background-color:lightyellow;font-weight:bolder;text-align:center;">PROMO CODE : '+ref_code+'</td><td>'+ Number(disc_amount).toFixed(2) +'</td></tr>';
            }
            grand_total = grand_total - disc_amount;
            out += '<tr><td colspan="2">Grand Total</td><td>'+ grand_total.toFixed(2) +'</td></tr>';

            out +='</table></div>';
            $('#order_list').empty();
            $('#order_list').append(out);
        }
    });
</script>