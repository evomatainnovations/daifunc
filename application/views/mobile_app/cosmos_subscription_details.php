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
		height:50px !important;
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

	.general1 > tbody > tr > td{
		padding: 10px;
	}
</style>
<?php
	$content = '';
	$content .= '<table class="general1"><tbody>';
	$content .= '<tr><td>Ref. No.</td><td>:</td><td>'.$s_txn_id.'</td></tr>';
	$content .= '<tr><td>Date</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_date)).'</td></tr>';
	$content .= '<tr><td>Period From</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_start_date)).'</td></tr>';
	$content .= '<tr><td>Period To</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_end_date)).'</td></tr>';
	$content .= '<tr><td>GST No.</td><td>:</td><td>'.$u_gst.'</td></tr>';
	if ($status == 'cb_client') {
		$content .= '<tr><td>Status</td><td>:</td><td>Confirm by you</td></tr>';
	}else{
		$content .= '<tr><td>Status</td><td>:</td><td>'.$status.'</td></tr>';
	}
	$content.= '</tbody></table>';

	$content.= '<table class="general_table" style="overflow:auto;"><thead>';
	$content.= '<tr><th>Sr. No.</th><th>Particulars</th><th>S/N</th><th>Qty</th><th>Amount</th></tr>';
	$content.='</thead>';
	$amt=0;
	$tax = 0;
	for ($k=0; $k < count($details) ; $k++) {
		$content.= '<tr><td>'.($k+1).'</td>';
		if ($details[$k]->iextamcpd_alias == 'true') {
			if(strlen($details[$k]->ip_product) > 32) {
		    $content.= '<td>'.$details[$k]->ipp_alias;
			} else {
			    $content.= '<td>'.$details[$k]->ipp_alias;
			}
		}else{
			if(strlen($details[$k]->ip_product) > 32) {
			    $content.= '<td>'.$details[$k]->ip_product;
			} else {
			    $content.= '<td>'.$details[$k]->ip_product;
			}
		}
		$content.='</td><td>'.$details[$k]->iextamcpd_serial_number.'</td><td>'.$details[$k]->iextamcpd_qty.'</td><td></td></tr>';
		for($m=0; $m < count($taxes); $m++){
			if($taxes[$m]->itxgc_tg_id == $details[$k]->iextamc_tax){
				$tax = $tax + $taxes[$m]->itx_percent;
			}
		}
	}
	$tax_amount = 0;
	$content .= '<tr class="item_name" style="border:1px solid #ccc;"><td style="text-align:left;font-weight:bold;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;" colspan="4">AMC Amount</td><td style="text-align:right;border-right: 1px solid #ccc;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;font-weight:bold;">'.$details[0]->iextamc_amount.'</td></tr>';
	for($m=0; $m < count($taxes); $m++){
		if($taxes[$m]->itxgc_tg_id == $details[0]->iextamc_tax){
			$t_amount = $details[0]->iextamc_amount * ($taxes[$m]->itx_percent/100);
			$content .= '<tr class="item_name"><td style="text-align:left;border-bottom:1px solid #ccc;" colspan="4">'.$taxes[$m]->itx_name.'</td><td style="text-align:right;border-right: 1px solid #ccc;border-bottom:1px solid #ccc;">'.$t_amount.'</td></tr>';
			$tax_amount = $tax_amount + $t_amount;
		}
	}
	$g_total = $tax_amount+$details[0]->iextamc_amount;

	$number = $g_total;
	$no = round($number);
	$point = round($number - $no, 2) * 100;
	$hundred = null;
	$digits_1 = strlen($no);
	$i = 0;
	$str = array();
	$words = array('0' => '', '1' => 'one', '2' => 'two',
	'3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
	'7' => 'seven', '8' => 'eight', '9' => 'nine',
	'10' => 'ten', '11' => 'eleven', '12' => 'twelve',
	'13' => 'thirteen', '14' => 'fourteen',
	'15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
	'18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
	'30' => 'thirty', '40' => 'forty', '50' => 'fifty',
	'60' => 'sixty', '70' => 'seventy',
	'80' => 'eighty', '90' => 'ninety');
	$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
	while ($i < $digits_1) {
	 $divider = ($i == 2) ? 10 : 100;
	 $number = floor($no % $divider);
	 $no = floor($no / $divider);
	 $i += ($divider == 10) ? 1 : 2;
	 if ($number) {
	    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
	    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
	    $str [] = ($number < 21) ? $words[$number] .
	        " " . $digits[$counter] . $plural . " " . $hundred
	        :
	        $words[floor($number / 10) * 10]
	        . " " . $words[$number % 10] . " "
	        . $digits[$counter] . $plural . " " . $hundred;
	 } else $str[] = null;
	}
	$str = array_reverse($str);
	$result = implode('', $str);

	$content .= '<tr class="item_name"><td style="text-align:left;font-weight:bold;" colspan="4">Rupees '.$result.' only</td><td style="text-align:right;border-right: 1px solid #ccc;font-weight:bold;">'.$g_total.'</td></tr>';

	$content.= '<tr><td colspan="5" style="border-left:1px solid #ccc;border-right:1px solid #ccc;"><div style="text-align: left; margin:0px;">';
	$key = 0;
	if (count($terms) > 0 ) {
		$content.= '<b style="padding-top: 0px; font-size:0.8em;">Terms And condition : </b><br>';
		for($l=0;$l < count($terms); $l++){
			$key ++;
			$content.= '<b style="padding-top: 0px; font-size:0.8em;font-weight:normal;">'.$key.')'.$terms[$l]->iextdt_term.'</b><br>';
		}	
	}
	$content.= '</div></td></tr>';
	$content.= '</tbody></table>';
	if (isset($basic)) {
		if ($basic[0]->iextamc_status == 'open') {
			$content .= '<div style="text-align:center;margin-top:20px;"><button class="mdl-button mdl-button--colored mdl-button--raised amc_confirm">Confirm Subscription</button></div>';
		}
	}
?>
<main>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col" style="overflow: auto;">
			<?php echo $content; ?>
		</div>
		<div class="mdl-cell mdl-cell--12-col" style="overflow: auto;">
			<?php
				if (isset($amc_act)) {
					echo '<h3>Activity List  </h3>';
					echo '<table id="act_list" class="general_table"><thead><tr><th>Sr. no.</th><th>Title</th><th>Status</th></tr></thead><tbody>';
					$sr = 1 ;
					if (count($amc_act)) {
						for ($i=0; $i < count($amc_act) ; $i++) {
							$sdate = date('Y-m-d',strtotime($amc_act[$i]->iua_date));
							$edate = date('Y-m-d',strtotime($amc_act[$i]->iua_end_date));
							echo '<tr><td>'.$sr.'</td><td>'.$amc_act[$i]->iua_title.'</td>';
							echo '<td>'.$amc_act[$i]->iua_status.'</td></tr>';
							$sr++;
						}	
					}else{
						echo '<tr><td colspan="6" style="text-align:center;">No records found !</td></tr>';
					}
					echo '</tbody></table>';
				}
			?>
		</div>
	</div>
</main>
<script type="text/javascript">
	$(document).ready(function() {
		$('.amc_confirm').click(function (e) {
			e.preventDefault();
			window.location = '<?php echo base_url()."Mobile_app/cosmos_subscription_satatus_update/".$code."/".$sub_id ;?>';
		});
	});
</script>