<title><?php echo $s_title; ?></title>
<style>
    .detail_center {
        text-align:center;
    }
    
    .detail_right {
        text-align:right;
    }
</style>
<main class="mdl-layout__content">
  

	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--8-col">
			<div id="content" style="width: 100%;">
				
				<?php
					
					$content = "<style> @media print { .main_foot { display:table-footer-group; }  .main_head { display:table-header-group; }  } .col_right {text-align: right; padding-right: 10px; } .col_left {text-align: left; width: 30%; } .item_header > th {font-weight: bold; border:1px solid;   } .item_name > td { border: 0.5px solid; height: 20px;} @page {size: A4; size:landscape; }  @media print { #duplicate {/*page-break-before: always;*/ } }  </style> <table style=\"width:100%;margin-bottom:5px;font-family: Calibri, sans-serif;\"><tr>";
					
				for($j=0;$j<count($temp_copies);$j++)

				{

					    $content.= '<td id="'.$temp_copies[$j]->iutc_id.'" style="padding-right:10px;padding-left:10px;">';
            			$content.= '<table style="border-collapse:seperate; border-spacing:0px;">';
            			$content.= '<thead class="main_head">';
            			$content.= '<tr>';
            			$content.= '<td colspan="5"><img src="'.$s_logo.'" style="width: 100%; height: 100px;margin-bottom:5px;"></td>';
            			$content.= '</tr>';
            			$content.= '<tr><td colspan="5"><div style="text-align: center">Delivery Challan - '.$temp_copies[$j]->iutc_copies.'</div></td></tr>';
            			$content.= '<tr>';
            			// CLIENT
            			$content.= '<td colspan="3" style="font-size:0.9em;">Client Name:<b>'.$s_name.'</b><br>'.$s_address.'<br>';
						$content.= 'GST: '.$s_txn_id;
						$content.= '</td>';
            			$content.= '<td colspan="2">';
                        // DATE
            			$content.= '<table style="width: 100%;padding: 10px;">';
            			$content.= '<tr>';
            			$content.= '<td class="col_right"><b>Invoice No:</b></td>';
						$content.= '<td class="col_left"><u>#'.$s_txn_id.'</u></td>';
						$content.= '</tr>';
						$content.= '<tr>';
						$content.= '<td class="col_right"><b>Date:</b></td>';
						$content.= '<td class="col_left"><u>'.date_format(date_create($s_txn_date), 'd/m/Y').'</u></td>';
						$content.= '</tr>';
						$content.= '</table>';
					    $content.= '</td>';
					    $content.= '</tr>';
                        
						$content.= '<tr class="item_header"><th colspan="1" style="border-radius:5px 0px 0px 0px;width:200px; ">Sr. No.</th><th style="width:400px" colspan="3">Particulars</th>';

						$content.='<th style="border-radius:0px 5px 0px 0px;width:200px" colspan="1">Oty</th></tr>';
						$content.='</thead>';
						
				        // BODY BEGINS
						$content.='<tbody>';
						$break_page = [1];
						$product_value = 0;
						$grand_total = 0;
						$txn_tmp = [];
                        $tmp_prod_name = "";
                        $tmp_tax_item_number = [];
						$line_cnt = count($details);
						if(count($details) > 0 ) { $line_cnt_total = 13 - $line_cnt; } else { $line_cnt_total = 14 - $line_cnt; }
				        
				        for ($i=0; $i < count($details) ; $i++) {

				            
							$content.= '<tr class="item_name"><td colspan="1" style="text-align:center;">'.($i+1).'</td>';

							if(strlen($details[$i]->ip_product) > 32) {
							    $content.= '<td colspan="3" style="font-size:0.8em;">'.$details[$i]->ip_product.'</td>';
							} else {
							    $content.= '<td colspan="3">'.$details[$i]->ip_product.'</td>';
							}

							$content.='<td colspan="1" class="detail_center" style="text-align:center;">'.$details[$i]->iexteid_outward.'</td>';

							$content.='</tr>';
						}

						for ($i=0; $i < $line_cnt_total; $i++) {
							$content.= '<tr class="item_name"><td colspan="1" class="detail_center" style="text-align:center;"> </td><td colspan="3" class="detail_right" style="text-align:right;"></td><td colspan="1" class="detail_right" style="text-align:right;"></td></tr>';
						}

						$content.= '</tbody>';
				        
				       // FOOTER BEGINS
						$content.= '<tfoot class="main_foot">';
						$content.= '<tr class="item_name"><td colspan="5">Receivers Signature</td></tr>';
						
						$content.= '<tr class="item_name"><td colspan="5" style="border-radius:0px 0px 0px 5px;">Note: ';

						$content.= '</td></tr>';

						
						
						$content.= '<tr>';
						$content.= '<td colspan="3"><div style="font-size:0.7em;font-weight:bold;">TERMS & CONDITIONS</div><div style="font-size:0.5em; line-height:1em;">';
						for ($k=0; $k <count($terms) ; $k++) { 
						$content.=$terms[$k]->iextdt_term;
						}
						$content.='</div><div style="font-size:0.6em;">E.&.O.E.</div></td>';
						$content.= '<td colspan="2"><div style="padding-top: 3em;width:100%;border-bottom: 1px solid #000;margin:0px;"></div><div style="text-align: right; margin:0px;"><b style="padding-top: 0px; font-size:0.9em; padding-right: 50px; ">Proprietor/ Authorized Signature</b></div></td>';
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