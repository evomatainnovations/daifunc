<style type="text/css">
	.g_table {
		width: 100%;
        text-align: left;
        font-size: 1em;
        border: 1px solid #ccc;
        border-collapse: collapse;
        border-radius: 10px;
    }

	@media only screen and (max-width: 760px) {
		.g_table {
			display: block;
        	overflow: auto;
		}
	}

	.g_table > thead > tr {
		border: 1px solid #ccc;
	}

	.g_table > thead > tr > th {
		padding: 10px;
	}

	.g_table > tbody {
		border: 1px solid #ccc;
	}

	.g_table > tbody > tr > td {
		padding: 15px;
		table-layout: fixed;
	}
</style>
<div class="modal fade" id="modial_payment" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add payment details</h3>
			</div>
			<div class="modal-body">
				<div class="mdl-grid">
					<?php if (isset($bal_amount)) { 
						echo '<div class="mdl-cell mdl-cell--12-col"><h4 id="bal_amt">Balance amount '.$bal_amount.' /-</h4></div>';
					} ?>
					<div class="mdl-cell mdl-cell--6-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="pay_mod">
							<label class="mdl-textfield__label" for="pay_mod">Enter payment mode</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--6-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" data-type="date" id="pay_date">
							<label class="mdl-textfield__label" for="pay_date">Select payment date</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--6-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="pay_amt" pattern="-?[0-9]*(\.[0-9]+)?">
							<label class="mdl-textfield__label" for="pay_amt">Enter payment amount</label>
							<span class="mdl-textfield__error">Input is not a number!</span>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--6-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="pay_vno">
							<label class="mdl-textfield__label" for="pay_vno">Enter vouchar number</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"  style="width: 100%;">
							<input class="mdl-textfield__input" type="text" id="pay_desc">
							<label class="mdl-textfield__label" for="pay_desc">Enter payment description</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<button class="mdl-button mdl-button--colored mdl-button--raised pay_save" style="width: 100%;"><i class="material-icons">save</i> Save</button>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="panel-group" id="accordion">
				            <div class="panel panel-default">
				                <div class="panel-heading">
				                    <h4 class="panel-title">
				                        <a data-toggle="collapse" data-parent="#accordion" href="#likehood">History</a>
				                    </h4>
				                </div>
				                <div id="likehood" class="panel-collapse collapse">
				                    <div class="panel-body">
			                    		<?php
			                    			if (isset($history)) {
			                    				if (count($history) > 0) {
			                    					echo '<table id="payment_history" class="g_table"><thead><th>Vouchar No.</th><th>Amount</th><th>Description</th><th></th><th></th></thead><tbody>';
			                    					for ($i=0; $i <count($history) ; $i++) { 
			                    						echo '<tr><td>'.$history[$i]->iextepay_vno.'</td><td>'.$history[$i]->iextepay_amount.'</td><td style="word-break: break-all;">'.$history[$i]->iextepay_desc.'</td><td><button class="mdl-button mdl-button--icon pay_delete" id="'.$history[$i]->iextepay_id.'"><i class="material-icons">delete</i></button></td><td><button class="mdl-button mdl-button--icon pay_edit" id="'.$history[$i]->iextepay_id.'"><i class="material-icons">edit</i></button></td></tr>';
			                    					}
			                    					echo '</tbody></table>';
			                    				}else{
			                    					echo "<h4>No records found !</h4>";
			                    				}
			                    			}
			                    		?>
				                    </div>
				                </div>
				            </div>
				        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>