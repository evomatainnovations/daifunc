<style>
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
<main class="mdl-layout__content" style="z-index:3;">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
			<h4>Upload project documents</h4>
			<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
				<i class="material-icons">attach_file</i> Choose file
				<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
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
	<hr>
	<div class="mdl-grid" id="folders"></div>
</main>
</body>
<script>
var doc_arr = [];
<?php
    if (isset($doc)) {
        for ($i=0; $i <count($doc) ; $i++) { 
            echo "doc_arr.push({'id' : '".$doc[$i]->icd_id."', 'cid' : '".$doc[$i]->icd_cid."', 'file' : '".$doc[$i]->icd_file."','owner' : '".$doc[$i]->icd_owner."', 'file_id' : '".$doc[$i]->icd_timestamp."'});";
        }
    }
?>
$(document).ready(function() {
doc_display();
	
	$('.upload').change(function (e) {
		e.preventDefault();
		$('.u_bar').css('display','block');
		var datat = new FormData();
		var ins = $('.proposal_doc')[0].files.length;
		flnm = "";
		for (var x = 0; x < ins; x++) {
            datat.append("used[]", $('.proposal_doc')[0].files[x]);
        }
		$.ajax({
			url:"<?php echo base_url()."Projects/project_upload_file/".$code."/".$pid; ?>",
			type: "POST",
			data: datat, 
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				var a = JSON.parse(data);
				doc_arr = [];
				for (var i = 0; i < a.doc.length; i++) {
					doc_arr.push({id : a.doc[i].icd_id, cid : a.doc[i].icd_cid, file : a.doc[i].icd_file,owner : a.doc[i].icd_owner, file_id : a.doc[i].icd_timestamp});	
				}
				var ik = 40;
				for (var i = Number(ik); i < 100; i++) {
					$('.active').css('width',i+'%');
					ik = Number(ik)+1;
					if (ik == 100) {
						$('#success').css('display','block');
					}
				}
				id = data;
				doc_display();
			}
		});
	});

	$('#folders').on('click','.document',function(e){
        e.preventDefault();
        var fid = $(this).prop('id');
        window.location = "<?php echo base_url()."Account/doc_download/".$code."/"; ?>"+ doc_arr[fid].file_id ;
    });
	function doc_display() {
		var out ='';
        var path = '';
		if (doc_arr.length > 0) {
            for (var i = 0; i < doc_arr.length; i++) {
                var oid ='';

                path = "<?php echo base_url().'assets/uploads/'.$oid.'/';?>"+doc_arr[i].file_id;

                out += '<div class="mdl-cell mdl-cell--2-col document" id="'+i+'"><a href="#sign_up" id="'+i+'"><div class="mdl-card__title mdl-card--expand" style="background: linear-gradient(0deg,rgba(0,0,0,0.5),rgba(200, 15, 15, 0.3)),url('+path+');background-size: contain;width: 256px;background-repeat: no-repeat;height: 256px;"><h2 class="mdl-card__title-text">'+doc_arr[i].file+'</h2></div></a></div>';

            }
        	$('#folders').empty();
        	$('#folders').append(out);    
        }else{
            out += '<div class="mdl-cell mdl-cell--12-col" style="text-align:center;"><h3>No records found !!</h3></div>';
            $('#folders').empty();
        	$('#folders').append(out);	
        }
        

	}
})
</script>
</html>