<style>
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
	border-bottom: 1px solid #ccc;
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
@media only screen and (max-width: 760px) {
	.general_table {
		display: block;
    	overflow: auto;
	}
}
.panel {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}
.progress {
	height: 20px;
	margin: 10px;
	overflow: hidden;
	background-color: #f5f5f5;
	border-radius: 10px;
	-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
	box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<button class="mdl-button allot_work"><i class="material-icons">add</i> Allot work</button>
			<button class="mdl-button create_temp"><i class="material-icons">add</i> create template</button>
		</div>
		<table class="general_table" style="width: 100%;">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Work Name</th>
					<th>User Name</th>
					<th>Date</th>
					<th style="text-align: center;">Progress</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="details">
				<?php
					if (isset($work_allot)) {
						$sr_flg = 0;
						for ($i=0; $i < count($work_allot) ; $i++) {
							$sr_flg++;
							echo '<tr>';
							echo '<td>'.$sr_flg.'</td>';
							echo '<td>'.$work_allot[$i]->iextetwm_title.'</td>';
							echo '<td>'.$work_allot[$i]->ic_name.'</td>';
							echo '<td>'.$work_allot[$i]->iextetwma_date.'</td>';
							echo '<td style="text-align:center;"><div class="progress"><div class="progress-bar progress-bar-danger active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:';
								$total_act = 0 ;
								$done_act = 0 ;
								for ($ij=0; $ij < count($work_activity) ; $ij++) { 
									if ($work_activity[$ij]->iua_allot_id == $work_allot[$i]->iextetwma_id ) {
										$total_act++;
										if ($work_activity[$ij]->iua_status == 'done') {
											$done_act++;
										}
										$act_per = (intval($done_act) / intval($total_act) ) * 100;
									}
								}
							echo $act_per;
							echo '%;background-color: #4CAF50"></div></div></td><td>';
							echo $act_per.'%';
							echo '</td>';
							echo '</tr>';
						}
					}
				?>
			</tbody>
		</table>
	</div>
</main>
</body>
<div class="modal fade" id="work_allot_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3>Work allot to user</h3>
				<hr>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
					<input class="mdl-textfield__input" type="text" id="template_name" placeholder="Enter Work template name">
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
					<label>Share with user</label>
					<ul id="mutual_tag"></ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button" data-dismiss="modal" id="allot_to_user">Allot</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var customer_data = [];
	var work_list = [];
    <?php
        if (isset($work_list)) {
            for ($i=0; $i < count($work_list) ; $i++) {
                echo "work_list.push('".$work_list[$i]->iextetwm_title."');";
            }
        }

		if (isset($cust_list)) {
			for ($i=0; $i < count($cust_list) ; $i++) {
				echo "customer_data.push('".$cust_list[$i]->ic_name."');";
			}
		} 
	?>
	$(document).ready(function() {
		$("#template_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(work_list, request.term);
                response(results.slice(0, 10));
            }    
        });

		$('#mutual_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : customer_data,
    		singleField : true
    	});

		$('#details').on('click', '.tbl_view_inward', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');
			window.location = "<?php echo base_url().'Work_module/work_add/'.$code."/"; ?>"+tid;
		}));

		$('.create_temp').click(function (e){
			e.preventDefault();
			window.location = "<?php echo base_url().'Work_module/work_add/'.$code; ?>";
		});

		$('.allot_work').click(function (e){
			e.preventDefault();
			$('#work_allot_modal').modal('show');
		});

		$('#allot_to_user').click(function (e){
			e.preventDefault();
			var mutual = [];
			$('#mutual_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					mutual.push(tmpstr1);
				}
			});
			$.post('<?php echo base_url()."Work_module/work_allot/".$code; ?>', {
				'user_list' : mutual,
				'template_name' : $('#template_name').val()
			}, function(data, status, xhr) {
				// console.log(data);
				window.location = "<?php echo base_url().'Work_module/home/0/'.$code; ?>";
			})

		});
	})
</script>
</html>