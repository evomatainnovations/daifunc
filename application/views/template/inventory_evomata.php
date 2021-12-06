<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			<div id="content" style="width: 100%;">
				<?php
					$typearr = [];
					$typeidarr = [];
					for ($i=0; $i < count($temp_copies) ; $i++) {
						array_push($typearr , $temp_copies[$i]->iutc_copies);
						array_push($typeidarr , $temp_copies[$i]->iutc_copies);
					}
					$content = "<style> @media print { .main_foot { display:table-footer-group; }  .main_head { display:table-header-group; }  } .col_right {text-align: left; padding-right: 0px; } .col_left {text-align: left; } .item_header > th {font-weight: bold; border-bottom: 1px solid #000;border-top: 1px solid #000;border-left: 1px solid #000;   } .item_name > td { border-bottom: 1px solid #000;border-left: 1px solid #000; height: 20px;} @page {size: A4; size:landscape; }  @media print { #duplicate {/*page-break-before: always;*/ } }  </style> <table style=\"width:100%;margin-bottom:5px;font-family: Calibri, sans-serif;\"><tr>";
					for($j=0;$j<count($typearr);$j++) {
					    $content.= '<td id="'.$typeidarr[$j].'" style="padding-right:25px;padding-left:25px;padding-top:20px;">';
            			$content.= '<table style="border-collapse:seperate; border-spacing:0px;">';
            			$content.= '<thead class="main_head">';
            			$content.= '<tr><td colspan="4"><div style="text-align: left;font-size:0.9em;font-weight:bold;">Delivery Challan - '.$temp_copies[$j]->iutc_copies.'</div></td></tr>';

            			$content.= '<tr><td colspan="5">';

            			$content.= '<table><tr><td style="font-size:0.9em;padding-top:25px;width:50%;">';
            			$content.= '<table style="width: 100%;">';
            			$content.= '<tr><td>'.$basic[0]->ic_name.'</td></tr>';
						for($ij=0;$ij < count($property); $ij++){
							$content.= '<tr><td>'.$property[$ij]->iexteinvept_property_value.'</td></tr>';
						}
						$content.= '</table>';
					    $content.= '</td>';

						$content.= '<td style="width:50%;text-align: center;"><img src="'.$s_logo.'" style="max-width: 100%; height: auto;"></td></tr></table>';
					    
					    $content.= '</td></tr>';
					    $content.= '<tr style="padding-top:20px;"><td colspan="2" style="padding:10px;font-size:0.9em;border-top:1px solid #000;border-left:1px solid #000;">';
            			$content.= 'Challan No. : '.$s_txn_id;
					    $content.= '</td>';
						$content.= '<td colspan="3" style="text-align: left;font-size:0.9em;padding:10px;border-top:1px solid #000;border-right:1px solid #000;border-left:1px solid #000;">Date : '.date('d-m-Y',strtotime($s_txn_date)).'</td></tr>';

						$content.= '<tr class="item_header" style="width:100%;"><th style="width:10%;">Sr. No.</th><th style="width:50%;">Particulars</th><th style="width:20%;">Serial Number</th><th style="width:10%;">Qty</th><th style="width:10%;border-right: 1px solid #000;">Amount</th></tr>';
						$content.='</thead>';
						$content.='<tbody>';
						$line_cnt = count($details);
						$n_o_p = ceil(count($details)/28);
						$line_cnt_total = ($n_o_p * 28) - $line_cnt;
				        $amt=0;
				        for ($i=0; $i < count($details) ; $i++) {
							$content.= '<tr class="item_name"><td style="text-align:center;width:10%;">'.($i+1).'</td>';
							$content.= '<td style="font-size:0.8em;width:50%;">'.$details[$i]->ip_product.'</td>';
							$content.= '<td style="font-size:0.8em;width:20%;">'.$details[$i]->iin_serial_number.'</td>';
							$content.='<td class="detail_center" style="text-align:center;width:10%;">'.$details[$i]->iin_inward.'</td><td class="detail_right" style="text-align:right;border-right: 1px solid #000;"></td></tr>';
						}
						for ($i=0; $i < $line_cnt_total; $i++) {
							$content.= '<tr class="item_name"><td style="text-align:center;width:10%;"></td><td style="width:50%;"></td><td style="width:20%;"></td><td class="detail_center" style="text-align:center;width:10%;"></td><td class="detail_right" style="text-align:right;border-right: 1px solid #000;"></td></tr>';
						}
						$totamt=0;$transamt=0;
						$content.= '</tbody>';
						$content.= '<tfoot class="main_foot">';
						if($s_txn_note != ''){
							$content .= '<tr><td colspan="5"><p><b>NOTE</b> : '.$s_txn_note.'</p></td></tr>';
						}
						$content.= '<tr><td colspan="2"><div style="padding-top: 3em;width:100%;margin:0px;"></div><div style="text-align: left; margin:0px;"><b style="padding-top: 5px; font-size:0.9em;border-top:1px solid #000;">Receivers Signature</div></td>';
						$content.= '<td colspan="3"><div style="padding-top: 3em;width:100%;margin:0px;"></div><div style="text-align: right; margin:0px;"><b style="padding-top: 5px;border-top: 1px solid #000;font-size:0.9em;">Proprietor/ Authorized Signature</b></div></td>';
						$content.= '</tr>';
						$content.= '</tfoot>';
						$content.= '</table>';
            		    $content.= '</td>';
					}
					$content.= "</tr></table>";
					echo $content;
				?>
			</div>
		</div>
	</div>
</main>