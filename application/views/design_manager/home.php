<style type="text/css">
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
		background-color: #666;
		color: #fff;
	}

	.general_table > tbody {
		border: 1px solid #ccc;
	}
	.general_table > tbody > tr {
		/*border-bottom: 1px solid #ccc;*/
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
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<button class="mdl-button mdl-button--colore add_design_manager"><i class="material-icons">add</i> Add design</button>
			<button class="mdl-button mdl-button--colore add_dm_template"><i class="material-icons">add</i> Add template</button>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Txn No</th>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="">Date</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
						for ($i=0; $i < count($dm_list) ; $i++) { 
							echo '<tr style="font-weight: bold;" class="tbl_view" id="'.$dm_list[$i]->iextetdm_id.'">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$dm_list[$i]->iextetdm_id.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$dm_list[$i]->iextetdm_title.'</td>';
							echo '<td class="">'.date( 'Y-m-d' ,strtotime($dm_list[$i]->iextetdm_created)).'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
    </div>
</main>
<script type="text/javascript">
	$(document).ready( function() {

		$('.tbl_view').click(function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	window.location = '<?php echo base_url()."Design_manager/add_design_manager/".$code.'/'; ?>'+id;
        });

		$('.add_dm_template').click(function (e) {
        	e.preventDefault();
        	window.location = '<?php echo base_url()."Design_manager/add_dm_template/".$code.'/'; ?>';
        });

  		$('.add_design_manager').click(function (e) {
        	e.preventDefault();
			window.location = '<?php echo base_url()."Design_manager/add_design_manager/".$code; ?>';
        });

	});
</script>