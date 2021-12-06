<main>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col mdl-shadow--4dp" style="border-radius: 15px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
						<input type="text" class="mdl-textfield__input" id="h_title" name="h_title" style="font-size: 3em;" placeholder="Enter title" value="<?php if(isset($edit_helpers)){ echo $edit_helpers[0]->ih_title; } ?>">
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" class="mdl-textfield__input" id="f_name" value="<?php if(isset($edit_helpers)){ echo $edit_helpers[0]->ih_func_name; } ?>" >
						<label class="mdl-textfield__label" for="f_name">Enter Function Name</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" class="mdl-textfield__input" id="h_type" value="<?php if(isset($edit_helpers)){ echo $edit_helpers[0]->ih_type; } ?>" >
						<label class="mdl-textfield__label" for="h_type">Enter helper type</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="f_module" name="f_module">
							<!-- <option value="all">Select from module</option> -->
						</select>
						<label class="mdl-textfield__label" for="f_module">Select from module</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="t_module" name="t_module">
							<!-- <option value="all">Select to module</option> -->
						</select>
						<label class="mdl-textfield__label" for="t_module">Select to module</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" class="mdl-textfield__input" id="o_type" value="<?php if(isset($edit_helpers)){ echo $edit_helpers[0]->ih_outcome_type; } ?>">
						<label class="mdl-textfield__label" for="o_type">Enter outcome type</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--6-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" class="mdl-textfield__input" id="o_value" value="<?php if(isset($edit_helpers)){ echo $edit_helpers[0]->ih_outcome_value; } ?>">
						<label class="mdl-textfield__label" for="o_value">Enter outcome value</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%;">
						<label>Add function parameters</label>
						<ul id="parameter_tag">
							<?php 
								if(isset($edit_parameter)){ 
									for ($i=0; $i <count($edit_parameter) ; $i++) { 
										echo '<li>'.$edit_parameter[$i]->ihp_value.'</li>';
									}
								} 
							?>
						</ul>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
					<button class="mdl-button mdl-button--colored save"><i class="material-icons">save</i> save</button>
				</div>
			</div>	
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Helper title</th>
						<th class="mdl-data-table__cell--non-numeric">Type</th>
						<th class="mdl-data-table__cell--non-numeric">Action</th>
					</tr>
				</thead>
				<tbody id="h_list" >
					
				</tbody>
			</table>
		</div>
	</div>
</main>
<script type="text/javascript">
	var modules_array = [];
	var helpers_array = [];
	
	<?php
		if (isset($modules)) {
			for ($i=0; $i <count($modules) ; $i++) {
				echo "modules_array.push({'id': ".$modules[$i]->im_id.",'name' : '".$modules[$i]->im_name."'});";
			}
		}

		if (isset($helpers)) {
			for ($i=0; $i <count($helpers) ; $i++) { 
				echo "helpers_array.push({'id' : '".$helpers[$i]->ih_id."', 'title' : '".$helpers[$i]->ih_title."', 'type' : '".$helpers[$i]->ih_type."','status' : 'false'});";
			}
		}
		if (isset($edit_helpers)) {
			for ($i=0; $i <count($edit_helpers) ; $i++) {
				echo "var helpers_fmid = ".$edit_helpers[$i]->ih_from_module.";";
				echo "var helpers_tmid = ".$edit_helpers[$i]->ih_to_module.";";
			}
		}else{
			echo "var helpers_fmid = 0;";
			echo "var helpers_tmid = 0;";
		}
	?>
	$(document).ready( function() {
		module();
		helper_list();
		
		$('#parameter_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true
    	});

		$('.save').click(function(e) {
			e.preventDefault();
			var par = [];
			$('#parameter_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					par.push(tmpstr1);
				}
			});

			$.post('<?php if (isset($edit_helpers)) {echo base_url().'Portal/update_helper/'.$hid;}else{echo base_url().'Portal/save_helper/';} ?>',{
				'f_name' : $('#f_name').val(),
				'title' : $('#h_title').val(),
				'f_module' : $('#f_module').val(),
				't_module' : $('#t_module').val(),
				'h_type' : $('#h_type').val(),
				'o_type' : $('#o_type').val(),
				'o_value' : $('#o_value').val(),
				'parameters' : par,
			},function(data,status,xhr) {
				window.location = "<?php echo base_url().'Portal/module_helper/'; ?>";
			});
		});

		$('#h_list').on('click','.delete',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = "<?php echo base_url().'Portal/delete_helper/'; ?>"+id;
		});

		$('#h_list').on('click','.edit',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = "<?php echo base_url().'Portal/module_helper/'; ?>"+id;			
		});

		function module() {
			var a = '<option value="all">Select from module</option>';
			for (var i = 0; i < modules_array.length; i++) {
				if (helpers_fmid == modules_array[i].id) {
					a+='<option value="'+modules_array[i].id+'" selected>'+modules_array[i].name+'</option>';
				}else{
					a+='<option value="'+modules_array[i].id+'">'+modules_array[i].name+'</option>';
				}
			}

			$('#f_module').empty();
			$('#f_module').append(a);
			a='';

			a = '<option value="all">Select to module</option>';
			for (var i = 0; i < modules_array.length; i++) {
				if (helpers_tmid == modules_array[i].id) {
					a+='<option value="'+modules_array[i].id+'" selected>'+modules_array[i].name+'</option>';
				}else{
					a+='<option value="'+modules_array[i].id+'">'+modules_array[i].name+'</option>';
				}
			}			

			$('#t_module').empty();
			$('#t_module').append(a);
		}

		function helper_list() {
			var a = '';
			for (var i = 0; i < helpers_array.length; i++) {
    			a+='<tr class="mdl-data-table__cell--non-numeric"><td style="text-align: left">'+ helpers_array[i].title +'</td><td style="text-align: left">'+ helpers_array[i].type +'</td><td style="text-align: left"><div class="mdl-grid"><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button-icon edit" id="'+helpers_array[i].id+'"><i class="material-icons">edit</i></button></div><div class="mdl-cell mdl-cell--6-col"><button class="mdl-button mdl-button-icon delete" id="'+helpers_array[i].id+'"><i class="material-icons">delete</i></button></div></div></td></tr>';
    		}
    		$('#h_list').empty();
    		$('#h_list').append(a);
		}
	});
</script>