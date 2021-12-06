<style type="text/css">
body {
	text-align: center;
}
.g_table {
		width: 100%;
        text-align: left;
        font-size: 1em;
        border: 1px solid #ccc;
        border-collapse: collapse;
        border-radius: 10px;
    }

	@media only screen and (max-width: 760px) {
		.g_table {
			display: block;
        	overflow: auto;
		}
	}

	.g_table > thead > tr {
		border: 1px solid #ccc;
	}

	.g_table > tbody > tr {
		border: 1px solid #ccc;
	}

	.g_table > thead > tr > th {
		padding: 10px;
	}

	.g_table > tbody {
		border: 1px solid #ccc;
	}

	.g_table > tbody > tr > td {
		padding: 15px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;height: 25vh;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
						<input type="text" id="sp_emp" class="mdl-textfield__input" style="font-size: 2em;" placeholder="Enter employee name">
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col" style="text-align: center;">
					<button class="mdl-button mdl-button--colored allot" style="margin-top: 20px;"><i class="material-icons">add</i> Allot to employee</button>
				</div>
				<div class="mdl-cell mdl-cell--6-col" style="text-align: center;">
					<button class="mdl-button mdl-button--colored grp_switch" style="margin-top : 10px"><i class="material-icons">compare_arrows</i> Transfer to group</button>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--7-col" style="text-align: center;">
					<h3>Ticket's by <?php echo $c_name; ?></h3>
				</div>
				<div class="mdl-cell mdl-cell--5-col" id="graph-container" style="text-align: center;"></div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<table class="g_table" style="width: 100%;">
				<thead>
					<tr>
						<th>Type</th>
						<th>User</th>
						<th>Date</th>
						<th>Title</th>
						<th>Description</th>
						<th>Priority</th>
						<th>Remarks</th>
						<th>Comments</th>
						<th>Rating</th>
					</tr>
				</thead>
				<tbody class="table_body"></tbody>
			</table>
		</div>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<div class="modal fade" id="myModal_group" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Select Group for transfer</h4>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield">
				    <input class="mdl-textfield__input" type="text" id="group_search">
				    <label class="mdl-textfield__label" for="group_search">Group Name</label>
				</div>
				<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="account_search"><i class="material-icons">search</i> Search</button>
				<div id="grp_body">
					
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var c_data = [];
	var s_act = [];
	var labale_arr = [];
	var data_arr = [];
	var support_arr = [];
	var user_data = [];
	<?php
		if (isset($customer)) {
			for ($i=0; $i < count($customer) ; $i++) { 
				echo "c_data.push('".$customer[$i]->ic_name."');";
			}
		}

		if (isset($support)) {
			for ($i=0; $i < count($support) ; $i++) {
				echo "support_arr.push({'id' : '".$support[$i]->ies_id."' , 'type' : 'create' ,'name' : '".$support[$i]->ic_name."' , 'date' : '".$support[$i]->ies_date."' , 'title' : '".$support[$i]->ies_category."' , 'desc' : '".$support[$i]->ies_desc."' , 'prty' : '".$support[$i]->ies_priority."' , 'rem' : '".$support[$i]->ies_remark."' , 'cmnt' : 'N/A' , 'rat' : 'N/A' });";
			}
		}

		if (isset($s_details)) {
			for ($i=0; $i < count($s_details) ; $i++) {
				if ($c_name != $s_details[$i]->ic_name ) {
					$dt = date('Y-m-d' , strtotime($s_details[$i]->iesa_created));
					echo "s_act.push({'id' : '".$s_details[$i]->iesa_id."', 'sid' : '".$s_details[$i]->iesa_sid."' , 'type' : '".$s_details[$i]->iual_title."' , 'name' : '".$s_details[$i]->ic_name."' , 'date' : '".$dt."' , 'title' : '".$s_details[$i]->iua_title."' , 'desc' : '".$s_details[$i]->iual_title."' , 'prty' : 'N/A' , 'rem' : 'N/A' , 'cmnt' : '".$s_details[$i]->iual_comment."' , 'rat' : '".$s_details[$i]->iual_star_rating."' });";
				}
			}
		}
		
		if (isset($s_chart)) {
			for ($i=0; $i <count($s_chart) ; $i++) {
				echo "labale_arr.push('".$s_chart[$i]->cat."');";
				echo "data_arr.push('".$s_chart[$i]->c_count."');";
			}
		}
		for ($i=0; $i < count($user_connection); $i++) {
    		echo "user_data.push({'id' : ".$user_connection[$i]->iug_id.", 'name' : '".$user_connection[$i]->iug_name."'});";
		}
	?>
	$(document).ready(function() {
		var snackbarContainer = document.querySelector('#demo-toast-example');
		display_list();
		display_chart();

		$('.grp_switch').click(function (e) {
			e.preventDefault();
			switch_account();
			$('#myModal_group').modal('show');
		});

		$('#myModal_group').on('click','#account_search',function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Home/account_search"; ?>', {
        		's_account' : $('#group_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		user_data = [];
        		for (var i=0; i < d.account.length; i++) {
            		user_data.push({'id' : d.account[i].iug_id, 'name' : d.account[i].iug_name});
        		}
        		switch_account();
        	});
		});

		$('#grp_body').on('click','.transfer_to_group',function (e) {
			e.preventDefault();
			var gid = $(this).prop('id');
			$.post('<?php echo base_url()."Support/support_transfer/".$code."/".$sid."/"; ?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Support/home/0/".$code; ?>';
			}, 'text');
		});

  		$("#sp_emp").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(c_data, request.term);
                response(results.slice(0, 10));
            }
        });

        $('.allot').click(function (e) {
        	e.preventDefault();
        	var e_name = $('#sp_emp').val();
        	if (e_name != '') {
        		$.post('<?php echo base_url()."View/activity_modal/".$code."/support/".$sid; ?>'
		        , function(data, status, xhr) {
		        	console.log(data);
		            $('#activity_modal > div > div').empty();
		            $('#activity_modal > div > div').append(data);
		        }, 'text');
		        $('#activity_modal').modal('toggle');
        	}else{
        		var data = {message: 'Please select employee name !'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
        	}	
        });

        function switch_account(){
			var out = '';
			if (user_data.length > 0) {
				for (var i=0; i < user_data.length; i++) {
	        		if (gid == user_data[i].id) {
	        			out+= '<button class="mdl-button mdl-button--raised mdl-button--colored transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
	        		}else{
	        			out+= '<button class="mdl-button transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
	        		}
	    		}
			}else{
				out +='<h3>No records found !!</h3>'
			}
			$('#grp_body').empty();
	    	$('#grp_body').append(out); 
		}

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

		function display_list(){
			var a = '';
			if (s_act.length > 0) {
				for (var i = 0; i < s_act.length; i++) {
					a+= '<tr>';
					// Type / User / Date /{ Title / Description / Priority / Remarks} / { Comments / Rating }
					a+= '<td>'+s_act[i].type+'</td>';
					a+= '<td>'+s_act[i].name+'</td>';
					a+= '<td>'+s_act[i].date+'</td>';
					a+= '<td>'+s_act[i].title+'</td>';
					a+= '<td>'+s_act[i].desc+'</td>';
					a+= '<td>'+s_act[i].prty+'</td>';
					a+= '<td>'+s_act[i].rem+'</td>';
					if (s_act[i].cmnt != '') {
						a+= '<td>'+s_act[i].cmnt+'</td>';
					}else{
						a+= '<td>N/A</td>';
					}
					if (s_act[i].rat != '') {
						a+= '<td>'+s_act[i].rat+'</td>';
					}else{
						a+= '<td>N/A</td>';
					}
					a+= '</tr>';
				}
			}
			for (var i = 0; i < support_arr.length; i++) {
				a+= '<tr>';
				// Type / User / Date /{ Title / Description / Priority / Remarks} / { Comments / Rating }
				a+= '<td>'+support_arr[i].type+'</td>';
				a+= '<td>'+support_arr[i].name+'</td>';
				a+= '<td>'+support_arr[i].date+'</td>';
				a+= '<td>'+support_arr[i].title+'</td>';
				a+= '<td>'+support_arr[i].desc+'</td>';
				a+= '<td>'+support_arr[i].prty+'</td>';
				a+= '<td>'+support_arr[i].rem+'</td>';
				if (support_arr[i].cmnt != '') {
					a+= '<td>'+support_arr[i].cmnt+'</td>';
				}else{
					a+= '<td>N/A</td>';
				}
				if (support_arr[i].rat != '') {
					a+= '<td>'+support_arr[i].rat+'</td>';
				}else{
					a+= '<td>N/A</td>';
				}
				a+= '</tr>';
			}

			$('.table_body').empty();
			$('.table_body').append(a);
		}
  	});
</script>