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
					<h3><?php echo $s_title; ?></h3>
					Client Name:<br/>
					<p>
						<b><?php echo $s_name; ?></b><br>
						<?php echo $s_address; ?><br>
						GST No: <?php echo $s_gst;?>

					</p>
				</td>
				<td>
					<div style="text-align: right;">
						<img src="<?php echo $s_logo; ?>" style="width: auto; height: 100px;">
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
									<b>Period From:</b>
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_start_date; ?></u>	
								</td>
							</tr>
							<tr>
								<td class="col_right">
									<b>Period To:</b>
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_end_date; ?></u>	
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
		<h4>Invoice Details	</h4>
		<p><?php echo $s_txn_note; ?></p>
	</div>
	<div style="border: 0px #000 solid;">
		<table border="0" style="width: 100%;" id="items">
		    <thead>
			<tr>
				<th class="col_left">Sr. No.</th>
				<th class="col_left">Particulars</th>
				<!-- <th>Rate</th> -->
				<th class="col_right">Qty</th>
				<!-- <th>Discount</th>
				<th>Value</th>
				<th>Tax</th>
				<th>Amount</th> -->
			</tr>
			</thead>
			<tbody>
			<tr>
				<?php 
					setlocale(LC_MONETARY, 'en_IN');
					
					$grand_total = $s_txn_amount;
					for ($i=0; $i < count($details) ; $i++) { 
						// $tmp_rate = $details[$i]->iexteinpd_rate;
						$tmp_qty = $details[$i]->iextamcpd_qty;
						// $tmp_amt = $tmp_rate*$tmp_qty;
						// $tmp_disc = $details[$i]->iexteinpd_discount;

						// $tmp_disc_calc = 0;
						
						echo "<tr>";
						echo "<td>".($i+1)."</td>";
						echo "<td>".$details[$i]->ip_product."</td>";
						// echo "<td>".$details[$i]->iexteinpd_rate."</td>";
						echo "<td class='amount'>".$tmp_qty."</td>";
						// if (strpos($tmp_disc, "%") !== false) {
						// 	$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
						// 	$tmp_disc_calc = (float)$ptst;

						// 	$tmp_amt = $tmp_rate*$tmp_qty;
						// 	$tmp_amt = $tmp_amt * $tmp_disc_calc / 100;
						// 	echo "<td>".$tmp_amt."(".$details[$i]->iexteinpd_discount.")</td>";
						
						// } else {
						// 	$tmp_disc_calc = (float)$tmp_disc;

						// 	$tmp_amt = $tmp_disc_calc;
						// 	echo "<td>".$tmp_amt."</td>";
						
						// }
						// echo "<td>".$details[$i]->iexteinpd_amount."</td>";
						// echo "<td>";
						// $tax_total = 0;

						// for ($j=0; $j < count($taxes) ; $j++) { 
						// 	if($taxes[$j]->iexteinpt_p_id == $details[$i]->ip_id) {
						// 		$tax_total=$tax_total + $taxes[$j]->iexteinpt_t_amount;
						// 		echo $taxes[$j]->iexteinpt_t_name.': '.$taxes[$j]->iexteinpt_t_amount."<br>";
						// 	}
						// }

						// $total = $details[$i]->iexteinpd_amount + $tax_total;
						// $grand_total = $grand_total + $total;
						// echo "</td>";
						// echo "<td>".$total."</td>";
						echo "</tr>";
					}
				?>
			</tr>
			</tbody>
		</table>
		<table id="summary"	style="border:1px solid #999;">
			<?php
			    
			    echo '<tr><td colspan="2"><b>Sub Total</b></td><td class="amount"><b>'.money_format("%.2n",$basic[0]->iextamc_amount).'</b></td></tr>';
			    if($basic[0]->iextamc_discount != "" || $basic[0]->iextamc_discount != NULL) {
			        echo  '<tr><td colspan="2"><b>Discount</b></td><td class="amount"><b>-'.money_format("%.2n",$basic[0]->iextamc_discount).'</b></td></tr>';
			    }
			    echo '<tr><td colspan="2"><b>Total</b></td><td class="amount"><b>'.money_format("%.2n",$basic[0]->iextamc_total).'</b></td></tr>';
			    $amt = $basic[0]->iextamc_total;$gt=$amt;
			    for($i=0;$i<count($taxes);$i++) {
			        $tx = $taxes[$i]->itx_percent;
			        $tamt=$amt*$tx/100; $gt+=$tamt;
			        echo '<tr><td colspan="2">'.$taxes[$i]->itx_name.'</td><td class="amount">'.$tamt.'</td></tr>';
			    }
			    echo '<tr><td colspan="2"><b>Grand Total</b></td><td class="amount"><b>'.money_format("%.2n",$gt).'</b></td></tr>';
			?>
		</table>
	</div>
	<div style="border: 0px #000 solid;">
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
	</div>
	<div style="text-align: right;">
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
		<div style="text-align: center">Original</div>
		<table border="0" style="width: 100%;" id="general">
			<tr>
				<td style="width: 50%;">
					<h3><?php echo $s_title; ?></h3>
					Client Name:<br/>
					<p>
						<b><?php echo $s_name; ?></b><br>
						<?php echo $s_address; ?><br>
						GST No: <?php echo $s_gst;?>

					</p>
				</td>
				<td>
					<div style="text-align: right;">
						<img src="<?php echo $s_logo; ?>" style="width: auto; height: 100px;">
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
									<b>Period From:</b>
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_start_date; ?></u>	
								</td>
							</tr>
							<tr>
								<td class="col_right">
									<b>Period To:</b>
								</td>
								<td class="col_left">
									<u><?php echo $s_txn_end_date; ?></u>	
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
		<h4>Invoice Details	</h4>
		<p><?php echo $s_txn_note; ?></p>
	</div>
	<div style="border: 0px #000 solid;">
		<table border="0" style="width: 100%;" id="items">
		    <thead>
			<tr>
				<th class="col_left">Sr. No.</th>
				<th class="col_left">Particulars</th>
				<!-- <th>Rate</th> -->
				<th class="col_right">Qty</th>
				<!-- <th>Discount</th>
				<th>Value</th>
				<th>Tax</th>
				<th>Amount</th> -->
			</tr>
			</thead>
			<tbody>
			<tr>
				<?php 
					setlocale(LC_MONETARY, 'en_IN');
					
					$grand_total = $s_txn_amount;
					for ($i=0; $i < count($details) ; $i++) { 
						// $tmp_rate = $details[$i]->iexteinpd_rate;
						$tmp_qty = $details[$i]->iextamcpd_qty;
						// $tmp_amt = $tmp_rate*$tmp_qty;
						// $tmp_disc = $details[$i]->iexteinpd_discount;

						// $tmp_disc_calc = 0;
						
						echo "<tr>";
						echo "<td>".($i+1)."</td>";
						echo "<td>".$details[$i]->ip_product."</td>";
						// echo "<td>".$details[$i]->iexteinpd_rate."</td>";
						echo "<td class='amount'>".$tmp_qty."</td>";
						// if (strpos($tmp_disc, "%") !== false) {
						// 	$ptst = substr($tmp_disc, 0, (strlen($tmp_disc) - 1));
						// 	$tmp_disc_calc = (float)$ptst;

						// 	$tmp_amt = $tmp_rate*$tmp_qty;
						// 	$tmp_amt = $tmp_amt * $tmp_disc_calc / 100;
						// 	echo "<td>".$tmp_amt."(".$details[$i]->iexteinpd_discount.")</td>";
						
						// } else {
						// 	$tmp_disc_calc = (float)$tmp_disc;

						// 	$tmp_amt = $tmp_disc_calc;
						// 	echo "<td>".$tmp_amt."</td>";
						
						// }
						// echo "<td>".$details[$i]->iexteinpd_amount."</td>";
						// echo "<td>";
						// $tax_total = 0;

						// for ($j=0; $j < count($taxes) ; $j++) { 
						// 	if($taxes[$j]->iexteinpt_p_id == $details[$i]->ip_id) {
						// 		$tax_total=$tax_total + $taxes[$j]->iexteinpt_t_amount;
						// 		echo $taxes[$j]->iexteinpt_t_name.': '.$taxes[$j]->iexteinpt_t_amount."<br>";
						// 	}
						// }

						// $total = $details[$i]->iexteinpd_amount + $tax_total;
						// $grand_total = $grand_total + $total;
						// echo "</td>";
						// echo "<td>".$total."</td>";
						echo "</tr>";
					}
				?>
			</tr>
			</tbody>
		</table>
		<table id="summary"	style="border:1px solid #999;">
			<?php
			    
			    echo '<tr><td colspan="2"><b>Sub Total</b></td><td class="amount"><b>'.money_format("%.2n",$basic[0]->iextamc_amount).'</b></td></tr>';
			    if($basic[0]->iextamc_discount != "" || $basic[0]->iextamc_discount != NULL) {
			        echo  '<tr><td colspan="2"><b>Discount</b></td><td class="amount"><b>-'.money_format("%.2n",$basic[0]->iextamc_discount).'</b></td></tr>';
			    }
			    echo '<tr><td colspan="2"><b>Total</b></td><td class="amount"><b>'.money_format("%.2n",$basic[0]->iextamc_total).'</b></td></tr>';
			    $amt = $basic[0]->iextamc_total;$gt=$amt;
			    for($i=0;$i<count($taxes);$i++) {
			        $tx = $taxes[$i]->itx_percent;
			        $tamt=$amt*$tx/100; $gt+=$tamt;
			        echo '<tr><td colspan="2">'.$taxes[$i]->itx_name.'</td><td class="amount">'.$tamt.'</td></tr>';
			    }
			    echo '<tr><td colspan="2"><b>Grand Total</b></td><td class="amount"><b>'.money_format("%.2n",$gt).'</b></td></tr>';
			?>
		</table>
	</div>
	<div style="border: 0px #000 solid;">
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
	</div>
	<div style="text-align: right;">
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