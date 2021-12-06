
<link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap-4.1.0.min.css'; ?>">
<script src="<?php echo base_url().'assets/js/bootstrap-4.1.0.min.js'; ?>"></script>
<style>
    .mdl-card__title {
        height: auto;
        text-align: left;
    }
    .mdl-card__supporting-text {
        text-align: left;
    }

    .modal-content{
        border-radius: 0px;
        box-shadow: 1px 5px 77px #000;
    }

    .modal-header{
        padding: 30px;
        padding-bottom: 0px;
    }

    .modal{
        padding-left: 0px;
    }

    .ui-menu {
        z-index: 2000;
    }

    #p_list {
        width: 100%;
        border: 1px solid #ccc;
        padding: 10px;
    }

    #p_list > thead > tr > th {
        padding: 10px;
    }
    #p_list > tbody > tr > td {
        padding: 10px;
    }

</style>
<main class="mdl-layout__content">
    <div class="mdl-grid task_list">
        <?php for($i=0; $i < count($edit_task_group); $i++) {
            echo '<div class="mdl-cell mdl-cell--4-col group_list" id="'.$edit_task_group[$i]->iextptg_id.'"">';
            echo '<div class="mdl-card mdl-shadow--4dp">';
            echo '<div class="mdl-card__title mdl-card--expand">';
            echo '<h2 class="mdl-card__title-text">'.$edit_task_group[$i]->iextptg_name.'</h2>';
            echo '</div>';
            
            $tmp_usr = [];
            $flg = false;
            if (isset($edit_task_group_users)) {
                for($j=0;$j<count($edit_task_group_users); $j++) {
                    if($edit_task_group[$i]->iextptg_id == $edit_task_group_users[$j]->iextprour_task_gid) {
                        array_push($tmp_usr, $edit_task_group_users[$j]->ic_name); 
                        $flg=true;
                    }
                }
                if ($flg==true) { echo '<div class="mdl-card__supporting-text">'; echo '<i class="material-icons">people</i> '; echo implode(", ", $tmp_usr); echo '</div>';}
            }
            echo '</div>';
            echo '</div>';
        } ?>
    </div>
    <button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
        <i class="material-icons">add</i>
    </button>
</main>
</body>
<div class="modal" id="manage_Modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Group Details</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input type="text" id="p_name" name="p_name" class="mdl-textfield__input" value="<?php if(isset($edit_project)) { $edit_project[0]->iextpp_p_name; } ?>">
                    <label class="mdl-textfield__label" for="p_name">Task Group Name</label>
                </div>
                <table id="p_list">
                    <thead>
                        <tr>
                            <th>Name</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="mdl-button mdl-js-button mdl-button--colored" id="delete_group">Delete Group</button>
                <button type="button" class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised" data-dismiss="modal" id="submit">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    var people_list = [];
    var user_array = [];
    <?php

    ?>
    $(document).ready( function() {
    	
    	<?php
    		if (isset($edit_user_list)) {
                if (count($edit_user_list) > 0) {
                    for ($i=0; $i <count($edit_user_list) ; $i++) {
                        if ($edit_user_list[$i]->iextprour_pid != '') {
                            if ($edit_user_list[$i]->ium_admin == 'true') {
                                if ($edit_user_list[$i]->ic_name == '') {
                                    echo "user_array.push({'id' : ".$edit_user_list[$i]->i_uid.", 'email' : '".$edit_user_list[$i]->i_uname."', 'admin' : 'true', 'project' : 'true', 'group' : 'true'});";
                                }else{
                                    echo "user_array.push({'id' : ".$edit_user_list[$i]->i_uid.", 'email' : '".$edit_user_list[$i]->ic_name."', 'admin' : 'true','project' : 'true', 'group' : 'true'});";  
                                }
                            }else{
                                if ($edit_user_list[$i]->iextprour_project == 'true') {
                                    $project = 'true';
                                }else{
                                    $project = 'false';
                                }
                                if ($edit_user_list[$i]->iextprour_project == 'true') {
                                    $group = 'true';
                                }else{
                                    $group = 'false';
                                }
                                if ($edit_user_list[$i]->ic_name == '') {
                                    echo "user_array.push({'id' : ".$edit_user_list[$i]->i_uid.", 'email' : '".$edit_user_list[$i]->i_uname."', 'admin' : 'false','project' : '".$project."', 'group' : '".$group."'});";
                                }else{
                                    echo "user_array.push({'id' : ".$edit_user_list[$i]->i_uid.", 'email' : '".$edit_user_list[$i]->ic_name."', 'admin' : 'false','project' : '".$project."', 'group' : '".$group."'});";
                                }
                            }
                        }
                    }
                }
            }
    	?>

	    $('.task_list > .group_list').click(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Projects/get_task_group_details/".$pid.'/'.$code; ?>', {
                'tgid' : $(this).prop('id'),
            }, function(d,s,x) {
                var a=JSON.parse(d);
                $('#p_name').val(a.group[0].groups);
                selected_group=a.group[0].id;
                $('#delete_group').css('display','block');
                people_list=[];
                user_array = [];
                if (a.edit_user_list.length > 0) {
                    for (i=0; i <a.edit_user_list.length ; i++) {
                        if (a.edit_user_list[i].ium_admin == 'true') {
                            if (a.edit_user_list[i].ic_name == null || a.edit_user_list[i].ic_name == 'null' || a.edit_user_list[i].ic_name == '') {
                                user_array.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].i_uname, 'admin' : 'true', 'project' : 'true', 'group' : 'true'});
                            }else{
                                user_array.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].ic_name, 'admin' : 'true','project' : 'true', 'group' : 'true'});  
                            }
                        }else{
                            if (a.edit_user_list[i].iextprour_project == 'true') {
                                var project = 'true';
                            }else{
                                var project = 'false';
                            }
                            if (a.edit_user_list[i].iextprour_task_gid == '' || a.edit_user_list[i].iextprour_task_gid != selected_group) {
                                var group = 'false';
                            }else{
                                var group = 'true';
                            }
                            if (a.edit_user_list[i].iextprour_pid != null) {
                                if (a.edit_user_list[i].ic_name == null || a.edit_user_list[i].ic_name == 'null' || a.edit_user_list[i].ic_name == '') {
                                    user_array.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].i_uname, 'admin' : 'false','project' : project, 'group' : group});
                                }else{
                                    user_array.push({'id' : a.edit_user_list[i].i_uid, 'email' : a.edit_user_list[i].ic_name, 'admin' : 'false','project' : project, 'group' : group});
                                }
                            }
                        }
                    }
                }
                load_list();
                $('#manage_Modal').modal('toggle');
            })
        });

        $('#p_list').on('click', '.delete', function(e) {
            e.preventDefault();
            people_list.splice($(this).prop('id'), 1);
            load_list();
        });

        $('#add').click(function(e) {
            e.preventDefault();
            selected_group=0;
            $('#p_name').val('');
            people_list=[];
            load_list();
            $('#delete_group').css('display','none');
            $('#manage_Modal').modal('toggle');
        })

        $('#p_list').on('click','.add',function (e){
            var a = $(this).prop('id');
            var status = a.substring(0, 3);
            var mid = a.substring(3, a.length);
            
            if (status == 'add') {
                for (var i = 0; i < user_array.length; i++) {
                    if(user_array[i].id == mid){
                        if (user_array[i].group == 'true') {
                            user_array[i].group = 'false';
                        }else{
                            user_array[i].group = 'true';
                        }
                    }
                }
            }
            load_list();
        });


	    $('#submit').click(function(e) {
			e.preventDefault();
                $.post('<?php echo base_url()."Projects/save_task_group/".$pid.'/'.$code; ?>', {
                    'name' : $('#p_name').val(),
                    'people' : user_array,
                    'sel' : selected_group
                }, function(data, status, xhr) {
                    selected_group=0;
                   window.location = '<?php echo base_url()."Projects/add_task_group/".$code."/"; ?>'+data;
                }, 'text');			
		});

        $('#delete_group').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Projects/delete_task_group/'.$code.'/'; ?>"+selected_group;
        })

	});

    function load_list() {
        var a="";
        if(user_array.length > 0){
            for (var i = 0; i < user_array.length; i++) {
                a +='<tr><td class="mdl-data-table__cell--non-numeric"><h4>'+user_array[i].email+'</h4></td>';
                a +='<td class="mdl-data-table__cell--non-numeric">';
                if (user_array[i].admin == 'true' || user_array[i].project == 'true') {
                    a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="add'+user_array[i].id+'"><i class="material-icons">add</i></button>';
                }else if (user_array[i].group == 'true') {
                    a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored add" id="add'+user_array[i].id+'"><i class="material-icons">add</i></button>';
                }else{
                    a+='<button class="mdl-button mdl-js-button mdl-button--raised add" id="add'+user_array[i].id+'"><i class="material-icons">add</i></button>';
                }
                a +='</td></tr>';
            }
        }

        $('#p_list > tbody').empty();
        $('#p_list > tbody').append(a);
    }
</script>
</html>