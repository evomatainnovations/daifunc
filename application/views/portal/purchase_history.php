<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
<div class="modal fade" id="order_details" role="dialog" style="overflow: auto;">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-header">
                <button type="mdl-button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<script>
    var order_arr = [];
    var group = '';
    var storage = '';
    var g_amount = '';
    var s_amount = '';
    var details_arr = [];
    $(document).ready(function() {
        $('.general_table').on('click','.order_details',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            $.post('<?php echo base_url()."Portal/purchase_details/"; ?>'+id,
            function(data, status, xhr) {
                var d = JSON.parse(data);
                order_arr = [];
                group = d.group;
                storage = d.storage;
                g_amount = d.g_amount[0].ipprice_amount;
                s_amount = d.s_amount[0].ipprice_amount;
                for (var i = 0; i < d.order.length; i++) {
                    order_arr.push({id : d.order[i].iucm_id, mid : d.order[i].iucm_mid, user : d.order[i].iucm_users, month : d.order[i].iucm_sub_month, mname : d.order[i].im_name, mprice : d.order[i].im_price});
                    // order_arr.push({id : d.order[i].iucm_id, mid : d.order[i].iucm_mid, user : d.order[i].iucm_users, mname : d.order[i].im_name, mprice : d.order[i].im_price});
                }
                for (var i = 0; i < d.txn_details.length; i++) {
                    details_arr.push({pay_id : d.txn_details[i].iutxn_payment_id,status : d.txn_details[i].iutxn_status,currency : d.txn_details[i].iutxn_currency ,invoice_id : d.txn_details[i].iutxn_invoice_id ,method : d.txn_details[i].iutxn_method ,card_no : d.txn_details[i].iutxn_card_id ,bank : d.txn_details[i].iutxn_bank ,wallet : d.txn_details[i].iutxn_wallet ,email : d.txn_details[i].iutxn_email ,contact : d.txn_details[i].iutxn_contact ,fee : d.txn_details[i].iutxn_fee ,tax : d.txn_details[i].iutxn_tax});
                }
                display_order();
            });
        });

        function display_order() {
            var out = '';
            var g_total = 0;
            $('#order_details').modal('show');
            out += '<div class="mdl-grid"><table id="proposal_list" class="general_table"><thead><tr><th colspan="2">Order details<th></tr></thead>';
            for (var i = 0; i < details_arr.length; i++) {
                out += '<tr><td>Payment id</td><td style="text-align:center;">:</td><td>'+ details_arr[i].pay_id +'</td></tr>';
                out += '<tr><td>Payment status</td><td style="text-align:center;">:</td><td>'+ details_arr[i].status +'</td></tr>';
                out += '<tr><td>Currency</td><td style="text-align:center;">:</td><td>'+ details_arr[i].currency +'</td></tr>';
                out += '<tr><td>Invoice_id</td><td style="text-align:center;">:</td><td>'+ details_arr[i].invoice_id +'</td></tr>';
                out += '<tr><td>Method</td><td style="text-align:center;">:</td><td>'+ details_arr[i].method +'</td></tr>';
                out += '<tr><td>Card_no</td><td style="text-align:center;">:</td><td>'+ details_arr[i].card_no +'</td></tr>';
                out += '<tr><td>Bank</td><td style="text-align:center;">:</td><td>'+ details_arr[i].bank +'</td></tr>';
                out += '<tr><td>Wallet</td><td style="text-align:center;">:</td><td>'+ details_arr[i].wallet +'</td></tr>';
                out += '<tr><td>Email</td><td style="text-align:center;">:</td><td>'+ details_arr[i].email +'</td></tr>';
                out += '<tr><td>Contact</td><td style="text-align:center;">:</td><td>'+ details_arr[i].contact +'</td></tr>';
                out += '<tr><td>Fee</td><td style="text-align:center;">:</td><td>'+ Number(details_arr[i].fee)/100 +'</td></tr>';
                out += '<tr><td>Tax</td><td style="text-align:center;">:</td><td>'+ Number(details_arr[i].tax)/100 +'</td></tr>';
            }
            out += '<thead><tr><th colspan="2">Further details<th></tr></thead>';
            out += '<thead><tr><th>module</th><th style="text-align:center;">No. of Users</th><th>Total</th></tr></thead>';
            if (order_arr.length != 0) {
                var total = 0;
                for (var i = 0; i < order_arr.length; i++) {
                    out += '<tr><td>'+order_arr[i].mname+'</td><td class="c_users" style="text-align:center;">'+order_arr[i].user+'</td>';
                    var m_price = Number(order_arr[i].mprice)/12;
                    var total = (Number(m_price)*Number(order_arr[i].month)) * Number(order_arr[i].user);
                    out +='<td>'+total.toFixed(2)+'</td></tr>';
                    g_total = g_total + total;
                }
                out += '<tr><td>Storage (in GB)</td><td style="text-align:center;">'+Number(storage)+'</td>';
                var storage_total = Number(storage) * Number(s_amount);
                out +='<td>'+storage_total+'</td></tr>';
                out += '<tr><td>Group</td><td style="text-align:center;">'+Number(group)+'</td>';
                var group_total = Number(group) * Number(g_amount);
                out +='<td>'+group_total+'</td></tr>';
                var grand_total = Number(group_total) + Number(storage_total) + Number(g_total);
                out += '<tr><td colspan="2">Grand Total</td><td>'+ grand_total.toFixed(2) +'</td></tr>';
            }

            out +='</table></div>';
            $('.modal-body').empty();
            $('.modal-body').append(out);
        }
    });
</script>