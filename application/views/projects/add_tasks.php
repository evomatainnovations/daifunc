<style>
    #task_list {
        width:100%;
        /*display: block;*/
        overflow: auto;
        border-collapse:collapse;
        word-spacing:normal;
    }
    
    #task_list > thead {
        box-shadow: 0px 1px 5px #999;
    }
    
    #task_list > thead > tr > th {
        padding: 10px;
    }
    
    #task_list > tbody > tr > td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }
    
    .mdl-tabs__tab-bar > a:link {
	    color: #ff0000;
		text-decoration: none;
	}

	.mdl-tabs__tab-bar > a:visited {
	    color: #ff0000;
		text-decoration: none;
	}

    .mdl-tabs__tab-bar > a:hover {
	    color:#ff0000;
		text-decoration: none;
	}

	.mdl-tabs__tab-bar > a:active {
	    color:#ff0000;
		text-decoration: none;
	}
	
	.task-comments {
	    max-height:50vh;
	    height: 50vh;
	    overflow: auto;
	    display: -webkit-flex;
        display: -moz-flex;
        -webkit-flex-direction: column-reverse;
        -moz-flex-direction: column-reverse;
        display: flex;
        flex-direction: column-reverse;
        text-align:left;
	}
	
	.comment {
	    background-color: #ccc;
	    margin:10px;
	    height:auto !important;
	}
	.user-comment {
	    text-align:right;
	    /*float:right !important;*/
	    background-color:#f4433642;
	}
	
	.comment-description, .comment > span {
	    height:auto !important;
	}
</style>
<main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Group Details</h2>
				</div>
				
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="t_group" class="mdl-textfield__input">
						    <?php 
						        for($i=0;$i<count($edit_task_group); $i++) {
						            echo "<option value='".$edit_task_group[$i]->iextptg_id."'";
						            if(isset($edit_task)) {
						                if($edit_task[0]->iextpt_tg_id == $edit_task_group[$i]->iextptg_id) {
						                    echo " selected ";
						                }
						            }
						            echo ">".$edit_task_group[$i]->iextptg_name."</option>";
						        }
						    ?>
						</select>
						<label class="mdl-textfield__label" for="t_group">Select Group</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="t_name" class="mdl-textfield__input" value="<?php if(isset($edit_task)) { echo $edit_task[0]->iextpt_name; } ?>">
						<label class="mdl-textfield__label" for="t_name">Task Name</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="t_start_date" class="mdl-textfield__input" value="<?php if(isset($edit_task)) { echo $edit_task[0]->iua_date; } ?>">
						<label class="mdl-textfield__label" for="t_start_date">Select Start Date</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" data-type="date" id="t_end_date" class="mdl-textfield__input" value="<?php if(isset($edit_task)) { echo $edit_task[0]->iua_end_date; } ?>">
						<label class="mdl-textfield__label" for="t_end_date">Select End Date</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="t_desc" name="t_desc" class="mdl-textfield__input" value="<?php if(isset($edit_task)) { echo $note; } ?>">
						<label class="mdl-textfield__label" for="t_desc">Description</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="t_status" class="mdl-textfield__input">
							<option value="pending" <?php if(isset($edit_task)) { if($edit_task[0]->iua_status == "pending") { echo "selected"; } } ?> >Pending</option>
						    <option value="progress" <?php if(isset($edit_task)) { if($edit_task[0]->iua_status == "progress") { echo "selected"; } } ?> >In Progress</option>
						    <option value="done" <?php if(isset($edit_task)) { if($edit_task[0]->iua_status == "done") { echo "selected"; } } ?> >Done</option>
						    <option value="close" <?php if(isset($edit_task)) { if($edit_task[0]->iua_status == "close") { echo "selected"; } } ?> >Close</option>
						</select>
						<label class="mdl-textfield__label" for="t_status">Select Status</label>
					</div>
					<?php
						if (isset($edit_task)) {
							echo '<div><button class="mdl-button task_delete" id="'.$tid.'"><i class="material-icons">delete</i></button></div>';
						}
					?>
				</div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
    </div>
    
    </div>
</div>
</div>
</body>
<script>
    $(document).ready( function() {
    	$('#t_start_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    	$('#t_end_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    	
    	
    });
</script>

<script>
    var staff_name = [];
    var staff_role = [];
    var staff_access = [];
    
    $(document).ready(function() {

    	$('.task_delete').click(function (e) {
    		e.preventDefault();
    		var tid = $(this).prop('id');
    		window.location = '<?php echo base_url()."Projects/project_task_delete/".$pid."/".$code."/";?>'+tid;
    	});
	    
	    $('#submit').click(function(e) {
			e.preventDefault();
			
			$.post('<?php if(isset($edit_task)) { echo base_url()."Projects/update_task/".$pid."/".$code."/".$tid; } else { echo base_url()."Projects/save_task/".$pid."/".$code; } ?>', {
				'group' : $('#t_group').val(),
				'name' : $('#t_name').val(),
				'start' : $('#t_start_date').val(),
				'end' : $('#t_end_date').val(),
				'description' : $('#t_desc').val(),
				'status' : $('#t_status').val(),
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Projects/edit_project_details/".$code."/";?>'+data;
			}, 'text');			
		});

	});
</script>
</html>