<style>
.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    /*padding: 18px;*/
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.active, .accordion:hover {
     /*background-color: #ccc;*/
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
						    <input class="mdl-textfield__input" type="Date" id="p_fr_date" name="from">
						    <label class="mdl-textfield__label" for="p_fr_date">From Date</label>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="Date" id="p_to_date" name="to">
						    <label class="mdl-textfield__label" for="p_to_date">To Date</label>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="text" id="p_min_amount">
						    <label class="mdl-textfield__label" for="p_min_amount">Minimum Amount</label>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="text" id="p_max_amount">
						    <label class="mdl-textfield__label" for="p_max_amount">Maximum Amount</label>
						</div>
	        		</div>
	        		<div class="mdl-cell mdl-cell--2-col">
	        			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
		        			<label class="mdl-textfield__label" for="p_in_status">Purchase Status</label>
		        			<select class="mdl-textfield__input" id="p_in_status">
								<?php for($i=0; $i < count($status); $i++) {
					            	echo '<option value="'.$status[$i]->iextep_status.'">'.$status[$i]->iextep_status.'</option>';
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
		<div class="mdl-cell mdl-cell--1-col" style="text-align: right;">
			<button class="mdl-button" style="border-radius: 50px 50px;padding-top: 0px;" id="invoice_setting"><i class="material-icons" style="font-size: 2.5em;">settings</i></button>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;font-size: 1em;">
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
							if($invoice[$i]->iextep_status == "paid") {
								echo '<tr style="color: #009933;font-weight: bold;" class="tbl_view" id="'.$invoice[$i]->iextep_id.'">';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextep_txn_id.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextep_txn_date.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->ic_name.'</td>';
								echo '<td class="">'.$invoice[$i]->iextep_amount.'</td>';
								echo '</tr>';
							} else {
								echo '<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="'.$invoice[$i]->iextep_id.'">';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextep_txn_id.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->iextep_txn_date.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$invoice[$i]->ic_name.'</td>';
								echo '<td class="">'.$invoice[$i]->iextep_amount.'</td>';
								echo '</tr>';
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
		<i class="material-icons">add</i>
	</button>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$( "#p_fr_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	    $( "#p_to_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		$('#add').click(function(e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Enterprise/purchase_add/'.$code.'/'.$mod_id; ?>";
		});

		$('#details').on('click', '.tbl_view', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');
			window.location = "<?php echo base_url().'Enterprise/purchase_add/'.$code.'/'.$mod_id.'/' ?>"+tid;

		}));

		$('#invoice_setting').click(function (e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Enterprise/module_setting/Purchase/'.$code; ?>";
		});

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Enterprise/purchase_search/".$code; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.purchase.length; i++) {
					if(abc.purchase[i].iextep_status == "paid") {
						out+='<tr style="color: #009933;font-weight: bold;" class="tbl_view" id="' + abc.purchase[i].iextep_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.purchase[i].iextep_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.purchase[i].iextep_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.purchase[i].ic_name + '</td>';
						out+='<td class="">' + abc.purchase[i].iextep_amount + '</td>';
						out+='</tr>';
					} else {
						out+='<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="' + abc.purchase[i].iextep_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.purchase[i].iextep_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.purchase[i].iextep_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.purchase[i].ic_name + '</td>';
						out+='<td class="">' + abc.purchase[i].iextep_amount + '</td>';
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

		var a_flg = 'false';
        
        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

         $('#submit').click(function(e) {
            e.preventDefault();
            if($('#search_modal').css('display') != 'none'){
                var note = $('#notes_text').html();
                $('#ATags > li').each(function(index) {
                    var tmpstr = $(this).text();
                    var len = tmpstr.length - 1;
                    if(len > 0) {
                        tmpstr = tmpstr.substring(0, len);
                        activity_tags.push(tmpstr);
                    }
                });
                var date = $('.s_date').val();
                var e_date = $('.e_date').val();
                $.post('<?php echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
                    'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
                }, function(data, status, xhr) {
                        location.reload();
                }, 'text');
            }
        });

		$('#check').click(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/purchase_filter/".$code; ?>', {
				'p_from' : $('#p_fr_date').val(),
				'p_to': $('#p_to_date').val(),
				'p_min_amount' : $('#p_min_amount').val(),
				'p_max_amount' : $('#p_max_amount').val(),
				'p_in_status'	 : $('#p_in_status').val()
			}, function(data, status, xhr) {
			 	var abc = JSON.parse(data);
				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.filter.length; i++) {
					if(abc.filter[i].iextep_status == "paid") {
						out+='<tr style="color: #009933;font-weight: bold;" class="tbl_view" id="' + abc.filter[i].iextep_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextep_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextep_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
						out+='<td class="">' + abc.filter[i].iextep_amount + '</td>';
						out+='</tr>';
					} else {
						out+='<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="' + abc.filter[i].iextep_id + '">';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextep_txn_id + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextep_txn_date + '</td>';
						out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
						out+='<td class="">' + abc.filter[i].iextep_amount + '</td>';
						out+='</tr>';
					}
				}
				$('#details').append(out);
			})
		});
	});
</script>
</html>