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

.activity_list{
      border-radius: 15px;
}
</style>
<main class="mdl-layout__content">
      <div class="mdl-grid" style="width: 100%;">
      	<div class="mdl-cell mdl-cell--12-col">
      		<table class="general_table">
      			<thead>
      				<th>Action</th>
                              <th>Group Name</th>
      				<th>Sr. no</th>
      				<th>Product name</th>
      				<th>Rate</th>
      				<th>Qty</th>
      				<th>Total</th>
      			</thead>
      			<tbody class="prod_table"></tbody>
      		</table>
      	</div>
            <div class="mdl-cell mdl-cell--12-col">
                  <h3>Estimate Cost</h3>
                  <table class="general_table">
                        <thead>
                              <th>Sr. no</th>
                              <th>Product name</th>
                              <th>Rate</th>
                              <th>Qty</th>
                              <th>Tax</th>
                              <th>Total</th>
                        </thead>
                        <tbody class="proposal_table"></tbody>
                  </table>
            </div>
            <div class="mdl-cell mdl-cell--12-col">
                  <h3>Outward</h3>
                  <table class="general_table">
                        <thead>
                              <th>Sr. no</th>
                              <th>Product name</th>
                              <th>Rate</th>
                              <th>Qty</th>
                              <th>Tax</th>
                              <th>Total</th>
                        </thead>
                        <tbody class="outward_table"></tbody>
                  </table>
            </div>
      </div>
</main>
<script type="text/javascript">
      var prod_arr = [] ;
      var pro_grp = [] ;
      var proposal_arr = [];
      var out_arr = [];
      <?php
            if (isset($product)) {
                  for ($i=0; $i < count($product) ; $i++) {
                        echo "prod_arr.push({'id' : '".$i."' , 'name' : '".$product[$i]->ip_product."' , 'qty' : '".$product[$i]->iextppl_qty."' , 'rate' : '".$product[$i]->iextppl_rate."' , 'grp_id' : '".$product[$i]->iextppl_project_group."' , 'flg' : 'true' });";
                  }
            }
            if (isset($pro_grp)) {
                  for ($i=0; $i < count($pro_grp) ; $i++) { 
                        echo "pro_grp.push({'gid' : '".$pro_grp[$i]->iextptg_id."' , 'gname' : '".$pro_grp[$i]->iextptg_name."' });";
                  }
            }
            if (isset($proposal_list)) {
                  for ($i=0; $i < count($proposal_list) ; $i++) { 
                        for ($ij=0; $ij < count($p_list) ; $ij++) {
                              if ($p_list[$ij]->ip_id == $proposal_list[$i]->iexteprod_product_id ) {
                                    for ($ik=0; $ik < count($tax) ; $ik++) { 
                                          if ($tax[$ik]->ittxg_id == $proposal_list[$i]->iexteprod_tax ) {
                                                $tax_amt = 0;
                                                for ($j=0; $j < count($taxes) ; $j++) { 
                                                      if ($taxes[$j]->itxgc_tg_id == $proposal_list[$i]->iexteprod_tax ) {
                                                            $tax_amt = $tax_amt + $taxes[$j]->itx_percent;
                                                      }
                                                }
                                                $t_amount = ( $proposal_list[$i]->iexteprod_qty * $proposal_list[$i]->iexteprod_rate ) * ( $tax_amt / 100 ) ;
                                                $t_amount = $t_amount + ( $proposal_list[$i]->iexteprod_qty * $proposal_list[$i]->iexteprod_rate );
                                                echo "proposal_arr.push({'id' : '".$proposal_list[$i]->iextepro_id."' , 'pname' : '".$p_list[$ij]->ip_product."' , 'qty' : '".$proposal_list[$i]->iexteprod_qty."' , 'rate' : '".$proposal_list[$i]->iexteprod_rate."' , 'tax' : '".$tax[$ik]->ittxg_group_name."' , 't_amt' : '".$t_amount."' });";
                                          }
                                    }
                              }
                        }
                  }
            }
            if (isset($inv_list)) {
                  for ($i=0; $i < count($inv_list) ; $i++) {
                        for ($ij=0; $ij < count($p_list) ; $ij++) {
                              if ($inv_list[$i]->iexteid_product_id == $p_list[$ij]->ip_id ) {
                                    for ($ik=0; $ik < count($tax) ; $ik++) { 
                                          if ($tax[$ik]->ittxg_id == $p_list[$ij]->ipt_t_id ) {
                                                $tax_amt = 0;
                                                for ($j=0; $j < count($taxes) ; $j++) {
                                                      if ($taxes[$j]->itxgc_tg_id == $tax[$ik]->ittxg_id ) {
                                                            $tax_amt = $tax_amt + $taxes[$j]->itx_percent;
                                                      }
                                                }
                                                $t_amount = ( $inv_list[$i]->iexteid_balance * $p_list[$ij]->ipp_sell_price ) * ( $tax_amt / 100 ) ;
                                                $t_amount = $t_amount + ( $inv_list[$i]->iexteid_balance * $p_list[$ij]->ipp_sell_price );
                                                echo "out_arr.push({ 'id' : '".$inv_list[$i]->iextei_id."' , 'pname' : '".$p_list[$ij]->ip_product."' , 'qty' : '".$inv_list[$i]->iexteid_balance."' , 'rate' : '".$p_list[$ij]->ipp_sell_price."' , 'tax' : '".$tax[$ik]->ittxg_group_name."' , 't_amt' : '".$t_amount."' });";
                                          }else{
                                                $t_amount = $inv_list[$i]->iexteid_balance * $p_list[$ij]->ipp_sell_price ;
                                                if ($t_amount == 0 ) {
                                                      $rate = 0 ;
                                                }else{
                                                      $rate =  $p_list[$ij]->ipp_sell_price;
                                                }
                                                echo "out_arr.push({ 'id' : '".$inv_list[$i]->iextei_id."' , 'pname' : '".$p_list[$ij]->ip_product."' , 'qty' : '".$inv_list[$i]->iexteid_balance."' , 'rate' : '".$rate."' , 'tax' : 'N/A' , 't_amt' : '".$t_amount."' });";
                                          }
                                    }
                              }
                        }
                  }
            }
      ?>
$(document).ready(function() {
      display_prod_list();
      estimate_cost();
      outward_cost();
      $('.prod_table').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            for (var i = 0; i < prod_arr.length; i++) {
                  if(prod_arr[i].grp_id == a){
                        if(!ischecked){
                              prod_arr[i].flg = 'false';
                        }else{
                              prod_arr[i].flg = 'true';
                        }
                  }
            }
            display_prod_list();
      });

      function display_prod_list() {
            var out = '';
            var t_amount = 0 ;
            if (prod_arr.length > 0) {
                  var srno = 1 ;
                  for (var i = 0; i < prod_arr.length; i++) {
                        if (prod_arr[i].grp_id == 0){
                              out += '<tr>';                              
                              if (srno == 1) {
                                    if (prod_arr[i].flg == 'true') {
                                          out +='<td><input class="mdl-checkbox__input group_name" type="checkbox" id="0" checked></td>';
                                    }else{
                                          out +='<td><input class="mdl-checkbox__input group_name" type="checkbox" id="0"></td>';
                                    }
                                    out += '<td>Parent Group</td>';
                              }else{
                                    out +='<td></td>';
                                    out += '<td></td>';
                              }
                              out +='<td>'+srno+'</td><td>'+prod_arr[i].name+'</td><td>'+prod_arr[i].rate+'</td><td>'+prod_arr[i].qty+'</td>';
                              var amt = Number(prod_arr[i].qty) * Number(prod_arr[i].rate) ;
                              out += '<td>'+amt+'</td>';
                              out += '</tr>';
                              if (prod_arr[i].flg == 'true') {
                                    t_amount = Number(t_amount) + Number(amt);
                              }
                              srno++;
                        }
                  }
                  for (var ij = 0; ij < pro_grp.length; ij++) {
                        var srno = 1 ;
                        for (var i = 0; i < prod_arr.length; i++) {
                              if (pro_grp[ij].gid == prod_arr[i].grp_id ) {
                                    out += '<tr>';
                                    if (srno == 1) {
                                          if (prod_arr[i].flg == 'true') {
                                                out +='<td><input class="mdl-checkbox__input group_name" type="checkbox" id="'+ pro_grp[ij].gid +'" checked></td>';
                                          }else{
                                                out +='<td><input class="mdl-checkbox__input group_name" type="checkbox" id="'+ pro_grp[ij].gid +'"></td>';
                                          }
                                          out += '<td>'+pro_grp[ij].gname+'</td>';
                                    }else{
                                          out +='<td></td>';
                                          out += '<td></td>';
                                    }
                                    out += '<td>'+srno+'</td><td>'+prod_arr[i].name+'</td><td>'+prod_arr[i].rate+'</td><td>'+prod_arr[i].qty+'</td>';
                                    var amt = Number(prod_arr[i].qty) * Number(prod_arr[i].rate) ;
                                    out += '<td>'+amt+'</td>';
                                    out += '</tr>';
                                    if (prod_arr[i].flg == 'true') {
                                          t_amount = Number(t_amount) + Number(amt);
                                    }
                                    srno++;
                              }
                        }
                  }
                  out += '<tr style="border: 1px solid #ccc;font-weight : bold;"><td colspan="6">Grand Total</td><td>'+t_amount+'</td></tr>';
            }else{
                  out += '<tr><td colspan = "7" style="text-align:center;">Records not found !</td></tr>';
            }
            $('.prod_table').empty();
            $('.prod_table').append(out);
      }

      function estimate_cost() {
            var out = '';
            var t_amount = 0 ;
            if (proposal_arr.length > 0) {
                  var srno = 1 ;
                  for (var i = 0; i < proposal_arr.length; i++) {
                        out += '<tr>';
                        out += '<td>'+srno+'</td><td>'+proposal_arr[i].pname+'</td><td>'+proposal_arr[i].rate+'</td><td>'+proposal_arr[i].qty+'</td><td>'+proposal_arr[i].tax+'</td>';
                        out += '<td>'+proposal_arr[i].t_amt+'</td>';
                        out += '</tr>';
                        t_amount = Number(t_amount) + Number(proposal_arr[i].t_amt);
                        srno++;
                  }
                  out += '<tr style="border: 1px solid #ccc;font-weight : bold;"><td colspan="5">Grand Total</td><td>'+t_amount+'</td></tr>';
            }else{
                  out += '<tr><td colspan = "6" style="text-align:center;">Records not found !</td></tr>';
            }
            $('.proposal_table').empty();
            $('.proposal_table').append(out);
      }

      function outward_cost() {
            var out = '';
            var t_amount = 0 ;
            if (proposal_arr.length > 0) {
                  var srno = 1 ;
                  for (var i = 0; i < out_arr.length; i++) {
                        out += '<tr>';
                        out += '<td>'+srno+'</td><td>'+out_arr[i].pname+'</td><td>'+out_arr[i].rate+'</td><td>'+out_arr[i].qty+'</td><td>'+out_arr[i].tax+'</td>';
                        out += '<td>'+out_arr[i].t_amt+'</td>';
                        out += '</tr>';
                        t_amount = Number(t_amount) + Number(out_arr[i].t_amt);
                        srno++;
                  }
                  out += '<tr style="border: 1px solid #ccc;font-weight : bold;"><td colspan="5">Grand Total</td><td>'+t_amount+'</td></tr>';
            }else{
                  out += '<tr><td colspan = "6" style="text-align:center;">Records not found !</td></tr>';
            }
            $('.outward_table').empty();
            $('.outward_table').append(out);
      }
});
</script>