<!DOCTYPE>
<html>
<head>
<script src="<?php echo base_url().'assets/js/jquery.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/material.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.min.css'; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material_icon.css'; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/material.red-deep_orange.min.css'; ?> ">
<script src="<?php echo base_url().'assets/js/moment-with-locales.min.js'; ?>" type="text/javascript" charset="utf-8"></script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style type="text/css">
    html, body ,h1 ,h2 ,h3 ,h4 ,h5 ,h6 {
        font-family: 'Muli', sans-serif !important;
    }
	.general_table {
		width: 100%;
        text-align: left;
        border: 0px solid #ccc;
        border-collapse: collapse;
        
	}

	@media only screen and (max-width: 760px) {
		.general_table {
			display: block;
        	overflow: auto;
		}
	}

	.general_table > thead > tr {
		box-shadow: 0px 5px 5px #ccc;
	}

	.general_table > thead > tr > th {
		padding: 10px;
	}

	.general_table > tbody > tr {
		border-bottom: 1px solid #ccc;
	}

	.general_table > tbody > tr > td {
		padding: 15px;
	}
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

	.suspend_icon{
		font-size: 1000%;
		font-weight: lighter;
		-webkit-text-stroke: 6px white;
	}
</style>
</head>
<body>
<main class="mdl-layout__content" style="width: 100%;height: 100%;background-color: rgb(203, 104, 106);">
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid" style="padding: 30px;">
		<div class="mdl-cell mdl-cell--8-col" style="padding: 30px;color: #fff;"><h2 style="font-size: 3em;"><?php echo $edit_boq[0]->iextetboq_title; ?></h2></div>
		<div class="mdl-cell mdl-cell--4-col"><img style="margin: auto;width: 100%;height: auto;" src="<?php if(isset($logo)) echo base_url().'assets/uploads/'.$oid.'/'.$logo; ?>"></div>
		<div class="mdl-cell mdl-cell--12-col form info_arr w3-animate-left" style="background-color: #fff;border-radius: 15px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff;border-radius: 10px; padding: 20px;">
		    		<h4>Enter Following Details</h4>
		    		<hr>
		    		<p>( * required field )</p>
		    		<div style="text-align: center;padding: 30px;height: 50%;overflow: auto;">
		    		<?php
		    			for ($i=0; $i < count($info_arr) ; $i++) {
		    				echo '<div>';
		    				if ($info_arr[$i]->status == 'true') {
		    					echo '*&nbsp&nbsp <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="info'.$info_arr[$i]->id.'" class="mdl-textfield__input info_text" style="outline: none;" required >';
		    				}else{
		    					echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="info'.$info_arr[$i]->id.'" class="mdl-textfield__input info_text" style="outline: none;">';
		    				}
							echo '<label class="mdl-textfield__label" for="i_wrnty">Enter '.$info_arr[$i]->text.'</label></div></div>';
		    			}
		    		?>
		    		</div>
		    	</div>
				<div class="mdl-cell mdl-cell--6-col" style="background-color: #fff;border-radius: 10px; padding: 20px;">
		    		<h4>Upload Following Documents</h4>
		    		<hr>
		    		<div style="text-align: left;padding: 30px;height: 50%;overflow: auto;">
			    		<?php
			    			for ($i=0; $i < count($req_arr) ; $i++) {
			    				echo '<div style="display:flex;width:100%;">';
			    				echo '<div class="mdl-cell mdl-cell--3-col upload-btn-wrapper" style="width: 70%;"><div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button"><i class="material-icons">note</i>Upload '.$req_arr[$i]->text.'<input type="file" name="file[]" data-uid="'.$req_arr[$i]->id.'" id="upload'.$req_arr[$i]->id.'" class="upload proposal_doc"></div></div>';
			    				echo '<p style="width: 30%;padding:5%;" class="file_uplaod'.$req_arr[$i]->id.'"></p>';
			    				echo '</div>';
			    			}
			    		?>
		    		</div>
		    	</div>
		    	<div class="mdl-cell mdl-cell--12-col" style="text-align: right;">
	    			<button class="mdl-button mdl-button--colored div_1" style="background-color: green;color: #fff;">Next</button>
	    		</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col form table_arr w3-animate-left" style="background-color: #fff;border-radius: 15px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px; padding: 20px;">
					<h4>Enter empty filed</h4>
		    		<hr>
		    		<div style="text-align: center;padding: 30px;height: 50%;overflow: auto;">
			    		<?php
				    		echo '<table class="general_table">';
				            for ($i = 0; $i < count($table_arr); $i++) {
				                if ($table_arr[$i]->level == 1) {
				                    echo '<thead>';
				                    echo '<tr>';
				                    for ($ij = 0; $ij < count($table_arr[$i]->row_data); $ij++) {
				                    	echo '<th style="outline:none;min-width:200px;width:200px;word-break: break-all;background-color:#ccc;border:1px solid #000;" class="td'.$i.$ij.'">'.$table_arr[$i]->row_data[$ij]->data.'</th>';
				                    }
				                    echo '</tr></thead>';
				                }else{
				                    echo '<tbody><tr>';
				                    for ($ij = 0; $ij < count($table_arr[$i]->row_data); $ij++) {
				                    	if ($table_arr[$i]->row_data[$ij]->data == null) {
				                    		echo '<td style="outline:none;min-width:200px;width:200px;word-break: break-all;border:1px solid #000;" ><input value="'.$table_arr[$i]->row_data[$ij]->data.'" class="td'.$i.$ij.'" style="border:0px;outline:none;font-size:0.9em;"></td>';
				                    	}else{
				                    		echo '<td style="outline:none;min-width:200px;width:200px;word-break: break-all;border:1px solid #000;" class="td'.$i.$ij.'">'.$table_arr[$i]->row_data[$ij]->data.'</td>';
				                    	}
				                    }
				                    echo '</tr></tbody>';
				                }
				            }
				            echo '</table>';
			    		?>
			    	</div>
	    		</div>
	    		<div class="mdl-cell mdl-cell--12-col" style="text-align: right;">
	    			<button class="mdl-button mdl-button--colored div_2_back" style="background-color: green;color: #fff;">Back</button>
	    			<button class="mdl-button mdl-button--colored div_2" style="background-color: green;color: #fff;">Next</button>
	    		</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col form note_arr w3-animate-left" style="background-color: #fff;border-radius: 15px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px; padding: 20px;">
					<h4>Add note if any</h4>
		    		<hr>
		    		<div style="text-align: center;padding: 30px;height: 50%;overflow: auto;">
			    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							<textarea id="boq_note" class="mdl-textfield__input" rows= "5"></textarea>
							<label class="mdl-textfield__label" for="boq_note">Enter Note</label>
						</div>
			    	</div>
	    		</div>
	    		<div class="mdl-cell mdl-cell--12-col" style="text-align: right;">
	    			<button class="mdl-button mdl-button--colored div_3_back" style="background-color: green;color: #fff;">Back</button>
	    			<button class="mdl-button mdl-button--colored boq_submit" style="background-color: green;color: #fff;">Submit</button>
	    		</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col form sucess_arr w3-animate-left" style="background-color: #fff;border-radius: 15px;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px;padding: 20px;">
					<div style="text-align: center;padding: 30px;height: 50%;overflow: auto;">
						<i class="material-icons suspend_icon">mood</i>
	                	<h2>Successfully submitted !</h2>
					</div>
	    		</div>
	    		<div class="mdl-cell mdl-cell--12-col" style="text-align: right;">
	    		</div>
			</div>
		</div>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
</body>
<script type="text/javascript">
	var table_arr = [];
	var row_p_id = 0;
	var level_id = 1;
	var info_form_arr = [];
	var info_flg = 0;
	var req_arr = [];
	var req_flg = 0;
	<?php
		for ($i=0; $i <count($table_arr) ; $i++) {
            echo "table_arr.push({'id' : '".$table_arr[$i]->id."' , 'title' : '' , 'level' : '".$table_arr[$i]->level."' , 'full_width' : '".$table_arr[$i]->full_width."' , 'row_data' : [] });";
            for ($ij=0; $ij <count($table_arr[$i]->row_data) ; $ij++) {
                echo "table_arr[".$i."]['row_data'].push({'data' : '".$table_arr[$i]->row_data[$ij]->data."'});";
            }
            echo "row_p_id++;";
            echo "level_id++;";
        }

        for ($i=0; $i <count($info_arr) ; $i++) {
            echo "info_flg++;";
            echo "info_form_arr.push({'id' : '".$info_arr[$i]->id."' , 'text' : '".$info_arr[$i]->text."', 'status' : '".$info_arr[$i]->status."' , 'val' : ''});";
        }

        for ($i=0; $i <count($req_arr) ; $i++) {
            echo "req_flg++;";
            echo "req_arr.push({'id' : '".$req_arr[$i]->id."' , 'text' : '".$req_arr[$i]->text."' , 'upload_id' : ''});";
        }
	?>
	$(document).ready(function(){
		var snackbarContainer = document.querySelector('#demo-toast-example');
		$('.proposal_doc').change(function(e){
			e.preventDefault();
			var id = $(this).data('uid');
			$('.file_uplaod'+id).empty();
			$('.file_uplaod'+id).append('1 file selected.');
		});

		var slideIndex = 1;
		showDivs(slideIndex);
		function plusDivs(n) {
			showDivs(slideIndex += n);
		}
		function showDivs(n) {
		  var i;
		  var x = document.getElementsByClassName("form");
		  if (n > x.length) {slideIndex = 1} 
		  if (n < 1) {slideIndex = x.length} ;
		  for (i = 0; i < x.length; i++) {
		    x[i].style.display = "none";
		  }
		  x[slideIndex-1].style.display = "block";
		}

		$('.div_1').click(function(e){
			e.preventDefault();
			var flg_s = 0;
			for (var i = 0; i < info_form_arr.length; i++) {
            	var id = info_form_arr[i].id;
            	var status = $('#info'+id).prop('required');
            	var val = $('#info'+id).val();
            	if (status == true && val == '') {
            		flg_s++;
            	}
            }
            if (flg_s > 0 ) {
            	var data = {message: 'Please enter all ( * ) details !'};
	    		snackbarContainer.MaterialSnackbar.showSnackbar(data);
            }else{
            	slideIndex++;
				showDivs(slideIndex);
            }
		});

		$('.div_2_back').click(function(e){
			e.preventDefault();
			slideIndex--;
			showDivs(slideIndex);
		});

		$('.div_2').click(function(e){
			e.preventDefault();
			slideIndex++;
			showDivs(slideIndex);
		});

		$('.div_3_back').click(function(e){
			e.preventDefault();
			slideIndex--;
			showDivs(slideIndex);
		});

		$('.boq_submit').click(function(e){
			e.preventDefault();
			$('.loader').show();
			var datat = new FormData();
			var ins_flg = 0;
			for (var i = 0; i < req_arr.length; i++) {
				ins = $('.proposal_doc')[i].files.length;
				if (ins > 0 ) {
					ins_flg++;
		            datat.append("used[]", $('.proposal_doc')[i].files[0]);
		            req_arr[i].upload_id = i;
		        }
			}
			if (ins_flg > 0 ) {
				$.ajax({
					url: "<?php echo base_url().'BOQ/boq_doc_upload/'.$oid."/".$boq_id."/".$inid."/";?>",
					type: "POST",             // Type of request to be send, called as method
					data: datat, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(d)   // A function to be called if request succeeds
					{
						var a = JSON.parse(d);
						var flg = 0;
						for (var ij = 0; ij < req_arr.length; ij++) {
							if (req_arr[ij].upload_id == ij) {
								req_arr[ij].upload_id = a.upload_id[flg];
								flg++;
							}
						}
						data_submit();
					}
				});
			}else{
				data_submit();
			}
		});

		function data_submit(){
			for (var i = 0; i < table_arr.length; i++) {
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    if (table_arr[i]['row_data'][ij]['data'] == '' ) {
                    	var txt = $('.td'+i+ij).val();
	                    if (txt == '') {
	                        txt = null;
	                    }
	                    table_arr[i]['row_data'][ij]['data'] = txt;
                    }
                }
            }
            for (var i = 0; i < info_form_arr.length; i++) {
            	var id = info_form_arr[i].id;
            	var val = $('#info'+id).val();
            	if (info_form_arr[i].id == id) {
            		info_form_arr[i].val = val;
            	}
            }

			var url = "<?php echo base_url().'BOQ/boq_res_submit/'.$oid."/".$boq_id."/".$inid;?>";
			$.post(url,{
				'table_arr' : table_arr,
				'info_arr' : info_form_arr,
				'req_arr' : req_arr,
				'note' : $('#boq_note').val()
			},function(data,xhr,status){
				$('.loader').hide();
				slideIndex++;
				showDivs(slideIndex);
			},'text');
		}
	});
</script>
</html>