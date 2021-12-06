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
			$a.='<tr><td>'.$property[$j]->iextamcpt_property_value.'</td></tr>';
		}
		$a.='</table>';
		$a.='<table style="display: inline-block;width: 50%;text-align: center;"><tr><td><img src="'.$s_logo.'" style="width: auto; height: 110px;background-size: cover;"></td></tr>';
		$a.='</table>';
		$a.='<table style="text-align: left;font-weight: bold;margin-top: 5%;width: 20%;"><tbody><tr><td>Invoice No</td><td>:</td><td>'.$s_txn_id.'</td></tr><tr><td>Date</td><td>:</td><td>'.$s_txn_date.'</td></tr></tbody></table>';
		$a.='<hr>';
		$a.='<div>';
		$a.='<table style="width: 100%;text-align: center;"><thead><tr><th>Sr. No.</th><th>Particulars</th><th>Qty</th><th style="text-align: right;">Serial Number</th></tr></thead><tbody>';
			for($k=0;$k< count($details);$k++){
				$n = $k + 1;
				$a.= '<tr><td style="padding-top: 2%;">'.$n.'</td><td style="padding-top: 2%;">';
				if ($details[$k]->iextamcpd_alias == 'true') {
					$a.= $details[$k]->ipp_alias;
				}else{
					$a.= $details[$k]->ip_product;
				}
				$a .= '</td><td style="padding-top: 2%;">'.$details[$k]->iextamcpd_qty.'</td><td style="padding-top: 2%;text-align:right;">'.$details[$k]->iextamcpd_serial_number.'</td></tr>';
			}
		$a.='</tbody></table></div>';
		$a.='<hr>';
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