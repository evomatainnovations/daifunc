<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			<div id="content" style="width: 100%;">
				<?php
					$content = "<style> @media print { .main_foot { display:table-footer-group; }  .main_head { display:table-header-group; }  } .col_right {text-align: left; padding-right: 0px; } .col_left {text-align: left; } .item_header > th {font-weight: bold; border-bottom: 1px solid #000;border-top: 1px solid #000;border-left: 1px solid #000;   } .item_name > td { border-left: 1px solid #000; height: 20px;} @page {size: A4; size:landscape; }  @media print { .break_pg {/*page-break-before: always;*/ } }  </style>";
					for($j=0;$j<count($temp_copies);$j++) {
						if ($j > 0 ) {
							$content.= "<div style='page-break-after: always;'></div>";
						}
						$discount_flg = 'false';
						$colspan_flg = '7';
						$c_sub_flg = '5';
						for($k=0;$k< count($details);$k++){
							if($details[$k]->iexteinpd_discount != ''){
								$discount_flg = 'true';
								$colspan_flg = '8';
								$c_sub_flg = '6';
							}
						}
					    $content.= '<table style="width:100%;margin-bottom:5px;font-family: Calibri, sans-serif;margin-top:20px;"><tr><td id="'.$temp_copies[$j]->iutc_copies.'" style="padding-right:25px;padding-left:25px;">';
            			$content.= '<table style="border-collapse:seperate; border-spacing:0px;">';
            			$content.= '<thead class="main_head">';
            			$content.= '<tr><td colspan="2"><div style="text-align: left;font-size:1.5em;font-weight:bold;">Purchase Order</div></td><td colspan="5"><div style="text-align: left;">'.$temp_copies[$j]->iutc_copies.'</div></td></tr>';

            			$content.= '<tr><td colspan="'.$colspan_flg.'" style="border-top:0px solid #000;border-left:0px solid #000;border-right:0px solid #000;">';

            			$content.= '<table><tr><td style="font-size:0.9em;padding-top:5px;width:30%;border-right:0px solid #000;">';
            			$content.= '<b>'.$basic[0]->ic_name.'</b><br>';
						for($ij=0;$ij < count($property); $ij++){
							$content.= $property[$ij]->iexteinpt_property_value.'<br>';
						}
						$content.= '</td>';
            			$content.= '<td style="padding-top:25px;width:30%;border-right:0px solid #000;padding-left:50px;">';
            			$content.= '<table style="width: 100%;font-size:0.9em;">';
						$content .= '<tr><td>Order No.</td><td>:</td><td>'.$s_txn_id.'</td></tr><tr><td>Date</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_date)).'</td></tr>';
						$content .= '<tr><td>GST No.</td><td>:</td><td>'.$u_gst.'</td></tr>';
						$content.= '</table>';
					    $content.= '</td>';

						$content.= '<td style="width:40%;text-align: center;"><img src="'.$s_logo.'" style="max-width: 100%; height: auto;"></td></tr></table>';
					    
					    $content.= '</td></tr>';
						$content.= '<tr class="item_header" style="width:100%;"><th style="width:5%;">Sr. No.</th><th style="width:40%;">Particulars</th><th style="width:10%;">Serial Number</th><th style="width:5%;">Qty</th><th style="width:10%;">Rate</th><th style="width:10%;">Tax</th>';
						if ($discount_flg == 'true') {
							$content .= '<th style="width:10%;">Discount</th>';
							$content .= '<th style="width:10%;border-right: 1px solid #000;">Amount</th></tr>';
						}else{
							$content .= '<th style="width:20%;border-right: 1px solid #000;">Amount</th></tr>';
						}
						$content.='</thead>';
						$content.='<tbody>';
						$line_cnt = count($details);
						$n_o_p = ceil(count($details)/42);
						$line_cnt_total = ($n_o_p * 42) - $line_cnt - 10;
				        $amt=0;
				        $tax = 0;
						$g_tax = 0;
						$g_amount = 0;
						$g_total = 0;
						for($k=0;$k< count($details);$k++){
							$n = $k + 1;
							$content.= '<tr class="item_name"><td style="text-align:center;width:5%;">'.($k+1).'</td>';
							if ($details[$k]->iexteinpd_alias == 'true') {
								if(strlen($details[$k]->ip_product) > 32) {
							    $content.= '<td style="font-size:0.8em;width:40%;">'.$details[$k]->ipp_alias;
								} else {
								    $content.= '<td style="font-size:0.9em;width:40%;">'.$details[$k]->ipp_alias;
								}
							}else{
								if(strlen($details[$k]->ip_product) > 32) {
								    $content.= '<td style="font-size:0.8em;width:40%;">'.$details[$k]->ip_product;
								} else {
								    $content.= '<td style="font-size:0.9em;width:40%;">'.$details[$k]->ip_product;
								}
							}
							$content .= '</td><td style="font-size:0.9em;width:10%;">'.$details[$k]->iexteinpd_serial_number.'</td>';
							$content .= '<td style="font-size:0.9em;width:5%;text-align:center;">'.$details[$k]->iexteinpd_qty.'</td><td style="font-size:0.9em;width:10%;text-align:center;">'.number_format((float)$details[$k]->iexteinpd_rate, 2, '.', '').'</td><td style="font-size:0.9em;width:10%;text-align:center;">'.$details[$k]->ittxg_group_name.'</td>';
							$disc = 0;
							if($details[$k]->iexteinpd_discount != ''){
								$content.= '<td style="font-size:0.9em;width:10%;text-align:center;">'.$details[$k]->iexteinpd_discount.'</td>';
								$disc = $details[$k]->iexteinpd_discount;
							}
							$tax = 0;
							for($m=0; $m < count($taxes); $m++){
								if($taxes[$m]->itxgc_tg_id == $details[$k]->iexteinpd_tax){
									$tax = $tax + $taxes[$m]->itx_percent;
								}
							}
							$disc_amt =($details[$k]->iexteinpd_rate * $details[$k]->iexteinpd_qty) * ($disc / 100);
							$amount = $details[$k]->iexteinpd_rate * $details[$k]->iexteinpd_qty - $disc_amt;
							$g_amount = $g_amount + $amount;
							$tax_amt = $amount * ($tax/100) ;
							$g_tax = $g_tax + $tax_amt; 
							$t_amount = $amount + $tax_amt;
							$g_total = $g_total + $t_amount;
							if ($discount_flg == 'true') {
								$content.='<td style="font-size:0.9em;width:10%;text-align:right;border-right: 1px solid #000;">'.number_format((float)$t_amount, 2, '.', '').'</td></tr>';	
							}else{
								$content.='<td style="font-size:0.9em;width:20%;text-align:right;border-right: 1px solid #000;">'.number_format((float)$t_amount, 2, '.', '').'</td></tr>';
							}
						}

						for ($i=0; $i < $line_cnt_total; $i++) {
							$content.= '<tr class="item_name" style="width:100%;"><td style="width:5%;"></td><td style="width:40%;"></td><td style="width:10%;"></td><td style="width:5%;"></td><td style="width:10%;"></td><td style="width:10%;"></td>';
							if ($discount_flg == 'true') {
								$content .= '<td style="width:10%;"></td><td style="width:10%;border-right: 1px solid #000;"></td></tr>';
							}else{
								$content .= '<td style="width:20%;border-right: 1px solid #000;"></td></tr>';
							}
						}
						$a_c_flg = $colspan_flg - 1 ;
						$content.='<tr style="text-align: left;padding:5px;"><td colspan="'.$a_c_flg.'" style="padding:2px;font-weight:bold;border-left: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;">Product Amount</td><td class="amount" style="text-align: right;border: 1px solid #000;font-weight:bold;">'.number_format((float)$g_amount, 2, '.', '').'</td></tr>';
						if (count($taxes) > 0) {
							for ($k = 0; $k < count($taxes); $k++) {
								$tax_amount = 0;$p_total = 0;
								$flg = 0;
								$tax_product = '';
								$p_flg = 1;
								for ($l = 0; $l < count($details); $l++) {
									if ($taxes[$k]->itxgc_tg_id == $details[$l]->iexteinpd_tax) {
										if ($flg == 0) {
											$flg++;
											$tax_product .= $p_flg;
										}else{
											$p_flg = $l + 1;
											$tax_product .= ' ,  '.$p_flg;
										}
										if ($details[$l]->iexteinpd_discount == '') {
											$p_total = $details[$l]->iexteinpd_rate * $details[$l]->iexteinpd_qty;
										}else{
											$disc_amt = ($details[$l]->iexteinpd_rate * $details[$l]->iexteinpd_qty) * ($details[$l]->iexteinpd_discount / 100);
											$p_total = $details[$l]->iexteinpd_rate * $details[$l]->iexteinpd_qty - $disc_amt;
										}
										$tax_amount = $tax_amount + $p_total * ($taxes[$k]->itx_percent/100);
									}
								}
								if ($tax_amount != 0) {
									$content.='<tr class="item_name" style="text-align: left;border: 1px solid #000;padding:5px;"><td colspan="'.$a_c_flg.'" style="padding:2px;"> '.$taxes[$k]->itx_name.' : '.$tax_product.'</td><td style="text-align:right;border-right: 1px solid #000;">'.$tax_amount.'</td></tr>';
								}
							}
						}
						$content.='<tr class="item_name" style="border: 1px #000 solid; text-align: left;"><td colspan="'.$a_c_flg.'" style="padding:2px;">Total</td><td class="amount" style="text-align: right;border-right: 1px solid #000;">'.$g_total.'</td></tr>';
						$t_flot = $g_total - round($g_total);
						$content.='<tr class="item_name" style="border: 1px #000 solid; text-align: left;"><td colspan="'.$a_c_flg.'" style="padding:2px;">Round off</td><td class="amount" style="text-align: right;border-right: 1px solid #000;">'.abs(number_format((float)$t_flot, 2, '.', '')).'</td></tr>';
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

						$content.='<tr style="text-align: left;padding:5px;"><td colspan="'.$a_c_flg.'" style="padding:2px;font-weight:bold;border-left: 1px solid #000;border-top: 1px solid #000;">Rupees '.$result.' only</td><td class="amount" style="text-align: right;border-left: 1px solid #000;border-right: 1px solid #000;border-top: 1px solid #000;font-weight:bold;">'.round($g_total).'.00</td></tr>';

						$content.= '</tbody>';

						$content.= '<tfoot class="main_foot">';
						if ($s_txn_note != '') {
							$content.= '<tr style="border-right:1px solid #000;"><td colspan="'.$colspan_flg.'" style="font-size:0.8em;padding-top:5px;padding-top:5px;border-left:1px solid #000;border-right:1px solid #000;border-top:1px solid #000;">Note : '.$s_txn_note.'</td></tr>';
						}
						$content.= '<tr style="border-right:1px solid #000;"><td colspan="'.$c_sub_flg.'" style="font-size:0.8em;padding-top:5px;border-left:1px solid #000;border-top:1px solid #000;">Regd. office : A/36,Dattani Park No. 2, Kandivali (E),Mumbai - 400101.</td><td colspan="2" style="text-align: right; margin:0px;font-size:0.8em;border-right:1px solid #000;border-top:1px solid #000;">E. & O.E.</td></tr>';

						$content.= '<tr><td colspan="'.$c_sub_flg.'" style="border-left:1px solid #000;"><div style="width:100%;;margin:0px;"></div><div style="text-align: left; margin:0px;">';
						$key = 0;
						if (count($terms) > 0 ) {
							$content.= '<b style="padding-top: 0px; font-size:0.8em;">Terms And condition : </b><br>';
							for($l=0;$l < count($terms); $l++){
								$key ++;
								$content.= '<b style="padding-top: 0px; font-size:0.8em;font-weight:normal;">'.$key.')'.$terms[$l]->iextdt_term.'</b><br>';
							}
						}
						$content.= '</div></td>';
						$content.= '<td colspan="2" style="border-right:1px solid #000;"><div style="text-align: center; margin:0px;"><p style="padding-top: 20px; font-size:0.9em;">For COSMOS ELECTRONICS</p></div><div style="text-align: center; margin:0px;"><p style="padding-top: 20px; font-size:0.9em;">propritor</p></div></td>';
						$content.= '</tr>';
						$content.= '<tr><td colspan="'.$colspan_flg.'" style="border-left:1px solid #000;border-bottom:1px solid #000;margin-left:10px;border-right:1px solid #000;"><div style="text-align: left;font-size:0.8em;padding-top:30px;">I/We hereby certify that my/our registration certificate under B.S.T. Act 1959 is in force on the date on which the sale of the goods specified in this Bill/Cash Memorandum is made by me/us and that the transaction of sale covered by this Bill/Cash memorandum has been effected by me/us in the regular course of my/our business.</div></td></tr>';
						$content.= '</tfoot>';
						$content.= '</table>';
            		    $content.= '</td></tr>';
            		    $content.= "</table>";
					}
					echo $content;
				?>
			</div>
		</div>
	</div>
</main>