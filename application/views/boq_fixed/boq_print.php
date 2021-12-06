<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div id="content" style="width: 100%;">
				<?php
					$alpha = array('','A','B','C','D','E','F','G','H','I','J','K', 'L','M','N','O','P','Q','R','S','T','U','V','W','X ','Y','Z');
					$content = "<style> @media print { .main_foot { display:table-footer-group; }  .main_head { display:table-header-group;}  } .col_right {text-align: left; padding-right: 0px; } .col_left {text-align: left; } .item_header > th {font-weight: bold; border: 1px solid #000;} .item_name > td { border: 1px solid #000; height: 20px;padding:5px;} @page {size: A4; size:landscape; }  @media print { .break_pg {/*page-break-before: always;*/ } }  </style>";

				    $content.= '<table style="width:100%;margin-bottom:5px;font-family: Calibri, sans-serif;margin-top:20px;border-collapse: collapse;">';
        			$content.= '<thead class="main_head">';
					$content.= '<tr class="item_header" style="width:100%;"><th style="width:5%;">Sr. No.</th><th style="width:50%;">Particulars</th><th style="width:5%;">Unit</th><th style="width:10%;">Qty</th><th style="width:10%;">Rate</th><th style="width:10%;">Amount</th></tr>';
					$content.='</thead>';
					$content.='<tbody>';
					for ($i=0; $i < count($boq) ; $i++) {
						$n = $i+1;
						$content.= '<tr class="item_name"><td style="width:5%;font-weight:bold;text-align:center;">'.$alpha[$n].'</td>';
						$content.= '<td style="width:50%;font-weight:bold;text-align:left;padding-left:5px;"">'.$boq[$i]->cat_name.'</td><td style="width:5%;"></td><td style="width:10%;"></td><td style="width:10%;"></td><td style="width:10%;"></td>';
						$content.= '</tr>';
						for ($ij=0; $ij <count($boq[$i]->item_arr) ; $ij++) {
							$k = $ij +1;
							$content.= '<tr class="item_name" style="font-size:0.9em;">';
							$content.= '<td style="width:5%;text-align:center;">'.$k.'</td>';
							$content.= '<td style="width:50%;text-align:left;padding-left:5px;">'.$boq[$i]->item_arr[$ij]->particular.'</td>';
							$content.= '<td style="width:5%;text-align:center;">'.$boq[$i]->item_arr[$ij]->unit.'</td>';
							$content.= '<td style="width:10%;text-align:center;">'.$boq[$i]->item_arr[$ij]->qty.'</td>';
							$content.= '<td style="width:10%;text-align:center;">'.$boq[$i]->item_arr[$ij]->rate.'</td>';
							$content.= '<td style="width:10%;text-align:right;">'.$boq[$i]->item_arr[$ij]->amount.'</td>';
							$content.= '</tr>';
						}

						$content.= '<tr class="item_name" style="font-size:0.9em;"><td style="width:5%;text-align:center;"></td><td style="width:50%;text-align:left;padding-left:5px;"></td><td style="width:5%;text-align:center;"></td><td style="width:10%;text-align:center;"></td><td style="width:10%;text-align:center;"></td><td style="width:10%;text-align:right;"></td></tr>';
					}
					$content.='</tbody>';
        		    $content.= "</table>";
					echo $content;
				?>
			</div>
		</div>
	</div>
</main>