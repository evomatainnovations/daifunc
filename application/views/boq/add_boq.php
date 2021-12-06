<style type="text/css">
    .ui-widget {
        z-index: 30000 !important;
    }
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
</style>
<main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
            <input type="text" id="req_name" class="mdl-textfield__input" value="<?php if(isset($edit_boq)) { echo $edit_boq[0]->iextetboq_title; }?>" style="font-size: 1.6em;outline: none;" placeholder = 'Enter BOQ Title'>
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <button class="mdl-button mdl-button--colored add_info_form"><i class="material-icons">add</i> Information Form</button>
                    <button class="mdl-button mdl-button--colored add_req_list"><i class="material-icons">add</i> Document requirement list</button>
                    <?php
                        if (isset($edit_boq)) {
                            echo '<button class="mdl-button mdl-button--colored share_boq"><i class="material-icons">mail</i> Send Mail</button>';
                            echo '<button class="mdl-button mdl-button--colored get_link"><i class="material-icons">save_alt</i> Get Link</button>';
                            echo '<button class="mdl-button mdl-button--colored delete_boq"><i class="material-icons">delete</i> delete</button>';
                        }
                    ?>
                </div>
                <div class="mdl-cell mdl-cell--12-col copy_link"></div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--6-col ">
                    <button class="mdl-button mdl-button--colored add_col"><i class="material-icons">add</i>Column</button>
                    <button class="mdl-button mdl-button--colored add_row"><i class="material-icons">add</i>Rows</button>
                </div>
                <div class="mdl-cell mdl-cell--4-col" style="display: flex;">
                    <?php 
                        if (isset($edit_boq)) {
                            echo "<label>Compare Column Name</label>";
                            echo '<ul id="compare_tag" style="width:100%;">';
                            if ($edit_boq[0]->iextetboq_col_name != null) {
                                echo '<li>'.$edit_boq[0]->iextetboq_col_name.'</li>';   
                            }
                            echo '</ul>';
                        }
                    ?>
                </div>
                <div class="mdl-cell mdl-cell--12-col display_template" style="overflow: auto;"></div>
            </div>
        </div>
        <button class="lower-button mdl-button mdl-button--colored mdl-button--fab save_boq"><i class="material-icons">done</i></button>
    </div>
</main>
<div class="modal fade" id="boq_add_info" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Information Form</h3>
            </div>
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--10-col">
                        <input type="text" class="mdl-textfield__input" id="from_field" style="outline: none;">
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <button class="mdl-button mdl-button--colored add_info"><i class="material-icons">add</i></button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <table class="general_table"><tbody class="info_details"></tbody></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="boq_add_req_list" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Document requirement list</h3>
            </div>
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--10-col">
                        <input type="text" class="mdl-textfield__input" id="req_field" style="outline: none;">
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <button class="mdl-button mdl-button--colored add_req"><i class="material-icons">add</i></button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <table class="general_table"><tbody class="req_details"></tbody></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="send_boq_mail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Send BOQ Mail</h3>
            </div>
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <input type="text" class="mdl-textfield__input" id="subject" style="outline: none;" placeholder="Enter Subject">
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <input type="text" class="mdl-textfield__input" id="content" style="outline: none;" placeholder="Enter Content">
                    </div>
                    <div class="mdl-cell mdl-cell--5-col">
                        <input type="text" class="mdl-textfield__input" id="cname_field" style="outline: none;" placeholder="Enter Name">
                    </div>
                    <div class="mdl-cell mdl-cell--5-col">
                        <input type="text" class="mdl-textfield__input" id="mail_field" style="outline: none;" placeholder="Enter Email id">
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <button class="mdl-button mdl-button--colored add_mail"><i class="material-icons">add</i></button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <table class="general_table"><tbody class="mail_details"></tbody></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button send_mail" data-dismiss="modal"><i class="material-icons">send</i> Send Mail</button>
                <button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var table_arr = [];
    var contact_arr = [];
    var project_arr = [];
    var oppo_arr = [];
    var customer_data = [];
    var row_p_id = 0;
    var level_id = 1 ;
    var txn_type = 0;
    var req_txn_id = 0;

    var info_flg = 0;
    var info_form_arr = [];

    var req_flg = 0;
    var req_arr = [];
    var email_arr = [];
    <?php
        for($i=0; $i < count($project); $i++) {
            echo "project_arr.push({'id' : '".$project[$i]->iextpp_id."' , 'name' : '".$project[$i]->iextpp_p_name."' });";
        }

        for($i=0; $i < count($oppo); $i++) {
            echo "oppo_arr.push({'id' : '".$oppo[$i]->iextetop_id."' , 'name' : '".$oppo[$i]->iextetop_title."' });";
        }

        for($i=0; $i < count($contact); $i++) {
            echo "contact_arr.push({'id' : '".$contact[$i]->ic_id."' , 'name' : '".$contact[$i]->ic_name."' });";
            if ($contact[$i]->ic_uid != '' && $contact[$i]->ic_uid != null) {
                echo "customer_data.push('".$contact[$i]->ic_name."');";
            }
        }
        $data_arr = [];
        if (isset($table_arr)) {
            for ($i=0; $i <count($table_arr) ; $i++) {
                echo "table_arr.push({'id' : '".$table_arr[$i]->id."' , 'title' : '' , 'level' : '".$table_arr[$i]->level."' , 'full_width' : '".$table_arr[$i]->full_width."' , 'row_data' : [] });";
                for ($ij=0; $ij <count($table_arr[$i]->row_data) ; $ij++) {
                    echo "table_arr[".$i."]['row_data'].push({'data' : '".$table_arr[$i]->row_data[$ij]->data."'});";
                }
                echo "row_p_id++;";
                echo "level_id++;";
            }

            for ($i=0; $i <count($info_arr) ; $i++) {
                echo "info_flg++;";
                echo "info_form_arr.push({'id' : '".$info_arr[$i]->id."' , 'text' : '".$info_arr[$i]->text."', 'status' : '".$info_arr[$i]->status."'});";
            }

            for ($i=0; $i <count($req_arr) ; $i++) {
                echo "req_flg++;";
                echo "req_arr.push({'id' : '".$req_arr[$i]->id."' , 'text' : '".$req_arr[$i]->text."' });";
            }
        }
    ?>
    var col_data = [];
    $(document).ready( function() {
        <?php
            if (isset($table_arr)) {
            }else{
                echo "for (var i = 0; i < 6; i++) {table_arr.push({'id' : row_p_id,'title' : '' , 'level' : level_id , 'full_width' : 'no' , 'row_data' : [] });row_p_id++;level_id++;}for (var i = 0; i < table_arr.length; i++) {for (var ij = 0; ij < 6; ij++) {table_arr[i]['row_data'].push({'data' : '' });}}";
            }
        ?>
        display_table();
        display_info();
        display_req();

        for (var i = 0; i < table_arr.length; i++) {
            if (table_arr[i]['level'] == 1) {
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    col_data.push(table_arr[i]['row_data'][ij]['data']);
                }
            }
        }

        $('#compare_tag').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : col_data,
            singleField : true,
            tagLimit : 1
        });

        $("#cname_field").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(customer_data, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                var value =  ui.item.value;
                get_details(value);
            }    
        });

        function get_details(customer) {
            $.post('<?php echo base_url()."BOQ/cust_details/".$code."/"; ?>',{
                'c' : customer
            }, function(data, status, xhr) {
                var a = JSON.parse(data);
                if (a.details[0]) {
                    $('#mail_field').val(a.details[0].icbd_value);
                }
                $('#mail_field').focus();
            }, "text");
        }

        $('#send_boq_mail').on('keyup','#mail_field',function(e){
            e.preventDefault();
            if (e.keyCode == 13 && $('#mail_field').val() != '') {
                add_mail_arr();
            }
        });

        $('#send_boq_mail').on('click','.add_mail',function(e){
            e.preventDefault();
            add_mail_arr();
        });

        $('.mail_details').on('click','.delete_email',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            email_arr.splice(id,1);
            add_mail_arr();
        });

        $('.mail_details').on('click','.edit_email',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            $('#cname_field').val(email_arr[id].cname);
            $('#cname_field').focus();
            $('#mail_field').val(email_arr[id].email);
            email_arr.splice(id,1);
            add_mail_arr();
        });

        function add_mail_arr(){
            var name = $('#cname_field').val();
            var email = $('#mail_field').val();
            $('#cname_field').val('');
            $('#cname_field').focus();
            $('#mail_field').val('');
            email_arr.push({'cname' : name , 'email' : email});
            var out = '';
            for (var i = 0; i < email_arr.length; i++) {
                var sr_no = 0;
                out += '<tr><th>Sr. No.</th><th>Name</th><th>Email</th><th colspan="2" style="text-align:center;">Action</th></tr>';
                for (var i = 0; i < email_arr.length; i++) {
                    sr_no++;
                    out += '<tr>';
                    out += '<td>'+sr_no+'</td><td>'+email_arr[i].cname+'</td>';
                    out += '<td>'+email_arr[i].email+'</td>';
                    out += '<td><button class="mdl-button mdl-button--colored delete_email" id="'+i+'"><i class="material-icons">delete</i></button></td><td><button class="mdl-button mdl-button--colored edit_email" id="'+i+'"><i class="material-icons">edit</i></button></td>';
                    out += '<tr>';
                }
                $('.mail_details').empty();
                $('.mail_details').append(out);
            }
        }

        $('.send_mail').click(function (e) {
            e.preventDefault();
            $('.loader').show();
            $.post('<?php if (isset($edit_boq)) {echo base_url()."BOQ/send_boq_mail/".$code."/".$boq_id ; } ?>',{
                'email_arr' : email_arr,
                'sub' : $('#subject').val(),
                'content' : $('#content').val()
            }, function(data, status, xhr) {
                $('.loader').hide();
                window.location = '<?php echo base_url().'BOQ/add_boq/'.$code.'/' ?>'+data;
            }, "text");
        });

        $('.add_info_form').click(function(e){
            e.preventDefault();
            $('#boq_add_info').modal('show');
        });

        $('.get_link').click(function(e){
            e.preventDefault();
            $('.copy_link').empty();
            $('.copy_link').append('<input class="mdl-textfield__input" type="text" style="width:100%;outline:none;" value="<?php if (isset($edit_boq)) echo base_url()."BOQ/vendor_submit_boq/".$oid."/".$boq_id."/0"; ?>" >');
        });

        $('#boq_add_info').on('click','.add_info',function(e){
            e.preventDefault();
            add_info_arr();
        });

        $('#boq_add_info').on('keyup','#from_field',function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                add_info_arr();
            }
        });

        function add_info_arr(){
            var text = $('#from_field').val();
            info_flg++;
            info_form_arr.push({'id' : info_flg , 'text' : text, 'status' : 'false'});
            $('#from_field').val('');
            display_info();
        }

        $('.info_details').on('click','.delete_info',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            info_form_arr.splice(id,1);
            display_info();
        });

        $('.info_details').on('click','.edit_info',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            $('#from_field').val(info_form_arr[id].text);
            $('#from_field').focus();
            info_form_arr.splice(id,1);
            display_info();
        });

        $('.info_details').on('click','.info_req',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            var ischecked= $(this).is(':checked');
            if(ischecked == true){
                info_form_arr[id].status = 'true';
            }else{
                info_form_arr[id].status = 'false';
            }
            display_info();
        });

        function display_info(){
            var out = '';
            var sr_no = 0;
            out += '<tr><th>Sr. No.</th><th>Field Name</th><th>Required</th><th colspan="2" style="text-align:center;">Action</th></tr>';
            for (var i = 0; i < info_form_arr.length; i++) {
                sr_no++;
                out += '<tr>';
                out += '<td>'+sr_no+'</td><td>'+info_form_arr[i].text+'</td>';
                if (info_form_arr[i].status == 'false') {
                    out += '<td><input class="info_req" type="checkbox" id="'+i+'"></td>';
                }else{
                    out += '<td><input class="info_req" type="checkbox" id="'+i+'" checked></td>';
                }
                out += '<td><button class="mdl-button mdl-button--colored delete_info" id="'+i+'"><i class="material-icons">delete</i></button></td><td><button class="mdl-button mdl-button--colored edit_info" id="'+i+'"><i class="material-icons">edit</i></button></td>';
                out += '<tr>';
            }
            $('.info_details').empty();
            $('.info_details').append(out);
        }

        $('.add_req_list').click(function(e){
            e.preventDefault();
            $('#boq_add_req_list').modal('show');
        });

        $('#boq_add_req_list').on('click','.add_req',function(e){
            e.preventDefault();
            add_req_arr();
        });

        $('#boq_add_req_list').on('keyup','#req_field',function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                add_req_arr();
            }
        });

        function add_req_arr(){
            var text = $('#req_field').val();
            req_flg++;
            req_arr.push({'id' : req_flg , 'text' : text});
            $('#req_field').val('');
            display_req();
        }

        $('.req_details').on('click','.delete_req',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            req_arr.splice(id,1);
            display_req();
        });

        $('.req_details').on('click','.edit_req',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            $('#req_field').val(req_arr[id].text);
            $('#req_field').focus();
            req_arr.splice(id,1);
            display_req();
        });

        function display_req(){
            var out = '';
            var sr_no = 0;
            for (var i = 0; i < req_arr.length; i++) {
                sr_no++;
                out += '<tr>';
                out += '<td>'+sr_no+'</td><td>'+req_arr[i].text+'</td><td><button class="mdl-button mdl-button--colored delete_req" id="'+i+'"><i class="material-icons">delete</i></button></td><td><button class="mdl-button mdl-button--colored edit_req" id="'+i+'"><i class="material-icons">edit</i></button></td>';
                out += '<tr>';
            }
            $('.req_details').empty();
            $('.req_details').append(out);
        }

        $('.add_col').click(function(e){
            e.preventDefault();
            for (var i = 0; i < table_arr.length; i++) {
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    var txt = $('.td'+i+ij).val();
                    table_arr[i]['row_data'][ij]['data'] = txt;
                }
            }

            for (var i = 0; i < table_arr.length; i++) {
                table_arr[i]['row_data'].push({'data' : '' });
            }
            display_table();
        });

        $('.add_row').click(function(e){
            e.preventDefault();
            for (var i = 0; i < table_arr.length; i++) {
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    var txt = $('.td'+i+ij).val();
                    table_arr[i]['row_data'][ij]['data'] = txt;
                }
            }

            table_arr.push({'id' : row_p_id,'title' : '' , 'level' : level_id , 'full_width' : 'no' , 'row_data' : [] });
            row_p_id++;level_id++;
            var t_id = 0;
            if(table_arr.length > 0 ){
                t_id = table_arr[0]['row_data'].length;
            }

            for (var i = 0; i < table_arr.length; i++) {
                for (var ij = 0; ij < t_id; ij++) {
                    if (table_arr[i]['id'] == row_p_id - 1) {
                        table_arr[i]['row_data'].push({'data' : '' });
                    }
                }
            }
            display_table();
        });

        $('.display_template').on('click','.delete_col',function(e){
            e.preventDefault();
            for (var i = 0; i < table_arr.length; i++) {
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    var txt = $('.td'+i+ij).val();
                    table_arr[i]['row_data'][ij]['data'] = txt;
                }
            }

            var id = $(this).prop('id');
            for (var i = 0; i < table_arr.length; i++) {
                if (table_arr[i]['row_data'][id]) {
                    table_arr[i]['row_data'].splice(id,1);
                }
            }
            display_table();
        });

        $('.display_template').on('click','.delete_row',function(e){
            e.preventDefault();
            for (var i = 0; i < table_arr.length; i++) {
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    var txt = $('.td'+i+ij).val();
                    table_arr[i]['row_data'][ij]['data'] = txt;
                }
            }
            var id = $(this).prop('id');
            table_arr.splice(id,1);
            display_table();
        });
        
        function display_table() {
            var out = '';
            out += '<table class="general_table">';
            for (var i = 0; i < table_arr.length; i++) {
                if (table_arr[i]['level'] == 1) {
                    out+= '<thead>';
                    out += '<tr>';
                    for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                        out += '<th style="border-top:1px solid #fff;border-right:1px solid #fff;border-left:1px solid #fff;border-bottom:1px solid #000;min-width:200px;width:200px;text-align:center;"><button class="mdl-button mdl-button--colored delete_col" id="'+ij+'"><i class="material-icons">delete</i></button></th>';
                    }
                    out += '</tr>';
                    out += '<tr>';
                    for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                        out += '<th style="outline:none;min-width:200px;width:200px;word-break: break-all;background-color:#ccc;border:1px solid #000;" ><input type="text" class="td'+i+ij+'" value="'+table_arr[i]['row_data'][ij]['data']+'" style="border:0px;outline:none;background-color:#ccc;"></th>';
                    }
                    out+= '</tr></thead>';
                }else{
                    out+= '<tr>';
                    for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                        out += '<td style="outline:none;min-width:200px;width:200px;word-break: break-all;border:1px solid #000;" ><input value="'+table_arr[i]['row_data'][ij]['data']+'" class="td'+i+ij+'" style="border:0px;outline:none;"></td>';
                    }
                    out += '<td style="border-top:1px solid #fff;border-right:1px solid #fff;border-bottom:1px solid #fff;min-width:200px;width:200px;text-align:left;"><button class="mdl-button mdl-button--colored delete_row" id="'+i+'"><i class="material-icons">delete</i></button></td>';
                    out+= '</tr>';
                }
            }
            out += '</table>';
            $('.display_add_rows').css('display','block');
            $('.display_template').empty();
            $('.display_template').append(out);
        }

        $('.share_boq').click(function(e){
            e.preventDefault();
            $('#send_boq_mail').modal('show');
        });

        $('.save_boq').click(function (e) {
            e.preventDefault();
            var mutual = [];
            $('#compare_tag > li').each(function(index) {
                var tmpstr1 = $(this).text();
                var len1 = tmpstr1.length - 1;
                if(len1 > 0) {
                    tmpstr1 = tmpstr1.substring(0, len1);
                    mutual.push(tmpstr1);
                }
            });

            for (var i = 0; i < table_arr.length; i++) {
                for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
                    var txt = $('.td'+i+ij).val();
                    if (txt == '') {
                        txt = null;
                    }
                    table_arr[i]['row_data'][ij]['data'] = txt;
                }
            }
            $.post('<?php if (isset($edit_boq)) {echo base_url()."BOQ/update_boq/".$code."/".$boq_id ; }else{ echo base_url()."BOQ/save_boq/".$code."/" ; } ?>',{
                'txn_name' : $('#req_name').val(),
                'table_arr' : table_arr,
                'req_arr' : req_arr,
                'info_arr' : info_form_arr,
                'com_name' : mutual[0]
            }, function(data, status, xhr) {
                window.location = '<?php echo base_url().'BOQ/add_boq/'.$code.'/' ?>'+data;
            }, "text");
        });

        $('.delete_boq').click(function (e) {
            e.preventDefault();
            $.post('<?php if (isset($edit_boq)) {echo base_url()."BOQ/delete_boq/".$code."/".$boq_id ; } ?>'
            , function(data, status, xhr) {
                window.location = '<?php echo base_url().'BOQ/home/null/'.$code.'/' ?>';
            }, "text");
        });

//////////////////////////////////////////// Old BOQ //////////////////////////////////////////////////////////////////////////////////////
        // if (table_arr.length > 0 ) {
        //     $('.create_template').prop('disabled', true);
        //     display_table();
        // }
        // var snackbarContainer = document.querySelector('#demo-toast-example');

        // $('#boq_list_temp').change(function (e) {
        //     e.preventDefault();
        //     var txn_id = $(this).val();
        //     $.post('<?php echo base_url()."BOQ/get_boq_template/".$code."/";?>'+txn_id
        //     , function(data, status, xhr) {
        //         var a = JSON.parse(data);
        //         table_arr = [];
        //         for (var i=0; i < a.length ; i++) {
        //             if (i != 0) {
        //                 row_p_id++;level_id++;
        //             }
        //             table_arr.push({'id' : a[i]['id'] , 'title' : '' , 'level' : a[i]['level'] , 'full_width' : a[i]['full_width'] , 'row_data' : [] });
        //             for (var ij=0; ij < a[i]['row_data'].length ; ij++) { 
        //                 table_arr[i]['row_data'].push({'data' : a[i]['row_data'][ij]['data']});
        //             }
        //         }
        //         display_table();
        //     }, "text");
        // });

        // $('#mutual_tag').tagit({
        //     autocomplete : { delay: 0, minLenght: 5},
        //     allowSpaces : true,
        //     availableTags : customer_data,
        //     singleField : true
        // });

        // $('.create_template').click(function (e) {
        //     e.preventDefault();
        //     $(this).prop('disabled', true);
        //     table_arr.push({'id' : row_p_id,'title' : '' , 'level' : level_id , 'full_width' : 'yes' ,'row_data' : [] });
        //     table_arr[0]['row_data'].push({'data' : '' });
        //     display_table();
        // });

        // $('.delete_boq').click(function (e) {
        //     e.preventDefault();
        //     $.post('<?php if (isset($edit_boq)) {echo base_url()."BOQ/delete_boq/".$code."/".$boq_id ; } ?>'
        //     , function(data, status, xhr) {
        //         window.location = '<?php echo base_url().'BOQ/home/null/'.$code.'/' ?>';
        //     }, "text");
        // });

        // $('.display_template').on('click','.add_column',function (e) {
        //     e.preventDefault();
        //     var id = $(this).prop('id');
        //     table_arr[id]['full_width'] = 'no';
        //     table_arr[id]['row_data'].push({'data' : '' });
        //     display_table();
        // });

        // $('.display_template').on('click','.full_column',function (e) {
        //     e.preventDefault();
        //     var id = $(this).prop('id');
        //     table_arr[id]['full_width'] = 'yes';
        //     table_arr[id]['row_data'] = [];
        //     table_arr[id]['row_data'].push({'data' : '' });
        //     display_table();
        // });

        // $('.display_template').on('click','.delete_column',function (e) {
        //     e.preventDefault();
        //     var id = $(this).prop('id');
        //     var index_id = id.search("/");
        //     var l_id = id.substring(0, index_id);
        //     var column_id = id.substring(index_id + 1,id.length);
        //     for (var i = 0; i < table_arr.length; i++) {
        //         if(table_arr[i]['id'] == l_id){
        //             table_arr[i]['row_data'].splice(column_id, 1);
        //         }
        //     }

        //     for (var i = 0; i < table_arr.length; i++) {
        //         if (table_arr[i]['id'] == l_id ){
        //             if(table_arr[i]['row_data'].length > 0 ){
        //             }else{
        //                 table_arr.splice(i, 1);
        //                 row_p_id = row_p_id - 1;
        //                 level_id = level_id - 1;
        //             }
        //         }
        //     }
        //     display_table();
        // });

        // $('.display_template').on('keyup','.col_text',function (e) {
        //     e.preventDefault();
        //     var id = $(this).prop('id');
        //     var val = $(this).val();

        //     var index_id = id.search("/");
        //     var level_id = id.substring(0, index_id);
        //     var column_id = id.substring(index_id + 1,id.length);
        //     for (var i = 0; i < table_arr.length; i++) {
        //         if(table_arr[i]['id'] == level_id){
        //             table_arr[i]['row_data'][column_id]['data'] = val;
        //         }
        //     }
        // });

        // $('.add_row').click(function (e) {
        //     e.preventDefault();
        //     row_p_id++;level_id++;
        //     table_arr.push({'id' : row_p_id,'title' : '' , 'level' : level_id , 'full_width' : 'no' , 'row_data' : [] });

        //     for (var i = 0; i < table_arr.length; i++) {
        //         if (i == 0) {
        //             count_flg = table_arr[i]['row_data'].length;
        //         }else if(table_arr[i]['row_data'].length > count_flg){
        //             count_flg = table_arr[i]['row_data'].length;
        //         }
        //     }
        //     for (var ij = 0; ij < count_flg; ij++) {
        //         table_arr[row_p_id]['row_data'].push({'data' : '' });
        //     }
        //     display_table();
        // });

        // function display_table() {
        //     var out = '';
        //     out += '<table class="general_table">';
        //     out += '<thead>';
        //     var count_flg = 0;
        //     for (var i = 0; i < table_arr.length; i++) {
        //         if (i == 0) {
        //             count_flg = table_arr[i]['row_data'].length;
        //         }else if(table_arr[i]['row_data'].length > count_flg){
        //             count_flg = table_arr[i]['row_data'].length;
        //         }
        //     }

        //     for (var i = 0; i < table_arr.length; i++) {
        //         out+= '<tr>';
        //         for (var ij = 0; ij < table_arr[i]['row_data'].length; ij++) {
        //             if (table_arr[i]['full_width'] == 'yes') {
        //                 out += '<th colspan="'+count_flg+'">';    
        //             }else{
        //                 out += '<th colspan="">';
        //             }
        //             out += '<input type="text" class="mdl-textfield__input col_text" id="'+i+'/'+ij+'" value="'+table_arr[i]['row_data'][ij]['data']+'" style="outline:none;text-align:center;" placeholder="Enter ">';
        //             out += '<button class="mdl-button mdl-button--colored delete_column" id="'+i+'/'+ij+'"><i class="material-icons">delete</i> </button>';
        //             out += '</th>';
        //         }
        //         if (i == 0) {
        //             out += '<th style="width:10%;">N/A</th>';
        //         }else{
        //             out += '<th style="width:10%;"><button class="mdl-button mdl-button--colored add_column" id="'+i+'">add column</button><button class="mdl-button mdl-button--colored full_column" id="'+i+'">full width column</button></th>';
        //         }
        //         out+= '</tr>';
        //     }
        //     out += '</thead>';
        //     out += '</table>';
        //     $('.display_add_rows').css('display','block');
        //     $('.display_template').empty();
        //     $('.display_template').append(out);
        // }

        // $('#boq_type_list').change(function (e) {
        //     e.preventDefault();
        //     var data_type = [];
        //     txn_type = $(this).val();
        //     if (txn_type == 'contact') {
        //         for (var i = 0; i < contact_arr.length; i++) {
        //             data_type.push(contact_arr[i].name);
        //         }
        //     }else if(txn_type == 'project'){
        //         for (var i = 0; i < project_arr.length; i++) {
        //             data_type.push(project_arr[i].name);
        //         }
        //     }else{
        //         for (var i = 0; i < oppo_arr.length; i++) {
        //             data_type.push(oppo_arr[i].name);
        //         }
        //     }

        //     $("#req_name" ).autocomplete({
        //         source: function(request, response) {
        //             var results = $.ui.autocomplete.filter(data_type, request.term);
        //             response(results.slice(0, 10));
        //         },select: function(event, ui) {
        //             var value =  ui.item.value;
        //             get_txn_id(value);
        //         }
        //     });
        // });

        // function get_txn_id(name){
        //     if (txn_type == 'contact') {
        //         for (var i = 0; i < contact_arr.length; i++) {
        //             if (contact_arr[i].name == name) {
        //                 req_txn_id = contact_arr[i].id;
        //             }
        //         }
        //     }else if (txn_type == 'project') {
        //         for (var i = 0; i < project_arr.length; i++) {
        //             if (project_arr[i].name == name) {
        //                 req_txn_id = project_arr[i].id;
        //             }
        //         }
        //     }else{
        //         for (var i = 0; i < oppo_arr.length; i++) {
        //             if (oppo_arr[i].name == name) {
        //                 req_txn_id = oppo_arr[i].id;
        //             }
        //         }
        //     }
        // }

        // $('.save_boq').click(function (e) {
        //     e.preventDefault();
        //     var mutual = [];
        //     $('#mutual_tag > li').each(function(index) {
        //         var tmpstr1 = $(this).text();
        //         var len1 = tmpstr1.length - 1;
        //         if(len1 > 0) {
        //             tmpstr1 = tmpstr1.substring(0, len1);
        //             mutual.push(tmpstr1);
        //         }
        //     });
        //     $.post('<?php if (isset($edit_boq)) {echo base_url()."BOQ/update_boq/".$code."/".$boq_id ; }else{ echo base_url()."BOQ/save_boq/".$code."/" ; } ?>',{
        //         'txn_type' : txn_type,
        //         'boq_txn_id' : req_txn_id,
        //         'txn_name' : $('#req_name').val(),
        //         'mutual' : mutual,
        //         'table_arr' : table_arr
        //     }, function(data, status, xhr) {
        //         window.location = '<?php echo base_url().'BOQ/add_boq/'.$code.'/' ?>'+data;
        //     }, "text");
        // });
    });
</script>