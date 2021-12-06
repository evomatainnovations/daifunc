<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
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
    .jstree-contextmenu {
        z-index: 1 !important;
    }

    .vakata-context, .vakata-context ul {
        background: #e0e0e0 !important;
        box-shadow: 0px 0px 0px #000 !important;
        border: 0px solid #fff !important;
    }
    .vakata-context-separator{
        display: none;
    }
</style>
<main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;text-align: left;">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                        <input class="mdl-textfield__input" type="text" id="dm_title" style="width: 100%;" value="<?php if(isset($dm_list)){echo $dm_list[0]->iextetdm_title;} ?>">
                        <label class="mdl-textfield__label" for="dm_cat">Enter Title</label>
                    </div>
                    <?php
                        if (isset($edit_dm_temp)) {
                            echo '<div style="text-align:center;"><button class="mdl-button--colored mdl-button delete_dm"><i class="material-icons">delete</i> delete</button></div>';
                        }
                    ?>
                </div>
                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"style="height: 30px;width: 100%;" >
                        <select class="mdl-textfield__input" id="dm_type_list" style="height: 30px;width: 100%;">
                            <option value="null">Select design type</option>
                            <?php
                                if (isset($dm_temp_list)) {
                                    for ($i=0; $i < count($dm_temp_list) ; $i++) { 
                                        echo '<option value="'.$dm_temp_list[$i]->iextetdmt_id.'">'.$dm_temp_list[$i]->iextetdmt_title.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>  
                </div>
                <div class="mdl-cell mdl-cell--12-col dm_cat_temp"></div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc;height: 90vh;overflow-y: auto; ">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--6-col add_doc_display dm_detail_name" style="text-align: right;display: none;">

                </div>
                <div class="mdl-cell mdl-cell--3-col send_mail" style="text-align: right;display: none;">
                    <button type="button" class="mdl-button mdl-js-button mdl-button--colored send_mail_btn"><i class="material-icons">send</i>Send mail</button>
                </div>
                <div class="mdl-cell mdl-cell--3-col add_doc_display" style="text-align: right;display: none;">
                    <button type="button" class="mdl-button mdl-js-button mdl-button--colored add_doc_btn"><i class="material-icons">add</i>Add Document</button>
                </div>
                <div class="mdl-cell mdl-cell--12-col design_details"></div>
            </div>

        </div>
    </div>
    <button type="button" class="lower-button mdl-button mdl-button--fab mdl-button--colored save_dm_submit"><i class="material-icons">done</i></button>
</main>
<div class="modal fade" id="upload_doc_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <div class="mdl-cell mdl-cell--12-col" style="display: left;">
                    <h3>Upload Document</h3>
                    <hr>
                </div>
                <div class="mdl-cell mdl-cell--12-col" style="display: center;">
                    <div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
                        <i class="material-icons">note</i>Upload Document
                        <input type="file" name="file[]" id="multiFiles" class="upload dm_doc" multiple>
                    </div>
                    <div id="no_of_files">
                        
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                        <input class="mdl-textfield__input" type="text" id="dm_remark" style="width: 100%;">
                        <label class="mdl-textfield__label" for="dm_remark">Enter Remark</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i>close</button>
                <button type="button" class="mdl-button save_dm" data-dismiss="modal"><i class="material-icons">save</i>save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="send_mail_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3>Send Design</h3><hr>
                <div class="mdl-grid">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" id="send_name" class="mdl-textfield__input">
                        <label class="mdl-textfield__label" for="send_name">Enter Name</label>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col boq_details" style="display: none;">
                        <table style="width: 100%;">
                            <tbody class="boq_details_table" style="text-align: left;font-size : 1em;">
                            </tbody>
                        </table>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label email_add_not_found" style="display: none;">
                        <input type="text" id="send_email" class="mdl-textfield__input">
                        <label class="mdl-textfield__label" for="send_name">Not found email plz enter email</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input type="text" id="send_subject" class="mdl-textfield__input">
                        <label class="mdl-textfield__label" for="send_subject">Enter Subject</label>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <textarea id="send_content" class="mdl-textfield__input" style="outline: none;"></textarea>
                        <label class="mdl-textfield__label" for="send_content">Enter Content</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i>close</button>
                <button type="button" class="mdl-button send_mail_modal_btn" data-dismiss="modal"><i class="material-icons">send</i>send mail</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_remark_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3>Edit Remark</h3><hr>
                <div class="mdl-grid">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <textarea id="edit_remark_content" class="mdl-textfield__input" style="outline: none;"></textarea>
                        <label class="mdl-textfield__label" for="edit_remark_content">Enter Remark</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i>close</button>
                <button type="button" class="mdl-button save_remark" data-dismiss="modal"><i class="material-icons">send</i>save</button>
            </div>
        </div>
    </div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">
var txn_type = '';
var dm_txn_id = '';
var contact_arr = [];
var project_arr = [];
var oppo_arr = [];
var data_type = [];
var cat_type = [];
var dm_cat_arr = [];
var dm_upload_arr = [];
var user_arr = [];

var arrayCollection = [];
var sel_cat_id = 0;
var dm_id = 0;
var id_flg = 0;
var cust_arr = [];
var property_arr = [];
var dm_upload_id = 0;
<?php
    if (isset($edit_dm_temp)) {
        for ($i=0; $i < count($edit_dm_temp) ; $i++) { 
            echo "arrayCollection.push({'id': '".$edit_dm_temp[$i]->id."', 'parent': '".$edit_dm_temp[$i]->parent."', 'text': '".$edit_dm_temp[$i]->text."' });";
        }
    }

    if (isset($dm_id)) {
        echo "dm_id = ".$dm_id.";";
    }

    if (isset($c_list)) {
        for ($i=0; $i < count($c_list) ; $i++) { 
            echo "cust_arr.push('".$c_list[$i]->ic_name."');";
        }
    }
?>
$(document).ready( function() {
    <?php
        if (isset($edit_dm_temp)) {
            echo "add_category_display();";
        }
    ?>
    var snackbarContainer = document.querySelector('#demo-toast-example');

    $("#send_name").autocomplete({
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(cust_arr, request.term);
            response(results.slice(0, 10));
        },select: function(event, ui) {
            var value =  ui.item.value;
            get_details(value);
        }
    });

    function get_details(customer) {
        $.post('<?php echo base_url()."BOQ_fixed/cust_details/".$code."/"; ?>', {
            'c' : customer,
            }, function(data, status, xhr) {
            var a = JSON.parse(data);
            property_arr = [];
            if (a.details.length > 0 ) {
                for (var i = 0; i < a.details.length; i++) {
                    property_arr.push({'id' : i,'value' : a.details[i], 'status' : 'false'});
                }
                $('.email_add_not_found').css('display','none');
                $('.boq_details').css('display','block');
            }else{
                $('.email_add_not_found').css('display','block');
            }
            display_email_list();
        }, "text");
    }

    function display_email_list() {
        var out = '';
        for (var i = 0; i < property_arr.length; i++) {
            if (property_arr[i].status == 'true') {
                out +='<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2"><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input" checked></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
            }else{
                out +='<tr><td><label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-2"><input type="checkbox" id="'+property_arr[i].id+'" class="mdl-checkbox__input"></label></td><td style="padding: 10px;"> '+property_arr[i].value+'</td></tr>';
            }
        }
        $('.boq_details_table').empty();
        $('.boq_details_table').append(out);
    }

    $('.boq_details_table').on('change', 'input[type=checkbox]', function(e) {
        e.preventDefault();
        var a = $(this).prop('id');
        var ischecked= $(this).is(':checked');
        for (var i = 0; i < property_arr.length; i++) {
            if(property_arr[i].id == a){
                if(ischecked == false){
                    property_arr[i].status = 'false';
                }else{
                    property_arr[i].status = 'true';
                }
            }
        }
    });

    $('#send_mail_modal').on('click','.send_mail_modal_btn', function(e) {
        e.preventDefault();
        $('.loader').show();
        $.post('<?php if(isset($edit_dm_temp)) echo base_url()."Design_manager/dm_send_mail/".$code."/"; ?>'+dm_id+'/'+sel_cat_id, {
            'email' : property_arr,
            'subject' : $('#send_subject').val(),
            'content' : $('#send_content').val()
        }, function(data, status, xhr) {
            $('.loader').hide();
            var data = {message: 'Email Send !'};
            snackbarContainer.MaterialSnackbar.showSnackbar(data);
        }, 'text');
    });

    $('#dm_type_list').change(function (e) {
        e.preventDefault();
        var id = $(this).val();
        $.post('<?php echo base_url()."Design_manager/get_dm_template/".$code."/";?>'+id
        ,function(data, status, xhr) {
            var a = JSON.parse(data);
            $('.delete_temp').css('display','block');
            arrayCollection = [];
            $('#title_name').val(a.title);
            for (var i = 0; i < a.dm_temp.length; i++) {
                arrayCollection.push({"id": a.dm_temp[i].id, "parent": a.dm_temp[i].parent, "text": a.dm_temp[i].text});
            }
            add_category_display();
        });
    });

    $('.dm_cat_temp').on('click','.add_dm_cat',function (e){
        e.preventDefault();
        var arr= [];
        if (arrayCollection.length > 0) {
            arrayCollection = [];
            arr = $('#dm_cat_list').jstree(true).get_json('#', {flat:true});
            if (arr.length > 0 ) {
                id_flg = 0;
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i].parent == '#') {
                        id_flg++;
                    }
                    arrayCollection.push({"id": arr[i].id, "parent": arr[i].parent, "text": arr[i].text});
                }
            }
        }
        id_flg++;
        arrayCollection.push({"id": id_flg, "parent": "#", "text": 'Root'});
        add_category_display();
    });

    function add_category_display(){
        var out = '<div class="mdl-cell mdl-cell--12-col" style="text-align: center;"><button class="mdl-button mdl-button--colored add_dm_cat"><i class="material-icons">add</i>Add Category</button></div>';
        out += '<div class="mdl-grid" id="dm_cat_list"></div>';
        $('.dm_cat_temp').empty();
        $('.dm_cat_temp').append(out);
        $("#dm_cat_list").jstree({
            "core": {"check_callback": true,"data": arrayCollection},
            "plugins": ["json_data","contextmenu","themes","html_data", "ui", "crrm"]
        }).on('select_node.jstree',function (e, data) {
            sel_cat_id = data.node.id;
            display_dm_details(data.node.id,data.node.text);
        }).jstree();
    }
    
    function display_dm_details(id,name){
        $.post('<?php echo base_url()."Design_manager/get_dm_details/".$code."/";?>',{
            'id' : id,
            'name' : name,
            'dm_id' : dm_id
        }, function(data, status, xhr) {
            var a = JSON.parse(data);
            dm_upload_arr = [];
            user_arr = [];
            if (a.edit_dmc_upload.length > 0) {
                for (var ij = 0; ij < a.edit_dmc_upload.length; ij++) {
                    for (var i = 0; i < a.edit_dmc_upload[ij].length; i++) {
                        dm_upload_arr.push({id : a.edit_dmc_upload[ij][i].iextetdmcu_id , c_id : a.edit_dmc_upload[ij][i].iextetdmcu_dmc_id , file_name : a.edit_dmc_upload[ij][i].iextetdmcu_file_name , file : a.edit_dmc_upload[ij][i].iextetdmcu_timestamp , final : a.edit_dmc_upload[ij][i].iextetdmcu_final , final_on : a.edit_dmc_upload[ij][i].iextetdmcu_final_on , date : a.edit_dmc_upload[ij][i].iextetdmcu_date , remark : a.edit_dmc_upload[ij][i].iextetdmcu_remark , upload_by : a.edit_dmc_upload[ij][i].iextetdmcu_upload_by ,cat_id : a.edit_dmc_upload[ij][i].iextetdmcu_cat_id});
                    }   
                }

                for (var i = 0; i < a.users.length; i++) {
                    if (a.users[i].ic_uid == 'null' || a.users[i].ic_uid == null || a.users[i].ic_uid == '') {
                        user_arr.push({id : a.users[i].ic_uid , name : a.users[i].icbd_value });
                    }else{
                        user_arr.push({id : a.users[i].ic_uid , name : a.users[i].ic_name });
                    }
                }
                display_design();
            }
            $('.add_doc_display').css('display','block');
            $('.dm_detail_name').empty();
            $('.dm_detail_name').append('<h3>'+name+'</h3>');
        });
    }

    $('.add_doc_btn').click(function (e){
        e.preventDefault();
        $('#upload_doc_modal').modal('show');
    });
        
    $('#upload_doc_modal').on('change','.upload',function (e) {
        e.preventDefault();
        var ins = $('.upload')[0].files.length;
        $('#no_of_files').empty();
        if (ins > 1) {
            $('#no_of_files').append(ins+' files selected');
        }else{
            $('#no_of_files').append(ins+' file selected');
        }
    });

    function display_design(){
        var out = '';
        var sr_no = 0 ;
        var send_mail = 'false';
        out += '<div class="mdl-grid">';
            out += '<table class="general_table"><thead><tr><th>Sr. No</th><th>File name</th><th>Remark</th><th>Final</th><th>Final On</th><th>Date</th><th>Upload By</th><th>Action</th></tr></thead><tbody>';
            if (dm_upload_arr.length > 0 ) {
                for (var i = 0; i < dm_upload_arr.length; i++) {
                    sr_no++;
                    out += '<tr>';
                    out+= '<td>'+sr_no+'</td>';
                    out+= '<td><button class="mdl-button download_doc" id="'+dm_upload_arr[i].id+'">'+dm_upload_arr[i].file_name+'</button></td>';
                    out+= '<td>'+dm_upload_arr[i].remark+'</td>';
                    if (dm_upload_arr[i].final == 'false') {
                        out+= '<td><input type="checkbox" id="'+dm_upload_arr[i].id+'" class="mdl-switch__input"></td>';
                    }else{
                        out+= '<td><input type="checkbox" id="'+dm_upload_arr[i].id+'" class="mdl-switch__input" checked></td>';
                        send_mail = 'true';

                    }
                    if (dm_upload_arr[i].final_on == null) {
                        out+= '<td>N/A</td>';
                    }else{
                        out+= '<td>'+dm_upload_arr[i].final_on+'</td>';
                    }
                    out+= '<td>'+dm_upload_arr[i].date+'</td>';
                    for (var ik = 0; ik < user_arr.length; ik++) {
                        if(user_arr[ik].id == dm_upload_arr[i].upload_by ){
                            out+= '<td>'+user_arr[ik].name+'</td>';
                        }else{
                            out+= '<td>N/A</td>';
                        }
                    }
                    out+= '<td><button class="mdl-button mdl-button--colored mdl-button--icon dm_edit_remark" id="'+dm_upload_arr[i].id+'"><i class="material-icons">edit</i></button></td>';
                    out += '</tr>';
                }
            }else{
                out += '<tr><td colspan="7" style="text-align:center;">No Files Found !</td></tr>';
            }
            out += '</tbody></table>';
        out += '</div>';
        if (send_mail == 'true') {
            $('.send_mail').css('display','block');
        }

        $('.design_details').empty();
        $('.design_details').append(out);
    }

    $('.design_details').on('click','.dm_edit_remark',function(e){
        e.preventDefault();
        dm_upload_id = $(this).prop('id');
        $('#edit_remark_modal').modal('show');
    });

    $('.save_remark').click(function (e) {
        e.preventDefault();
        $.post('<?php echo base_url()."Design_manager/update_remark/".$code."/";?>'+dm_id+'/'+dm_upload_id,{
            'remark_edit' : $("#edit_remark_content" ).val()
        }, function(data, status, xhr) {
            for (var i = 0; i < dm_upload_arr.length; i++) {
                if(dm_upload_arr[i].id == dm_upload_id){
                    dm_upload_arr[i].remark = $("#edit_remark_content" ).val();
                }
            }
            $("#edit_remark_content" ).val('');
            display_design();
        }, "text");
    });

    $('.send_mail_btn').click(function (e){
        e.preventDefault();
        $('#send_mail_modal').modal('show');
    });

    $('.design_details').on('click','.download_doc',function (e) {
        e.preventDefault();
        var id = $(this).prop('id');
        window.location = "<?php echo base_url().'Design_manager/download_dm_doc/'.$code.'/'; ?>"+ id;
    });

    $('.design_details').on('change', 'input[type=checkbox]', function(e) {
        e.preventDefault();
        var a = $(this).prop('id');
        if ($(this).is(':checked') == false) {
            var status= 'false';
        }else{
            var status= 'true';
        }
        cat_id = 0;
        for (var i = 0; i < dm_upload_arr.length; i++) {
            if(dm_upload_arr[i].id == a){
                cat_id = dm_upload_arr[i].cat_id;
            }
        }
        $.post('<?php echo base_url()."Design_manager/change_dm_status/".$code."/";?>'+a+'/'+status+'/'+dm_id+'/'+cat_id
        , function(data, s, xhr) {
            if (data == '') {
                data = 'N/A';
            }
            for (var i = 0; i < dm_upload_arr.length; i++) {
                if (dm_id == dm_upload_arr[i].c_id) {
                    dm_upload_arr[i].final = 'false';
                    dm_upload_arr[i].final_on = 'N/A';
                }
                if(dm_upload_arr[i].id == a){
                    dm_upload_arr[i].final = status;
                    dm_upload_arr[i].final_on = data;
                }
            }
            display_design();
        }, "text");
    });

    $('.save_dm').click(function (e) {
        e.preventDefault();
        save_dm();
    });

    $('.save_dm_submit').click(function (e) {
        e.preventDefault();
        save_dm();
    });

    function save_dm(){
        arrayCollection = [];
        arr = $('#dm_cat_list').jstree(true).get_json('#', {flat:true});
        for (var i = 0; i < arr.length; i++) {
            arrayCollection.push({"id": arr[i].id, "parent": arr[i].parent, "text": arr[i].text});
        }

        $.post('<?php echo base_url()."Design_manager/save_design_manager/".$code."/";?>',{
            'dm_type' : 0,
            'dm_type_id' : 0,
            'dm_title' : $("#dm_title" ).val(),
            'dm_id' : dm_id,
            'dm_arr' : arrayCollection
        }, function(data, status, xhr) {
            upload_files(data,$("#dm_remark").val());
        }, "text");
    }

    function upload_files(inid,remark){
        if($('.upload')[0].files.length > 0 ) {
            var datat = new FormData();
            var ins = $('.upload')[0].files.length;
            for (var x = 0; x < ins; x++) {
                datat.append("used[]", $('.upload')[0].files[x]);
            }
            $.ajax({
                url: "<?php echo base_url().'Design_manager/dm_doc_upload/'.$code.'/';?>"+inid+'/'+sel_cat_id+'/'+remark,
                type: "POST",
                data: datat,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    window.location = '<?php echo base_url().'Design_manager/add_design_manager/'.$code.'/' ?>'+inid;
                }
            });
        }else{
            window.location = '<?php echo base_url().'Design_manager/add_design_manager/'.$code.'/' ?>'+inid;
        }
    }

    $('.delete_dm').click(function (e) {
        e.preventDefault();
        $.post('<?php echo base_url()."Design_manager/dm_delete/".$code."/";?>'+dm_id
        ,function(data, status, xhr) {
            window.location = '<?php echo base_url()."Design_manager/home/0/".$code."/";?>';
        });
    });
});
</script>