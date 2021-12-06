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
        border: 1px solid #ccc;
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
        border: 1px solid #ccc;
        text-align: center;
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
        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 10px;text-align: left;">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--6-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"style="height: 30px;width: 60%;" >
                        <select class="mdl-textfield__input" id="dm_type_list" style="height: 30px;">
                            <option value="null">Select design type</option>
                            <option value="boq">BOQ</option>
                            <!-- <option value="project">Proposal</option> -->
                            <!-- <option value="oppo">Opportunity</option> -->
                        </select>
                    </div>  
                </div>
                <div class="mdl-cell mdl-cell--6-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 60%;">
                        <input class="mdl-textfield__input" type="text" id="dm_type_name" >
                        <label class="mdl-textfield__label" for="dm_type_name">Enter design type name</label>
                    </div>  
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 90vh;overflow-y: auto; ">
            <div class="mdl-grid">
                <!-- <div class="mdl-cell mdl-cell--12-col com_details"></div> -->
                <table class="general_table com_details"></table>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    var boq_arr = [];
    var txn_type = '';
    var data_type = [];
    var dm_txn_id = 0;

    var data_arr = [];
    var mutual_arr = [];
    var user_arr = [];
    var column_count = 0;
    var col_compare = [];
    var level_arr = [] ;
    var col_id = 0;
    <?php
        for($i=0; $i < count($boq_list); $i++) {
            echo "boq_arr.push({'id' : '".$boq_list[$i]->iextetboq_id."' , 'name' : '".$boq_list[$i]->iextetboq_title."' });";
        }
    ?>

    $(document).ready( function() {

        $('#dm_type_list').change(function (e) {
            e.preventDefault();
            var data_type = [];
            txn_type = $(this).val();
            if (txn_type == 'boq') {
                for (var i = 0; i < boq_arr.length; i++) {
                    data_type.push(boq_arr[i].name);
                }
            }

            $("#dm_type_name" ).autocomplete({
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
            if (txn_type == 'boq') {
                for (var i = 0; i < boq_arr.length; i++) {
                    if (boq_arr[i].name == name) {
                        dm_txn_id = boq_arr[i].id;
                    }
                }
            }
            // else if (txn_type == 'project') {
            //     for (var i = 0; i < project_arr.length; i++) {
            //         if (project_arr[i].name == name) {
            //             dm_txn_id = project_arr[i].id;
            //         }
            //     }
            // }else{
            //     for (var i = 0; i < oppo_arr.length; i++) {
            //         if (oppo_arr[i].name == name) {
            //             dm_txn_id = oppo_arr[i].id;
            //         }
            //     }
            // }

            $.post('<?php echo base_url()."Quote_compare/get_quote_details/".$code."/";?>'+txn_type+'/'+dm_txn_id
            , function(data, status, xhr) {
                var a = JSON.parse(data);
                data_arr = [];
                mutual_arr = [];
                user_arr = [];
                column_count = 0;
                col_compare = [];
                for (var i = 0; i < a.boq_arr.length; i++) {
                    if (a.boq_arr[i]['full_width'] == 'no') {
                        if (data_arr.length == 0 ) {
                            for (var ij = 0; ij < a.boq_arr[i]['row_data'].length; ij++) {
                                var type = a.boq_arr[i]['row_data'][ij]['data'];
                                data_arr.push({'level' : i , 'col' : ij , 'data' : type});
                            }
                        }else{
                            for (var ij = 0; ij < a.boq_arr[i]['row_data'].length; ij++) {
                                var type = a.boq_arr[i]['row_data'][ij]['data'];
                                data_arr.push({'level' : i , 'col' : ij , 'data' : type});
                                if (type == '') {
                                    col_id = ij;
                                }
                            }
                        }
                    }
                }

                for (var i = 0; i < a.users.length; i++) {
                    user_arr.push({'uid' : a.users[i].iextetboqm_uid , 'uname' : a.users[i].ic_name , 'amount' : 0 , 'final' : 'no'});
                }

                for (var i = 0; i < a.mutual_arr.length; i++) {
                    for (var k = 0; k < a.mutual_arr[i]['data'].length; k++) {
                        var m_uid = a.mutual_arr[i]['uid'];
                        var m_uname = a.mutual_arr[i]['uname'];
                        if (a.mutual_arr[i]['data'][k]['full_width'] == 'no') {
                            if (mutual_arr.length == 0 ) {
                                for (var ij = 0; ij < a.mutual_arr[i]['data'][k]['row_data'].length; ij++) {
                                    var type = a.mutual_arr[i]['data'][k]['row_data'][ij]['data'];
                                    mutual_arr.push({'uid' : m_uid , 'u_name' : m_uname ,'level' : k , 'col' : ij , 'data' : type});
                                }
                            }else{
                                for (var ij = 0; ij < a.mutual_arr[i]['data'][k]['row_data'].length; ij++) {
                                    var type = a.mutual_arr[i]['data'][k]['row_data'][ij]['data'];
                                    mutual_arr.push({'uid' : m_uid , 'u_name' : m_uname , 'level' : k , 'col' : ij , 'data' : type});
                                }
                            }
                        }
                    }
                }
                display_quote_comp();
            }, "text");
        }

        function display_quote_comp(){
            var out = '';
            var flg = 0;
            if (data_arr.length > 0 ) {
                flg = data_arr[0].level;
            }
            out += '<thead>';
            for (var j = 0; j < data_arr.length; j++) {
                if(data_arr[j].level == flg){
                    if (data_arr[j].col != col_id) {
                        out += '<th>'+data_arr[j].data+'</th>';
                    }else{
                        for (var i = 0; i < user_arr.length; i++) {
                            out += '<th>'+user_arr[i].uname+'<br>( '+data_arr[j].data+' )</th>';
                        }
                    }
                }
            }
            out += '</thead>';
            out += '<tbody>';
            out += '<tr>';
            for (var j = 0; j < data_arr.length; j++) {
                if(data_arr[j].level != flg){
                    var flg_id = data_arr[j].level;
                    if (data_arr[j].col != col_id) {
                        out += '<td>'+data_arr[j].data+'</td>';
                    }else{
                        var f = 0;
                        for (var i = 0; i < mutual_arr.length; i++) {
                            if(mutual_arr[i].level == flg_id){
                                if (mutual_arr[i].col == col_id) {
                                    if (mutual_arr[i].data == '') {
                                        out += '<td> N/A </td>';
                                    }else{
                                        out += '<td>'+mutual_arr[i].data+'</td>';
                                        for (var ik = 0; ik < user_arr.length; ik++) {
                                            if(user_arr[ik].uid == mutual_arr[i].uid){
                                                user_arr[ik].amount = Number(user_arr[ik].amount) + Number(mutual_arr[i].data);
                                            }
                                        }
                                    }
                                    f++;
                                }
                            }
                        }
                        if (f > 0) {
                            out += '</tr>';
                        }
                    }
                }
            }
            out += '<tr>';
            var count_flg = 0;
            for (var j = 0; j < data_arr.length; j++) {
                if(data_arr[j].level == flg){
                    if (data_arr[j].col != col_id) {
                        count_flg ++;
                    }else{
                        out += '<td colspan="'+count_flg+'">Total Amount</td>';
                        for (var i = 0; i < user_arr.length; i++) {
                            if (user_arr[i].amount == 0) {
                                out += '<td>N/A <br> ';
                                if (user_arr[i].final == 'no') {
                                    out += '<button class="mdl-button final" id="'+i+'">Not final</button>';
                                }else{
                                    out += '<button class="mdl-button mdl-button--raised mdl-button--colored">Final</button>';
                                }
                                out += '</td>';
                            }else{
                                out += '<td>'+user_arr[i].amount+'<br>';
                                if (user_arr[i].final == 'no') {
                                    out += '<button class="mdl-button final" id="'+i+'">Not final</button>';
                                }else{
                                    out += '<button class="mdl-button mdl-button--raised mdl-button--colored">Final</button>';
                                }
                                out += '</td>';
                            }
                        }
                    }
                }
            }
            out += '</tr>';
            out += '</tbody>';
            $('.com_details').empty();
            $('.com_details').append(out);
        }

        $('.com_details').on('click','.final',function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            for (var i = 0; i < user_arr.length; i++) {
                user_arr[i].final = 'no';
            }
            user_arr[id].final = 'yes';
            display_quote_comp();
        });

    });
</script>