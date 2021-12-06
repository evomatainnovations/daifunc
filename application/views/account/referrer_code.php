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
		background-color: #666;
		color: #fff;
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
<main>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--5-col"></div>
		<div class="mdl-cell mdl-cell--2-col mdl-shadow-4dp" style="background-color: lightyellow;color: black;font-weight: bolder;text-align: center;font-size: 3em;"><?php echo $u_code; ?></div>
		<div class="mdl-cell mdl-cell--5-col"></div>
		<div class="mdl-cell mdl-cell--12-col">
			<table class="general_table">
				<thead>
					<th>Sr. No.</th>
					<th>Name</th>
					<th>Date</th>
					<th>Transaction Amount</th>
					<th>Scheme Name</th>
					<th>Earn Amount</th>
				</thead>
				<tbody>
					<?php
						$srno = 1;
						for ($i=0; $i < count($ref_income) ; $i++) { 
							echo '<tr class="txn_details" id="'.$ref_income[$i]->iutxn_id.'" >';
							echo '<td>'.$srno.'</td>';
							echo '<td>'.$ref_income[$i]->iud_name.'</td>';
							echo '<td>'.date("d F Y", strtotime($ref_income[$i]->iutxn_date)).'</td>';
							$t_amt = ($ref_income[$i]->iutxn_amount / 100 ) + $ref_income[$i]->iutxn_discount_amount ;
							echo '<td>'.number_format((float)$t_amt, 2, '.', '').'</td>';
							echo '<td>'.$ref_income[$i]->iush_name.'</td>';
							echo '<td>'.number_format((float)$ref_income[$i]->iushtxn_amount, 2, '.', '').'</td>';
							echo '</tr>';
							$srno++;
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</main>
<div class="modal fade" id="txn_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="text-align: center;">
				<h3 style="text-align: center;">Transaction Details</h3>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col income_details"></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal"><i class="material-icons">close</i> close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var group = 0 ;
	var storage = 0 ;
	var g_month = 0 ;
	var s_month = 0 ;
	var g_amount = 0 ;
	var s_amount = 0 ;
	var order_arr = [] ;
	var disc_amount = 0 ;
	$(document).ready( function() {

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

		// $('.txn_details').click(function (e) {
		// 	e.preventDefault();
		// 	var id = $(this).prop('id');
		// 	$.post('<?php echo base_url()."Account/get_txn_details/".$code."/"; ?>'+id,
		// 	function(data, status, xhr) {
	 //    		var d = JSON.parse(data);
	 //    		order_arr = [];
  //               group = d.group;
  //               storage = d.storage;
  //               g_month = d.g_month;
  //               s_month = d.s_month;
  //               g_amount = d.g_amount[0].ipprice_amount;
  //               s_amount = d.s_amount[0].ipprice_amount;
  //               // disc_amount = 
  //               for (var i = 0; i < d.order.length; i++) {
  //                   order_arr.push({id : d.order[i].iucm_id, mid : d.order[i].iucm_mid, user : d.order[i].iucm_users, month : d.order[i].iucm_sub_month, mname : d.order[i].im_name, mprice : d.order[i].im_price });
  //               }
  //               display_order();
	 //    	});
		// 	$('#txn_modal').modal('show');
		// });

		// function display_order() {
  //           var out = '';
  //           var g_total = 0;
  //           $('#order_details').modal('show');
  //           out += '<div class="mdl-grid">';
  //           out += '<table id="proposal_list" class="general_table"><thead><tr><th>module</th><th style="text-align:center;">No. of Users</th><th>Total</th></tr></thead>';
  //           var total = 0;
  //           for (var i = 0; i < order_arr.length; i++) {
  //               out += '<tr><td>'+order_arr[i].mname+'</td><td class="c_users" style="text-align:center;">'+order_arr[i].user+'</td>';
  //               var m_price = Number(order_arr[i].mprice)/12;
  //               var total = (Number(m_price)*Number(order_arr[i].month)) * Number(order_arr[i].user);
  //               out +='<td>'+total.toFixed(2)+'</td></tr>';
  //               g_total = g_total + total;
  //           }
  //           out += '<tr><td>Storage (in GB)</td><td style="text-align:center;">'+Number(storage)+'</td>';
  //           s_amount = Number(s_amount) / 12;
  //           var storage_total = Number(storage) * Number(s_month) * Number(s_amount);
  //           out +='<td>'+storage_total.toFixed(2)+'</td></tr>';
  //           out += '<tr><td>Group</td><td style="text-align:center;">'+Number(group)+'</td>';
  //           g_amount = Number(g_amount) / 12;
  //           var group_total = Number(group) * Number(g_amount) * Number(g_month);
  //           out +='<td>'+group_total.toFixed(2)+'</td></tr>';
  //           var grand_total = Number(group_total) + Number(storage_total) + Number(g_total);
  //           out += '<tr><td colspan="2">Total</td><td>'+ grand_total.toFixed(2) +'</td></tr>';
  //           // if (ref_code != 'null') {
  //           //     out += '<tr><td>Discount Amount</td><td style="background-color:lightyellow;font-weight:bolder;text-align:center;">PROMO CODE : '+ref_code+'</td><td>'+ Number(disc_amount).toFixed(2) +'</td></tr>';
  //           // }
  //           grand_total = grand_total - disc_amount;
  //           out += '<tr><td colspan="2">Grand Total</td><td>'+ grand_total.toFixed(2) +'</td></tr>';

  //           out +='</table></div>';
  //           $('.income_details').empty();
  //           $('.income_details').append(out);
  //       }

	});
</script>


