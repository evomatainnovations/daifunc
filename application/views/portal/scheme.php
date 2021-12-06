<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
	.ui-widget {
        z-index: 30000;
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
		/*border-bottom: 1px solid #ccc;*/
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
		<?php
			if (isset($s_list)) {
				for ($i=0; $i < count($s_list) ; $i++) {
					echo '<div class="mdl-cell mdl-cell--4-col mdl-cell--6-col--tablet mdl-shadow--8dp" style="border-radius: 15px;text-align:center;"><h3 style="text-align:center;">'.$s_list[$i]->iush_name.'</h3><hr style="width:80%;margin-left:10%;">';
					if ($s_list[$i]->iush_default == '1' ) {
						echo '<button class="mdl-button mdl-button--raised mdl-button--colored default" id="'.$s_list[$i]->iush_id.'" style="margin-bottom : 10px;">Choose Default</button>';
					}else{
						echo '<button class="mdl-button mdl-button--colored default" id="'.$s_list[$i]->iush_id.'" style="margin-bottom : 10px;">Choose Default</button>';
					}
					echo '<button class="mdl-button mdl-button--colored allot" id="'.$s_list[$i]->iush_id.'" style="margin-bottom : 10px;"><i class="material-icons">add</i> Allot</button>';
					echo '<button class="mdl-button mdl-button--colored edit" id="'.$s_list[$i]->iush_id.'" style="margin-bottom : 10px;"><i class="material-icons">edit</i> Edit</button></div>';
				}
			}
		?>
		<div class="mdl-cell mdl-cell--12-col">
			<button class="mdl-button mdl-button--fab lower-button mdl-button--colored add_scheme"><i class="material-icons">add</i></button>
		</div>
	</div>
</main>
<div class="modal fade" id="allot_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Allot scheme to users</h4>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<input type="text" id="search_name" class="mdl-textfield__input">
					<label class="mdl-textfield__label" for="search_name">Enter User Name</label>
				</div>
				<div class="mdl-grid" style="height: 40vh;overflow: auto;">
					<div class="mdl-cell mdl-cell--12-col">
						<table class="general_table">
							<thead>
								<th>Name</th>
								<th>Email</th>
								<th>Referrer Code</th>
								<th>Action</th>
							</thead>
							<tbody class="u_details"></tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="mdl-button mdl-button--colored allot_scheme"><i class="material-icons">save</i> Allot</button>
				<button class="mdl-button mdl-button--colored" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var customer_data = [] ;
	var u_details = [] ;
	var allot_id;
	var scheme_arr = [] ;
	<?php
		for ($i=0; $i < count($u_list) ; $i++) { 
			echo "customer_data.push('".$u_list[$i]->iud_name."');";
			echo "u_details.push({'id' : '".$u_list[$i]->i_uid."' , 'name' : '".$u_list[$i]->iud_name."' , 'email' : '".$u_list[$i]->iud_email."' , 'code' : '".$u_list[$i]->i_user_code."' , 'flg' : 'false' });";
			echo "scheme_arr.push({'sid' : '".$u_list[$i]->i_user_scheme."' , 'uid' : '".$u_list[$i]->i_uid."' });";
		}
	?>
	$(document).ready( function() {

		$("#search_name").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(customer_data, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_details(value);
            }
        });

		$('.add_scheme').click(function (e) {
			e.preventDefault();
			window.location = '<?php echo base_url()."Portal/add_scheme/"; ?>';
		});

		$('.default').click(function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = '<?php echo base_url()."Portal/default_scheme/"; ?>'+id;
		});

		$('.allot').click(function (e) {
			e.preventDefault();
			allot_id = $(this).prop('id');
			for (var i = 0; i < u_details.length; i++) {
				u_details[i].flg = 'false';
			}
			for (var i = 0; i < scheme_arr.length; i++) {
				for (var ij = 0; ij < u_details.length; ij++) {
					if (scheme_arr[i].uid == u_details[ij].id ) {
						if (scheme_arr[i].sid == allot_id) {
							u_details[ij].flg = 'true';
						}
					}
				}
			}
			get_details('null');
			$('#allot_modal').modal('show');
		});

		$('.edit').click(function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			window.location = '<?php echo base_url()."Portal/add_scheme/"; ?>'+id;
		});

		$('.allot_scheme').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Portal/scheme_allot/"; ?>',{
				'u_arr' : u_details,
    			's_id' : allot_id
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Portal/user_scheme/"; ?>';
			}, "text");
		});

		$('.u_details').on('click','.remove_user',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			for (var i = 0; i < u_details.length; i++) {
				if(u_details[i].id == id){
					u_details[i].flg = 'false';
					break;
				}
			}
			get_details('null');
		});

		function get_details(uname){
			var out = '';
			for (var i = 0; i < u_details.length; i++) {
				if(u_details[i].name == uname ){
					u_details[i].flg = 'true';
				}
				if (u_details[i].flg == 'true') {
					out += '<tr><td>'+u_details[i].name+'</td><td>'+u_details[i].email+'</td><td>'+u_details[i].code+'</td><td><button class="mdl-button mdl-button--colored mdl-button--icon remove_user" id="'+u_details[i].id+'"><i class="material-icons">close</i></button></td></tr>';
				}
			}
			$("#search_name").val("");
			$('.u_details').empty();
			$('.u_details').append(out);
		}
	});
</script>