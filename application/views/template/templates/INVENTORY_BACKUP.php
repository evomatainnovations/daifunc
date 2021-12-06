<style>
	html, body {
		font-family: Calibri,sans-serif;
	}
	.general_table {
		width: 100%;
        text-align: left;
        font-size: 1em;
        border: 1px solid #000;
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
		border: 1px solid #000;
	}

	.general_table > thead > tr > th {
		border: 1px solid #000;
		padding: 2px;
	}

	.general_table > tbody {
		border: 1px solid #000;
	}
	/*.general_table > tbody > tr {*/
		/*border: 1px solid #000;*/
	/*}*/

	.general_table > tbody > tr > td {
		padding: 2px;
		border-left: 1px solid #000;
		border-right: 1px solid #000;
	}

	.general_table > tfoot > tr {
		border: 1px solid #000;
	}

	.general_table > tfoot > tr > td {
		padding: 2px;
	}
</style>
<title></title>
<main class="mdl-layout__content">
<div style="display: flex;width: 100%;text-align: left;">
<?php
	$a='';
	for ($i=0; $i < count($temp_copies) ; $i++) {
		$a='<div style="width: 45%;display:inline-block;margin-left:20px;"><div style="text-align: center;"><u>'.$temp_copies[$i]->iutc_copies.'</u></div>';
		$a.='<table style="display: inline-block;text-align: center;"><tr><td><img src="'.$s_logo.'" style="width: 100%; height: 110px;background-size: cover;"></td></tr>';
		$a.='</table><hr>';
		$a.='<table style="width:100%;border-top:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;">';
		$a.= '<tr><td style="width:50%;">';
		$a.= $basic[0]->ic_name.'<br>';
		for($j=0;$j < count($property); $j++){
			$a.=$property[$j]->iexteinvept_property_value.'</br>';
		}
		$a .= '</td><td style="width:48%;border-left:1px solid #000;margin-left : 5px;">';
		$a .= 'Challan No. : '.$s_txn_id.'</br>';
		$a .= 'Date : '.$s_txn_date.'</br>';
		$a .= '</td></tr>';
		$a.= '</table>';
		$a.= '<div>';
		$a.= '<table class="general_table" style="width:100%;text-align: center;"><thead><tr><th style="text-align: left;width:10%;">Sr. No.</th><th style="width:50%;">Particulars</th><th style="width:20%;">Qty.</th><th style="text-align: right;width:20%;">Amount</th></tr></thead><tbody>';
		$flg = 0;
			for($k=0;$k< count($details);$k++){
				$n = $k + 1;
				$a.= '<tr><td style="text-align:left;">'.$n.'</td><td>';
				if ($details[$k]->iexteid_alias == 'true' ) {
					$a .= $details[$k]->ipp_alias;
				}else{
					$a .= $details[$k]->ip_product;
				}
				$a .= '</td><td>';
				$a.=$details[$k]->iexteid_balance;
				$a.='</td><td style="text-align:right;"></td></tr>';
			}
			for ($k=0; $k < 20 - count($details) ; $k++) {
				$a.= '<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>';
			}
		$a.='</tbody></table></div>';
		if (count($terms) > 0 ) {
			$a.='<table style="display:inline-block;width: 70%;"><tr><td><p style="font-size: 0.8em;">Terms and condition :</p></td></tr>';
				$key = 0;
				for($l=0;$l < count($terms); $l++){
					$key ++;
					$a.='<tr><td><p style="font-size: 0.8em;">'.$key.')'.$terms[$l]->iextdt_term.'</p></td></tr>';
				}
			$a.='</table>';
		}
		$a.='<table style="display: inline-block;width: 30%;text-align: center;">';
			if (count($terms) > 10 ) {
				for($l=0;$l < count($terms); $l++){
					$a.='<tr><td></td></tr>';
				}	
			}else{
				for($l=0;$l < 10; $l++){
					$a.='<tr><td></td></tr>';
				}
			}
		$a.='<tr><td>Receiver Signature</td></tr></table>';
		$a.='</div>';
		if ($i == 2 || $i == 4 || $i == 6) {
			echo '<div style="page-break-after:always"></div>';
		}
		echo $a;
	}
?>
</div>
</main>