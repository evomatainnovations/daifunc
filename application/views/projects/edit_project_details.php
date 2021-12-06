<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<style>
	.dropdown-submenu {
	    position: relative;
	}

	.dropdown-submenu .dropdown-menu {
	    top: 0;
	    left: 100%;
	    margin-top: -1px;
	} 
    .chart-element {
        width: 225px;
        height: 225px;
    }
    .chart-element-new {
        width: 350px;
        height: 350px;
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
	}

	.general_table > tbody {
		border: 1px solid #ccc;
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

	.activity_list{
		border-radius: 15px;
	}
	b{
		font-size: 50%;
		font-family: arial;
	}
	/*.popover{
		width: 100%;
	}*/
	.popover {
		min-width: 25%;
		z-index: 1 !important;
	}

	.ui-datepicker-div { z-index: 99999999 !important; }
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--11-col" style="overflow: auto;border: 1px solid #ccc;background-color: rgba(240, 240, 240, 0.57);">
			<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="pro_home" ><i class="material-icons">home</i> Project Home</button>
			<?php
				if (isset($nav_project)) {
					for ($i=0; $i < count($nav_project) ; $i++) {
						echo ' >> ';
						echo '<a href="'.base_url().'Projects/edit_project_details/'.$code.'/'.$pid.'/'.$nav_project[$i]->iextptg_id.'"><button class="mdl-button mdl-js-button mdl-js-ripple-effect" >'.$nav_project[$i]->iextptg_name.'</button></a>';
					}
				}
			?>
		</div>
		<div class="mdl-cell mdl-cell--1-col" style="text-align: center;">
			<div class="po-markup">
            	<a href="#" class="btn btn-lg btn-default po-link">Filters</a>
                <div class="po-content" style="display: none;">
                	<div class="po-title"><h4>Filter by</h4></div>
                	<div class="po-body">
                		<div class="mdl-grid">
                			<div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" data-type="Date" id="f_date" style="outline: none;" placeholder="From date">
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" data-type="Date" id="t_date" style="outline: none;" placeholder="To date">
                                </div>   
                            </div>
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
                                    <input class="mdl-textfield__input" type="text" id="f_title" style="outline: none;" placeholder="Enter title">
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--12-col" style="padding-top: 10px">
                                <div class="mdl-textfield mdl-js-textfield">
                                    <select class="mdl-textfield__input" id="f_cat">
                                        <option value="null">Categories</option>
                                        <?php for($i=0; $i < count($act_cat); $i++) {
                                            echo '<option value="'.$act_cat[$i].'">'.$act_cat[$i].'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--12-col" style="padding-top: 10px">
                                <div class="mdl-textfield mdl-js-textfield">
                                    <select class="mdl-textfield__input" id="f_status">
                                        <option value="null">Status</option>
                                        <?php for($i=0; $i < count($act_status); $i++) {
                                            echo '<option value="'.$act_status[$i].'">'.$act_status[$i].'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                			<div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
                        		<button type="button" class="mdl-button mdl-button--colored filter">Filter</button>
                			</div>
                		</div>
                    </div>
                 </div>
            </div>
		</div>
		<div class="mdl-cell mdl-cell--12-col">
		    <?php
		    if(isset($admin)) {
		    	if ($admin == 'true') {
		    		echo '<a href="'.base_url().'Projects/edit_project/'.$pid.'/'.$code.'"><button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="edit_main_info"><i class="material-icons">edit</i> Edit Project Details</button></a>';
		    		echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect"  id="add_task_groups"><i class="material-icons">add</i> Add Group</button>';
		    		if (isset($project_grp)) {
		    			if (count($project_grp) > 0) {
			    			echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="add_task"><i class="material-icons">add</i> Add Task</button>';	
			    			echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="pro_list"><i class="material-icons">add_to_queue</i> Add product list</button>';
			    			echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="pro_cost"><i class="material-icons">remove_red_eye</i> View Group Costing</button>';
			    		}
		    		}
		    		echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="add_doc"><i class="material-icons">folder</i> Upload Documents</button>';
		    	}
		    }
		    if (isset($project)) {
		    	if ($project == 'true') {
		    		echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="add_task_groups"><i class="material-icons">add</i> Add Groups</button>';
		    		if (isset($project_grp)) {
			    		if (count($project_grp) > 0) {
			    			echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="add_task"><i class="material-icons">add</i> Add Task</button>';
			    			echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="pro_list"><i class="material-icons">add_to_queue</i> Add product list</button>';
			    		}
			    	}
		    		echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="add_doc"><i class="material-icons">folder</i> Upload Documents</button>';
		    	}else{
		    		if (isset($project_grp)) {
			    		if (count($project_grp) > 0) {
				    		echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="add_task"><i class="material-icons">add</i> Add Task</button>';
				    		echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="pro_list"><i class="material-icons">add_to_queue</i> Add product list</button>';
				    	}
				    }
			    	echo '<button class="mdl-button mdl-js-button mdl-js-ripple-effect" id="add_doc"><i class="material-icons">folder</i> Upload Documents</button>';
			    }
		    }
			?>
	    </div>
	</div>   
	<div class="mdl-grid list_group">
	    <?php 
	    	for($i=0;$i < count($project_details); $i++) {
	            $values_str=[];
	            $arr_color = [];
				$opacity = rand(0.0, 1.0);

				$labels = [];
				$values = [];
				$value_title = "Testing My chart-element";
				echo '<div class="mdl-cell mdl-cell--4-col mdl-shadow--3dp mdl-cell--12-col-tablet" style="border-radius:20px;" id="'.$project_details[$i]->iextptg_id.'">';
					echo '<div class="mdl-grid" style="text-align:center;"><div class="mdl-cell mdl-cell--12-col"><div class="chart-element" style="margin:3px auto;"><canvas id="ch'.$i.'" width="60" height="60"></canvas></div></div><div class="mdl-cell mdl-cell--12-col"><h2>'.$project_details[$i]->iextptg_name.'</h2>';
					$tmpusr = []; $flg=false;
		            if (isset($g_user)) {
		            	for($j=0; $j< count($g_user); $j++) {
			                if($g_user[$j]->iextprour_task_gid == $project_details[$i]->iextptg_id) {
			                    array_push($tmpusr, $g_user[$j]->ic_name);
			                    $flg=true;
			                }
			            }
		            }
		            if ($flg==true) {
		            	echo '<button class="mdl-button mdl-button--icon"><i class="material-icons">group</i></button>'.implode(', ', $tmpusr);
		            }
					echo '</div></div>';
					echo '<hr>';
					echo '<div class="mdl-grid">';
					echo '<div class="mdl-cell mdl-cell--8-col"><button class="mdl-button mdl-button--colored project_grp" id="'.$project_details[$i]->iextptg_id.'"> view details</button>';
					if(isset($admin)) {
		    			if ($admin == 'true') {
		    				echo '<button class="mdl-button mdl-button--colored grp_edit" id="'.$project_details[$i]->iextptg_id.'"> edit group</button>';
		    			}
		    		}
		    		echo "</div>";
		    		for ($ik=0; $ik < count($grp_cost) ; $ik++) { 
		    			if ($project_details[$i]->iextptg_id == $grp_cost[$ik]['key']) {
		    				echo '<div class="mdl-cell mdl-cell--4-col"><h4 style="text-align:center;">Total Cost : '.$grp_cost[$ik]['cost'].'</h4></div>';
		    			}
		    		}
		    		echo '</div>';
				echo '</div>';
				for ($j=0; $j <count($project_details_tasks) ; $j++) { 
					for ($ij=0; $ij < count($project_details_tasks[$j]['activities']); $ij++) {
						if ($project_details[$i]->iextptg_id == $project_details_tasks[$j]['key']) {
							if ($project_details_tasks[$j]['activities'][$ij]['status']!=null) {
								array_push($labels, $project_details_tasks[$j]['activities'][$ij]['status']);
								array_push($values, $project_details_tasks[$j]['activities'][$ij]['count']);
							}
						}
		            }	
				}
	            $tmp_lbl = array_values(array_unique($labels));
		        $labels_str = json_encode($tmp_lbl);
		        $values_str = json_encode($values);

		        echo '<script>var ctx = document.getElementById("ch'.$i.'").getContext("2d");';
				echo 'var myChart = new Chart(ctx, {type: "doughnut", data: {labels: '.$labels_str.', datasets: [{ label: "'.$value_title.'", data: '.$values_str.', backgroundColor: ["#ff0000", "#999", "rgba(202, 200, 16, 0.79)","#800000", "#000"] }] }, options: { title : { display: true, text: "Group Status" } , rotation : -0.1 * Math.PI } });</script>';
	        }
	    ?>
	</div>
	<div class="mdl-grid list_task"></div>
	<div class="mdl-grid" id="work_area" style="display:none;">
	    <div class="mdl-cell mdl-cell--4-col">
	        <div class="mdl-card" style="border:1px solid #999; border-radius:5px; padding:15px;text-align:left;">
	            <p class="tg_name" id="1">Task Group Name</p>
	            <input type="text" class="mdl-textfield__input tg_name_input" id="gni1">
	        </div>
	    </div>
	</div>
</div>
</div>
</body>
<div class="modal fade" id="manage_Modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="text-align: center;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Add Group</h3>
			</div>
			<div class="modal-body">
				<div class="mdl-grid">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input class="mdl-textfield__input" type="text" id="g_name">
							<label class="mdl-textfield__label" for="g_name">Enter group name</label>
						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="grp_list">
							<select class="mdl-textfield__input" id="pg_name" name="octane">
								<?php
									if ($p_grp == 0) {
										echo '<option value="0" selected>select parent group</option>';
									}else{
										echo '<option value="0">select parent group</option>';
									}
									if (isset($project_grp)) {
										for ($i=0; $i <count($project_grp) ; $i++) {
											if ($p_grp == $project_grp[$i]->iextptg_id) {
												echo '<option value="'.$project_grp[$i]->iextptg_id.'" selected>'.$project_grp[$i]->iextptg_name.'</option>';
											}else{
												echo '<option value="'.$project_grp[$i]->iextptg_id.'">'.$project_grp[$i]->iextptg_name.'</option>';	
											}
										}	
									}
								?>
						    </select>
						</div>
						<table id="p_list" class="general_table">
		                    <thead>
		                        <tr>
		                            <th>Name</th><th>Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    	
		                    </tbody>
		                </table>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="text-align:left;">
						<button class="mdl-button mdl-button--colored" id="add_grp"><i class="material-icons">save</i> save</button>
					</div>
					<div class="mdl-cell mdl-cell--6-col" style="text-align:right;">
						<button class="mdl-button mdl-button--colored" id="delete_group"><i class="material-icons">delete</i> Delete</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="activity_Modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Reschedule</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" data-type="date" id="r_date" value="<?php echo date('Y-m-d H:m');?>">
                    <label class="mdl-textfield__label" for="r_date">Date</label>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button btn-default" data-dismiss="modal" id="r">Reshedule</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_note" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add Comments</h4>
            </div>
            <div class="modal-body">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="pro_note">
                    <label class="mdl-textfield__label" for="pro_note">Enter Comments</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal" id="pro_note_save">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="product_list" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add Product</h3>
            </div>
            <div class="modal-body" style="height: 70vh;overflow: auto;">
            	<div class="mdl-grid">
            		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col--tablet">
            			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="text" id="prod_name">
						    <label class="mdl-textfield__label" for="prod_name">Enter product name</label>
						</div>	
            		</div>
            		<div class="mdl-cell mdl-cell--4-col mdl-cell--12-col--tablet">
            			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="text" id="prod_rate">
						    <label class="mdl-textfield__label" for="prod_rate">Enter product rate</label>
						</div>
            		</div>
            		<div class="mdl-cell mdl-cell--3-col mdl-cell--12-col--tablet">
            			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="text" id="prod_qty">
						    <label class="mdl-textfield__label" for="prod_qty">Enter product qty</label>
						</div>
            		</div>
            		<div class="mdl-cell mdl-cell--1-col mdl-cell--12-col--tablet">
            			<button class="mdl-button mdl-button--colored mdl-button--raised prod_add_to_list"><i class="material-icons">add</i> Add</button>
            		</div>
            		<div class="mdl-cell mdl-cell--12-col">
            			<table class="general_table">
            				<thead>
            					<th>Action</th>
            					<th>Sr. no</th>
            					<th>Product name</th>
            					<th>Rate</th>
            					<th>Qty</th>
            					<th>Total</th>
            				</thead>
            				<tbody class="prod_table"></tbody>
            			</table>
            		</div>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="save_product_list"><i class="material-icons">save</i> Save</button>
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
	var user_arr = [];
    var selected_group=0;
    var staff_name = [];
    var staff_role = [];
    var staff_access = [];
    var grp_flg = 0;
    var tmpid = "";
    var adaptid = "";
    var task_arr =[],task_todo=[],task_person=[],task_perform=[],task_comment=[];
    var todo_array=[];
    var prod_arr = [] ;
    var prod_flg = 0 ;
    var prod_list = [];
    var prod_edit_flg = 0;
    var prod_edit = 0 ;
    var cat_list = [];
    <?php
    	echo 'var project_id = '.$pid.';';
    	echo 'var project_g_id = '.$p_grp.';';
    	if (isset($g_task)) {
			for ($i=0; $i < count($g_task) ; $i++) {
				if ($g_task[$i]->iua_status == 'progress') {
					echo "task_arr.push({'id' : '".$g_task[$i]->iua_id."', 'title' : '".$g_task[$i]->iua_title."', 'place': '".$g_task[$i]->iua_place."', 'todo' : '".$g_task[$i]->iua_to_do."', 'note' : '".$g_task[$i]->iua_note."', 'date' : '".$g_task[$i]->iua_date."','cat' : '".$g_task[$i]->iua_categorise."', 'pid' : '".$g_task[$i]->iua_p_activity."','status' : '".$g_task[$i]->iua_status."', 'modify' : '".$g_task[$i]->iua_modified_by."', 'shortcuts' : '".$g_task[$i]->iua_shortcuts."','m_shortcuts' : '".$g_task[$i]->iua_m_shortcuts."','color' : '".$g_task[$i]->iua_color."','e_date' : '".$g_task[$i]->iua_end_date."'});";
				}
    		}
    		for ($i=0; $i < count($g_task) ; $i++) {
				if ($g_task[$i]->iua_status != 'progress') {
					echo "task_arr.push({'id' : '".$g_task[$i]->iua_id."', 'title' : '".$g_task[$i]->iua_title."', 'place': '".$g_task[$i]->iua_place."', 'todo' : '".$g_task[$i]->iua_to_do."', 'note' : '".$g_task[$i]->iua_note."', 'date' : '".$g_task[$i]->iua_date."','cat' : '".$g_task[$i]->iua_categorise."', 'pid' : '".$g_task[$i]->iua_p_activity."','status' : '".$g_task[$i]->iua_status."', 'modify' : '".$g_task[$i]->iua_modified_by."', 'shortcuts' : '".$g_task[$i]->iua_shortcuts."','m_shortcuts' : '".$g_task[$i]->iua_m_shortcuts."','color' : '".$g_task[$i]->iua_color."','e_date' : '".$g_task[$i]->iua_end_date."'});";
				}
    		}
    		for ($i=0; $i < count($task_todo); $i++) {
                echo "task_todo.push({'id' : '".$task_todo[$i]->iextpt_aid."' ,'tid' : ".$task_todo[$i]->iuat_id." , 'title' : '".$task_todo[$i]->iuat_title."', 'status' : '".$task_todo[$i]->iuat_status."'});";
            }
            for ($i=0; $i <count($task_person) ; $i++) {
	            echo "task_person.push({'id' : ".$task_person[$i]->iextpt_aid.",'tag_name' : '".$task_person[$i]->ic_name."'});";
	        }
	        for ($i=0; $i <count($task_perform) ; $i++) {
	            echo "task_perform.push({'cid' : '".$task_perform[$i]->ic_uid."','cname' : '".$task_perform[$i]->ic_name."'});";
	        }
    	}

    	if (isset($task_comment)) {
    		for ($i=0; $i <count($task_comment) ; $i++) { 
    			echo "task_comment.push({'aid' : '".$task_comment[$i]->iextpt_aid."', 'name' : '".$task_comment[$i]->ic_name."','comment' : '".$task_comment[$i]->iextptc_comment."'});";
    		}
    	}

    	if (isset($project_users)) {
            for ($i=0; $i <count($project_users) ; $i++) {
                if ($project_users[$i]->iextprour_pid != '') {
                	if ($project_users[$i]->iextprour_group != 'false' || $project_users[$i]->iextprour_project != 'false') {
                		if ($project_users[$i]->ium_admin == 'true') {
	                        if ($project_users[$i]->ic_name == '') {
	                            echo "user_arr.push({'id' : ".$project_users[$i]->ium_u_id.", 'email' : '".$project_users[$i]->i_uname."', 'admin' : 'true', 'project' : 'true', 'group' : 'true'});";
	                        }else{
	                            echo "user_arr.push({'id' : ".$project_users[$i]->ic_uid.", 'email' : '".$project_users[$i]->ic_name."', 'admin' : 'true','project' : 'true', 'group' : 'true'});";  
	                        }
	                    }else{
	                    	if ($project_users[$i]->iextprour_group == 'true' && $project_users[$i]->iextprour_task_gid != '') {
	                    		$group = 'true';
	                    	}else{
	                    		$group = 'false';
	                    	}
	                        if ($project_users[$i]->ic_name == '') {
	                            echo "user_arr.push({'id' : ".$project_users[$i]->ium_u_id.", 'email' : '".$project_users[$i]->i_uname."', 'admin' : 'false','project' : '".$project_users[$i]->iextprour_project."', 'group' : '".$group."'});";
	                        }else{
	                            echo "user_arr.push({'id' : ".$project_users[$i]->ic_uid.", 'email' : '".$project_users[$i]->ic_name."', 'admin' : 'false','project' : '".$project_users[$i]->iextprour_project."', 'group' : '".$group."'});";
	                        }
	                    }
                	}
                }
            }
        }

        if (isset($product)) {
        	for ($i=0; $i < count($product) ; $i++) { 
        		echo "prod_arr.push({'id' : '".$i."' , 'name' : '".$product[$i]->ip_product."' , 'qty' : '".$product[$i]->iextppl_qty."' , 'rate' : '".$product[$i]->iextppl_rate."' , 'tax' : '' });";
        		echo "prod_flg++;";
        	}
        }

        if (isset($prod_list)) {
        	for ($i=0; $i < count($prod_list) ; $i++) { 
        		echo "prod_list.push('".$prod_list[$i]->ip_product."');";
        	}
        }
    ?>
    $(document).ready(function() {
    	display_task();
    	display_prod_list();

    	$('.po-markup > .po-link').popover({
            trigger: 'click',
            html: true,
            title: function() {
                return $(this).parent().find('.po-title').html();
            },
            content: function() {
                return $(this).parent().find('.po-body').html();
            },
            placement: 'bottom'
        }).on('shown.bs.popover', function () {
	        $("#f_date").bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});
        	$("#t_date").bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});
        	$('.filter').click(function (e) {
        		e.preventDefault();
        		$.post('<?php echo base_url()."Projects/project_filter/".$code; ?>', {
					'f_date' : $("#f_date").val(),
					't_date' : $("#t_date").val(),
					'title' : $("#f_title").val(),
					'cat' : $("#f_cat").val(),
					'status' : $("#f_status").val(),
					'p_gid' : project_g_id,
					'pid' : project_id
				}, function(data, status, xhr) {
					var a = JSON.parse(data);
					task_arr = [];
					if (a.g_task.length > 0) {
						for (var i = 0; i < a.g_task.length; i++) {
							task_arr.push({id : a.g_task[i].iua_id, title : a.g_task[i].iua_title, place : a.g_task[i].iua_place , todo : a.g_task[i].iua_to_do, note : a.g_task[i].iua_note, date : a.g_task[i].iua_date,cat : a.g_task[i].iua_categorise, pid : a.g_task[i].iua_p_activity,status : a.g_task[i].iua_status, modify : a.g_task[i].iua_modified_by, shortcuts : a.g_task[i].iua_shortcuts,m_shortcuts : a.g_task[i].iua_m_shortcuts,color : a.g_task[i].iua_color,e_date : a.g_task[i].iua_end_date});
						}
					}
					display_task();
				})
        	});
	    });

    	var snackbarContainer = document.querySelector('#demo-toast-example');
		$( "#r_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm'});
        $('.task_todo').css('height', (window.innerHeight-180));
	    <?php
		    for($i=0;$i < count($project_details); $i++) {
			}
		?>
        function change_group_text(id, prefix, state, value) {
            var tmp_id = prefix + id;
            if(state == "start") {
                $(id).css('display','none');
                $(tmp_id).css('display','block');
                $(tmp_id).focus();
            } else if(state == "end") {
                $(tmp_id).css('display','none');
                $(id).html(value);
                $(id).css('display','block');
                
            }
        }
		///////////////////////// Product Add list /////////////////////
        $("#prod_name" ).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(prod_list, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_prod_details(value);
            }    
        });

        $('#product_list').on('click','.prod_add_to_list' , function (e) {
        	e.preventDefault();
        	var pname = $('#prod_name').val();
        	var pqty = $('#prod_qty').val();
        	var prate = $('#prod_rate').val();
        	var ptax = '';//$('#prod_tax').val();
        	if (prod_edit_flg == 1) {
        		prod_arr[prod_edit].name = pname;
        		prod_arr[prod_edit].qty = pqty;
        		prod_arr[prod_edit].rate = prate;
        	}else{
        		prod_arr.push({ id : prod_flg , name : pname , qty : pqty , rate : prate , tax : ptax });
        		prod_flg++;
        	}
        	prod_edit_flg = 0 ;
        	clearall();
        	display_prod_list();
        });

        $('.prod_table').on('click','.edit_product',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	prod_edit_flg = 1 ;
        	prod_edit = id;
        	$('#prod_name').val(prod_arr[id].name);
        	$('#prod_qty').val(prod_arr[id].qty);
        	$('#prod_rate').val(prod_arr[id].rate);
        	$('#prod_qty').focus();
        });

        $('.prod_table').on('click','.delete_product',function (e) {
        	e.preventDefault();
        	var id = $(this).prop('id');
        	prod_arr.splice(id, 1);
        	display_prod_list();
        });

        $('#save_product_list').click(function (e) {
        	e.preventDefault();
        	$.post('<?php echo base_url()."Projects/save_product_list/".$code."/".$pid."/".$p_grp; ?>',{
        		'p_list' : prod_arr
			}, function(data, status, xhr) {
				var data = {message: 'Product list save !'};
                snackbarContainer.MaterialSnackbar.showSnackbar(data);
			}, "text");
        });

        function clearall() {
        	$('#prod_name').val('');
        	$('#prod_qty').val('');
        	$('#prod_rate').val('');
        	// $('#prod_tax').val('none');
        	$('#prod_name').focus();
        }

        function get_prod_details(product_name) {
			$.post('<?php echo base_url()."Enterprise/invoice_product_rate/".$code."/"; ?>'+product_name
				, function(data, status, xhr) {
				if (data == 'false') {
					$('#prod_rate').focus();
				}else{
					var a = JSON.parse(data);
					$('#prod_rate').focus();
					$('#prod_rate').val(a.prod_rate);
					// if (a.prod_tax != '') {
					// 	$('#prod_tax').val(a.prod_tax);
					// }
				}
			}, "text");
		}

		function display_prod_list(e) {
			var out = '';
			var srno = 1 ;
			var t_amount = 0 ;
			if (prod_arr.length > 0) {
				for (var i = 0; i < prod_arr.length; i++) {
					out += '<tr>';
					out +='<td><button class="mdl-button mdl-button--colored mdl-button--icon edit_product" id="'+i+'"><i class="material-icons">edit </i></button><button class="mdl-button mdl-button--colored mdl-button--icon delete_product" id="'+i+'"><i class="material-icons">delete </i></button></td><td>'+srno+'</td><td>'+prod_arr[i].name+'</td><td>'+prod_arr[i].rate+'</td><td>'+prod_arr[i].qty+'</td>';
					var amt = Number(prod_arr[i].qty) * Number(prod_arr[i].rate) ;
					out += '<td>'+amt+'</td>';
					out += '</tr>';
					t_amount = Number(t_amount) + Number(amt);
					srno++;
				}
				out += '<tr style="border: 1px solid #ccc;"><td colspan="5">Grand Total</td><td>'+t_amount+'</td></tr>';
			}else{
				out += '<tr><td colspan = "6" style="text-align:center;">Records not found !</td></tr>';
			}
			$('.prod_table').empty();
			$('.prod_table').append(out);
		}

		$('#pro_cost').click(function (e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Projects/project_costing/'.$code.'/'.$pid.'/'; ?>";
		});

///////////////////////////// Project //////////////////////////////////
        $('#pro_list').click(function (e) {
        	e.preventDefault();
        	$('#product_list').modal('show');
        	$('#prod_name').focus();
        });

        // $('.panel').on('click','.add_tasks',function(e) {
        //     e.preventDefault();
        //     grp_flg = $(this).prop('id');
        //     $('#project_activity').modal('toggle');
        // });
        
        $('#work_area').on('click','.tg_name', function(e) {
            e.preventDefault();
            change_group_text($(this).prop('id'), "#gni", "start", "");
        });
        
        $('#work_area').on('keydown', adaptid, function(e) {
            if(e.keyCode == 13) {
                change_group_text($(this).prop('id'), "#gni", "end", "");
            }
        });
	    
	    $('.task_list').on('click','tr', function(e) {
	        e.preventDefault();
	        var id = $(this).prop('id');
	        $.post('<?php echo base_url().'Projects/edit_task/'.$pid.'/'.$code.'/';?>'+id,
	        function (d,x,r) {
	        	window.location = "<?php echo base_url().'Home/activity/'.$code.'/'; ?>"+ d;
	        })
	    });
	    
	    $('.project_grp').click(function (e) {
	    	e.preventDefault();
	    	var grp_id = $(this).prop('id');
	    	window.location = "<?php echo base_url().'Projects/edit_project_details/'.$code.'/'.$pid.'/'; ?>"+ grp_id;
	    });

	    $('#add_doc').click(function (e) {
	    	e.preventDefault();
	    	window.location = "<?php echo base_url().'Projects/project_doc_details/'.$code.'/'.$pid; ?>";
	    });

	    $('#pro_home').click(function (e) {
	    	e.preventDefault();
	    	window.location = "<?php echo base_url().'Projects/edit_project_details/'.$code.'/'.$pid; ?>";
	    });

	    $('#add_task_groups').click(function (e) {
	    	e.preventDefault();
	    	$('#delete_group').css('display','none');
	    	display_ulist();
	    	$('#manage_Modal').modal('show');
	    })

	    $('#add_task').click(function (e) {
	    	e.preventDefault();
	    	$.post('<?php echo base_url()."View/activity_modal/".$code."/project/".$pid; ?>'
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
	    })

	    $('#add_staff').click(function(e) {
	       e.preventDefault();
	       addtolist();
	       updatelist();
	       resetfields();
	    });
	    
	    $('#staff_list').on('click', '.delete', function(e) {
	       e.preventDefault();
	       
	       deletefromlist($(this).prop('id'));
	       updatelist();
	    });

	    $('#p_list').on('click','.add',function (e){
	    	e.preventDefault();
            var a = $(this).prop('id');
            var status = a.substring(0, 3);
            var mid = a.substring(3, a.length);
            if (status == 'add') {
                for (var i = 0; i < user_arr.length; i++) {
                    if(user_arr[i].id == mid){
                        if (user_arr[i].group == 'true') {
                            user_arr[i].group = 'false';
                        }else{
                            user_arr[i].group = 'true';
                        }
                    }
                }
            }
            display_ulist();
        });

        $('.list_task').on('click', '.activity_action', function(e) {
            e.preventDefault();
            var a=$(this).prop('id');
            var b=a.substring(0,1);
            var c=a.substring(1, a.length);
            if (b == "r") {
                $('#activity_Modal').modal('show');
                re_id = c;
            }else if(b == "e"){
                $.post('<?php echo base_url()."View/activity_edit/".$code."/"; ?>'+c+'/<?php echo $pid; ?>/project'
	            , function(data, status, xhr) {
	                $('#activity_modal > div > div').empty();
	                $('#activity_modal > div > div').append(data);
	            }, 'text');
	            $('#activity_modal').modal('toggle');
            }else if (b == "d") {
        		re_id = c;
        		$('#add_note').modal('show');
            }else if (b == "l") {
				add_to_active(c);
            }else{
        		update_activity_status(c, b);
        	}
        });

        function add_to_active(aid) {
            $.post('<?php echo base_url()."Home/add_to_active_list/".$code."/"; ?>'+aid,
            function(d, s,x) {
                if (d == 'true') {
                    var data = {message: 'Added to active list !'};
                }else{
                    var data = {message: 'Already added to active list !'};
                }
                snackbarContainer.MaterialSnackbar.showSnackbar(data);
            }, "text");
        }

        $('#add_note').on('click','#pro_note_save',function (e) {
        	e.preventDefault();
        	$.post('<?php echo base_url()."Projects/project_activity_comments/".$code.'/'.$pid.'/'.$p_grp; ?>', {
                'id' : re_id, 'p_note' : $('#pro_note').val()
            }, function(d, s,x) {
            	var s = 'd';
                update_activity_status(re_id,s);
            }, "text");
        });

        $('#activity_Modal').on('click', '#r', function(e) {
            $.post('<?php echo base_url()."Home/activity_resheduled/".$code; ?>', {
                'id' : re_id, 'r_date' : $('#r_date').val()
            }, function(d, s,x) {
                if (d == 'true') {
                    window.location = "<?php echo base_url().'Projects/edit_project_details/'.$code."/".$pid."/".$p_grp; ?>";
                }
            }, "text");
        });

        $('.todo_table').on('change', 'input[type=checkbox]', function(e) {
        	e.preventDefault();
            var id = $(this).prop('id');
            var status = $(this)[0].checked;
            $.post('<?php echo base_url()."Home/activity_update_todo/".$code; ?>', {
                'i' : id, 's' : status
            }, function(d, s,x) {
            }, "text");
        });

        function update_activity_status(id, status) {
	        $.post('<?php echo base_url()."Home/activity_status_update/".$code; ?>', {
	            'i' : id,
	            's' : status,
	            'cmt' : $('#pro_note').val()
	        }, function(d,s,x) {
	        	act_id = '';
	            window.location = "<?php echo base_url().'Projects/edit_project_details/'.$code."/".$pid."/".$p_grp; ?>";
	        })
	    }
	    
	    function addtolist() {
	        staff_name.push($('#staff')[0].innerText);
	        staff_role.push($('#staff_role').val());
	        staff_access.push($('#staff_access')[0].checked);
	    }
	    
	    function updatelist()  {
	        $('#staff_list > tbody').empty();
	        
	        var out = "";
	        for(var i=0; i<staff_name.length; i++) {
	            out += '<tr><td><button class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored delete" id="' + i + '"><i class="material-icons">delete</i></button></td><td>' + staff_name[i] + '</td><td>' + staff_role[i] + '</td><td>' + staff_access[i] + '</td></tr>';
	        }
	        $('#staff_list > tbody').append(out);
	    }
	    
	    function deletefromlist(id) {
	        staff_name.splice(id, 1);
	        staff_role.splice(id, 1);
	        staff_access.splice(id, 1);
	    }
	    
	    function resetfields() {
            $('#staff > .tagit-choice').remove();
    	    
    	    $('#staff').data("ui-tagit").tagInput.focus();
	    }
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
			if($('#search_modal').css('display') == 'none'){
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
				$.post('<?php if (isset($edit_activity)) {echo base_url()."Projects/update_task/".$pid."/".$code."/".$aid;}else{ echo base_url()."Projects/save_task/".$pid."/".$code; } ?>', {
					'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'grp' : $('#a_pg_name').val()
				}, function(data, status, xhr) {
					window.location = '<?php echo base_url()."Projects/edit_project_details/".$code."/".$pid."/".$p_grp; ?>';
				}, 'text');
			}else{
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

		$('#add_grp').click(function(e) {
			e.preventDefault();
			if (selected_group == 0 ) {
				$.post('<?php echo base_url()."Projects/save_task_group/".$pid.'/'.$code; ?>', {
                    'name' : $('#g_name').val(),
                    'people' : user_arr,
                    'sel' : $('#pg_name').val()
                }, function(data, status, xhr) {
                   window.location = '<?php echo base_url()."Projects/edit_project_details/".$code."/".$pid."/".$p_grp; ?>';
                }, 'text');
			}else{
				$.post('<?php echo base_url()."Projects/update_task_group/".$pid.'/'.$code; ?>', {
                    'sel_gid' : selected_group,
                    'name' : $('#g_name').val(),
                    'people' : user_arr,
                    'sel' : $('#pg_name').val()
                }, function(data, status, xhr) {
                   	window.location = '<?php echo base_url()."Projects/edit_project_details/".$code."/".$pid."/".$p_grp; ?>';
                }, 'text');
			}
		});

		$('.close_modal').click(function(e){
            e.preventDefault();
            window.location = "<?php echo base_url().'Projects/edit_project_details/'.$code."/".$pid."/".$p_grp; ?>";
        });

		$('#grp_list').on('click','.dropdown-submenu a.test', function(e){
			console.log('hi');
			$(this).next('ul').toggle();
			e.stopPropagation();
			e.preventDefault();
		});

		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();
			$.post('<?php echo base_url()."Projects/project_search/".$code; ?>', {
				'search' : $(this).val(),
				'p_gid' : project_g_id,
				'pid' : project_id
			}, function(data, status, xhr) {
				var a = JSON.parse(data);
				task_arr = [];
				if (a.g_task.length > 0) {
					for (var i = 0; i < a.g_task.length; i++) {
						task_arr.push({id : a.g_task[i].iua_id, title : a.g_task[i].iua_title, place : a.g_task[i].iua_place , todo : a.g_task[i].iua_to_do, note : a.g_task[i].iua_note, date : a.g_task[i].iua_date,cat : a.g_task[i].iua_categorise, pid : a.g_task[i].iua_p_activity,status : a.g_task[i].iua_status, modify : a.g_task[i].iua_modified_by, shortcuts : a.g_task[i].iua_shortcuts,m_shortcuts : a.g_task[i].iua_m_shortcuts,color : a.g_task[i].iua_color,e_date : a.g_task[i].iua_end_date});
					}
				}
				display_task();
			})
		});

		$('.grp_edit').click(function(e) {
			e.preventDefault();
			var gr_id = $(this).prop('id');
            $.post('<?php echo base_url()."Projects/get_task_group_details/".$pid.'/'.$code; ?>', {
                'tgid' : $(this).prop('id')
            }, function(data, status, xhr) {
            	var a=JSON.parse(data);
            	var count = 0;
            	var out = "";
            	selected_group=a.group[0].iextptg_id;
            	p_group=a.group[0].iextptg_p_grp;
            	$('#g_name').val(a.group[0].iextptg_name);
            	$('#delete_group').css('display','block');
            	user_arr = [];
            	if (a.g_list.length > 0) {
            		out += '<select class="mdl-textfield__input" id="pg_name" name="octane">';
            		out += '<option value="0">select parent group</option>';
            		for (var i = 0; i < a.g_list.length; i++) {
						if (p_group == a.g_list[i].iextptg_id) {
							out += '<option value="'+a.g_list[i].iextptg_id+'" selected>'+a.g_list[i].iextptg_name+'</option>';
						}else{
							out += '<option value="'+a.g_list[i].iextptg_id+'">'+a.g_list[i].iextptg_name+'</option>';	
						}
            		}
            		out += '</select>';
            	}
            	$('#grp_list').empty();
            	$('#grp_list').append(out);
            	console.log(a.edit_user_list);
                for (var i=0; i <a.edit_user_list.length ; i++) {
                	if (a.grp_user.length > 0) {
                		for (var j = 0; j < a.grp_user.length; j++) {
                    		if(a.grp_user[j].iextprour_uid == a.edit_user_list[i].i_uid){
                    			if (a.edit_user_list[i].ium_admin == 'true') {
		                            if (a.edit_user_list[i].ic_name == null || a.edit_user_list[i].ic_name == 'null' || a.edit_user_list[i].ic_name == '') {
		                                user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].i_uname, 'admin' : 'true', 'project' : 'true', 'group' : 'true'});
		                            }else{
		                                user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].ic_name, 'admin' : 'true','project' : 'true', 'group' : 'true'});  
		                            }
		                        }else{
		                            if (a.edit_user_list[j].iextprour_task_gid != '' || a.edit_user_list[j].iextprour_task_gid == selected_group) {
		                                var group = 'true';
		                            }else{
		                                var group = 'false';
		                            }
		                            if (a.edit_user_list[i].iextprour_pid != null) {
		                                if (a.edit_user_list[i].ic_name == null || a.edit_user_list[i].ic_name == 'null' || a.edit_user_list[i].ic_name == '') {
		                                    user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].i_uname, 'admin' : 'false','project' : a.edit_user_list[j].iextprour_project, 'group' : group});
		                                }else{
		                                    user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].ic_name, 'admin' : 'false','project' : a.edit_user_list[j].iextprour_project, 'group' : group});
		                                }
		                            }
		                        }
                    		}else{
                				if (a.edit_user_list.length != a.grp_user.length) {
                					if (a.edit_user_list[i].iextprour_pid != null && a.edit_user_list[i].iextprour_group == 'true') {
		                                if (a.edit_user_list[i].ic_name == null || a.edit_user_list[i].ic_name == 'null' || a.edit_user_list[i].ic_name == '') {
		                                    user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].i_uname, 'admin' : 'false','project' : 'false', 'group' : 'false'});
		                                }else{
		                                    user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].ic_name, 'admin' : 'false','project' : 'false', 'group' : 'false'});
		                                }
		                            }
                				}
                    		}
                    	}
                	}else{
                		if (a.edit_user_list[i].iextprour_pid != null && a.edit_user_list[i].iextprour_group == 'true') {
                            if (a.edit_user_list[i].ic_name == null || a.edit_user_list[i].ic_name == 'null' || a.edit_user_list[i].ic_name == '') {
                                user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].i_uname, 'admin' : 'false','project' : 'false', 'group' : 'false'});
                            }else{
                                user_arr.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].ic_name, 'admin' : 'false','project' : 'false', 'group' : 'false'});
                            }
                        }
                	}
                }
                display_ulist();
                $('#manage_Modal').modal('toggle');
            }, 'text');			
		});

		$('#delete_group').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Projects/delete_task_group/'.$code.'/'; ?>"+selected_group;
        })

		function display_ulist() {
			var a="";
	        if(user_arr.length > 0){
	            for (var i = 0; i < user_arr.length; i++) {
	                a +='<tr><td class="mdl-data-table__cell--non-numeric"><h4>'+user_arr[i].email+'</h4></td>';
	                a +='<td class="mdl-data-table__cell--non-numeric">';
	                if (user_arr[i].admin == 'true' || user_arr[i].project == 'true') {
	                    a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="add'+user_arr[i].id+'"><i class="material-icons">add</i></button>';
	                }else if (user_arr[i].group == 'true') {
	                    a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored add" id="add'+user_arr[i].id+'"><i class="material-icons">add</i></button>';
	                }else{
	                    a+='<button class="mdl-button mdl-js-button mdl-button--raised add" id="add'+user_arr[i].id+'"><i class="material-icons">add</i></button>';
	                }
	                a +='</td></tr>';
	            }
	        }

	        $('#p_list > tbody').empty();
	        $('#p_list > tbody').append(a);
		}

		function display_task() {
			var a = "",flg=0;
			for (var i = 0; i < task_arr.length; i++) {
				a+='<div class="mdl-cell mdl-cell--2-col"></div>';
				a+='<div class="mdl-cell mdl-cell--8-col">';
					a+='<div class="mdl-grid mdl-shadow--8dp activity_list" style="font-size:1em;border-radius:15px;" id="' + task_arr[i].id + '">';
		            a+='<div class="mdl-cell mdl-cell--10-col"><h1 style="font-size: 2.5rem;">' + task_arr[i].title + '</h1></div>';
		            a+='<div class="mdl-cell mdl-cell--2-col"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="e' + task_arr[i].id + '"><i class="material-icons">edit</i> edit</button></div>';
		            a+='<div class="mdl-grid" style="text-align:center;width:100%;">'
		            if (task_arr[i].color == 'red') {
		                 a+='<hr style="background-color:rgba(255, 0, 0, 0.63);width: 100%;margin: 20px;height:2px;">';
		            }else if (task_arr[i].color == 'white') {
		                 a+='<hr style="background-color:white;width: 80%;margin: 20px;height:2px;">';
		            }else if (task_arr[i].color == 'orange') {
		                a+='<hr style="background-color:rgba(255, 165, 0, 0.65);width: 100%;margin: 20px;height:2px;">';
		            }else if (task_arr[i].color == 'blue') {
		                a+='<hr style="background-color:rgba(0, 0, 255, 0.64);width: 100%;margin: 20px;height:2px;">';
		            }else if (task_arr[i].color == 'green') {
		                a+='<hr style="background-color:rgba(0, 128, 0, 0.74);width: 100%;margin: 20px;height:2px;">';
		            }else{
		                a+='<hr style="background-color:gray;width: 100%;margin: 20px;height:2px;">';
		            }
		            a+='</div>';
		            if (task_arr[i].todo==1) {
		                a+='<div class= "mdl-cell mdl-cell--12-col"><table class="todo_table">';
		                a+='<h4>Things to-do</h4>';
		                for (var j=0; j < task_todo.length; j++) {
		                    if (task_arr[i].id == task_todo[j].id) {
		                        a+='<tr><td>';
		                        if (task_todo[j].status == "false") {
		                            a+='<input type = "checkbox" id="' + task_todo[j].tid +'" class = "mdl-checkbox__input" > ' + task_todo[j].title;
		                        } else {
		                            a+='<input type = "checkbox" id="' + task_todo[j].tid +'" class = "mdl-checkbox__input" checked> ' + task_todo[j].title;
		                        }
		                        a+='</td></tr>';
		                    }
		                }
		                a+='</table></div>';
		            }
		            if (task_arr[i].note != '' && task_arr[i].note != null) {
		                var files;
		                var file_name = task_arr[i].note;
		                var path = '<?php echo base_url().'assets/data/'.$oid.'/activity/';?>'+file_name;
		                $.ajax({
		                    url: path,
		                    async: false,
		                    cache: false,
		                    dataType: "text",
		                    success: function( data, textStatus, jqXHR ) {
		                        files = data;
		                    }
		                });
		                a+='<div class="mdl-cell mdl-cell--12-col">'+files+'</div>';
		            }
		            a+='<div class="mdl-grid" style="width:100%;display:flex;font-weight:bold;">';
		            if (task_arr[i].cat != '') {
		                a+='<div class="mdl-cell mdl-cell--4-col"><i class="material-icons">category</i> '+task_arr[i].cat+'</div>';
		            }
		            if (task_arr[i].place != '') {
		                a+='<div class="mdl-cell mdl-cell--4-col"><i class="material-icons">location_on</i> '+task_arr[i].place+'</div>';
		            }
		            if(task_person.length > 1 ){
		                a+='<div class = "mdl-cell mdl-cell--4-col">';
		                for (var j = 0; j< task_person.length; j++) {
		                    if(task_person[j].id == task_arr[i].id){
		                        flg++;
		                        if(flg == 1){
		                            a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id=""><i class="material-icons">people</i></button>'
		                            a+= task_person[j].tag_name ;
		                        }else{
		                            a+= ' , ' + task_person[j].tag_name ;
		                        }
		                    }
		                }
		                a+='</div>';
		            }flg = 0;
		            a+='</div>';

		            var cust_name;
		            a+='<div class= "mdl-cell mdl-cell--4-col" style="text-align: right">';
		                for (var j = 0; j < task_perform.length; j++) {
		                   if (task_arr[i].modify == task_perform[j].cid) {
		                        cust_name = task_perform[j].cname;
		                        break;
		                    }
		                }
		            a+='</div>';
		            a+='<div class="mdl-cell mdl-cell--12-col activity_task_date">'+task_arr[i].date+' to '+task_arr[i].e_date+'</div>';
		            a+='<div class="mdl-cell mdl-cell--12-col" style="text-align:left;">';
		            if (task_arr[i].status == 'done') {
		                a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored activity_action" id="d' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">done</i>  Done by '+cust_name+'</button>';
		            }else{
		                a+='<button class="mdl-button mdl-js-button activity_action" id="d' + task_arr[i].id + '" style="text-align:left;width:100%;"><i class="material-icons">done</i> done</button>';
		            }
		            a+='<button class="mdl-button mdl-js-button activity_action" id="l' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">add</i> Add to active list</button>';
		            if (task_arr[i].status == 'progress') {
		                a+='<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised activity_action" id="p' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">arrow_right_alt</i> progress by '+cust_name+'</button>';
		            }else{
		                a+='<button class="mdl-button mdl-js-button activity_action" id="p' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">arrow_right_alt</i> progress</button>';
		            }
		            if (task_arr[i].status == 'reschedule') {
		                a+='<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised activity_action" id="r' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">calendar_today</i> Reshedule by '+cust_name+'</button>';
		            }else{
		                a+='<button class="mdl-button mdl-js-button activity_action" id="r' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons" >calendar_today</i> reschedule</button>';
		            }
		            
		            if (task_arr[i].status == 'cancel') {
		                a+='<button class="mdl-button mdl-js-button  mdl-button--colored mdl-button--raised activity_action activity_action" id="c' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">close</i> close by '+cust_name+'</button>';
		            }else{
		                a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="c' + task_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">close</i> close</button>';
		            }
		            a+='</div>';
		            if (task_comment.length > 0) {
		            	a+='<div class="mdl-cell mdl-cell--12-col">';
			            a+='<hr><h4>Comments</h4>';
			            for (var ik = 0; ik < task_comment.length; ik++) {
			            	if(task_comment[ik].aid == task_arr[i].id){
			            		a+='<h5>'+task_comment[ik].name+' : '+task_comment[ik].comment+'</h5>'
			            		break;
			            	}
			            }
			            a+='</div>';
		            }
		            a+='</div><div style="margin-top:10px;"></div>';
				a+='</div>';
				a+='<div class="mdl-cell mdl-cell--2-col"></div>';
			}
			$('.list_task').empty();
			$('.list_task').append(a);
		}
	});

</script>
</html>