<title><?php echo $s_name." ".str_replace("/","",$s_txn_id)." ".$s_txn_date; ?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="<?php echo base_url().'assets/js/html2canvas.js'; ?>"></script>
	
<style>
	.col_right {
		text-align: right;
		padding-right: 10px;
	}

	.col_left {
		text-align: left;
		width: 30%;
		white-space:nowrap;
	}

	html, body {
		font-family: Calibri,sans-serif;
		font-size: 1em;
	}

	table  {
		font-family: Calibri, sans-serif;
		font-size: 0.9em;
		width: 100%;scroll-behavior: auto; overflow: auto;
	}

	thead > tr {
		border: 1px solid #999; box-shadow: 0px 3px 5px #999;
	}

	thead > tr >  th {
		padding-top: 10px; padding-bottom: 10px; padding-left: 10px; padding-right: 10px;
	}

	#items > tbody > tr > td {
		border-bottom: 1px solid #ccc;
	}
	
	.amount {
        text-align:right;
    }
	
	 @page {
        size: A4;
    }
    
    @media print {
    	#terms { display: block; page-break-before: auto; }
    	#item_div { display: block; page-break-after: avoid; }
    }
    
    @media print {
        #items { page-break-inside:auto; page-break-after: auto; }
        #items > tbody > tr    { page-break-inside:avoid; page-break-after:auto }
        #items > thead { display:table-header-group }
        #items > tfoot { display:table-footer-group }
        #items > td    { page-break-inside:avoid; page-break-after:auto }
        
        #duplicate { page-break-before: always; }
    }

</style>
<div id="content" style="width: 100%;">
	<div style="border: 2px #999 solid;padding: 20px;">
	<div style="border: 0px #000 solid;">
		<div style="text-align: center">Original</div>
		<table border="0" style="width: 100%;" id="general">
			<tr>
				<td style="width: 50%;">
					<h1><?php echo $s_title; ?></h1>
					Client Name:<br/>
					<p>
						<b><?php echo $s_name; ?></b><br>
						<?php echo $s_address; ?><br>
						<!-- GST No: <?php echo $s_gst;?> -->

					</p>
				</td>
				<td>
					<div style="text-align: right;">
						<img src="<?php echo $s_logo; ?>" style="width: auto; height: 110px;">
					</div>
					<div style="text-align: right;">
						<table style="width: 100%;padding: 10px;">
							<tr>
								<td class="col_right">
									<b>Quotation No:</b>			
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_id; ?></u>			
								</td>
							</tr>
							<tr>
								<td class="col_right">
									<b>Date:</b>
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_date; ?></u>	
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div style="text-align: left;">
		<hr>
		<p><?php echo $s_txn_note; ?></p>
	</div>
	<div style="border: 0px #000 solid;">
		<table border="0" style="width: 100%;" id="items">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Particulars</th>
					<th style='text-align:right;'>Rate</th>
					<th style='text-align:right;'>Qty</th>
					<?php 
					    
					    $test = false;
					    for ($i=0; $i < count($details) ; $i++) { 
							$tmp_disc = $details[$i]->iexteqpd_discount;
							$tmp_disc_calc = 0;
						
							if (strpos($tmp_disc, "%") !== false) {
								$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
								$tmp_disc_calc = (float)$ptst;

                                if($tmp_disc_calc > 0) {
                                    echo "<th>Discount</th>";
                                    $test = true;
                                    break;
                                }
							} else {
								$tmp_disc_calc = (float)$tmp_disc;
								if($tmp_disc_calc > 0) {
								    echo "<th>Discount</th>";
								    $test = true;
								    break;
								}
							}
						}
					?>
					<!--<th>Value</th>-->
					<!--<th>Tax</th>-->
					<th style='text-align:right;'>Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php 
					setlocale(LC_MONETARY, 'en_IN');
						$product_value = 0;
						$grand_total = 0;
						$main_tax_total = 0;
						$txn_tmp = [];
						$item_count = 0;
						
						$tmp_prod_name = "";
                        $tmp_tax_item_number = [];
                        
						
						for ($i=0; $i < count($details) ; $i++) { 
							$tmp_rate = $details[$i]->iexteqpd_rate;
							$tmp_qty = $details[$i]->iexteqpd_qty;
							$tmp_amt = $tmp_rate*$tmp_qty;
							$tmp_disc = $details[$i]->iexteqpd_discount;

							$tmp_disc_calc = 0;
							
							echo "<tr>";
							echo "<td>".($i+1)."</td>";
							echo "<td style='max-width:250px;'>";
						
							if ($details[$i]->iexteqpd_alias == "true") {
								echo $details[$i]->ipp_alias;
							} else {
								echo $details[$i]->ip_product;
							}
							
							#if ($details[$i]->iexteqpd_serial_number!=="") {
							#	echo "<br>S/N:".$details[$i]->iexteqpd_serial_number;
							#}
							
							echo "</td>";
							echo "<td style='text-align:right;' classs='amount'>".money_format("%.2n", $details[$i]->iexteqpd_rate)."</td>";
							echo "<td style='text-align:right;' classs='amount'>".$details[$i]->iexteqpd_qty."</td>";
							
							if($test == true) {
							    if (strpos($tmp_disc, "%") !== false) {
    								$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
    								$tmp_disc_calc = (float)$ptst;
    
    								$tmp_amt = $tmp_rate*$tmp_qty;
    								$tmp_amt = $tmp_amt * $tmp_disc_calc / 100;
    								
    								echo "<td classs='amount'>".money_format("%.2n", $tmp_amt)."(".$details[$i]->iexteqpd_discount.")</td>";   
    							} else {
    								$tmp_disc_calc = (float)$tmp_disc;
    
    								$tmp_amt = $tmp_disc_calc;
    								echo "<td classs='amount'>".money_format("%.2n", $tmp_amt)."</td>";
    							
    							}
							}
    						
							echo "<td style='text-align:right;' classs='amount'>".money_format("%.2n", $details[$i]->iexteqpd_amount)."</td>";
				// 			echo "<td>";
							$tax_total = 0;

							$tx_tmp = [];
							for ($j=0; $j < count($quotation_taxes) ; $j++) { 
								if ($details[$i]->iexteqpd_id == $quotation_taxes[$j]->iexteqpt_p_id) {
									$tax_total=$tax_total + $quotation_taxes[$j]->iexteqpt_t_amount;
								// 	echo $quotation_taxes[$j]->iexteqpt_t_name.': '.$quotation_taxes[$j]->iexteqpt_t_amount."<br>";
								}
							}
                            $product_value += $details[$i]->iexteqpd_amount;
                            $main_tax_total = $main_tax_total + $tax_total;
                            
							$total = $details[$i]->iexteqpd_amount + $tax_total;
							$grand_total = $grand_total + $total;
				// 			echo "</td>";
				// 			echo "<td>".$total."</td>";
							echo "</tr>";
						}
					?>
				</tr>
			</tbody>
			</table>
			<table style="border:1px solid #999;" id="summary">
			    <tr>
				    <?php if($test == true) {
				            echo '<td colspan="5"><b>Product Value</b></td>';
				        } else {
				            echo '<td colspan="4"><b>Product Value</b></td>';
				        }
				    ?>
					
					<td class="amount" ><b><?php echo money_format("%.2n", $product_value); ?></b></td>
				</tr>
				    <?php 
				        $tmp_tax_name = [];
                        $tmp_tax_amount = [];
                        $tmp_tax_item = [];
                        
				        
				        
				        for($j=0; $j < count($taxes); $j++) {
				            $tmp_tax_calc_amount = 0;
				            $tmp_tax_tmp_name = $taxes[$j]->itx_name;
				            for($k=0;$k < count($quotation_taxes); $k++) {
    					        if($taxes[$j]->itx_id == $quotation_taxes[$k]->iexteqpt_t_id) {
    					           
    					           $tmp_tax_calc_amount += $quotation_taxes[$k]->iexteqpt_t_amount;
    					           
    					           if(!in_array($tmp_tax_tmp_name, $tmp_tax_name)) {
            					        array_push($tmp_tax_name, $tmp_tax_tmp_name);
            					   }
    					        }
    					    }
    					     if(in_array($tmp_tax_tmp_name, $tmp_tax_name)) {
    					        array_push($tmp_tax_amount, $tmp_tax_calc_amount);
    					     }
				        }
				        
				        for($l=0; $l < count($tmp_tax_name); $l++) {
				            if($test == true) {
    				            echo '<tr><td colspan="5"><b>'.$tmp_tax_name[$l].'</b></td><td class="amount" >'.money_format("%.2n", $tmp_tax_amount[$l]).'</td></tr>';
    				        } else {
    				            echo '<tr><td colspan="4"><b>'.$tmp_tax_name[$l].'</b></td><td class="amount" >'.money_format("%.2n", $tmp_tax_amount[$l]).'</td></tr>';
    				        }
				        }
				    ?>
				
				<tr style="font-size:1.3em;">
				    <?php if($test == true) {
				            echo '<td colspan="5"><b>Grand Total</b></td>';          
				        } else {
				            echo '<td colspan="4"><b>Grand Total</b></td>';
				        }
				    ?>
					<td style="text-align:right;"><b style="text-align:right;"><?php echo money_format("%.2n", $grand_total); ?></b></td>
					
				</tr>
			</tbody>
		</table>
	</div>
	<div style="border: 0px #000 solid;font-size:0.8em;">
		<table border="0" style="width: 100%;text-align: left;padding-top: 10px;">
			<tr>
				<th colspan="2">Terms:</th>
			</tr>
			<?php for ($i=0; $i < count($terms) ; $i++) { 
				echo "<tr>";
				echo "<td>".($i+1)."</td>";
				echo "<td>".$terms[$i]->iexteqtm_terms."</td>";
				echo "</tr>";
			} ?>
		</table>
		<!-- <b>GST No: <?php echo $u_gst; ?></b> -->
	</div>
	<div style="text-align: right;margin-top:4em;">
		<b style="border-top: 1px #000 solid;margin-left: 70%;padding-top: 10px;">Authorized Signature</b>
	</div>
	</div>
	<hr>
<!-- 	<div style="border: 2px #999 solid;padding: 20px;">
	<div style="text-align: center;">
		<hr>
		<h4>Payment Details</h4>
	</div>
	<div style="border: 0px #000 solid;">
		<table border="1" style="width: 100%;">
			<tr>
				<th>Sr. No.</th>
				<th>Amount</th>
				<th>Particulars</th>
			</tr>
			<?php if(isset($fee_details)) {
				for ($i=0; $i < count($fee_details) ; $i++) { 
					echo '<tr>';
					echo '<td>'.($i+1).'</td>';
					echo '<td>'.$fee_details[$i]->iextf_paid_fee.'</td>';
					echo '<td>Date: '.$fee_details[$i]->iextf_paid_date.' Medium:'.$fee_details[$i]->iextf_medium.' Details: '.$fee_details[$i]->iextf_details.'</td>';
					echo '</tr>';
				}
			 } ?>
		</table>
		<h3>Balance Fee: <?php if (isset($fee_details)) { $a=count($fee_details)-1; echo $fee_details[$a]->iextf_balance_fee; } else { echo $s_fees;} ?></h3>
	</div>
	<br>
	<div style="text-align: right; margin-top: 50px;">
		<b style="border-top: 1px #000 solid;margin-left: 70%;padding-top: 10px;">Authorized Signature</b>
	</div>
	</div> -->
</div>
<div id="duplicate" style="width: 100%;">
	<div style="border: 2px #999 solid;padding: 20px;">
	<div style="border: 0px #000 solid;">
		<div style="text-align: center">Duplicate</div>
		<table border="0" style="width: 100%;" id="general">
			<tr>
				<td style="width: 50%;">
					<h1><?php echo $s_title; ?></h1>
					Client Name:<br/>
					<p>
						<b><?php echo $s_name; ?></b><br>
						<?php echo $s_address; ?><br>
						<!-- GST No: <?php echo $s_gst;?> -->

					</p>
				</td>
				<td>
					<div style="text-align: right;">
						<img src="<?php echo $s_logo; ?>" style="width: auto; height: 110px;">
					</div>
					<div style="text-align: right;">
						<table style="width: 100%;padding: 10px;">
							<tr>
								<td class="col_right">
									<b>Quotation No:</b>			
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_id; ?></u>			
								</td>
							</tr>
							<tr>
								<td class="col_right">
									<b>Date:</b>
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_date; ?></u>	
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div style="text-align: left;">
		<hr>
		<p><?php echo $s_txn_note; ?></p>
	</div>
	<div style="border: 0px #000 solid;">
		<table border="0" style="width: 100%;" id="items">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Particulars</th>
					<th style='text-align:right;'>Rate</th>
					<th style='text-align:right;'>Qty</th>
					<?php 
					    
					    $test = false;
					    for ($i=0; $i < count($details) ; $i++) { 
							$tmp_disc = $details[$i]->iexteqpd_discount;
							$tmp_disc_calc = 0;
						
							if (strpos($tmp_disc, "%") !== false) {
								$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
								$tmp_disc_calc = (float)$ptst;

                                if($tmp_disc_calc > 0) {
                                    echo "<th>Discount</th>";
                                    $test = true;
                                    break;
                                }
							} else {
								$tmp_disc_calc = (float)$tmp_disc;
								if($tmp_disc_calc > 0) {
								    echo "<th>Discount</th>";
								    $test = true;
								    break;
								}
							}
						}
					?>
					<!--<th>Value</th>-->
					<!--<th>Tax</th>-->
					<th style='text-align:right;'>Amount</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php 
					setlocale(LC_MONETARY, 'en_IN');
						$product_value = 0;
						$grand_total = 0;
						$main_tax_total = 0;
						$txn_tmp = [];
						$item_count = 0;
						
						$tmp_prod_name = "";
                        $tmp_tax_item_number = [];
                        
						
						for ($i=0; $i < count($details) ; $i++) { 
							$tmp_rate = $details[$i]->iexteqpd_rate;
							$tmp_qty = $details[$i]->iexteqpd_qty;
							$tmp_amt = $tmp_rate*$tmp_qty;
							$tmp_disc = $details[$i]->iexteqpd_discount;

							$tmp_disc_calc = 0;
							
							echo "<tr>";
							echo "<td>".($i+1)."</td>";
							echo "<td>";
						
							if ($details[$i]->iexteqpd_alias == "true") {
								echo $details[$i]->ipp_alias;
							} else {
								echo $details[$i]->ip_product;
							}
							
							#if ($details[$i]->iexteqpd_serial_number!=="") {
							#	echo "<br>S/N:".$details[$i]->iexteqpd_serial_number;
							#}
							
							echo "</td>";
							echo "<td style='text-align:right;' classs='amount'>".money_format("%.2n", $details[$i]->iexteqpd_rate)."</td>";
							echo "<td style='text-align:right;' classs='amount'>".$details[$i]->iexteqpd_qty."</td>";
							
							if($test == true) {
							    if (strpos($tmp_disc, "%") !== false) {
    								$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
    								$tmp_disc_calc = (float)$ptst;
    
    								$tmp_amt = $tmp_rate*$tmp_qty;
    								$tmp_amt = $tmp_amt * $tmp_disc_calc / 100;
    								
    								echo "<td classs='amount'>".money_format("%.2n", $tmp_amt)."(".$details[$i]->iexteqpd_discount.")</td>";   
    							} else {
    								$tmp_disc_calc = (float)$tmp_disc;
    
    								$tmp_amt = $tmp_disc_calc;
    								echo "<td classs='amount'>".money_format("%.2n", $tmp_amt)."</td>";
    							
    							}
							}
    						
							echo "<td style='text-align:right;' classs='amount'>".money_format("%.2n", $details[$i]->iexteqpd_amount)."</td>";
				// 			echo "<td>";
							$tax_total = 0;

							$tx_tmp = [];
							for ($j=0; $j < count($quotation_taxes) ; $j++) { 
								if ($details[$i]->iexteqpd_id == $quotation_taxes[$j]->iexteqpt_p_id) {
									$tax_total=$tax_total + $quotation_taxes[$j]->iexteqpt_t_amount;
								// 	echo $quotation_taxes[$j]->iexteqpt_t_name.': '.$quotation_taxes[$j]->iexteqpt_t_amount."<br>";
								}
							}
                            $product_value += $details[$i]->iexteqpd_amount;
                            $main_tax_total = $main_tax_total + $tax_total;
                            
							$total = $details[$i]->iexteqpd_amount + $tax_total;
							$grand_total = $grand_total + $total;
				// 			echo "</td>";
				// 			echo "<td>".$total."</td>";
							echo "</tr>";
						}
					?>
				</tr>
			</tbody>
			</table>
			<table style="border:1px solid #999;" id="summary">
			    <tr>
				    <?php if($test == true) {
				            echo '<td colspan="5"><b>Product Value</b></td>';
				        } else {
				            echo '<td colspan="4"><b>Product Value</b></td>';
				        }
				    ?>
					
					<td class="amount" ><b><?php echo money_format("%.2n", $product_value); ?></b></td>
				</tr>
				    <?php 
				        $tmp_tax_name = [];
                        $tmp_tax_amount = [];
                        $tmp_tax_item = [];
                        
				        
				        
				        for($j=0; $j < count($taxes); $j++) {
				            $tmp_tax_calc_amount = 0;
				            $tmp_tax_tmp_name = $taxes[$j]->itx_name;
				            for($k=0;$k < count($quotation_taxes); $k++) {
    					        if($taxes[$j]->itx_id == $quotation_taxes[$k]->iexteqpt_t_id) {
    					           
    					           $tmp_tax_calc_amount += $quotation_taxes[$k]->iexteqpt_t_amount;
    					           
    					           if(!in_array($tmp_tax_tmp_name, $tmp_tax_name)) {
            					        array_push($tmp_tax_name, $tmp_tax_tmp_name);
            					   }
    					        }
    					    }
    					     if(in_array($tmp_tax_tmp_name, $tmp_tax_name)) {
    					        array_push($tmp_tax_amount, $tmp_tax_calc_amount);
    					     }
				        }
				        
				        for($l=0; $l < count($tmp_tax_name); $l++) {
				            if($test == true) {
    				            echo '<tr><td colspan="5"><b>'.$tmp_tax_name[$l].'</b></td><td class="amount" >'.money_format("%.2n", $tmp_tax_amount[$l]).'</td></tr>';
    				        } else {
    				            echo '<tr><td colspan="4"><b>'.$tmp_tax_name[$l].'</b></td><td class="amount" >'.money_format("%.2n", $tmp_tax_amount[$l]).'</td></tr>';
    				        }
				        }
				    ?>
				
				<tr style="font-size:1.3em;">
				    <?php if($test == true) {
				            echo '<td colspan="5"><b>Grand Total</b></td>';          
				        } else {
				            echo '<td colspan="4"><b>Grand Total</b></td>';
				        }
				    ?>
					<td style="text-align:right;"><b style="text-align:right;"><?php echo $grand_total; ?></b></td>
					
				</tr>
			</tbody>
		</table>
	</div>
	<div style="border: 0px #000 solid;font-size:0.8em;">
		<table border="0" style="width: 100%;text-align: left;padding-top: 10px;">
			<tr>
				<th colspan="2">Terms:</th>
			</tr>
			<?php for ($i=0; $i < count($terms) ; $i++) { 
				echo "<tr>";
				echo "<td>".($i+1)."</td>";
				echo "<td>".$terms[$i]->iexteqtm_terms."</td>";
				echo "</tr>";
			} ?>
		</table>
		<!-- <b>GST No: <?php echo $u_gst; ?></b> -->
	</div>
	<div style="text-align: right;margin-top:4em;">
		<b style="border-top: 1px #000 solid;margin-left: 70%;padding-top: 10px;">Authorized Signature</b>
	</div>
	</div>
	<hr>
</div>
<script type="text/javascript">
	html2canvas($('#content'), {
		onrendered : function(canvas) {
			var imgData = canvas.toDataURL('image/svg', 1.0);
			var doc = new jsPDF();
			doc.addImage(imgData, 'PNG', 10, 10);
			// doc.save('<?php echo $s_name; ?>.pdf');		
		},
		letterRendering : true,

	});
</script>