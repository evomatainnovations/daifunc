<!DOCTYPE html>
<html>
<body>
	<div style="display: flex;">
		<?php
			echo '<table style="display: inline-block;width: 50%;"><tr><td>Client </td></tr>';
			echo '<tr><td>'.$c_name.'</td></tr>';
			for($j=0;$j < count($property); $j++){
				echo '<tr><td>'.$property[$j]->iexteld_d_val.'</td></tr>';
			}
			echo '<tr><td>'.$txn_id.'</td></tr>';
			echo '<tr><td>'.$date.'</td></tr>';
			echo '</table>';
			echo '<table style="display: inline-block;width: 50%;text-align: center;"><tr><td><img src="'.$logo.'" style="width: auto; height: 110px;background-size: cover;"></td></tr>';
			echo '</table>';
		?> 
		<div style="width: 100%;margin-top: 8%;text-align: center;font-weight: bold;">
			<?php
				if (isset($subject)) {
					echo "<u>Subject : ".$subject.'</u>';
				}
			?>
		</div>
		<div style="width: 100%;">
			<?php
				if (isset($content)) {
					echo '<div style="margin-top:3%;">'.$content.'</div>';
				}
			?>
		</div>
	</div>
</body>
</html>