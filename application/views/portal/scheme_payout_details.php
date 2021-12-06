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
<main class="mdl-layout__content">
	<div class="mdl-grid" style="text-align: center;">
        <div class="mdl-cell mdl-cell--12-col" style="text-align: center;width: 100%;">
            <button class="mdl-button mdl-button--colored mdl-button--raised paid" style="background-color: green;color: white;width: 100%;">Paid</button>
        </div>
		<div class="mdl-cell mdl-cell--12-col">
			<table class="general_table sh_details" style="width: 100%;">
				<thead>
					<th>Sr. no.</th>
					<th>Name</th>
                    <th>Scheme</th>
                    <th>Referrer code</th>
                    <th>Transaction amount</th>
                    <th>% OR Amount</th>
					<th>Amount</th>
                    <th>status</th>
                    <th style="text-align: center;">Action<br><button class="mdl-button mdl-button--colored select_all">select all</button><button class="mdl-button mdl-button--colored unselect_all">Unselect all</button></th>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</main>
<div class="modal fade" id="modial_payment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Add payment details</h3>
            </div>
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <h4 class="payment_amount"></h4>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="pay_mod">
                            <label class="mdl-textfield__label" for="pay_mod">Enter payment mode</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" data-type="date" id="pay_date">
                            <label class="mdl-textfield__label" for="pay_date">Select payment date</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                            <input class="mdl-textfield__input" type="text" id="pay_vno">
                            <label class="mdl-textfield__label" for="pay_vno">Enter vouchar number</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"  style="width: 100%;">
                            <input class="mdl-textfield__input" type="text" id="pay_desc">
                            <label class="mdl-textfield__label" for="pay_desc">Enter payment description</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <button class="mdl-button mdl-button--colored mdl-button--raised pay_save" style="width: 100%;display: none;"><i class="material-icons">save</i> Save</button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#likehood">History</a>
                                    </h4>
                                </div>
                                <div id="likehood" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?php
                                            if (isset($history)) {
                                                if (count($history) > 0) {
                                                    echo '<table id="payment_history" class="general_table"><thead><th>Vouchar No.</th><th>Amount</th><th>Description</th></thead><tbody>';
                                                    //<th></th><th></th>
                                                    for ($i=0; $i <count($history) ; $i++) { 
                                                        echo '<tr><td style="word-break: break-all;text-align:left;">'.$history[$i]->iushpay_v_no.'</td><td style="word-break: break-all;text-align:center;">';
                                                        echo number_format((float)$history[$i]->iushpay_amount, 2, '.', '');
                                                        echo '</td><td style="word-break: break-all;text-align:center;">'.$history[$i]->iushpay_desc.'</td></tr>';
                                                        //<td><button class="mdl-button mdl-button--icon pay_delete" id="'.$history[$i]->iushpay_id.'"><i class="material-icons">delete</i></button></td><td><button class="mdl-button mdl-button--icon pay_edit" id="'.$history[$i]->iushpay_id.'"><i class="material-icons">edit</i></button></td>
                                                    }
                                                    echo '</tbody></table>';
                                                }else{
                                                    echo "<h4>No records found !</h4>";
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var u_arr = [];
    <?php
        if (isset($u_details)) {
            for ($i=0; $i < count($u_details) ; $i++) { 
                $amt = number_format((float)$u_details[$i]->iutxn_amount, 2, '.', '')/100 + number_format((float)$u_details[$i]->iutxn_discount_amount, 2, '.', '');
                if ($u_details[$i]->iushp_type == 'percentage') {
                    $amt_t = $u_details[$i]->iushp_amount.' %';
                }else{
                    $amt_t = $u_details[$i]->iushp_amount;
                }
                $u_amt = number_format((float)$u_details[$i]->iushtxn_amount, 2, '.', '');
                echo "u_arr.push({'id': '".$u_details[$i]->iushtxn_id."' , 'name' : '".$u_details[$i]->iud_name."', 'scheme' : '".$u_details[$i]->iush_name."' , 'ref_code' : '".$u_details[$i]->iushtxn_ref_code."' , 'amount' : '".$amt."' , 's_amt' : '".$amt_t."' , 'u_amount' : '".$u_amt."' , 'status' : '".$u_details[$i]->iushtxn_status."' , 'flg' : 'false' });";
            }
        }
    ?>
    $(document).ready( function() {
        display_details();
        $('#pay_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        $('.sh_details').on('click','.p_add',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            for (var i = 0; i < u_arr.length; i++) {
                if(u_arr[i].id == id){
                    u_arr[i].flg = 'true';
                    break;
                }
            }
            display_details();
        });

        $('.sh_details').on('click','.p_close',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            for (var i = 0; i < u_arr.length; i++) {
                if(u_arr[i].id == id){
                    u_arr[i].flg = 'false';
                    break;
                }
            }
            display_details();
        });

        $('.select_all').click(function (e) {
            e.preventDefault();
            for (var i = 0; i < u_arr.length; i++) {
                if(u_arr[i].status == 'unpaid'){
                    u_arr[i].flg = 'true';
                }
            }
            display_details();
        });

        $('.unselect_all').click(function (e) {
            e.preventDefault();
            for (var i = 0; i < u_arr.length; i++) {
                if(u_arr[i].status == 'unpaid'){
                    u_arr[i].flg = 'false';
                }
            }
            display_details();
        });

        $('.paid').click(function (e) {
            e.preventDefault();
            var p_amount = 0 ;
            $('.pay_save').css('display','none');
            for (var i = 0; i < u_arr.length; i++) {
                if(u_arr[i].flg == 'true'){
                    p_amount = p_amount + Number(u_arr[i].u_amount);
                    $('.pay_save').css('display','block');
                }
            }
            $('.payment_amount').empty();
            $('.payment_amount').append('Payment Amount '+parseFloat(p_amount).toFixed(2)+'/- ');
            $('#modial_payment').modal('show');
        });

        $('.pay_save').click(function (e) {
            e.preventDefault();
            var p_amount = 0 ;
            for (var i = 0; i < u_arr.length; i++) {
                if(u_arr[i].flg == 'true'){
                    p_amount = p_amount + Number(u_arr[i].u_amount) ;
                }
            }
            $.post('<?php echo base_url()."Portal/scheme_payment_details"; ?>',{
                'p_mode':$('#pay_mod').val(),
                'p_date':$('#pay_date').val(),
                'p_amt': p_amount,
                'p_vno':$('#pay_vno').val(),
                'p_desc':$('#pay_desc').val(),
                'sh_arr' : u_arr
            }, function(data, status, xhr) {
                window.location.reload();
            }, "text");
        });

        function display_details(){
            var out = '';
            var srno = 1;
            var paid = 0 ;
            var unpaid = 0 ;
            for (var i = 0; i < u_arr.length; i++) {
                if (u_arr[i].status == 'unpaid' ) {
                    out += '<tr>';
                    out += '<td>'+srno+'</td><td>'+u_arr[i].name+'</td><td>'+u_arr[i].scheme+'</td><td>'+u_arr[i].ref_code+'</td><td>'+u_arr[i].amount+'</td><td>'+u_arr[i].s_amt+'</td><td>'+u_arr[i].u_amount+'</td><td>Unpaid</td>';
                    if (u_arr[i].flg == 'true' ) {
                        out += '<td style="text-align:center;"><button class="mdl-button mdl-button--colored mdl-button--raised p_close" id="'+u_arr[i].id+'"><i class="material-icons">close</i></button>';
                    }else{
                        out += '<td style="text-align:center;"><button class="mdl-button mdl-button--colored p_add" id="'+u_arr[i].id+'"><i class="material-icons">add</i></button>';
                    }
                    out += '</td></tr>';
                    srno++;
                }
            }
            if (srno == 1 ) {
                $('.select_all').css('display','none');
                $('.unselect_all').css('display','none');
            }
            for (var i = 0; i < u_arr.length; i++) {
                if (u_arr[i].status == 'paid' ) {
                    out += '<tr>';
                    out += '<td>'+srno+'</td><td>'+u_arr[i].name+'</td><td>'+u_arr[i].scheme+'</td><td>'+u_arr[i].ref_code+'</td><td>'+u_arr[i].amount+'</td><td>'+u_arr[i].s_amt+'</td><td>'+u_arr[i].u_amount+'</td><td>Paid</td><td style="text-align:center;">N/A</td>';
                    out += '</tr>';
                    srno++;
                }
            }

            $('.sh_details > tbody').empty();
            $('.sh_details > tbody').append(out);
        }
    });
</script>