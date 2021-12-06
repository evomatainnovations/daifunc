<main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--4-col">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;text-align: left;height: 86vh;">
                    <table class="general_table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Work Title</th>
                                <th colspan="2" style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="work_list"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--8-col">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;text-align: left;">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                                <input class="mdl-textfield__input" type="text" id="work_title" style="width: 100%;font-size: 2em;" placeholder="Enter Work Title">
                            </div>  
                        </div>
                        <div class="mdl-cell mdl-cell--12-col work_delete_btn" style="text-align:center;display: none;">
                            <button class="mdl-button mdl-button--colored work_delete"><i class="material-icons">delete</i>Delete</button>
                        </div>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet design_details" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 67vh;overflow-y: auto; ">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--10-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
                                <input class="mdl-textfield__input" type="text" id="work_act" style="width: 100%;" placeholder="Enter Activity Title">
                            </div>
                        </div>
                        <div class="mdl-cell mdl-cell--2-col" style="text-align: center;">
                            <button class="mdl-button mdl-button--colored add_act"><i class="material-icons">add</i> Add</button>
                        </div>
                        <div class="mdl-cell mdl-cell--12-col" style="overflow: auto;">
                            <table class="general_table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Activity Title</th>
                                        <th colspan="2" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="work_act_list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>    
        </div>
    </div>
    <button class="lower-button mdl-button mdl-button--fab mdl-button--colored submit_work"><i class="material-icons">done</i></button>
</main>
<script type="text/javascript">
    var act_flg = 0;
    var act_list = [];
    var work_list = [];
    var act_edit_flg = null;
    var work_edit_flg = null;
    <?php
        if (isset($work_list)) {
            for ($i=0; $i < count($work_list) ; $i++) {
                echo "work_list.push({'id' : '".$work_list[$i]->iextetwm_id."' , 'work_title' : '".$work_list[$i]->iextetwm_title."' });";
            }
        }
    ?>
    $(document).ready(function() {
        display_work_list();
        $('.add_act').click(function (e) {
            e.preventDefault();
            if (act_edit_flg == null) {
                act_flg++;
                act_list.push({'id' : act_flg , 'act_title' : $('#work_act').val()});
            }else{
                act_list[act_edit_flg].act_title = $('#work_act').val();
            }
            act_edit_flg = null;
            $('#work_act').val('');
            display_act_list();
        });

        $('#work_act').keyup(function (e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                if (act_edit_flg == null) {
                    act_flg++;
                    act_list.push({'id' : act_flg , 'act_title' : $('#work_act').val()});
                }else{
                    act_list[act_edit_flg].act_title = $('#work_act').val();
                }
                act_edit_flg = null;
                $('#work_act').val('');
                display_act_list();
            }
        });

        $('#work_act_list').on('click','.edit',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            act_edit_flg = id;
            $('#work_act').val(act_list[id].act_title);
        });

        $('#work_act_list').on('click','.delete',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            act_list.splice(id,1);
            act_edit_flg = null;
            $('#work_act').val('');
            display_act_list();
        });

        $('#work_list').on('click','.work_edit',function (e) {
            e.preventDefault();
            $('.loader').show();
            work_edit_flg = $(this).prop('id');
            $.post('<?php echo base_url()."Work_module/get_work_activity/".$code."/"; ?>'+work_edit_flg,
            function(data, status, xhr) {
                var a = JSON.parse(data);
                act_list = [];
                if (a.work_edit.length > 0 ) {
                    $('#work_title').val(a.work_edit[0].iextetwm_title);
                    for (var i=0; i < a.work_edit.length ; i++) {
                        act_list.push({'id' : a.work_edit[i].iextetwma_id , 'act_title' : a.work_edit[i].iextetwma_title });
                    }
                }
                $('.work_delete_btn').css('display','block');
                display_act_list();
                $('.loader').hide();
            });
        });

        $('.work_delete_btn').click(function (e) {
            e.preventDefault();
            if (work_edit_flg != null) {
                $('.loader').show();
                $.post('<?php echo base_url()."Work_module/work_delete/".$code."/"; ?>'+work_edit_flg,
                function(data, status, xhr) {
                    window.location = "<?php echo base_url().'Work_module/work_add/'.$code; ?>";
                });
            }
        });

        $('.submit_work').click(function (e) {
            e.preventDefault();
            $('.loader').show();
            var path = '';
            if (work_edit_flg == null) {
                path = '<?php echo base_url()."Work_module/work_save/".$code; ?>';
            }else{
                path = '<?php echo base_url()."Work_module/work_update/".$code."/"; ?>'+work_edit_flg;
            }
            $.post(path,{
                'title' : $('#work_title').val(),
                'act_list' : act_list
            },function(data, status, xhr) {
                window.location = "<?php echo base_url().'Work_module/work_add/'.$code; ?>";
            });
        });
    });

    function display_act_list(){
        var out = '';
        var sr_flg = 0;
        for (var i = 0; i < act_list.length; i++) {
            sr_flg++;
            out += '<tr>';
            out += '<td style="width:20%;">'+sr_flg+'</td>';
            out += '<td style="width:50%;">'+act_list[i].act_title+'</td>';
            out += '<td style="text-align: center;"><button class="mdl-button mdl-button--colored delete" id="'+i+'"><i class="material-icons">delete</i> delete</button></td>';
            out += '<td style="text-align: center;"><button class="mdl-button mdl-button--colored edit" id="'+i+'"><i class="material-icons">edit</i> edit</button></td>';
            out += '</tr>';
        }

        $('#work_act_list').empty();
        $('#work_act_list').append(out);
    }

    function display_work_list(){
        var out = '';
        var sr_flg = 0;
        for (var i = 0; i < work_list.length; i++) {
            sr_flg++;
            out += '<tr>';
            out += '<td style="width:20%;">'+sr_flg+'</td>';
            out += '<td style="width:50%;">'+work_list[i].work_title+'</td>';
            out += '<td style="text-align: center;"><button class="mdl-button mdl-button--colored work_edit" id="'+work_list[i].id+'"><i class="material-icons">edit</i> edit</button></td>';
            out += '</tr>';
        }

        $('#work_list').empty();
        $('#work_list').append(out);
    }
</script>