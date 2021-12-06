<style>
.general_table {
	width: 100%;
    text-align: left;
    font-size: 1em;
    border: 1px solid #ccc;
    border-collapse: collapse;
    border-radius: 10px;
}

@media only screen and (max-width: 760px) {
	.general_table {
		display: block;
    	overflow: auto;
	}
}

.general_table > thead > tr {
	border: 1px solid #ccc;
}

.general_table > thead > tr > th {
	padding: 10px;
}

.general_table > tbody {
	border: 1px solid #ccc;
}
.general_table > tbody > tr {
	border-bottom: 1px solid #ccc;
}

.general_table > tbody > tr > td {
	padding: 15px;
}

.general_table > tfoot > tr {
	border: 1px solid #ccc;
}

.general_table > tfoot > tr > td {
	padding: 10px;
}

.ui-widget-content{
	z-index: 1111 !important;
}

.panel {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}

.loader {
	position: fixed;
    border: 5px solid #f3f3f3;
	-webkit-animation: spin 2s linear infinite; /* Safari */
	animation: spin 1s linear infinite;
	border-top: 5px solid #555;
	border-radius: 50%;
	width: 50px;
	height: 50px;
	left: 47%;
	top: 50%;
	z-index: 1111111 !important;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col" style="width: 100%;overflow: auto;">
			<table class="general_table" style="width: 100%;">
				<thead>
					<tr>
						<th>Transaction No.</th>
						<th>Date</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
					if (isset($amc)) {
						for ($i=0; $i < count($amc) ; $i++) {
							echo '<tr style="font-weight: bold;" class="tbl_view" id="'.$amc[$i]->iextamc_id.'">';
							echo '<td>'.$amc[$i]->iextamc_txn_id.'</td>';
							echo '<td>'.$amc[$i]->iextamc_created.'</td>';
							if ($amc[$i]->iextamc_status == 'cb_client') {
								echo '<td>Confirm by you</td>';
							}else{
								echo '<td>'.$amc[$i]->iextamc_status.'</td>';
							}
							echo '</tr>';
						}	
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</main>
</div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		$('.tbl_view').click(function (e) {
			e.preventDefault();
			var sid = $(this).prop('id');
			window.location = '<?php echo base_url()."Mobile_app/cosmos_subscription_details/".$code."/" ;?>'+sid;
		});
	});
</script>