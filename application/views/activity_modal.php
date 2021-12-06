<style type="text/css">
    .ui-widget {
        z-index: 30000 !important;
        width: auto !important;
    }

    .pic_button {
        border-radius: 10px;
        box-shadow: 0px 4px 10px #ccc;
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

    #activity_title::placeholder {
        color: #fff !important;
        opacity: 1;
    }

    .repeat_date::placeholder {
        color: #fff !important;
        opacity: 1;
    }

    .popover {
        z-index: 40000 !important;
    }
    @media screen and (max-width: 500px) {
        .from_css{
            min-width: 100%;
        }
        .to_css{
            min-width: 100%;
        }
    }

    .ui-autocomplete {
        border: 0px !important;
        background-color: solid #fff !important;
    }
</style>
    <div class="modal-body" id="add_activity_body" style="padding: 0px;">
        <div class="demo-card-wide mdl-card" style="min-height: auto;padding: 0px;">
            <div class="mdl-card__title act_title" style="background-color: rgba(255, 0, 0, 0.63);">
                <h2 class="mdl-card__title-text" style="width: 100%;">
                    <div style="display: flex;margin: 0px;padding: 0px;width: 100%;" >
                        <div class="mdl-cell mdl-cell--10-col">
                            <input class="mdl-textfield__input" type="text" id="activity_title" style="font-size: 25px;outline: none;border-bottom: 1px solid #fff;" placeholder="Enter title">
                            <p class="parent_title" style="display: none;margin-top: 15px;margin-bottom: -2px;"></p>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col" style="text-align: right;">
                            <div class="po-markup">
                                <a href="#" class="btn btn-lg btn-default po-link" style="height: 40px;outline: none;"><i class="material-icons" style="font-size: 25px;" fill="none">category</i></a>
                                <div class="po-content" style="display: none;">
                                    <div class="po-body">
                                        <button class="mdl-button mdl-js-button mdl-button--icon a_color" id="#09bfb4" style="background-color: #09bfb4;margin-top: 10px;outline: none;"></button>
                                        <button class="mdl-button mdl-js-button mdl-button--icon a_color" id="rgba(255, 0, 0, 0.63)" style="background-color: rgba(255, 0, 0, 0.63);margin-top: 10px;outline: none;"></button>
                                        <button class="mdl-button mdl-js-button mdl-button--icon a_color" id="rgba(0, 128, 0, 0.74)" style="background-color: rgba(0, 128, 0, 0.74);margin-top: 10px;outline: none;"></button>
                                        <button class="mdl-button mdl-js-button mdl-button--icon a_color" id="rgba(0, 0, 255, 0.64)" style="background-color: rgba(0, 0, 255, 0.64);margin-top: 10px;outline: none;"></button>
                                        <button class="mdl-button mdl-js-button mdl-button--icon a_color" id="rgba(255, 165, 0, 0.65)" style="background-color: rgba(255, 165, 0, 0.65);margin-top: 10px;outline: none;"></button>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </h2>
            </div>
        </div>
        <div class="mdl-grid" style="width: 100%; display: flex;padding: 20px;">
            <div style="width: 10%;">
                <i class="material-icons date_icon" style="color: rgba(255, 0, 0, 0.63);">calendar_today</i>
            </div>
            <div style="width: 60%;display: flex;">
                <h4 class="date_name" style="margin-top: 2px;color: rgba(255, 0, 0, 0.63)">  Date</h4>
            </div>
            <div style="width: 30%;display: flex;">
                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="act_date_change"><input type="checkbox" id="act_date_change" class="mdl-switch__input" <?php if (isset($edit_activity)) { if (date('H:i:s' , strtotime($edit_activity[0]->iua_date)) == '00:00:00') { echo "checked";
                }} ?>><span class="mdl-switch__label">All Day</span></label>
            </div>
            <div class="from_css" style="display: flex;width: 50%;">
                <div class="mdl-cell mdl-cell--2-col">
                    <h4 style="color: #000;">From </h4>
                </div>
                <div class="mdl-cell mdl-cell--10-col act_from_date_time">
                    <input class="mdl-button mdl-js-button mdl-button--colore mdl-button--raise s_date_time" data-type="date" value="<?php if(isset($edit_activity)) { echo $edit_activity[0]->iua_date; }?>" placeholder="From date" style="width: 100%;color: #666;">
                </div>
                <div class="mdl-cell mdl-cell--10-col act_from_date" style="display: none;">
                    <input class="mdl-button mdl-js-button mdl-button--colore mdl-button--raise s_date" data-type="date" value="<?php if(isset($edit_activity)) { echo date('Y-m-d', strtotime($edit_activity[0]->iua_end_date)); }?>" placeholder="From date" style="width: 100%;color: #666;">
                </div>
            </div>
            <div class="to_css" style="display: flex;width: 50%;">
                <div class="mdl-cell mdl-cell--2-col">
                    <h4 style="color: #000;">To </h4>
                </div>
                <div class="mdl-cell mdl-cell--10-col act_to_date_time">
                    <input class="mdl-button mdl-js-button mdl-button--colore mdl-button--raise e_date_time" data-type="date" value="<?php if(isset($edit_activity)) { echo $edit_activity[0]->iua_end_date; }?>" placeholder="To date" style="width: 100%;color: #666;">
                </div>
                <div class="mdl-cell mdl-cell--10-col act_to_date" style="display: none;">
                    <input class="mdl-button mdl-js-button mdl-button--colore mdl-button--raise e_date" data-type="date" value="<?php if(isset($edit_activity)) { echo date('Y-m-d', strtotime($edit_activity[0]->iua_end_date)); }?>" placeholder="To date" style="width: 100%;color: #666;">
                </div>
            </div>
            <hr style="width: 100%;">
            <div style="width: 10%;">
                <i class="material-icons repeat_icon" style="color: rgba(255, 0, 0, 0.63);margin-top: 20%;">repeat</i>
            </div>
            <div style="width: 30%;display: flex;">
                <h4 class="repeat_name" style="margin-top: 5%;color: rgba(255, 0, 0, 0.63)">  Repeat</h4>
            </div>
            <div style="width: 60%;display: flex;">
                <select class="mdl-textfield__input" id="act_duration" style="width:100%;outline: none;">
                    <?php
                        if (isset($edit_activity)) {
                            if ($edit_activity[0]->iua_repeat == 'one_time') {
                                echo '<option value="one_time" selected>One Time</option>';    
                            }else{
                                echo '<option value="one_time">One Time</option>';
                            }
                            if ($edit_activity[0]->iua_repeat == 'daily') {
                                echo '<option value="daily" selected>Daily</option>';    
                            }else{
                                echo '<option value="daily">Daily</option>';
                            }
                            if ($edit_activity[0]->iua_repeat == 'weekly') {
                                echo '<option value="weekly" selected>Weekly</option>';
                            }else{
                                echo '<option value="weekly">Weekly</option>';
                            }
                            if ($edit_activity[0]->iua_repeat == 'monthly') {
                                echo '<option value="monthly" selected>Monthly</option>';
                            }else{
                                echo '<option value="monthly">Monthly</option>';
                            }
                            if ($edit_activity[0]->iua_repeat == 'yearly') {
                                echo '<option value="yearly" selected>Yearly</option>';
                            }else{
                                echo '<option value="yearly">Yearly</option>';
                            }
                        }else{
                            echo '<option value="one_time" selected>One Time</option><option value="daily">Daily</option><option value="weekly">Weekly</option><option value="monthly">Monthly</option><option value="yearly">Yearly</option>';
                        }
                    ?>
                </select>
            </div>
            <div style="width: 40%;display: flex;"></div>
            <div style="width: 60%;display: flex;margin-top: 10px;">
                <input class="mdl-button mdl-js-button mdl-button--colore mdl-button--raise repeat_date" data-type="date" placeholder="Repeat till date" style="width: 100%;color:#fff;display: none;">
            </div>
            <hr style="width: 100%;">
            <div class="more_content_added" style="width: 100%;"></div>
            <button class="mdl-button mdl-button--colored more_option" tabindex="0" data-toggle="popover" data-trigger="focus" style="color: #000;border-radius: 15px;">More ...</button>
            <div class="more_content" style="display: none;"></div>
        </div>
        <div class="modal-footer">
            <button class="mdl-button mdl-button--raise mdl-button--colore option_type" id="this" style="display: none;width: 100%;color: red;"> Change only this activity</button>
            <button class="mdl-button mdl-button--raise mdl-button--colore option_type" id="future" style="display: none;width: 100%;margin-top: 10px;color: red;"> Change this and all future activity</button>

            <button class="mdl-button mdl-button--raise mdl-button--colore delete_option_type" id="this" style="display: none;width: 100%;color: red;"> Delete only this activity</button>
            <button class="mdl-button mdl-button--raise mdl-button--colore delete_option_type" id="future" style="display: none;width: 100%;margin-top: 10px;color: red;"> Delete this and all future activity</button>

            <button class="mdl-button mdl-button--raise mdl-button--colored delete_normal_activity" style="display: none;width: 100%;margin-top: 10px;"><i class="material-icons">delete</i> delete</button>

            <button class="mdl-button mdl-button--raise mdl-button--colore save_normal_activity"><i class="material-icons">save</i> save</button>
            <button class="mdl-button mdl-button--raise mdl-button--colore close_modal" data-dismiss="modal" ><i class="material-icons">close</i> close</button>
        </div>
    </div>
<script type="text/javascript">
    var todo_array = [];
    var to_do = "";
    var status = "";
    var user_array = [];
    var tag_data = [];
    var activity_tags = [];
    var options = [];
    var person_array = [];
    var re_id = "";
    var today = new Date();
    var currdate=today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var current_dates=[currdate];
    var date_data ='';
    var act_color ='';
    var module_arr = [];
    var most_module = [];
    var activity_arr = []; activity_todo_arr =[]; activity_perform = []; m_s = [];activity_person = [];
    var activity_place = []; activity_cat = [];
    var content_arr = [] ;
    var project_grp_arr = [];
    var star_rat = 0;
    var shortcut_display = 'true';
    var activity_type = 'Event';
    var edit_mid = 0 ;
    var cat_display = 'true';
    var act_reminde = 'null';
    var file_arr = [];
    var mod_id = 0;
    var txn_id = 0;
    var edit_project_grp = 0;
    var parent_id = 0;
    var p_order = 'false';
    <?php
    if (isset($parent_title)) {
        echo "$('.parent_title').append('".$parent_title."');";
        echo "$('.parent_title').css('display','block');";
        echo "$('.parent_title').css('font-size','17px');";
        echo "parent_id = ".$parent_aid.";";
    }

    if (isset($mid)) {
        echo "mod_id = ".$mid.";";
    }

    if (isset($project_id)) {
        echo "txn_id = ".$project_id.";";
    }

    if (isset($txn_id)) {
        echo "txn_id = ".$txn_id.";";
    }

    if (isset($edit_grp)) {
        echo "edit_project_grp = ".$edit_grp.";";
    }

    if (isset($m_shortcuts)) {
        for ($i=0; $i < count($m_shortcuts) ; $i++) { 
            echo "module_arr.push({id : '".$m_shortcuts[$i]->ims_id."' , 'name' : '".$m_shortcuts[$i]->ims_name."' , 'status' : 'false'});";
        }
    }

    if (isset($cat)) {
        for ($i=0; $i <count($cat) ; $i++) {
            echo "activity_cat.push('".$cat[$i]->iua_categorise."');";
        }
    }

    if (isset($place)) {
        for ($i=0; $i <count($place) ; $i++) {
            echo "activity_place.push('".$place[$i]->iua_place."');";
        }
    }
    if (isset($user_list)) {
        for ($i=0; $i <count($user_list) ; $i++) {
            echo "options.push('".$user_list[$i]->ic_name."');";
        }   
    }

    if (isset($project_grp)) {
        for ($i=0; $i < count($project_grp) ; $i++) {
            echo "project_grp_arr.push({'id' : '".$project_grp[$i]->iextptg_id."', 'name' : '".$project_grp[$i]->iextptg_name."' , 'pid' : '".$project_grp[$i]->iextptg_p_id."' , 'status' : 'false' });";
        }
    }

    if (isset($pid_name)) {
        echo "$('#add_activity').modal('toggle');";
    }
    if (isset($type)) {
        echo "activity_type='".$type."';";
    }
    if ($cat_display == 'no') {
        echo "cat_display = 'false';";
    }

    if ($shortcut == 'no') {
        echo "shortcut_display = 'false';";
    }
    if (isset($edit_activity)) {
        if ($edit_activity[0]->iua_color != '') {
            echo "un_color = '".$edit_activity[0]->iua_color."';";
        }else{
            echo "var un_color = 'rgba(255, 0, 0, 0.63)';";
        }
        echo "var option_type = 'future';";
        echo "$('.delete_normal_activity').css('display','block');";
    }else{
        echo "var un_color = 'rgba(255, 0, 0, 0.63)';";
        echo "var option_type = '';";
    }

    if (isset($oppo_name)) {
        echo "var oppo_name = '".$oppo_name."';";
    }else{
        echo "var oppo_name = '';";
    }

    if (isset($c_name)) {
        echo "var c_name = '".$c_name."';";
    }else{
        echo "var c_name = '';";
    }

    if (isset($c_add)) {
        echo "var c_add = '".$c_add."';";
    }else{
        echo "var c_add = '';";
    }
    if (isset($support_details)) {
        if (count($support_details) > 0 ) {
            echo 'var support_subject = "'.$support_details[0]->ies_subject.'";';
            echo 'var support_desc = "'.$support_details[0]->ies_desc.'";';
        }else{
            echo 'var support_subject = "";';
            echo 'var support_desc = "";';
        }
    }else{
        echo 'var support_subject = "";';
        echo 'var support_desc = "";';
    }

    if (isset($purchase_order)) {
        echo "p_order='true';";
    }
    ?>
    $(document).ready(function() {
        if (activity_type == 'project' ) {
            for (var i = 0; i < project_grp_arr.length; i++) {
                if(project_grp_arr[i].id == edit_project_grp){
                    project_grp_arr[i].status = 'true';
                    break;
                }
            }
        }
        $(".s_date_time").change(function (e) {
            e.preventDefault();
            $('.e_date_time').val($('.s_date_time').val());
        });

        $(".s_date").change(function (e) {
            e.preventDefault();
            $('.e_date').val($('.s_date').val());
        });

        $(".s_date_time").bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm:ss'});
        $(".e_date_time").bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm:ss'});

        $(".s_date").bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});
        $(".e_date").bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});

        $(".repeat_date").bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});

        $('#act_duration').change(function (e) {
            e.preventDefault();
            var id = $('#act_duration').val();
            if (id != 'one_time') {
                $('.repeat_date').css('display','block');
                $('.repeat_date').css('background-color',un_color);
            }else{
                $('.repeat_date').css('display','none');
            }
        });
        /////// Do not re-arrange content array insert list
        if (shortcut_display == 'false') {
            content_arr.push({'val' : '<button class="mdl-button add_more" id="act_mod" style="width: 100%;text-align: left;"><i class="material-icons"> redo</i> Module Shortcut</button>' , 'status' : 'true' , 'id' : 'act_mod' });
        }else{
            content_arr.push({'val' : '<button class="mdl-button add_more" id="act_mod" style="width: 100%;text-align: left;"><i class="material-icons"> redo</i> Module Shortcut</button>' , 'status' : 'false' , 'id' : 'act_mod' });
            <?php if (!isset($edit_activity)) {
                echo "display_mod();";
            }?>
        }

        if (cat_display == 'true') {
            content_arr.push({'val' : '<button class="mdl-button add_more" id="act_cat" style="width: 100%;text-align: left;"><i class="material-icons">category</i> Category</button>' , 'status' : 'true' , 'id' : 'act_cat' });
        }else{
            if (activity_type == 'project') {
                content_arr.push({'val' : '<button class="mdl-button add_more" id="act_cat" style="width: 100%;text-align: left;"><i class="material-icons">category</i> Project group</button>' , 'status' : 'false' , 'id' : 'act_project' });
                display_project_group();
            }else{
                content_arr.push({'val' : '<button class="mdl-button add_more" id="act_cat" style="width: 100%;text-align: left;"><i class="material-icons">category</i> Category</button>' , 'status' : 'true' , 'id' : 'act_cat' });
            }
        }
        content_arr.push({'val' : '<button class="mdl-button add_more" id="act_todo" style="width: 100%;text-align: left;"><i class="material-icons">list</i> To do list</button>' , 'status' : 'true' , 'id' : 'act_todo' });
        content_arr.push({'val' : '<button class="mdl-button add_more" id="act_note" style="width: 100%;text-align: left;"><i class="material-icons">note_add</i> Notes</button>' , 'status' : 'true' , 'id' : 'act_note' });
        content_arr.push({'val' : '<button class="mdl-button add_more" id="act_attach" style="width: 100%;text-align: left;"><i class="material-icons">attach_file</i> Attachment</button>' , 'status' : 'true', 'id' : 'act_attach'});
        content_arr.push({'val' : '<button class="mdl-button add_more" id="act_group" style="width: 100%;text-align: left;"><i class="material-icons">group</i> Share with person</button>' , 'status' : 'true' , 'id' : 'act_group' });
        content_arr.push({'val' : '<button class="mdl-button add_more" id="act_loc" style="width: 100%;text-align: left;"><i class="material-icons">place</i> Location</button>' , 'status' : 'true' , 'id' : 'act_loc'});
        content_arr.push({'val' : '<button class="mdl-button add_more" id="act_notification" style="width: 100%;text-align: left;"><i class="material-icons">notifications</i> Reminders</button>' , 'status' : 'true' ,'id' : 'act_notification' });
        content_arr.push({'val' : '<button class="mdl-button add_more" id="act_priority" style="width: 100%;text-align: left;"><i class="material-icons">priority_high</i> Priority</button>' , 'status' : 'true' , 'id' : 'act_priority' });
        ////// Do not re-arrange content array insert list

        if (activity_type == 'support') {
            var e_name = $('#sp_emp').val();
            person_array.push(e_name);
            content_arr[5].status = 'false';
            content_arr[1].status = 'false';
            display_cat();
            display_group();
            append_person_list();
            display_note();
            $('#activity_title').val(c_name+' : '+support_subject);
            $('#notes_text').append(support_desc+'<br><br>Address : '+c_add);
        }else if (activity_type == 'opportunity' && oppo_name != '') {
            person_array.push(oppo_name);
            content_arr[5].status = 'false';
            display_group();
            append_person_list();
        }

        /////// Edit activity //////
        <?php

            if (isset($edit_activity)) {
                echo "$('#activity_title').val('".$edit_activity[0]->iua_title."');";
                echo "$('.act_title').css('background-color',un_color);";
                echo "$('.date_icon').css('color',un_color);";
                echo "$('.date_name').css('color',un_color);";
                echo "$('.repeat_name').css('color',un_color);";
                echo "$('.repeat_icon').css('color',un_color);";

                if (date('H:i:s' , strtotime($edit_activity[0]->iua_date)) == '00:00:00'){
                    echo "$('.s_date').val('".date('Y-m-d',strtotime($edit_activity[0]->iua_date) )."');";
                    echo "$('.e_date').val('".date('Y-m-d',strtotime($edit_activity[0]->iua_end_date))."');";
                    echo "$('.act_from_date').css('display','block');";
                    echo "$('.act_to_date').css('display','block');";
                    echo "$('.act_from_date_time').css('display','none');";
                    echo "$('.act_to_date_time').css('display','none');";
                    echo '$("#act_date_change").prop("checked");';
                }else{
                    echo "$('.s_date_time').val('".date('Y-m-d H:i:s' , strtotime($edit_activity[0]->iua_date))."');";
                    echo "$('.e_date_time').val('".date('Y-m-d H:i:s' , strtotime($edit_activity[0]->iua_end_date))."');";
                    echo "$('.act_from_date').css('display','none');";
                    echo "$('.act_to_date').css('display','none');";
                    echo "$('.act_from_date_time').css('display','block');";
                    echo "$('.act_to_date_time').css('display','block');";
                }

                if ($edit_activity[0]->iua_repeat != 'one_time') {
                    echo "$('.repeat_date').css('display','block');";
                    echo "$('.repeat_date').css('background-color',un_color);";
                    if ($edit_activity[0]->iua_repeat_date != '0000-00-00') {
                        echo "$('.repeat_date').val('".$edit_activity[0]->iua_repeat_date."');";
                    }
                }
                
                if (isset($mod_shortcut)) {
                    if ($mod_shortcut != '' && $mod_shortcut != 'null') {
                        echo "content_arr[0].status = 'false';";
                        echo "edit_mid = '".$mod_shortcut."';";
                        echo "display_mod();";
                    }
                }

                if ($cat_display == 'yes') {
                    if ($edit_activity[0]->iua_categorise != 'null' && $edit_activity[0]->iua_categorise != '') {
                        echo "content_arr[1].status = 'false';";
                        echo "display_cat();";
                        echo "$('#act_cat_auto').val('".$edit_activity[0]->iua_categorise."');";
                    }
                }

                if (isset($edit_todo)) {
                    if (count($edit_todo) > 0 ) {
                        for ($i=0; $i < count($edit_todo); $i++) {
                            if ($edit_todo[$i]->iuat_status == "true") {
                                echo "todo_array.push({'tid' : '".$edit_todo[$i]->iuat_a_id."' , 'title' : '".$edit_todo[$i]->iuat_title."', 'status' : 'true'});";
                            }else{
                                echo "todo_array.push({'tid' : '".$edit_todo[$i]->iuat_a_id."' , 'title' : '".$edit_todo[$i]->iuat_title."', 'status' : 'false'});";
                            }
                        }
                        echo "content_arr[2].status = 'false';";
                        echo "display_todo();";
                        echo "append_todo_list();";
                    }
                }

                if ($edit_activity[0]->iua_note != '' && $edit_activity[0]->iua_note != 'null') {
                    echo "content_arr[3].status = 'false';";
                    echo "display_note();";
                    $txt_file = $edit_activity[0]->iua_note;
                    $path = $this->config->item('document_rt').'assets/data/'.$oid.'/activity/';
                    $note = file_get_contents($path.$txt_file);
                    echo "$('#notes_text').append('".$note."');";
                }

                if (isset($edit_person)) {
                    if (count($edit_person) > 0 ) {
                        for ($i=0; $i <count($edit_person) ; $i++) { 
                            echo "person_array.push('".$edit_person[$i]->ic_name."');";
                        }
                        echo "content_arr[5].status = 'false';";
                        echo "display_group();";
                        echo "append_person_list();";
                    }
                }

                if ($edit_activity[0]->iua_place != 'null' && $edit_activity[0]->iua_place != '') {
                    echo "content_arr[6].status = 'false';";
                    echo "display_loc();";
                    echo "$('#act_loc_auto').val('".$edit_activity[0]->iua_place."');";
                }

                if ($edit_activity[0]->iua_reminder != '' && $edit_activity[0]->iua_reminder != 'null') {
                    echo "content_arr[7].status = 'false';";
                    echo "act_reminde = '".$edit_activity[0]->iua_reminder."';";
                    echo "display_notification();";
                }

                if ( $edit_activity[0]->iua_priority != '' &&  $edit_activity[0]->iua_priority != 'null') {
                    echo "content_arr[8].status = 'false';";
                    echo "display_priority();";
                    for ($i=0; $i < $edit_activity[0]->iua_priority ; $i++) {
                        echo "$('.priority_rat').css('color','black');";
                        echo "star_rat = ".$edit_activity[0]->iua_priority.";";
                        echo 'for (var i = 1; i <= '.$edit_activity[0]->iua_priority.'; i++) {';
                            echo "$('#prt'+i).css('color','red');";
                        echo '}';
                    }
                }

                if (isset($edit_files)) {
                    if (count($edit_files) > 0) {
                        echo "content_arr[4].status = 'false';";
                        $path = base_url()."assets/uploads/".$oid."/";
                        for ($i=0; $i < count($edit_files) ; $i++) {
                            echo "file_arr.push('".$path.$edit_files[$i]->icd_timestamp."');";
                        }
                        echo "display_attach();";
                        echo "show_file_images();";
                    }
                }                
            }else{
                echo "un_color = 'rgba(255, 0, 0, 0.63)';";
                echo "$('.s_date_time').val('".date('Y-m-d H:i:s')."');";
                echo "$('.e_date_time').val('".date('Y-m-d H:i:s')."');";
                echo "$('.s_date').val('".date('Y-m-d')."');";
                echo "$('.e_date').val('".date('Y-m-d')."');";
            }
        ?>
        /////// Save activity //////

        $('.save_normal_activity').click(function(e){
            e.preventDefault();
            <?php
                if (isset($edit_activity)) {
                    if ($edit_activity[0]->iua_repeat != 'one_time' ) {
                        echo "$('.save_normal_activity').css('display','none');";
                        echo "$('.option_type').css('display','block');";
                    }else{
                        echo "option_type='null';";
                        echo "save_activity();";
                    }
                }else{
                    echo "option_type='null';";
                    echo "save_activity();";
                }
            ?>
        });

        $('.delete_normal_activity').click(function(e){
            e.preventDefault();
            <?php
                if (isset($edit_activity)) {
                    if ($edit_activity[0]->iua_repeat != 'one_time' ) {
                        echo "$('.delete_normal_activity').css('display','none');";
                        echo "$('.delete_option_type').css('display','block');";
                    }else{
                        echo "option_type='null';";
                        echo "delete_activity();";
                    }
                }
            ?>
        });

        $('.delete_option_type').click(function (e) {
            e.preventDefault();
            var type = $(this).prop('id');
            if (type == 'this') {
                option_type = 'this';
            }else{
                option_type = 'future';
            }
            delete_activity();
        });

        function delete_activity(){
            $.post('<?php if (isset($edit_activity)) {echo base_url()."View/activity_delete/".$code."/".$aid."/";} ?>'+option_type,
            function(data, status, xhr) {
                var path = window.location.href;
                path = path.replace("#", "");
                window.location = path;
            }, 'text');
        }

        $('.option_type').click(function (e) {
            e.preventDefault();
            var type = $(this).prop('id');
            if (type == 'this') {
                option_type = 'this';
            }else{
                option_type = 'future';
            }
            save_activity();
        });

        function save_activity(){
            if(content_arr[0].status == 'false'){var mod = $('#act_mod').val();}else{var mod = 'null';}
            if (cat_display == 'true') {
                if(content_arr[1].status == 'false'){var cat = $('#act_cat_auto').val();var project = 'null';}else{var cat = 'null';var project = 'null';}
            }else{
                if(content_arr[1].status == 'false'){var project = $('#act_project').val();var cat = 'null';}else{var project = 'null';var cat = 'null';}
            }
            if(content_arr[3].status == 'false'){var note = $('#notes_text').html();}else{var note = 'null';}
            if(content_arr[6].status == 'false'){var place = $('#act_loc_auto').val();}else{var place = 'null';}
            if(content_arr[7].status == 'false'){var remind = $('#act_reminde_select').val();}else{var remind = 'null';}
            if(content_arr[8].status == 'false'){var priority = star_rat}else{var priority = 'null';}
            var f_date;var t_date;
            if($("#act_date_change").prop("checked") == true){
                f_date = $('.s_date').val();
                t_date = $('.e_date').val();
            }else{
                f_date = $('.s_date_time').val();
                t_date = $('.e_date_time').val();
            }
            $.post('<?php if (isset($edit_activity)) {echo base_url()."View/activity_update/".$code."/".$aid."/";}else {echo base_url()."View/activity_save/".$code."/";} ?>'+option_type,{
                'title' : $('#activity_title').val(),
                'type' : activity_type,
                'f_date' : f_date,
                't_date' : t_date,
                'repeat' : $('#act_duration').val(),
                'color' : un_color,
                'mod_shortcut' : mod,
                'category' : cat,
                'todo' : todo_array,
                'notes' : note,
                'share' : person_array,
                'location' : place,
                'remind' : remind,
                'priority' : priority,
                'repeat_end' : $('.repeat_date').val(),
                'mod_id' : mod_id,
                'txn_id' : txn_id,
                'project_grp' : project,
                'parent_id' : parent_id
            }, function(data, status, xhr) {
                if(content_arr[4].status == 'false'){
                    upload_files(data);
                }else{
                    var path = window.location.href;
                    path = path.replace("#", "");
                    window.location = path;
                }
            }, 'text');
        }

        function upload_files(aid){
            if($('.upload')[0].files.length > 0 ) {
                var datat = new FormData();
                var ins = $('.upload')[0].files.length;
                for (var x = 0; x < ins; x++) {
                    datat.append("used[]", $('.upload')[0].files[x]);
                }
                $.ajax({
                    url: "<?php echo base_url().'View/activity_doc_upload/'.$code.'/';?>"+aid,
                    type: "POST",
                    data: datat,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        var path = window.location.href;
                        path = path.replace("#", "");
                        window.location = path;
                    }
                });
            }else{
                var path = window.location.href;
                path = path.replace("#", "");
                window.location = path;
            }
        }

        $('.more_option').popover({
            trigger: 'click',
            html: true,
            title: function() {
                return $(this).parent().find('.po-title').html();
            },
            content: function() {
                var out = '';
                var pop_flg = 0;
                for (var i = 0; i < content_arr.length; i++) {
                    if(content_arr[i].status == 'true'){
                        out += content_arr[i].val;
                        pop_flg ++;
                    }
                }
                if (pop_flg == 0 ) {
                    $('.more_option').empty();
                    $('.more_option').append('No more !');
                }
                return out;
            },
            placement: 'right'
        }).on('shown.bs.popover', function () {
            $('.add_more').click(function (e) {
                e.preventDefault();
                var id = $(this).prop('id');
                $(this).css('display','none');
                for (var i = 0; i < content_arr.length; i++) {
                    if(content_arr[i].id == id){
                        content_arr[i].status = 'false';
                    }
                }
                if (id == 'act_mod') {
                    display_mod();
                }
                if (id == 'act_cat') {
                    display_cat();
                }
                if (id == 'act_loc') {
                    display_loc();
                }
                if (id == 'act_notification') {
                    display_notification();
                }
                if (id == 'act_priority') {
                    display_priority();
                }
                if (id == 'act_attach') {
                    display_attach();
                }
                if (id == 'act_group') {
                    display_group();
                }
                if (id == 'act_todo') {
                    display_todo();
                }
                if (id == 'act_note') {
                    display_note();
                }
                $('.more_option').popover('hide');
            });
        });

        function display_project_group() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons cat_icon" style="color: '+un_color+';">category</i></div><div style="width: 30%;display: flex;"><h4 class="cat_name" style="margin-top: 2px;color: '+un_color+'">  Project Group</h4></div><div style="width:60%;"><select class="mdl-textfield__input" id="act_project" style="width:100%;"><option value="0">Select project group</option>';
            for (var i = 0; i < project_grp_arr.length; i++) {
                if (project_grp_arr[i].status == 'true') {
                    out += '<option value="'+project_grp_arr[i].id+'" selected>'+project_grp_arr[i].name+'</option>';
                }else{
                    out += '<option value="'+project_grp_arr[i].id+'">'+project_grp_arr[i].name+'</option>';
                }
            }
            out += '</select></div></div><hr style="width: 100%;">';
            $('.more_content_added').append(out);
        }

        function display_mod() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons mod_icon" style="color: '+un_color+';">redo</i></div><div style="width: 30%;display: flex;"><h4 class="mod_name" style="margin-top: 2px;color: '+un_color+'">  Module Shortcut</h4></div><div style="width:60%;"><select class="mdl-textfield__input" id="act_mod" style="width:100%;"><option value="0">Select module shortcut</option>';
            for (var i = 0; i < module_arr.length; i++) {
                if (module_arr[i].id == edit_mid) {
                    out += '<option value="'+module_arr[i].id+'" selected>'+module_arr[i].name+'</option>';
                }else if (p_order == 'true' && module_arr[i].name == 'Add Purchase Order') {
                    out += '<option value="'+module_arr[i].id+'" selected>'+module_arr[i].name+'</option>';
                }else{
                    out += '<option value="'+module_arr[i].id+'">'+module_arr[i].name+'</option>';
                }
            }
            out += '</select></div></div><hr style="width: 100%;">';
            $('.more_content_added').append(out);
        }

        function display_cat() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons cat_icon" style="color: '+un_color+';">category</i></div><div style="width: 30%;display: flex;"><h4 class="cat_name" style="margin-top: 2px;color: '+un_color+'">  Category</h4></div><input class="mdl-textfield__input" type="text" id="act_cat_auto" style="outline: none;border-bottom: 1px solid #666;width:60%;color:#000;" placeholder="Enter Category"></div><hr style="width: 100%;">';
            $('.more_content_added').append(out);

            $("#act_cat_auto").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(activity_cat, request.term);
                    response(results.slice(0, 10));
                }
            });
        }

        function display_loc() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons loc_icon" style="color: '+un_color+';">place</i></div><div style="width: 30%;display: flex;"><h4 class="loc_name" style="margin-top: 2px;color: '+un_color+'">  Location</h4></div><input class="mdl-textfield__input" type="text" id="act_loc_auto" style="outline: none;border-bottom: 1px solid #666;width:60%;color:#000;" placeholder="Enter Location"></div><hr style="width: 100%;">';
            $('.more_content_added').append(out);

            $("#act_loc_auto").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(activity_place, request.term);
                    response(results.slice(0, 10));
                }
            });
        }

        function display_notification() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons reminde_icon" style="color: '+un_color+';">notifications</i></div><div style="width: 30%;display: flex;"><h4 class="reminde_name" style="margin-top: 2px;color: '+un_color+'">  Reminders</h4></div>';
            out += '<select class="mdl-textfield__input" id="act_reminde_select" style="width:60%;">';
            if (act_reminde != 'null') {
                if (act_reminde == 'never') {
                    out += '<option value="never" selected>Never Reminde</option>';
                }else{
                    out += '<option value="never">Never Reminde</option>';
                }
                if (act_reminde == '5 min') {
                    out += '<option value="5 min" selected>5 minutes before</option>';
                }else{
                    out += '<option value="5 min">5 minutes before</option>';
                }
                if (act_reminde == '15 min') {
                    out += '<option value="15 min" selected>15 minutes before</option>';
                }else{
                    out += '<option value="15 min">15 minutes before</option>';
                }
                if (act_reminde == '30 min') {
                    out += '<option value="30 min" selected>30 minutes before</option>';
                }else{
                    out += '<option value="30 min">30 minutes before</option>';
                }
                if (act_reminde == '1 hr') {
                    out += '<option value="1 hr" selected>1 hour before</option>';
                }else{
                    out += '<option value="1 hr">1 hour before</option>';
                }
            }else{
                out += '<option value="never" selected>Never Reminde</option>';
                out += '<option value="5 min">5 minutes before</option>';
                out += '<option value="15 min">15 minutes before</option>';
                out += '<option value="30 min">30 minutes before</option>';
                out += '<option value="1 hr">1 hour before</option>';
            }
            out += '</select>';
            out += '</div><hr style="width: 100%;">';
            $('.more_content_added').append(out);
        }

        function display_priority() {
            var out = '';
            out +=  '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons priority_icon" style="color: '+un_color+';">priority_high</i></div><div style="width: 30%;display: flex;"><h4 class="priority_name" style="margin-top: 2px;color: '+un_color+'">  Priority</h4></div><div style="width:60%;">';
            out +=  '<button class="mdl-button mdl-button--icon priority_rat" id="prt1"><i class="material-icons">star</i></button>';
            out +=  '<button class="mdl-button mdl-button--icon priority_rat" id="prt2"><i class="material-icons">star</i></button>';
            out +=  '<button class="mdl-button mdl-button--icon priority_rat" id="prt3"><i class="material-icons">star</i></button>';
            out +=  '<button class="mdl-button mdl-button--icon priority_rat" id="prt4"><i class="material-icons">star</i></button>';
            out +=  '<button class="mdl-button mdl-button--icon priority_rat" id="prt5"><i class="material-icons">star</i></button></div>';
            out +=  '</div><hr style="width: 100%;">';
            $('.more_content_added').append(out);
        }

         function display_attach() {
            var out = '';
            out +=  '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons attach_icon" style="color: '+un_color+';">attach_file</i></div><div style="width: 30%;display: flex;"><h4 class="attach_name" style="margin-top: 2px;color: '+un_color+'">  Attachment</h4></div><div style="width:60%;display:flex;">';
            out += '<button type="button" class="mdl-button mdl-js-button mdl-button--colore pic_button"> Upload file<input type="file" name="attach_file" class="upload" id="attach_file" multiple/></button><p style="margin-left:10px;" id="no_of_files">no files selected</p>';
            out +=  '</div></div><div class="mdl-grid" style="width:100%;margin-top:10px;" id="file_details_view"></div><hr style="width: 100%;">';
            $('.more_content_added').append(out);
        }

        $('.more_content_added').on('change','.upload',function (e) {
            e.preventDefault();
            var ins = $('.upload')[0].files.length;
            $('#no_of_files').empty();
            if (ins > 1) {
                $('#no_of_files').append(ins+' files selected');
            }else{
                $('#no_of_files').append(ins+' file selected');
            }
            var input = $('.upload')[0];
            $('#file_details_view').empty();

            for (var i = 0; i < input.files.length; i++) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#file_details_view').append('<div class="mdl-cell mdl-cell--4-col" style="width:25%;height:100px;"><img class="upload_view" src="'+ e.target.result+'" style="max-width:100%;max-height:100%;border: 1px solid #000;" alt="your image" /></div>');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
        });

        $('.more_content_added').on('click','.upload_view' , function (e) {
            e.preventDefault();
            var input = $('.upload')[0];
            $('.img_preview').empty();
            for (var i = 0; i < input.files.length; i++) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.img_preview').append('<div class="mdl-cell mdl-cell--12-col" style="background-color:#fff;"><img class="upload_view" src="'+ e.target.result+'" style="height:100%;width:100%;" alt="No images content" /></div>');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
            $('#img_preview_modal').modal('show');
        });

        function show_file_images() {
            $('#no_of_files').empty();
            if (file_arr.length > 1) {
                $('#no_of_files').append(file_arr.length+' files selected');
            }else{
                $('#no_of_files').append(file_arr.length+' file selected');
            }
            $('#file_details_view').empty();
            for (var i = 0; i < file_arr.length; i++) {
                $('#file_details_view').append('<div class="mdl-cell mdl-cell--4-col" style="width:25%;height:100px;"><img class="edit_upload_view" src="'+file_arr[i]+'" style="max-width:100%;max-height:100%;border: 1px solid #000;" alt="your image" /></div>');;
            }
        }

        $('.more_content_added').on('click','.edit_upload_view' , function (e) {
            e.preventDefault();
            var input = $('.upload')[0];
            $('.img_preview').empty();
            for (var i = 0; i < file_arr.length; i++) {
                $('.img_preview').append('<div class="mdl-cell mdl-cell--12-col" style="background-color:#fff;"><img class="upload_view" src="'+ file_arr[i]+'" style="height:100%;width:100%;" alt="No images content" /></div>');
            }
            $('#img_preview_modal').modal('show');
        });

        function display_group() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons group_icon" style="color: '+un_color+';">group_icon</i></div><div style="width: 30%;display: flex;"><h4 class="group_name" style="margin-top: 2px;color: '+un_color+'">  Share with person</h4></div><input class="mdl-textfield__input" type="text" id="act_person_auto" style="outline: none;border-bottom: 1px solid #666;width:50%;color:#000;" placeholder="Enter person name"><button class="mdl-button mdl-button--icon add_person_btn"><i class="material-icons">add</i></button></div>';
            out += '<div class="mdl-grid person_list_chips"></div>';
            out += '<hr style="width: 100%;">';
            $('.more_content_added').append(out);

            $("#act_person_auto").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(options, request.term);
                    response(results.slice(0, 10));
                }
            });
        }

        $('.more_content_added').on('click','.add_person_btn',function(e) {
            e.preventDefault();
            person_array.push($('#act_person_auto').val());
            $('#act_person_auto').val('');
            $('#act_person_auto').focus();
            append_person_list();
        });

        $('.more_content_added').on('keyup','#act_person_auto',function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                person_array.push($('#act_person_auto').val());
                $(this).val('');
                $(this).focus();
                append_person_list();
            }
        });

        function append_person_list() {
            var out = '';
            out += '<div style="width:100%;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="act_send_mail"><input type="checkbox" id="act_send_mail" class="mdl-switch__input"><span class="mdl-switch__label">Send e-mail to tagged person </span></label></div>';
            out += '<div class="mdl-cell mdl-cell--12-col">';
            for (var i = 0; i < person_array.length; i++) {
                out += '<span class="mdl-chip mdl-chip--contact mdl-chip--deletable" style="margin:5px;"><span class="mdl-chip__contact mdl-color-text--white person_icon" style="background-color:'+un_color+';"><i class="material-icons" style="margin:4px;">person</i></span><span class="mdl-chip__text">'+person_array[i]+'</span><a href="#" class="mdl-chip__action delete_person_chips" id="grp'+i+'"><i class="material-icons">cancel</i></a></span>';
            }
            out += '</div>';
            $('.person_list_chips').empty();
            $('.person_list_chips').append(out);
        }

        $('.more_content_added').on('click','.delete_person_chips',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            id = id.substring(3,4);
            person_array.splice(id, 1);
            append_person_list();
        });

        function display_todo() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons todo_icon" style="color: '+un_color+';">list</i></div><div style="width: 30%;display: flex;"><h4 class="todo_name" style="margin-top: 2px;color: '+un_color+'">  To-do </h4></div><input class="mdl-textfield__input" type="text" id="act_todo_auto" style="outline: none;border-bottom: 1px solid #666;width:50%;color:#000;" placeholder="Enter todo"><button class="mdl-button mdl-button--icon add_todo_btn"><i class="material-icons">add</i></button></div>';
            out += '<div class="mdl-grid todo_list_table" style="display:flex;"></div>';
            out += '<hr style="width: 100%;">';
            $('.more_content_added').append(out);
        }

        $('.more_content_added').on('click','.add_todo_btn',function(e) {
            e.preventDefault();
            todo_array.push({'title' : $('#act_todo_auto').val() , 'status' : true});
            $('#act_todo_auto').val('');
            $('#act_todo_auto').focus();
            append_todo_list();
        });

        $('.more_content_added').on('keyup','#act_todo_auto',function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                todo_array.push({'title' : $('#act_todo_auto').val() , 'status' : false});
                $(this).val('');
                $(this).focus();
                append_todo_list();
            }
        });

        function append_todo_list() {
            var out = '';
            for (var i = 0; i < todo_array.length; i++) {
                out += '<tr style="width:100%;"><td style="width:10%;">';
                if (todo_array[i].status == true) {
                    out += '<input type = "checkbox" id = "'+i+'" class = "mdl-checkbox__input" checked>';
                }else{
                    out += '<input type = "checkbox" id = "'+i+'" class = "mdl-checkbox__input">';
                }
                out += '</td><td style="word-break:break-all;width:70%;"><h4>'+ todo_array[i].title +'</h4></td><td style="width:10%;"><button class="mdl-button mdl-js-button delete_todo" id="'+ i +'"><i class="material-icons">delete</i></button></td><td style="width:10%;"><button class="mdl-button mdl-js-button edit_todo" id="'+ i +'"><i class="material-icons">edit</i></button></td></tr>';
            }
            $('.todo_list_table').empty();
            $('.todo_list_table').append(out);
        }

        $('.more_content_added').on('click', '.delete_todo' , function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            todo_array.splice(id, 1);
            append_todo_list();
        });

        $('.more_content_added').on('click', '.edit_todo' , function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            $('#act_todo_auto').val(todo_array[id].title);
            todo_array.splice(id, 1);
            append_todo_list();
        });

        $('.more_content_added').on('change', 'input[type=checkbox]', function(e) {
            e.preventDefault();
            var id = $(this).prop('id');
            todo_array[id].status = $(this)[0].checked;
        });

        $('.more_content_added').on('click','.priority_rat',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            id = id.substring(3,4);
            star_rat = id;
            $('.priority_rat').css('color','black');
            for (var i = 1; i <= id; i++) {
                $('#prt'+i).css('color','red');
            }
        });

        $('.rem_select_type').click(function (e) {
            e.preventDefault();
            var id  = $(this).prop('id');
            $('#act_reminde').empty();
            $('#act_reminde').append(id);
        });

        function display_note() {
            var out = '';
            out += '<div style="display:flex;"><div style="width: 10%;"><i class="material-icons note_icon" style="color: '+un_color+';">note_add</i></div><div style="width: 30%;display: flex;"><h4 class="note_name" style="margin-top: 2px;color: '+un_color+'">  Notes </h4></div></div>';
            out += '<div style="width: 100%;margin-top:10px;border:1px solid #ccc;"><div contenteditable="true" id="notes_text" style="width: 100%;height:150px;outline: none;overflow: auto;margin-left:5px;" class="mdl-textfield__input"></div></div>';
            out += '<div style="overflow: hidden;overflow-x: auto;display: flex;margin-top: 10px;">';
            out += '<select class="mdl-textfield__input" id="font_button" style="width:40%;"><option value="Arial" selected>Arial</option><option value="Times Roman">Times Roman</option></select>';
            out += '<button class="mdl-button" id="bold_button"><i class="material-icons">format_bold</i></button><button class="mdl-button" id="italic_button"><i class="material-icons">format_italic</i></button><button class="mdl-button" id="underline_button"><i class="material-icons">format_underlined</i></button></div>';
            out += '<hr style="width: 100%;">';
            $('.more_content_added').append(out);
        }

        $('.more_content_added').on('change','#font_button',function (e) {
            e.preventDefault();
            var id = $(this).val();
            $('#notes_text').css('font-family',id);
        });

        $('.more_content_added').on('click','#bold_button',function (e) {
            e.preventDefault();
            document.execCommand("bold");
        });

        $('.more_content_added').on('click','#underline_button',function (e) {
            e.preventDefault();
            document.execCommand("underline");
        });

        $('.more_content_added').on('click','#italic_button',function (e) {
            e.preventDefault();
            document.execCommand("italic");
        });

        $('.more_content_added').on('keyup','#notes_text',function (e) {
            e.preventDefault();
            console.log($(this).html());
        });

        $('.po-markup > .po-link').popover({
            trigger: 'click',
            html: true,
            title: function() {
                return $(this).parent().find('.po-title').html();
            },
            content: function() {
                return $(this).parent().find('.po-body').html();
            },
            placement: 'left'
        }).on('shown.bs.popover', function () {
            $('.a_color').click(function (e) {
                e.preventDefault();
                var id = $(this).prop('id');
                un_color = id;
                $('.act_title').css('background-color',id);
                $('.date_icon').css('color',id);
                $('.date_name').css('color',id);
                $('.repeat_icon').css('color',id);
                $('.repeat_name').css('color',id);
                $('.group_icon').css('color',id);
                $('.group_name').css('color',id);
                $('.todo_icon').css('color',id);
                $('.todo_name').css('color',id);
                $('.mod_icon').css('color',id);
                $('.mod_name').css('color',id);
                $('.attach_icon').css('color',id);
                $('.attach_name').css('color',id);
                $('.cat_icon').css('color',id);
                $('.cat_name').css('color',id);
                $('.loc_icon').css('color',id);
                $('.loc_name').css('color',id);
                $('.reminde_icon').css('color',id);
                $('.reminde_name').css('color',id);
                $('.priority_icon').css('color',id);
                $('.priority_name').css('color',id);
                $('.note_icon').css('color',id);
                $('.note_name').css('color',id);
                $('.person_icon').css('background-color',id);
                $('.repeat_date').css('background-color',id);
            });
        });

        $("#act_date_change").change(function(){
            if($(this).prop("checked") == true){
                $('.act_from_date').css('display','block');
                $('.act_to_date').css('display','block');
                $('.act_from_date_time').css('display','none');
                $('.act_to_date_time').css('display','none');
            }else{
                $('.act_from_date').css('display','none');
                $('.act_to_date').css('display','none');
                $('.act_from_date_time').css('display','block');
                $('.act_to_date_time').css('display','block');
            }
        });

    });
</script>