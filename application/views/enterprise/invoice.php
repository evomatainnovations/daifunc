<style>
.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.active, .accordion:hover {
    box-shadow: 0px 5px 0px #ccc;
    border-radius: 10px;
}

.panel {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--11-col">
			<button class="accordion btn-lg" style="font-size: 1.5em; text-align: left;box-shadow: 0px 5px 0px #ccc;border-radius: 10px;padding-top: 0px;"><i class="material-icons">filter_list</i> Filter Records</button>
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
	                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
	                        <input class="mdl-textfield__input" type="text" id="in_created">
	                        <label class="mdl-textfield__label" for="in_created">Created By</label>
	                    </div>
	                </div>
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
		        			<label class="mdl-textfield__label" for="in_status">Invoice Status</label>
		        			<select class="mdl-textfield__input" id="in_status">
								<?php for($i=0; $i < count($status); $i++) {
					            	echo '<option value="'.$status[$i]->iextein_status.'">'.$status[$i]->iextein_status.'</option>';
					        	} ?>
							</select>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
	        			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="check"><i class="material-icons">search</i> Filter</button>
	        		</div>
	        	</div>
			</div>	
		</div>
		<div class="mdl-cell mdl-cell--1-col" style="text-align: center;">
			<button class="mdl-button" style="border-radius: 50px 50px;padding-top: 0px;" id="invoice_setting"><i class="material-icons" style="font-size: 2.5em;">settings</i></button>
		</div>
		<div class="mdl-cell mdl-cell--12-col scroll-auto" style="overflow: auto;">
			<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Txn No</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
						<th class="mdl-data-table__cell--non-numeric">Customer</th>
						<th class="">Amount</th>
					</tr>
				</thead>
				<tbody id="details">
					<?php
						for ($i=0; $i < count($invoice) ; $i++) { 
							if($invoice[$i]->iextein_status == "paid") {
								echo '<tr style="color: #009933;font-weight: bold;" class="tbl_view" id="'.$invoice[$i]->iextein_id.'">';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextein_txn_id.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextein_txn_date.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->ic_name.'</td>';
								echo '<td class="">'.$invoice[$i]->iextein_amount.'</td>';
								echo '</tr>';
							} else {
								echo '<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="'.$invoice[$i]->iextein_id.'">';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextein_txn_id.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextein_txn_date.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->ic_name.'</td>';
								echo '<td class="">'.$invoice[$i]->iextein_amount.'</td>';
								echo '</tr>';
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Enterprise/document_terms/Invoice/'.$code; ?>"><button class="mdl-button mdl-js-button mdl-button--raised" style="width: 100%;">Terms</button></a>
		</div>
		<div class="mdl-cell mdl-cell--4-col"></div>
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
			window.location = "<?php echo base_url().'Enterprise/invoice_add/'.$mod_id.'/'.$code; ?>";
		});

		$('#details').on('click', '.tbl_view', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');
			window.location = "<?php echo base_url().'Enterprise/invoice_add/'.$mod_id.'/'.$code.'/' ?>"+tid;

		}));

		$('#invoice_setting').click(function (e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Enterprise/module_setting/Invoice/'.$code; ?>";
		});

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/invoice_search/".$code; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.invoice.length; i++) {
					if(abc.invoice[i].iextein_status == "paid") {
						out+='<tr style="color: #009933;font-weight: bold;" class="tbl_view" id="' + abc.invoice[i].iextein_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].ic_name + '</td>';
						out+='<td class="">' + abc.invoice[i].iextein_amount + '</td>';
						out+='</tr>';
					} else {
						out+='<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="' + abc.invoice[i].iextein_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].iextein_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.invoice[i].ic_name + '</td>';
						out+='<td class="">' + abc.invoice[i].iextein_amount + '</td>';
						out+='</tr>';
					}
				}
				$('#details').append(out);
			})
		});

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
			$.post('<?php echo base_url()."Enterprise/invoice_filter/".$code; ?>', {
				'from' : $('#fr_date').val(),
				'to': $('#to_date').val(),
				'min_amount' : $('#min_amount').val(),
				'max_amount' : $('#max_amount').val(),
				'in_status'	 : $('#in_status').val(),
				'in_created' : $('#in_created').val()
			}, function(data, status, xhr) {
			 	var abc = JSON.parse(data);
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