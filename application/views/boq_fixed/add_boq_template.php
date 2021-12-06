<style type="text/css">
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
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<input type="text" id="title_name" name="title_name" class="mdl-textfield__input" placeholder="Enter Title" style="font-size: 2.5em;outline: none;">
					<div style="display: flex;">
						<button class="mdl-button mdl-button--colored save_as_temp" style="display: none;"><i class="material-icons">save</i>save as</button>
						<button class="mdl-button mdl-button--colored delete_temp" style="display: none;"><i class="material-icons">delete</i>delete</button>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<button class="mdl-button mdl-button--colored add_boq_cat"><i class="material-icons">add</i>Add Category</button>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 60vh;overflow-y: scroll;width: 100%;">
					<div class="mdl-grid boq_cat_list"></div>
				</div>
				<button class="mdl-button lower-button mdl-button--fab mdl-button--colored save_boq"><i class="material-icons">done</i></button>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col boq_template_list" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; margin-top: 20px;margin-bottom: 20px;"></div>
	</div>
</main>
<div class="modal fade" id="boq_add_details" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<h3 class="modal-title"></h3>
			</div>
			<div class="modal-body" style="text-align: center;">
				<div class="mdl-cell mdl-cell--12-col" style="display: center;">
					<button class="mdl-button mdl-button--colored add_item_cat"><i class="material-icons">add</i> Add category</button>
				</div>
				<div class="mdl-grid item_cat_list" style="height: 60vh;overflow: auto;"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i>close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="save_as_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="text-align: center;">
				<div class="mdl-cell mdl-cell--12-col" style="display: center;">
					<input type="text" id="save_as_title" class="mdl-textfield__input" placeholder="Enter Title" style="font-size: 2.5em;outline: none;">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i>close</button>
				<button type="button" class="mdl-button save_title" data-dismiss="modal"><i class="material-icons">save</i>save</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var cat_flg = 0;
	var boq_cat_arr = [];
	var edit_cat_id = null;
	var edit_item_id = null;
	var detail_cat_id = null;
	var detail_item_id = null;
	var item_cat_flg = 0;
	var edit_detail_item_id = null;
	var edit_detail_cat_id = null;
	var boq_temp_arr = [];
	var edit_template = null;
	<?php
		for ($i=0; $i < count($boq_temp_list) ; $i++) { 
			echo "boq_temp_arr.push({'id' : '".$boq_temp_list[$i]->iextetboqt_id."' , 'title' : '".$boq_temp_list[$i]->iextetboqt_title."'});";
		}
	?>
	$(document).ready( function() {
		display_template_list();
		$('.save_boq').click(function (e) {
        	e.preventDefault();
        	if (edit_template == null) {
        		var path = '<?php echo base_url()."BOQ_fixed/boq_template_save/".$code; ?>';
        	}else{
        		var path = '<?php echo base_url()."BOQ_fixed/boq_template_update/".$code."/"; ?>'+edit_template;
        	}
        	$.post(path,{
        		'title' : $('#title_name').val(),
    			'boq_arr' : boq_cat_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."BOQ_fixed/home/0/".$code; ?>';
			}, "text");
        });

        $('.delete_temp').click(function (e) {
        	e.preventDefault();
        	if (edit_template != null) {
        		var path = '<?php echo base_url()."BOQ_fixed/boq_delete/".$code."/"; ?>'+edit_template;
	        	$.post(path,
	        	function(data, status, xhr) {
					window.location = '<?php echo base_url()."BOQ_fixed/home/0/".$code; ?>';
				}, "text");
        	}
        });

        $('.save_as_temp').click(function (e) {
        	e.preventDefault();
        	$('#save_as_modal').modal('show');
        });

        $('.save_title').click(function (e) {
        	e.preventDefault();
        	var path = '<?php echo base_url()."BOQ_fixed/boq_template_save/".$code; ?>';
        	$.post(path,{
        		'title' : $('#save_as_title').val(),
    			'boq_arr' : boq_cat_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."BOQ_fixed/home/0/".$code; ?>';
			}, "text");
        });

  		$('.add_boq_cat').click(function (e) {
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}
			boq_cat_arr.push({'id' : cat_flg, 'cat_name' : '' , 'item_arr' : []});
			cat_flg++;
			display_cat_list();
        });

        $('.boq_cat_list').on('keyup','.boq_unit',function(e){
        	e.preventDefault();
        	if (e.keyCode == 13) {
        		for (var i = 0; i < boq_cat_arr.length; i++) {
	        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
	        		boq_cat_arr[i].cat_name = cat_name;
	        	}

        		var id = $(this).data('boq');
	        	var particular = $('#particular'+id).val();
	        	var unit = $('#boq_unit'+id).val();
	        	if (edit_cat_id == null) {
	        		for (var i = 0; i < boq_cat_arr.length; i++) {
		        		if(boq_cat_arr[i].id == id ){
		        			boq_cat_arr[i]['item_arr'].push({'particular' : particular , 'unit' : unit , 'detail_arr' : [] });
		        		}
		        	}
	        	}else{
	        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['particular'] = particular;
	        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['unit'] = unit;
	        		edit_cat_id = null;
					edit_item_id = null;
	        	}
	        	display_cat_list();
	        	$('#particular'+id).focus();
        	}
        });

        $('.boq_cat_list').on('click','.add_boq_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}
        	var id = $(this).prop('id');
        	var particular = $('#particular'+id).val();
        	var unit = $('#boq_unit'+id).val();

        	if (edit_cat_id == null) {
        		for (var i = 0; i < boq_cat_arr.length; i++) {
	        		if(boq_cat_arr[i].id == id ){
	        			boq_cat_arr[i]['item_arr'].push({'particular' : particular , 'unit' : unit , 'detail_arr' : [] });
	        		}
	        	}
        	}else{
        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['particular'] = particular;
        		boq_cat_arr[edit_cat_id]['item_arr'][edit_item_id]['unit'] = unit;
        		edit_cat_id = null;
				edit_item_id = null;
        	}
        	display_cat_list();
        	$('#particular'+id).focus();
        });

        $('.boq_cat_list').on('click','.edit_boq_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	p_val = boq_cat_arr[id]['item_arr'][sub_id]['particular'];
        	b_val = boq_cat_arr[id]['item_arr'][sub_id]['unit'];
        	$('#particular'+id).val(p_val);
        	$('#boq_unit'+id).val(b_val);
        	$('#particular'+id).focus();
        	edit_cat_id = id;
        	edit_item_id = sub_id;
        });

        $('.boq_cat_list').on('click','.delete_boq_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	boq_cat_arr[id]['item_arr'].splice(sub_id, 1);
        	display_cat_list();
        });

        $('.boq_cat_list').on('click','.add_boq_details',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		var cat_name = $('#cat_title'+boq_cat_arr[i].id).val();
        		boq_cat_arr[i].cat_name = cat_name;
        	}
        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	detail_cat_id = id;
        	detail_item_id = sub_id;
        	$('.modal-title').empty();
        	$('.modal-title').append(boq_cat_arr[id]['item_arr'][sub_id]['particular']);
        	display_item_cat_list();
        	$('#boq_add_details').modal('show');
        });

        function display_cat_list(){
        	var out = '';
        	for (var i = 0; i < boq_cat_arr.length; i++) {
        		out += '<div class="mdl-cell mdl-cell--12-col">';
        		out += '<input type="text" id="cat_title'+boq_cat_arr[i].id+'" class="mdl-textfield__input" placeholder="Enter Category Name" ';
        		if (boq_cat_arr[i].cat_name != '') {
        			out += 'value = "'+boq_cat_arr[i].cat_name+'"';
        		}
        		out += 'style="outline: none;font-size:1.5em;">';
        		
        		out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--8-col">';
        		out += '<input type="text" id="particular'+boq_cat_arr[i].id+'" class="mdl-textfield__input" placeholder="Enter Particular" style="outline: none;">';
        		out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--2-col">';
        		out += '<input type="text" id="boq_unit'+boq_cat_arr[i].id+'" data-boq = "'+boq_cat_arr[i].id+'" class="mdl-textfield__input boq_unit" placeholder="Enter Unit" style="outline: none;">';
        		out += '</div>';
        		out += '<div class="mdl-cell mdl-cell--2-col">';
        		out += '<button class="mdl-button mdl-button--colored add_boq_item" id="'+boq_cat_arr[i].id+'"><i class="material-icons">add</i></button>';
        		out += '</div>';
        		out += '<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;"><thead><tr><th style="text-align:left;">Sr. No.</th><th style="text-align:left;">Particulars</th><th style="text-align:left;">Units</th><th style="text-align:center;">Action</th></tr></thead><tbody id="boq_item_list">';
        		for (var ij = 0; ij < boq_cat_arr[i]['item_arr'].length; ij++) {
        			srno = ij + 1;
        			out += '<tr>';
        			out += '<td style="text-align:left;">'+srno+'</td>';
        			out += '<td style="text-align:left;">'+boq_cat_arr[i]['item_arr'][ij]['particular']+'</td>';
        			out += '<td style="text-align:left;">'+boq_cat_arr[i]['item_arr'][ij]['unit']+'</td>';
        			out += '<td style="text-align:center;"><button class="mdl-button mdl-button--colored edit_boq_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">edit</i></button><button class="mdl-button mdl-button--colored delete_boq_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">delete</i></button><button class="mdl-button mdl-button--colored add_boq_details" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">add</i> Add details</button></td></tr>';
        		}
        		out += '</tbody></table>';
        		out += '<div class="mdl-cell mdl-cell--12-col" style="border-top:1px solid #000;width:100%;"></div>';
        	}
        	$('.boq_cat_list').empty();
        	$('.boq_cat_list').append(out);
        }

        $('.add_item_cat').click(function (e) {
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}
        	boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].push({'id' : item_cat_flg, 'cat_name' : '' , 'item_arr' : []});
			item_cat_flg++;
			display_item_cat_list();
        });

        $('.item_cat_list').on('keyup','.item_unit',function(e){
        	e.preventDefault();
        	if (e.keyCode == 13) {
        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
	        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
	        	}

        		var id = $(this).data('boq');
	        	var particular = $('#item_particular'+id).val();
	        	var unit = $('#item_unit'+id).val();

	        	if (edit_detail_cat_id == null) {
	        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
		        		if(boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id'] == id ){
		        			boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'].push({'particular' : particular , 'unit' : unit ,'detail_arr' : []});
		        		}
		        	}
	        	}else{
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['particular'] = particular;
	        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['unit'] = unit;
	        		edit_detail_cat_id = null;
					edit_detail_item_id = null;
	        	}
	        	display_item_cat_list();
	        	$('#item_particular'+id).focus();
        	}
        });

        $('.item_cat_list').on('click','.add_item_list',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}

    		var id = $(this).prop('id');
        	var particular = $('#item_particular'+id).val();
        	var unit = $('#item_unit'+id).val();

        	if (edit_detail_cat_id == null) {
        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
	        		if(boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id'] == id ){
	        			boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'].push({'particular' : particular , 'unit' : unit ,'detail_arr' : [] });
	        		}
	        	}
        	}else{
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['particular'] = particular;
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][edit_detail_cat_id]['item_arr'][edit_detail_item_id]['unit'] = unit;
        		edit_detail_cat_id = null;
				edit_detail_item_id = null;
        	}
        	display_item_cat_list();
        	$('#item_particular'+id).focus();
        });

        $('.item_cat_list').on('click','.edit_detail_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');

        	var p_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['particular'];
        	var b_val = boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'][sub_id]['unit'];

        	$('#item_particular'+id).val(p_val);
        	$('#item_unit'+id).val(b_val);
        	$('#item_particular'+id).focus();

        	edit_detail_cat_id = id;
			edit_detail_item_id = sub_id;
        });

        $('.item_cat_list').on('click','.delete_detail_item',function(e){
        	e.preventDefault();
        	for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
        		var cat_name = $('#cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']).val();
        		boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] = cat_name;
        	}

        	var id = $(this).data('catid');
        	var sub_id = $(this).data('itemid');
        	boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][id]['item_arr'].splice(sub_id,1);
        	display_item_cat_list();
        });

        function display_item_cat_list(){
        	var out = '';
        	if(boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr']) {
        		for (var i = 0; i < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'].length; i++) {
	        		out += '<div class="mdl-cell mdl-cell--12-col">';
	        		out += '<input type="text" id="cat_item_title'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input" placeholder="Enter Category Name" ';
	        		if (boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name'] != '') {
	        			out += 'value = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['cat_name']+'"';
	        		}
	        		out += 'style="outline: none;font-size:1.5em;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--8-col">';
	        		out += '<input type="text" id="item_particular'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input" placeholder="Enter Particular" style="outline: none;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<input type="text" id="item_unit'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" data-boq = "'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'" class="mdl-textfield__input item_unit" placeholder="Enter Unit" style="outline: none;">';
	        		out += '</div>';
	        		out += '<div class="mdl-cell mdl-cell--2-col">';
	        		out += '<button class="mdl-button mdl-button--colored add_item_list" id="'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['id']+'"><i class="material-icons">add</i></button>';
	        		out += '</div>';
	        		out += '<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;"><thead><tr><th style="text-align:left;">Sr. No.</th><th style="text-align:left;">Particulars</th><th style="text-align:left;">Units</th><th style="text-align:center;">Action</th></tr></thead><tbody id="boq_item_list">';
	    			for (var ij = 0; ij < boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'].length; ij++) {
	        			srno = ij + 1;
	        			out += '<tr>';
	        			out += '<td style="text-align:left;">'+srno+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['particular']+'</td>';
	        			out += '<td style="text-align:left;">'+boq_cat_arr[detail_cat_id]['item_arr'][detail_item_id]['detail_arr'][i]['item_arr'][ij]['unit']+'</td>';
	        			out += '<td style="text-align:center;"><button class="mdl-button mdl-button--colored edit_detail_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">edit</i></button><button class="mdl-button mdl-button--colored delete_detail_item" data-catid="'+i+'" data-itemid="'+ij+'"><i class="material-icons">delete</i></button></td></tr>';
	        		}
	        		out += '</tbody></table>';
	        		out += '<div class="mdl-cell mdl-cell--12-col" style="border-top:1px solid #000;width:100%;"></div>';
	        	}
        	}
        	$('.item_cat_list').empty();
        	$('.item_cat_list').append(out);
        }

        $('.boq_template_list').on('click','.boq_table',function (e){
        	e.preventDefault();
        	var id = $(this).prop('id');
        	edit_template = id;
        	$.post('<?php echo base_url()."BOQ_fixed/get_boq_template/".$code."/"; ?>'+id
        	, function(data, status, xhr) {
        		var a = JSON.parse(data);
        		$('.save_as_temp').css('display','block');
        		$('.delete_temp').css('display','block');

        		$('#title_name').val(a.title);
        		boq_cat_arr = [];
        		for (var i = 0; i < a.boq.length; i++) {
        			boq_cat_arr.push({'cat_name' : a.boq[i].cat_name , 'id' : a.boq[i].id , 'item_arr' : [] });

        			for (var j = 0; j < boq_cat_arr.length; j++) {
        				if(boq_cat_arr[j].id == a.boq[i].id){
        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
        						boq_cat_arr[i]['item_arr'].push({'particular' : a.boq[i]['item_arr'][ij]['particular'] , 'unit' : a.boq[i]['item_arr'][ij]['unit'] , 'detail_arr' : []});
        					}
        				}
        			}

        			for (var j = 0; j < boq_cat_arr.length; j++) {
        				if(boq_cat_arr[j].id == a.boq[i].id){
        					for (var ij = 0; ij < a.boq[i]['item_arr'].length; ij++) {
        						if (a.boq[i]['item_arr'][ij]['detail_arr']) {
        							for (var k = 0; k < boq_cat_arr[j]['item_arr'].length; k++) {
        								if (k == ij) {
        									boq_cat_arr[j]['item_arr'][k]['detail_arr'] = a.boq[i]['item_arr'][ij]['detail_arr'];
        								}
        							}
        						}
        					}
        				}
        			}
        		}
        		display_cat_list();
			}, "text");
        });

        function display_template_list(){
        	var out = '';
        	out += '<table class="mdl-data-table mdl-js-data-table general_table" style="width: 100%;"><thead><tr><th style="text-align:left;">Sr. No.</th><th style="text-align:left;">Title</th></tr></thead><tbody style="overflow:auto;">';
    		for (var ij = 0; ij < boq_temp_arr.length; ij++) {
    			srno = ij + 1;
    			out += '<tr class="boq_table" id="'+boq_temp_arr[ij].id+'">';
    			out += '<td style="text-align:left;">'+srno+'</td>';
    			out += '<td style="text-align:left;">'+boq_temp_arr[ij].title+'</td>';
    			out += '</tr>';
    		}
    		out += '</tbody></table>';

    		$('.boq_template_list').empty();
        	$('.boq_template_list').append(out);
        }
	});
</script>