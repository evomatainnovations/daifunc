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
</style>
<main>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-grid">
				<table class="general_table">
					<thead>
						<th>Sr. No.</th>
						<th>Device Name</th>
						<th>Serial Number</th>
						<th>Location</th>
					</thead>
					<tbody class="device_list"></tbody>
				</table>
			</div>
		</div>
		<button class="mdl-button mdl-button--colored mdl-button--fab lower-button add_devices"><i class="material-icons">add</i></button>
	</div>
</main>
<div class="modal fade" id="device_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h3 style="text-align: center;">Add device</h3>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" id="d_name" type="text">
				    <label class="mdl-textfield__label" for="d_name">Enter device name</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" id="d_loc" type="text">
				    <label class="mdl-textfield__label" for="d_loc">Enter location</label>
				</div>
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input class="mdl-textfield__input" id="d_sn" type="text">
				    <label class="mdl-textfield__label" for="d_sn">Enter serial number</label>
				</div>
			</div>
			<div class="modal-footer">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--6-col">
						<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="delete_device" style="display: none;"><i class="material-icons">delete</i> delete</button>	
					</div>
					<div class="mdl-cell mdl-cell--6-col">
						<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="save_device"><i class="material-icons">save</i> save</button>
						<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal"><i class="material-icons">close</i> close</button>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var device_arr = [] ;
	var edit_flg = 0;
	var edit_id = 0 ;
	<?php
			if (isset($d_list)) {
				for ($i=0; $i < count($d_list) ; $i++) {
					echo "device_arr.push({'id' : '".$d_list[$i]->iu_d_id."' , 'name' : '".$d_list[$i]->iu_d_name."' , 'sn' : '".$d_list[$i]->iu_d_serial_number."' , 'loc' : '".$d_list[$i]->iu_d_location."' });";
				}
			}
	?>
	$(document).ready( function() {
		display_list();
		$('.add_devices').click(function (e) {
			e.preventDefault();
			edit_flg = 0;
			$('#d_name').val("");
			$('#d_loc').val("");
			$('#d_sn').val("");
			$('#delete_device').css('display','none');
			$('#device_modal').modal('show');
		});

		$('.device_list').on('click','.edit_device',function (e) {
			e.preventDefault();
			$('#delete_device').css('display','block');
			id = $(this).prop('id');
			edit_id = device_arr[id].id;
			edit_flg = 1;
			$('#d_name').val("");
			$('#d_loc').val("");
			$('#d_sn').val("");
			$('#d_name').val(device_arr[id].name);
			$('#d_loc').val(device_arr[id].loc);
			$('#d_sn').val(device_arr[id].sn);
			$('#device_modal').modal('show');
		});

		$('#delete_device').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Account/delete_device/".$code."/"; ?>'+edit_id
			,function(data, status, xhr) {
				var a = JSON.parse(data);
				device_arr = [];
				if (a.d_list.length > 0 ) {
					for (var i = 0; i < a.d_list.length; i++) {
						device_arr.push({id : a.d_list[i].iu_d_id , name : a.d_list[i].iu_d_name , sn : a.d_list[i].iu_d_serial_number , loc : a.d_list[i].iu_d_location });
					}
				}
				display_list();
			});
		});

		$('#save_device').click(function (e) {
			e.preventDefault();
			if (edit_flg == 0 ) {
				var url = '<?php echo base_url()."Account/save_device/".$code."/"; ?>';
			}else{
				var url = '<?php echo base_url()."Account/update_device/".$code."/"; ?>'+edit_id;
			}
			$.post(url,{
				'd_name' : $('#d_name').val(),
				'd_loc' : $('#d_loc').val(),
				'd_sn' : $('#d_sn').val()
			},function(data, status, xhr) {
				var a = JSON.parse(data);
				if (a.d_list.length > 0 ) {
					device_arr = [];
					for (var i = 0; i < a.d_list.length; i++) {
						device_arr.push({id : a.d_list[i].iu_d_id , name : a.d_list[i].iu_d_name , sn : a.d_list[i].iu_d_serial_number , loc : a.d_list[i].iu_d_location });
					}
				}
				display_list();
			});
		});

		var a_flg = 'false';
        
        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

		function display_list() {
			var out = '';
			var srno = 1;
			if (device_arr.length > 0 ) {
				for (var i = 0; i < device_arr.length; i++) {
					out += '<tr class="edit_device" id="'+i+'"><td>'+srno+'</td><td>'+device_arr[i].name+'</td><td>'+device_arr[i].sn+'</td><td>'+device_arr[i].loc+'</td></tr>';
					srno++;
				}
			}else{
				out += '<tr><td colspan="4"><h3 style="text-align:center;">No device found !</h3></td></tr>';
			}
			$('.device_list').empty();
			$('.device_list').append(out);
		}
	});
</script>