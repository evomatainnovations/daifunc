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
		<div class="mdl-cell mdl-cell--6-col mdl-shadow--4dp" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<input type="text" id="t_title" class="mdl-textfield__input" <?php if(isset($temp_title)){echo 'value="'.$temp_title.'";';}else{ echo 'placeholder= "Enter title";';}?> style="font-size: 3em;outline: none;">
		</div>
		<div class="mdl-cell mdl-cell--6-col mdl-shadow--4dp" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;">
			<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
				<i class="material-icons">attach_file</i> Choose file
				<input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
			</div>
			<div class="mdl-grid" id="display_doc"></div>
		</div>
		<?php
			if (isset($temp_title)) {
				echo '<div class="mdl-cell mdl-cell--12-col"><div class="mdl-grid"><div class="mdl-cell--6-col" style="text-align: center;"><button class="mdl-button mdl-button--colored delete_temp"><i class="material-icons">delete</i> Delete</button></div></div></div>';
			}
		?>
		<textarea class="mdl-cell mdl-cell--6-col mdl-shadow--4dp" id="t_body" placeholder= "Enter Content" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;border-width: 0px;outline: none; padding: 30px;height: 70vh;overflow: auto;font-size: 2em;"><?php if (isset($temp_content)) {echo $temp_content;}?></textarea>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent"  id="submit_email_temp"><i class="material-icons">done</i></button>
	</div>
</main>

<script type="text/javascript">
	var doc_arr = [];
	<?php
		if (isset($files)) {
			for ($i=0; $i < count($files) ; $i++) { 
				echo "doc_arr.push({'id' : '".$files[$i]->icd_id."' , 'name' : '".$files[$i]->icd_file."' , 'flg' : 'true' });";
			}
		}
	?>
$(document).ready( function() {
	display_doc();
	var snackbarContainer = document.querySelector('#demo-toast-example');

	$('#submit_email_temp').click(function(e) {
		var note = $('#t_body').val();
		e.preventDefault();
		$.post('<?php if (isset($temp_title)) { echo base_url()."Account/email_temp_update/".$temp_id."/".$code; }else{ echo base_url()."Account/email_temp_save/".$code; } ?>',{
			't_title': $('#t_title').val(),
			't_body':note,
			'doc_arr' : doc_arr
		}, function(data, status, xhr) {
			window.location="<?php echo base_url().'Account/email_template/'.$code; ?>";
		}, "text");
	});

	$('.delete_temp').click(function(e) {
		e.preventDefault();
		$.post('<?php if (isset($temp_title)) { echo base_url()."Account/delete_email_temp/".$temp_id."/".$code; } ?>'
		, function(data, status, xhr) {
			window.location="<?php echo base_url().'Account/email_template/'.$code; ?>";
		}, "text");
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

    $('.upload').change(function (e) {
		e.preventDefault();
		var datat = new FormData();
        var ins = $('.proposal_doc')[0].files.length;
        for (var x = 0; x < ins; x++) {
            datat.append("used[]", $('.proposal_doc')[0].files[x]);
        }
		$.ajax({
			url: "<?php echo base_url().'Account/email_template_attach/'.$code.'/';?>", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{	
				var a = JSON.parse(data);
				doc_arr = [];
				for (var i = 0; i < a.files.length; i++) {
					doc_arr.push({ id : a.files[i].icd_id , name : a.files[i].icd_file , flg : 'true' });
				}
				display_doc();
			}
		});
	});

	$('#display_doc').on('click','.delete_doc',function (e) {
		e.preventDefault();
		var id = $(this).prop('id');
		for (var i = 0; i < doc_arr.length; i++) {
			if(doc_arr[i].id == id){
				doc_arr[i].flg = 'false';
			}
		}
		display_doc();
	});

    function display_doc() {
    	var out = '';
    	for (var i = 0; i < doc_arr.length; i++) {
    		if (doc_arr[i].flg == 'true') {
    			out += '<span class="mdl-chip mdl-chip--deletable" style="margin-left:20px;"><span class="mdl-chip__text">'+doc_arr[i].name+'</span><button type="button" class="mdl-chip__action delete_doc" id="'+doc_arr[i].id+'"><i class="material-icons">cancel</i></button></span>';
    		}
    	}

    	$('#display_doc').empty();
    	$('#display_doc').append(out);
    }

});	
</script>
</html>