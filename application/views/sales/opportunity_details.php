<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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
	.modal-dialog {
		z-index: 10000000 !important;
	}
	.panel-group{
	    overflow-x: auto;
	}
	.mdl-tabs__panel {
	    max-height: 40vh;
	    overflow-y: auto;
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
	::placeholder {color: black;}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid" id="edit_opportunity" style="display: none;width: 100%;">
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--10-col">
				<h1 id="title"><?php if (isset($save_opportunity)){echo $save_opportunity[0]->iextetop_title;} ?></h1>
			</div>
			<!-- <div class="mdl-cell mdl-cell--2-col" style="padding: 15px;text-align: right;">
				<button class="mdl-button mdl-js-ripple-effect opp_details" id="<?php if (isset($save_opportunity)){echo $save_opportunity[0]->iextetop_cid;} ?>"><i class="material-icons">remove_red_eye</i> view details</button>
			</div> -->
			<div class="mdl-cell mdl-cell--2-col" style="padding: 15px;text-align: right;">
				<button class="mdl-button mdl-js-ripple-effect opp_edit" id="<?php if(isset($save_opportunity)){echo $save_opportunity[0]->iextetop_id;} ?>">Edit <i class="material-icons">edit</i></button>
			</div>
		</div>
		<div class="mdl-grid">
			<div class="panel-group" id="accordion" style="width: 100%;margin-left: 10px;">
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4 class="panel-title">
	                        <a data-toggle="collapse" data-parent="#accordion" href="#likehood">Likelihood of conversion</a>
	                    </h4>
	                </div>
	                <div id="likehood" class="panel-collapse collapse">
	                    <div class="panel-body">
	                    	<div class="mdl-grid">
	                    		<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
		                    		<h4 id="slider_num" style="text-align: center;">0</h4>
									<input class="mdl-slider mdl-js-slider opp_slider" value="0" type="range" min="0" max="10" tabindex="0">	
		                    		<button class="mdl-button mdl-button--raise mdl-button--colored likehood_submit" style="text-align: center;">Submit</button>
		                    	</div>
		                    	<div class="mdl-cell mdl-cell--8-col">
		                    		<canvas id="myChart" style="display: block; width: 1053px;height: 250px !important;"></canvas>
		                    	</div>
	                    	</div>
	                    	
	                    </div>
	                </div>
	            </div>
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4 class="panel-title">
	                        <a data-toggle="collapse" data-parent="#accordion" href="#details">Details</a>
	                    </h4>
	                </div>
	                <div id="details" class="panel-collapse collapse">
	                    <div class="panel-body">
	                    	<div class="mdl-grid">
		                    	<div class="mdl-cell mdl-cell--12-col">
		                    		<button class="mdl-button mdl-js-ripple-effect add_prpty" id="<?php if (isset($save_opportunity)){echo $save_opportunity[0]->iextetop_cid;} ?>">Add property<i class="material-icons">add</i></button>
		                    	</div>
	                    	</div>
	                    	<table class="mdl-data-table">
	                    		<tbody>
									<?php
										if (isset($cust_details)) {
											for ($i=0; $i < count($cust_details) ; $i++) {
												if ($cust_details[$i]->icbd_value != '') {
													echo '<tr style="border:none;"><td style="text-align:left;">'.$cust_details[$i]->ip_property .'</td><td>  =>  </td><td>'.$cust_details[$i]->icbd_value.'</td></tr>';
												}
											}
										}
									?>
								</tbody>
							</table>
	                    </div>
	                </div>
	            </div>
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4 class="panel-title">
	                        <a data-toggle="collapse" data-parent="#accordion" href="#note">Notes</a>
	                    </h4>
	                </div>
	                <div id="note" class="panel-collapse collapse">
	                    <div class="panel-body">
	                    	<div class="mdl-grid">
	                    		<div class="mdl-cell mdl-cell--12-col">
		                    		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
										<input class="mdl-textfield__input" type="text" id="o_note">
			    						<label class="mdl-textfield__label" for="o_note">Note</label>
									</div>
		                    	</div>
		                    	<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
		                    		<button class="mdl-button mdl-js-ripple-effect add_notes" id="<?php if (isset($save_opportunity)){echo $save_opportunity[0]->iextetop_id;} ?>"><i class="material-icons">add</i> save Notes</button>
		                    	</div>
	                    	</div>
	                    	<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp notes_table" style="width: 100%;">
	                    		<thead>
									<th class="mdl-data-table__cell--non-numeric">Note</th>
									<th class="mdl-data-table__cell--non-numeric">Date</th>
								</thead>
								<tbody id="notes_table">
									
								</tbody>
	                    	</table>
	                    </div>
	                </div>
	            </div>
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4 class="panel-title">
	                        <a data-toggle="collapse" data-parent="#accordion" href="#info">Send Information</a>
	                    </h4>
	                </div>
	                <div id="info" class="panel-collapse collapse">
	                    <div class="panel-body">
	                    	<button class="mdl-button mdl-js-ripple-effect add_info" id="<?php if (isset($save_opportunity)){echo $save_opportunity[0]->iextetop_id;} ?>">Send Information<i class="material-icons">add</i></button>
	                    </div>
	                    <table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp info_table" style="width: 100%;">
                    		<thead>
								<th class="mdl-data-table__cell--non-numeric">Title</th>
								<th class="mdl-data-table__cell--non-numeric">Date</th>
							</thead>
							<tbody id="info_table">
								
							</tbody>
                    	</table>
	                </div>
	            </div>
	            <?php
	            		if (isset($mod)) {
	            			for ($i=0; $i <count($mod) ; $i++) { 
	            				if ($mod[$i]->mname == 'Proposal' && $mod[$i]->status == 'active') {
	            					$mod_id = $mod[$i]->mid;
	            					echo '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#proposal">Proposal</a></h4></div><div id="proposal" class="panel-collapse collapse"><div class="panel-body">';
	            					echo '<button class="mdl-button mdl-js-ripple-effect add_proposal" id="<?php if (isset($save_opportunity)){echo $save_opportunity[0]->iextetop_id;} ?>">Add Proposal<i class="material-icons">add</i></button>';
	            					echo '<table id="proposal_table" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;"></table></div></div></div>';
	            				}else{
	            					$mod_id = 0;
	            				}
	            			}
	            		}
	            ?>
	            
	            <div class="panel panel-default">
	                <div class="panel-heading">
	                    <h4 class="panel-title">
	                        <a data-toggle="collapse" data-parent="#accordion" href="#activity">Activity</a>
	                    </h4>
	                </div>
	                <div id="activity" class="panel-collapse collapse">
	                    <div class="panel-body">
	                    	<button class="mdl-button mdl-js-ripple-effect new_activity" id="<?php if (isset($save_opportunity)){echo $save_opportunity[0]->iextetop_id;} ?>">Add Activity<i class="material-icons">add</i></button>
	                    	<table id="activity_list" class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;"></table></div>
	                </div>
	            </div>
	        </div>
		</div>
		<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    <input class="mdl-textfield__input" type="text" id="add_action">
				    <label class="mdl-textfield__label" for="add_action">Add Status</label>
				</div>
				<button class="mdl-button mdl-button--colored mdl-button--raise mdl-button--accent add_action_button"><i class="material-icons">add</i></button>
			</div>
			<div class="mdl-cell mdl-cell--12-col add_action"></div>
		</div>
	</div>
	<div class="mdl-grid" id="add_opportunity">
		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
			<input class="mdl-textfield__input" type="text" id="op_title" placeholder="Enter Customer Name" value="<?php if(isset($cust)) { echo $cust[0]->ic_name;}else{echo $cust_name;} ?>" style="font-size: 3em;outline: none;">
		</div>
		<div class="mdl-cell mdl-cell--8-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label>Enter Tags</label>
						<ul id="oppo_tag">
							<?php 
								if(isset($oppo_tags)) {
									for ($i=0; $i <count($oppo_tags) ; $i++) { 
										echo "<li>".$oppo_tags[$i]->t_name."</li>";		
									}
								} 
							?>
						</ul>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label>Share with user</label>
						<ul id="mutual_tag">
							<?php 
								if(isset($mutual_tag)) {
									for ($i=0; $i <count($mutual_tag) ; $i++) { 
										echo "<li>".$mutual_tag[$i]->ic_name."</li>";		
									}
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="mdl-grid">
				<?php
					if (isset($oppo_title)) {
						echo '<div class="mdl-cell mdl-cell--4-col"><button class="mdl-button mdl-button--colored"';
						if ($oppo_gid != 0) {
							echo 'id="oppo_slef_trans"><i class="material-icons">compare_arrows</i> Transfer to Self Account';
						}else{
							echo 'id="oppo_group_trans"><i class="material-icons">compare_arrows</i> Transfer to Group Account';
						}
						echo '</button></div>';
						echo '<div class="mdl-cell mdl-cell--4-col"><button class="mdl-button mdl-button--colored" id="transfer_user"><i class="material-icons">compare_arrows</i> Transfer to User</button></div>';
						echo '<div class="mdl-cell mdl-cell--4-col"><button class="mdl-button mdl-button--colored" id="oppo_delete"><i class="material-icons">delete</i> delete</button></div>';
					}
				?>
			</div>	
		</div>
		<?php
			if (!isset($save_opportunity)){
				echo '<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add"><i class="material-icons">add</i></button>';
			}
		?>
	</div>
</main>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Send Information <?php if (isset($save_opportunity)){echo ' to '.$save_opportunity[0]->iextetop_title;} ?></h4>
				</div>
				<div class="modal-body">
					<div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
					  	<div class="mdl-tabs__tab-bar" id="panel_flg">
					      <a href="#product-panel" class="mdl-tabs__tab p_flg" id="pro" style="display: none;">Product</a>
					      <a href="#repo-panel" class="mdl-tabs__tab is-active p_flg" id="store">Storage</a>
					      <a href="#upload-panel" class="mdl-tabs__tab p_flg" id="uplod">Upload</a>
					      <a href="#template-panel" class="mdl-tabs__tab p_flg" id="e_temp">Email template</a>
					  	</div>
					  	<div class="mdl-tabs__panel " id="product-panel" style="display: none;">
					  		<div class="mdl-textfield mdl-js-textfield">
							    <input class="mdl-textfield__input" type="text" id="p_search">
							    <label class="mdl-textfield__label" for="p_search">Product name</label>
							</div>
							<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="product_search"><i class="material-icons">search</i> Search</button>
					  		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp repo_table" style="width: 100%;">
								<tbody id="product_table">
									
								</tbody>
	                    	</table>
					  	</div>
					  	<div class="mdl-grid" id="prod_selected"></div>
					  	<div class="mdl-tabs__panel is-active" id="repo-panel">
							<div class="mdl-textfield mdl-js-textfield">
							    <input class="mdl-textfield__input" type="text" id="f_search">
							    <label class="mdl-textfield__label" for="f_search">File name</label>
							</div>
							<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="file_search"><i class="material-icons">search</i> Search</button>
					  		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp repo_table" style="width: 100%;">
								<tbody id="repo_table">
									
								</tbody>
	                    	</table>
					  	</div>
					  	<div class="mdl-grid" id="selected"></div>
					  	<div class="mdl-tabs__panel" id="upload-panel">
					  		<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
								<div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
									<i class="material-icons">folder</i> Upload Document
									<input type="file" name="file[]" id="multiFiles" class="upload u_multiple" multiple>
								</div>
							</div>
					  	</div>
					  	<div class="mdl-tabs__panel" id="template-panel">
					  		<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
					  			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="text-align:left;">
					  				<select class="mdl-textfield__input" id="e_temp">
					  				<option value="null" selected>Select email template</option>
									<?php
										if (isset($e_temp)) {
											for ($i=0; $i < count($e_temp) ; $i++) { 
												echo '<option value="'.$e_temp[$i]->iuetemp_id.'">'.$e_temp[$i]->iuetemp_title.'</option>';
											}
										}
									?>
									</select> 
									<label class="mdl-textfield__label" for="e_temp">Select template</label>
								</div>
							</div>
					  	</div>
					</div>
					<div class="mdl-grid">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 80%">
							<input class="mdl-textfield__input" type="text" id="customer_mail">
							<label class="mdl-textfield__label" for="customer_mail">Email</label>
						</div>	
						<button class="mdl-button mdl-button-done mdl-js-button mdl-button--accent" id="email_button"><i class="material-icons">add</i></button>
						<div id="email_list">
							<h5>Email id </h5>
							<table id="exist_email"></table>
						</div>
						<div class="mdl-cell mdl-cell--12-col">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
							    <input class="mdl-textfield__input" type="text" id="subject">
							    <label class="mdl-textfield__label" for="subject">Subject</label>
							</div>	
							<div class="mdl-textfield mdl-js-textfield" style="width: 100%;">
							    <textarea class="mdl-textfield__input" type="text" rows= "3" id="body_text"></textarea>
							    <label class="mdl-textfield__label" for="body_text"></label>
							</div>
						</div>
						<div class="mdl-cell mdl-cell--12-col" id="selected_temp"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="send_mail">Send</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal_email" role="dialog">
		<div class="modal-dialog">
	<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Enter Email address for <?php if(isset($edit_invoice)) { echo $edit_invoice[0]->ic_name;} ?></h4>
				</div>
				<div class="modal-body">
					<div>
						<table id="exist_email">
						    
						</table>
					</div>
					<div id="enter_email">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 250px">
							<input class="mdl-textfield__input" type="text" id="cust_mail">
							<label class="mdl-textfield__label" for="cust_mail">Email</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="add_mail">Accept</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal_group" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Select Group for transfer</h4>
			</div>
			<div class="modal-body">
				<div class="mdl-textfield mdl-js-textfield">
				    <input class="mdl-textfield__input" type="text" id="group_search">
				    <label class="mdl-textfield__label" for="group_search">Group Name</label>
				</div>
				<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="account_search"><i class="material-icons">search</i> Search</button>
				<div id="grp_body">
					
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal_user" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Enter User Name for transfer</h4>
			</div>
			<div class="modal-body" style="text-align: center;">
				<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					<ul id="user_search">
					</ul>
				</div>
				<div>
					<button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="user_add"><i class="material-icons">compare_arrows</i> Transfer</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- </body> -->
<script type="text/javascript">
	var customer_data = [], oppo_arr = [], note_arr = [], file_arr =[],email_array =[],info_arr = [],btn_arr = [],activity_arr = [],person_array = [],proposal_arr = [],product_arr = [];
	var o_id = '',panel_flg = 'store';
	var repo = [],labale_arr = [],data_arr= [],prod=[];
	var email = '';
	var customer = [];
	var tags = [];
	var edit_flg = '';
	var num = '';
	var likehood = '';
	var status = '';
	var total_task = '';
	var user_data = [];
	var mutual_arr = [];
	var tag_data = [];
	<?php

		for ($i=0; $i < count($customer) ; $i++) { 
			echo "customer_data.push('".$customer[$i]->ic_name."');";
		}

		for ($i=0; $i <count($tags) ; $i++) { 
			echo "tag_data.push('".$tags[$i]->it_value."');";
		}

		if (isset($cust)) {
			for ($i=0; $i <count($cust) ; $i++) {
				echo "email_array.push({'email' : '".$cust[$i]->icbd_value."','status' : 'false'});";
			}
			echo "person_array.push('".$cust[0]->ic_name."');";
		}else if (isset($cust_data)) {
			echo "person_array.push('".$cust_data[0]->ic_name."');";
		}

		if (isset($oppo_note) ) {
			for ($i=0; $i <count($oppo_note) ; $i++) {
				echo "note_arr.push({'id' : ".$oppo_note[$i]->iexteon_id.", 'note' : '".$oppo_note[$i]->iexteon_note."', 'date' : '".$oppo_note[$i]->iexteon_created."'});";
			}
			if (count($info) > 0) {
				for ($i=0; $i <count($info) ; $i++) { 
					echo "info_arr.push({'id' : ".$info[$i]->iexteoi_id.", 'title' : '".$info[$i]->iexteoi_title."', 'date' : '".$info[$i]->iexteoi_created."'});";
				}
			}
		}

		if (isset($proposal)) {
			for ($i=0; $i <count($proposal) ; $i++) { 
				echo "proposal_arr.push({'id' : ".$proposal[$i]->iextepro_id.",'txn_no' : '".$proposal[$i]->iextepro_txn_id."' ,'title' : '".$proposal[$i]->iextepro_type."', 'date' : '".$proposal[$i]->iextepro_txn_date."'});";
			}
		}
		
		if (isset($files)) {
			if (count($files) > 0) {
				for ($i=0; $i <count($files) ; $i++) { 
					echo "file_arr.push({'id': ".$files[$i]->icd_id.",'file_name' : '".$files[$i]->icd_file."'});";	
				}
			}
		}

		if (isset($product)) {
			if (count($product) > 0) {
				for ($i=0; $i <count($product) ; $i++) { 
					echo "product_arr.push({'id': ".$product[$i]->ip_id.",'file_name' : '".$product[$i]->ip_product."'});";
				}
			}
		}

		if (isset($likehood) && count($likehood) > 0) {
			echo "$('#slider_num').empty();";
			echo "$('#slider_num').append(".$likehood[0]->iexteoh_rate.");";
			echo "$('.opp_slider').val(".$likehood[0]->iexteoh_rate.");";
			
			for ($i=0; $i <count($likehood_graph) ; $i++) { 
				echo "labale_arr.push('".$likehood_graph[$i]->iexteoh_created."');";
				echo "data_arr.push(".$likehood_graph[$i]->iexteoh_rate.");";
			}
		}
		
		if (isset($save_opportunity)) {
			echo "$('#add_opportunity').css('display','none');";
			echo "$('#edit_opportunity').css('display','block');";
			echo "status = '".$save_opportunity[0]->iextetop_status."';";
			echo "console.log('edit');";
		} else if (isset($oppo_title)) {
			echo "console.log('add');";
			echo "$('#edit_opportunity').css('display','none');";
		}else{
			echo "console.log('tp');";
		}

		echo "btn_arr.push({'name' : 'closed'});";
		echo "btn_arr.push({'name' : 'cancelled'});";
		echo "btn_arr.push({'name' : 'not intrested'});";

		if (isset($status) && count($status) > 0) {
			for ($i=0; $i <count($status) ; $i++) { 
				echo "btn_arr.push({'name' : '".$status[$i]->iexteos_name."'});";
			}
		}
		if (isset($edit_person)) {
			echo "person_array.push('".$edit_person[0]->ic_name."');";
		}

		if (isset($activity)) {
			for ($i=0; $i <count($activity) ; $i++) {
				echo "activity_arr.push({'id' : ".$activity[$i]->iua_id.", 'title' : '".$activity[$i]->iua_title."', 'date' : '".$activity[$i]->iua_date."', 'cat' : '".$activity[$i]->iua_categorise."'});";
			}
		}
		
		for ($i=0; $i < count($user_connection); $i++) {
    		echo "user_data.push({'id' : ".$user_connection[$i]->iug_id.", 'name' : '".$user_connection[$i]->iug_name."'});";
		}
	?>

	$(document).ready(function() {
		display_notes();
		display_information();
		btn_display();
		load_activity();
		load_proposal();
		var snackbarContainer = document.querySelector('#demo-toast-example');

		var o_task = <?php if (isset($t_task)) {echo $t_task;}else{echo 0;} ?>;
		var o_day = <?php if (isset($total_day)) {echo $total_day;}else{echo 0;} ?>;

		if (o_day > 0) {
			var efforts = o_task / o_day * 100;	
		}else{
			var efforts = 0;	
		}

		if (efforts > 80) {
			$('#efforts').append('High');
			$('#efforts').css('color','green');
		}else if(efforts <= 80 && efforts > 40 ){
			$('#efforts').append('Medium');
			$('#efforts').css('color','yello');
		}else if(efforts <= 40 && efforts > 10 ){
			$('#efforts').append('Low');
			$('#efforts').css('color','blue');
		}else if(efforts <= 10 && efforts != 0){
			$('#efforts').append('No');
			$('#efforts').css('color','red');
		}else if (efforts == 0) {
			$('#efforts').append('');
		}

		var ctx = document.getElementById("myChart").getContext("2d");
	    var myChart = new Chart(ctx, {
	            type: 'line',
	            data: {
	                  labels: labale_arr,
	                  datasets: [{
	                  		backgroundColor: 'rgb(167, 108, 179)',
      				  		borderColor: 'rgb(255, 255, 255)',
	                        label: 'likehood',
	                        data: data_arr
	                             }]
	                  },
	            options: {
	            scales: {
	                  yAxes: [{
	                        ticks: {
	                             beginAtZero:true
	                               }
	                          }]
	                    }
	           }
	       });

		$('.opp_slider').on('change', function() {
			num = this.value;
			$('#slider_num').empty();
			$('#slider_num').append(num);
		});

		$('.likehood_submit').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/likehood_opportunity/".$code."/".$inid."/"; ?>'+num,
			 function(data, status, xhr) {
				window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;	
			}, 'text');
		});

		$("#op_title").autocomplete({
    		source: function(request, response) {
                var results = $.ui.autocomplete.filter(customer_data, request.term);
                response(results.slice(0, 10));
            }    
        });
    	// $('#i_name').tagit({
    	// 	autocomplete : { delay: 0, minLenght: 5},
    	// 	allowSpaces : true,
    	// 	availableTags : customer_data,
    	// 	tagLimit : 1,
    	// 	singleField : true
    	// });

    	$('#oppo_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data,
    		singleField : true
    	});

    	$('#mutual_tag').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : customer_data,
    		singleField : true
    	});

    	$('#oppo_slef_trans').click(function (e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/opportunity_transfer/".$code."/".$inid."/0"; ?>'
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Sales/home/".$mid."/".$code; ?>';
			}, 'text');
		});

    	$('#oppo_group_trans').click(function (e) {
			e.preventDefault();
			switch_account();
			$('#myModal_group').modal('show');
		});

		$('#myModal_group').on('click','#account_search',function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Home/account_search/".$code; ?>', {
        		's_account' : $('#group_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		user_data = [];
        		for (var i=0; i < d.account.length; i++) {
            		user_data.push({'id' : d.account[i].iug_id, 'name' : d.account[i].iug_name});
        		}
        		switch_account();
        	});
		});

		$('#grp_body').on('click','.transfer_to_group',function (e) {
			e.preventDefault();
			var gid = $(this).prop('id');
			$.post('<?php echo base_url()."Sales/opportunity_transfer/".$code."/".$inid."/"; ?>'+gid
			,function (data, status , xhr) {
				window.location = '<?php echo base_url()."Sales/home/".$mid."/".$code; ?>';
			}, 'text');
		});
///////////////////// Transfer user ///////////////////////////////

		$('#user_search').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : customer_data,
    		tagLimit : 1,
    		singleField : true
    	});

		$('#transfer_user').click(function (e) {
			e.preventDefault();
			$('#myModal_user').modal('show');
		});

		$('#user_add').click(function (e) {
			e.preventDefault();
			var name = [];
			$('#user_search > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					name.push(tmpstr);
				}
			});
			$.post('<?php echo base_url()."Sales/opportunity_transfer_user/".$inid."/".$code;?>', {
				'cust_name' : name[0]
			}, function(data, status, xhr) {
				if (data == 'true') {
					window.location = '<?php echo base_url()."Sales/home/".$mid."/".$code; ?>';
				}else{
					var data = {message: 'User not register!'};
	    			snackbarContainer.MaterialSnackbar.showSnackbar(data);
				}
			}, 'text');
		});

    	$('.add_action').on('click','.oppo_action',function(e) {
    		e.preventDefault();
    		var name = $(this).prop('id');
    		$.post('<?php echo base_url()."Sales/opportunity_status_update/".$code."/".$inid; ?>', {
				'status' : name
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Sales/home/".$mid."/".$code; ?>';
			}, 'text');
    	});

    	$('.opp_edit').click(function (e){
    		e.preventDefault();
    		var id = $(this).prop('id');
    		window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/edit/"; ?>'+id;
    	});

    	$('.add_prpty').click(function (e){
    		e.preventDefault();
    		var id = $(this).prop('id');
    		window.location = '<?php echo base_url()."Enterprise/customer_edit/".$code."/"; ?>'+id;
    	});

    	$('#oppo_delete').click(function (e) {
    		e.preventDefault();
    		console.log('hello');
    		window.location = '<?php echo base_url()."Sales/opportunity_delete/".$code."/".$inid; ?>';
    	});

    	$("#panel_flg").on('click','.p_flg',function (e) {
			e.preventDefault();
			panel_flg = $(this).prop('id');
			console.log(panel_flg);
			if (panel_flg == 'store') {
				$('#selected').css('display','block');
				$('#prod_selected').css('display','none');
			}else if(panel_flg == 'pro'){
				$('#prod_selected').css('display','block');
				$('#selected').css('display','none');
			}else if(panel_flg == 'e_temp'){
				$('#prod_selected').css('display','none');
				$('#selected').css('display','none');
				$('#selected_temp').css('display','block');
			}else{
				$('#prod_selected').css('display','none');
				$('#selected').css('display','none');
			}
		});

		$('.add_action_button').click(function (e) {
			e.preventDefault();
			var name = $('#add_action').val();
			$.post('<?php echo base_url()."Sales/opportunity_status/".$code."/".$inid; ?>', {
				'status' : name
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Sales/home/".$mid."/".$code; ?>';
			}, 'text'); 

		});

		$('#customer_mail').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
            	$.post('<?php echo base_url()."Sales/opportunity_add_email/".$inid."/".$code; ?>', {
					'customer_mail' : $('#customer_mail').val()
				}, function(data, status, xhr) {
					email_array.push({'email' : $('#customer_mail').val(), 'status' : 'true'});
	                $('#customer_mail').val('');
	                $('#customer_mail').focus();
	                email_append();
				}, 'text');                
            }
        });

        $('#email_button').click(function(e) {
            e.preventDefault();
            
            $.post('<?php echo base_url()."Sales/opportunity_add_email/".$inid."/".$code; ?>', {
				'customer_mail' : $('#customer_mail').val()
			}, function(data, status, xhr) {
				email_array.push({'email' : $('#customer_mail').val(), 'status' : 'true'});
                $('#customer_mail').val('');
                $('#customer_mail').focus();
                email_append();
			}, 'text');   
        });

         $('#activity').on('click','.new_activity',function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."View/activity_modal/".$code."/opportunity/".$inid; ?>'
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
        });

        var a_flg = 'true';
    
        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

         $('#activity').on('click','.activity_edit',function(e) {
            e.preventDefault();
            var aid = $(this).prop('id');
            $.post('<?php echo base_url()."View/activity_edit/".$code."/"; ?>'+aid
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
        });

        $('.close_modal').click(function(e){
            e.preventDefault();
            window.location = "<?php echo base_url().'Sales/opportunity_details/'.$code.'/save/'.$inid; ?>";
        });

////////////////////////// Add proposal ////////////////////////////////

		$('.add_proposal').click(function(e){
	       	e.preventDefault();
		 	window.location = "<?php echo base_url().'Sales/proposal_add/'.$code.'/'.$mod_id.'/null/'.$inid; ?>";
		});

		$('.proposal_edit').click(function (e) {
			e.preventDefault();
			var pid = $(this).prop('id');
			window.location = "<?php echo base_url().'Sales/proposal_add/'.$code.'/'.$mod_id.'/'; ?>"+ pid;
		})

////////////////////////// Add notes ///////////////////////////////////

    	$('#add').click(function(e){
	       	e.preventDefault();
	       	
			// $('#i_name > li').each(function(index) {
			// 	var tmpstr = $(this).text();
			// 	var len = tmpstr.length - 1;
			// 	if(len > 0) {
			// 		tmpstr = tmpstr.substring(0, len);
			// 		customer.push(tmpstr);
			// 	}
			// });
		
			$('#oppo_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					tags.push(tmpstr1);
				}
			});
			var mutual = [];
			$('#mutual_tag > li').each(function(index) {
				var tmpstr1 = $(this).text();
				var len1 = tmpstr1.length - 1;
				if(len1 > 0) {
					tmpstr1 = tmpstr1.substring(0, len1);
					mutual.push(tmpstr1);
				}
			});
			$.post('<?php if (isset($oppo_title)) { echo base_url()."Sales/update_opportunity/".$inid."/".$code; } else { echo base_url()."Sales/save_opportunity/".$code; } ?>', {
				'customer' : $('#op_title').val(),
				'tags' : tags,
				'mutual' : mutual,
				'title' : $('#op_title').val()
			}, function(data, status, xhr) {
				if (data == 'false') {
					$('#myModal_email').modal('show');
				}else{
					window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;
				}
			}, 'text');
		});

		$('#myModal_email').on('click','#add_mail',function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/add_cust_opportunity/".$code; ?>', {
				'customer' : $('#op_title').val(),
				'title' : $('#op_title').val(),
				'email' : $('#cust_mail').val()
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;
			}, 'text');
		});

		$('#o_note').keyup(function (e) {
			e.preventDefault();
			if (e.keyCode == 13) {
				var path ='';
				var note = $('#o_note').val();
					if (edit_flg == 'true') {
						path = '<?php echo base_url()."Sales/opportunity_update_note/".$inid."/".$code."/"; ?>';
					}else{
						path = '<?php echo base_url()."Sales/opportunity_add_note/".$inid."/".$code."/"; ?>';
					}
				$.post(path+o_id,
				{'note' : note}
				, function(data, status, xhr) {
					window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;
				}, 'text');
			}
		});		

		$('.add_notes').click(function (e) {
			e.preventDefault();var path ='';
			var note = $('#o_note').val();
				if (edit_flg == 'true') {
					path = '<?php echo base_url()."Sales/opportunity_update_note/".$inid."/".$code."/"; ?>';
				}else{
					path = '<?php echo base_url()."Sales/opportunity_add_note/".$inid."/".$code."/"; ?>';
				}
			$.post(path+o_id,
			{'note' : note}
			, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;
			}, 'text');
		});

		$("#notes_table").on('click','.edit',function (e) {
			e.preventDefault();
			var id = $(this).prop('id');
			
			$.post('<?php echo base_url()."Sales/opportunity_edit_note/".$code; ?>', {
				'opp_id' : id
			}, function(data, status, xhr) {
					var a = JSON.parse(data);
					var note = '';
					if (a.edit_note.length > 0) {
						note = a.edit_note[0].iexteon_note ;
						o_id = a.edit_note[0].iexteon_id ;
						edit_flg = 'true';
 					}
 					$('#o_note').val(note);
			}, 'text');
		});

///////////////////////// Add information /////////////////////////////
		
		$('#template-panel').on('change','#e_temp',function (e) {
			e.preventDefault();
			var temp_id = $(this).val();
			$.post('<?php echo base_url()."Sales/fetch_select_temp/".$code."/"; ?>'+temp_id,
			function(data, status, xhr) {
        		var a = JSON.parse(data);
        		$('#subject').val(a.temp_title);
        		$('#body_text').val(a.temp_content);
        		repo = [];
				for (var i = 0; i < a.files.length; i++) {
					repo.push({'id' : a.files[i].icd_id,'file_name' : a.files[i].icd_file});
				}
				display_selected_temp();
        	});
		});

		function display_selected_temp() {
			var out ='';
			for (var i = 0; i < repo.length; i++) {
				out +='<span class="mdl-chip mdl-chip--deletable" style="margin-right: 10px;margin-bottom: 10px;margin-top: 10px;"><span class="mdl-chip__text">'+repo[i].file_name+'</span><button id="'+repo[i].id+'" type="button" class="mdl-chip__action repo_delete"><i class="material-icons">cancel</i></button></span>';
			}
			$('#selected_temp').empty();
			$('#selected_temp').append(out);
		}

		$('.add_info').click(function(e){
	       	e.preventDefault();
		 	$('#myModal').modal('show');
		 	display_file();
		 	display_product();
		 	email_append();
		});

		$('#repo_table').on('click','.add_repo',function(e){
	       	e.preventDefault();
		 	var id = $(this).prop('id');
		 	for (var i = 0; i < file_arr.length; i++) {
		 		if(file_arr[i].id == id){
		 			var f_name = file_arr[i].file_name;
		 			repo.push({'id' : id,'file_name' : f_name});
		 			file_arr.splice(i, 1);
		 			break;
		 		}
		 	}
		 	display_selected_repo();
		 	display_file();
		});

		$('#product_table').on('click','.add_product',function(e){
	       	e.preventDefault();
		 	var id = $(this).prop('id');
		 	for (var i = 0; i < product_arr.length; i++) {
		 		if(product_arr[i].id == id){
		 			var f_name = product_arr[i].file_name;
		 			prod.push({'id' : id,'file_name' : f_name});
		 			product_arr.splice(i, 1);
		 			break;
		 		}
		 	}
		 	display_selected_product();
		 	display_product();
		});

		$('#exist_email').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var a = $(this).prop('id');
            email_array[a].status = $(this)[0].checked;
        })	

		$('#send_mail').click(function(e){
			e.preventDefault();
			if (panel_flg == 'store') {
				send_store_mail();
			}else if (panel_flg == 'pro') {
				send_prod_mail();
			}else if(panel_flg == 'uplod'){
				send_upload_mail();
			}else if (panel_flg == 'e_temp' ) {
				send_temp_mail();
			}
		});

		$('#file_search').click(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/opp_file_search/".$code; ?>', {
        		'file_name' : $('#f_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		file_arr = [];
        		for (var i=0; i < d.files.length; i++) {
        			file_arr.push({id: d.files[i].icd_id, file_name : d.files[i].icd_file});
        		}
        		display_file();
        	});
		});

		$('#product_search').click(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Sales/opp_product_search/".$code; ?>', {
        		'product_name' : $('#p_search').val()
        	}, function(data, status, xhr) {
        		var d = JSON.parse(data);
        		product_arr = [];
        		for (var i=0; i < d.product.length; i++) {
        			product_arr.push({id: d.product[i].ip_id, file_name : d.product[i].ip_product});
        		}
        		display_product();
        	});
		});

		$('#selected').on('click','.repo_delete',function(e){
			e.preventDefault();
			var id = $(this).prop('id');
		 	for (var i = 0; i < repo.length; i++) {
		 		if(repo[i].id == id){
		 			var f_name = repo[i].file_name;
		 			file_arr.push({'id' : id,'file_name' : f_name});
		 			repo.splice(i, 1);
		 			break;
		 		}
		 	}
		 	display_selected_repo();
		 	display_file();
		});

		$('#prod_selected').on('click','.repo_delete',function(e){
			e.preventDefault();
			var id = $(this).prop('id');
		 	for (var i = 0; i < prod.length; i++) {
		 		if(prod[i].id == id){
		 			var f_name = prod[i].file_name;
		 			product_arr.push({'id' : id,'file_name' : f_name});
		 			prod.splice(i, 1);
		 			break;
		 		}
		 	}
		 	display_selected_product();
		 	display_product();
		});

		function send_prod_mail() {
			$('.loader').show();
			$.post('<?php echo base_url()."Sales/opportunity_prod_email/".$code."/".$inid."/"; ?>'+panel_flg, {
				'product' : prod,
				'email' : email_array,
				'subject' : $('#subject').val(),
				'content' : $('#body_text').val()
			}, function(data, status, xhr) {
				$('.loader').hide();
				window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;	
			}, 'text');
		}

		function send_store_mail() {
			$('.loader').show();
			$.post('<?php echo base_url()."Sales/opportunity_send_email/".$code."/".$inid."/"; ?>'+panel_flg, {
				'files' : repo,
				'email' : email_array,
				'subject' : $('#subject').val(),
				'content' : $('#body_text').val()
			}, function(data, status, xhr) {
				$('.loader').hide();
				window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;	
			}, 'text');
		}

		function send_temp_mail() {
			$('.loader').show();
			$.post('<?php echo base_url()."Sales/opportunity_temp_email/".$code."/".$inid."/"; ?>'+panel_flg, {
				'files' : repo,
				'email' : email_array,
				'subject' : $('#subject').val(),
				'content' : $('#body_text').val()
			}, function(data, status, xhr) {
				$('.loader').hide();
				window.location = '<?php echo base_url()."Sales/opportunity_details/".$code."/save/"; ?>'+data;	
			}, 'text');
		}

		function send_upload_mail() {
			if($('.u_multiple')[0].files[0]) {
				var datat = new FormData();
	            var ins = $('.u_multiple')[0].files.length;
	            for (var x = 0; x < ins; x++) {
	                datat.append("used[]", $('.u_multiple')[0].files[x]);
	            }
				$.ajax({
					url: "<?php echo base_url().'Sales/oppo_doc_upload/'.$inid.'/'.$code; ?>", // Url to which the request is send
					type: "POST",           // Type of request to be send, called as method
					data: datat, 			// Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,     // The content type used when sending data to the server.
					cache: false,           // To unable request pages to be cached
					processData:false,      // To send DOMDocument or non processed data file it is set to false
					success: function(data) // A function to be called if request succeeds
					{	
						var a = JSON.parse(data);
						repo = [];
						if (a.files.length > 0) {
							for (var i = 0; i < a.files.length; i++) {
								repo.push({ 'id' : a.files[i].icd_id , 'file_name' : a.files[i].icd_file});
							}
						}
						send_store_mail();
					}
				});
			}
		}
	});

	function btn_display() {
		var out = '';
		for (var i = 0; i < btn_arr.length; i++) {
			if (status == btn_arr[i].name) {
				out +='<button class="mdl-button mdl-button--raised mdl-button--colore mdl-button--accent oppo_action" id="'+btn_arr[i].name+'">'+btn_arr[i].name+'</button>';
			}else{
				out +='<button class="mdl-button oppo_action" id="'+btn_arr[i].name+'">'+btn_arr[i].name+'</button>';	
			}
		}
		$('.add_action').empty();
		$('.add_action').append(out);	
	}
	function email_append(){
		var a = '';
		$('#exist_email').empty();
		if (email_array.length > 0) {
			for (var i = 0; i < email_array.length; i++) {
				a+='<tr><td><input type="checkbox" id="'+ i +'"/></td><td> '+ email_array[i].email +'</td></tr>';
			}
			$('#exist_email').append(a);
		}
	}
	function display_notes() {
		var out = '';
		if (note_arr.length > 0) {
			for (var i = 0; i < note_arr.length; i++) {
				out +='<tr class="tbl_view edit" id='+note_arr[i].id+'><td class="mdl-data-table__cell--non-numeric">'+note_arr[i].note+'</td><td class="mdl-data-table__cell--non-numeric">'+note_arr[i].date+'</td></tr>';
			}
		}else{
			$('.notes_table').hide();
		}
		$('#notes_table').empty();
		$('#notes_table').append(out);
	}
	function display_information() {
		var out = '';
		if (info_arr.length > 0) {
			for (var i = 0; i < info_arr.length; i++) {
				out +='<tr class="tbl_view" id='+info_arr[i].id+'><td class="mdl-data-table__cell--non-numeric">'+info_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+info_arr[i].date+'</td></tr>';
			}
		}else{
			$('.info_table').hide();
		}
		$('#info_table').empty();
		$('#info_table').append(out);
	}
	function display_file() {
		var out = '';
		if (file_arr.length > 0) {
			for (var i = 0; i < file_arr.length; i++) {
				out +='<tr class="tbl_view add_repo" id='+file_arr[i].id+'><td class="mdl-data-table__cell--non-numeric">'+file_arr[i].file_name+'</td></tr>';
			}
		}else{
			out +='<tr><td style="text-align:left;">No records !</td></tr>';
		}
		$('#repo_table').empty();
		$('#repo_table').append(out);
	}
	function display_selected_repo() {
		var out ='';
		for (var i = 0; i < repo.length; i++) {
			out +='<span class="mdl-chip mdl-chip--deletable" style="margin-right: 10px;margin-bottom: 10px;margin-top: 10px;"><span class="mdl-chip__text">'+repo[i].file_name+'</span><button id="'+repo[i].id+'" type="button" class="mdl-chip__action repo_delete"><i class="material-icons">cancel</i></button></span>';
		}
		$('#selected').empty();
		$('#selected').append(out);
	}
	
	function display_product(){
		var out = '';
		if (product_arr.length > 0) {
			for (var i = 0; i < product_arr.length; i++) {
				out +='<tr class="tbl_view add_product" id='+product_arr[i].id+'><td class="mdl-data-table__cell--non-numeric">'+product_arr[i].file_name+'</td></tr>';
			}
		}else{
			out +='<tr><td style="text-align:left;">No records !</td></tr>';
		}
		$('#product_table').empty();
		$('#product_table').append(out);
	}
	function display_selected_product() {
		var out ='';
		for (var i = 0; i < prod.length; i++) {
			out +='<span class="mdl-chip mdl-chip--deletable" style="margin-right: 10px;margin-bottom: 10px;margin-top: 10px;"><span class="mdl-chip__text">'+prod[i].file_name+'</span><button id="'+prod[i].id+'" type="button" class="mdl-chip__action repo_delete"><i class="material-icons">cancel</i></button></span>';
		}
		$('#prod_selected').empty();
		$('#prod_selected').append(out);
	}

	function load_proposal() {
    	var a ="";
    	if (proposal_arr.length > 0) {
    		for (var i = 0; i < proposal_arr.length; i++) {
	    		a+='<tr class="proposal_edit" id="'+proposal_arr[i].id+'"><td class="mdl-data-table__cell--non-numeric" style="text-align: left;">'+proposal_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric" style="text-align: center;">'+proposal_arr[i].date+'</td>';
		    	a+='<td class="mdl-data-table__cell--non-numeric" style="text-align: right;">'+proposal_arr[i].txn_no+'</td>';
	    		a+='</tr>';
	    	}
    	}else{
    		$('#proposal_table').hide();
    	}
    	$('#proposal_table').empty();
    	$('#proposal_table').append(a);
    }

	function load_activity() {
    	var a ="";
    	if (activity_arr.length > 0) {
	    	for (var i = 0; i < activity_arr.length; i++) {
	    		a+='<tr class="activity_edit " id="'+activity_arr[i].id+'"><td class="mdl-data-table__cell--non-numeric" style="text-align: left;">'+activity_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric" style="text-align: center;">'+activity_arr[i].date+'</td>';
		    	if (activity_arr[i].cat != '') {
		    		a+='<td class="mdl-data-table__cell--non-numeric" style="text-align: right;">'+activity_arr[i].cat+'</td>';
		    	}else{
		    		a+='<td class="mdl-data-table__cell--non-numeric" style="text-align: right;">None</td>';
		    	}
	    		a+='</tr>';
	    	}
	    }else{
	    	$('#activity_list').hide();
	    }	
    	$('#activity_list').empty();
    	$('#activity_list').append(a);
    }

    function switch_account(){
		var out = '';
		if (user_data.length > 0) {
			for (var i=0; i < user_data.length; i++) {
        		if (gid == user_data[i].id) {
        			out+= '<button class="mdl-button mdl-button--raised mdl-button--colored transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
        		}else{
        			out+= '<button class="mdl-button transfer_to_group" id="'+user_data[i].id+'" style="margin-right: 10px;width: 100%"><i class="material-icons">group</i> '+user_data[i].name+'</button>';
        		}
    		}
		}else{
			out +='<h3>No records found !!</h3>'
		}
		$('#grp_body').empty();
    	$('#grp_body').append(out); 
	}
</script>