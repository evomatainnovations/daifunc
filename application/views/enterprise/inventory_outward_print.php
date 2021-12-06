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
    		<table border="0" style="width: 100%;"  id="general">
    			<tr>
    				<td style="width: 50%;">
    					<h3><?php echo $s_title; ?></h3>
    					Client Name:<br/>
    					<p>
    						<b><?php echo $s_name; ?></b><br>
    						<?php echo $s_address; ?><br>
    					</p>
    				</td>
    				<td>
    					<div style="text-align: right;">
    						<img src="<?php echo $s_logo; ?>" style="width: auto; height: 150px;">
    					</div>
    					<div style="text-align: right;">
    						<table style="width: 100%;padding: 10px;">
    							<tr>
    								<td class="col_right">
    									<b>Inventory Outward No:</b>			
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
    		<!--<h4>Inventory Outward Details	</h4>-->
    		<!-- <p><?php echo $s_txn_note; ?></p> -->
    	</div>
    	<div style="border: 0px #000 solid;">
    		<table border="0" style="width: 100%;" id="items">
    			<thead>
    				<tr>
    					<th>Sr. No.</th>
    					<th>Particulars</th>
    					<th>Qty</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<?php 
    						$grand_total = 0;
    						for ($i=0; $i < count($details) ; $i++) { 
    
    							echo "<tr>";
    							echo "<td>".($i+1)."</td>";
    							echo "<td>";
    							if ($details[$i]->iexteid_alias == "true") {
    								echo $details[$i]->ipp_alias;
    							} else {
    								echo $details[$i]->ip_product;
    							}
    							
    							if ($details[$i]->iexteid_serial_number!=="") {
    								echo " ( S/N: ".$details[$i]->iexteid_serial_number." )";
    							}
    							echo "</td>";
    							echo "<td>".$details[$i]->iexteid_outward."</td>";
    							echo "</tr>";
    						}
    					?>
    				</tr>
    			</tbody>
    		</table>
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
    	    <div style="text-align: right;margin-top:4em;">
        		<b style="border-top: 1px #000 solid;margin-left: 70%;padding-top: 10px;">Authorized Signature</b>
        	</div>
        </div>
    </div>
	<hr>
</div>
<div id="duplicate" style="width: 100%;">
	<div style="border: 2px #999 solid;padding: 20px;">
    	<div style="border: 0px #000 solid;">
    		<div style="text-align: center">Duplicate</div>
    		<table border="0" style="width: 100%;"  id="general">
    			<tr>
    				<td style="width: 50%;">
    					<h3><?php echo $s_title; ?></h3>
    					Client Name:<br/>
    					<p>
    						<b><?php echo $s_name; ?></b><br>
    						<?php echo $s_address; ?><br>
    					</p>
    				</td>
    				<td>
    					<div style="text-align: right;">
    						<img src="<?php echo $s_logo; ?>" style="width: auto; height: 150px;">
    					</div>
    					<div style="text-align: right;">
    						<table style="width: 100%;padding: 10px;">
    							<tr>
    								<td class="col_right">
    									<b>Inventory Outward No:</b>			
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
    		<!--<h4>Inventory Outward Details	</h4>-->
    		<!-- <p><?php echo $s_txn_note; ?></p> -->
    	</div>
    	<div style="border: 0px #000 solid;">
    		<table border="0" style="width: 100%;" id="items">
    			<thead>
    				<tr>
    					<th>Sr. No.</th>
    					<th>Particulars</th>
    					<th>Qty</th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<?php 
    						$grand_total = 0;
    						for ($i=0; $i < count($details) ; $i++) { 
    
    							echo "<tr>";
    							echo "<td>".($i+1)."</td>";
    							echo "<td>";
    							if ($details[$i]->iexteid_alias == "true") {
    								echo $details[$i]->ipp_alias;
    							} else {
    								echo $details[$i]->ip_product;
    							}
    							
    							if ($details[$i]->iexteid_serial_number!=="") {
    								echo " ( S/N: ".$details[$i]->iexteid_serial_number." )";
    							}
    							echo "</td>";
    							echo "<td>".$details[$i]->iexteid_outward."</td>";
    							echo "</tr>";
    						}
    					?>
    				</tr>
    			</tbody>
    		</table>
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