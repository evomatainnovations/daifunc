<style type="text/css">
	.general_table {
		width: 100%;
        text-align: left;
        font-size: 1em;
    }

	@media only screen and (max-width: 760px) {
		.general_table {
			display: block;
        	overflow: auto;
		}
	}

	.general_table > thead > tr > th {
		padding: 10px;
	}
	.general_table > tbody > tr > td {
		padding: 15px;
	}

	.general_table > tfoot > tr > td {
		padding: 10px;
	}

	.module_body {
		border:1px solid #ccc;
		height: 700px;
		outline: none;
		padding: 10px;
		border-radius: 10px;
		box-shadow: 0px 3px 5px #ccc inset;
		overflow-y: auto;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<input type="text" id="title" name="title" class="mdl-textfield__input" value="<?php if(isset($collection)) { echo $collection[0]->iec_title; } ?>" placeholder="Enter Title" style="font-size: 3em;outline: none;">
					<input type="text" id="cat1" name="cat1" class="mdl-textfield__input" value="<?php if(isset($collection)) { echo $collection[0]->iec_cat1; } ?>" placeholder="Enter Cat1" style="font-size: 1.5em;outline: none;margin-top: 5%;">
					<input type="text" id="cat2" name="cat2" class="mdl-textfield__input" value="<?php if(isset($collection)) { echo $collection[0]->iec_cat2; } ?>" placeholder="Enter Cat2" style="font-size: 1.5em;outline: none;margin-top: 5%;">
					<h4 style="margin-top: 5%;">Add background image
						<input type="file" name="file[]" id="multiFiles" class="upload" multiple style="">
					</h4>
					<?php if (isset($collection)) {
					echo '<button class="mdl-button mdl-button--colored e_delete"><i class="material-icons">delete</i> delete</button>';
					} ?>
				</div>
				<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<table class="general_table">
						<thead>
							<th>Module</th>
							<th style="text-align: center;">Action</th>
						</thead>
						<tbody id="store">
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
					<h4>Add HTML body</h4>
					<textarea class="module_body" style="width: 100%;font-size: 1.2em;"><?php if(isset($content)){echo $content;} ?></textarea>
				</div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent add"><i class="material-icons">add</i></button>
	</div>
</main>
</div>
</body>
<script>
	var module_arr = [];
	var col_arr = [];
	var edit_flg = 0;
	<?php
			if (isset($modules)) {
				for ($i=0; $i <count($modules) ; $i++) { 
					echo "module_arr.push({'id' : ".$modules[$i]->im_id.", 'name' : '".$modules[$i]->im_name."', 'status' : 'close'});";
				}
			}
			if (isset($collection)) {
				for ($i=0; $i <count($collection) ; $i++) { 
					echo "col_arr.push({'id' : '".$collection[$i]->iecm_mid."'});";
					echo "edit_flg = 1;";
				}
			}

	?>
	$(document).ready(function() {
		if (edit_flg == 1) {
			for (var i = 0; i < module_arr.length; i++) {
				for (var j = 0; j < col_arr.length; j++) {
					if (module_arr[i].id == col_arr[j].id) {
						module_arr[i].status = 'add';
					}
				}
			}
		}
		load();
		$('.add').click(function(e) {
			e.preventDefault();
			$.post("<?php if (isset($collection)) { echo base_url().'Portal/update_explore_collection/'.$tid; }else{ echo base_url().'Portal/save_explore_collection'; } ?>", {
				'title' : $('#title').val(),
				'module' : module_arr,
				'html_body' : $('.module_body').val(),
				'cat1' : $('#cat1').val(),
				'cat2' : $('#cat2').val()
			}, function(data, status, xhr) {
				uploadfiledata(data);
			})			
		});

		$('.e_delete').click(function (e) {
			e.preventDefault();
			window.location = '<?php if (isset($collection)) { echo base_url()."Portal/delete_explore_collection/".$tid; } ?>';
		});

		$('#store').on('click','.action',function(e) {
			e.preventDefault();
			var id = $(this).prop('id');
			
			for (var i = 0; i < module_arr.length; i++) {
				if(module_arr[i].id == id){
					if (module_arr[i].status == 'close') {
						module_arr[i].status = 'add';
					}else{
						module_arr[i].status = 'close';
					}
				}
			}
			load();
		});

		function uploadfiledata(stid) {
			var datat = new FormData();
			if($('.upload')[0].files[0]) {
				// console.log('true');
				datat.append("used", $('.upload')[0].files[0]);
				
				flnm = "";
				$.ajax({
					url: "<?php echo base_url().'Portal/collection_file_upload/'; ?>" + stid, // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						window.location = '<?php echo base_url()."Portal/explore_collection"; ?>';
					}
				});
			} else {
				// console.log('false');
				window.location = '<?php echo base_url()."Portal/explore_collection"; ?>';
			}
		}

		function load(){
			var out = '';
			
			for (var i = 0; i < module_arr.length; i++) {

				out+= '<tr class="click_module">';
				out+= '<td>'+module_arr[i].name+'</td><td style="text-align:center;">';
				if (module_arr[i].status == 'add') {
					out+='<button class="mdl-button mdl-button--raised mdl-button--colored action" id="'+module_arr[i].id+'">';
				}else{
					out+='<button class="mdl-button mdl-button--raised action" id="'+module_arr[i].id+'">';
				}
				out+='<i class="material-icons">'+module_arr[i].status+'</i></button>';
				out+= "</td></tr>";
			}
			$('.general_table > tbody').empty();
			$('.general_table > tbody').append(out);
			
		}
	});
</script>

</html>