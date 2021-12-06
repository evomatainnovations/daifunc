<style>
	html, body {
		font-family: Calibri,sans-serif;
	}
</style>
<title></title>
<main class="mdl-layout__content">
<?php
	for($i=0;$i < count($temp_copies);$i++){ 
		$a='';
		$g_tax = 0;
		$g_amount = 0;
		$g_total = 0;

		$a.='<div><div style="text-align: center;">';
		$a.= $temp_copies[$i]->iutc_copies;
		$a.= '</div><hr>';
		$a.='<table style="display: inline-block;width: 50%;"><tr><td>To </td></tr>';
		$a.= '<tr><td>'.$basic[0]->ic_name.'</td></tr>';
			for($j=0;$j < count($property); $j++){
				$a.='<tr><td>'.$property[$j]->iexteppt_property_value.'</td></tr>';
			}
		$a.='</table>';
		$a.='<table style="display: inline-block;width: 50%;text-align: center;"><tr><td><img src="'.$s_logo.'" style="width: auto; height: 110px;background-size: cover;"></td></tr>';
		$a.='</table>';
		$a.='<table style="text-align: left;font-weight: bold;margin-top: 5%;width: 20%;"><tbody><tr><td>Invoice No</td><td>:</td><td>'.$s_txn_id.'</td></tr><tr><td>Date</td><td>:</td><td>'.$s_txn_date.'</td></tr></tbody></table>';
		$a.='<hr>';
		$a.='<div>';
		$a.='<table style="width: 100%;text-align: center;"><thead><tr><th>Sr. No.</th><th>Particulars</th><th>Rate</th><th>Qty</th><th>Tax</th><th>Disc.</th><th style="text-align: right;">Amount</th></tr></thead><tbody>';
			for($k=0;$k< count($details);$k++){
				$n = $k + 1;
				$a.= '<tr><td style="padding-top: 2%;">'.$n.'</td><td style="padding-top: 2%;">';
				if ($details[$k]->iexteprod_alias == 'true' ) {
					$a .= $details[$k]->ipp_alias;
				}else{
					$a .= $details[$k]->ip_product;
				}
				$a.= '<br>'.$details[$k]->iexteprod_serial_number.'</td><td style="padding-top: 2%;">'.$details[$k]->iexteprod_rate.'</td><td style="padding-top: 2%;">'.$details[$k]->iexteprod_qty.'</td><td style="padding-top: 2%;">'.$details[$k]->ittxg_group_name.'</td>';
				$disc = 0;
				if($details[$k]->iexteprod_discount != ''){
					$a.= '<td style="padding-top: 2%;">'.$details[$k]->iexteprod_discount.' %</td>';
					$disc = $details[$k]->iexteprod_discount;
				}else{
					$a.= '<td style="padding-top: 2%;">-</td>';
				}
				$tax = 0;
				for($m=0; $m < count($taxes); $m++){
					if($taxes[$m]->itxgc_tg_id == $details[$k]->iexteprod_tax){
						$tax = $tax + $taxes[$m]->itx_percent;
					}
				}
				$disc_amt =($details[$k]->iexteprod_rate * $details[$k]->iexteprod_qty) * ($disc / 100);
				$amount = $details[$k]->iexteprod_rate * $details[$k]->iexteprod_qty - $disc_amt;
				$g_amount = $g_amount + $amount;
				$tax_amt = $amount * ($tax/100) ;
				$g_tax = $g_tax + $tax_amt;
				$t_amount = $amount + $tax_amt;
				$g_total = $g_total + $t_amount;
				$a.='<td style="text-align: right;padding-top: 2%;">'.$t_amount.'</td></tr>';
			}
		$a.='</tbody></table></div>';
		$a.='<hr>';
		$a.='<table id="summary" style="width: 100%;">';
		$a.='<tr style="border: 1px solid #ddd;text-align: left;"><td>Products Total Amount</td><td class="amount" style="text-align: right;">'.$g_amount.'</td></tr>';
		$a.='<tr style="border: 10px #000 solid;text-align: left;"><td>Tax Total Amount</td><td class="amount" style="text-align: right;">'.$g_tax.'</td></tr>';
		$a.='<tr style="border: 10px #000 solid; text-align: left;"><td>Grand Total Amount</td><td class="amount" style="text-align: right;">'.$g_total.'</td></tr>';
		$a.='</table><hr>';
		$a.='<table style="display: inline-block;width: 70%;"><tr><td><p style="font-size: 0.5em;">Terms and condition :</p></td></tr>';
			$key = 0;
			for($l=0;$l < count($terms); $l++){
				$key ++;
				$a.='<tr><td><p style="font-size: 0.5em;">'.$key.')'.$terms[$l]->iextdt_term.'</p></td></tr>';
			}
		$a.='</table>';
		$a.='<table style="display: inline-block;width: 30%;text-align: center;">';
			for($l=0;$l < count($terms); $l++){
				$a.='<tr><td></td></tr>';
			}
		$a.='<tr><td>Authorized Signature</td></tr></table>';
		$a.='</div>';
		echo $a;
		if(count($temp_copies) - 1 != $i){
			echo '<div style="page-break-after:always"></div>';
		}
	}
?>
</main>