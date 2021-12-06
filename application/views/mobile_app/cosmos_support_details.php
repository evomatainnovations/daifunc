<style type="text/css">
body {
	text-align: center;
}
.general_table {
	width: 100%;
    text-align: left;
    font-size: 1em;
    border: 1px solid #ccc;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: auto;
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

.general_table > tbody > tr > td {
	padding: 15px;
}

.general_table > tfoot > tr {
	border: 1px solid #ccc;
}

.general_table > tfoot > tr > td {
	padding: 10px;
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col" style="overflow: auto;">
			<table class="general_table">
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
<script type="text/javascript">
	var c_data = [];
	var s_act = [];
	var support_arr = [];
	<?php
		if (isset($support)) {
			for ($i=0; $i < count($support) ; $i++) {
				echo "support_arr.push({'id' : '".$support[$i]->ies_id."' , 'type' : 'create' ,'name' : '".$support[$i]->ic_name."' , 'date' : '".$support[$i]->ies_date."' , 'title' : '".$support[$i]->ies_subject."' , 'desc' : '".$support[$i]->ies_desc."' , 'prty' : '".$support[$i]->ies_priority."' , 'rem' : '".$support[$i]->ies_remark."' , 'cmnt' : 'N/A' , 'rat' : 'N/A' });";
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
	?>
	$(document).ready(function() {
		display_list();
		function display_list(){
			var a = '';
			if (s_act.length > 0) {
				for (var i = 0; i < s_act.length; i++) {
					a+= '<tr>';
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