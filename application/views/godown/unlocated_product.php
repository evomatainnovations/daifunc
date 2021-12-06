<main class="mdl-layout__content">
   <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col">
            <button class="mdl-button add_godown"><i class="material-icons">compare_arrows</i> transfer product to location</button>
            <button class="mdl-button from_add_godown"><i class="material-icons">compare_arrows</i> transfer product to account</button>
        </div>
        <div class="mdl-cell mdl-cell--12-col"  style="overflow: auto;">
            <table class="general_table" style="width: 100%;overflow: auto;">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Product Name</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody id="details">
                    <?php
                        if (isset($inventory) || isset($inventory_acc)) {
                            $sr_no=0;
                            for ($i=0; $i < count($inventory_acc) ; $i++) {
                                $sr_no++;
                                echo '<tr class="tbl_view_outward" id="'.$i.'">';
                                echo '<td>'.$sr_no.'</td>';
                                echo '<td>'.$inventory_acc[$i]['a_name'].'</td>';
                                echo '<td>'.$inventory_acc[$i]['date'].'</td>';
                                echo '<td>'.$inventory_acc[$i]['pname'].'</td>';
                                echo '<td>'.$inventory_acc[$i]['bal'].'</td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<div class="modal fade" id="add_product_to_location" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col"><h3>Manage product location</h3></div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="acc_name">
                            <label class="mdl-textfield__label" for="acc_name">From Inventory Account</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="loc_barcode">
                            <label class="mdl-textfield__label" for="loc_barcode">To Location barcode or name</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="pro_qty">
                            <label class="mdl-textfield__label" for="pro_qty">Product QTY</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input type="text" id="pro_barcode" name="pro_barcode" class="mdl-textfield__input inv_prod" placeholder="Product barcode or name">
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="prod_multiple_sn_check"> <span class="mdl-switch__label">Turn on for multiple S/N</span><input type="checkbox" id="prod_multiple_sn_check" class="mdl-switch__input"> </label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <button class="mdl-button mdl-button--colored add_to_list"><i class="material-icons">add</i> add</button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col"><table class="general_table"><thead><tr><th>Sr. No.</th><th>Account</th><th>Location</th><th>Qty</th><th>Product</th><th>Action</th></tr></thead><tbody class="product_list"></tbody></table></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="save_loc">Save</button>
                <button type="button" class="mdl-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_product_to_account" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col"><h3>Manage product location</h3></div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="from_loc_barcode">
                            <label class="mdl-textfield__label" for="from_loc_barcode">From Location barcode or name</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="from_acc_name">
                            <label class="mdl-textfield__label" for="from_acc_name">To Inventory Account</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="from_pro_qty">
                            <label class="mdl-textfield__label" for="from_pro_qty">Product QTY</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input type="text" id="from_pro_barcode" name="pro_barcode" class="mdl-textfield__input inv_prod" placeholder="Product barcode or name">
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="from_prod_multiple_sn_check"> <span class="mdl-switch__label">Turn on for multiple S/N</span><input type="checkbox" id="from_prod_multiple_sn_check" class="mdl-switch__input"> </label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <button class="mdl-button mdl-button--colored from_add_to_list"><i class="material-icons">add</i> add</button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col"><table class="general_table"><thead><tr><th>Sr. No.</th><th>Account</th><th>Location</th><th>Qty</th><th>Product</th><th>Action</th></tr></thead><tbody class="from_product_list"></tbody></table></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-button--colored" data-dismiss="modal" id="from_save_loc">Save</button>
                <button type="button" class="mdl-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var loc_arr = [];
    var acc_arr = [];
    var pro_arr = [];
    var multi_sn = 'false';

    var pro_loc_arr = [];
    var arrayCollection = [];
     <?php
        if (isset($gd_temp)) {
            for ($i=0; $i < count($gd_temp) ; $i++) {
                echo "loc_arr.push('".$gd_temp[$i]->text."');";
                echo "arrayCollection.push({'id' : '".$gd_temp[$i]->id."','parent' : '".$gd_temp[$i]->parent."','text' : '".$gd_temp[$i]->text."', 'loc_barcode' : '".$gd_temp[$i]->barcode."'});";
            }
        }

        for ($i=0; $i < count($products) ; $i++) { 
            echo "pro_arr.push('".$products[$i]->ip_product."');";
        }

        for ($i=0; $i < count($inv_acc) ; $i++) {
            echo "acc_arr.push('".$inv_acc[$i]->iia_name."');";
        }
    ?>
    $(document).ready(function(){

        $("#acc_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(acc_arr, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#pro_barcode").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(pro_arr, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#loc_barcode").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(loc_arr, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                $('#pro_qty').focus();
            }
        });

        $('.add_godown').click(function(e){
            e.preventDefault();
            $('#add_product_to_location').modal('show');
            setTimeout(function(){
                $('#acc_name').focus();    
            },1000);
        });

        $('#prod_multiple_sn_check').change(function(e){
            e.preventDefault();
            if($('#prod_multiple_sn_check')[0].checked == true){
                multi_sn = 'true';
                $('#pro_qty').val('1');
            }else{
                multi_sn = 'false';
            }
        });

        $('#add_product_to_location').on('click','.add_to_list',function(e){
            e.preventDefault();
            add_barcode();
        });

        $('#add_product_to_location').on('keyup','#loc_barcode',function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                $('#pro_qty').focus();
            }
        });

        $('#add_product_to_location').on('keyup','#pro_barcode',function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                add_barcode();
            }
        });

        $('.product_list').on('click','.delete_barcode',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            pro_loc_arr.splice(id,1);
            display_barcode();
        });

        function add_barcode(){
            pro_loc_arr.push({'account' : $('#acc_name').val() ,'loc' : $('#loc_barcode').val() , 'qty' : $('#pro_qty').val() , 'pro' : $('#pro_barcode').val() });
            if (multi_sn == 'false') {
                $('#loc_barcode').val('');
                $('#pro_qty').val('');
                $('#acc_name').val('');
                $('#pro_barcode').val('');
                $('#acc_name').focus();
            }else{
                $('#pro_barcode').val('');
                $('#pro_barcode').focus();
            }
            display_barcode();
        }

        function display_barcode(){
            var out = '';
            var sr_no = 0;
            for (var i = 0; i < pro_loc_arr.length; i++) {
                sr_no++;
                out += '<tr><td>'+sr_no+'</td><td>'+pro_loc_arr[i].account+'</td><td>'+pro_loc_arr[i].loc+'</td><td>'+pro_loc_arr[i].qty+'</td><td>'+pro_loc_arr[i].pro+'</td>';
                out += '<td><button class="mdl-button mdl-button--colored delete_barcode" id="'+i+'"><i class="material-icons">delete</i></button></td>';
                out += '</tr>';
            }
            $('.product_list').empty();
            $('.product_list').append(out);
        }

        $('#add_product_to_location').on('click','#save_loc',function(e){
            e.preventDefault();
            $.post('<?php echo base_url().'Godown/save_product_location/'.$code; ?>',{
                'pro_loc_arr' : pro_loc_arr,
                'arr_loc' : arrayCollection
            },function(data,xhr,status){
                window.location = '<?php echo base_url()."Godown/unlocated_product/".$code."/";?>';
            },'text');
        });
// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $("#from_acc_name").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(acc_arr, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#from_pro_barcode").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(pro_arr, request.term);
                response(results.slice(0, 10));
            }
        });

        $("#from_loc_barcode").autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(loc_arr, request.term);
                response(results.slice(0, 10));
            },select: function(event, ui) {
                $('#from_acc_name').focus();
            }
        });

        $('.from_add_godown').click(function(e){
            e.preventDefault();
            $('#add_product_to_account').modal('show');
            setTimeout(function(){
                $('#from_loc_barcode').focus();
            },1000);
        });

        $('#from_prod_multiple_sn_check').change(function(e){
            e.preventDefault();
            if($('#from_prod_multiple_sn_check')[0].checked == true){
                multi_sn = 'true';
                $('#from_pro_qty').val('1');
            }else{
                multi_sn = 'false';
            }
        });

        $('#add_product_to_account').on('click','.from_add_to_list',function(e){
            e.preventDefault();
            from_add_barcode();
        });

        $('#add_product_to_account').on('keyup','#from_loc_barcode',function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                $('#from_pro_qty').focus();
            }
        });

        $('#add_product_to_account').on('keyup','#from_pro_barcode',function(e){
            e.preventDefault();
            if (e.keyCode == 13) {
                from_add_barcode();
            }
        });

        $('.from_product_list').on('click','.from_delete_barcode',function(e){
            e.preventDefault();
            var id = $(this).prop('id');
            pro_loc_arr.splice(id,1);
            from_display_barcode();
        });

        function from_add_barcode(){
            pro_loc_arr.push({'account' : $('#from_acc_name').val() ,'loc' : $('#from_loc_barcode').val() , 'qty' : $('#from_pro_qty').val() , 'pro' : $('#from_pro_barcode').val() });
            if (multi_sn == 'false') {
                $('#from_loc_barcode').val('');
                $('#from_pro_qty').val('');
                $('#from_acc_name').val('');
                $('#from_pro_barcode').val('');
                $('#from_acc_name').focus();
            }else{
                $('#from_pro_barcode').val('');
                $('#from_pro_barcode').focus();
            }
            from_display_barcode();
        }

        function from_display_barcode(){
            var out = '';
            var sr_no = 0;
            for (var i = 0; i < pro_loc_arr.length; i++) {
                sr_no++;
                out += '<tr><td>'+sr_no+'</td><td>'+pro_loc_arr[i].account+'</td><td>'+pro_loc_arr[i].loc+'</td><td>'+pro_loc_arr[i].qty+'</td><td>'+pro_loc_arr[i].pro+'</td>';
                out += '<td><button class="mdl-button mdl-button--colored from_delete_barcode" id="'+i+'"><i class="material-icons">delete</i></button></td>';
                out += '</tr>';
            }
            $('.from_product_list').empty();
            $('.from_product_list').append(out);
        }

        $('#add_product_to_account').on('click','#from_save_loc',function(e){
            e.preventDefault();
            $.post('<?php echo base_url().'Godown/save_product_location/'.$code.'/account'; ?>',{
                'pro_loc_arr' : pro_loc_arr,
                'arr_loc' : arrayCollection
            },function(data,xhr,status){
                console.log(data);
                // window.location = '<?php echo base_url()."Godown/unlocated_product/".$code."/";?>';
            },'text');
        });
    });
</script>