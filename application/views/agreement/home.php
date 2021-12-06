<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;">
				<thead>
					<tr>
						<!-- <th class="mdl-data-table__cell--non-numeric">Txn No</th>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="">Date</th> -->
					</tr>
				</thead>
				<tbody id="details">
					<?php
					// if (isset($boq_list)) {
					// 	for ($i=0; $i < count($boq_list) ; $i++) { 
					// 		echo '<tr style="font-weight: bold;" class="tbl_view" id="'.$boq_list[$i]->iextetboq_id.'">';
					// 		echo '<td class="mdl-data-table__cell--non-numeric">'.$boq_list[$i]->iextetboq_id.'</td>';
					// 		echo '<td class="mdl-data-table__cell--non-numeric">'.$boq_list[$i]->iextetboq_title.'</td>';
					// 		echo '<td class="">'.date( 'Y-m-d' ,strtotime($boq_list[$i]->iextetboq_created)).'</td>';
					// 		echo '</tr>';
					// 	}
					// }
					?>
				</tbody>
			</table>
		</div>
        <button class="lower-button mdl-button mdl-button--fab mdl-button--colored add_agree"><i class="material-icons">add</i></button>
    </div>
</main>
<script type="text/javascript">
	$(document).ready( function() {

		// $('.tbl_view').click(function (e) {
  //       	e.preventDefault();
  //       	var id = $(this).prop('id');
  //       	window.location = '<?php //echo base_url()."BOQ/add_boq/".$code.'/'; ?>'+id;
  //       });

  		$('.add_agree').click(function (e) {
        	e.preventDefault();
			window.location = '<?php echo base_url()."Agreement/add_agreement/".$code; ?>';
        });

	});
</script>