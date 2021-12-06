<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			<div id="content" style="width: 100%;">
				<?php
					$content = "<style> @media print { .main_foot { display:table-footer-group; }  .main_head { display:table-header-group; }  } .col_right {text-align: left; padding-right: 0px; } .col_left {text-align: left; } .item_header > th {font-weight: bold; border-bottom: 1px solid #000;border-top: 1px solid #000;border-left: 1px solid #000;   } .item_name > td {border-left: 1px solid #000; height: 20px;font-size:0.9em;} @page {size: A4; size:landscape; }  @media print { .break_pg {/*page-break-before: always;*/ } }  </style>";
					for($j=0;$j<count($temp_copies);$j++) {
					    $content .= '<table style="width:100%;margin-bottom:5px;font-family: Calibri, sans-serif;margin-top:20px;padding-right:25px;padding-left:25px;font-size:0.9em;"><tr><td id="'.$temp_copies[$j]->iutc_copies.'">';
            			$content.= '<table style="border-collapse:seperate; border-spacing:0px;">';
            			$content.= '<thead class="main_head">';
            			$content.= '<tr><td colspan="4"><div style="text-align: left;font-size:1.5em;font-weight:bold;">Annual Maintenance Contract</div></td></tr>';
            			$content.= '<tr><td colspan="4"><div style="text-align: center;">'.$temp_copies[$j]->iutc_copies.'</div></td></tr>';
					    $content.= '<tr><td colspan="7">';

            			$content.= '<table><tr><td style="font-size:0.9em;padding-top:25px;width:30%;">';
            			$content.= '<b>'.$basic[0]->ic_name.'</b><br>';
						for($ij=0;$ij < count($property); $ij++){
							$content.= $property[$ij]->iextamcpt_property_value.'<br>';
						}
						$content.= '</td>';
            			$content.= '<td style="padding-top:25px;width:30%;padding-left:30px;">';
            			$content.= '<table style="max-width: 100%;font-size:0.8em;">';
						$content .= '<tr><td>Ref. No.</td><td>:</td><td>'.$s_txn_id.'</td></tr><tr><td>Date</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_date)).'</td></tr>';
						$content .= '<tr><td>Period From</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_start_date)).'</td></tr><tr><td>Period To</td><td>:</td><td>'.date('d-m-Y',strtotime($s_txn_end_date)).'</td></tr>';
						$content .= '<tr><td>GST No.</td><td>:</td><td>'.$u_gst.'</td></tr>';
						$content.= '</table>';
					    $content.= '</td>';

						$content.= '<td style="width:40%;text-align: center;"><img src="'.$s_logo.'" style="max-width: 100%; height: auto;"></td></tr></table>';
					    
					    $content.= '</td></tr>';
						$content.= '<tr class="item_header" style="width:100%;padding-top:10px;"><th style="width:10%;">Sr. No.</th><th style="width:50%;">Particulars</th><th style="width:20%;">Serial Number</th><th style="width:10%;">Qty</th><th style="width:10%;border-right: 1px solid #000;">Amount</th></tr>';
						$content.='</thead>';
						$content.='<tbody>';
						$line_cnt = count($details);
						$n_o_p = ceil(count($details)/43);
						$line_cnt_total = ($n_o_p * 43) - $line_cnt - 10;
				        $amt=0;
				        $tax = 0;
				        for ($k=0; $k < count($details) ; $k++) {
							$content.= '<tr class="item_name"><td style="text-align:center;width:10%;">'.($k+1).'</td>';
							if ($details[$k]->iextamcpd_alias == 'true') {
								if(strlen($details[$k]->ip_product) > 32) {
							    $content.= '<td style="font-size:0.8em;width:50%;">'.$details[$k]->ipp_alias;
								} else {
								    $content.= '<td style="font-size:0.9em;width:50%;">'.$details[$k]->ipp_alias;
								}
							}else{
								if(strlen($details[$k]->ip_product) > 32) {
								    $content.= '<td style="font-size:0.8em;width:50%;">'.$details[$k]->ip_product;
								} else {
								    $content.= '<td style="font-size:0.9em;width:50%;">'.$details[$k]->ip_product;
								}
							}
							$content.='</td><td style="font-size:0.9em;width:20%;">'.$details[$k]->iextamcpd_serial_number.'</td><td class="detail_center" style="text-align:center;width:10%;">'.$details[$k]->iextamcpd_qty.'</td><td class="detail_right" style="text-align:right;border-right: 1px solid #000;"></td></tr>';
							for($m=0; $m < count($taxes); $m++){
								if($taxes[$m]->itxgc_tg_id == $details[$k]->iextamc_tax){
									$tax = $tax + $taxes[$m]->itx_percent;
								}
							}
						}
						for ($i=0; $i < $line_cnt_total; $i++) {
							$content.= '<tr class="item_name"><td style="text-align:center;width:10%;"></td><td style="width:50%;"></td><td style="width:20%;"></td><td class="detail_center" style="text-align:center;width:10%;"></td><td class="detail_right" style="text-align:right;border-right: 1px solid #000;"></td></tr>';
						}
						$tax_amount = 0;
						$content .= '<tr class="item_name" style="border:1px solid #000;"><td style="text-align:left;font-weight:bold;border-top: 1px solid #000;border-bottom: 1px solid #000;" colspan="4">AMC Amount</td><td style="text-align:right;border-right: 1px solid #000;border-top: 1px solid #000;border-bottom: 1px solid #000;font-weight:bold;">'.$details[0]->iextamc_amount.'</td></tr>';
						for($m=0; $m < count($taxes); $m++){
							if($taxes[$m]->itxgc_tg_id == $details[0]->iextamc_tax){
								$t_amount = $details[0]->iextamc_amount * ($taxes[$m]->itx_percent/100);
								$content .= '<tr class="item_name"><td style="text-align:left;border-bottom:1px solid #000;" colspan="4">'.$taxes[$m]->itx_name.'</td><td style="text-align:right;border-right: 1px solid #000;border-bottom:1px solid #000;">'.$t_amount.'</td></tr>';
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

						$content .= '<tr class="item_name"><td style="text-align:left;font-weight:bold;" colspan="4">Rupees '.$result.' only</td><td style="text-align:right;border-right: 1px solid #000;font-weight:bold;">'.$g_total.'</td></tr>';

						$content.= '</tbody>';
						$content.= '<tfoot class="main_foot">';
						$content.= '<tr style="border-right:1px solid #000;"><td colspan="3" style="font-size:0.8em;padding-top:5px;border-left:1px solid #000;border-top: 1px solid #000;">Regd. office : A/36,Dattani Park No. 2, Kandivali (E),Mumbai - 400101.</td><td colspan="2" style="text-align: right; margin:0px;font-size:0.8em;border-right:1px solid #000;border-top: 1px solid #000;">E. & O.E.</td></tr>';
						$content.= '<tr><td colspan="5" style="border-left:1px solid #000;border-right:1px solid #000;"><div style="width:100%;;margin:0px;"></div><div style="text-align: left; margin:0px;">';
						$key = 0;
						if (count($terms) > 0 ) {
							$content.= '<b style="padding-top: 0px; font-size:0.8em;">Terms And condition : </b><br>';
							for($l=0;$l < count($terms); $l++){
								$key ++;
								$content.= '<b style="padding-top: 0px; font-size:0.8em;font-weight:normal;">'.$key.')'.$terms[$l]->iextdt_term.'</b><br>';
							}	
						}
						$content.= '</div></td></tr>';
						
						$content.= '<tr><td colspan="2" style="border-left:1px solid #000;margin-left:10px;font-size:0.9em;padding-top:50px;text-align:center;">Name & signature of authorized person with rubber stamp of contracting firm.</td><td colspan="3" style="border-right:1px solid #000;font-size:0.9em;font-size:0.9em;padding-top:50px;text-align:center;">For COSMOS ELECTRONICS</td></tr>';
						$content.= '<tr><td colspan="2" style="border-left:1px solid #000;margin-left:10px;font-size:0.9em;padding-top:40px;text-align:center;"></td><td colspan="3" style="border-right:1px solid #000;font-size:0.9em;font-size:0.9em;padding-top:40px;text-align:center;">Head-Service Division.</td></tr>';

						$content.= '<tr><td colspan="7" style="border-left:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;margin-left:10px;text-align:right;font-size:0.8em;"><p>Terms & Condition overleaf</p></td></tr>';

						$content.= '</tfoot>';
						$content.= '</table>';
            		    $content.= '</td></tr>';
            		    $content.= "</table>";
            		    $content.= "<div class='break_pg' style='page-break-before: always;'></div>";
					}
					echo $content;
				?>
			</div>
		</div>
	</div>
</main>