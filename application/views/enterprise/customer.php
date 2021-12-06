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
<main class="mdl-layout__content">
    <div class="mdl-grid">
    	<div class="mdl-cell mdl-cell--12-col" style="">
    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<select id="c_name" name="c_name" class="mdl-textfield__input">
				    <option value="all">Select All</option>
				    <?php for($i=0; $i < count($section); $i++) {
				        echo '<option value="'.$section[$i]->ic_section.'">'.$section[$i]->ic_section.'</option>'; 
				    }?>
				</select>
				<label class="mdl-textfield__label" for="c_name">Select Contact Type</label>
			</div>
			<button class="mdl-button mdl-js-button mdl-js-ripple-effect imp_file"><i class="material-icons">backup</i> Import File</button>
			<a href="<?php echo base_url().'Enterprise/general_properties/'.$code; ?>"><button class="mdl-button mdl-js-button mdl-js-ripple-effect prp_add"><i class="material-icons">description</i> General Properties</button></a>
		</div>
    </div>
	<div class="mdl-grid" id="details">
		<?php 
			for ($i=0; $i < count($customer) ; $i++) {
				echo '<div class="mdl-cell mdl-cell--2-col">';
				echo '<a href="'.base_url()."Enterprise/customer_details/".$customer[$i]->ic_id."/".$code.'">';
				echo '<div class="mdl-card mdl-shadow--4dp">';

				if($customer[$i]->icp_path) {
					echo '<div class="mdl-card__title mdl-card--expand" style="height:180px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url(\''.base_url().'assets/uploads/'.$oid.'/'.$customer[$i]->icp_path.'\');background-size: 100%;">';	
				} else {
					echo '<div class="mdl-card__title mdl-card--expand" style="height:180px;">';
				}
				
				echo '<h2 class="mdl-card__title-text">'.$customer[$i]->ic_name.'</h2>';
				echo '</div>';
				echo '</div>';
				echo '</a>';
				echo '</div>';
				// echo '<div class="mdl-cell mdl-cell--4-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">';
				// echo '<div class="mdl-grid" style="display:flex;">';
				// echo '<div class="mdl-cell mdl-cell--2-col">';
				// echo '<img src='.base_url().'assets/uploads/'.$oid.'/'.$customer[$i]->icp_path.' style="border-radius:50%;border:1px solid #666;max-width:100%;max-height:200%;height:65px;width:65px;" alt="your image" />';
				// echo '</div>';
				// echo '<div class="mdl-cell mdl-cell--10-col">';
				// echo '<h2 class="mdl-card__title-text">'.$customer[$i]->ic_name.'</h2>';
				// echo '</div>';
				// echo '<div class="mdl-cell mdl-cell--6-col">';
				// echo '<p>Email : kpatole2</p>';
				// echo '<p>Company : evomata</p>';
				// echo '<p>Mobile No. : 9821406714</p>';
				// echo '</div>';
				// echo '<div class="mdl-cell mdl-cell--6-col">';
				// echo '<p>Email : kpatole2</p>';
				// echo '<p>Company : evomata</p>';
				// echo '<p>Mobile No. : 9821406714</p>';
				// echo '</div>';
				// echo '</div>';
				// echo '</div>';
			}
		 ?>
	</div>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col" style="margin-left: 200px">
			<button class="mdl-button mdl-button-upside mdl-js-button mdl-js-ripple-effect" style="color: black" id="show">Show More<i class="material-icons">keyboard_arrow_down</i></button>
		</div>
	</div>
	<?php
		echo '<a href="'.base_url()."Enterprise/customer_add/".$code.'">';
		echo '<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent add_cust"><i class="material-icons">add</i></button>';
		echo '</a>';
	?>
</main>
</body>
<div class="modal fade" id="add_cust_modal" data-backdrop="static" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div>
<div  class="modal fade" id="view_cust_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
			</div>
		</div>
	</div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
	var tag_data = [];
	var cust_arr = [];
	var cust_sec = [];
	var cust_parent = [];
	
	<?php
		for ($i=0; $i < count($customer) ; $i++) {
			echo "cust_arr.push({'id' : '".$customer[$i]->ic_id."' , 'name' : '".$customer[$i]->ic_name."' , 'type' : '".$customer[$i]->ic_section."' });";
			echo "cust_parent.push('".$customer[$i]->ic_name."');";
		}

		for ($i=0; $i < count($section) ; $i++) {
			echo "cust_sec.push('".$section[$i]->ic_section."');";
		}

		for ($i=0; $i < count($tags) ; $i++) { 
			echo "tag_data.push('".$tags[$i]->it_value."');";
		}

		if ($cid != 0) {
			echo "edit_cust(".$cid.");";
		}
	?>
	$(document).ready(function() {
		// display_cust_list();

		var snackbarContainer = document.querySelector('#demo-toast-example');

		$('#view_cust_modal').on('click','.another_contact',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            $('.loader').show();
           	$.post('<?php echo base_url()."Enterprise/view_customer/".$code."/"; ?>'+id,
			function(data, status, xhr) {
				$('#view_cust_modal').modal('toggle');
				setTimeout(function() {
					$('#view_cust_modal > div > div > .modal-body').empty();
					$('#view_cust_modal > div > div > .modal-body').append(data);
					$('#view_cust_modal').modal('show');
					$('.loader').hide();
				}, 1000);
	        }, 'text');
        });

        $('#view_cust_modal').on('click','.activity_edit',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            $('.loader').show();
           	$.post('<?php echo base_url()."View/activity_edit/".$code."/"; ?>'+id
	        , function(data, status, xhr) {
	            $('#activity_modal > div > div').empty();
	            $('#activity_modal > div > div').append(data);
	        }, 'text');
	        $('#view_cust_modal').modal('toggle');
			setTimeout(function() {
				$('#activity_modal').modal('toggle');
				$('.loader').hide();
			}, 1000);
        });

///////////////////////////////// Customer home /////////////////////////////////////////////////
		var flg=100;
		$('#show').click(function(e){
	        e.preventDefault();
	        flg = flg+100;
	        $.post('<?php echo base_url()."Enterprise/customers_show_more/".$code."/"; ?>'+ flg,{
	        	'c_type' : $('#c_name').val()
	        },function(data, status, xhr) {
	            var abc = JSON.parse(data);
				cust_arr = [];
				for (var i = 0; i < abc.customer.length; i++) {
					cust_arr.push({'id' : abc.customer[i].ic_id , 'name' : abc.customer[i].ic_name , 'type' : abc.customer[i].ic_section});
				}
				display_cust_list();
	        })
	    });

	    $('#c_name').change(function(e) {
	        e.preventDefault();
	        $.post('<?php echo base_url()."Enterprise/customer_filter/".$code; ?>', {
	            'filter' : $(this).val()
	        }, function(data, status, xhr) {
	            var abc = JSON.parse(data);
	            cust_arr = [];
				for (var i = 0; i < abc.customer.length; i++) {
					cust_arr.push({'id' : abc.customer[i].ic_id , 'name' : abc.customer[i].ic_name , 'type' : abc.customer[i].ic_section});
				}
				display_cust_list();
	        })
	    });
	    
		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Enterprise/customer_search/".$code; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);
				cust_arr = [];
				for (var i = 0; i < abc.customer.length; i++) {
					cust_arr.push({'id' : abc.customer[i].ic_id , 'name' : abc.customer[i].ic_name , 'type' : abc.customer[i].ic_section});
				}
				display_cust_list();
			})
		});

		$('.prp_add').click(function (e) {
			e.preventDefault();
			window.location = '<?php echo base_url().'Enterprise/general_properties/Customers/'.$code; ?>';
		});

		$('.imp_file').click(function (e) {
			e.preventDefault();
			window.location = '<?php echo base_url().'Enterprise/excel_import_file/Customers/'.$code; ?>';
		});

		function display_cust_list(){
			var out = '';
			var sr_no = 0;
			// out+= '<table class="general_table">';
			// out+= '<thead><th>Sr. No.</th><th>Name</th><th>Type</th><th colspan="2" style="text-align:center;">Action</th></thead>';
			// out+= '<tbody>';
			var path = "<?php echo base_url().'Enterprise/customer_details/'; ?>";
			if (cust_arr.length > 0 ) {
				for (var i = 0; i < cust_arr.length; i++) {
					out+= '<div class="mdl-cell mdl-cell--2-col">';					
					// out+= '<a href="'+<?php //echo base_url()."Enterprise/customer_details/".$cust_arr[$i]->ic_id."/".$code; ?>'">';
					out+= '<a href="'+path+cust_arr[i].id+'/<?php echo $code; ?>"';
					out+= '<div class="mdl-card mdl-shadow--4dp">';
					out+= '<div class="mdl-card__title mdl-card--expand" style="height:180px;">';
					out+= '<h2 class="mdl-card__title-text">'+cust_arr[i].name+'</h2>';
					out+= '</div>';
					out+= '</div>';
					out+= '</a>';
					out+= '</div>';
					// out+= '<tr><td>'+sr_no+'</td><td>'+cust_arr[i].name+'</td><td>'+cust_arr[i].type+'</td><td style="width:15%;"><button class="mdl-button mdl-button--colored edit_cust" id="'+cust_arr[i].id+'"><i class="material-icons">edit</i> Details</button></td><td style="width:15%;"><button class="mdl-button mdl-button--colored cust_view_detail" style="width:100%;" id="'+cust_arr[i].id+'"><i class="material-icons">remove_red_eye</i> Transaction</button></td></tr>';

				}
			}else{
				// out+='<tr><td colspan="4" style="text-align:center;">No Records Found!</td></tr>'
				out += '<h2>No Records Found !</h2>';
			}
			// out+= '</tbody>';
			// out+= '</table>';

			$('#details').empty();
			$('#details').append(out);
		}
///////////////////////////////// Customer Add /////////////////////////////////////////////////
		// $('.add_cust').click(function (e) {
		// 	e.preventDefault();
  //   		$.post('<?php //echo base_url()."Enterprise/cust_add/".$code."/"; ?>'
	 //        , function(data, status, xhr) {
	 //            $('#add_cust_modal > div > div > .modal-body').remove();
	 //            $('#add_cust_modal > div > div').append('<div class="modal-body"></div>');

	 //            $('#add_cust_modal > div > div > .modal-footer').remove();
	 //            $('#add_cust_modal > div > div').append('<div class="modal-footer"></div>')

	 //            $('#add_cust_modal > div > div > .modal-footer').append('<button type="button" class="mdl-button mdl-button--colored empty_modal" id="submit_contact" data-dismiss="modal">Save</button><button type="button" class="mdl-button mdl-button--colored empty_modal" data-dismiss="modal">Close</button>');

		// 		$('#add_cust_modal > div > div > .modal-body').append(data);

		// 		$('#add_cust_modal').modal('show');
	 //        }, 'text');
  //   	});
///////////////////////////////// Customer Edit /////////////////////////////////////////////////
		$('#details').on('click','.edit_cust',function (e) {
			e.preventDefault();
			var cust_id = $(this).prop('id');
    		edit_cust(cust_id);
    	});
///////////////////////////////// Customer View /////////////////////////////////////////////////
		$('#details').on('click','.cust_view_detail',function (e) {
			e.preventDefault();
			var cust_id = $(this).prop('id');
			$.post('<?php echo base_url()."Enterprise/view_customer/".$code."/"; ?>'+cust_id,
			function(data, status, xhr) {
				$('#view_cust_modal > div > div > .modal-body').empty();
				$('#view_cust_modal > div > div > .modal-body').append(data);
				$('#view_cust_modal').modal('show');
			});
		});
	});
	
 	function edit_cust(cust_id){
		$.post('<?php echo base_url()."Enterprise/cust_add/".$code."/"; ?>'+cust_id
        , function(data, status, xhr) {
            $('#add_cust_modal > div > div > .modal-body').remove();
            $('#add_cust_modal > div > div').append('<div class="modal-body"></div>');

            $('#add_cust_modal > div > div > .modal-footer').remove();
            $('#add_cust_modal > div > div').append('<div class="modal-footer"></div>')

            $('#add_cust_modal > div > div > .modal-footer').append('<button type="button" class="mdl-button mdl-button--colored empty_modal" id="submit_contact" data-dismiss="modal">Save</button><button type="button" class="mdl-button mdl-button--colored empty_modal" data-dismiss="modal">Close</button>');
            
			$('#add_cust_modal > div > div > .modal-body').append(data);

			$('#add_cust_modal').modal('show');
        }, 'text');
	}


</script>
</html>