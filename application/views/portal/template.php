<style type="text/css">
.pic_button {
	border-radius: 10px;
	box-shadow: 0px 4px 10px #ccc;
	margin: 20px;
	position: relative;
	overflow: hidden;
}
.pic_button input.upload {
	position: absolute;
	top: 0;
	right: 0;
	margin: 0;
	padding: 0;	
	cursor: pointer;
	opacity: 0;
	filter: alpha(opacity=0);
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Add Template</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
								<input type="text" class="mdl-textfield__input" id="title" name="title">
								<label class="mdl-textfield__label" for="title">Enter Template Name</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="domain" name="domain">
									<option value="all">Select</option>
									<?php for ($i=0; $i < count($domain); $i++) { 
										echo "<option value='".$domain[$i]->idom_id."'";
										if(isset($edit_kpi)) {if($edit_kpi[0]->idom_id == $domain[$i]->idom_id) { echo "selected";}}
										echo ">".$domain[$i]->idom_name."</option>";
									} ?>
								</select>
								<label class="mdl-textfield__label" for="domain">Select Domain</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<select class="mdl-textfield__input" id="modules" name="modules">
									<option value="all">Select</option>
									<?php for ($i=0; $i < count($modules); $i++) { 
										echo "<option value='".$modules[$i]->im_id."'";
										if(isset($edit_kpi)) {if($edit_kpi[0]->im_id == $modules[$i]->im_id) { echo "selected";}}
										echo ">".$modules[$i]->im_name."</option>";
									} ?>
								</select>
								<label class="mdl-textfield__label" for="modules">Select Module</label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col" style="text-align: center;">
							<div type="button" class="mdl-button mdl-js-button pic_button">
								<input type="file" name="attach_file" class="upload">
								<i class="material-icons">note</i> Upload Document
							</div>
						</div>
						<div class="mdl-cell mdl-cell--6-col" style="text-align: center;">
							<div type="button" class="mdl-button mdl-js-button pic_button">
								<i class="material-icons">image</i> Upload Image
								<input type="file" name="attach_file" class="upload">
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
							<button class="mdl-button mdl-button--colored" id="submit"><i class="material-icons">save</i> Save</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--6-col" >
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Template Name</th>
						<th class="mdl-data-table__cell--non-numeric">Template File Name</th>
					</tr>
				</thead>
				<tbody >
					<?php for ($i=0; $i < count($template) ; $i++) { 
							echo '<tr id="'.$template[$i]->itemp_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$template[$i]->itemp_title;		
							echo '<td class="mdl-data-table__cell--non-numeric">'.$template[$i]->itemp_file_name;
							echo "</tr>";
					 } ?>
					
				</tbody>
			</table>
		</div>
		</div>
	</div>
</main>
</body>
</html>
<script>
$(document).ready(function() {

	$('#submit').click(function(e){
		e.preventDefault();
		var email = $('#f_email').val();
		$.post('<?php echo base_url()."Portal/add_template/"; ?>',{
			'title' : $('#title').val(),
			'module' : $('#modules').val(),
			'domain' : $('#domain').val()
		}, function(data, status, xhr) {
			file_upload(data);
		}, 'text');
	});

	var datat = new FormData();
	function file_upload(id) {
		for(var i=0; i < $('.upload').length; i++) {
		    if($('.upload')[i].files[0]) {
    		    datat.append(i, $('.upload')[i].files[0]);
		    }
		}
		var url ='<?php echo base_url()."Portal/temp_file_upload/"; ?>'+id;
		flnm = "";
		$.ajax({
			url: url, // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data){
				window.location = "<?php echo base_url().'portal/view_template'; ?>"
			},
			error: function(x,s,e){
				alert('choose proper file');
			} 
		});
	}
});

</script>