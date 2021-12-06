<style type="text/css">
.demo-card-square.mdl-card {
  width: 320px;
  height: 320px;
}
.demo-card-square > .mdl-card__title {
  color: #fff;
  /*background:
  url('../assets/demos/dog.png') bottom right 15% no-repeat #46B6AC;*/
}
#myImg:hover {opacity: 0.10;}
#myModal {
    display: none; /* Hidden by default */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 15%;
    top: 15%;
    width: 70%; /* Full width */
    height: 70%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.img01 {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
#caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}
@media only screen and (max-width: 700px){
    #img01 {
        width: 100%;
    }
}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid loader" style="display: none;">
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<div class="mdl-grid" id="doc_id">
				<?php
				// if (isset($doc_id)) {
				// 	for ($i=0; $i < count($doc_id) ; $i++) { 
				// 		if ($doc_id[$i]->iumdi_variable == "true") {
				// 			echo '<div class="mdl-cell mdl-cell--3-col"><div class="mdl-grid"><div class="mdl-cell mdl-cell--4-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="v'.$i.'">A Variable Value</label><input type="checkbox" id="v'.$i.'" name="v_name[]" class="mdl-textfield__input" checked/></div></div><div class="mdl-cell mdl-cell--8-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="'.$i.'">Enter Section</label><input type="text" id="'.$i.'" name="c_name[]" class="mdl-textfield__input" value="'.$doc_id[$i]->iumdi_doc_syntax.'" /></div></div></div></div>';
				// 		} else if($doc_id[$i]->iumdi_variable == "false") {
				// 			echo '<div class="mdl-cell mdl-cell--3-col"><div class="mdl-grid"><div class="mdl-cell mdl-cell--4-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="v'.$i.'">A Variable Value</label><input type="checkbox" id="v'.$i.'" name="v_name[]" class="mdl-textfield__input"/></div></div><div class="mdl-cell mdl-cell--8-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="'.$i.'">Enter Section</label><input type="text" id="'.$i.'" name="c_name[]" class="mdl-textfield__input" value="'.$doc_id[$i]->iumdi_doc_syntax.'"/></div></div></div></div>';
				// 		}
				// 	}	
				// }
				?>	
			</div>
			<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
				<button class="mdl-button mdl-button--colored mdl-button--raised" id="doc_add">Add Section</button>
				<button class="mdl-button mdl-button--colored mdl-button--raised" id="doc_save">Save</button>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
			<h2>Choose template for <?php echo $mname; ?></h2><hr>
			<div class="mdl-grid" id="temp_list"></div>
		</div>
	</div>
	<div class="mdl-cell mdl-cell--4-col">
    	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit"><i class="material-icons">done</i></button>
  	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
	<div class="mdl-snackbar__text"></div>
	<button class="mdl-snackbar__action" type="button"></button>
</div>

<div id="myModal" class="modal">
	<span class="close">&times;</span>
	<img class="modal-content" id="img01" style="width: 100%;">
	<div id="caption"></div>
</div>

<div class="modal" id="temp_Modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            	<h3>Type of pages you want for this template</h3>
            	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
					<ul id="mutual_tag">
						<?php
							if (isset($temp_cat)) {
								for ($i=0; $i <count($temp_cat) ; $i++) {
									echo "<li>".$temp_cat[$i]->iutc_copies."</li>";
								}
							}
						?>
					</ul>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal" id="temp_save">Save</button>
                <button type="button" class="mdl-button" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
    </div>
</div>
<script type = "text/javascript">
	var temp_arr = [];
	var selected_temp = [];
	var temp_id =[]
	var mid = <?php echo $mid; ?>;
	var s_temp_id;
	var doc_arr = [];
	var document_arr = [];
	var prp_id = 0;
	<?php
		for ($j=0; $j<count($template);$j++) {
			if ($template[$j]->itemp_id == $s_temp) {
				echo "temp_arr.push({'id':'".$template[$j]->itemp_id."','title' : '".$template[$j]->itemp_title."','mid' : '".$template[$j]->itemp_module."', 'file_name' : '".$template[$j]->itemp_file_name."', 'img_name' : '".$template[$j]->itemp_img_name."','selected' : 'select'});";
			}else{
				echo "temp_arr.push({'id':'".$template[$j]->itemp_id."','title' : '".$template[$j]->itemp_title."','mid' : '".$template[$j]->itemp_module."', 'file_name' : '".$template[$j]->itemp_file_name."', 'img_name' : '".$template[$j]->itemp_img_name."','selected' : 'none'});";
			}
      	}

      	for ($i=0; $i < count($doc_id); $i++) {
      		echo "document_arr.push({'id' : '".$i."' , 'doc_id' : '".$doc_id[$i]->iumdi_id."', 'syntax' : '".$doc_id[$i]->iumdi_doc_syntax."' });";
      	}
	?>

	$(document).ready(function(){
		temp_list();
		display_doc_id();
		var snackbarContainer = document.querySelector('#demo-toast-example');

		$('#mutual_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		singleField : true
    	});

		$('#doc_add').click(function(e) {
			e.preventDefault();
			$('#doc_id').append('<div class="mdl-cell mdl-cell--2-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"><select class="mdl-textfield__input sel_doc" id="sel_doc'+prp_id+'"><option value="none">select</option><option value="acc_yr">Accounting year</option><option value="txn_no">Transaction Number</option><option value="txt">Text</option></select></div></div>');
			prp_id++;
		});

		$('#doc_id').on('change','.sel_doc',function (e) {
			e.preventDefault();
			var id = $(this).val();
			if (id == 'txt') {
				$('#doc_id').append('<div class="mdl-cell mdl-cell--2-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="sel_doc'+prp_id+'" class="mdl-textfield__input" style="outline:none;"><label class="mdl-textfield__label">Enter text</label></div></div>');
				prp_id++;
			}
		});

		$('#doc_save').click(function(e) {
			e.preventDefault();
			doc_arr = [];
			for (var i = 0; i < prp_id ; i++) {
				var id = $('#sel_doc'+i).val();
				if (id != 'txt' && id != 'none') {
					doc_arr.push({'id':i, 'val' : id});
				}
			}
			// console.log(doc_arr);
			// console.log(prp_id);
			$.post('<?php echo base_url()."Enterprise/save_module_doc/".$code."/".$mid; ?>', {
				'mid' : mid,
				"doc_variable" : doc_arr
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url().$dom_loc."/".$fname."/".$mid."/".$code; ?>';
			}, "text");
		});

		$('#temp_list').on('click','.myImg',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			var iname = '';
			for (var i = 0; i < temp_arr.length; i++) {
				if(temp_arr[i].id == id){
					iname = temp_arr[i].img_name;
				}
			}
			var path = "<?php echo base_url().'assets/data/portal/template/'; ?>"+iname;
			$('#img01').prop('src',path);
			$('#myModal').show();
		});

		$('#myModal').on('click','.close',function (e) {
			e.preventDefault();
			$('#myModal').hide();
		});

		$('#temp_Modal').on('click','#close',function (e) {
			e.preventDefault();
			$('#temp_Modal').hide();
		});

		$('#temp_list').on('click','.choose',function (e) {
			e.preventDefault();
			temp_id = $(this).prop('id');
			$('#temp_Modal').show();
		});

		$('#temp_Modal').on('click','#temp_save',function (e) {
			e.preventDefault();
			var mutual = [];
			$('#mutual_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					mutual.push(tmpstr1);
				}
			});
			$.post('<?php echo base_url()."Enterprise/save_template_copies/".$code; ?>', {
        		'tid' : temp_id,
        		'mid' : mid,
        		'copies' : mutual
        	}, function(data, status, xhr) {
        		window.location = '<?php echo base_url().$dom_loc."/".$fname."/".$mid."/".$code;?>';
        	});
		});

		function display_doc_id() {
			var a = '';
			for (var i = 0; i < document_arr.length; i++) {
				a += '<div class="mdl-cell mdl-cell--2-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;"><select class="mdl-textfield__input sel_doc" id="sel_doc'+prp_id+'">';
				a += '<option value="none">select</option>';
					if (document_arr[i].syntax == 'acc_yr' ) {
						a += '<option value="acc_yr" selected>Accounting year</option>';
						a += '<option value="txn_no">Transaction Number</option>';
						a += '<option value="txt">Text</option>';
					}else if (document_arr[i].syntax == 'txn_no' ) {
						a += '<option value="acc_yr">Accounting year</option>';
						a += '<option value="txn_no" selected>Transaction Number</option>';
						a += '<option value="txt">Text</option>';
					}else{
						a += '<option value="acc_yr">Accounting year</option>';
						a += '<option value="txn_no">Transaction Number</option>';
						a += '<option value="txt" selected>Text</option>';
					}
					a+='</select></div></div>';
				prp_id++;
				if(document_arr[i].syntax != 'acc_yr' && document_arr[i].syntax != 'txn_no'){
					a+= '<div class="mdl-cell mdl-cell--2-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="sel_doc'+prp_id+'" class="mdl-textfield__input" style="outline:none;" value = "'+document_arr[i].syntax+'" ><label class="mdl-textfield__label">Enter text</label></div></div>';
					prp_id++;
				}
			}
			$('#doc_id').empty();
			$('#doc_id').append(a);
		}

		function temp_list() {
			var a ='';
			for (var i = 0; i < temp_arr.length; i++) {
				a +='<div class="mdl-cell mdl-cell--4-col"><div class="demo-card-square mdl-card mdl-shadow--2dp">';
				a+='<div class="mdl-card__title mdl-card--expand myImg" id="'+temp_arr[i].id+'" style="background:url(<?php echo base_url().'assets/data/portal/template/'; ?>'+temp_arr[i].img_name+');background-size: cover;"><h2 class="mdl-card__title-text" style="color:black;">'+temp_arr[i].title+'</h2></div><div class="mdl-card__actions mdl-card--border" style="text-align:center;">';
				if (temp_arr[i].selected == 'select') {
					s_temp_id = temp_arr[i].id;
					a+='<button class="mdl-button mdl-button--colored mdl-button--raised choose" id="'+temp_arr[i].id+'">Selected</button>';
				}else{
					a+='<button class="mdl-button mdl-button--colored choose" id="'+temp_arr[i].id+'">Choose</button>';
				}
				a+='</div></div></div>';
			}
			$('#temp_list').empty();
			$('#temp_list').append(a);
		}
	});
</script>

