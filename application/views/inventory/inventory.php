<style>
.accordion {
    background-color: #fff;
    color: #444;
    cursor: pointer;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}
.active, .accordion:hover {
    box-shadow: 0px 5px 0px #ccc;
    border-radius: 10px;
}

.panel {
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    animation-duration: 12s;
}
</style>
<main class="mdl-layout__content">
    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--11-col">
            <button class="accordion btn-lg" style="font-size: 1.5em; text-align: left;box-shadow: 0px 5px 0px #ccc;border-radius: 10px;padding-top: 0px;"><i class="material-icons">filter_list</i> Filter Records</button>
            <div class="panel">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--2-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="Date" id="fr_date" name="from">
                            <label class="mdl-textfield__label" for="fr_date">From Date</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="Date" id="to_date" name="to">
                            <label class="mdl-textfield__label" for="to_date">To Date</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" >
                            <input class="mdl-textfield__input" type="text" id="inv_created">
                            <label class="mdl-textfield__label" for="inv_created">Created By</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <label class="mdl-textfield__label" for="in_status">Inventory status</label>
                            <select class="mdl-textfield__input" id="in_status">
                                <option value="">Select</option>
                                <?php for($i=0; $i < count($status); $i++) {
                                    if ($status[$i]->iextei_status != null && $status[$i]->iextei_status != "null") {
                                        echo '<option value="'.$status[$i]->iextei_status.'">'.$status[$i]->iextei_status.'</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--2-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <label class="mdl-textfield__label" for="in_type">Inventory Type</label>
                            <select class="mdl-textfield__input" id="in_type">
                                <?php for($i=0; $i < count($type); $i++) {
                                    echo '<option value="'.$type[$i]->iextei_type.'">'.$type[$i]->iextei_type.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col" style="text-align: center;">
                        <button class="mdl-button mdl-js-button mdl-button--raise mdl-button--colored" id="check"><i class="material-icons">search</i> Filter</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mdl-cell mdl-cell--1-col" style="text-align: right;">
            <button class="mdl-button" style="border-radius: 50px 50px;padding-top: 0px;" id="invoice_setting"><i class="material-icons" style="font-size: 2.5em;">settings</i></button>
        </div>
    </div>
    <div class="mdl-grid" style="margin-top: 0px;"> 
            <a href="<?php echo base_url().'Inventory/inventory_add/inward/'.$code.'/'.$mod_id; ?>">
                <button class="mdl-button" style="margin-left: 10px;"><i class="material-icons">arrow_downward</i> Add Inward</button>
            </a>
            <a href="<?php echo base_url().'Inventory/inventory_add/outward/'.$code.'/'.$mod_id; ?>">
                <button class="mdl-button" style="margin-left: 10px;"><i class="material-icons">arrow_upward</i> Add Outward</button>
            </a>
            <a href="<?php echo base_url().'Inventory/inventory_status/'.$code; ?>">
                <button class="mdl-button" style="margin-left: 10px;"><i class="material-icons">trending_up</i>Status</button>
            </a>
            <a href="<?php echo base_url().'Inventory/inventory_report/'.$code; ?>">
                <button class="mdl-button" style="margin-left: 10px;"><i class="material-icons">timeline</i>Analyse</button>
            </a>
            <!-- <a href="<?php //echo base_url().'Inventory/inventory_search_barcode/'.$code; ?>">
                <button class="mdl-button" style="margin-left: 10px;"><i class="material-icons">search</i>Search</button>
            </a> -->
    </div>
    <div class="mdl-grid">
        <table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">Txn No</th>
                    <th class="mdl-data-table__cell--non-numeric">Date</th>
                    <th class="mdl-data-table__cell--non-numeric">Customer</th>
                </tr>
            </thead>
            <tbody id="details">
                <?php
                    for ($i=0; $i < count($inventory) ; $i++) { 
                        if($inventory[$i]->iextei_type == "inward") {
                            echo '<tr style="color: #fff; background-color: #009933;font-weight: bold;" class="tbl_view_inward" id="'.$inventory[$i]->iextei_id.'">';
                            echo '<td class="mdl-data-table__cell--non-numeric">'.$inventory[$i]->iextei_txn_id.'</td>';
                            echo '<td class="mdl-data-table__cell--non-numeric">'.$inventory[$i]->iextei_txn_date.'</td>';
                            echo '<td class="mdl-data-table__cell--non-numeric">'.$inventory[$i]->ic_name.'</td>';
                            echo '</tr>';
                        } else if($inventory[$i]->iextei_type == "outward") {
                            echo '<tr style="color: #fff; background-color: #ff5050;font-weight: bold;" class="tbl_view_outward" id="'.$inventory[$i]->iextei_id.'">';
                            echo '<td class="mdl-data-table__cell--non-numeric">'.$inventory[$i]->iextei_txn_id.'</td>';
                            echo '<td class="mdl-data-table__cell--non-numeric">'.$inventory[$i]->iextei_txn_date.'</td>';
                            echo '<td class="mdl-data-table__cell--non-numeric">'.$inventory[$i]->ic_name.'</td>';
                            echo '</tr>';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
<div class="mdl-grid">
        <div class="mdl-cell mdl-cell--4-col"></div>
        <div class="mdl-cell mdl-cell--4-col">
            <a href="<?php echo base_url().'Enterprise/document_terms/Inventory/'.$code; ?>"><button class="mdl-button mdl-js-button mdl-button--raised" style="width: 100%;">Terms</button></a>
        </div>
        <div class="mdl-cell mdl-cell--4-col"></div>
</div>  
</main>
</div>
</body>

<script type="text/javascript">
    $(document).ready(function() {
        $( "#fr_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });
        $( "#to_date" ).bootstrapMaterialDatePicker({ weekStart : 0, time: false });

        $('#details').on('click', '.tbl_view_inward', (function(e) {
            e.preventDefault();
            var tid = $(this).prop('id');
            window.location = "<?php echo base_url().'Inventory/inventory_edit/inward/'.$code.'/'.$mod_id.'/'; ?>" + tid;
        }));

        $('#invoice_setting').click(function (e){
            e.preventDefault();
            window.location = "<?php echo base_url().'Enterprise/module_setting/Inventory_new/'.$code; ?>";
        });

        $('#details').on('click', '.tbl_view_outward', (function(e) {
            e.preventDefault();
            var tid = $(this).prop('id');
            window.location = "<?php echo base_url().'Inventory/inventory_edit/outward/'.$code.'/'.$mod_id.'/'; ?>" + tid;
        }));

        $('#fixed-header-drawer-exp').change(function(e) {
            e.preventDefault();

            $.post('<?php echo base_url()."Inventory/inventory_search/".$code; ?>', {
                'search' : $(this).val()
            }, function(data, status, xhr) {
                var abc = JSON.parse(data);

                $('#details').empty();
                var out = "";
                for (var i = 0; i < abc.inventory.length; i++) {
                    if(abc.inventory[i].iextei_type == "inward") {
                        out+='<tr style="color: #fff; background-color: #009933;font-weight: bold;" class="tbl_view_inward" id="' + abc.inventory[i].iextei_id +'">';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_id + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_date + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].ic_name + '</td>';
                        out+='</tr>';
                    }
                    if(abc.inventory[i].iextei_type == "outward"){
                        out+='<tr style="color: #fff; background-color: #ff5050;font-weight: bold;" class="tbl_view_outward" id="' + abc.inventory[i].iextei_id + '">';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_id + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].iextei_txn_date + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.inventory[i].ic_name + '</td>';
                        out+='</tr>';
                    }
                }
                $('#details').append(out);
            })
        });

        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
                if (panel.style.maxHeight){
                  panel.style.maxHeight = null;
                } else {
                  panel.style.maxHeight = panel.scrollHeight + "px";
                } 
            });
        }

        $('#check').click(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Inventory/inventory_filter/".$code; ?>', {
                'from' : $('#fr_date').val(),
                'to': $('#to_date').val(),
                'in_type'    : $('#in_type').val(),
                'in_status' : $('#in_status').val(),
                'inv_created' : $('#inv_created').val()
            }, function(data, status, xhr) {
                var abc = JSON.parse(data);
                console.log(abc);
                $('#details').empty();
                var out = "";
                for (var i = 0; i < abc.filter.length; i++) {
                    if(abc.filter[i].iextei_type == "inward") {
                        out+='<tr style="color: #fff; background-color: #009933;font-weight: bold;" class="tbl_view_inward" id="' + abc.filter[i].iextei_id +'">';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_id + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_date + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
                        out+='</tr>';
                    } else if(abc.filter[i].iextei_type == "outward") {
                        out+='<tr style="color: #fff; background-color: #ff5050;font-weight: bold;" class="tbl_view_outward" id="' + abc.filter[i].iextei_id + '">';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_id + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_date + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
                        out+='</tr>';
                    } else if(abc.filter[i].iextei_type == "spare") {
                        out+='<tr style="color: #fff; background-color: rgb(42, 136, 231);font-weight: bold;" class="tbl_view_spare" id="' + abc.filter[i].iextei_id + '">';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_id + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_date + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
                        out+='</tr>';
                    }else{
                        out+='<tr style="color: #fff; background-color: #ff5050;font-weight: bold;" class="tbl_view_outward" id="' + abc.filter[i].iextei_id + '">';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_id + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].iextei_txn_date + '</td>';
                        out+='<td class="mdl-data-table__cell--non-numeric">' + abc.filter[i].ic_name + '</td>';
                        out+='</tr>';
                    }
                }
                $('#details').append(out);
            })
        });
    })
</script>
</html>