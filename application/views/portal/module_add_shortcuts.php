<main class="mdl-layout__content">
	<div class="mdl-grid">

		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--6dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Module Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="s_function" name="s_function" class="mdl-textfield__input">
							<option value="none">Select</option>
							<?php 
								if (isset($func)) {
									for ($i=0; $i < count($func) ; $i++) { 
										echo "<option value='".$func[$i]->ifun_id."'>".$func[$i]->ifun_name."</option>";
									}
								}	
							?>
						</select>
						<label class="mdl-textfield__label" for="s_function">Select Function</label>
					</div><div></div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="s_name" name="s_name" class="mdl-textfield__input" value="">
						<label class="mdl-textfield__label" for="s_name">Shortcut Name</label>
					</div><div></div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="i_name" name="i_name" class="mdl-textfield__input" value="">
						<label class="mdl-textfield__label" for="i_name">Icon Name</label>
					</div>
					<button class="mdl-button mdl-button-done mdl-button--accent" id="submit"><i class="material-icons">add</i></button>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Shortcut Name</th>
						<th class="mdl-data-table__cell--non-numeric">Function Name</th>
						<th class="mdl-data-table__cell--non-numeric">Icon Name</th>
					</tr>
				</thead>
				<tbody id="m_list" >
					
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</body>
<script type="text/javascript">
	
	var modules_array = [];

	<?php
		if (isset($modules)) {
			for ($i=0; $i <count($modules) ; $i++) { 
				if ($modules[$i]->ims_m_id == $mid) {
					echo "modules_array.push({'id': ".$modules[$i]->ims_id.",'name' : '".$modules[$i]->ims_name."', 'function' : '".$modules[$i]->ifun_name."','icon' : '".$modules[$i]->ims_icon."'});";
				}
			}
		}
	?>
    $(document).ready( function() {
    	append_module();
    	
    	function append_module(){
    		var a ='';

    		for (var i = 0; i < modules_array.length; i++) {
    			a+='<tr class="mdl-data-table__cell--non-numeric modules" id="'+modules_array[i].id+'"><td style="text-align: left">'+ modules_array[i].name +'</td><td style="text-align: left">'+ modules_array[i].function +'</td><td style="text-align: left">'+ modules_array[i].icon +'</td></tr>';
    		}
    		
    		$('#m_list').empty();
    		$('#m_list').append(a);
    	}

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var name = $('#s_name').val();
			var func = $('#s_function').val();
			var icon = $('#i_name').val();

			$.post('<?php echo base_url()."Portal/add_shortcuts/".$mid; ?>', {
				's_name' : name, 's_function' : func, 's_icon' : icon
			}, function(data, status, xhr) {
	    		window.location = "<?php echo base_url().'Portal/modules_shortcuts_add/'; ?>"+ data;
			}, 'text');

		});

	});
</script>
</html>