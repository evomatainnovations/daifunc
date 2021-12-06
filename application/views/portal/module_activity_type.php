<style type="text/css">
    @media only screen and (max-width: 760px) {
        .general_table {
            display: block;
            overflow: auto;
        }
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
</style>
<main class="mdl_content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--4-col" style="background-color: #fff;border-radius: 15px;box-shadow: 0px 4px 10px #ccc;padding: 30px;">
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="mdl-textfield__label" for="mod_act_module">Select Module Name</label>
                <select class="mdl-textfield__input" id="mod_act_module">
                    <option value="0">No Module</option>
                    <?php for($i=0; $i < count($modules); $i++) {
                        echo '<option value="'.$modules[$i]->im_id.'">'.$modules[$i]->im_name.'</option>';
                    } ?>
                </select>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" type="text" id="mod_act_type">
                <label class="mdl-textfield__label" for="mod_act_type">Enter Activity type</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="mdl-textfield__label" for="mod_act_date">Select Activity Date Display</label>
                <select class="mdl-textfield__input" id="mod_act_date">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="mdl-textfield__label" for="mod_shortcut">Module Shortcut Display</label>
                <select class="mdl-textfield__input" id="mod_shortcut">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <label class="mdl-textfield__label" for="mod_category">Catergory Display</label>
                <select class="mdl-textfield__input" id="mod_category">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <button class="mdl-button mdl-button--colored mdl-button--raised save_mod_act" style="width: 100%;"><i class="material-icons">save</i> save</button>
        </div>
        <div class="mdl-cell mdl-cell--8-col">
            <table class="general_table" style="width: 100%;">
                <thead>
                    <th>Module Name</th>
                    <th>Activity Type</th>
                    <th>Date display</th>
                    <th>Cat display</th>
                    <th>Action</th>
                    <th></th>
                </thead>
                <tbody class="mod_act_list"></tbody>
            </table>
        </div>
    </div>
</main>
<script type="text/javascript">
    var mod_act_arr = [];
    var edit_flg = 0;
    <?php
        if (isset($mod_act)) {
            for ($i=0; $i < count($mod_act) ; $i++) {
                echo "mod_act_arr.push({'id' : '".$mod_act[$i]->ipmat_id."', 'mid' : '".$mod_act[$i]->ipmat_mid."' ,'mname' : '".$mod_act[$i]->ipmat_mname."' , 'mod_act_type' : '".$mod_act[$i]->ipmat_act_type."', 'mod_act_date' : '".$mod_act[$i]->ipmat_date_display."', 'mod_act_shortcut' : '".$mod_act[$i]->ipmat_shortcut_display."', 'mod_act_cat' : '".$mod_act[$i]->ipmat_category_display."' });";
            }
        }
    ?>
    $(document).ready(function() {
        display_mod_list();

        $('.save_mod_act').click(function (e) {
            e.preventDefault();
            $.post('<?php echo base_url().'Portal/module_activity_type_save/'; ?>',{
                'mid' : $('#mod_act_module').val(),
                'mod_act_type' : $('#mod_act_type').val(),
                'mod_act_date' : $('#mod_act_date').val(),
                'mod_act_shortcut' : $('#mod_shortcut').val(),
                'mod_act_cat' : $('#mod_category').val(),
                'edit_flg' : edit_flg
            },function (d,x,s) {
                var a = JSON.parse(d);
                mod_act_arr = [] ;
                for (var i = 0; i < a.mod_details.length; i++) {
                    mod_act_arr.push({id : a.mod_details[i].ipmat_id , mid : a.mod_details[i].ipmat_mid , mname : a.mod_details[i].ipmat_mname , mod_act_type : a.mod_details[i].ipmat_act_type , mod_act_date : a.mod_details[i].ipmat_date_display , mod_act_shortcut : a.mod_details[i].ipmat_shortcut_display , mod_act_cat : a.mod_details[i].ipmat_category_display });
                }
                $('#mod_act_module').val('0');
                $('#mod_act_type').val('');
                $('#mod_act_date').val('yes');
                $('#mod_shortcut').val('yes');
                $('#mod_category').val('yes');
                display_mod_list();
            },'text');
        });

        $('.mod_act_list').on('click','.delete_mod_act', function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            $.post('<?php echo base_url().'Portal/module_activity_type_delete/'; ?>'+id
            ,function (d,x,s) {
                var a = JSON.parse(d);
                mod_act_arr = [] ;
                for (var i = 0; i < a.mod_details.length; i++) {
                    mod_act_arr.push({id : a.mod_details[i].ipmat_id , mid : a.mod_details[i].ipmat_mid , mname : a.mod_details[i].ipmat_mname , mod_act_type : a.mod_details[i].ipmat_act_type , mod_act_date : a.mod_details[i].ipmat_date_display , mod_act_shortcut : a.mod_details[i].ipmat_shortcut_display , mod_act_cat : a.mod_details[i].ipmat_category_display });
                }
                display_mod_list();
            },'text');
        });

        $('.mod_act_list').on('click','.edit_mod_act', function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            edit_flg = id;
            for (var i = 0; i < mod_act_arr.length; i++) {
                if(mod_act_arr[i].id == id){
                    $('#mod_act_module').val(mod_act_arr[i].mid);
                    $('#mod_act_type').val(mod_act_arr[i].mod_act_type);
                    $('#mod_act_date').val(mod_act_arr[i].mod_act_date);
                    $('#mod_shortcut').val(mod_act_arr[i].mod_act_shortcut);
                    $('#mod_category').val(mod_act_arr[i].mod_act_cat);
                }
            }
        });

        function display_mod_list(){
            var out = '';
            for (var i = 0; i < mod_act_arr.length; i++) {
                if (mod_act_arr[i].mid == 0) {
                    mname = 'No module';
                }else{
                    mname = mod_act_arr[i].mname;
                }
                out += '<tr><td>'+mname+'</td><td>'+mod_act_arr[i].mod_act_type+'</td><td>'+mod_act_arr[i].mod_act_date+'</td><td>'+mod_act_arr[i].mod_act_cat+'</td><td><button class="mdl-button mdl-button--icon delete_mod_act" id="'+mod_act_arr[i].id+'"><i class="material-icons">delete</i></button></td><td><button class="mdl-button mdl-button--icon edit_mod_act" id="'+mod_act_arr[i].id+'"><i class="material-icons">edit</i></button></td></tr>';
            }
            $('.mod_act_list').empty();
            $('.mod_act_list').append(out);
        }
    });
</script>