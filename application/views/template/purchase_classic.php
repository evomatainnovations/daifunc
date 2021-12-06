<style type="text/css">
*
{
	border: 0;
	box-sizing: content-box;
	color: inherit;
	font-family: inherit;
	font-size: inherit;
	font-style: inherit;
	font-weight: inherit;
	line-height: inherit;
	list-style: none;
	margin: 0;
	padding: 0;
	text-decoration: none;
	vertical-align: top;
}
h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

table { font-size: 75%; table-layout: fixed; width: 100%; }
table { border-collapse: separate; border-spacing: 2px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th { background: #EEE; border-color: #BBB; }
td { border-color: #DDD; }

html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
/*header span, header img { display: block; float: right; }*/
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
/*header img { max-height: 100%; max-width: 100%; }*/
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

table.meta, table.balance { float: right; width: 36%; }
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

table.meta th { width: 40%; }
table.meta td { width: 60%; }

table.inventory { clear: both; width: 100%; }
table.inventory th { font-weight: bold; text-align: center; }

table.inventory td:nth-child(1) { width: 26%; }
table.inventory td:nth-child(2) { width: 38%; }
table.inventory td:nth-child(3) { text-align: right; width: 12%; }
table.inventory td:nth-child(4) { text-align: right; width: 12%; }
table.inventory td:nth-child(5) { text-align: right; width: 12%; }

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: right; }

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }

@page { margin: 0; }
</style>
<html>
<?php for($i=0;$i < count($temp_copies);$i++){  ?>
	<body>
		<?php 
		$g_amount=0;
		$t_amount=0;
		$g_total=0;
		$g_tax = 0; ?>
		<header>
			<h1><?php echo $temp_copies[$i]->iutc_copies; ?></h1>
			<?php
				echo '<p style="width: 100%;text-align:center;"><img src="'.$s_logo.'" style="width: auto; height: 110px;background-size: cover;background-size: 100%;"><p>';
			?>
		</header>
		<article>
			<address style="font-weight: normal;font-size: 12px;">
			<?php
				echo '<p>To ,</p><br>';
				echo '<p>'.$basic[0]->ic_name.'</p>';
				for($j=0;$j < count($property); $j++){
					echo '<p>'.$property[$j]->iexteprpt_property_value.'</p>';
				}
			?>
			</address>
			<table class="meta">
				<tr>
					<th><span>Invoice</span></th>
					<td><span><?php echo $s_txn_id; ?></span></td>
				</tr>
				<tr>
					<th><span>Date</span></th>
					<td><span><?php echo $s_txn_date; ?></span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span>Item</span></th>
						<th><span>Rate</span></th>
						<th><span>Quantity</span></th>
						<th><span>Tax</span></th>
						<th><span>Discount</span></th>
						<th><span>Price</span></th>
					</tr>
				</thead>
				<tbody>
				<?php	
					for($k=0;$k< count($details);$k++){
						$n = $k + 1;
						echo '<tr><td><span>';
						if ($details[$k]->iexteppd_alias == 'true' ) {
							echo $details[$k]->ipp_alias;
						}else{
							echo $details[$k]->ip_product;
						}
						echo '</span></td><td style="text-align: center;"><span>'.$details[$k]->iexteppd_rate.'</span></td><td style="text-align: center;"><span>'.$details[$k]->iexteppd_qty.'</span></td><td style="text-align: center;"><span>'.$details[$k]->ittxg_group_name.'</span></td>';
						$disc = 0;
						if($details[$k]->iexteppd_discount != ''){
							echo '<td style="text-align: center;"><span>'.$details[$k]->iexteppd_discount.'</span></td>';
							$disc = $details[$k]->iexteppd_discount;
						}else{
							echo '<td style="text-align: center;"><span>-</span></td>';
						}
						$tax = 0;
						for($m=0; $m < count($taxes); $m++){
							if($taxes[$m]->itxgc_tg_id == $details[$k]->iexteppd_tax){
								$tax = $tax + $taxes[$m]->itx_percent;
							}
						}
						$disc_amt =($details[$k]->iexteppd_rate * $details[$k]->iexteppd_qty) * ($disc / 100);
						$amount = $details[$k]->iexteppd_rate * $details[$k]->iexteppd_qty - $disc_amt;
						$g_amount = $g_amount + $amount;
						$tax_amt = $amount * ($tax/100) ;
						$g_tax = $g_tax + $tax_amt; 
						$t_amount = $amount + $tax_amt;
						$g_total = $g_total + $t_amount;
						echo '<td style="text-align: right;"><span>'.$t_amount.'</span></td>';
						echo '</tr>';
					}
				?>	
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span>Products Total Amount</span></th>
					<td><span><?php echo $g_amount; ?></span></td>
				</tr>
				<tr>
					<th><span>Tax Total Amount</span></th>
					<td><span><?php echo $g_tax; ?></span></td>
				</tr>
				<tr>
					<th><span>Grand Total Amount</span></th>
					<td><span><?php echo $g_total; ?></span></td>
				</tr>
			</table>
		</article>
		<?php 
			if($note != ''){
				echo '<aside><h1><span>Additional Notes</span></h1><hr><div><p>'.$note.'</p></div></aside>';
			}
		 ?>
	</body>
<?php
	if(count($temp_copies) - 1 != $i){
		echo '<div style="page-break-after:always"></div>';
	}
 } 
 ?>	
</html>