<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- <div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Enterprise/inventory_add/inward/'.$mod_id; ?>">
				<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Inward</button>
			</a>
		</div>
		 -->
	</div>
    	<div class="mdl-grid" id="search_block" style="height:0px; background-color: #4e4e4e; color: #fff; padding: 0px 20px 0px 20px; border-radius: 5px; margin: 12px;display:none;"> <div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input type="text" data-type="date" id="i_txn_start_date" class="mdl-textfield__input" value="<?php if(isset($edit_amc)) { echo $edit_amc[0]->iextamc_period_from; } ?>">
				<label class="mdl-textfield__label" for="i_txn_start_date" style="color: #fff;">Period From</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input type="text" data-type="date" id="i_txn_end_date" class="mdl-textfield__input" value="<?php if(isset($edit_amc)) { echo $edit_amc[0]->iextamc_period_to; } ?>">
				<label class="mdl-textfield__label" for="i_txn_end_date" style="color: #fff;">Period To</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--3-col">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input type="text" id="i_txn_company" class="mdl-textfield__input" value="<?php if(isset($edit_amc)) { echo $edit_amc[0]->iextamc_period_to; } ?>">
				<label class="mdl-textfield__label" for="i_txn_company" style="color: #fff;">Contact Name</label>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--1-col" style="padding-top: 15px;">		
			<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;" id="search"><i class="material-icons">search</i></button>
		</div>
	</div>
	
	<div class="mdl-grid">
	    <div class="mdl-cell mdl-cell--4-col">
            <div class="mdl-card mdl-shadow--4dp">
                <h1>GST Collected</h1>
            </div>
	    </div>
	</div>
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
			<thead>
				<tr>
					<th class="mdl-data-table__cell--non-numeric">Type</th>
					<th class="mdl-data-table__cell--non-numeric">Ledger</th>
					<th class="mdl-data-table__cell--non-numeric">Txn Number</th>
					<th class="mdl-data-table__cell--non-numeric">Date</th>
					<th class="mdl-data-table__cell--non-numeric">Credit</th>
					<th class="mdl-data-table__cell--non-numeric">Debit</th>
				</tr>
			</thead>
			<tbody id="details">
				<?php
					for ($i=0; $i < count($accounts) ; $i++) { 
						if ($accounts[$i]->method == "credit") {
							echo '<tr style="font-weight: bold; color:#009900;" class="tbl_view_inward" id="'.$i.'">';
						} else {
							echo '<tr style="font-weight: bold; color:#ff6600;" class="tbl_view_inward" id="'.$i.'">';
						}
						
						echo '<td class="mdl-data-table__cell--non-numeric">'.$accounts[$i]->type.'</td>';
						echo '<td class="mdl-data-table__cell--non-numeric">'.$accounts[$i]->name.'</td>';
						echo '<td class="mdl-data-table__cell--non-numeric">'.$accounts[$i]->txn.'</td>';
						echo '<td class="mdl-data-table__cell--non-numeric">'.$accounts[$i]->txn_date.'</td>';
						echo '<td class="mdl-data-table__cell--non-numeric">'.$accounts[$i]->credit.'</td>';
						echo '<td class="mdl-data-table__cell--non-numeric">'.$accounts[$i]->debit.'</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
	
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$('#i_txn_start_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    	$('#i_txn_end_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		$('#details').on('click', '.tbl_view_inward', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');
			// window.location = "<?php #echo base_url().'Enterprise/inventory_edit/inward/'.$mod_id.'/'; ?>" + tid;
		}));

		$('#details').on('click', '.tbl_view_outward', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');
			// window.location = "<?php #echo base_url().'Enterprise/inventory_edit/outward/'.$mod_id.'/'; ?>" + tid;
		}));

		$('#fixed-header-drawer-exp').click(function(e) {
			e.preventDefault();

			$('#search_block').css('display','flex');
			$('#search_block').animate({height: '75px'});
			
		});

		$('#search').click(function(e) {
			$.post('<?php echo base_url()."Enterprise/account_search/"; ?>', {
				'search' : $('#i_txn_company').val(),
				'from' : $('#i_txn_start_date').val(),
				'to' : $('#i_txn_end_date').val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.length; i++) {
					if (abc[i].method == "credit") {
						out+= '<tr style="font-weight: bold;color:#009900;" class="tbl_view_inward" id="' + i + '">';	
					} else {
						out+= '<tr style="font-weight: bold; color:#ff6600" class="tbl_view_inward" id="' + i + '">';
					}
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].type + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].name + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].txn + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].txn_date + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].credit + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].debit + '</td>';
					out+= '</tr>';
				}
				$('#details').append(out);
			})	
		})
		
	})
</script>
</html>