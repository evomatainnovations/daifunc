<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<style>
.ui-widget {
    z-index: 30000;
}

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
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}

.pic_button {
	border-radius: 10px;
	box-shadow: 0px 4px 10px #ccc;
	margin: 20px;
	position: relative;
	overflow: hidden;
}
.pic_button input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
				<div class="mdl-tabs__tab-bar">
					<a href="#Self-panel" class="mdl-tabs__tab is-active" id="self" style="color:black">Graph</a>
	                <a href="#All-panel" class="mdl-tabs__tab" id="all" style="color:black">Details</a>
	            </div>
	            <div class="mdl-tabs__panel is-active" id="Self-panel">
	            	<div class="mdl-grid">
	            		<div class="mdl-cell--12-col">
	            			<div class="mdl-grid">
	            				<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet">
		            				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input type="text" data-type="date" id="fr_date" class="mdl-textfield__input">
										<label class="mdl-textfield__label" for="fr_date">From Date</label>
									</div>
		            			</div>
		            			<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet">
		            				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input type="text" data-type="date" id="to_date" class="mdl-textfield__input">
										<label class="mdl-textfield__label" for="to_date">To Date</label>
									</div>
		            			</div>
		            			<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet">
		            				<button class="mdl-button mdl-button--raised sort_chart" style="width:100%;">Apply</button>
		            			</div>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="mdl-grid" style="text-align: center;">
	            		<div class="mdl-cell mdl-cell--4-col"></div>
	        			<div class="mdl-cell mdl-cell--4-col" id="graph-container"></div>
	        		</div>
	            </div>
	            <div class="mdl-tabs__panel" id="All-panel">
	            	<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col" style="width: 100%;overflow: auto;">
							<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
								<thead>
									<tr>
										<button class="accordion btn-lg" style="font-size: 1.5em; text-align: left;box-shadow: 0px 5px 0px #ccc;border-radius: 10px;padding-top: 0px;"><i class="material-icons">filter_list</i> Filter Records</button>
								        <div class="panel">
								        	<div class="mdl-grid">
								        		<div class="mdl-cell mdl-cell--4-col">
								        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
														<ul id="f_categories" class="mdl-textfield__input">
														</ul>
													</div>
								        		</div>
								        		<div class="mdl-cell mdl-cell--2-col">
								        			<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="filter" style="padding-top: 10px;"><i class="material-icons">search</i> Filter</button>
								        		</div>
								        	</div>
										</div>
									</tr>
									<tr>
										<th class="mdl-data-table__cell--non-numeric">Date</th>
										<th class="mdl-data-table__cell--non-numeric">Amount</th>
										<th class="mdl-data-table__cell--non-numeric">Details</th>
										<th class="mdl-data-table__cell--non-numeric">File</th>
										<?php
											if (isset($admin)) {
												if ($admin == true) {
													echo '<th class="mdl-data-table__cell--non-numeric">Action</th>';
												}
											}
										?>
									</tr>
								</thead>
								<tbody id="tdetails">
									<?php
										for ($i=0; $i < count($expense) ; $i++) { 
											echo '<tr id="'.$expense[$i]->iextete_id.'" class="click_customer">';
											echo '<td class="mdl-data-table__cell--non-numeric">'.$expense[$i]->iextete_date.'</td>';
											echo '<td class="mdl-data-table__cell--non-numeric">'.$expense[$i]->iextete_amount.'</td>';
											echo '<td class="mdl-data-table__cell--non-numeric">'.$expense[$i]->iextete_details.'</td>';
											echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--accent download" id="'.$expense[$i]->iextete_id.'">'.$expense[$i]->iextete_file.'</button></a></td>';
											if (isset($admin)) {
												if ($admin == true) {
													echo '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--colored edit" id="'.$expense[$i]->iextete_id.'" ><i class="material-icons">edit</i> edit</button>';
													echo '<button class="mdl-button mdl-button--colored trash" id="'.$expense[$i]->iextete_id.'" ><i class="material-icons">delete</i> delete</button>';
												}
											}
											echo "</td></tr>";
										}
									?>
								</tbody>
							</table>
						</div>
	            	</div>
	            </div>
	            <button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add"><i class="material-icons">add</i></button>
	        </div>
		</div>
	</div>
</main>
</body>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col list_cat">
						<h3>Type Expense Categories</h3>
						<ul id="categories" class="mdl-textfield__input">
							<?php
								if (isset($edit_expense)) {
									for ($i=0; $i <count($edit_expense) ; $i++) { 
										echo '<li>'.$edit_expense[$i]->it_value.'</li>';
									}
								}
							?>
						</ul>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<input type="text" id="details" name="details" class="mdl-textfield__input" value="<?php if(isset($edit_expense)) { echo $edit_expense[0]->iextete_details; } ?>">
							<label class="mdl-textfield__label" for="details">Enter Details of Expenditure</label>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<label class="mdl-textfield__label" for="amount">Enter Amount</label>
							<input type="text" id="amount" name="amount" pattern="-?[0-9]*(\.[0-9]+)?" class="mdl-textfield__input" value="<?php if(isset($edit_expense)) { echo $edit_expense[0]->iextete_amount; } ?>">
							<span class="mdl-textfield__error">Input is not a number!</span>
						</div>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="text-align: center;">
						<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
							<i class="material-icons">folder</i> Upload Document
							<input type="file" name="attach_file" class="upload">
						</div>
					</div>
					<div class="mdl-cell mdl-cell--6-col">
						<input type="date" class="pic_button" data-type="date" id="date-input" style="outline: none;border-width: 0px;width: 80%;text-align: center;font-size: 1.5em;">
					</div>
					<div class="mdl-cell mdl-cell--12-col">
						<button class="mdl-button mdl-button--raised mdl-button--colored" style="width: 100%;" id="submit_exp"><i class="material-icons">save</i> Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready( function() {
		var snackbarContainer = document.querySelector('#demo-toast-example');
    	var tag_data = [];
    	var labale_arr = [];
    	var data_arr = [];
    	var l_arr = [];
    	var d_arr = [];
    	var color_arr = [];
    	<?php
    		for ($i=0; $i < count($tags) ; $i++) { 
    			echo "tag_data.push('".$tags[$i]->it_value."');";
    		}

    		for ($i=0; $i <count($e_expense) ; $i++) {
				echo "labale_arr.push('".$e_expense[$i]->it_value."');";
				echo "data_arr.push('".$e_expense[$i]->amount."');";
    		}

    		if (isset($edit_expense)) {
    			echo "$('#myModal').modal('show');";
    		}
    	?>
    	display_chart();
    	
    	$('#add').click(function (e) {
			e.preventDefault();
			$('#myModal').modal('show');
		});

		$('#categories').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

    	$('#f_categories').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});

		$('#date-input').bootstrapMaterialDatePicker({ weekStart : 0, time: false, format : 'YYYY-MM-DD' });
		var dt = new Date()
		var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
		<?php
			if (isset($edit_expense)) {
				echo "$('#date-input').val('".$edit_expense[0]->iextete_date."');";
			}else{
				echo "$('#date-input').val(s_dt);";
			}
		?>

		$('.close').click(function (e) {
			e.preventDefault();
			<?php
				if (isset($edit_expense)) {
					echo "window.location = '".base_url().'Enterprise/expenses/0/'.$code."'";
				}else{
					echo "$('#myModal').modal('hide');";
				}
			?>
		});

		$('.trash').click(function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			window.location = "<?php echo base_url().'Enterprise/delete_expenses/'.$code.'/'; ?>"+ cid;
		});

		$('.edit').click(function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			window.location = "<?php echo base_url().'Enterprise/expenses/0/'.$code.'/'; ?>"+ cid;
		});

		$('#tdetails').on('click','.download',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = "<?php echo base_url().'Enterprise/download_expenses/'.$code.'/'; ?>"+ id;
		});

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/expense_search/".$code; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#tdetails').empty();
				var out = "";
				for (var i = 0; i < abc.length; i++) {
					out+= '<tr id="' + abc[i].iextete_id + '" class="click_customer">';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iextete_date +'</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iextete_amount + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iextete_details + '</td>';
					out+='<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--accent download" id="'+abc[i].iextete_id+'">' + abc[i].iextete_file + '</button></td>';
					out+= '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--colored trash" id="' + abc[i].iextete_id + '" ><i class="material-icons">delete</i></button></td>';
					out+= "</tr>";
				}
				$('#tdetails').append(out);
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
		$('#filter').click(function(e) {
			e.preventDefault();

			var tag_info = [];
			$('#f_categories > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					tag_info.push(tmpstr);
				}
			});

			$.post('<?php echo base_url()."Enterprise/expense_filter/".$code; ?>', {
				'filter' : tag_info
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				$('#tdetails').empty();
				var out = "";
				for (var i = 0; i < abc.length; i++) {
					out+= '<tr id="' + abc[i].iextete_id + '" class="click_customer">';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iextete_date +'</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iextete_amount + '</td>';
					out+= '<td class="mdl-data-table__cell--non-numeric">' + abc[i].iextete_details + '</td>';
					out+='<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--accent download" id="'+abc[i].iextete_id+'">' + abc[i].iextete_file + '</button></td>';
					out+= '<td class="mdl-data-table__cell--non-numeric"><button class="mdl-button mdl-button--colored trash" id="' + abc[i].iextete_id + '" ><i class="material-icons">delete</i></button></td>';
					out+= "</tr>";
				}
				$('#tdetails').append(out);
			})
		});

		$('#submit_exp').click(function(e) {
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
			var date_input = $('#date-input').val();
			var details = $('#details').val();
			var amount = $('#amount').val();
			var in_id ="";

			$.post('<?php if (isset($edit_expense)) { echo base_url()."Enterprise/update_expenses/".$code."/".$eid; } else {echo base_url()."Enterprise/save_expenses/".$code; } ?>',{
				'categories' : tag_info,
				'date' : date_input,
				'details' : details,
				'amt' : amount
			},function(data, status, xhr) {
				file_upload(data);
			}, 'text');
		});

		$('.sort_chart').click(function (e) {
			e.preventDefault();
			var fdate = $('#fr_date').val();
			var edate = $('#to_date').val();
			if (fdate == '' || edate == '') {
				var data = {message: 'Please select both date !'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}else{
				$.post('<?php echo base_url()."Enterprise/sort_chart/".$code;?>',{
					'fr_date' : fdate,
					'to_date' : edate
				}, function(data, status, xhr) {
					var d = JSON.parse(data);
					$('#myChart').remove();
					labale_arr = [];
					data_arr = [];
					for (var i=0; i <d.e_expense.length ; i++) {
						labale_arr.push(d.e_expense[i].it_value);
						data_arr.push(d.e_expense[i].amount);
		    		}
		    		display_chart();
				}, "text");
			}
		});

		function display_chart() {
			$('#graph-container').append('<canvas id="myChart"><canvas>');
			color_arr=[];
			for (var i = 0; i < labale_arr.length; i++) {
	    		r = Math.floor(Math.random() * 350);
				g = Math.floor(Math.random() * 350);
				b = Math.floor(Math.random() * 350);
				color = 'rgb(' + r + ', ' + g + ', ' + b + ')';
	    		color_arr.push(color);
	    	}

	    	var ctx = document.getElementById("myChart").getContext("2d");
	    	var myChart = new Chart(ctx,{
			    type: 'pie',
			    data: {
	                  labels: labale_arr,
	                  datasets: [{
	                        label: 'Expenses',
			                borderWidth: 3,
	                        data: data_arr,
	                        backgroundColor : color_arr
	                     }]
	                  }
			});
		}

	});

	function file_upload(in_id) {
		var datat = new FormData();
		if($('.upload')[0].files[0]) {
			datat.append("use", $('.upload')[0].files[0]);

			$.ajax({
				url: "<?php echo base_url().'Enterprise/expenses_upload/'.$code.'/'; ?>" + in_id, // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					window.location = '<?php echo base_url()."Enterprise/expenses/0/".$code; ?>';
				}
			});
		} else {
			window.location = '<?php echo base_url()."Enterprise/expenses/0/".$code; ?>';
		}
	}
</script>

</html>