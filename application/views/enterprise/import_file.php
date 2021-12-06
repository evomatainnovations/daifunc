<style type="text/css">
	.pic_button {
		/*height: 100px;*/
		border-radius: 10px;
		box-shadow: 0px 4px 10px #ccc;
		margin: 20px;
		position: relative;
		overflow: hidden;
		/*margin: 10px;*/
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
		<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
			<h4>Import file for adding a <?php echo $thing; ?> details</h4>
			<p>Note: Supported file formats .csv , .xls</p>
			<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
				<i class="material-icons">attach_file</i> Choose file
				<input type="file" name="attach_file" class="upload" id="profile_pic">
			</div>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col u_bar" style="display: none;text-align: center;">
			<div class="progress">
			    <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:40%;background-color: #4CAF50"></div>
			</div>
			<h3 style="color: green;display: none;" id="success">File upload succesfully !</h3>
		</div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col submit" style="display: none;text-align:" >
			<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" id="submit" >Proceed <i class="material-icons">arrow_forward_ios</i></button>
		</div>
	</div>
</body>
</main>
<script>
	$(document).ready(function() {
		var id = '';
		$('.upload').change(function (e) {
			e.preventDefault();
			$('.u_bar').css('display','block');
			var datat = new FormData();
			datat.append("use", $('.upload')[0].files[0]);
			flnm = "";
			$.ajax({
				url:"<?php echo base_url()."Enterprise/excel_upload_file/".$code; ?>",
				type: "POST",
				data: datat, 
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){
					var ik = 40;
					for (var i = Number(ik); i < 100; i++) {
						$('.active').css('width',i+'%');
						ik = Number(ik)+1;
						if (ik == 100) {
							$('.submit').css('display','block');
							$('.submit').css('text-align','center');
							$('#success').css('display','block');
						}
					}
					id = data;
				}
			});
		});

		$('#submit').click(function(e) {
			window.location = '<?php echo base_url()."Enterprise/read_excel/".$code."/"; ?>' + id;
		});
	});
</script>
</html>