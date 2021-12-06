<main class="mdl-layout__content">
	<div class="mdl-grid p_list"></div>
	<!-- <button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit"><i class="material-icons">done</i></button> -->
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
	var list_arr = [];
	<?php
		if (isset($p_price)) {
			for ($i=0; $i <count($p_price) ; $i++) { 
				echo "list_arr.push({id : '".$p_price[$i]->ipprice_id."',name : '".$p_price[$i]->ipprice_name."',amount : '".$p_price[$i]->ipprice_amount."'});";
			}
		}
	?>
	$(document).ready(function() {
		display_list();

		var snackbarContainer = document.querySelector('#demo-toast-example');

		$('.p_save').click(function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			var name,price;
			for (var i = 0; i < list_arr.length; i++) {
				if(list_arr[i].id == id){
					$.post("<?php echo base_url().'Portal/update_price/'; ?>"+id, {
					name : list_arr[i].name,
					price : $('#am'+id).val()
					}, function(data, status, xhr) {
						if (data == 'true') {
							var data = {message: 'Data save!'};
	    					snackbarContainer.MaterialSnackbar.showSnackbar(data);
						}else{
							var data = {message: 'Error!'};
	    					snackbarContainer.MaterialSnackbar.showSnackbar(data);
						}
					}, "text");
				}
			}
		});
	});
	function display_list() {
		var out = '';
		for (var i = 0; i < list_arr.length; i++) {
			var name = list_arr[i].name.toUpperCase();
			out +='<div class="mdl-cell mdl-cell--4-col"><h2>'+name+'</h2><input type="text" id="am'+list_arr[i].id+'" name="p_amount" class="mdl-textfield__input" value="'+list_arr[i].amount+'" placeholder="Enter price" style="font-size: 3em;outline: none;"><br><button style="width:100%;" class="mdl-button mdl-button--raised p_save" id="'+list_arr[i].id+'">save</button></div>';
		}
		$('.p_list').empty();
		$('.p_list').append(out);
	}
</script>