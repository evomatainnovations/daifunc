<style type="text/css">
	@media only screen and (max-width: 760px) {
		.general_table {
			display: block;
	    	overflow: auto;
		}
	}
	th,td{
		text-align: center;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Accounting Year</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="date-input-start" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="date-input-start">Year Start Date</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="date-input-end" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="date-input-end">Year End Date</label>
					</div>

					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="year-code" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="year-code">Year Code</label>
					</div>
					<div>
						<button class="mdl-button mdl-button--accent add_button"><i class="material-icons">save</i> Save</button>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<table class="general_table" style="width: 100%;">
				<thead>
					<tr>
						<th  style="text-align:left;">Status</th>
						<th>Accounting Year</th>
						<th>Code</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="details"></tbody>
			</table>
		</div>
	</div>
</main>
</body>

<script>
	var acc_arr = [];
	var id = 0;
	<?php  
		if (isset($edit_acc)) {
			for ($i=0; $i < count($edit_acc) ; $i++) { 
				echo "acc_arr.push({'id' : '".$edit_acc[$i]->iua_id."', 's_year' : '".$edit_acc[$i]->iua_start_date."', 'e_year' : '".$edit_acc[$i]->iua_end_date."', 'code' : '".$edit_acc[$i]->iua_year_code."', 'status' : '".$edit_acc[$i]->iua_status."'});";
			}
		}
	?>
	$(document).ready(function() {
		display_acc_year();
		$('#date-input-start').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		$('#date-input-end').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		var start_yr = "";
		var end_yr = "";
		$('#date-input-start').change(function(e){
			e.preventDefault();
			
			var dt = new Date($(this).val());
			start_yr = dt.getFullYear();

			$('#year-code').val(start_yr + "-" + end_yr);
		});
		
		$('#date-input-end').change(function(e){
			e.preventDefault();
			
			var dt = new Date($(this).val());
			end_yr = dt.getFullYear();
			$('#year-code').val(start_yr + "-" + end_yr);
		});

		$(".add_button").click(function(){
        	$.post('<?php echo base_url()."Account/update_accounting_setting/".$code."/"; ?>'+id,{
        		'year_start'	: $('#date-input-start').val(),
        		'year_end' 	: $('#date-input-end').val(),
        		'year_code' : $('#year-code').val()
        	},function(d,s,x) {
        		var type = '<?php echo $type; ?>';
        		if (type == 'home') {
        			window.location = "<?php echo base_url().'Home/index/'.$code.'/account'; ?>";
        		}else{
	        		var a = JSON.parse(d);
	    			id = 0;
	    			acc_arr = [];
	    			$('#date-input-start').val('');
					$('#date-input-end').val('');
					$('#year-code').val('');
	        		for (var i = 0; i < a.edit_acc.length; i++) {
	        			acc_arr.push({id : a.edit_acc[i].iua_id, s_year : a.edit_acc[i].iua_start_date, e_year : a.edit_acc[i].iua_end_date, code : a.edit_acc[i].iua_year_code ,status : a.edit_acc[i].iua_status});
	        		}
	        		display_acc_year();
	        	}
        	},'text');
    	});

    	$("#details").on('click',".acc_select",function (e) {
    		e.preventDefault();
    		id = $(this).prop('id');
    		$.post('<?php echo base_url()."Account/status_accounting_setting/".$code."/"; ?>'+id
    		,function(d,s,x) {
    			var a = JSON.parse(d);
    			acc_arr = [];
    			id = 0;
        		for (var i = 0; i < a.edit_acc.length; i++) {
        			acc_arr.push({id : a.edit_acc[i].iua_id, s_year : a.edit_acc[i].iua_start_date, e_year : a.edit_acc[i].iua_end_date, code : a.edit_acc[i].iua_year_code ,status : a.edit_acc[i].iua_status });
        		}
        		display_acc_year();
        	},'text');
    	});

    	$("#details").on('click',".acc_delete",function (e) {
    		e.preventDefault();
    		id = $(this).prop('id');
    		$.post('<?php echo base_url()."Account/delete_accounting_setting/".$code."/"; ?>'+id
    		,function(d,s,x) {
    			var a = JSON.parse(d);
    			id = 0;
    			acc_arr = [];
        		for (var i = 0; i < a.edit_acc.length; i++) {
        			acc_arr.push({id : a.edit_acc[i].iua_id, s_year : a.edit_acc[i].iua_start_date, e_year : a.edit_acc[i].iua_end_date, code : a.edit_acc[i].iua_year_code ,status : a.edit_acc[i].iua_status });
        		}
        		display_acc_year();
        	},'text');
    	});

    	$("#details").on('click',".acc_edit",function (e) {
    		e.preventDefault();
    		id = $(this).prop('id');
    		for (var i = 0; i < acc_arr.length; i++) {
    			if (acc_arr[i].id == id) {
    				$('#date-input-start').val('');
    				$('#date-input-end').val('');
    				$('#year-code').val('');
    				$('#date-input-start').val(acc_arr[i].s_year);
    				$('#date-input-end').val(acc_arr[i].e_year);
    				$('#year-code').val(acc_arr[i].code);
    				break;
    			}
    		}
    	});

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

    	function display_acc_year(){
    		var a = '';
    		if (acc_arr.length > 0) {
    			for (var i = 0; i < acc_arr.length; i++) {
    				a+= '<tr><td style="text-align:left;">';
    				if (acc_arr[i].status == 'true') {
    					a+='<button class="mdl-button mdl-button--colored mdl-button--raised acc_select" style="background-color:green;" id="'+acc_arr[i].id+'">Selected</button>';
    				}else{
    					a+='<button class="mdl-button mdl-button--colored mdl-button--raised acc_select" style="background-color:red;" id="'+acc_arr[i].id+'">Select</button>';
    				}
    				a+='</td><td>'+acc_arr[i].code+'</td><td>'+acc_arr[i].s_year+' TO '+acc_arr[i].e_year+'</td><td><button class="mdl-button mdl-button--colored mdl-button--icons acc_delete" id="'+acc_arr[i].id+'"><i class="material-icons">delete</i> delete</button><button class="mdl-button mdl-button--colored mdl-button--icons acc_edit" id="'+acc_arr[i].id+'"><i class="material-icons">edit</i> Edit</button></td></tr>';
    			}
    		}else{
    			a+= '<tr><td colspan="3" style="text-align:center;"><h4>No records found !<h4><td></tr>';
    		}

    		$('#details').empty();
    		$('#details').append(a);
    	}

	});


</script>
</html>