<style type="text/css">
	.loader {
		position: fixed;
	    border: 5px solid #f3f3f3;
		-webkit-animation: spin 2s linear infinite; /* Safari */
		animation: spin 1s linear infinite;
		border-top: 5px solid #555;
		border-radius: 50%;
		width: 50px;
		height: 50px;
		left: 47%;
		top: 50%;
		z-index: 1000000 !important;
	}
	@-webkit-keyframes spin {
	  0% { -webkit-transform: rotate(0deg); }
	  100% { -webkit-transform: rotate(360deg); }
	}

	@keyframes spin {
	    0% { transform: rotate(0deg); }
	    100% { transform: rotate(360deg); }
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--10-col">
			<h5>Select all the File Columns on the left that you want to merge with the Contact Property on the right. Click Transfer to Map. Proceed till your done.</h5>
			<h5>Once you are done, click <i class="material-icons">done</i> on the bottom right.</h5>

		</div>
		<div class="mdl-cell mdl-cell--2-col">
			<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--colored" id="change_import" style="width: 100%;">Change import file</button>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--2-col">
			<div  class="mdl-card mdl-shadow--2dp">
				<p style="border-bottom: 1px solid #ccc;font-size: 1.5em;margin: 15px;padding: 10px; text-align: center;">File Columns</p>
				<div id="d_data"></div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col">
			<div  class="mdl-card mdl-shadow--2dp">
				<p style="border-bottom: 1px solid #ccc;font-size: 1.5em;margin: 15px;padding: 10px; text-align: center;">Contact Properties</p>
				<div id="d_property"></div>
				<div style="margin: 25px;">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="p_name" name="p_name" class="mdl-textfield__input">
						<label class="mdl-textfield__label" for="p_name">Property Name</label>
					</div>
					<button class="mdl-button mdl-button-upside mdl-js-button mdl-js-ripple-effect" id="add" style="width: 100%;"><i class="material-icons">add</i></button>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col">
			<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--colored" id="transfer" style="width: 100%;">Transfer <i class="material-icons">play_arrow</i></button>
		</div>
		<div class="mdl-cell mdl-cell--6-col">
			<div  class="mdl-card mdl-shadow--2dp">
				<p style="border-bottom: 1px solid #ccc;font-size: 1.5em;margin: 30px;padding: 10px;">Current Selections</p>
				<div style="margin: 25px;">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" id="d_sel_section" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="d_sel_section">Type of Contact</label>
					</div>
				</div>
				<div class="mdl-grid" id="tb_sel_data" style="width: 100%;"></div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit"><i class="material-icons">check</i></button>
	</div>
	
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
</body>

<script>
	var d_array = [];
	// var multi_p_array = [];
	var multi_d_array = [];
	var p_array = [];
	var btn_array = [];
	var options = [];
	var d_sel = 0, d_sel_can=0;
	var p_sel = 0, p_sel_can=0;

$(document).ready(function() {

		var snackbarContainer = document.querySelector('#demo-toast-example');

		<?php
			if (isset($csv)) {
				for ($i=0; $i < count($csv); $i++) {
					echo "d_array.push({ 'd_id' : '".$i."', 'd_data' : '".$csv[$i]."' });";
				}
			}else{
				for ($i=1; $i < count($cells[1]); $i++) {
					echo "d_array.push({ 'd_id' : '".$i."', 'd_data' : '".$cells[1][$i]."' });";
				}
			}		
		?>	
		data_button_load();
		<?php
			echo "p_array.push({ 'p_id' : '0', 'p_data' : 'name' });";
			for ($j=0; $j < count($property); $j++) {
				echo "p_array.push({ 'p_id' : '".$property[$j]->ip_id."', 'p_data' : '".$property[$j]->ip_property."' });";
			}	
		?>	
		property_button_load();

		<?php
			for ($j=0; $j < count($options); $j++) {
				echo "options.push('".$options[$j]->ic_section."');";
			}	
		?>
		
		$("#d_sel_section").autocomplete({
            source: options
        });

		$('#d_data').on('click', '.d_data', (function(e) {
			e.preventDefault();
			var data_id = $(this).prop('id');
			var data_value = $(this).val();
			var flag = '';
			
			if(multi_d_array.length == 0){
				$(this).css('background-color','red');
				$(this).css('color', 'white');
				multi_d_array.push({'d_id' : data_id , 'd_value' : data_value});
			}else{
				for (var i = 0; i < multi_d_array.length; i++) {
					if(multi_d_array[i].d_id == data_id){
						flag = 'true';
						break;
					}
				}
				if (flag != 'true') {
					$(this).css('background-color','red');
					$(this).css('color', 'white');
					multi_d_array.push({'d_id' : data_id , 'd_value' : data_value});
				}else{
					$(this).css('background-color','white');
					$(this).css('color', 'black');
					multi_d_array.splice(i,1);
				}
			}
		}));

		$('#d_property').on('click', '.d_property', (function(e) {
			e.preventDefault();
			var property_id = $(this).prop('id');
			$('.d_property').css('background-color','white');
			$('.d_property').css('color', 'black');
			
			$(this).css('background-color','red');
			$(this).css('color', 'white');

			p_sel=$(this).prop('id');
		}));

		$('#tb_sel_data').on('click', '.can_sel', (function(e) {
			e.preventDefault();
			cancel_selected($(this).prop('id'));
		}));

		
		$('#transfer').click(function(e) {
			e.preventDefault();
			display_selected(p_sel);	
		});

		$('#change_import').click(function(e) {
			e.preventDefault();
			window.location = '<?php echo base_url()."Enterprise/excel_import_file/Customers/".$code; ?>';
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			$('.loader').show();
			$.post('<?php echo base_url()."Enterprise/save_excel_data/".$in_id."/".$code; ?>', {
				'btn_array' : btn_array,
				'type' : $('#d_sel_section').val()
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/customers/0/".$code; ?>';
			}, "text");
		});

		$('#add').click(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/save_property/Customers/".$code; ?>', {
				'p_property' : $('#p_name').val()
			}, function(data, status, xhr) {

				var abc = JSON.parse(data);
				$('#d_property').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#d_property').append('<button class="mdl-button mdl-js-button d_property" id="'+abc[i].ip_id+'">'+ abc[i].ip_property +'</button><br></br>');
				}
				$('#p_name').val('');
			}, "text");
		});

		function cancel_selected(id) {
			for (var i = 0; i < btn_array[id]["multi_d_array"].length; i++) {
				d_array.push({'d_id' : btn_array[id]["multi_d_array"][i].d_id, 'd_data' : btn_array[id]["multi_d_array"][i].d_value});
			}

			p_array.push({'p_id' : btn_array[id].p_id, 'p_data' : btn_array[id].p_val});
			btn_array.splice(id, 1);
			data_button_load();
			property_button_load();
			selected_load();	

		}

		function display_selected(p) {
			var sel_d_rm=0, sel_p_rm=0;
			var sel_d_val='', sel_p_val='';

			for (var i = 0; i < p_array.length; i++) {
				if (p==p_array[i].p_id) {
					sel_p_rm=i;
					sel_p_val=p_array[i].p_data;
					break;
				}
			}

			for (var i = 0; i < multi_d_array.length; i++) {
				for (var j = 0; j < d_array.length; j++) {
					if (multi_d_array[i].d_id == d_array[j].d_id) {
						d_array.splice(j, 1);
					}
				}
			}

			btn_array.push({multi_d_array, 'p_id' : p, 'p_val' : sel_p_val});
			p_array.splice(sel_p_rm, 1);
			// console.log(btn_array);
			data_button_load();
			property_button_load();
			selected_load();

			d_sel=0;p_sel=0;
		}

		function selected_load() {
			var tb="";
			for (var i = 0; i < btn_array.length; i++) {
				tb+='<div class="mdl-cell mdl-cell--1-col"><button class="mdl-button mdl-js-button mdl-button--icon can_sel" id="' + i +'" style="width: 100%;"><i class="material-icons">close</i></button></div><div class="mdl-cell mdl-cell--8-col">';
				for (var j = 0; j < btn_array[i]["multi_d_array"].length; j++) {
					 tb+=btn_array[i]["multi_d_array"][j].d_value+' | ' ;
				}
				tb+='</div><div class="mdl-cell mdl-cell--3-col">'+btn_array[i].p_val+'</div>';
			}
			$('#tb_sel_data').empty();
			$('#tb_sel_data').append(tb);
			multi_d_array = [];
		}

		function data_button_load() {
			var a="";
			for (var i = 0; i < d_array.length; i++) {
				a+='<button class="mdl-button mdl-js-button mdl-button--raise d_data" value="'+d_array[i].d_data+'" id="'+d_array[i].d_id+'">'+d_array[i].d_data+'</button><br></br>';	
			}
			$('#d_data').empty();
			$('#d_data').append(a);
		}

		function property_button_load(){
			var out="";
			for (var i = 0; i < p_array.length; i++) {
				
					out+='<button class="mdl-button mdl-js-button d_property" id="'+p_array[i].p_id+'">'+p_array[i].p_data+'</button><br></br>';	
			}
			$('#d_property').empty();
			$('#d_property').append(out);
		}

});
</script>
</html>