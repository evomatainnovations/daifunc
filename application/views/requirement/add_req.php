<style type="text/css">
    .ui-widget {
        z-index: 30000 !important;
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
        <div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 50px;text-align: center;">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
                <select class="mdl-textfield__input" id="req_type_list" style="height: 30px;">
                    <option value="null">Select requriment type</option>
                    <?php
                        if (isset($edit_req)) {
                            if ($edit_req[0]->iextetr_type == 'contact') {
                                echo '<option value="contact" selected>Contact</option>';
                            }else{
                                echo '<option value="contact">Contact</option>';
                            }
                            if ($edit_req[0]->iextetr_type == 'project') {
                                echo '<option value="project" selected>Project</option>';
                            }else{
                                echo '<option value="project">Project</option>';
                            }
                            if ($edit_req[0]->iextetr_type == 'oppo') {
                                echo '<option value="oppo" selected>Opportunity</option>';
                            }else{
                                echo '<option value="oppo">Opportunity</option>';
                            }
                        }else{
                            echo '<option value="contact">Contact</option><option value="project">Project</option><option value="oppo">Opportunity</option>';
                        }
                    ?>
                </select>
            </div>
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
        <div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
            <input type="text" id="req_name" name="req_name" class="mdl-textfield__input" value="<?php if(isset($edit_req)) { echo $edit_req[0]->iextetr_title; }?>" style="font-size: 1.6em;outline: none;">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <?php
                        if (isset($edit_req)) {
                            echo '<button class="mdl-button mdl-button--colored delete_req"><i class="material-icons">delete</i> delete</button>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="mdl-grid">
        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
            <div class="mdl-tabs__tab-bar" style="width:100%">
                <a href="#p_formal" class="mdl-tabs__tab is-active" style="color:black">Upload photos and Add Note</a>
                <a href="#p_email" class="mdl-tabs__tab" style="color:black">Add Requirement List</a>
            </div>
            <div class="mdl-cell mdl-cell--12-col" id="req_type">
                <div class="mdl-tabs__panel is-active" id="p_formal">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--4-col upload-btn-wrapper">
                            <div type="button" class="mdl-button mdl-js-button mdl-button--colored pic_button">
                                <i class="material-icons">note</i>Upload Document
                                <input type="file" name="file[]" id="multiFiles" class="upload proposal_doc" multiple>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--6-col">
                            <input type="text" id="req_note" class="mdl-textfield__input" placeholder="Add notes" style="font-size: 1.6em;outline: none;margin: 20px;">
                        </div>
                        <div class="mdl-cell mdl-cell--2-col">
                            <button class="mdl-button mdl-button--colored add_req_note"><i class="material-icons">add</i>Add notes</button>
                        </div>
                    </div>
                    <div class="mdl-grid note_display" style="overflow-y: scroll;height: 50vh;">
                        <?php
                            if (isset($edit_notes)) {
                                for ($i=0; $i < count($edit_notes) ; $i++) { 
                                    if ($edit_notes[$i]->iextetrn_type == 'note') {
                                        echo '<div class="mdl-cell mdl-cell--12-col"><h3>'.$edit_notes[$i]->iextetrn_content.'</h3></div>';
                                    }else{
                                        $upload_dir = base_url()."assets/uploads/".$oid."/";
                                        $file_name = $edit_notes[$i]->iextetrn_content;
                                        echo '<div class="mdl-cell mdl-cell--3-col"><img class="upload_view" src="'.$upload_dir.$file_name.'" style="max-width:100%;max-height:100%;" alt="your image" /></div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="p_email">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--4-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <select class="mdl-textfield__input" id="req_list_temp">
                                    <option value="null">Select Requirement List</option>
                                    <?php 
                                        for($i=0; $i < count($req_list); $i++) {
                                            echo '<option value="'.$req_list[$i]->iextetr_id.'">'.$req_list[$i]->iextetr_title.'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--4-col">
                            <button class="mdl-button mdl-button--colored add_req_list"><i class="material-icons">add</i> Add Requirement List</button>
                        </div>
                        <div class="mdl-cell mdl-cell--12-col" style="width: 100%;">
                             <table id="edit_req_list" class="general_table" style="display: ;">
                                <thead>
                                    <tr>
                                        <th>Sr. No</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="lower-button mdl-button mdl-button--fab mdl-button--colored save_req"><i class="material-icons">done</i></button>
    </div>
</main>
<div class="modal fade" id="add_req_list_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add requirement list</h3>
            </div>
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                            <input class="mdl-textfield__input" type="text" id="product_name" style="width: 100%;">
                            <label class="mdl-textfield__label" for="product_name">Enter product name</label>
                        </div>  
                    </div>
                    <div class="mdl-cell mdl-cell--4-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                            <input class="mdl-textfield__input" type="text" id="product_qty" style="width: 100%;">
                            <label class="mdl-textfield__label" for="product_qty">Enter product Qty</label>
                        </div>  
                    </div>
                    <div class="mdl-cell mdl-cell--2-col" style="margin-top: 20px;">
                        <button class="mdl-button mdl-button--colored add_to_product_list"><i class="material-icons">add</i></button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col" style="width: 100%;">
                        <table id="req_list" class="general_table" style="display: ;">
                            <thead>
                                <tr>
                                    <th>Sr. No</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Action</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="save_req_list">Save</button>
                <button type="button" class="mdl-button" data-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>
<div id="demo-toast-example" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script type="text/javascript">

    var product_data_l = [];
    var req_pro_arr = [];
    var arr_id = 0;
    var req_txn_id = 0;
    var txn_type = '';
    var edit_req_pro = [];
    var note_arr = [];
    var contact_arr = [];
    var project_arr = [];
    var oppo_arr = [];
    var customer_data = [];
    <?php
        if (isset($product)) {
            for ($i=0; $i < count($product) ; $i++) { 
                echo "product_data_l.push('".$product[$i]->ip_product."');";
            }
        }

        if (isset($edit_req)) {
            echo "req_txn_id = '".$edit_req[0]->iextetr_type_id."';";
            echo "txn_type = '".$edit_req[0]->iextetr_type."';";
        }

        if (isset($edit_req_list)) {
            for ($i=0; $i <count($edit_req_list) ; $i++) { 
                echo "edit_req_pro.push({'id' : '".$edit_req_list[$i]->iextetrp_id."' , 'pro_name' : '".$edit_req_list[$i]->ip_product."' , 'qty' : '".$edit_req_list[$i]->iextetrp_qty."'});";
            }
            echo "display_req_pro_list();";
        }

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
    ?>
    $(document).ready( function() {
        var snackbarContainer = document.querySelector('#demo-toast-example');

        $('#mutual_tag').tagit({
            autocomplete : { delay: 0, minLenght: 5},
            allowSpaces : true,
            availableTags : customer_data,
            singleField : true
        });

        $('.add_req_note').click(function (e) {
            e.preventDefault();
            var req_note = $('#req_note').val();
            note_arr.push({'type' : 'note' , 'content' : req_note });
            $('#req_note').val('');
            display_req_notes(req_note);
        });

        $('#req_note').keyup(function (e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                var req_note = $('#req_note').val();
                note_arr.push({'type' : 'note' , 'content' : req_note });
                $('#req_note').val('');
                display_req_notes(req_note);
            }
        });

        $('.upload').change(function (e) {
            e.preventDefault();
            var ins = $('.upload')[0].files.length;
            var input = $('.upload')[0];
            for (var i = 0; i < input.files.length; i++) {
                if (input.files && input.files[i]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.note_display').append('<div class="mdl-cell mdl-cell--3-col"><img class="upload_view" src="'+ e.target.result+'" style="max-width:100%;max-height:100%;" alt="your image" /></div>');
                    };
                    reader.readAsDataURL(input.files[i]);
                }
            }
        });

        $("#product_name" ).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(product_data_l, request.term);
                response(results.slice(0, 10));
            }
        });

        $('#add_req_list_modal').on('click','#save_req_list',function (e) {
            e.preventDefault();
            for (var i = 0; i < req_pro_arr.length; i++) {
                edit_req_pro.push({'id' : req_pro_arr[i].id , 'pro_name' : req_pro_arr[i].pro_name , 'qty' : req_pro_arr[i].qty});
            }
            display_req_pro_list();
        });

        $('#product_qty').keyup(function (e) {
            e.preventDefault();
            var key = e.keyCode;
            if (key == 13) {
                insert_product_list();
            }
        });

        $('.add_to_product_list').click(function (e) {
            e.preventDefault();
            insert_product_list();
        });

        $('#req_list_temp').change(function (e) {
            e.preventDefault();
            var txn_id = $(this).val();
            $.post('<?php echo base_url()."Requirement/get_req_product_list/".$code."/";?>'+txn_id
            , function(data, status, xhr) {
                var a = JSON.parse(data);
                edit_req_pro = [];
                for (var i = 0; i < a.req_list.length; i++) {
                    edit_req_pro.push({'id' : a.req_list[i].iextetrp_id , 'pro_name' : a.req_list[i].ip_product , 'qty' : a.req_list[i].iextetrp_qty});
                }
                display_req_pro_list();
            }, "text");
        });

        $('#req_type_list').change(function (e) {
            e.preventDefault();
            var data_type = [];
            txn_type = $(this).val();
            if (txn_type == 'contact') {
                for (var i = 0; i < contact_arr.length; i++) {
                    data_type.push(contact_arr[i].name);
                }
            }else if(txn_type == 'project'){
                for (var i = 0; i < project_arr.length; i++) {
                    data_type.push(project_arr[i].name);
                }
            }else{
                for (var i = 0; i < oppo_arr.length; i++) {
                    data_type.push(oppo_arr[i].name);
                }
            }

            $("#req_name" ).autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(data_type, request.term);
                    response(results.slice(0, 10));
                },select: function(event, ui) {
                    var value =  ui.item.value;
                    get_txn_id(value);
                }
            });
        });


        function get_txn_id(name){
            if (txn_type == 'contact') {
                for (var i = 0; i < contact_arr.length; i++) {
                    if (contact_arr[i].name == name) {
                        req_txn_id = contact_arr[i].id;
                    }
                }
            }else if (txn_type == 'project') {
                for (var i = 0; i < project_arr.length; i++) {
                    if (project_arr[i].name == name) {
                        req_txn_id = project_arr[i].id;
                    }
                }
            }else{
                for (var i = 0; i < oppo_arr.length; i++) {
                    if (oppo_arr[i].name == name) {
                        req_txn_id = oppo_arr[i].id;
                    }
                }
            }
        }
        $('.add_req_list').click(function (e) {
            e.preventDefault();
            $('#add_req_list_modal').modal('show');
        });

        $('#req_list').on('click','.edit_arr',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            for (var i = 0; i < req_pro_arr.length; i++) {
                if(req_pro_arr[i].id == id ){
                    $('#product_name').val(req_pro_arr[i].pro_name);
                    $('#product_qty').val(req_pro_arr[i].qty);
                    req_pro_arr.splice(i , 1);
                }
            }
            display_product_list();
        });

        $('#req_list').on('click','.delete_arr',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            for (var i = 0; i < req_pro_arr.length; i++) {
                if(req_pro_arr[i].id == id ){
                    req_pro_arr.splice(i , 1);
                }
            }
            display_product_list();
        });

        $('.save_req').click(function (e) {
            e.preventDefault();
            var title = $('#req_name').val();
            if (title == '') {
                var data = {message: 'Please select requirement type !'};
                snackbarContainer.MaterialSnackbar.showSnackbar(data);
            }else {
                $('.loader').show();
                for (var i = 0; i < edit_req_pro.length; i++) {
                    var id = edit_req_pro[i].id;
                    var qty = $('#edit_product_qty'+id).val();
                    edit_req_pro[i].qty = qty;
                }
                var mutual = [];
                $('#mutual_tag > li').each(function(index) {
                    var tmpstr1 = $(this).text();
                    var len1 = tmpstr1.length - 1;
                    if(len1 > 0) {
                        tmpstr1 = tmpstr1.substring(0, len1);
                        mutual.push(tmpstr1);
                    }
                });
                $.post('<?php if(isset($edit_req)) { echo base_url()."Requirement/update_req/".$code."/".$edit_req_id; } else { echo base_url()."Requirement/save_req/".$code."/"; } ?>',{
                    'pro_list' : edit_req_pro ,
                    'req_title' : $('#req_name').val(),
                    'txn_id' : req_txn_id,
                    'txn_type' : txn_type,
                    'notes' : note_arr,
                    'mutual' : mutual
                }, function(data, status, xhr) {
                    upload_fles(data);
                }, "text");
            }
        });

        function upload_fles(req_id) {
            if($('.upload')[0].files.length > 0 ) {
                var datat = new FormData();
                var ins = $('.upload')[0].files.length;
                for (var x = 0; x < ins; x++) {
                    datat.append("used[]", $('.upload')[0].files[x]);
                }
                $.ajax({
                    url: "<?php echo base_url().'Requirement/req_doc_upload/'.$code.'/';?>"+req_id,
                    type: "POST",
                    data: datat,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        window.location = '<?php echo base_url().'Requirement/add_req/'.$code.'/' ?>'+req_id;
                    }
                });
            }else{
                window.location = '<?php echo base_url().'Requirement/add_req/'.$code.'/' ?>'+req_id;
            }
        }

        $('.delete_req').click(function (e) {
            e.preventDefault();
            $.post('<?php if(isset($edit_req)) { echo base_url()."Requirement/delete_req/".$code."/".$edit_req_id; }  ?>'
            ,function(data, status, xhr) {
                window.location = '<?php echo base_url().'Requirement/home/null/'.$code.'/' ?>';
            }, "text");
        });

        function insert_product_list() {
            req_pro_arr.push({id : arr_id , pro_name : $('#product_name').val() , qty : $('#product_qty').val() });
            arr_id ++;
            $('#product_name').val('');
            $('#product_qty').val('');
            $('#product_name').focus();
            display_product_list();
        }

        function display_product_list() {
            var out = '';
            var sr_no = 0;
            for (var i = 0; i < req_pro_arr.length; i++) {
                sr_no++;
                out += '<tr>';
                out += '<td>'+sr_no+'</td>';
                out += '<td>'+req_pro_arr[i].pro_name+'</td>';
                out += '<td>'+req_pro_arr[i].qty+'</td>';
                out += '<td><button class="mdl-button mdl-button--colored mdl-button--icon edit_arr" id="'+req_pro_arr[i].id+'"><i class="material-icons">edit</i></button></td>';
                out += '<td><button class="mdl-button mdl-button--colored mdl-button--icon delete_arr" id="'+req_pro_arr[i].id+'"><i class="material-icons">delete</i></button></td>';
                out += '</tr>';
            }
            $('#req_list > tbody').empty();
            $('#req_list > tbody').append(out);
        }
    });

        function display_req_pro_list() {
            var out = '';
            var sr_no = 0;
            for (var i = 0; i < edit_req_pro.length; i++) {
                sr_no++;
                out += '<tr>';
                out += '<td>'+sr_no+'</td>';
                out += '<td>'+edit_req_pro[i].pro_name+'</td>';
                out += '<td><input class="mdl-textfield__input" type="text" id="edit_product_qty'+edit_req_pro[i].id+'" value="'+edit_req_pro[i].qty+'" style="outline:none;"></td>';
                out += '</tr>';
            }
            $('#edit_req_list > tbody').empty();
            $('#edit_req_list > tbody').append(out);
        }

        function display_req_notes(note){
            var out = '<div class="mdl-cell mdl-cell--12-col"><h3>'+note+'<h3></div>';
            $('.note_display').append(out);
            $(".note_display").scrollTop(1e4);
        }
</script>


