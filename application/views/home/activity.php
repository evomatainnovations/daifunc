<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
    html, body {
        font-family: 'Open Sans', sans-serif;
        width: 100%;
    }

    #calendar {
        width: inherit;
    }
    .panel-group{
        overflow-x: auto;
    }
    .mdl-tabs__panel {
        max-height: 40vh;
        overflow-y: auto;
    }
    .ui-datepicker,
    .ui-datepicker table,
    .ui-datepicker tr,
    .ui-datepicker td,
    .ui-datepicker th {
        margin: 0;
        padding: 0;
        border: none;
        border-spacing: 0;
    }
    .ui-widget {
        width: inherit;
        z-index: 30000;
    }
    .ui-datepicker-calendar {
        width: 100%;
        text-align: center;
    }

    .ui-datepicker-calendar > tbody > tr > td {
        padding: 4%;
    }

    .ui-datepicker-calendar > thead > tr > th {
        padding: 15px;
    }

    @media only screen and (max-width:700px) {
        .ui-datepicker-prev {
            left: 5px;
            padding-left: 0;
        }
         
        .ui-datepicker-next {
            right: 0px;
            padding-right: 30px;
        }
    }

    @media only screen and (max-width:400px) {
        .ui-datepicker-calendar > tbody > tr > td {
            padding: 2%;
        }

        .ui-datepicker-calendar > thead > tr > th {
            padding: 10px;
        }
    }

    @media only (min-width:400px) and (max-width:900px) {
        .ui-datepicker-calendar > tbody > tr > td {
            padding: 4%;
        }

        .ui-datepicker-calendar > thead > tr > th {
            padding: 15px;
        }
    }

    .ui-state-default {
        text-decoration: none;
    }

    .ui-datepicker-header {
        position: relative;
        padding-bottom: 10px;
        border-bottom: 1px solid #d6d6d6;
    }
     
    .ui-datepicker-title { text-align: center; }
     
    .ui-datepicker-month {
        position: relative;
        padding-right: 15px;
        color: #565656;
    }
     
    .ui-datepicker-year {
        padding-left: 8px;
        color: #a8a8a8;
    }

    .ui-widget-content, .ui-state-default {
        border: 0px !important;
        background-color: initial !important;
    }

    .ui-icon {
        height: 1em;
        width: 1em;

    }
    .ui-datepicker .ui-datepicker-prev .ui-icon, .ui-datepicker .ui-datepicker-next .ui-icon {
        overflow: hidden;
    }

    .ui-state-active {
        color: #fff !important;
    }
    
    .ui-datepicker-header {
        background-color: initial;
        border: 0px;
    }
    .ui-datepicker-title {
        font-size: 2em;
        font-weight: bold;
        padding-top: 20px;
    }

    .ui-datepicker-prev {
        left: 40px;
        padding-left: 0;
    }
    
    .ui-datepicker-prev > span {
        background-image: url('<?php echo base_url().'assets/css/images/ui-icons_444444_256x240.png'; ?>') !important;
        background-size: contain !important;
        background-position: center !important;
        background-repeat: no-repeat;
    }

    .ui-datepicker-next > span {
        background-image: url('<?php echo base_url().'assets/css/images/ui-icons_555555_256x240.png'; ?>') !important;
        background-size: contain !important;
        background-position: center !important;
        background-repeat: no-repeat;
    }


    .ui-datepicker-next {
        right: 60px;
        padding-right: 30px;
    }

    .ui-datepicker-prev,
    .ui-datepicker-next {
        position: absolute;
        top: 25px;
        padding: 15px;
        color: #000;
        cursor: pointer;
        content: "Move";

    }
    
    .ui-datepicker-prev span,
    .ui-datepicker-next span{
        display: block;
        color: #000;
    }

    a {
        color: #000;
    }

    .ui-datepicker-other-month {
        color: #ccc;
    }
    .css-class-to-highlight {
       background-color: #ff4536;
       border-radius: 10px;
       color: #fff;
   }

   .css-class-to-highlight > a {
       color: #fff;
       font-weight: bold;
       font-size: 1em;

   }

   .css-class-to-highlight-events {
       background-color: #ddd;
       border-radius: 10px;
   }

   .css-class-to-highlight-events > a {
       color: #000;
       font-weight: bold;
       font-size: 1em;
   }

    .mdl-card {
        text-align: left;
    }
    .activity_table {
        width: 100%;
        text-align: left;
        border: 0px solid #ccc;
        border-collapse: collapse;
        background-color: #fff;
        font-size: 1.3em;
    }

    .activity_table > thead > tr > {
        box-shadow: 0px 5px 5px #ccc;
    }

    .activity_table > thead > tr > th {
        padding: 10px;
    }

    .activity_table > tbody > tr > {
        border-bottom: 1px solid #ccc;
    }

    .activity_table > tbody > tr > td {
        padding: 15px;
    }

    .activity_align_right {
        text-align: right;
        width: 20%;
    }
    .accordion {
        background-color: #fff;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: right;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }
    .active, .accordion:hover {
        background-color: #ccc;
        border-radius: 10px;
    }

   .panel_filter {
        padding: 0 18px;
        background-color: white;
        display: none;
        overflow: hidden;
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

    #toggle_todo {
        z-index: 999999999999999 !important;
    }
    #m_filter{
        display: none;
    }
    @media screen and (max-width: 600px) {
      #mobile_view {
        clear: both;
        float: left;
        width: 28%;
        display: none;
      }
      #m_filter{
        display: inline;   
      }
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
</style>
<body>
<main class="mdl-layout__content">
    <div class="mdl-grid" style="text-align: right;width: 100%;">
        <input type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="m_filter" name="" value="<?php echo date('d-m-Y'); ?>">
    </div>
    <div class="mdl-grid" style="text-align: left;width: 100%;">
        <div class="mdl-cell mdl-cell--4-col">
            <div class="mdl-grid" style="width: 100%" id="mobile_view">
                <div class="mdl-cell mdl-cell--12-col">
                    <div id="calendar"></div>
                </div>
                <div class="mdl-cell mdl-cell--12-col">
                    <button class="accordion" style="text-align: left" id="filter"><i class="material-icons">filter_list</i>Filter</button>
                    <div class="panel panel_filter" id="filter_list">
                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" data-type="Date" id="f_date">
                                    <label class="mdl-textfield__label" for="f_date">From Date</label>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" data-type="Date" id="t_date">
                                    <label class="mdl-textfield__label" for="t_date">To Date</label>
                                </div>   
                            </div>
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
                                    <input class="mdl-textfield__input" type="text" id="f_title">
                                    <label class="mdl-textfield__label" for="f_title">Title</label>
                                </div>
                            </div>
                            <!-- <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="f_todo">
                                    <label class="mdl-textfield__label" for="f_todo">To Do</label>
                                </div>
                            </div> -->
                             <div class="mdl-cell mdl-cell--12-col" style="padding-top: 10px">
                                <div class="mdl-textfield mdl-js-textfield">
                                    <select class="mdl-textfield__input" id="f_place_loc">
                                        <option value="null">Place</option>
                                        <?php for($i=0; $i < count($place); $i++) {
                                            echo '<option value="'.$place[$i]->iua_place.'">'.$place[$i]->iua_place.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--12-col" style="padding-top: 10px">
                                <div class="mdl-textfield mdl-js-textfield">
                                    <select class="mdl-textfield__input" id="f_cat">
                                        <option value="null">Categories</option>
                                        <?php for($i=0; $i < count($cat); $i++) {
                                            echo '<option value="'.$cat[$i]->iua_categorise.'">'.$cat[$i]->iua_categorise.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--12-col" style="padding-top: 10px">
                                <div class="mdl-textfield mdl-js-textfield">
                                    <select class="mdl-textfield__input" id="f_status">
                                        <option value="null">Status</option>
                                        <?php for($i=0; $i < count($status); $i++) {
                                            echo '<option value="'.$status[$i]->iua_status.'">'.$status[$i]->iua_status.'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <ul id="personTags" class="mdl-textfield__input" style="border: 1px solid #ccc !important;"></ul>
                                </div>
                            </div> -->
                        </div>
                        <div class="mdl-grid">
                            <div class="mdl-cell--4-col"></div>
                            <div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
                                <button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="filters"><i class="material-icons">search</i> Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="mdl-cell mdl-cell--8-col">
            <div class="mdl-grid" style="width: 100%">
                <div class="mdl-cell mdl-cell--12-col" style="text-align: right;">
                    <button class="mdl-button mdl-button--colored" id="act_list"><i class="material-icons">list</i> List</button>
                    <button class="mdl-button" id="act_cat"><i class="material-icons">sort</i> Category</button>
                </div>
                <div style="width: 100%;"  id="activity_edit"></div>
            </div>
        </div>
        <button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent"  id="add"><i class="material-icons">add</i></button>
	</div>
</main>
<div class="modal fade" id="exampleModalLong" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLongTitle">Series of Events</h1>
                <button type="button" class="mdl-button close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="activity_parent"></div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-js-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="activity_remind_Modal" role="dialog">
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
                    <input class="mdl-textfield__input" type="text" id="sub_code">
                    <label class="mdl-textfield__label" for="sub_code">Enter verify code</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="text" id="sub_cmt">
                    <label class="mdl-textfield__label" for="sub_cmt">Enter comments</label>
                </div>
                <div class="mdl-cell mdl-cell--12-col">
                    <p>give rating's</p>
                    <button class="mdl-button mdl-button--icon star_rat" id="1"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="2"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="3"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="4"><i class="material-icons">star</i></button>
                    <button class="mdl-button mdl-button--icon star_rat" id="5"><i class="material-icons">star</i></button>
                </div>
                <div class="mdl-cell mdl-cell--12-col">
                    <h5 id="code_not_verify"></h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal" id="code_verify">verify</button>
            </div>
        </div>
    </div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
    var todo_array = [];
    var to_do = "";
    var status = "";
    var user_array = [];
    var tag_data = [];
    var activity_tags = [];
    var re_id = "";
    var stat = '';
    var act_type ='';
    var today = new Date();
    var currdate=today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var current_dates=[currdate];
    var your_dates=[]; //'2018-9-13', '2018-9-20'
    var date_data ='';
    var list_type='list';
    var activity_cat_arr=[];
    var a_person_arr = [];
    var activity_arr = []; activity_todo_arr =[]; activity_perform = []; m_s = [];activity_person = [];
    var star_rat;
    <?php
        for ($i=0; $i < count($activity); $i++) {
            echo "activity_arr.push({'id' : ".$activity[$i]->iua_id.",'type' : '".$activity[$i]->iua_type."', 'title' : '".$activity[$i]->iua_title."', 'place': '".$activity[$i]->iua_place."', 'todo' : ".$activity[$i]->iua_to_do.", 'note' : '".$activity[$i]->iua_note."', 'date' : '".$activity[$i]->iua_date."','cat' : '".$activity[$i]->iua_categorise."', 'pid' : '".$activity[$i]->iua_p_activity."','status' : '".$activity[$i]->iua_status."', 'modify' : '".$activity[$i]->iua_modified_by."', 'shortcuts' : '".$activity[$i]->iua_shortcuts."','m_shortcuts' : '".$activity[$i]->iua_m_shortcuts."','created' : '".date("H.m ", strtotime($activity[$i]->iua_created))."','type' : '".$activity[$i]->iua_type."','e_date' : '".$activity[$i]->iua_end_date."' });";
        }
        for ($i=0; $i <count($activity_date) ; $i++) { 
            echo "your_dates.push('".date('Y-n-j', strtotime($activity_date[$i]->iua_date))."');";
        }
        for ($i=0; $i < count($activity_todo); $i++) { 
            echo "activity_todo_arr.push({'id' : ".$activity_todo[$i]->iuat_id.", 'a_id' : ".$activity_todo[$i]->iuat_a_id.", 'title' : '".$activity_todo[$i]->iuat_title."', 'status' : '".$activity_todo[$i]->iuat_status."'});\n\r";
        }

        if (isset($edit_todo)) {
            for ($i=0; $i < count($edit_todo); $i++) { 
                if ($edit_todo[$i]->iuat_status == "true") {
                    echo "todo_array.push({'title' : '".$edit_todo[$i]->iuat_title."', 'status' : 'true'});";
                }else{
                    echo "todo_array.push({'title' : '".$edit_todo[$i]->iuat_title."', 'status' : 'false'});";
                }    
            }
        }
        if (isset($activity_perform)) {
            for ($i=0; $i <count($activity_perform) ; $i++) {
                echo "activity_perform.push({'cid' : ".$activity_perform[$i]->ic_uid.",'cname' : '".$activity_perform[$i]->ic_name."'});";
            }
        }

        for ($i=0; $i <count($m_shortcuts) ; $i++) {
            echo "m_s.push({'id' : '".$m_shortcuts[$i]->ims_id."','f_id': '".$m_shortcuts[$i]->ims_function."','f_name' : '".$m_shortcuts[$i]->ifun_name."','domain': '".$m_shortcuts[$i]->idom_name."','mid' : '".$m_shortcuts[$i]->ims_m_id."','icon' : '".$m_shortcuts[$i]->ims_icon."'});";
        }

        for ($i=0; $i <count($activity_person) ; $i++) {
            echo "activity_person.push({'id' : '".$activity_person[$i]->iuap_a_id."','tag_name' : '".$activity_person[$i]->ic_name."'});";
        }

        for ($i=0; $i <count($a_person) ; $i++) { 
            echo "a_person_arr.push('".$activity_person[$i]->ic_name."');";
        }

        for ($i=0; $i <count($activity_cat) ; $i++) { 
            echo "activity_cat_arr.push({'cat' : '".$activity_cat[$i]->iua_categorise."'});";
        }
    ?>

    $('a > span').removeClass('ui-icon ui-icon-circle-triangle-w');
    $(document).ready(function() {
        var a_flg = 'false';
        var snackbarContainer = document.querySelector('#demo-toast-example');

        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });


        $('#personTags').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : a_person_arr
        });

        $('#act_list').click(function (e) {
            e.preventDefault();
            $('#act_cat').removeClass('mdl-button--colored');
            $(this).addClass('mdl-button--colored');
            $('#activity_edit').addClass('mdl-shadow--4dp');
            $('#activity_edit').removeClass('mdl-cell');
            $('#activity_edit').removeClass('mdl-cell--12-col');

            var dt = date_data;
            if (dt == '') {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                dt = yyyy + '-' + mm + '-' + dd;
            }
            list_type = 'list';
            date_pick(dt,list_type);
        });

        $('#act_cat').click(function (e) {
            e.preventDefault();
            $('#act_list').removeClass('mdl-button--colored');
            $(this).addClass('mdl-button--colored');

            var dt = date_data;
            if (dt == '') {
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                dt = yyyy + '-' + mm + '-' + dd;
            }
            list_type = 'cat';
            date_pick(dt,list_type);
        });

        function date_pick(dt,list_type){
            $.post('<?php echo base_url()."Home/calendar_filter/".$code; ?>', {
                'calander_date' : dt
            }, function(data, s,x) {
                var d = JSON.parse(data);
                activity_arr = []; activity_todo_arr =[];activity_cat_arr=[];
                if ($('#m_filter').css('display') != 'none') {
                    $('#mobile_view').css('display','none');
                    $('#m_filter').val(d.date_c);
                }

                for (var i=0; i < d.activity_d.length; i++) {
                    activity_arr.push({'id' : d.activity_d[i].iua_id,'type' : d.activity_d[i].iua_type , 'title' : d.activity_d[i].iua_title, 'place': d.activity_d[i].iua_place, 'todo' : d.activity_d[i].iua_to_do, 'note' : d.activity_d[i].iua_note, 'date' : d.activity_d[i].iua_date,'cat' : d.activity_d[i].iua_categorise, 'pid' : d.activity_d[i].iua_p_activity,'status' : d.activity_d[i].iua_status, 'modify' : d.activity_d[i].iua_modified_by, 'shortcuts' : d.activity_d[i].iua_shortcuts,'m_shortcuts' : d.activity_d[i].iua_m_shortcuts,'created' : d.activity_d[i].iua_created,'type' : d.activity_d[i].iua_type, 'e_date' : d.activity_d[i].iua_end_date});
                }
                for (var i=0; i < d.todo_d.length; i++) { 
                    activity_todo_arr.push({'id' : d.todo_d[i].iuat_id, 'a_id' : d.todo_d[i].iuat_a_id, 'title' : d.todo_d[i].iuat_title, 'status' : d.todo_d[i].iuat_status});
                }
                for (var i = 0; i < d.activity_cat.length; i++) {
                    activity_cat_arr.push({'cat' : d.activity_cat[i].iua_categorise});
                }
                load_activity_table(list_type);
            }, "text");
        }

        $('#calendar').datepicker({
            inline: true,
            firstDay: 1,
            showOtherMonths: true,
            dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            beforeShowDay: function(date) {
                var m = date.getMonth()+1, d = date.getDate(), y = date.getFullYear();
                var nm = y+'-'+m+'-'+d;
                
                for (i = 0; i < current_dates.length; i++) {
                    if($.inArray(nm,current_dates) != -1) {
                        return [true, 'css-class-to-highlight', 'great11'];
                    }
                }

                for (i = 0; i < your_dates.length; i++) {
                    if($.inArray(nm,your_dates) != -1) {
                        return [true, 'css-class-to-highlight-events', 'great11'];
                    }
                }
                return [true];
            },onSelect: function(){
                date = $(this).datepicker('getDate');

                var m = date.getMonth()+1, d = date.getDate(), y = date.getFullYear(); 
                current_dates[0] = y+'-'+m+'-'+d;
                date_data = current_dates[0];
                <?php echo 'date_pick(date_data,list_type);';?>
                $('#calendar').datepicker("refresh");
            }
        });
    
        $('#m_filter').click(function(e){
            e.preventDefault();
            if ($('#mobile_view').css('display') == 'block') {
                $('#mobile_view').css('display','none');
            }else{
                $('#mobile_view').css('display','block');
            }
            
        });

        $('#add').click(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."View/activity_modal/".$code."/Event/"; ?>'
            , function(data, status, xhr) {
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
        });

        $('.close_modal').click(function(e){
            e.preventDefault();
            <?php
                if (isset($edit_activity)) {
                    echo "path = '".base_url()."Home/index/".$code."';";
                }else{
                    echo "path = '".base_url()."Home/activity/".$code."';";
                }
            ?>
            window.location = path;
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

        load_activity_table(list_type);

        $('#filter_button').popover({
            html : true,
            content: function() {
              return $('#filter_list').html();
            }
        }); 

        var acc = document.getElementsByClassName("accordion");
        var i;

         $('.accordion').click(function(e) {
            e.preventDefault();
            if ($('.panel_filter').css('display') == "none") {
                $('.panel_filter').css('display','block');
            } else {
                $('.panel_filter').css('display','none');
            }
        });

        $( "#f_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});
        $( "#t_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : false, format: 'YYYY-MM-DD'});

        $('#filters').click(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Home/activity_filters/".$code; ?>', {
                'f_title' : $('#f_title').val(),
                'f_date' : $('#f_date').val(),
                'f_place' : $('#f_place_loc').val(),
                'f_todo' : $('#f_todo').val(),
                'f_cat' : $('#f_cat').val(),
                'f_status' : $('#f_status').val(),
                't_date' : $('#t_date').val(),
                'f_person' : $('#f_person').val()
            }, function(data, status, xhr) {
                activity_arr = []; activity_todo_arr =[];
                var d=JSON.parse(data);
                for (var i=0; i < d.activity_f.length; i++) { 
                    activity_arr.push({'id' : d.activity_f[i].iua_id,'type' : d.activity_f[i].iua_type ,'title' : d.activity_f[i].iua_title, 'place': d.activity_f[i].iua_place, 'todo' : d.activity_f[i].iua_to_do, 'note' : d.activity_f[i].iua_note, 'date' : d.activity_f[i].iua_date,'cat' : d.activity_f[i].iua_categorise, 'pid' : d.activity_f[i].iua_p_activity,'status' : d.activity_f[i].iua_status, 'modify' : d.activity_f[i].iua_modified_by, 'shortcuts' : d.activity_f[i].iua_shortcuts,'m_shortcuts' : d.activity_f[i].iua_m_shortcuts, 'e_date' : d.activity_f[i].iua_end_date});
                }
                load_activity_table('list');
            });
        });

        $('#activity_edit').on('click', '.activity_action', function(e) {
            e.preventDefault();
            var a=$(this).prop('id');
            var b=a.substring(0,1);
            var c=a.substring(1, a.length);
            var flg = 0;
            
            for (var i = 0; i < activity_arr.length; i++) {
                if (activity_arr[i].id == c) {
                    flg = 1;
                    act_type = activity_arr[i].type;
                    break;
                }
            }
            if(b == "a"){
                $.post('<?php echo base_url()."View/activity_modal/".$code."/Event/"; ?>'+c
                , function(data, status, xhr) {
                    $('#activity_modal > div > div').empty();
                    $('#activity_modal > div > div').append(data);
                }, 'text');
                $('#activity_modal').modal('toggle');
            }else if(b == 'e') {
                edit_activity(c);
            }else if (b == "r") {
                $('#activity_remind_Modal').modal('show');
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
            }else if (b == 'l') {
                add_to_active(c);
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

        function edit_activity(aid) {
            $.post('<?php echo base_url()."View/activity_edit/".$code."/"; ?>'+aid
            , function(data, status, xhr) {
                console.log(data);
                $('#activity_modal > div > div').empty();
                $('#activity_modal > div > div').append(data);
            }, 'text');
            $('#activity_modal').modal('toggle');
        };

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

        function send_mail(aid) {
            $('.loader').css('display','block');
            $.post('<?php echo base_url()."Home/subscription_mail_send/".$code."/"; ?>'+aid,
            function(d, s,x) {
                $('.loader').css('display','none');
                if (d == 'true') {
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
                url = '<?php echo base_url()."Home/support_mail_send/".$code."/"; ?>';
            }else{
                url = '<?php echo base_url()."Home/subscription_mail_send/".$code."/"; ?>'; 
            }
            $.post(url+aid,
            function(d, s,x) {
                $('.loader').css('display','none');
                if (d == 'true') {
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
                url = '<?php echo base_url()."Home/support_code_verify/".$code."/"; ?>';
            }else{
                url = '<?php echo base_url()."Home/subscription_code_verify/".$code."/"; ?>'; 
            }
            $.post(url+re_id,{
                'sub_code' : sub_code,
                'cmt' : $('#sub_cmt').val(),
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

        $('#activity_remind_Modal').on('click', '#r', function(e) {
            $.post('<?php echo base_url()."Home/activity_resheduled/".$code; ?>', {
                'id' : re_id, 'r_date' : $('#r_date').val(), 'cmt' : $('#act_cmt').val()
            }, function(d, s,x) {
                window.location = "<?php echo base_url().'Home/index/'.$code; ?>";
            }, "text");
        });

        $('#activity_parent').on('click', '.activity_action', function(e) {
            e.preventDefault();
            var a=$(this).prop('id');
            var b=a.substring(0,1);
            var c=a.substring(1, a.length);
            var flg = 0;
            for (var i = 0; i < activity_arr.length; i++) {
                if (activity_arr[i].id == c) {
                    flg = 1;
                    act_type = activity_arr[i].type;
                    break;
                }
            }

            if(b == "a"){
                window.location = "<?php echo base_url().'Home/activity/'.$code.'/null/'; ?>"+ c;
            }else if(b == 'e') {
                window.location = "<?php echo base_url().'Home/activity/'.$code.'/'; ?>"+ c;
            }else if (b == "r") {
                $('#activity_remind_Modal').modal('show');
                re_id = c;
            }else {
                update_activity_status(c,b,null);
            }
        });

        function update_activity_status(id, status, cmt) {
            $.post('<?php echo base_url()."Home/activity_status_update/".$code; ?>',{
                'i' : id,
                's' : status,
                'cmt' : cmt
            }, function(d,s,x) {
                window.location = "<?php echo base_url().'Home/activity/'.$code; ?>";
            })
        }

        $( "#r_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time : true, format: 'YYYY-MM-DD HH:mm'});

        $('#activity_remind_Modal').on('click', '#r', function(e) {
            $.post('<?php echo base_url()."Home/activity_resheduled/".$code; ?>', {
                'id' : re_id, 'r_date' : $('#r_date').val(), 'cmt' : $('#act_cmt').val()
            }, function(d, s,x) {
                window.location = "<?php echo base_url().'Home/activity/'.$code; ?>";
            }, "text");
        });

        $('#activity_edit').on('click','.activity_child',function(e) {
            e.preventDefault();
            var d=$(this).prop('id');
            $.post('<?php echo base_url()."Home/activity_get_parent/".$code."/"; ?>'+ d
            , function(data, status, xhr) {
                var a=JSON.parse(data);
                activity_arr = []; activity_todo_arr =[];

                for (var i=0; i < a.activity_s.length; i++) {
                    activity_arr.push({id : a.activity_s[i].iua_id,type : a.activity_s[i].iua_type,title : a.activity_s[i].iua_title,place: a.activity_s[i].iua_place,todo : a.activity_s[i].iua_to_do,note : a.activity_s[i].iua_note,date : a.activity_s[i].iua_date,cat : a.activity_s[i].iua_categorise,status : a.activity_s[i].iua_status,pid : a.activity_s[i].iua_p_activity,e_date : a.activity_s[i].iua_end_date});
                }

                for (var i=0; i < a.todo_s.length; i++) { 
                    activity_todo_arr.push({id : a.todo_s[i].iuat_id, a_id : a.todo_s[i].iuat_a_id, title : a.todo_s[i].iuat_title, status : a.todo_s[i].iuat_status});
                }
                load_activity_parent();
            });
        });

        $('#fixed-header-drawer-exp').change(function(e) {
            e.preventDefault();

            $.post('<?php echo base_url()."Home/activity_search/".$code; ?>', {
                'search' : $(this).val()
            }, function(data, status, xhr) {
                activity_arr = []; activity_todo_arr =[];
                var a=JSON.parse(data);

                for (var i=0; i < a.activity_s.length; i++) { 
                    activity_arr.push({'id' : a.activity_s[i].iua_id,'type' : a.activity_s[i].iua_type ,'title' : a.activity_s[i].iua_title, 'place': a.activity_s[i].iua_place, 'todo' : a.activity_s[i].iua_to_do, 'note' : a.activity_s[i].iua_note, 'date' : a.activity_s[i].iua_date,'cat' : a.activity_s[i].iua_categorise,'status' : a.activity_s[i].iua_status,'pid':a.activity_s[i].iua_p_activity, 'e_date' : d.activity_s[i].iua_end_date });
                }
                
                for (var i=0; i < a.todo_s.length; i++) { 
                    activity_todo_arr.push({'id' : a.todo_s[i].iuat_id, 'a_id' : a.todo_s[i].iuat_a_id, 'title' : a.todo_s[i].iuat_title, 'status' : a.todo_s[i].iuat_status});
                }
                load_activity_table('list');
                
            })
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

        function load_activity_table(list_type) {
            var a="";var flg = 0;
            if (list_type == 'list') {
                if (activity_arr.length > 0) {
                    for (var i = 0; i < activity_arr.length; i++) {
                        if (activity_arr[i].type == 'note'){
                            a+='<div class="mdl-grid mdl-shadow--2dp activity_list" style="font-size:1.5em;border-radius:15px;">';
                            a+='<div class="mdl-cell mdl-cell--10-col">'+activity_arr[i].title+'</div>';
                            a+='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="e' + activity_arr[i].id + '"><i class="material-icons">edit</i> edit</button></div>';
                            if (activity_arr[i].note != '') {
                                var files;
                                var file_name = activity_arr[i].note;
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
                            }
                            a+='<div style="word-break: break-all;padding:10px;font-size:0.7em;">'+files+'</div>';
                            a+='</div>';
                        }else if(activity_arr[i].type == 'module'){
                            a+='<div class="mdl-grid mdl-shadow--2dp" style="font-size:1.5em;border-radius:15px;padding:20px;">';
                            a+='You are created '+activity_arr[i].title;
                                if(activity_person.length > 1 ){
                                    for (var j = 0; j< activity_person.length; j++) {
                                        if(activity_person[j].id == activity_arr[i].id){
                                            flg++;
                                            if(flg == 1){
                                                a+= ' for ' + activity_person[j].tag_name ;
                                                break;
                                            }
                                        }
                                    }
                                }flg = 0;
                            a+='.</div><div style="margin-top:10px;"></div>';
                        }else{
                            a+='<div class="mdl-grid mdl-shadow--8dp activity_list" style="font-size:1em;border-radius:15px;" id="' + activity_arr[i].id + '">';
                            a+='<div class="mdl-cell mdl-cell--10-col"><h1 style="font-size: 2.5rem;">' + activity_arr[i].title + '</h1></div>';
                            a+='<div class="mdl-cell mdl-cell--2-col"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="e' + activity_arr[i].id + '"><i class="material-icons">edit</i> edit</button></div>';    
                            if(activity_arr[i].shortcuts != 'null' && activity_arr[i].shortcuts != '' && activity_arr[i].shortcuts != 0){
                                a+='<div class="mdl-cell mdl-cell--12-col" style="text-align: right">';
                                for (var j = 0; j< m_s.length; j++) {
                                    if(m_s[j].f_id == activity_arr[i].shortcuts){
                                        a+='<button class="mdl-button shortcuts" id="'+m_s[j].id+'"><i class="material-icons">'+m_s[j].icon+'</i>'+m_s[j].f_name+'</button>';
                                    }
                                }
                                a+='</div>';
                            }
                            a+='<div class="mdl-grid" style="text-align:center;width:100%;">'
                            if (activity_arr[i].color == 'red') {
                                 a+='<hr style="background-color:rgba(255, 0, 0, 0.63);width: 100%;margin: 20px;height:2px;">';
                            }else if (activity_arr[i].color == 'white') {
                                 a+='<hr style="background-color:white;width: 80%;margin: 20px;height:2px;">';
                            }else if (activity_arr[i].color == 'orange') {
                                a+='<hr style="background-color:rgba(255, 165, 0, 0.65);width: 100%;margin: 20px;height:2px;">';
                            }else if (activity_arr[i].color == 'blue') {
                                a+='<hr style="background-color:rgba(0, 0, 255, 0.64);width: 100%;margin: 20px;height:2px;">';
                            }else if (activity_arr[i].color == 'green') {
                                a+='<hr style="background-color:rgba(0, 128, 0, 0.74);width: 100%;margin: 20px;height:2px;">';
                            }else{
                                a+='<hr style="background-color:gray;width: 100%;margin: 20px;height:2px;">';
                            }
                            a+='</div>';
                            if (activity_arr[i].todo==1) {
                                a+='<div class= "mdl-cell mdl-cell--12-col"><table class="todo_table">';
                                a+='<h4>Things to-do</h4>';
                                for (var j=0; j < activity_todo_arr.length; j++) {
                                    if (activity_arr[i].id == activity_todo_arr[j].a_id) {
                                        a+='<tr><td>';
                                        if (activity_todo_arr[j].status == "false") {
                                            a+='<input type = "checkbox" id="' + activity_todo_arr[j].id +'" class = "mdl-checkbox__input" > ' + activity_todo_arr[j].title;
                                        } else {
                                            a+='<input type = "checkbox" id="' + activity_todo_arr[j].id +'" class = "mdl-checkbox__input" checked> ' + activity_todo_arr[j].title;
                                        }
                                        a+='</td></tr>';
                                    }
                                }
                                a+='</table></div>';
                            }
                            if (activity_arr[i].note != '' && activity_arr[i].note != null) {
                                var files;
                                var file_name = activity_arr[i].note;
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
                                    a+='<div class="mdl-cell mdl-cell--12-col">'+files+'</div>';
                                }
                            }
                            a+='<div class="mdl-grid" style="width:100%;display:flex;font-weight:bold;">';
                            if (activity_arr[i].cat != '' && activity_arr[i].cat != 'null') {
                                a+='<div class="mdl-cell mdl-cell--4-col"><i class="material-icons">category</i> '+activity_arr[i].cat+'</div>';
                            }
                            if (activity_arr[i].place != '' && activity_arr[i].place != 'null') {
                                a+='<div class="mdl-cell mdl-cell--4-col"><i class="material-icons">location_on</i> '+activity_arr[i].place+'</div>';
                            }
                            if(activity_person.length > 1 ){
                                a+='<div class = "mdl-cell mdl-cell--4-col">';
                                for (var j = 0; j< activity_person.length; j++) {
                                    if(activity_person[j].id == activity_arr[i].id){
                                        flg++;
                                        if(flg == 1){
                                            a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id=""><i class="material-icons">people</i></button>'
                                            a+= activity_person[j].tag_name ;
                                        }else{
                                            a+= ' , ' + activity_person[j].tag_name ;
                                        }
                                    }
                                }
                                a+='</div>';
                            }flg = 0;
                            a+='</div>';

                            var cust_name;
                            a+='<div class= "mdl-cell mdl-cell--4-col" style="text-align: right">';
                                for (var j = 0; j < activity_perform.length; j++) {
                                   if (activity_arr[i].modify == activity_perform[j].cid) {
                                        cust_name = activity_perform[j].cname;
                                        break;
                                    }
                                }
                            a+='</div>';
                            a+='<div class="mdl-cell mdl-cell--12-col activity_task_date">'+activity_arr[i].date+' to '+activity_arr[i].e_date+'</div>';
                            a+='<div class="mdl-cell mdl-cell--12-col" style="text-align:left;">';
                            if (activity_arr[i].type != 'subscription' && activity_arr[i].type != 'support') {
                                if (activity_arr[i].status == 'done') {
                                    a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored activity_action" id="d' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">done</i>  Done by '+cust_name+'</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button activity_action" id="d' + activity_arr[i].id + '" style="text-align:left;width:100%;"><i class="material-icons">done</i> done</button>';
                                }
                            }else{
                                if (activity_arr[i].status == 'done') {
                                    a+='<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised activity_action" id="s' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">thumb_up</i> Verified by customer</button>';
                                }else{
                                    a+='<button class="mdl-button mdl-js-button activity_action" id="s' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">thumb_up</i> Verify by customer</button>';
                                }
                            }

                            a+='<button class="mdl-button mdl-js-button activity_action" id="l' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">add</i> Add to active list</button>';

                            if (activity_arr[i].pid != 0) {
                                a+='<button class="mdl-button mdl-js-button activity_child" id="' + activity_arr[i].pid + '" style="width:100%;text-align:left;"><i class="material-icons">low_priority</i> view parent activity</button>';
                            }
                            a+='<button class="mdl-button mdl-js-button activity_action" id="a' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">note_add</i> add child activity</button>';

                            if (activity_arr[i].status == 'progress') {
                                a+='<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised activity_action" id="p' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">arrow_right_alt</i> progress by '+cust_name+'</button>';
                            }else{
                                a+='<button class="mdl-button mdl-js-button activity_action" id="p' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">arrow_right_alt</i> progress</button>';
                            }
                            if (activity_arr[i].status == 'reschedule') {
                                a+='<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised activity_action" id="r' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">calendar_today</i> Reshedule by '+cust_name+'</button>';
                            }else{
                                a+='<button class="mdl-button mdl-js-button activity_action" id="r' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons" >calendar_today</i> reschedule</button>';
                            }
                            
                            if (activity_arr[i].status == 'cancel') {
                                a+='<button class="mdl-button mdl-js-button  mdl-button--colored mdl-button--raised activity_action activity_action" id="c' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">close</i> close by '+cust_name+'</button>';
                            }else{
                                a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="c' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">close</i> close</button>';
                            }
                            a+='</div>';
                            a+='</div><div style="margin-top:10px;"></div>';
                        }
                    }
                }else{
                    a+='<h3>There is no activity scheduled !!</h3>';
                }
                $('#activity_edit').removeClass('mdl-shadow--4dp');
            }else{
                if (activity_cat_arr.length > 0 ) {
                    for (var k = 0; k < activity_cat_arr.length; k++) {
                        a+='<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#info'+k+'">';
                        if (activity_cat_arr[k].cat == '') {
                            a+='Uncategorise';
                        }else{
                            a+=activity_cat_arr[k].cat;
                        }
                        a+='</a></h4></div>';
                        a+='<div id="info'+k+'" class="panel-collapse collapse"><div class="panel-body">';
                            for (var i = 0; i < activity_arr.length; i++) {
                                if(activity_arr[i].cat == activity_cat_arr[k].cat){
                                    if (activity_arr[i].type == 'note'){
                                        a+='<div class="mdl-grid mdl-shadow--2dp activity_list" style="font-size:1.5em;border-radius:15px;">';
                                        a+='<div class="mdl-cell mdl-cell--10-col">'+activity_arr[i].title+'</div>';
                                        a+='<div class="mdl-cell mdl-cell--2-col" style="text-align:right;"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="e' + activity_arr[i].id + '"><i class="material-icons">edit</i> edit</button></div>';
                                        if (activity_arr[i].note != '') {
                                            var files;
                                            var file_name = activity_arr[i].note;
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
                                        }
                                        a+='<div style="word-break: break-all;padding:10px;font-size:0.7em;">'+files+'</div>';
                                        a+='</div>';
                                    }else if(activity_arr[i].type == 'module'){
                                        a+='<div class="mdl-grid mdl-shadow--2dp" style="font-size:1.5em;border-radius:15px;padding:20px;">';
                                        a+='You are created '+activity_arr[i].title;
                                            if(activity_person.length > 1 ){
                                                for (var j = 0; j< activity_person.length; j++) {
                                                    if(activity_person[j].id == activity_arr[i].id){
                                                        flg++;
                                                        if(flg == 1){
                                                            a+= ' for ' + activity_person[j].tag_name ;
                                                            break;
                                                        }
                                                    }
                                                }
                                            }flg = 0;
                                        a+='.</div><div style="margin-top:10px;"></div>';
                                    }else{
                                        a+='<div class="mdl-grid mdl-shadow--8dp activity_list" style="font-size:1em;border-radius:15px;" id="' + activity_arr[i].id + '">';
                                        a+='<div class="mdl-cell mdl-cell--10-col"><h1 style="font-size: 2.5rem;">' + activity_arr[i].title + '</h1></div>';
                                        a+='<div class="mdl-cell mdl-cell--2-col"><button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="e' + activity_arr[i].id + '"><i class="material-icons">edit</i> edit</button></div>';    
                                        if(activity_arr[i].shortcuts != 'null' && activity_arr[i].shortcuts != '' && activity_arr[i].shortcuts != 0){
                                            a+='<div class="mdl-cell mdl-cell--12-col" style="text-align: right">';
                                            for (var j = 0; j< m_s.length; j++) {
                                                if(m_s[j].f_id == activity_arr[i].shortcuts){
                                                    a+='<button class="mdl-button shortcuts" id="'+m_s[j].id+'"><i class="material-icons">'+m_s[j].icon+'</i>'+m_s[j].f_name+'</button>';
                                                }
                                            }
                                            a+='</div>';
                                        }
                                        a+='<div class="mdl-grid" style="text-align:center;width:100%;">'
                                        if (activity_arr[i].color == 'red') {
                                             a+='<hr style="background-color:rgba(255, 0, 0, 0.63);width: 100%;margin: 20px;height:2px;">';
                                        }else if (activity_arr[i].color == 'white') {
                                             a+='<hr style="background-color:white;width: 80%;margin: 20px;height:2px;">';
                                        }else if (activity_arr[i].color == 'orange') {
                                            a+='<hr style="background-color:rgba(255, 165, 0, 0.65);width: 100%;margin: 20px;height:2px;">';
                                        }else if (activity_arr[i].color == 'blue') {
                                            a+='<hr style="background-color:rgba(0, 0, 255, 0.64);width: 100%;margin: 20px;height:2px;">';
                                        }else if (activity_arr[i].color == 'green') {
                                            a+='<hr style="background-color:rgba(0, 128, 0, 0.74);width: 100%;margin: 20px;height:2px;">';
                                        }else{
                                            a+='<hr style="background-color:gray;width: 100%;margin: 20px;height:2px;">';
                                        }
                                        a+='</div>';
                                        if (activity_arr[i].todo==1) {
                                            a+='<div class= "mdl-cell mdl-cell--12-col"><table class="todo_table">';
                                            a+='<h4>Things to-do</h4>';
                                            for (var j=0; j < activity_todo_arr.length; j++) {
                                                if (activity_arr[i].id == activity_todo_arr[j].a_id) {
                                                    a+='<tr><td>';
                                                    if (activity_todo_arr[j].status == "false") {
                                                        a+='<input type = "checkbox" id="' + activity_todo_arr[j].id +'" class = "mdl-checkbox__input" > ' + activity_todo_arr[j].title;
                                                    } else {
                                                        a+='<input type = "checkbox" id="' + activity_todo_arr[j].id +'" class = "mdl-checkbox__input" checked> ' + activity_todo_arr[j].title;
                                                    }
                                                    a+='</td></tr>';
                                                }
                                            }
                                            a+='</table></div>';
                                        }
                                        if (activity_arr[i].note != '' && activity_arr[i].note != null) {
                                            var files;
                                            var file_name = activity_arr[i].note;
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
                                        if (activity_arr[i].cat != '') {
                                            a+='<div class="mdl-cell mdl-cell--4-col"><i class="material-icons">category</i> '+activity_arr[i].cat+'</div>';
                                        }
                                        if (activity_arr[i].place != '') {
                                            a+='<div class="mdl-cell mdl-cell--4-col"><i class="material-icons">location_on</i> '+activity_arr[i].place+'</div>';
                                        }
                                        if(activity_person.length > 1 ){
                                            a+='<div class = "mdl-cell mdl-cell--4-col">';
                                            for (var j = 0; j< activity_person.length; j++) {
                                                if(activity_person[j].id == activity_arr[i].id){
                                                    flg++;
                                                    if(flg == 1){
                                                        a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id=""><i class="material-icons">people</i></button>'
                                                        a+= activity_person[j].tag_name ;
                                                    }else{
                                                        a+= ' , ' + activity_person[j].tag_name ;
                                                    }
                                                }
                                            }
                                            a+='</div>';
                                        }flg = 0;
                                        a+='</div>';

                                        var cust_name;
                                            for (var j = 0; j < activity_perform.length; j++) {
                                               if (activity_arr[i].modify == activity_perform[j].cid) {
                                                    cust_name = activity_perform[j].cname;
                                                    break;
                                                }
                                            }
                                        a+='<div class="mdl-cell mdl-cell--12-col" style="text-align:left;">';
                                        if (activity_arr[i].type != 'subscription' && activity_arr[i].type != 'support') {
                                            if (activity_arr[i].status == 'done') {
                                                a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored activity_action" id="d' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">done</i>  Done by '+cust_name+'</button>';
                                            }else{
                                                a+='<button class="mdl-button mdl-js-button activity_action" id="d' + activity_arr[i].id + '" style="text-align:left;width:100%;"><i class="material-icons">done</i> done</button>';
                                            }
                                        }else{
                                            if (activity_arr[i].status == 'done') {
                                                a+='<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored activity_action" id="s' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">thumb_up</i> Verify by customer</button>';
                                            }else{
                                                a+='<button class="mdl-button mdl-js-button activity_action" id="s' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">thumb_up</i> Verify by customer</button>';
                                            }
                                        }
                                        a+='<button class="mdl-button mdl-js-button activity_action" id="l' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">add</i> Add to active list</button>';
                                        if (activity_arr[i].pid != 0) {
                                            a+='<button class="mdl-button mdl-js-button activity_child" id="' + activity_arr[i].pid + '" style="width:100%;text-align:left;"><i class="material-icons">low_priority</i> view parent activity</button>';
                                        }
                                        a+='<button class="mdl-button mdl-js-button activity_action" id="a' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">note_add</i> add child activity</button>';

                                        if (activity_arr[i].status == 'progress') {
                                            a+='<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised activity_action" id="p' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">arrow_right_alt</i> progress by '+cust_name+'</button>';
                                        }else{
                                            a+='<button class="mdl-button mdl-js-button activity_action" id="p' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">arrow_right_alt</i> progress</button>';
                                        }
                                        if (activity_arr[i].status == 'reschedule') {
                                            a+='<button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised activity_action" id="r' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">calendar_today</i> Reshedule by '+cust_name+'</button>';
                                        }else{
                                            a+='<button class="mdl-button mdl-js-button activity_action" id="r' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons" >calendar_today</i> reschedule</button>';
                                        }
                                        
                                        if (activity_arr[i].status == 'cancel') {
                                            a+='<button class="mdl-button mdl-js-button  mdl-button--colored mdl-button--raised activity_action activity_action" id="c' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">close</i> close by '+cust_name+'</button>';
                                        }else{
                                            a+='<button class="mdl-button mdl-js-button mdl-js-ripple-effect activity_action" id="c' + activity_arr[i].id + '" style="width:100%;text-align:left;"><i class="material-icons">close</i> close</button>';
                                        }
                                        a+='</div>';
                                        a+='</div><div style="margin-top:10px;"></div>';
                                    }
                                }
                            }
                        a+='</div></div>';
                        a+='</div>';
                    }
                    $('#activity_edit').removeClass('mdl-shadow--4dp');
                }else{
                    $('#activity_edit').addClass('mdl-shadow--4dp');
                    $('#activity_edit').removeClass('mdl-cell mdl-cell--12-col');
                    a+='<h3>There is no activity scheduled !!</h3>';   
                }
            }
            $('#activity_edit').empty();
            $('#activity_edit').append(a);                
        }

        function load_activity_parent() {
            var a="";
            for (var i = 0; i < activity_arr.length; i++) {
                // if (activity_arr[i].status == 'done') {
                //     a+='<div class="mdl-cell mdl-cell--12-col scrolldiv" style="font-size:1.5em; border : 2px solid #ccc; border-radius : 5px; padding: 20px; border-color: green;" id="' + activity_arr[i].id + '">';
                // }else if(activity_arr[i].status == 'reschedule'){
                //     a+='<div class="mdl-cell mdl-cell--12-col scrolldiv" style="font-size:1.5em; border : 2px solid #ccc; border-radius : 5px; padding: 20px; border-color: blue;" id="' + activity_arr[i].id + '">';
                // }else if(activity_arr[i].status == 'progress'){
                //     a+='<div class="mdl-cell mdl-cell--12-col scrolldiv" style="font-size:1.5em; border : 2px solid #ccc; border-radius : 5px; padding: 20px; border-color: red;background-color: rgba(169, 169, 169, 0.19);" id="' + activity_arr[i].id + '">';
                // }else{
                //     a+='<div class="mdl-cell mdl-cell--12-col scrolldiv" style="font-size:1.5em; border : 2px solid #ccc; border-radius : 5px; padding: 20px;" id="' + activity_arr[i].id + '">';
                // }
               
                a+='<div class="mdl-grid"><div class="mdl-cell mdl-cell--4-col"><h1>' + activity_arr[i].title + '</h1>';
                if (activity_arr[i].cat != 'null') {
                    a+='<h4>' + activity_arr[i].cat + '</h4>';
                }
                a+= '</div><div class="mdl-cell mdl-cell--8-col" style="text-align : right">';
                // if (activity_arr[i].pid != 0) {
                //     a+='<button class="mdl-button mdl-js-button activity_child" id="' + activity_arr[i].pid + '"><i class="material-icons">low_priority</i></button>';
                // }
                // a+='<button class="mdl-button mdl-js-button activity_action" id="a' + activity_arr[i].id + '"><i class="material-icons">note_add</i></button><button class="mdl-button mdl-js-button activity_action" id="e' + activity_arr[i].id + '"><i class="material-icons">edit</i></button>';
                a+= '<h4 style="margin-right: 30px;">( ' + activity_arr[i].status + ' )</h4><i></div></div><hr>';
                if (activity_arr[i].place!='' && activity_arr[i].place!=null && activity_arr[i].place!='null') {
                    a+='<div> <i class = "material-icons">location_on</i> ' + activity_arr[i].place + '</div>';
                }
                
                if (activity_arr[i].todo==1) {
                    a+='<table class="todo_table">';
                    for (var j=0; j < activity_todo_arr.length; j++) { 
                        if (activity_arr[i].id == activity_todo_arr[j].a_id) {
                            a+='<tr><td>';
                            if (activity_todo_arr[j].status == "false") {
                                a+='<input type = "checkbox" id="' + activity_todo_arr[j].id +'" class = "mdl-checkbox__input" > ' + activity_todo_arr[j].title;
                            } else {
                                a+='<input type = "checkbox" id="' + activity_todo_arr[j].id +'" class = "mdl-checkbox__input" checked> ' + activity_todo_arr[j].title;
                            }
                            a+='</td></tr>';
                        }
                    }                            
                    a+='</table>';
                }
                if (activity_arr[i].note != ''&& activity_arr[i].note != null) {
                    var files;
                    var file_name = activity_arr[i].note;
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
                }
                if (files != undefined) {
                    a+='<div style="word-break: break-all;padding:10px;font-size:0.7em;">'+files+'</div>';
                }
                if (activity_arr[i].date != 0) {
                    a+='<i style="font-size:0.9em;">' + activity_arr[i].date + '</i>';
                }
                a+='</div>';
            }
            
            $('#exampleModalLong').modal('show');
            $('#activity_parent').empty();
            $('#activity_parent').append(a);                
        }
    });
</script>
</html>