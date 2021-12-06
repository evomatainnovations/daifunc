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
	}

</style>
<div id="content" style="width: 100%;">
	<div style="border: 2px #999 solid;padding: 20px;">
	<div style="border: 0px #000 solid;">
		<div style="text-align: center">Original</div>
		<table border="0" style="width: 100%;">
			<tr>
				<td>
					<h3><?php echo $s_title; ?></h3>
					Student Name:<br/>
					<b><?php echo $s_name; ?></b>
					<p><?php echo $s_address; ?></p>				
				</td>
				<td>
					<div style="text-align: right;">
						<img src="<?php echo $s_logo; ?>" style="width: auto; height: 90px;">
					</div>
					<div style="text-align: right;">
						<table style="width: 100%;padding: 10px;">
							<tr>
								<td class="col_right">
									<b>Date:</b>
								</td>
								<td class="col_left">
									<u><?php echo $s_date; ?></u>	
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div style="text-align: center;">
		<hr>
		<h4>Marks Details</h4>
	</div>
	<div style="border: 0px #000 solid;">
		<table border="1" style="width: 100%;">
			<tr>
				<th>Sr. No.</th>
				<th>Exam</th>
				<th>Obt</th>
				<th>Total</th>
				<th>Grade</th>
				<th>Details</th>
				<th>Percent</th>
			</tr>
			<?php 
				for ($i=0; $i < count($s_details) ; $i++) { 
					echo '<tr>';
					echo '<td>'.($i + 1).'</td>';
					echo '<td>'.$s_details[$i]['s_particular_text'].'</td>';
					echo '<td>'.$s_details[$i]['s_particular_obt'].'</td>';
					echo '<td>'.$s_details[$i]['s_particular_outof'].'</td>';
					echo '<td>'.$s_details[$i]['s_particular_grade'].'</td>';
					echo '<td>'.$s_details[$i]['s_particular_detail'].'</td>';
					echo '<td>'.$s_details[$i]['s_particular_percent'].'</td>';
					echo '</tr>';
				}
			?>
		</table>
	</div>
	<div style="border: 0px #000 solid;">
		<table border="0" style="width: 100%;text-align: left;padding-top: 10px;">
			<tr>
				<th colspan="2">Note:</th>
			</tr>
			<tr>
				<td>1.</td>
				<td>This recipt is provided after payment of complete fees</td>
			</tr>
			<tr>
				<td>2</td>
				<td>9000</td>
			</tr>
			<tr>
				<td>3.</td>
				<td>This recipt is provided after payment of complete fees</td>
			</tr>
			<tr>
				<td>4.</td>
				<td>This recipt is provided after payment of complete fees</td>
			</tr>

		</table>
	</div>
	<div style="text-align: right;">
		<b style="border-top: 1px #000 solid;margin-left: 70%;padding-top: 10px;">Authorized Signature</b>
	</div>
	</div>
	<hr>
	</div>
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