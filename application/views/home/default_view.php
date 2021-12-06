<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">         
    html, body, h1, h2, h3, h4, h5, h6, a {
        font-family: 'Muli', sans-serif !important;
    }

    .img-box {
        box-shadow: 0px 3px 10px #111; border-radius: 10px;
    }

    .mdl-layout__header {
        background-color: #fff;
        color: #000;
        box-shadow: none;
    }

    .mdl-layout__drawer-button {
        color: #000 !important;
    }

    .full_height {
        height: 100vh;
    }

    .full_height_150 {
        height: 150vh;
    }

    .full_width {
        width: 100%;
    }

    .title_image {
        background: linear-gradient(10deg,rgba(255, 255, 255, 1),rgba(255, 255, 255, 0.5)), url(31216.jpg);
        background-repeat: no-repeat;
        background-size: cover;
    }

    .title_card {
        color: #000;
        padding-top: 40vh;
        text-align: center;
    }

    .title_card_small_text {
        font-size: 2em;
    }

    .title_card_large_text {
        font-weight: bold;
        font-size: 5em;
        line-height: 1.3em;
    }

    .focus_point {
        text-align: center;
        border-radius: 550px;
        box-shadow: 0px 2px 50px #666;
        height: 500px;
        width: 500px;
        padding: 90px;
        background-color: #F44336;
        color: #fff;
        line-height: 1.2em;
        margin: auto;
    }

    .focus_point > h3 {
        font-size: 2em;
    }

    .focus_point > h2 {
        font-weight: bold;
    }

    .focus_question {
        text-align: center;
        height: auto;
        width: 100%;
        padding: 40px;
        background-color: #F44336;
        color: #fff;
        line-height: 1.2em;
        margin: auto;
    }

    .focus_point > h3 {
        font-size: 2em;
    }

    .focus_point > h2 {
        font-weight: bold;
    }

    .problem_button {
        margin: 30px;
        padding: 49px;
        font-size: 2em;
        outline: none;
        line-height: 1.4em;
        width: 300px;
        height: 250px;
        text-align: center;
        cursor: pointer;
        border-radius: 50%;
        background: #f74d4d;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f74d4d), color-stop(100%, #f86569));
        background-image: -moz-gradient(linear, left top, left bottom, color-stop(0%, #f74d4d), color-stop(100%, #f86569));
        box-shadow: 0 15px #e24f4f;
        border: 0px;
    }

    .problem_button:active {
        box-shadow: 0 0 #e24f4f;
        -webkit-transform: translate(0px, 15px);
        -moz-transform: translate(0px, 15px);
        -ms-transform: translate(0px, 15px);
        -o-transform: translate(0px, 15px);
        -webkit-transition: 0.1s all ease-out;
        -moz-transition: 0.1s all ease-out;
        -ms-transition: 0.1s all ease-out;
        -o-transition: 0.1s all ease-out;
        transition: 0.1s all ease-out;
    }

    @media only screen and (max-width: 450px) {
        .title_card {
            padding-top: 20vh;
            text-align: left;
        }

        .title_card_large_text {
            font-size: 3.7em;
        }

        .focus_point {
            border-radius: 10px;
            height: auto;
            padding: 25px;
            text-align: left;
        }

        .focus_point > h3 {
            font-size: 1.6em;
        }

        .focus_point > h2 {
            font-size: 3em;
            font-weight: bold;
        }

        .problem_button {
            margin: 0px;
        }

        .text-justify {
            padding: 0px !important;
        }

        .text-justify > h4 {
            padding: 24px;
            font-size: 1.4em;
        }

        .hdr {
            width: 100%;
        }
    }
    

    @media only screen and (max-width: 320px) {
        .title_card_large_text {
            font-size: 3em;
        }

        .focus_point {
            width: 100%;
        }

        .focus_point > h2 {
            font-size: 2.5em;
        }

        .text-justify {
            padding: 0px !important;
        }

        .text-justify > h4 {
            padding: 24px;
            font-size: 1.4em;
        }
    }

    .benefits {
        height: 300px;
    }
    

    .access_button {
        width: 50%;
    }

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

    a:hover {
        text-decoration: none;
    }

    a:focus {
        text-decoration: none;
    }

    .text-justify {
        text-align: justify;
        padding: 10px;
    }

    .text-justify > h4 {
        padding: 30px;
        box-shadow: 0px 5px 20px #aaa;
        border-radius: 10px;
    }

    .main_features {
        border-radius: 5px; box-shadow: 0px 3px 10px #aaa;padding: 10px;
    }

    .main_features > h4 {
        text-align: center;
        color: #f44336;
    }

    .main_features > ul {
        padding-left: 20px;
    }


    .activity {
        background-color: #fff;
        height: 86vh;
    }

    .activity_records {
        border: 1px solid #ccc;
        margin: 10px;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px 3px 10px #666;
    }

    .main_blocks {
        height: 82vh;
    }

    .main_blocks_contents {
        height: 72vh;
        overflow-y: auto;
    }

    .activity_parent {
        box-shadow: 0px 5px 15px #666;
        border-radius: 10px;
        background-color: #000;
        color: #fff;
    }

    .activity_headers {
        display: flex;
        padding: 10px 10px;
    }

    .activity_body {
        background-color: #fff;
        color: #000;
        border-radius: 10px;
    }

    .activity_headers_title {
        margin: 0px 0px 0px 5px;
    }

    .component_hide {
        display: none;
    }

    .component_show {
        display: block;
    }

    .activity_tasks {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 3px 10px #ccc;
        margin: 5px;
    }
    .activity_task_title {
        padding: 10px 0px;
        font-size: 2em;
        font-weight: bold;
    }

    .activity_task_color {
        height: 2px; 
        width: 80%;
        text-align: center;
        /*background-color: #ffcc00;*/
        margin: 20px;
    }
    

    .activity_task_module_shortcut {
        color: #666;
        margin: 10px 30px;
        text-align: right;
        padding: 20px 0px;
        font-weight: bold;
    }

    .activity_task_people {
        padding: 10px 0px;
    }

    .activity_task_todo {
    }

    .activity_task_todo > .activity_task_todo_title {
        padding: 10px;
        border-bottom: 1px solid #ccc;
    }

    .activity_task_todo > .activity_task_todo_items {
        padding: 10px;
    }

    .activity_task_todo > .activity_task_todo_items > label {
        margin: 2px;
    }

    .activity_task_notes {
        margin: 15px;
        word-break: break-all;
    }

    .activity_task_category {
        font-style: italic;
        font-weight: bold;
        padding: 10px 0px;
    }

    .activity_task_location {
    }

    .activity_task_people {
    }

    .activity_task_date {
        font-size: 0.8em;
        padding: 10px;
    }

    .activity_task_inactive_button {
        width: 100%;
        margin: 5px;
        text-align: left;
    }

    .activity_task_active_button {
        width: 100%;
        margin: 5px;
        text-align: left;
        background-color: #f44336;
        color: #fff;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
    }

    .activity_empty {
        text-align: center;
    }

    .activity_empty > img {
        width: 60%;
        margin: 40px auto;
    }

    .activity_empty > p {
        font-size: 2em;
        line-height: 1em;
        padding: 10px 0px;
        font-weight: bold;
    }

    .widget_parent_header {
        display: flex; padding: 10px;
    }

    .widget_parent_header > p {
        font-size: 2em; font-weight: bold; line-height: 1.3em;
    }

    .widget_parent_body {

    }

    .widget_data {
        border-radius: 10px;
        border:1px solid #ccc;
        margin: 10px;
    }

    .widget_data_text {
        
    }

    .widget_data_highlight {
        font-size: 3em;
        font-weight: bold;
        text-align: center;
        padding: 20px;
    }
    .widget_data_chart > canvas {
        width: 60%;
        height: auto;
    }

    .widget_list_modal_cell {
        border: 1px solid #ccc;
        border-radius: 10px;
        text-align: left;
        padding: 20px;
    }

    .widget_list_modal_cell > h3 {
        font-size: 2em;
    }

    .widget_search {
        outline: none;
        padding: 20px;
        width: 99%;
        border: 0px;
        border-bottom: 1px solid #ccc;
        font-size: 2em;
        font-weight: bold;
    }

    .widget_list_modal_cell {
        border: 1px solid #ccc;
        border-radius: 10px;
        text-align: left;
        padding: 20px;
    }

    .widget_list_modal_cell > h3 {
        font-size: 2em;
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

    @media only screen and (max-width: 767px) {
        .closing_tag {
            font-size: 2.3em;
            font-weight: bold;
        }

        .gs_text_title {
            font-size: 2em;
        }

        .gs_text_description {
            font-size: 1.3em;
        }

        .gs_text_description_secondary {
            font-size: 1.2em;
            line-height: 1.5em;
        }
    }

    .gs_text {
        text-align: justify;
    }

    .gs_image {
        width: auto;
        height: 40vh;
    }

    ::placeholder {
      color: #ccc;
    }

    .po-mark > .popover {
        width: 300px;
        left: 30px;
        max-width: 90%;
        margin-right: 10px;
    }

    .dropbtn {
      background-color: #4CAF50;
      color: white;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .dropbtn:hover, .dropbtn:focus {
      background-color: #3e8e41;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #fff;
      min-width: 230px;
      overflow: auto;
      border: 1px solid #ddd;
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {background-color: #ddd;}

    .show {display: block;}
</style>
    <div class="mdl-grid" style="width: 100%;">
        <div class="mdl-cell mdl-cell--4-col mdl-cell--6-col-tablet main_blocks activity_parent">
            <div class="activity_headers">
                <div class="dropdown">
                    <button id="group_select" class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised grp_title dropbtn" onclick="myFunction()"></button>
                    <div id="myDropdown" class="dropdown-content">
                    <?php
                        if ($gid != 0) {
                            echo '<a class="group_select_type" id="self">Groups</a>';
                        }else{
                            echo '<a class="group_select_type" id="all">All</a>';
                            echo '<a class="group_select_type" id="group">Groups</a>';
                            echo '<a class="group_select_type" id="self">Self</a>';
                        }
                    ?>
                    </div>
                </div>
                <div><h4 class="activity_headers_title">Things to do today</h4></div>
                <div class="mdl-grid" style="text-align: right;">
                    <div id="activity_progress_digit" style="font-size: 1.8em;"></div>
                </div>
            </div>
            <div class="activity_body">
                <div class="mdl-grid main_blocks_contents">
                    <div class="mdl-cell mdl-cell--12-col self_activity component_hide">
                    </div>
                    <div class="mdl-cell mdl-cell--12-col group_activity component_hide">
                    </div>
                    <div class="mdl-cell mdl-cell--12-col all_activity component_hide">
                    </div>
                    <div class="mdl-cell mdl-cell--12-col activity_empty component_hide">
                        <img src="<?php echo base_url().'assets/images/relax2.svg'; ?>" style="width: 70%;">
                        <p>No tasks for today</p>
                        <button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised" id="add_act"><i class="material-icons">add</i> Add Activity</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--8-col mdl-cell--6-col-tablet main_blocks widget_parent">
            <div class="widget_parent_header">
                <p>Operational Insights</p>
                <button class="mdl-button mdl-js--button mdl-button--colored" id="widget_button"><i class="material-icons">add</i> Add Widgets</button> 
            </div>
            <div class="main_blocks_contents widget_parent_body">
                <div class="mdl-grid" id="kpi_outcome">
                    <?php
                        if (isset($get_chart)) {
                            for ($i=0; $i <count($get_chart) ; $i++) { 
                                echo $get_chart[$i];
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add"><i class="material-icons">calendar_today</i></button>
<div id="purchase_modules" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <h4> Now, </h4>
                <img src="<?php echo base_url().'assets/images/'; ?>block_module.png" class="gs_image">
                <h4>Search & Add Modules to your Daifunc Account</h4>
                <button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised proceed_col">Proceed <i class="material-icons">play_arrow</i></button>
                <h4 style="color: #aaa;">Or you can go to the <b style="color: #000;"><i class="material-icons">menu</i> Menu</b>, and click on <b style="color: #000;"> Collections</b></h4>
            </div>
        </div>
    </div>
</div>
<div id="accounting_year" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <h4> Now, </h4>
                <h4> Add accounting year</h4>
                <h5>click on button </h5>
                <button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised add_acc_yr">Proceed <i class="material-icons">play_arrow</i></button>
            </div>
        </div>
    </div>
</div>
<div id="email_setting" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <h4> Now, </h4>
                <h4> Add email setting</h4>
                <h5> click on button</h5>
                <button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised add_email_set">Proceed <i class="material-icons">play_arrow</i></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="activity_Modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Reschedule Activity</h4>
            </div>
            <div class="modal-body">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" data-type="date" id="r_date" value="<?php echo date('Y-m-d H:m');?>">
                    <label class="mdl-textfield__label" for="r_date">Date</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                    <input class="mdl-textfield__input" type="text" id="act_cmt">
                    <label class="mdl-textfield__label" for="act_cmt">Enter Comments</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button btn-default" data-dismiss="modal" id="r"><i class="material-icons">calendar_today</i> Reshedule</button>
                <button type="button" class="mdl-button btn-default" data-dismiss="modal"><i class="material-icons">close</i> close</button>
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
                <button type="button" class="mdl-button" data-dismiss="modal" id="add_cmt"><i class="material-icons">save</i> Save</button>
                <button type="button" class="mdl-button btn-default" data-dismiss="modal"><i class="material-icons">close</i> close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="verify_subscription" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Verify with customer</h4>
            </div>
            <div class="modal-body">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="sub_action">
                    <label class="mdl-textfield__label" for="sub_action">Enter action taken</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label sub_code">
                    <input class="mdl-textfield__input" type="text" id="sub_code">
                    <label class="mdl-textfield__label" for="sub_code">Enter verify code</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label sub_cmt">
                    <input class="mdl-textfield__input" type="text" id="sub_cmt">
                    <label class="mdl-textfield__label" for="sub_cmt">Enter Remark</label>
                </div>
                <div class="mdl-cell mdl-cell--12-col" id="star_rat">
                    <p>give rating's</p>
                    <button class="mdl-button mdl-button--icon star_rat" id="1"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="2"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="3"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="4"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="5"><i class="material-icons">star</i></button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal" id="code_verify">verify</button>
            </div>
        </div>
    </div>
</div>
<div id="widget_list_modal"  class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header" style="text-align: left;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <input type="text" id="search_widget" placeholder="Search widgets.." class="widget_search">
            </div>
            <div class="modal-body" style="text-align: center;">
                <div class="mdl-grid" id="widget_list_modal_parent">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
    function myFunction() {
        $('#myDropdown').toggle('show');
    }
    $('.btn-explore-irene').click(function(e) {
        e.preventDefault();
        $('#s_name').focus();
        $('#s_name').val($(this).html());
        $('#s_name').trigger(jQuery.Event( 'keyup', { keyCode: 13, which: 13 }));
    })
    var s_count = 0;
    var g_count = 0;
    var a_count = 0;
    var call_flg = 0;
    var m_s = [];
    var activity_perform = [];
    var activity_self = []; var activity_todo_self =[]; 
    var activity_group = []; var activity_todo_group = [];
    var activity_all = []; var activity_todo_all = [];
    var activity_person = []; var a= 0; var type = 'self';
    var widgets = [];
    var r_type = '';
    var stat = '';
    var act_type = '';
    <?php 
        ################## widget ##############
        if (isset($widget)) {
            for ($i=0; $i <count($widget) ; $i++) { 
                echo "widgets.push({'id':'".$widget[$i]->iukpi_id."','title' : '".$widget[$i]->iukpi_title."', 'description' : 'Get a list of total collections you have gathered for the current month.'});";
            }
        }
        ################## self ################
        if (isset($s_activity)) {
            for ($i=0; $i < count($s_activity); $i++) {
                if ($s_activity[$i]->iua_status == 'progress') {
                    echo "activity_self.push({'id' : ".$s_activity[$i]->iua_id.",'type' : '".$s_activity[$i]->iua_type."', 'title' : '".$s_activity[$i]->iua_title."', 'place': '".$s_activity[$i]->iua_place."', 'todo' : ".$s_activity[$i]->iua_to_do.", 'note' : '".$s_activity[$i]->iua_note."', 'date' : '".date("d-m-Y H:i:s", strtotime($s_activity[$i]->iua_date))."','cat' : '".$s_activity[$i]->iua_categorise."', 'pid' : '".$s_activity[$i]->iua_p_activity."','status' : '".$s_activity[$i]->iua_status."', 'modify' : '".$s_activity[$i]->iua_modified_by."', 'shortcuts' : '".$s_activity[$i]->iua_shortcuts."','m_shortcuts' : '".$s_activity[$i]->iua_m_shortcuts."','color' : '".$s_activity[$i]->iua_color."', 'e_date': '".date("d-m-Y H:i:s", strtotime($s_activity[$i]->iua_end_date))."'});";
                    echo "a++;";
                }
            }

            for ($i=0; $i < count($s_activity); $i++) {
                if ($s_activity[$i]->iua_status == 'done' || $s_activity[$i]->iua_status == 'cancel') {
                    echo "s_count++;";
                }else if ($s_activity[$i]->iua_status == 'pending' || $s_activity[$i]->iua_status == 'reschedule') {
                    echo "activity_self.push({'id' : ".$s_activity[$i]->iua_id.",'type' : '".$s_activity[$i]->iua_type."', 'title' : '".$s_activity[$i]->iua_title."', 'place': '".$s_activity[$i]->iua_place."', 'todo' : ".$s_activity[$i]->iua_to_do.", 'note' : '".$s_activity[$i]->iua_note."', 'date' : '".date("d-m-Y H:i:s", strtotime($s_activity[$i]->iua_date))."','cat' : '".$s_activity[$i]->iua_categorise."', 'pid' : '".$s_activity[$i]->iua_p_activity."','status' : '".$s_activity[$i]->iua_status."', 'modify' : '".$s_activity[$i]->iua_modified_by."', 'shortcuts' : '".$s_activity[$i]->iua_shortcuts."','m_shortcuts' : '".$s_activity[$i]->iua_m_shortcuts."','color' : '".$s_activity[$i]->iua_color."', 'e_date': '".date("d-m-Y H:i:s", strtotime($s_activity[$i]->iua_end_date))."'});";
                    echo "a++;";
                }
            }

            for ($i=0; $i < count($s_activity_todo); $i++) { 
                echo "activity_todo_self.push({'id' : ".$s_activity_todo[$i]->iuat_id.", 'a_id' : ".$s_activity_todo[$i]->iuat_a_id.", 'title' : '".$s_activity_todo[$i]->iuat_title."', 'status' : '".$s_activity_todo[$i]->iuat_status."'});\n\r";

            }
        }
        ################## group ##################
        if (isset($g_activity)) {
            for ($i=0; $i < count($g_activity); $i++) {
                if ($g_activity[$i]->iua_status == 'progress') {
                    echo "activity_group.push({'id' : ".$g_activity[$i]->iua_id.",'type' : '".$g_activity[$i]->iua_type."', 'title' : '".$g_activity[$i]->iua_title."', 'place': '".$g_activity[$i]->iua_place."', 'todo' : ".$g_activity[$i]->iua_to_do.", 'note' : '".$g_activity[$i]->iua_note."', 'date' : '".date("d-m-Y H:i:s", strtotime($g_activity[$i]->iua_date))."','cat' : '".$g_activity[$i]->iua_categorise."', 'pid' : '".$g_activity[$i]->iua_p_activity."','status' : '".$g_activity[$i]->iua_status."', 'modify' : '".$g_activity[$i]->iua_modified_by."', 'shortcuts' : '".$g_activity[$i]->iua_shortcuts."','m_shortcuts' : '".$g_activity[$i]->iua_m_shortcuts."','e_date': '".date("d-m-Y H:i:s", strtotime($g_activity[$i]->iua_end_date))."'});";
                }
            }

            for ($i=0; $i < count($g_activity); $i++) {
                if ($g_activity[$i]->iua_status == 'done' || $g_activity[$i]->iua_status == 'cancel') {
                    echo "g_count++;";
                } 
                if ($g_activity[$i]->iua_status == 'pending' || $g_activity[$i]->iua_status == 'reschedule') {
                    echo "activity_group.push({'id' : ".$g_activity[$i]->iua_id.",'type' : '".$g_activity[$i]->iua_type."', 'title' : '".$g_activity[$i]->iua_title."', 'place': '".$g_activity[$i]->iua_place."', 'todo' : ".$g_activity[$i]->iua_to_do.", 'note' : '".$g_activity[$i]->iua_note."', 'date' : '".date("d-m-Y H:i:s", strtotime($g_activity[$i]->iua_date))."','cat' : '".$g_activity[$i]->iua_categorise."', 'pid' : '".$g_activity[$i]->iua_p_activity."','status' : '".$g_activity[$i]->iua_status."', 'modify' : '".$g_activity[$i]->iua_modified_by."', 'shortcuts' : '".$g_activity[$i]->iua_shortcuts."','m_shortcuts' : '".$g_activity[$i]->iua_m_shortcuts."','e_date': '".date("d-m-Y H:i:s", strtotime($g_activity[$i]->iua_end_date))."'});";
                }
            }

            for ($i=0; $i < count($g_activity_todo); $i++) { 
                echo "activity_todo_group.push({'id' : ".$g_activity_todo[$i]->iuat_id.", 'a_id' : ".$g_activity_todo[$i]->iuat_a_id.", 'title' : '".$g_activity_todo[$i]->iuat_title."', 'status' : '".$g_activity_todo[$i]->iuat_status."'});\n\r";
            }
        }
        
        ################# all ######################
        if (isset($a_activity)) {
            for ($i=0; $i < count($a_activity); $i++) {
                if ($a_activity[$i]->iua_status == 'progress') {
                    echo "activity_all.push({'id' : ".$a_activity[$i]->iua_id.",'type' : '".$a_activity[$i]->iua_type."', 'title' : '".$a_activity[$i]->iua_title."', 'place': '".$a_activity[$i]->iua_place."', 'todo' : ".$a_activity[$i]->iua_to_do.", 'note' : '".$a_activity[$i]->iua_note."', 'date' : '".date("d-m-Y H:i:s", strtotime($a_activity[$i]->iua_date))."','cat' : '".$a_activity[$i]->iua_categorise."', 'pid' : '".$a_activity[$i]->iua_p_activity."','status' : '".$a_activity[$i]->iua_status."', 'modify' : '".$a_activity[$i]->iua_modified_by."', 'shortcuts' : '".$a_activity[$i]->iua_shortcuts."','m_shortcuts' : '".$a_activity[$i]->iua_m_shortcuts."','e_date': '".date("d-m-Y H:i:s", strtotime($a_activity[$i]->iua_end_date))."'});";
                }
            }
            for ($i=0; $i < count($a_activity); $i++) {
                if ($a_activity[$i]->iua_status == 'done' || $a_activity[$i]->iua_status == 'cancel') {
                    echo "a_count++;";
                } 
                if ($a_activity[$i]->iua_status == 'pending' || $a_activity[$i]->iua_status == 'reschedule') {
                    echo "activity_all.push({'id' : ".$a_activity[$i]->iua_id.",'type' : '".$a_activity[$i]->iua_type."', 'title' : '".$a_activity[$i]->iua_title."', 'place': '".$a_activity[$i]->iua_place."', 'todo' : ".$a_activity[$i]->iua_to_do.", 'note' : '".$a_activity[$i]->iua_note."', 'date' : '".date("d-m-Y H:i:s", strtotime($a_activity[$i]->iua_date))."','cat' : '".$a_activity[$i]->iua_categorise."', 'pid' : '".$a_activity[$i]->iua_p_activity."','status' : '".$a_activity[$i]->iua_status."', 'modify' : '".$a_activity[$i]->iua_modified_by."', 'shortcuts' : '".$a_activity[$i]->iua_shortcuts."','m_shortcuts' : '".$a_activity[$i]->iua_m_shortcuts."','e_date': '".date("d-m-Y H:i:s", strtotime($a_activity[$i]->iua_end_date))."'});";
                }
            }

            for ($i=0; $i < count($a_activity_todo); $i++) { 
                echo "activity_todo_all.push({'id' : ".$a_activity_todo[$i]->iuat_id.", 'a_id' : ".$a_activity_todo[$i]->iuat_a_id.", 'title' : '".$a_activity_todo[$i]->iuat_title."', 'status' : '".$a_activity_todo[$i]->iuat_status."'});\n\r";

            }
        }
        
        
        for ($i=0; $i <count($activity_perform) ; $i++) {
            echo "activity_perform.push({'cid' : ".$activity_perform[$i]->ic_uid.",'cname' : '".$activity_perform[$i]->ic_name."'});";
        }
        
        for ($i=0; $i <count($activity_person) ; $i++) { 
            echo "activity_person.push({'id' : ".$activity_person[$i]->iuap_a_id.",'tag_name' : '".$activity_person[$i]->ic_name."'});";
        }
      
        for ($i=0; $i <count($m_shortcuts) ; $i++) {
            echo "m_s.push({'id' : '".$m_shortcuts[$i]->ims_id."','f_id': '".$m_shortcuts[$i]->ims_function."','f_name' : '".$m_shortcuts[$i]->ifun_name."','domain': '".$m_shortcuts[$i]->idom_name."','mid' : '".$m_shortcuts[$i]->ims_m_id."','icon' : '".$m_shortcuts[$i]->ims_icon."' , 'ms_name' : '".$m_shortcuts[$i]->ims_name."'});";
        }

        if ($gid != 0) {
            echo "$('.grp_title').append('group');";
        }else{
            echo "$('.grp_title').append('self');";
        }

        if (isset($users)) {
            if ($users[0]->i_view == 'false' ) {
                echo "$('#getting_started').modal('toggle');";
            }
        }

        echo "r_type='".$type."';";
    ?>
    var act_total_count = <?php echo count($s_activity); ?>;
    var act_perform_count = s_count;
    var re_id;
    var star_rat = 0;
    $(document).ready(function() {
        if (r_type == 'account') {
            $('#email_setting').modal('toggle');
        }else if(r_type == 'email'){
            $('#purchase_modules').modal('toggle');
        }

        $('#next_modal').click(function(e) {
            e.preventDefault();
            $('#getting_started').modal('hide');
            setTimeout(function() {
                $('#accounting_year').modal('show');
            }, 1000);
        });

        $('#myCarousel').on('slid.bs.carousel', function (e) {
            if ($('.carousel-inner .item:last').hasClass('active')) {
                $('#myCarousel').carousel('pause');
            }
            if ($('.carousel-inner .item:first').hasClass('active')) {
                $('#myCarousel').carousel('cycle');
            }
        });

        $('#accounting_year').on('click','.add_acc_yr',function (e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Account/user_accounting_setting/'.$code.'/home'; ?>";
        });

        $('#email_setting').on('click','.add_email_set',function (e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Account/email_setting/'.$code.'/home'; ?>";
        });

        $('#purchase_modules').on('click','.proceed_col',function (e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Home/collection/0/'.$code; ?>";
        });

        load_activity_self();
        $('.self_activity').removeAttr('component_hide');
        $('.self_activity').addClass('component_show');
        var snackbarContainer = document.querySelector('#demo-toast-example');

        $('#self').addClass('mdl-button--colored');
        var perc = act_perform_count / act_total_count * 100;
        update_progress(perc);
        
        $('.activity_body').on('change', 'input[type=checkbox]', function(e) {
            var id = $(this).prop('id');
            var status = $(this)[0].checked;
            $.post('<?php echo base_url()."Home/activity_update_todo/".$code; ?>', {
                'i' : id, 's' : status
            }, function(d, s,x) {
                for (var i = 0; i < activity_todo_all.length; i++) {
                    if(activity_todo_all[i].id == id){
                        activity_todo_all[i].id = status;
                        break;
                    }
                }
                for (var i = 0; i < activity_todo_self.length; i++) {
                    if(activity_todo_self[i].id == id){
                        activity_todo_self[i].id = status;
                    }
                }
                for (var i = 0; i < activity_todo_group.length; i++) {
                    if(activity_todo_group[i].id == id){
                        activity_todo_group[i].id = status;
                    }
                }
            }, "text");
        });

        $('#widget_button').click(function(e) {
            e.preventDefault();
            $('#widget_list_modal').modal('toggle');
            display_widgets();
        })

        $('.widget_search').keyup(function (e){
            e.preventDefault();
            if (e.keyCode == 13) {
                var widg_serach = $(this).val();
                $.post('<?php echo base_url()."Home/widget_search/".$code; ?>', {
                    'name' : widg_serach
                }, function(d, s,x) {
                    var d = JSON.parse(d);
                    widgets = [];
                    for (var i=0; i <d.widget.length ; i++) { 
                        widgets.push({id : d.widget[i].iukpi_id ,title : d.widget[i].iukpi_title, description : 'Get a list of total collections you have gathered for the current month.'});
                    }
                    display_widgets();
                }, "text");
            }
        });

        $('#widget_list_modal_parent').on('click','.widget_list_modal_add_button',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            window.location = "<?php echo base_url().'Home/add_widget/'.$code.'/'; ?>"+id;
        });

        $('#verify_subscription').on('click','.star_rat',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            star_rat = id;
            $('.star_rat').css('color','black');
            for (var i = 1; i <= id; i++) {
                $('#'+i).css('color','orange');
            }
        });

        $('.group_select_type').click(function(e) {
            e.preventDefault();
            type = $(this).prop('id');
            $('#myDropdown').toggle('hide');
            <?php
                if ($gid != 0) {
                    echo "$('.grp_title').empty();$('.grp_title').append('group');";
                }else{
                    echo "$('.grp_title').empty();$('.grp_title').append(type);";
                }
            ?>

            if(type == 'self'){
                $('.self_activity').removeClass('component_hide');
                $('.self_activity').addClass('component_show');
                $('.group_activity').addClass('component_hide');
                $('.all_activity').addClass('component_hide');
                $('.activity_empty').removeClass('component_show');
                $('.activity_empty').addClass('component_hide');
                $('.group_activity').empty();
                $('.all_activity').empty();
                load_activity_self();

                act_total_count = <?php echo count($s_activity); ?>;
                act_perform_count = s_count;
                var perc = act_perform_count / act_total_count * 100;
                update_progress(perc);
            }else if(type == 'group'){
                $('.group_activity').removeClass('component_hide');
                $('.group_activity').addClass('component_show');
                $('.all_activity').addClass('component_hide');
                $('.self_activity').addClass('component_hide');
                $('.activity_empty').removeClass('component_show');
                $('.activity_empty').addClass('component_hide');
                $('.self_activity').empty();
                $('.all_activity').empty();
                load_activity_group();
                act_total_count = <?php if(isset($g_activity)){echo count($g_activity);}else{echo count($s_activity);}?>;
                act_perform_count = g_count;
                var perc = act_perform_count / act_total_count * 100;
                update_progress(perc);
                
            }else if(type == 'all'){
                $('.all_activity').removeClass('component_hide');
                $('.all_activity').addClass('component_show');
                $('.self_activity').addClass('component_hide');
                $('.group_activity').addClass('component_hide');
                $('.activity_empty').removeClass('component_show');
                $('.activity_empty').addClass('component_hide');
                $('.group_activity').empty();
                $('.self_activity').empty();
                load_activity_all();
                act_perform_count = a_count;
                act_total_count = <?php if(isset($a_activity)){echo count($a_activity);}else{echo count($s_activity);}?>;
                var perc = act_perform_count / act_total_count * 100;
                update_progress(perc); 
             
            }
        });

        $('.refresh').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Home/index/'.$code; ?>";
        });

        $('#add').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Home/activity/'.$code; ?>";
        });

        $('#add_act').click(function(e) {
            e.preventDefault();
            window.location = "<?php echo base_url().'Home/activity/'.$code; ?>";
        });

        $('.activity_body').on('click', '.activity_action', function(e) {
            e.preventDefault();
            var a=$(this).prop('id');
            var b=a.substring(0,1);
            var c=a.substring(1, a.length);
            var flg = 0;
            if (type == 'self') {
                for (var i = 0; i < activity_self.length; i++) {
                    if (activity_self[i].id == c) {
                        flg = 1;
                        act_type = activity_self[i].type;
                        break;
                    }
                }
            }else if (type == 'all' || type == 'group' ) {
                 for (var i = 0; i < activity_all.length; i++) {
                    if (activity_all[i].id == c) {
                        act_type = activity_all[i].type;
                        break;
                    }
                }
            }

            if(b == "a"){
                window.location = "<?php echo base_url().'Home/activity/'.$code.'/null/'; ?>"+ c;
            }else if(b == 'e') {
                    $.post('<?php echo base_url()."View/activity_edit/".$code."/"; ?>'+c
                    , function(data, status, xhr) {
                        $('#activity_modal > div > div').empty();
                        $('#activity_modal > div > div').append(data);
                    }, 'text');
                    $('#activity_modal').modal('toggle');
            }else if (b == "r") {
                $('#activity_Modal').modal('show');
                re_id = c;
            }else if (b == 'd') {
                if (act_type == 'Event') {
                    update_activity_status(c,b,null);
                }else{
                    $('#add_note').modal('show');
                    re_id = c;
                    stat = b;
                }
            }else if (b == 's'){
                if (act_type == 'support') {
                    re_id = c;
                    send_support_mail(c);
                }else if (act_type == 'subscription') {
                    re_id = c;
                    send_mail(c);
                }
            }else{
                if (act_type == 'Event') {
                    update_activity_status(c,b,null);
                }else{
                    $('#add_note').modal('show');
                    re_id = c;
                    stat = b;
                }
            }
        });

        function send_mail(aid) {
            $('.loader').css('display','block');
            $.post('<?php echo base_url()."Home/subscription_mail_send/".$code."/"; ?>'+aid,            
            function(d, s,x) {
                $('.loader').css('display','none');
                if (d == 'false' || d == '') {
                    $('#sub_code').val('');
                    $('#verify_subscription').modal('show');
                }else if(d == 'true'){
                    $('.sub_code').css('display','none');
                    $('.sub_cmt').css('display','none');
                    $('#star_rat').css('display','none');
                    $('#sub_code').val('');
                    $('#verify_subscription').modal('show');
                }else{
                    var data = {message: 'Please check email id !'};
                    snackbarContainer.MaterialSnackbar.showSnackbar(data);
                }
            }, "text");
        };

        function send_support_mail(aid) {
            $('.loader').css('display','block');
            var url;
            if (act_type == 'support') {
                var url = '<?php echo base_url()."Home/support_mail_send/".$code."/"; ?>';
            }else{
                var url = '<?php echo base_url()."Home/subscription_mail_send/".$code."/"; ?>';
            }
            $.post(url+aid,
            function(d, s,x) {
                $('.loader').css('display','none');
                if (d == 'false' || d == '') {
                    $('#sub_code').val('');
                    $('#verify_subscription').modal('show');
                }else if(d == 'true'){
                    $('.sub_code').css('display','none');
                    $('.sub_cmt').css('display','none');
                    $('#star_rat').css('display','none');
                    $('#sub_code').val('');
                    $('#verify_subscription').modal('show');
                }else{
                    var data = {message: 'Please check email id !'};
                    snackbarContainer.MaterialSnackbar.showSnackbar(data);
                }
            }, "text");
        };

        $('#code_verify').click(function (e) {
            e.preventDefault();
            var sub_code = $('#sub_code').val();
            if (act_type == 'support') {
                var url = '<?php echo base_url()."Home/support_code_verify/".$code."/"; ?>'+re_id;
            }else{
                var url = '<?php echo base_url()."Home/subscription_code_verify/".$code."/"; ?>'+re_id;
            }
            $.post(url,{
                'sub_code' : sub_code,
                'cmt' : $('#sub_cmt').val(),
                'sub_action' : $('#sub_action').val(),
                'rat' : star_rat
            },function(d, s,x) {
                if (d == 'true') {
                    window.location = "<?php echo base_url().'Home/index/'.$code; ?>";
                }else{
                    var data = {message: 'Please enter correct verification code !'};
                    snackbarContainer.MaterialSnackbar.showSnackbar(data);
                }
            }, "text"); 
        });

        $('#add_note').on('click','#add_cmt',function (e) {
            e.preventDefault();
            update_activity_status(re_id,stat,$('#pro_note').val());
        });

        $('#activity_Modal').on('click', '#r', function(e) {
            $.post('<?php echo base_url()."Home/activity_resheduled/".$code; ?>', {
                'id' : re_id, 'r_date' : $('#r_date').val(), 'cmt' : $('#act_cmt').val()
            }, function(d, s,x) {
                window.location = "<?php echo base_url().'Home/index/'.$code; ?>";
            }, "text");
        });

        $('.shortcuts').click(function(e){
            var mid = $(this).prop('id');
            for (var i = 0; i < m_s.length; i++) {
                if(m_s[i].id == mid){
                    window.location = "<?php echo base_url(); ?>"+ m_s[i].domain +'/'+m_s[i].f_name+'/'+m_s[i].mid+'/'+"<?php echo $code; ?>";
                    break;
                }
            }
        });
    });

    function update_activity_status(id, status, cmt) {
        $.post('<?php echo base_url()."Home/activity_status_update/".$code; ?>', {
            'i' : id,
            's' : status,
            'cmt' : cmt
        }, function(d,s,x) {
            window.location = "<?php echo base_url().'Home/index/'.$code; ?>";
        })
    }

    $( "#r_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm'});

    function load_activity_self(){
        var a = '';flg = 0;
        if (activity_self.length > 0) {
            for (var i = 0; i < activity_self.length; i++) {
                a+='<div class="activity_tasks">';
                    a+='<div class="activity_task_title"><div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col">' + activity_self[i].title + '</div><div class="mdl-cell mdl-cell--2-col" style="margin-top:-10px;"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="e' + activity_self[i].id + '"><i class="material-icons">edit</i> edit</button></div></div></div>';
                    if(activity_self[i].shortcuts != 'null' && activity_self[i].shortcuts != '' && activity_self[i].shortcuts != 0){
                        a+='<div class="activity_task_module_shortcut">';
                        for (var j = 0; j< m_s.length; j++) {
                            if(m_s[j].f_id == activity_self[i].shortcuts){
                                a+='<button class="mdl-button shortcuts" id="'+m_s[j].id+'"><i class="material-icons">'+m_s[j].icon+'</i>'+m_s[j].ms_name+'</button>';
                            }
                        }
                        a+='</div>';
                    }
                    if (activity_self[i].color == 'red') {
                        a+='<div class="activity_task_color" style="background-color:rgba(255, 0, 0, 0.63);"></div>';
                    }else if (activity_self[i].color == 'white') {
                        a+='<div class="activity_task_color" style="background-color:white;"></div>';
                    }else if (activity_self[i].color == 'orange') {
                        a+='<div class="activity_task_color" style="background-color:rgba(255, 165, 0, 0.65);"></div>';
                    }else if (activity_self[i].color == 'blue') {
                        a+='<div class="activity_task_color" style="background-color:rgba(0, 0, 255, 0.64);"></div>';
                    }else if (activity_self[i].color == 'green') {
                        a+='<div class="activity_task_color" style="background-color:rgba(0, 128, 0, 0.74);"></div>';
                    }
                    if (activity_self[i].todo==1) {
                        a+='<div class="activity_task_todo">';
                            a+='<div class="activity_task_todo_title">Things to-do</div>';
                            a+='<div class="activity_task_todo_items">';
                                for (var j=0; j < activity_todo_self.length; j++) {
                                    if (activity_self[i].id == activity_todo_self[j].a_id) {
                                        if (activity_todo_self[j].status == "false") {
                                            a+='<label class="mdl-checkbox mdl-js-checkbox"><input type="checkbox" id="' + activity_todo_self[j].id +'" class="mdl-checkbox__input"><span class="mdl-checkbox__label">' + activity_todo_self[j].title + '</span></label>';
                                        } else {
                                            a+='<label class="mdl-checkbox mdl-js-checkbox"><input type="checkbox" id="' + activity_todo_self[j].id +'" class="mdl-checkbox__input" checked><span class="mdl-checkbox__label">' + activity_todo_self[j].title + '</span></label>';
                                        }
                                    }
                                }
                            a+='</div>';
                        a+='</div>';
                    }
                    if (activity_self[i].note != '') {
                        var files;
                        var file_name = activity_self[i].note;
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
                        if (files != '' && files != 'null') {
                            a+='<div class="activity_task_notes">'+files+'</div>';
                        }
                    }
                    if (activity_self[i].cat != '' && activity_self[i].cat != 'null') {
                        a+='<div class="activity_task_category"><i class="material-icons">category</i> '+activity_self[i].cat+'</div>';
                    }
                    if (activity_self[i].place != '' && activity_self[i].place != 'null') {
                        a+='<div class="activity_task_location"><i class="material-icons">location_on</i> '+activity_self[i].place+'</div>';
                    }
                    if(activity_person.length > 0){
                        a+= '<div class="activity_task_people">';
                        for (var j = 0; j< activity_person.length; j++) {
                            if(activity_person[j].id == activity_self[i].id && activity_person[j].tag_name != ''){
                                flg++;
                                if(flg == 1){
                                    a+='<i class="material-icons">people</i>';
                                    a+= activity_person[j].tag_name ;
                                }else{
                                    a+= ' , ' + activity_person[j].tag_name ;
                                }
                            }
                        }
                        a+='</div>';
                    }flg = 0;
                    var cust_name = '';
                    a+='<div class="activity_task_date">'+activity_self[i].date+' to '+activity_self[i].e_date+'</div>';
                    for (var j = 0; j < activity_perform.length; j++) {
                       if (activity_self[i].modify == activity_perform[j].cid) {
                            cust_name = activity_perform[j].cname;
                            break;
                        }
                    }
                    a+='<div class="activity_task_actions">';
                        a+='<div class="mdl-grid">';
                            a+='<div class="mdl-cell mdl-cell--12-col">';
                                if (activity_self[i].type != 'subscription' && activity_self[i].type != 'support' ) {
                                    if (activity_self[i].status == 'done') {
                                            a+='<button class="mdl-button mdl-js--button activity_task_active_button activity_action" id="d' + activity_self[i].id + '"><i class="material-icons">done</i> Done by '+cust_name+'</button>';
                                    }else{
                                        a+='<button class="mdl-button mdl-js--button activity_task_inactive_button activity_action" id="d' + activity_self[i].id + '"><i class="material-icons">done</i> Done</button>';
                                    }
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="s' + activity_self[i].id + '"><i class="material-icons">thumb_up</i> Verify by customer</button>';
                                }
                                a+='<button class="mdl-button mdl-js-button activity_task_inactive_button activity_action" id="a' + activity_self[i].id + '"><i class="material-icons">note_add</i> add child activity</button>';
                                if (activity_self[i].status == 'progress') {
                                    a+='<button class="mdl-button mdl-js-button activity_task_active_button activity_action" id="p' + activity_self[i].id + '"><i class="material-icons">arrow_right_alt</i> progress by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button activity_task_inactive_button mdl-js-ripple-effect activity_action" id="p' + activity_self[i].id + '"><i class="material-icons">arrow_right_alt</i> progress</button>';
                                }

                                if (activity_self[i].status == 'reschedule') {
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_active_button activity_action" id="r' + activity_self[i].id + '"><i class="material-icons">calendar_today</i> reschedule by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="r' + activity_self[i].id + '"><i class="material-icons">calendar_today</i> reschedule</button>';
                                }

                                if (activity_self[i].status == 'cancel') {
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_active_button activity_action" id="c' + activity_self[i].id + '"><i class="material-icons">close</i> close by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="c' + activity_self[i].id + '"><i class="material-icons">close</i> close</button>';
                                }
                            a+='</div>';
                        a+='</div>'
                    a+='</div>';
                a+='</div>';
            }
        }else{
            $('.activity_empty').removeAttr('component_hide');
            $('.activity_empty').addClass('component_show');
        }
        $('.self_activity').empty();
        $('.self_activity').append(a);
    }
    
    function load_activity_group(){
        var a = '';flg = 0;
        if (activity_group.length > 0) {
            for (var i = 0; i < activity_group.length; i++) {
                a+='<div class="activity_tasks">';
                    a+='<div class="activity_task_title"><div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col">' + activity_group[i].title + '</div><div class="mdl-cell mdl-cell--2-col" style="margin-top:-10px;"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="e' + activity_group[i].id + '"><i class="material-icons">edit</i></button></div></div></div>';
                    if(activity_group[i].shortcuts != 'null' && activity_group[i].shortcuts != '' && activity_group[i].shortcuts != 0){
                        a+='<div class="activity_task_module_shortcut">';
                        for (var j = 0; j< m_s.length; j++) {
                            if(m_s[j].f_id == activity_group[i].shortcuts){
                                a+='<button class="mdl-button shortcuts" id="'+m_s[j].id+'"><i class="material-icons">'+m_s[j].icon+'</i>'+m_s[j].ms_name+'</button>';
                            }
                        }
                        a+='</div>';
                    }
                    if (activity_group[i].color == 'red') {
                        a+='<div class="activity_task_color" style="background-color:rgba(255, 0, 0, 0.63);"></div>';
                    }else if (activity_group[i].color == 'white') {
                        a+='<div class="activity_task_color" style="background-color:white;"></div>';
                    }else if (activity_group[i].color == 'orange') {
                        a+='<div class="activity_task_color" style="background-color:rgba(255, 165, 0, 0.65);"></div>';
                    }else if (activity_group[i].color == 'blue') {
                        a+='<div class="activity_task_color" style="background-color:rgba(0, 0, 255, 0.64);"></div>';
                    }else if (activity_group[i].color == 'green') {
                        a+='<div class="activity_task_color" style="background-color:rgba(0, 128, 0, 0.74);"></div>';
                    }
                    if (activity_group[i].todo==1) {
                        a+='<div class="activity_task_todo component_show todo_table">';
                            a+='<div class="activity_task_todo_title">Things to-do</div>';
                            a+='<div class="activity_task_todo_items">';
                                for (var j=0; j < activity_todo_group.length; j++) {
                                    if (activity_group[i].id == activity_todo_group[j].a_id) {
                                        if (activity_todo_group[j].status == "false") {
                                            a+='<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1"><input type="checkbox" id="' + activity_todo_group[j].id +'" class="mdl-checkbox__input"><span class="mdl-checkbox__label">' + activity_todo_group[j].title + '</span></label>';
                                        } else {
                                            a+='<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1"><input type="checkbox" id="' + activity_todo_group[j].id +'" class="mdl-checkbox__input" checked><span class="mdl-checkbox__label">' + activity_todo_group[j].title + '</span></label>';
                                        }
                                    }
                                }
                            a+='</div>';
                        a+='</div>';
                    }
                    if (activity_group[i].note != '') {
                        var files;
                        var file_name = activity_group[i].note;
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
                        if (files != '' && files != 'null') {
                            a+='<div class="activity_task_notes">'+files+'</div>';
                        }
                    }
                    if (activity_group[i].cat != '' && activity_group[i].cat != 'null') {
                        a+='<div class="activity_task_category"><i class="material-icons">category</i> '+activity_group[i].cat+'</div>';
                    }
                    if (activity_group[i].place != '' && activity_group[i].place != 'null') {
                        a+='<div class="activity_task_location"><i class="material-icons">location_on</i> '+activity_group[i].place+'</div>';
                    }
                    if(activity_person.length > 0){
                        for (var j = 0; j< activity_person.length; j++) {
                            if(activity_person[j].id == activity_group[i].id && activity_person[j].tag_name != ''){
                                flg++;
                                if(flg == 1){
                                    a+='<div class="activity_task_people"><i class="material-icons">people</i>';
                                    a+= activity_person[j].tag_name ;
                                }else{
                                    a+= ' , ' + activity_person[j].tag_name ;
                                }
                                a+='</div>';
                            }
                        }
                    }flg = 0;
                    a+='<div class="activity_task_date">'+activity_group[i].date+' to '+activity_group[i].e_date+'</div>';
                    var cust_name = '';
                    for (var j = 0; j < activity_perform.length; j++) {
                       if (activity_group[i].modify == activity_perform[j].cid) {
                            cust_name = activity_perform[j].cname;
                            break;
                        }
                    }
                    a+='<div class="activity_task_actions">';
                        a+='<div class="mdl-grid">';
                            a+='<div class="mdl-cell mdl-cell--12-col">';
                                if (activity_group[i].type != 'subscription' && activity_group[i].type != 'support' ) {
                                    if (activity_group[i].status == 'done') {
                                        a+='<button class="mdl-button mdl-js--button activity_task_active_button activity_action" id="d' + activity_group[i].id + '"><i class="material-icons">done</i> Done</button>';
                                    }else{
                                        a+='<button class="mdl-button mdl-js--button activity_task_inactive_button activity_action" id="d' + activity_group[i].id + '"><i class="material-icons">done</i> Done by '+cust_name+'</button>';
                                    }
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="s' + activity_group[i].id + '"><i class="material-icons">thumb_up</i> Verify by customer</button>';
                                }
                                // if (activity_group[i].pid != 0) {
                                //     a+='<button class="mdl-button mdl-js-button activity_task_inactive_button activity_child" id="' + activity_group[i].pid + '"><i class="material-icons">low_priority</i>chile activity</button>';
                                // }
                                // a+='<button class="mdl-button mdl-js-button activity_task_inactive_button activity_action" id="a' + activity_self[i].id + '"><i class="material-icons">note_add</i></button>';
                                if (activity_group[i].status == 'progress') {
                                    a+='<button class="mdl-button mdl-js-button activity_task_active_button activity_action" id="p' + activity_group[i].id + '"><i class="material-icons">arrow_right_alt</i> progress by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button activity_task_inactive_button mdl-js-ripple-effect activity_action" id="p' + activity_group[i].id + '"><i class="material-icons">arrow_right_alt</i> progress</button>';
                                }
                                if (activity_group[i].status == 'reschedule') {
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_active_button activity_action" id="r' + activity_group[i].id + '"><i class="material-icons">calendar_today</i> reschedule by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="r' + activity_group[i].id + '"><i class="material-icons">calendar_today</i> reschedule</button>';
                                }
                                
                                // a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="e' + activity_group[i].id + '"><i class="material-icons">edit</i> edit</button>';

                                if (activity_group[i].status == 'cancel') {
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_active_button activity_action" id="c' + activity_group[i].id + '"><i class="material-icons">close</i> close by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="c' + activity_group[i].id + '"><i class="material-icons">close</i> close</button>';
                                }
                            a+='</div>';
                        a+='</div>'
                    a+='</div>';
                a+='</div>';
            }
        }else{
            $('.activity_empty').removeAttr('component_hide');
            $('.activity_empty').addClass('component_show');
        }
        $('.group_activity').empty();
        $('.group_activity').append(a);
    }

    function load_activity_all(){
        var a = '';flg = 0;
        if (activity_all.length > 0) {
            for (var i = 0; i < activity_all.length; i++) {
                a+='<div class="activity_tasks">';
                    a+='<div class="activity_task_title"><div class="mdl-grid"><div class="mdl-cell mdl-cell--10-col">' + activity_all[i].title + '</div><div class="mdl-cell mdl-cell--2-col" style="margin-top:-10px;"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="e' + activity_all[i].id + '"><i class="material-icons">edit</i></button></div></div></div>';
                    if(activity_all[i].shortcuts != 'null' && activity_all[i].shortcuts != '' && activity_all[i].shortcuts != 0){
                        a+='<div class="activity_task_module_shortcut">';
                        for (var j = 0; j< m_s.length; j++) {
                            if(m_s[j].f_id == activity_all[i].shortcuts){
                                a+='<button class="mdl-button shortcuts" id="'+m_s[j].id+'"><i class="material-icons">'+m_s[j].icon+'</i>'+m_s[j].ms_name+'</button>';
                            }
                        }
                        a+='</div>';
                    }
                    if (activity_all[i].color == 'red') {
                        a+='<div class="activity_task_color" style="background-color:rgba(255, 0, 0, 0.63);"></div>';
                    }else if (activity_all[i].color == 'white') {
                        a+='<div class="activity_task_color" style="background-color:white;"></div>';
                    }else if (activity_all[i].color == 'orange') {
                        a+='<div class="activity_task_color" style="background-color:rgba(255, 165, 0, 0.65);"></div>';
                    }else if (activity_all[i].color == 'blue') {
                        a+='<div class="activity_task_color" style="background-color:rgba(0, 0, 255, 0.64);"></div>';
                    }else if (activity_all[i].color == 'green') {
                        a+='<div class="activity_task_color" style="background-color:rgba(0, 128, 0, 0.74);"></div>';
                    }
                    if (activity_all[i].todo==1) {
                        a+='<div class="activity_task_todo component_show todo_table">';
                            a+='<div class="activity_task_todo_title">Things to-do</div>';
                            a+='<div class="activity_task_todo_items">';
                                for (var j=0; j < activity_todo_all.length; j++) {
                                    if (activity_all[i].id == activity_todo_all[j].a_id) {
                                        if (activity_todo_all[j].status == "false") {
                                            a+='<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1"><input type="checkbox" id="' + activity_todo_all[j].id +'" class="mdl-checkbox__input"><span class="mdl-checkbox__label">' + activity_todo_all[j].title + '</span></label>';
                                        } else {
                                            a+='<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1"><input type="checkbox" id="' + activity_todo_all[j].id +'" class="mdl-checkbox__input" checked><span class="mdl-checkbox__label">' + activity_todo_all[j].title + '</span></label>';
                                        }
                                    }
                                }
                            a+='</div>';
                        a+='</div>';
                    }
                    if (activity_all[i].note != '') {
                        var files;
                        var file_name = activity_all[i].note;
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
                        if (files != '' && files != 'null') {
                            a+='<div class="activity_task_notes">'+files+'</div>';
                        }
                    }
                    if (activity_all[i].cat != '' && activity_all[i].cat != 'null') {
                        a+='<div class="activity_task_category"><i class="material-icons">category</i> '+activity_all[i].cat+'</div>';
                    }
                    if (activity_all[i].place != '' && activity_all[i].place != 'null') {
                        a+='<div class="activity_task_location"><i class="material-icons">location_on</i> '+activity_all[i].place+'</div>';
                    }
                    if(activity_person.length > 0){
                        for (var j = 0; j< activity_person.length; j++) {
                            if(activity_person[j].id == activity_all[i].id && activity_person[j].tag_name != ''){
                                flg++;
                                if(flg == 1){
                                    a+='<div class="activity_task_people"><i class="material-icons">people</i>';
                                    a+= activity_person[j].tag_name ;
                                }else{
                                    a+= ' , ' + activity_person[j].tag_name ;
                                }
                                a+='</div>';
                            }
                        }
                    }flg = 0;
                    var cust_name = '';
                    a+='<div class="activity_task_date">'+activity_all[i].date+' to '+activity_all[i].e_date+'</div>';
                    for (var j = 0; j < activity_perform.length; j++) {
                       if (activity_all[i].modify == activity_perform[j].cid) {
                            cust_name = activity_perform[j].cname;
                            break;
                        }
                    }
                    a+='<div class="activity_task_actions">';
                        a+='<div class="mdl-grid">';
                            a+='<div class="mdl-cell mdl-cell--12-col">';

                                if (activity_all[i].type != 'subscription' && activity_all[i].type != 'support' ) {
                                    if (activity_all[i].status == 'done') {
                                        a+='<button class="mdl-button mdl-js--button activity_task_active_button activity_action" id="d' + activity_all[i].id + '"><i class="material-icons">done</i> Done by '+cust_name+'</button>';
                                    }else{
                                        a+='<button class="mdl-button mdl-js--button activity_task_inactive_button activity_action" id="d' + activity_all[i].id + '"><i class="material-icons">done</i> Done</button>';
                                    }
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="s' + activity_all[i].id + '"><i class="material-icons">thumb_up</i> Verify by customer</button>';
                                }
                                // if (activity_all[i].pid != 0) {
                                //     a+='<button class="mdl-button mdl-js-button activity_task_inactive_button activity_child" id="' + activity_all[i].pid + '"><i class="material-icons">low_priority</i>chile activity</button>';
                                // }
                                // a+='<button class="mdl-button mdl-js-button activity_task_inactive_button activity_action" id="a' + activity_self[i].id + '"><i class="material-icons">note_add</i></button>';
                                if (activity_all[i].status == 'progress') {
                                    a+='<button class="mdl-button mdl-js-button activity_task_active_button activity_action" id="p' + activity_all[i].id + '"><i class="material-icons">arrow_right_alt</i> progress by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button activity_task_inactive_button mdl-js-ripple-effect activity_action" id="p' + activity_all[i].id + '"><i class="material-icons">arrow_right_alt</i> progress</button>';
                                }
                                if (activity_all[i].status == 'reschedule') {
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_active_button activity_action" id="r' + activity_all[i].id + '"><i class="material-icons">calendar_today</i> reschedule by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="r' + activity_all[i].id + '"><i class="material-icons">calendar_today</i> reschedule</button>';
                                }

                                if (activity_all[i].status == 'cancel') {
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_active_button activity_action" id="c' + activity_all[i].id + '"><i class="material-icons">close</i> close by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_task_inactive_button activity_action" id="c' + activity_all[i].id + '"><i class="material-icons">close</i> close</button>';
                                }
                            a+='</div>';
                        a+='</div>'
                    a+='</div>';
                a+='</div>';
            }
        }else{
            $('.activity_empty').removeAttr('component_hide');
            $('.activity_empty').addClass('component_show');
        }
        $('.all_activity').empty();
        $('.all_activity').append(a);
    }

    function display_widgets(){
        var a = '';
        for (var i = 0; i < widgets.length; i++) {
            a+='<div class="mdl-cell mdl-cell--4-col widget_list_modal_cell"> <h3>' + widgets[i].title + '</h3> <p>' + widgets[i].description + '</p> <button class="mdl-button mdl-js--button mdl-button--colored mdl-button--raised widget_list_modal_add_button" id="' + widgets[i].id + '"><i class="material-icons">add</i> Add Widget</button> </div>';
        }
        $('#widget_list_modal_parent').empty();
        $('#widget_list_modal_parent').append(a);
    }

    function update_progress(p) {
        if (p >= 0 && p <=100) {
            $('#activity_progress_digit').html(p.toFixed(1) + '%');
        }else{
            $('#activity_progress_digit').html('0.0%');
        }
        return p;
    }
</script>
</html>