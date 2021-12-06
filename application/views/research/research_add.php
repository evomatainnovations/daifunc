<style>
	.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.active, .accordion:hover {
    background-color: #ccc;
    border-radius: 10px;
}

.panel {
    /*padding: 0 18px;*/
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}

</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-textfield mdl-js-textfield">
			    <input class="mdl-textfield__input" type="text" id="re_title" value="<?php if(isset($edit_research)) echo $edit_research[0]->iextre_title; ?>">
				<label class="mdl-textfield__label" for="re_title">Research Title</label>
			</div>
			<?php if (isset($edit_research)) {
				echo '<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored save_title">Update</button>';
			}?>
		</div>

	</div>	
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
        <div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Node Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield">
					    <input class="mdl-textfield__input" type="text" id="n_title">
					    <label class="mdl-textfield__label" for="n_title">Title</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
					    <input class="mdl-textfield__input" type="text" id="n_link">
					    <label class="mdl-textfield__label" for="n_link">Link</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
					    <textarea class="mdl-textfield__input" type="text" rows= "5" id="n_desc" ></textarea>
					    <label class="mdl-textfield__label" for="n_desc">Description</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
						<input type="file" name="image_file" id="image_file" class="upload">
					</div>
					<div id="img_view">

					</div>
					<div class="mdl-textfield mdl-js-textfield">
						<select class="mdl-textfield__input" id="n_parent">
						  <option value="0">Select</option>
						  <?php for ($i=0; $i < count($edit_r_d_full); $i++) { 
						  	echo '<option value="'.$edit_r_d_full[$i]->iextred_id.'">'.$edit_r_d_full[$i]->iextred_title.'</option>';
						  } ?>
						</select>
					</div>
					<div class="mdl-card__actions mdl-card--border">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored save_details" id="submit" style="width: 100%">Save</button>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col">
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--raised home">Home</button>
					<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--raised up">Up</button>
				</div>
				<div class="mdl-cell mdl-cell--12-col" id="node_view">

				</div>
			</div>
			
		</div>	
		<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
		  <div class="mdl-snackbar__text"></div>
		  <button class="mdl-snackbar__action" type="button"></button>
		</div>	
	</div>
</main>
</div>
</body>
<script type="text/javascript">
	var node_arr = [];
	var flg ='';
	<?php if (isset($edit_r_details)) { for ($i=0; $i < count($edit_r_details); $i++) { 
		echo "node_arr.push({ 'id' : ".$edit_r_details[$i]->iextred_id.", 'title': '".$edit_r_details[$i]->iextred_title."', 'desc' : '".$edit_r_details[$i]->iextred_desc."', 'link' : '".$edit_r_details[$i]->iextred_link."', 'img' : '".$edit_r_details[$i]->iextred_image."', 'parent' : '".$edit_r_details[$i]->iextred_p_id."'});";
	} }?>
	$(document).ready(function() {
		var snackbarContainer = document.querySelector('#demo-toast-example');

		load_nodes();
		$('#submit').click(function(e){
			e.preventDefault();
			$.post('<?php if(isset($edit_research)) { echo base_url()."Research/research_update/".$rid."/"; } else { echo base_url()."Research/research_save/"; } ?>' + flg , {
					're_title' : $('#re_title').val(),
					'n_title' : $('#n_title').val(),
					'n_desc' : $('#n_desc').val(),
					'n_parent' : $('#n_parent').val(),
					'n_link' : $('#n_link').val()
				}, function(data, status, xhr){
					if (data == '') {
						var data = {message: 'Please try again later !', timeout: 2000,};
    					snackbarContainer.MaterialSnackbar.showSnackbar(data);
					}else{
						if ($('.upload').val()!='') {
							upload_img(data);
						} else {
							reset_fields()	
							var data = {message: 'Saved Successfully.', timeout: 2000, };
    					snackbarContainer.MaterialSnackbar.showSnackbar(data);
						}
					}
				}, 'text');
		});

		$('#node_view').on('click', '.node_detail', function(e) {
			flg = $(this).prop('id');
			e.preventDefault();
			console.log("Node:" + flg);
			$.post('<?php if(isset($edit_r_details)) echo base_url()."Research/get_nodes/".$rid."/"; ?>' + $(this).prop('id'), {}, function(d,s,x) {
				var out='';
				var a=JSON.parse(d);
				if (a.details.length > 0) {
					$('#n_title').val(a.details[0].iextred_title);
					$('#n_desc').val(a.details[0].iextred_desc);
					$('#n_parent').val(a.details[0].iextred_p_id);
					$('#n_link').val(a.details[0].iextred_link);
					$('#img_view').empty();
					if (a.details[0].iextred_image != '') {
						out+='<div class="mdl-card__title" style="background: url(<?php echo base_url()."assets/uploads/$oid/research/"; ?>' + a.details[0].iextred_image +') no-repeat; background-size:contain;" >';
						$('#img_view').append(out);
					}else{
						$('#img_view').hide();
					}	
				}

				if (a.nodes.length > 0) {
					node_arr =[];

					for (var i = 0; i < a.nodes.length; i++) {
						flg = a.nodes[i].iextred_id;
						node_arr.push({ 'id' : a.nodes[i].iextred_id, 'title': a.nodes[i].iextred_title, 'desc' : a.nodes[i].iextred_desc, 'link' : a.nodes[i].iextred_link, 'img' : a.nodes[i].iextred_image, 'parent' : a.nodes[i].iextred_p_id});
					}

					load_nodes();
				}
			}, "text");
		});

		$('.home').click(function(e){
			e.preventDefault();
			flg=0;
			console.log("Home:" + flg);
			$.post('<?php if(isset($edit_r_details)) echo base_url()."Research/get_parent_nodes/".$rid."/"; ?>' + flg, {}, 
				function(d,s,x) {
				node_arr =[];
				var a=JSON.parse(d);
				for (var i = 0; i < a.nodes.length; i++) {
					flg = a.nodes[i].iextred_id;
					node_arr.push({ 'id' : a.nodes[i].iextred_id, 'title': a.nodes[i].iextred_title, 'desc' : a.nodes[i].iextred_desc, 'link' : a.nodes[i].iextred_link, 'img' : a.nodes[i].iextred_image, 'parent' : a.nodes[i].iextred_p_id});
				}
				reset_fields();
				load_nodes();
			}, "text");
		});

		$('.up').click(function(e){
			e.preventDefault();
			console.log("Up:" + flg);
			$.post('<?php if(isset($edit_r_details)) echo base_url()."Research/get_parent_nodes/".$rid."/"; ?>' + flg + '/p', {}, 
				function(d,s,x) {
				node_arr =[];
				var a=JSON.parse(d);
				reset_fields();
				if (a.details.length > 0) {
					$('#n_title').val(a.details[0].iextred_title);
					$('#n_desc').val(a.details[0].iextred_desc);
					$('#n_parent').val(a.details[0].iextred_p_id);
					$('#n_link').val(a.details[0].iextred_link);
					$('#img_view').empty();
					if (a.details[0].iextred_image != '') {
						out+='<div class="mdl-card__title" style="background: url(<?php echo base_url()."assets/uploads/$oid/research/"; ?>' + a.details[0].iextred_image +') no-repeat; background-size:contain;" >';
						$('#img_view').append(out);
					}else{
						$('#img_view').hide();
					}	
				}

				for (var i = 0; i < a.nodes.length; i++) {
					flg = a.nodes[i].iextred_id;
					node_arr.push({ 'id' : a.nodes[i].iextred_id, 'title': a.nodes[i].iextred_title, 'desc' : a.nodes[i].iextred_desc, 'link' : a.nodes[i].iextred_link, 'img' : a.nodes[i].iextred_image, 'parent' : a.nodes[i].iextred_p_id});
				}
				load_nodes();
			},
			 "text");
		});

	});


	function upload_img($in_id){
		var datat = new FormData();
		datat.append("use", $('.upload')[0].files[0]);
		flnm = "";
		$.ajax({
			url:"<?php if(isset($edit_research)) { echo base_url()."Research/data_upload/update/"; } else { echo base_url()."Research/data_upload/save/"; } ?>" + $in_id,
			type: "POST",
			data: datat, 
			contentType: false,
			cache: false,
			processData:false,
			success: function(data){
				reset_fields();				
			}
		});
	}

	function reset_fields() {
		$('#n_title').val('');
		$('#n_desc').val('');
		$('#n_parent').val('0');
		$('#n_link').val('');
		$('#img_view').empty();
		$('#img_view').hide();
	}

	function load_nodes() {
		var a="";
		a+= '<div class="mdl-grid">';
		for (var i = 0; i < node_arr.length; i++) {

			a+= '<div class="mdl-cell mdl-cell--4-col"><div class="demo-card-square mdl-card mdl-shadow--2dp node_detail" id="' + node_arr[i].id+ '">';

			if (node_arr[i] !== '') {
				a+='<div class="mdl-card__title mdl-card--expand" style="background: linear-gradient(rgba(20,20,20,0.3),rgba(20,20,20,0.3)), url(<?php echo base_url()."assets/uploads/$oid/research/"; ?>' + node_arr[i].img+') no-repeat; background-size:contain;" >';
				a+='<h2 class="mdl-card__title-text">' + node_arr[i].title + '</h2></div>';
			}else{
				a+='<div class="mdl-card__title" style="background: linear-gradient(rgba(20,20,20,0.3),rgba(20,20,20,0.3)), url(<?php echo base_url()."assets/uploads/$oid/research/"; ?>) no-repeat; background-size:contain;" >';
				a+='<h2 class="mdl-card__title-text">' + node_arr[i].title + '</h2></div>';
			}

			if (node_arr[i].desc !== '') {
				a+='<div class="mdl-card__supporting-text">' + node_arr[i].desc + '</div>';
			}

			if (node_arr[i].img !== '' && node_arr[i].link !== '') {
				a+='<div class="mdl-card__actions mdl-card--border">';
				if (node_arr[i].img !== '' ) {
				a+='<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="<?php echo base_url()."assets/uploads/$oid/research/"; ?>'+ node_arr[i].img + '" target="_blank">view</a>';
				}if (node_arr[i].link !== '') {
				a+='<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="'+ node_arr[i].link +'" target="_blank">link</a>';
				}
				a+='</div>';
			}	
			a+='</div></div>';
			
		}

			a+='</div>';
			$('#node_view').empty();
			$('#node_view').append(a);
	}
</script>
</html>