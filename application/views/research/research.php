<style>
	.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.active, .accordion:hover {
    background-color: #ccc;
    border-radius: 10px;
}

.panel {
    /*padding: 0 18px;*/
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
        <button class="accordion btn-lg" style="font-size: 1.8em; text-align: left;"><i class="material-icons">filter_list</i> Filter Records</button>
        <div class="panel">
        	<div class="mdl-grid">
        		<div class="mdl-cell mdl-cell--2-col">
        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					    <input class="mdl-textfield__input" type="Date" id="fr_date" name="from">
					    <label class="mdl-textfield__label" for="fr_date">From Date</label>
					</div>
        		</div>
        		<div class="mdl-cell mdl-cell--2-col">
        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					    <input class="mdl-textfield__input" type="Date" id="to_date" name="to">
						<label class="mdl-textfield__label" for="to_date">To Date</label>
					</div>
        		</div>
        		<div class="mdl-cell mdl-cell--2-col">
        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
					    <input class="mdl-textfield__input" type="text" id="min_amount">
					    <label class="mdl-textfield__label" for="min_amount">Minimum Amount</label>
					</div>
        		</div>
        		<div class="mdl-cell mdl-cell--2-col">
        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					    <input class="mdl-textfield__input" type="text" id="max_amount">
						<label class="mdl-textfield__label" for="max_amount">Maximum Amount</label>
					</div>
        		</div>
        		<div class="mdl-cell mdl-cell--2-col">
        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	        			<label class="mdl-textfield__label" for="p_in_status">Purchase Status</label>
	        			<select class="mdl-textfield__input" id="p_in_status">
							
						</select>
					</div>
        		</div>
        		<div class="mdl-cell mdl-cell--2-col">
        			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="check"><i class="material-icons">search</i> Filter</button>
        		</div>
        	</div>
		</div>
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
			<thead>
				<tr>
					<th class="mdl-data-table__cell--non-numeric">Title</th>
				</tr>
			</thead>
			<tbody>
				<?php
					for ($i=0; $i < count($research) ; $i++) { 
							echo '<tr style="font-weight: bold;" class="tbl_view" id="'.$research[$i]->iextre_id.'">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$research[$i]->iextre_title.'</td>';
							echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
		<i class="material-icons">add</i>
	</button>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
	    $( "#fr_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	    $( "#to_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	
		$('#add').click(function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Research/research_add/'; ?>";
		});

		$('table').on('click', '.tbl_view', function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Research/research_edit/'; ?>" + $(this).prop('id');
		})

		var acc = document.getElementsByClassName("accordion");
		var i;

		for (i = 0; i < acc.length; i++) {
			acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			    if (panel.style.maxHeight){
			      panel.style.maxHeight = null;
			    } else {
			      panel.style.maxHeight = panel.scrollHeight + "px";
			    } 
			});
		}
		
		$('#check').click(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/invoice_filter/"; ?>', {
				'from' : $('#fr_date').val(),
				'to': $('#to_date').val(),
				'min_amount' : $('#min_amount').val(),
				'max_amount' : $('#max_amount').val(),
				'in_status'	 : $('#in_status').val()
			}, function(data, status, xhr) {
			 	var abc = JSON.parse(data);
			 	console.log(abc);
				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.filter.length; i++) {
					if(abc.filter[i].iextein_status == "paid") {
						out+='<tr style="color: #009933;font-weight: bold;" class="tbl_view" id="' + abc.filter[i].iextein_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextein_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextein_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
						out+='<td class="">' + abc.filter[i].iextein_amount + '</td>';
						out+='</tr>';
					} else {
						out+='<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="' + abc.filter[i].iextein_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextein_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextein_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
						out+='<td class="">' + abc.filter[i].iextein_amount + '</td>';
						out+='</tr>';
					}
				}
				$('#details').append(out);
			})
		});
});



</script>
</html>