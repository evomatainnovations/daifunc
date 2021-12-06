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
        color: #000;
        text-align: center;
        border-bottom: 1px solid #ccc;
    }

    .general_table > tbody {
        border: 1px solid #ccc;
    }
    .general_table > tbody > tr {
        border-bottom: 1px solid #ccc;
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
<main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;">
            <input type="text" id="req_name" name="req_name" class="mdl-textfield__input" value="<?php if(isset($edit_boq)) { echo $edit_boq[0]->iextetboq_title; }?>" style="font-size: 1.6em;outline: none;" placeholder="Enter Agreement Title">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col">
                    <?php
                        if (isset($edit_boq)) {
                            echo '<button class="mdl-button mdl-button--colored delete_boq"><i class="material-icons">delete</i> delete</button>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet">
            <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
                <div class="mdl-tabs__tab-bar">
                    <a href="#Self-panel" class="mdl-tabs__tab is-active" id="self" style="color:black">Tab 1</a>
                    <a href="#All-panel" class="mdl-tabs__tab" id="all" style="color:black">Tab 2</a>
                </div>
                <div class="mdl-tabs__panel is-active" id="Self-panel">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;text-align: center;">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="agree_var">
                                <label class="mdl-textfield__label" for="agree_var">Variable</label>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" id="agree_val">
                                <label class="mdl-textfield__label" for="agree_val">Value</label>
                            </div>
                            <div>
                                <button class="mdl-button mdl-button--colored add_attr"><i class="material-icons">add</i> Add</button>
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--8-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 60vh;overflow: auto;">
                            <table class="general_table table_display">
                                <thead>
                                    <th>Sr. No.</th>
                                    <th>Variable</th>
                                    <th>Value</th>
                                    <th colspan="2">Action</th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mdl-tabs__panel" id="All-panel">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <select class="mdl-textfield__input" id="table_data"><option value="">Select</option></select>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" id="agree_content" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 60vh;outline: none;overflow: auto;" contenteditable="true"></div>
                </div>
            </div>
        </div>
        <button class="lower-button mdl-button mdl-button--colored mdl-button--fab save_boq"><i class="material-icons">done</i></button>
    </div>
</main>
<script type="text/javascript">
    var table_arr = [];
    var t_flg = 0;
    var edit_attr_flg = 0;
    $(document).ready( function() {
        var snackbarContainer = document.querySelector('#demo-toast-example');

        $('.add_attr').click(function (e){
            e.preventDefault();
            if (edit_attr_flg == 0 ) {
                t_flg++;
                table_arr.push({'id' : t_flg , 'var' : $('#agree_var').val(),'val' : $('#agree_val').val() });
            }else{
                for (var i = 0; i < table_arr.length; i++) {
                    if(table_arr[i].id == edit_attr_flg){
                        table_arr[i].var = $('#agree_var').val();
                        table_arr[i].val = $('#agree_val').val();
                    }
                }
            }
            edit_attr_flg = 0;
            $('#agree_var').val('');
            $('#agree_val').val('');
            display_table_option();
            display_table();
        });

        $('#agree_val').keyup(function (e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                if (edit_attr_flg == 0 ) {
                    t_flg++;
                    table_arr.push({'id' : t_flg , 'var' : $('#agree_var').val(),'val' : $('#agree_val').val() });
                }else{
                    for (var i = 0; i < table_arr.length; i++) {
                        if(table_arr[i].id == edit_attr_flg){
                            table_arr[i].var = $('#agree_var').val();
                            table_arr[i].val = $('#agree_val').val();
                        }
                    }
                }
                edit_attr_flg = 0;
                $('#agree_var').val('');
                $('#agree_val').val('');
                display_table_option();
                display_table();
            }
        });

        $('#table_data').change(function (e) {
            e.preventDefault();
            var a_content = $(this).val();
            $('#agree_content').append(' '+a_content);
        });

        $('.table_display').on('click','.edit_attr', function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            edit_attr_flg = id;
            var var1,val1;
            for (var i = 0; i < table_arr.length; i++) {
                if(table_arr[i].id == id){
                    var1 = table_arr[i].var;
                    val1 = table_arr[i].val;
                }
            }
            $('#agree_var').val(var1);
            $('#agree_val').val(val1);
        });

        $('.table_display').on('click','.delete_attr', function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            for (var i = 0; i < table_arr.length; i++) {
                if(table_arr[i].id == id){
                    table_arr.splice(i,1);
                }
            }
            display_table();
        });

        function display_table_option(){
            var out = '';
            out += '<option value="">Select</option>';
            for (var i = 0; i < table_arr.length; i++) {
                out += '<option value="'+table_arr[i].val+'">'+table_arr[i].var+'</option>';
            }
            $('#table_data').empty();
            $('#table_data').append(out);
        }

        function display_table(){
            var out = '';
            for (var i = 0; i < table_arr.length; i++) {
                out += '<tr style="text-align:center;"><td>'+table_arr[i].id+'</td><td>'+table_arr[i].var+'</td><td>'+table_arr[i].val+'</td><td><button class="mdl-button mdl-button--colored edit_attr" id="'+table_arr[i].id+'"><i class="material-icons">edit</i>edit</button></td><td><button class="mdl-button mdl-button--colored delete_attr" id="'+table_arr[i].id+'"><i class="material-icons">delete</i>delete</button></td></tr>';
            }
            $('.table_display > tbody').empty();
            $('.table_display > tbody').append(out);
            $('#agree_var').focus();
        }
    });
</script>