<style type="text/css">
    .ui-widget {
        z-index: 30000;
    }
	.emp{
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc; 
		padding: 30px;
		background-color: #ffa784;
		text-align: center;
		height: 20px;
	}
	h3{
		margin-top: -10px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<button class="mdl-button mdl-button--colore add_employee"><i class="material-icons">add</i> Add employee</button>
			<button class="mdl-button mdl-button--colore view_attend"><i class="material-icons">remove_red_eye</i> View Attendance</button>
			<button class="mdl-button mdl-button--colore process_sal"><i class="material-icons">credit_card</i> Process Salary</button>
		</div>
	</div>
</main>
<!-- <div class="modal fade" id="issue_card_Modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3 class="modal-title" style="text-align: center;">Allot card to employee</h3>
				<hr>
				<div class="mdl-cell mdl-cell--12-col">
					<h4>Enter employee name</h4>
					<ul id="emp_tag"></ul>
				</div>
				<div class="mdl-cell mdl-cell--12-col card_list"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="allot_card">Allot</button>
			</div>
		</div>
	</div>
</div> -->
<!-- <div class="modal fade" id="salary_para_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3 class="modal-title" style="text-align: center;">Add salary parameter's</h3>
				<hr>
				<div class="mdl-grid para_list"></div>
				<button class="mdl-button mdl-button--colored add_para"  style="width: 100%;"><i class="material-icons">add</i> add parameter's</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="save_para">Save</button>
			</div>
		</div>
	</div>
</div> -->
<script>
	var emp_data = [] ;
	var aval_card_id;
	<?php
			if (isset($emp_list)) {
				for ($i=0; $i < count($emp_list) ; $i++) { 
					echo "emp_data.push('".$emp_list[$i]->ic_name."');";
				}
			}
	?>
	$(document).ready(function() {
		$('#emp_tag').tagit({
    		autocomplete: {delay: 0, minLength: 3},
    		allowSpaces : true,
    		availableTags : emp_data,
    		tagLimit : 1,
    		singleField : true,
    		maxTags : 5 ,
    		beforeTagAdded: function(event, ui) {
        		get_avl_card();
    		},
    		beforeTagRemoved: function(event, ui) {
		        $('.card_list').empty();
		    }
    	});

    	$('.add_employee').click(function (e) {
    		e.preventDefault();
    		window.location = "<?php echo base_url().'Hr/add_employee/'.$code;?>";
    	});

    	$('.view_attend').click(function (e) {
    		e.preventDefault();
    		window.location = "<?php echo base_url().'Hr/view_attendance/'.$code;?>";
    	});

    	$('.process_sal').click(function (e) {
    		e.preventDefault();
    		window.location = "<?php echo base_url().'Hr/process_salary/'.$code;?>";
    	});

    	function get_avl_card() {
			$.post('<?php echo base_url()."Hr/get_card_details/".$code; ?>',
			function(data, status, xhr) {
        		var a = JSON.parse(data);
        		if (a.card_list.length > 0 ) {
        			aval_card_id = a.card_list[0].ihwh_id;
        			var out = '<button class="mdl-button mdl-button--colored card_allot" style="width:100%;" id="'+a.card_list[0].ihwh_id+'">Card serial number : '+a.card_list[0].ihwh_card_id+'</button>';
        			$('.card_list').empty();
        			$('.card_list').append(out);
        		}
        	});
		}

		// $('.issue_card').click(function (e) {
		// 	e.preventDefault();
		// 	aval_card_id = 0 ;
		// 	get_avl_card();
		// 	$('#issue_card_Modal').modal('show');
		// });

		// $('#issue_card_Modal').on('click','#allot_card',function (e) {
		// 	e.preventDefault();
		// 	var txn_tags = [] ;
		// 	$('#emp_tag > li').each(function(index) {
		// 		var tmpstr = $(this).text();
		// 		var len = tmpstr.length - 1;
		// 		if(len > 0) {
		// 			tmpstr = tmpstr.substring(0, len);
		// 			txn_tags.push(tmpstr);
		// 		}
		// 	});
		// 	$.post('<?php echo base_url()."Hr/card_allot_emp/".$code; ?>',{
		// 		'cname' : txn_tags,
		// 		'card_id' : aval_card_id
		// 	},function(data, status, xhr) {
		// 		$('.card_list').empty();
  //       	});
		// });

		// $('.salary_parameter').click(function (e) {
		// 	e.preventDefault();
		// 	$('#salary_para_modal').modal('show');
		// });

		// $('#salary_para_modal').on('click','.add_para',function (e) {
		// 	e.preventDefault();
		// 	var out = '<div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="para'+p_list+'" class="mdl-textfield__input para_auto" style="outline:none;" placeholder="Enter parameter name"></div></div><div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"><select class="mdl-textfield__input" id="para_char_'+p_list+'"><option value="-">Minus</option><option value="+">Plus</option></select></div></div></div><div class="mdl-cell mdl-cell--2-col"><button class="mdl-button mdl-button--colored para_delete" id="'+p_list+'"><i class="material-icons">delete</i> delete</button></div>';
		// 	p_list++;
		// 	$('.para_list').append(out);
		// });

		// $('#salary_para_modal').on('click','.para_delete',function (e) {
		// 	e.preventDefault();
		// 	var pid = $(this).prop('id');
		// 	var para_arr = [] ;
		// 	var temp_p_list = 0 ;
		// 	var out = '';
		// 	for (var i = 0; i < p_list ; i++) {
		// 		if (pid != i ) {
		// 			var p_name = $('#para'+i).val();
		// 			var p_val = $('#para_char_'+i).val();
		// 			para_arr.push({ id : i , name : p_name , val : p_val });
		// 		}
		// 	}
		// 	p_list = 0 ;
		// 	if (para_arr.length > 0 ) {
		// 		for (var i = 0; i < para_arr.length; i++) {
		// 			out += '<div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="para'+p_list+'" value="'+para_arr[i].name+'" class="mdl-textfield__input para_auto" style="outline:none;" placeholder="Enter parameter name"></div></div><div class="mdl-cell mdl-cell--5-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"><select class="mdl-textfield__input" id="para_char_'+p_list+'">';
		// 			if (para_arr[i].val == '-' ) {
		// 				out += '<option value="-" selected>Minus</option>';
		// 			}else{
		// 				out += '<option value="-">Minus</option>';
		// 			}
		// 			if (para_arr[i].val == '+' ) {
		// 				out += '<option value="+" selected>Plus</option>';
		// 			}else{
		// 				out += '<option value="+">Plus</option>';
		// 			}
		// 			out +='</select></div></div></div><div class="mdl-cell mdl-cell--2-col"><button class="mdl-button mdl-button--colored para_delete" id="'+p_list+'"><i class="material-icons">delete</i> delete</button></div>';
		// 			p_list++;
		// 		}
		// 	}
		// 	$('.para_list').empty();
		// 	$('.para_list').append(out);
		// });		

		// $('#salary_para_modal').on('click','#save_para',function (e) {
		// 	e.preventDefault();
		// 	var para_arr = [] ;
		// 	for (var i = 0; i < p_list ; i++) {
		// 		var p_name = $('#para'+i).val();
		// 		var p_val = $('#para_char_'+i).val();
		// 		para_arr.push({ id : i , name : p_name , val : p_val });
		// 	}
		// 	console.log(para_arr);
		// });
	});
</script>
</html>