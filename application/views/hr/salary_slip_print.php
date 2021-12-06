<style type="text/css">
	body{
		text-align: center;
	}
	.general_table > tbody > tr > td {
		padding: 10px;
	}
</style>
<html>
<body>
	<div class="mdl-grid" style="border: 1px solid #000;">
		<div style="display: flex;">
			<div style="text-align: left;padding: 10px;width: 100%;">
				<div style="text-align: center;">
					<h2>Salary slip</h2>
				</div>
			</div>
			<div style="text-align: left;padding-left: 10px;width: 100%;">
				<table>
					<tbody>
						<tr><td>Employee Name</td><td> : </td><td><?php echo $emp_list[0]->ic_name; ?></td></tr>
						<?php
							if ($emp_list[0]->iextethd_dept_name != '' ) {
								echo "<tr><td>Department</td><td> : </td><td>".$emp_list[0]->iextethd_dept_name."</td></tr>";
							}
						?>
						<tr><td>Month</td><td> : </td><td><?php echo $month; ?></td></tr>
					</tbody>
				</table>
			</div>
		</div>
		<hr>
		<?php
			for ($i = 0; $i < count($emp_list); $i++) {
				$flg_count = 0;
				$t_flg = count($date_list);
				$p_flg = 0;
				$a_flg = 0;
				$in_time = 0;
				for ($ij = 0; $ij < count($shift_list); $ij++) {
					if ($emp_list[$i]->iexteth_shift_id == $shift_list[$ij]['iexteths_id']) {
						$in_time = $shift_list[$ij]['iexteths_in_time'];
					}
				}
				$lt_mark = 0;

				for ($ik = 0; $ik < count($date_list); $ik++) {
					$dt1 = 0;$dt2 = 0;
					for ($m = 0; $m < count($emp_attend); $m++) {
						if($emp_attend[$m]['ica_date'] == $date_list[$ik] && $emp_attend[$m]['ica_card_id'] == $emp_list[$i]->ic_card_id){
							$flg_count++;
							if ($dt1 == 0) {
								$dt1 = $emp_attend[$m]['time'];
								if ($dt1 > $in_time) {
									$lt_mark++;
								}
							}else{
								$dt2 = $emp_attend[$m]['time'];
							}
						}
					}
					if ($dt1 == 0) {
						$a_flg++;
					}else{
						$p_flg++;
					}
				}
				$sal_per_day = $emp_list[$i]->iexteth_salary / $t_flg;
				$t_sal = $sal_per_day * $p_flg;
				$t_sal = $t_sal - ( $lt_mark * $in_time_exeed_deduct );
				if ($absent_exeed < $a_flg) {
					$t_sal = $t_sal - $absent_exeed_deduct;
				}
			}
		?>
		<div class="mdl-cell mdl-cell--12-col" style="width: 100%;">
			<table class="general_table" style="width: 100%;">
				<tbody>
					<tr><td>Per day salary</td><td style="text-align: right;"><?php echo number_format((float)$sal_per_day, 2, '.', ''); ?></td></tr>
					<tr><td>Present days</td><td  style="text-align: right;"><?php echo $p_flg; ?></td></tr>
					<tr><td>Absent days</td><td  style="text-align: right;"><?php echo $a_flg; ?></td></tr>
					<tr><td>Late mark</td><td style="text-align: right;"><?php echo $lt_mark; ?></td></tr>
					<tr><td style="border-top:1px solid #000;">Total</td><td style="border-top:1px solid #000;text-align: right;"><?php echo number_format((float)$t_sal, 2, '.', ''); ?></td></tr>
				</tbody>
			</table>
		</div>
	</div>
	<div style="page-break-after:always"></div>
</body>
</html>