<main class="mdl-layout__content">
	<div class="mdl-grid">
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
						for ($i=0; $i < count($req_list) ; $i++) { 
							echo '<tr style="font-weight: bold;" class="tbl_view" id="'.$req_list[$i]->iextetr_id.'">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$req_list[$i]->iextetr_id.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$req_list[$i]->iextetr_title.'</td>';
							echo '<td class="">'.date( 'Y-m-d' ,strtotime($req_list[$i]->iextetr_created)).'</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
        <button class="lower-button mdl-button mdl-button--fab mdl-button--colored add_req"><i class="material-icons">add</i></button>
    </div>
</main>
<script type="text/javascript">
	$(document).ready( function() {

		$('.tbl_view').click(function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	window.location = '<?php echo base_url()."Requirement/add_req/".$code.'/'; ?>'+id;
        });

  		$('.add_req').click(function (e) {
        	e.preventDefault();
			window.location = '<?php echo base_url()."Requirement/add_req/".$code; ?>';
        });

	});
</script>