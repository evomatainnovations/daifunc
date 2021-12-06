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
        
        #content { page-break-after: always; }
    }
 
</style>
<div class="mdl-grid">

</div>

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
    						GST No: <?php echo $s_gst;?>
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
    									<b>Tax Invoice No:</b>			
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
	    <div style="border: 0px #000 solid;" id="item_div">
		    <table border="0" style="width: 100%;" id="items">
			    <thead>
				<tr>
					<th>Sr. No.</th>
					<th>Particulars</th>
					<th>Rate</th>
					<th>Qty</th>
					<?php 
					    $test = false;
					    for ($i=0; $i < count($details) ; $i++) { 
							$tmp_rate = $details[$i]->iexteinpd_rate;
							$tmp_qty = $details[$i]->iexteinpd_qty;
							$tmp_amt = $tmp_rate*$tmp_qty;
							$tmp_disc = $details[$i]->iexteinpd_discount;

							$tmp_disc_calc = 0;
						
							if (strpos($tmp_disc, "%") !== false) {
								$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
								$tmp_disc_calc = (float)$ptst;

								$tmp_amt = $tmp_rate*$tmp_qty;
								$tmp_amt = $tmp_amt * $tmp_disc_calc / 100;
							} else {
								$tmp_disc_calc = (float)$tmp_disc;
								$tmp_amt = $tmp_disc_calc;
							}
							
							if($tmp_amt > 0) {
							    $test = true;
					            echo "<th>Discount</th>";
					            break;
							}
							
						}
					?>
					<!--<th>Value</th>-->
					<!--<th>Tax</th>-->
					<th>Amount</th>
				</tr>
			</thead>
			    <tbody>
				<tr>
					<?php 
					setlocale(LC_MONETARY, 'en_IN');
					    $break_page = [1];
						$product_value = 0;
						$grand_total = 0;
						$txn_tmp = [];
                        $tmp_prod_name = "";
                        $tmp_tax_item_number = [];
                        
					    for ($i=0; $i < count($details) ; $i++) { 
                            if($i == 17) {
                                array_push($break_page, 2);
                            }
                            
                            
                            
							$tmp_rate = $details[$i]->iexteinpd_rate;
							$tmp_qty = $details[$i]->iexteinpd_qty;
							$tmp_amt = $tmp_rate*$tmp_qty;
							$tmp_disc = $details[$i]->iexteinpd_discount;
                            
                            array_push($tmp_tax_item_number, array("item_no" => $i + 1, "txn_no" => $details[$i]->iexteinpd_id));
                            
							$tmp_disc_calc = 0;
						
							echo "<tr>";
							echo "<td>".($i+1)."</td>";
							echo "<td>";
							if ($details[$i]->iexteinpd_alias == "true") {
								echo $details[$i]->ipp_alias;
							} else {
								echo $details[$i]->ip_product;
							}
							
							if($s_txn_disp_hsn == "true") {
							    echo "<br>HSN/SAC:".$details[$i]->ipai_hsn_code;
							}
							
							if($s_txn_disp_desc == "true") {
							    echo "<br><i>".$details[$i]->ipai_description."</i>";
							}
							
							
							if ($details[$i]->iexteinpd_serial_number!=="") {
								echo "<br>S/N:".$details[$i]->iexteinpd_serial_number;
							}
							echo "</td>";
							echo "<td class='amount'>".money_format("%.2n", $details[$i]->iexteinpd_rate)."</td>";
							echo "<td class='amount'>".$details[$i]->iexteinpd_qty."</td>";
							
							if($test == true) {
						    	if (strpos($tmp_disc, "%") !== false) {
    								$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
    								$tmp_disc_calc = (float)$ptst;
    
    								$tmp_amt = $tmp_rate*$tmp_qty;
    								$tmp_amt = $tmp_amt * $tmp_disc_calc / 100;
    								
    								if($tmp_amt > 0) {
    								    echo "<td class='amount'>".money_format("%.2n", $tmp_amt)."(".$details[$i]->iexteinpd_discount.")</td>";    
    								}
    							} else {
    								$tmp_disc_calc = (float)$tmp_disc;
    
    								$tmp_amt = $tmp_disc_calc;
    								
    								if($tmp_amt > 0) {
    								    echo "<td>".money_format("%.2n", $tmp_amt)."</td>";    
    								}
    							}
							}
							
						
							echo "<td class='amount'>".money_format("%.2n", $details[$i]->iexteinpd_amount)."</td>";
				// 			echo "<td>";
							$tax_total = 0;

							$tx_tmp = [];
							$tmp_txn_id = $i + 1;
							for ($j=0; $j < count($product_taxes) ; $j++) { 
							    
								if ($details[$i]->iexteinpd_id == $product_taxes[$j]->iexteinpt_p_id) {
								    
								    $tax_total=$tax_total + $product_taxes[$j]->iexteinpt_t_amount;
								// 	echo $product_taxes[$j]->iexteinpt_t_name.': '.$product_taxes[$j]->iexteinpt_t_amount."<br>";
								}
							}
                            $product_value += $details[$i]->iexteinpd_amount;
							$total = $details[$i]->iexteinpd_amount + $tax_total;
							$grand_total = $grand_total + $total;
				// 			echo "</td>";
				// 			echo "<td>".$total."</td>";
							echo "</tr>";
						}
					?>
				</tr>
			</tbody>
			</table>
			
			<?php 
			    if(count($break_page) == 2) {
			        // echo "<br><br><b>Page 1 of ".count($break_page)."<br><br><br><br><br><br><br><br><br><br>";
			    }
			?>
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
				            for($k=0;$k < count($product_taxes); $k++) {
    					        if($taxes[$j]->itx_id == $product_taxes[$k]->iexteinpt_t_id) {
    					           //array_push($tmp_tax_item_number, $tmp_txn_id);
    					           
    					           $tmp_tax_calc_amount += $product_taxes[$k]->iexteinpt_t_amount;
    					           
    					           //if($product_taxes[$k]->iexteinpt_t_id == $tmp_tax_item_number) {
    					           //    array_push($tmp_tax_item, $tmp_tax_item_number);
    					               
    					           //}
    					           
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
				<tr>
				    <?php if($test == true) {
				            echo '<td colspan="5"><b>Grand Total</b></td>';
				        } else {
				            echo '<td colspan="4"><b>Grand Total</b></td>';
				        }
				    ?>
					
					<td class="amount" ><b><?php echo money_format("%.2n", $grand_total); ?></b></td>
				</tr>
			</tbody>
		</table>
		<div style="text-align:right;">E. & O.E.</div>
			
	    </div>
	    <div style="border: 0px #000 solid;font-size:0.8em;" id="terms">
		    <table border="0" style="width: 100%;text-align: left;padding-top: 10px;">
			<tr>
				<th colspan="2">Terms:</th>
			</tr>
			<?php for ($i=0; $i < count($terms) ; $i++) { 
				echo "<tr>";
				echo "<td>".($i+1)."</td>";
				echo "<td>".$terms[$i]->iextdt_term."</td>";
				echo "</tr>";
			} ?>
		</table>
		    <b>GST No: <?php echo $u_gst; ?></b>
    		<div style="text-align: right;margin-top:4em;">
        		<b style="border-top: 1px #000 solid;margin-left: 70%;padding-top: 10px;">Authorized Signature</b>
        	</div>
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