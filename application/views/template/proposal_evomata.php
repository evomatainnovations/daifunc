<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			<div id="content" style="width: 100%;">
				<?php
					$content = "<style> @media print { .main_foot { display:table-footer-group; }  .main_head { display:table-header-group; }  } .col_right {text-align: left; padding-right: 0px; } .col_left {text-align: left; } .item_header > th {font-weight: bold; border-bottom: 1px solid #000;border-top: 1px solid #000;border-left: 1px solid #000;font-size:0.9em; } .item_name > td { border-left: 1px solid #000; height: 20px;} @page {size: A4; size:landscape; }  @media print { #duplicate {/*page-break-before: always;*/ } }  </style>";
					for($j=0;$j<count($temp_copies);$j++) {
						if ($j > 0 ) {
							$content.= "<div style='page-break-after: always;'></div>";
						}
						$discount_flg = 'false';
						$colspan_flg = '7';
						$c_sub_flg = '5';
						for($k=0;$k< count($details);$k++){
							if($details[$k]->iexteprod_discount != ''){
								$discount_flg = 'true';
								$colspan_flg = '8';
								$c_sub_flg = '6';
							}
						}

					    $content.= '<table style="width:100%;margin-bottom:5px;font-family: Calibri, sans-serif;"><tr><td id="'.$temp_copies[$j]->iutc_copies.'" style="padding-right:25px;padding-left:25px;font-size:0.9em;">';
            			$content.= '<table style="border-collapse:seperate; border-spacing:0px;">';
            			$content.= '<thead class="main_head">';
            			$content.= '<tr><td colspan="2"><div style="text-align: left;font-size:1em;font-weight:bold;">Sales Quotation</div></td><td colspan="'.$c_sub_flg.'"><div style="text-align: left;">'.$temp_copies[$j]->iutc_copies.'</div></td></tr>';

            			$content.= '<tr><td colspan="'.$colspan_flg.'">';

            			$content.= '<table><tr><td style="font-size:0.9em;padding-top:25px;width:30%;">';
            			$content.= $basic[0]->ic_name.'<br>';
						for($ij=0;$ij < count($property); $ij++){
							$content.= $property[$ij]->iexteppt_property_value.'<br>';
						}
						$content.= '</td>';
            			$content.= '<td style="padding-top:25px;width:30%;">';
            			$content.= '<table style="width: 100%;font-size:0.9em;">';
						$content .= '<tr><td>Quotation No</td><td>:</td><td>'.$s_txn_id.'</td></tr><tr><td>Date</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_date)).'</td></tr>';
						$content.= '</table>';
					    $content.= '</td>';

						$content.= '<td style="width:40%;text-align: center;"><img src="'.$s_logo.'" style="max-width: 100%; height: auto;"></td></tr></table>';
					    
					    $content.= '</td></tr>';

						$content.= '<tr class="item_header" style="100%;"><th style="width:5%;">Sr. No.</th><th style="width:40%;">Particulars</th><th style="width:5%;">Qty</th><th style="width:10%;">Rate</th><th style="width:10%;">Tax</th>';
						if ($discount_flg == 'true') {
							$content.= '<th style="width:10%;">Discount</th>';
							$content.= '<th style="width:20%;border-right: 1px solid #000;">Amount</th></tr>';
						}else{
							$content.= '<th style="width:30%;border-right: 1px solid #000;">Amount</th></tr>';
						}
						$content.='</thead>';
						$content.='<tbody>';
						$line_cnt = count($details);
						$n_o_p = ceil(count($details)/45);
						$line_cnt_total = ($n_o_p * 45) - $line_cnt - 5;
				        $amt=0;
				        $tax = 0;
						$g_tax = 0;
						$g_amount = 0;
						$g_total = 0;
						for($k=0;$k< count($details);$k++){
							$n = $k + 1;
							$content.= '<tr class="item_name"><td style="text-align:center;width:5%;">'.($k+1).'</td>';
							if ($details[$k]->iexteprod_alias == 'true') {
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
							if ($details[$k]->iexteprod_serial_number != '') {
								$content .= ' Sr. No. '.$details[$k]->iexteprod_serial_number;
							}
							$content.='</td>';

							$content .= '<td style="font-size:0.9em;width:5%;text-align:center;">'.$details[$k]->iexteprod_qty.'</td><td style="font-size:0.9em;width:10%;text-align:center;">'.$details[$k]->iexteprod_rate.'</td><td style="font-size:0.9em;width:10%;text-align:center;">'.$details[$k]->ittxg_group_name.'</td>';
							$disc = 0;

							if($discount_flg == 'true'){
								$content.= '<td style="font-size:0.9em;width:10%;text-align:center;">'.$details[$k]->iexteprod_discount.'</td>';
								$disc = $details[$k]->iexteprod_discount;
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
							if($discount_flg == 'true'){
								$content.='<td style="font-size:0.9em;width:20%;text-align:right;border-right: 1px solid #000;">'.abs(number_format((float)$t_amount, 2, '.', '')).'</td></tr>';
							}else{
								$content.='<td style="font-size:0.9em;width:30%;text-align:right;border-right: 1px solid #000;">'.abs(number_format((float)$t_amount, 2, '.', '')).'</td></tr>';
							}
						}

						for ($i=0; $i < $line_cnt_total; $i++) {
							$content.= '<tr class="item_name"><td style="text-align:center;width:5%;"></td><td style="font-size:0.8em;width:40%;"></td><td style="font-size:0.9em;width:5%;"></td><td style="font-size:0.9em;width:10%;"></td><td style="font-size:0.9em;width:10%;"></td>';
							if ($discount_flg == 'true') {
								$content.= '<td style="font-size:0.9em;width:10%;"></td><td style="font-size:0.9em;width:20%;text-align:right;border-right: 1px solid #000;"></td>';	
							}else{
								$content.= '<td style="font-size:0.9em;width:30%;text-align:right;border-right: 1px solid #000;"></td>';
							}
							$content.= '</tr>';
						}

						$content.='<tr class="item_name" style="text-align: left;padding:5px;"><td colspan="'.$c_sub_flg.'" style="padding:2px;border-top:1px solid #000;border-bottom:1px solid #000;font-weight:bold;font-size:0.9em;">Product Total</td><td class="amount" style="font-size:0.9em;text-align: right;border-right: 1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;font-weight:bold;">'.abs(number_format((float)$g_amount, 2, '.', '')).'</td></tr>';
						if (count($taxes) > 0) {
							for ($k = 0; $k < count($taxes); $k++) {
								$tax_amount = 0;$p_total = 0;
								$flg = 0;
								$tax_product = '';
								for ($l = 0; $l < count($details); $l++) {
									if ($taxes[$k]->itxgc_tg_id == $details[$l]->iexteprod_tax) {
										if ($flg == 0) {
											// $tax_product .= $details[$l]->ip_product;
											$tax_product .= $l+1;
											$flg++;	
										}else{
											$flg = $l+1;
											$tax_product .= ' , '.$flg;
											// $tax_product .= ' ,  '.$details[$l]->ip_product;
										}
										if ($details[$l]->iexteprod_discount == '') {
											$p_total = $details[$l]->iexteprod_rate * $details[$l]->iexteprod_qty;
										}else{
											$disc_amt = ($details[$l]->iexteprod_rate * $details[$l]->iexteprod_qty) * ($details[$l]->iexteprod_discount / 100);
											$p_total = $details[$l]->iexteprod_rate * $details[$l]->iexteprod_qty - $disc_amt;
										}
										$tax_amount = $tax_amount + $p_total * ($taxes[$k]->itx_percent/100);
									}
								}
								if ($tax_amount != 0) {
									$content.='<tr class="item_name" style="text-align: left;border: 1px solid #000;padding:5px;"><td colspan="'.$c_sub_flg.'" style="padding:2px;font-size:0.9em;"> '.$taxes[$k]->itx_name.' : '.$tax_product.'</td><td style="text-align:right;border-right: 1px solid #000;font-size:0.9em;">'.abs(number_format((float)$tax_amount, 2, '.', '')).'</td></tr>';
								}
							}
						}
						$content.='<tr class="item_name" style="border: 1px #000 solid; text-align: left;"><td colspan="'.$c_sub_flg.'" style="padding:2px;font-size:0.9em;">Total</td><td class="amount" style="font-size:0.9em;text-align: right;border-right: 1px solid #000;">'.abs(number_format((float)$g_total, 2, '.', '')).'</td></tr>';

						$t_flot = $g_total - round($g_total);
						$content.='<tr class="item_name" style="border: 1px #000 solid; text-align: left;"><td colspan="'.$c_sub_flg.'" style="padding:2px;font-size:0.9em;">Round off</td><td class="amount" style="font-size:0.9em;text-align: right;border-right: 1px solid #000;">'.abs(number_format((float)$t_flot, 2, '.', '')).'</td></tr>';
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
						$content.='<tr class="item_name" style="border: 1px #000 solid; text-align: left;"><td colspan="'.$c_sub_flg.'" style="padding:2px;border-top:1px solid #000;font-weight:bold;font-size:0.9em;">Rupees '.$result.' only</td><td class="amount" style="font-size:0.9em;text-align: right;border-right: 1px solid #000;border-top:1px solid #000;font-weight:bold;">'.round($g_total).'</td></tr>';

						$content.= '</tbody>';
						$content.= '<tfoot class="main_foot"><tr>';
						$content .= '<td colspan="'.$colspan_flg.'" style="border-right:1px solid #000;border-left:1px solid #000;border-top:1px solid #000;"></td></tr><tr>';
						if($note != ''){
							$content .= '<td colspan="'.$colspan_flg.'" style="border-right:1px solid #000;border-left:1px solid #000;font-size:0.9em;"><p><b>NOTE</b> : '.$note.'</p></td>';
						}
						$content .= '</tr><tr>';
						$content.= '<td colspan="'.$colspan_flg.'" style="border-right:1px solid #000;border-left:1px solid #000;"><div style="width:100%;"></div><div style="text-align: left;">';
						$key = 0;
						$content.= '<b style="font-size:0.8em;">Terms And condition : </b><br>';
						if (count($terms) > 0 ) {
							for($l=0;$l < count($terms); $l++){
								$key ++;
								$content.= '<b style="font-size:0.8em;font-weight:normal;">'.$key.')'.$terms[$l]->iextdt_term.'</b><br>';
							}
						}
						$content.= '</div></td>';
						$content.= '</tr>';
						$content.= '<tr><td colspan="'.$colspan_flg.'" style="font-size:0.9em;border-top:20px;border-right:1px solid #000;border-left:1px solid #000;border-bottom:1px solid #000;text-align:right;"><p>Looking forward to your valuable orders.</p></td></tr>';
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