<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Txn No</th>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
						<th class="mdl-data-table__cell--non-numeric" colspan="2">Action</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
					if (isset($boq_list)) {
						for ($i=0; $i < count($boq_list) ; $i++) { 
							echo '<tr style="font-weight: bold;">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$boq_list[$i]->iextetboq_id.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$boq_list[$i]->iextetboq_title.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.date( 'Y-m-d' ,strtotime($boq_list[$i]->iextetboq_created)).'</td>';
							$flg = 0;
							if (isset($boq_count)) {
								for ($ij=0; $ij < count($boq_count) ; $ij++) { 
									if ($boq_list[$i]->iextetboq_id == $boq_count[$ij]->iextetboqm_boq_id) {
										$flg++;
									}
								}
							}
							echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--colored res_view" id="'.$boq_list[$i]->iextetboq_id.'"> No of response '.$flg.'</button></td>';
							echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--colored tbl_view" id="'.$boq_list[$i]->iextetboq_id.'"><i class="material-icons">edit</i> Edit</button></td>';
							echo '</tr>';
						}
					}
					?>
				</tbody>
			</table>
		</div>
        <button class="lower-button mdl-button mdl-button--fab mdl-button--colored add_boq"><i class="material-icons">add</i></button>
    </div>
</main>
<script type="text/javascript">
	$(document).ready( function() {

		$('.tbl_view').click(function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	window.location = '<?php echo base_url()."BOQ/add_boq/".$code.'/'; ?>'+id;
        });

        $('.res_view').click(function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	window.location = '<?php echo base_url()."BOQ/boq_res_view/".$code.'/'; ?>'+id;
        });

  		$('.add_boq').click(function (e) {
        	e.preventDefault();
			window.location = '<?php echo base_url()."BOQ/add_boq/".$code; ?>';
        });

	});
</script>