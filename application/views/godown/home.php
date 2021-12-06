<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<style type="text/css">
    .jstree-contextmenu {
        z-index: 1 !important;
    }
    .pic_button {
        border-radius: 10px;
        box-shadow: 0px 4px 10px #ccc;
        margin: 20px;
        position: relative;
        overflow: hidden;
    }
</style>
<main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <button class="mdl-button add_location"><i class="material-icons">add</i> add location</button>
            <button class="mdl-button unlocated_product"><i class="material-icons">visibility</i> Un-located Products</button>
        </div>
        <div class="mdl-cell mdl-cell--12-col">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--10-col">
                    <input type="text" id="enter_val" class="mdl-textfield__input" placeholder="Enter barcode or product name" style="font-size: 2em;outline: none;">
                </div>
                <div class="mdl-cell mdl-cell--2-col" style="text-align: center;">
                    <button class="mdl-button mdl-button--colored mdl-button--raised search_det" ><i class="material-icons">search</i>search</button>
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--12-col gd_location">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--4-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;padding-top: 0px;height: 70vh;overflow: auto;">
                    <h3>Location</h3><hr>
                    <div class="gd_cat_list"></div>
                </div>
                <div class="mdl-cell mdl-cell--8-col" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;padding-top: 0px;height: 70vh;overflow: auto;">
                    <h3>Product Details</h3>
                    <div class="folder_display"></div>
                    <hr>
                    <table class="general_table">
                        <thead><tr><th>Sr. No.</th><th>Product</th><th>Serial Number</th><th>Qty</th><th>Location</th></tr></thead>
                        <tbody class="product_details_list"><tr><td colspan="5" style="text-align: center;">No records found !</td></tr></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--12-col gd_pro_list" style="background-color: #fff;border-radius: 10px;box-shadow: 0px 4px 10px #ccc; padding: 30px;height: 75vh;display: none;overflow: auto;">
            <table class="general_table">
                <thead><tr><th>Sr. No.</th><th>Product</th><th>Serial Number</th><th>Date</th></tr></thead>
                <tbody class="product_list"></tbody>
            </table>
        </div>
    </div>
</main>
<script type="text/javascript">
    var arrayCollection = [];
    var product_data = [];
     <?php
        if (isset($gd_temp)) {
            for ($i=0; $i < count($gd_temp) ; $i++) { 
                echo "arrayCollection.push({'id' : '".$gd_temp[$i]->id."','parent' : '".$gd_temp[$i]->parent."','text' : '".$gd_temp[$i]->text."', 'loc_barcode' : '".$gd_temp[$i]->barcode."'});";
            }
        }

        for ($i=0; $i < count($products) ; $i++) { 
            echo "product_data.push('".$products[$i]->ip_product."');";
        }
    ?>
    $(document).ready(function(){
        if (arrayCollection.length > 0 ) {
            add_location_display();
        }

        $('.unlocated_product').click(function(e){
            e.preventDefault();
            window.location = '<?php echo base_url().'Godown/unlocated_product/'.$code; ?>';
        });

        $('.add_location').click(function(e){
            e.preventDefault();
            window.location = '<?php echo base_url().'Godown/add_location/'.$code; ?>';
        });

        $( "#enter_val" ).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(product_data, request.term);
                response(results.slice(0, 10));
            }
        });

        function add_location_display(){
            $(".gd_cat_list").jstree({"core": {"check_callback": true,"data": arrayCollection},"plugins": ["json_data","contextmenu","dnd"]});

            var tree = $(".gd_cat_list");
            tree.bind("loaded.jstree", function (event, data) {
                tree.jstree("open_all");
            });
        }

        $('.gd_cat_list').click(function (e, data) {
            sel_id = $(this).jstree('get_selected');
            $('.loader').show();
            var barcode = 0;
            for (var i = 0; i < arrayCollection.length; i++) {
                if (arrayCollection[i].id == sel_id[0]) {
                    barcode = arrayCollection[i].loc_barcode;
                }
            }
            $.post('<?php echo base_url().'Godown/search_on_click_location/'.$code; ?>',{
                'val' : barcode,
                'arr_col' : arrayCollection
            },function(data,xhr,status){
                var a = JSON.parse(data);
                $('.loader').hide();
                $('.gd_location').css('display','block');
                $('.gd_cat_list').css('display','block');
                $('.gd_pro_list').css('display','none');
                var out = '';
                for (var ij = 0; ij < arrayCollection.length; ij++) {
                    if (sel_id[0] == arrayCollection[ij].parent) {
                        out += '<button class="mdl-button mdl-button--colored pic_button" style="height:5em;color:black;"><p style="text-align:center;font-size:1em;">'+arrayCollection[ij].text+'</p></button>';
                    }
                }
                $('.folder_display').empty();
                $('.folder_display').append(out);
                var out = '';
                var sr_flg = 0;
                if (a.pro_data.length > 0 ) {
                    for (var j = 0; j < a.pro_data.length; j++) {
                        if(a.pro_data[j].qty != 0) {
                            sr_flg++;
                            out += '<tr>';
                            out += '<td>'+sr_flg+'</td><td>'+a.pro_data[j].pname+'</td>';
                            if (a.pro_data[j].sn == null) {
                                out += '<td>-</td>';
                            }else{
                                out += '<td>'+a.pro_data[j].sn+'</td>';
                            }
                            var loc_name = '';
                            for (var ij = 0; ij < arrayCollection.length; ij++) {
                                if(arrayCollection[ij].loc_barcode == a.pro_data[j].loc){
                                    loc_name = arrayCollection[ij].text;
                                }
                            }
                            out += '<td>'+a.pro_data[j].qty+'</td>';
                            out += '<td>'+loc_name+'</td>';
                            out += '</tr>';
                        }   
                    }
                }else{
                    var out = '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
                }
                $('.product_details_list').empty();
                $('.product_details_list').append(out);
            });
        });

        $('#enter_val').keyup(function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                serach_details();
            }
        });

        $('.search_det').click(function(e){
            e.preventDefault();
            serach_details();
        });

        function serach_details(){
            $('.loader').show();
            $.post('<?php echo base_url().'Godown/search_location/'.$code; ?>',{
                'val' : $('#enter_val').val(),
                'arr_col' : arrayCollection
            },function(data,xhr,status){
                var a = JSON.parse(data);
                console.log(a);
                $('.loader').hide();
                if (a.inventory.length > 0 ) {
                    $('.gd_location').css('display','block');
                    $('.gd_cat_list').css('display','block');
                    $('.gd_pro_list').css('display','none');
                    for (var ij = 0; ij < arrayCollection.length; ij++) {
                        $('.gd_cat_list').jstree(true).deselect_node(arrayCollection[ij].id);
                    }
                    var id = 0;
                    for (var i = 0; i < a.inventory.length; i++) {
                        id = 0;
                        for (var ij = 0; ij < arrayCollection.length; ij++) {
                            if(arrayCollection[ij].loc_barcode == a.inventory[i].iin_location){
                                id = arrayCollection[ij].id;
                            }
                        }
                        $('.gd_cat_list').jstree(true).select_node(id);
                    }
                    var out = '';
                    for (var ij = 0; ij < arrayCollection.length; ij++) {
                        if (id == arrayCollection[ij].parent) {
                            out += '<button class="mdl-button mdl-button--colored pic_button" style="height:5em;color:black;"><p style="text-align:center;font-size:1em;">'+arrayCollection[ij].text+'</p></button>';
                        }
                    }
                    $('.folder_display').empty();
                    $('.folder_display').append(out);
                    var out = '';
                    var sr_flg = 0;
                    if (a.pro_data.length > 0 ) {
                        for (var j = 0; j < a.pro_data.length; j++) {
                            if (a.pro_data[j].qty != 0) {
                                sr_flg++;
                                out += '<tr>';
                                out += '<td>'+sr_flg+'</td><td>'+a.pro_data[j].pname+'</td>';
                                if (a.pro_data[j].sn == null) {
                                    out += '<td>-</td>';
                                }else{
                                    out += '<td>'+a.pro_data[j].sn+'</td>';
                                }
                                out += '<td>'+a.pro_data[j].qty+'</td>';
                                var loc_name = '';
                                for (var ij = 0; ij < arrayCollection.length; ij++) {
                                    if(arrayCollection[ij].loc_barcode == a.pro_data[j].loc){
                                        loc_name = arrayCollection[ij].text;
                                    }
                                }
                                out += '<td>'+loc_name+'</td>';
                                out += '</tr>';
                            }
                        }
                    }
                    $('.product_details_list').empty();
                    $('.product_details_list').append(out);
                }else{
                    console.log(a);
                    $('.gd_location').css('display','none');
                    $('.gd_pro_list').css('display','block');
                    var out = '<tr><td colspan="5" style="text-align:center;">No records found !</td></tr>';
                    $('.product_list').empty();
                    $('.product_list').append(out);
                }
            },'text')
        }
    });
</script>