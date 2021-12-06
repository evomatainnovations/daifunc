<style>

    #expense_table {
        width:100%;
    }
    @media only screen and (max-width: 768px) {

        #expense_table {
            overflow: auto;
            display: block;
        }
    }
</style>

<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Add Expense</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label>Type Expense Categories</label>
						<ul id="categories" class="mdl-textfield__input">
						</ul>
					</div>
					<div class="mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input" class="mdl-textfield__input" value="<?php if(isset($edit_lecture)) { echo $edit_lecture[0]->iextls_from_date; } ?>">
							<label class="mdl-textfield__label" for="date-input">Select Date</label>
						</div>
					</div>
					
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="details" name="details" class="mdl-textfield__input" value="<?php if(isset($edit_function)) { echo $edit_function[0]->ifun_name; } ?>">
						<label class="mdl-textfield__label" for="details">Enter Details of Expenditure</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="amount" name="amount" class="mdl-textfield__input" value="<?php if(isset($edit_function)) { echo $edit_function[0]->ifun_name; } ?>">
						<label class="mdl-textfield__label" for="amount">Enter Amount</label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" id="expense_table">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Details</th>
						<th class="mdl-data-table__cell--non-numeric">Amount</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
						<th class="mdl-data-table__cell--non-numeric">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($expense) ; $i++) { 
							echo '<tr id="'.$expense[$i]->iexte_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric" style="white-space:normal">'.$expense[$i]->iexte_details.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$expense[$i]->iexte_amount.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$expense[$i]->iexte_date.'</td>';
							echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent trash" id="'.$expense[$i]->iexte_id.'" ><i class="material-icons">delete</i></button></td>';
							echo "</tr>";
						}
					?>
				</tbody>
			</table>

		</div>
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	
    	<?php
    		for ($i=0; $i < count($tags) ; $i++) { 
    			echo "tag_data.push('".$tags[$i]->it_value."');";
    		}
    	?>
    	
    	$('#categories').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});
    });
</script>

<script>
	$(document).ready(function() {

		$('#date-input').bootstrapMaterialDatePicker({ weekStart : 0, time: false, format : 'YYYY-MM-DD' });
		var dt = new Date()
		var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
		$('#date-input').val(s_dt);

		$('.trash').click(function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			window.location = "<?php echo base_url().'Education/delete_expenses/'; ?>"+ cid;
		});

		$('#submit').click(function(e) {
			e.preventDefault();

			var tag_info = [];
			$('#categories > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					tag_info.push(tmpstr);
				}
			});
			
			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_system_function/'.$did; } { echo base_url().'Education/save_expenses'; } ?>", {
				'categories' : tag_info,
				'date' : $('#date-input').val(),
				'details' : $('#details').val(),
				'amt' : $('#amount').val()
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Education/expenses'; ?>"
			}, "text");
		});
	});
</script>

</html>