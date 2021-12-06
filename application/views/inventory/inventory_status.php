<link href="<?php echo base_url().'assets/css/tableexport.css'; ?>" rel="stylesheet">
<script src="<?php echo base_url().'assets/js/xlsx.core.min.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/FileSaver.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/tableexport.js'; ?>"></script>
<script src="<?php echo base_url().'assets/js/Blob.js'; ?>"></script>
<style type="text/css">
    .btn-default {
        background-color: green;
        color: #fff !important;
    }

    .btn-default:hover {
        color: #000 !important;
    }

    .bottom {
        margin-left: 45%;
    }

	a {
        color: #fff;
        text-decoration: none;
    }

    a:hover {
        color: #fff;
        text-decoration: none;
    }

    .ui-front {
        z-index: 2000;
    }

    .dhr_card {
        box-shadow: 0px 2px 5px #aaa;
        border-radius: 5px;
        padding:20px;
    }
    
    .dhr_card_title {
        text-align: left;
        padding-left: 15px;
        color: #aaa;
        font-weight: bold;
        font-size: 20px;
    }
    
    .dhr_card_content {
        font-size: 3em;
        padding: 30px;
        text-align: center;
        color: #666;
    }
    
    .product_input {
        border: 1px solid #999;
        border-radius: 3px;
        padding: 10px;
        text-align: center;
        margin-bottom: 10px;
        width: 70px;
    }
</style>
<main class="mdl-layout__content">
    <div class="mdl-grid">
	    <div class="mdl-cell mdl-cell--12-col">
            <button class="mdl-button mdl-js--button mdl-button--colored inv_home" category="0"><i class="material-icons">home</i></button>
            <button class="mdl-button mdl-js--button mdl-button--colored back" category="0"><i class="material-icons">arrow_back_ios</i></button>
            
            <div class="dhr_card" style="height:550px; overflow:auto;">
                <table class="general_table" id="main_category">
                    <?php 
                        for($i=0;$i<count($categories);$i++) {
                            echo '<tr id="'.$categories[$i]->iproc_id.'" type="category"><td colspan="7"><i class="material-icons">category</i> '.$categories[$i]->iproc_name.'</td></tr>';
                        } 
                        for($i=0;$i<count($product);$i++) {
                            echo '<tr id="'.$product[$i]['id'].'" type="product"><td>'.$product[$i]['name'].'</td><td>Limit: ';
                            if ($product[$i]['limit'] == '' || $product[$i]['limit'] == null) {
                                echo 0;
                            }else{
                                echo $product[$i]['limit'].'</td>';
                            }
                            $m = $product[$i]['stock'];
                            for($j=0;$j<count($m);$j++) {
                                echo '<td>'.$m[$j]['account'].' : '.$m[$j]['bal'].'</td>';
                            }
                            echo '<td><input type="text" id="" class="product_input" value="" product="'.$product[$i]['id'].'"><button class="mdl-button mdl-js--button mdl-button--colored mdl-button--raised product_qty_accept" prod_name="'.$product[$i]['name'].'" id="'.$product[$i]['id'].'"><i class="material-icons">add</i> Qty</button></td></tr>';
                        }
                    ?>
                </table>
            </div>
	    </div>
	</div>
	<div class="mdl-grid">
	    <div class="mdl-cell mdl-cell--12-col">
	        <button class="mdl-button mdl-js--button mdl-button--raised mdl-button--colored" id="add_inventory"><i class="material-icons">add</i> Inventory Records</button>
	        <button class="mdl-button mdl-js--button" id="add_accounts"><i class="material-icons">receipt</i> Manage Accounts</button>
	        <button class="mdl-button mdl-js--button" id="view_txns"><i class="material-icons">explore</i> View Transactions</button>
	        <button class="mdl-button mdl-js--button" id="view_order_list"><i class="material-icons">shopping_cart</i> Order List</button>
	    </div>
	</div>
	<div id="demo-snackbar-example" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>
</div>
</div>
<div id="add_inventory_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Inventory</h4>
            </div>
            <div class="modal-body">
                <div id="info_repea" class="mdl-grid">
					<div class="mdl-cell mdl-cell--6-col">
					    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="from_switch">
                            <input type="checkbox" id="from_switch" class="mdl-switch__input" checked>
                            <span class="mdl-switch__label">On: Contacts<br>Off: Inventory Accounts</span>
                        </label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="from_inv_account" class="mdl-textfield__input">
    						<input type="text" id="from_inv_account_sec" style="display:none;">
    						<label class="mdl-textfield__label" for="from_inv_account">Search From</label>
    					</div>
                    </div>
					<div class="mdl-cell mdl-cell--6-col">
					    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="to_switch">
                            <input type="checkbox" id="to_switch" class="mdl-switch__input" checked>
                            <span class="mdl-switch__label">On: Contacts<br>Off: Inventory Accounts</span>
                        </label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="to_inv_account" class="mdl-textfield__input">
    						<input type="text" id="to_inv_account_sec" style="display:none;">
    						<label class="mdl-textfield__label" for="to_inv_account">Search To</label>
    					</div>
                    </div>
					<div class="mdl-cel mdl-cell--12-col">
					    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="i_txn_date" class="mdl-textfield__input">
    						<label class="mdl-textfield__label" for="i_txn_date">Select Date</label>
    					</div>
					</div>
					<div class="mdl-cel mdl-cell--12-col">
					    <label>Add Items to Inventory</label>
					</div>
					<hr>
					<div class="mdl-cel mdl-cell--4-col">
					    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="prod" class="mdl-textfield__input">
    						<label class="mdl-textfield__label" for="prod">Search Products</label>
    					</div>
					</div>
					<div class="mdl-cel mdl-cell--3-col">
					    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="prod_qty" class="mdl-textfield__input" value="">
    						<label class="mdl-textfield__label" for="prod_qty">Qty</label>
    					</div>
					</div>
                    <div class="mdl-cel mdl-cell--4-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
                            <input type="text" id="prod_sn" class="mdl-textfield__input" placeholder="Serial Number">
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="prod_multiple_sn_check"> <span class="mdl-switch__label">Turn on for multiple S/N</span><input type="checkbox" id="prod_multiple_sn_check" class="mdl-switch__input"> </label>
                            <!-- <label class="mdl-textfield__label" for="prod">Serial Number</label> -->
                        </div>
                    </div>
					<div class="mdl-cel mdl-cell--1-col" style="margin-top:12px;margin-left:0%;padding:0px;">
						<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" id="add_item"><i class="material-icons">add</i></button>
					</div>
				</div>
				<div class="mdl-grid">
					<table class="general_table" id="order_table">
						<thead>
							<tr>
								<th>Product</th>
								<th>Qty</th>
                                <th>S/n</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								
							</tr>
						</tbody>
					</table>
				</div>
				
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-js-button" data-dismiss="modal">Close</button>
                <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" data-dismiss="modal" id="save_order_list">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="add_account_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Inventory Account</h4>
            </div>
            <div class="modal-body">
                <div id="info_repea" class="mdl-grid">
					<div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="add_account" class="mdl-textfield__input">
    						<label class="mdl-textfield__label" for="add_account">Name</label>
    					</div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
                            <input type="text" id="add_barcode" class="mdl-textfield__input" state="0">
                            <label class="mdl-textfield__label" for="add_account">Barcode</label>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <button class="mdl-button mdl-js--button mdl-button--colored mdl-button--raised" id="account_save" state="0"><i class="material-icons">done</i> Save</button>
                    </div>
				</div>
				<div class="mdl-grid">
					<table class="general_table" id="accounts_table">
						<thead>
							<tr>
								<th>Accounts</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
				
            </div>
        </div>
    </div>
</div>
<div id="view_txn_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Inventory Transactions</h4>
            </div>
            <div class="modal-body">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--6-col">
					    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="search_switch">
                            <input type="checkbox" id="search_switch" class="mdl-switch__input" checked>
                            <span class="mdl-switch__label">On: Contacts<br>Off: Inventory Accounts</span>
                        </label>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="search_inv_account" class="mdl-textfield__input">
    						<input type="text" id="search_inv_account_sec" style="display:none;">
    						<label class="mdl-textfield__label" for="search_inv_account">Search Account/ Contact</label>
    					</div>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="search_inv_product" class="mdl-textfield__input">
    						<label class="mdl-textfield__label" for="search_inv_product">Product Name</label>
    					</div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="search_inv_from" class="mdl-textfield__input">
    						<label class="mdl-textfield__label" for="search_inv_from">From Date</label>
    					</div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width:90%;">
    						<input type="text" id="search_inv_to" class="mdl-textfield__input">
    						<label class="mdl-textfield__label" for="from_inv_to">To Date</label>
    					</div>
                    </div>
                    
                    <div class="mdl-cell mdl-cell--6-col">
                        <button class="mdl-button mdl-js--button mdl-button--colored mdl-button--raised" id="search_inv_txns"><i class="material-icons">search</i> Search Records</button>
                    </div>
				</div>
				<div class="mdl-grid">
					<table class="general_table" id="txns_table">
						<thead>
							<tr>
								<th>From</th>
								<th>To</th>
								<th>Date</th>
								<th>Product</th>
								<th>Qty</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot>
						    <tr>
						        <th colspan="4">Balance</th>
						        <th id="txn_search_total"></th>
						    </tr>
						</tfoot>
					</table>
				</div>
				
            </div>
        </div>
    </div>
</div>
<div id="view_order_list_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">View Order List</h4>
            </div>
            <div class="modal-body">
                <div class="mdl-grid">
					<table class="general_table" id="order_item_table">
						<thead>
							<tr>
								<th>Products</th>
								<th>Qty</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button mdl-js-button" data-dismiss="modal" id="clear_order_list">Clear Order List</button>
                <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="download">Download</button>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    var inv_new_list=[]; var inv_sel_rec=0; var inv_sel_flg=false;
    var inv_order_list=[];
	$(document).ready(function() {
	    var snackbarContainer = document.querySelector('#demo-snackbar-example');
	    var inv_accounts=[]; var sel_inv_account=0;
	    
	    
	    $('#i_txn_date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	    var dt = new Date();
    	var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
    	$('#i_txn_date').val(s_dt);
	    
	    $('#search_inv_from').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	    var dt = new Date();
    	var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
    	$('#search_inv_from').val(s_dt);
	    
	    $('#search_inv_to').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	    var dt = new Date();
    	var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
    	$('#search_inv_to').val(s_dt);
	    
	    <?php for($i=0;$i<count($accounts);$i++) { 
	        echo 'inv_accounts.push({"iia_id" : "'.$accounts[$i]->iia_id.'","iia_name" : "'.$accounts[$i]->iia_name.'", "iia_star" : "'.$accounts[$i]->iia_star.'" });';
	        echo 'load_inv_accounts(inv_accounts);';
	    }?>
	    
	    var product_data = [];
    	
    	<?php for ($i=0; $i < count($products) ; $i++) { 
    		echo "product_data.push('".$products[$i]->ip_product."');";
    	}?>
    	
    	$( "#prod" ).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(product_data, request.term);
                response(results.slice(0, 10));
            }
        });
        
	    $( "#search_inv_product" ).autocomplete({
            source: function(request, response) {
                var results = $.ui.autocomplete.filter(product_data, request.term);
                response(results.slice(0, 10));
            }
        });
	    
        $("#from_inv_account").autocomplete({
            source: function( request, response ) {
                var url="";
                if($('#from_switch')[0].checked == true) {
                    url="<?php echo base_url().'Inventory/inventory_new_get_list/'.$code.'/c'; ?>";
                } else {
                    url="<?php echo base_url().'Inventory/inventory_new_get_list/'.$code.'/i'; ?>";
                }
                $.post(url, {
                    'term' : request.term
                }, function(d,s,x) {
                    var a=JSON.parse(d);
                    response(a);
                });
            },
            minLength: 2,
            focus: function(e,u) {
                $(this).val(u.item.label);
                $('#from_inv_account_sec').val(u.item.value);
                return false;
            },select: function(e,u) {
                $(this).val(u.item.label);
                $('#from_inv_account_sec').val(u.item.value);
                return false;
            }
        });
        
        $("#to_inv_account").autocomplete({
            source: function( request, response ) {
                var url="";
                if($('#to_switch')[0].checked == true) {
                    url="<?php echo base_url().'Inventory/inventory_new_get_list/'.$code.'/c'; ?>";
                } else {
                    url="<?php echo base_url().'Inventory/inventory_new_get_list/'.$code.'/i'; ?>";
                }
                $.post(url, {
                    'term' : request.term
                }, function(d,s,x) {
                    var a=JSON.parse(d);
                    response(a);
                });
            },
            minLength: 2,
            focus: function(e,u) {
                $(this).val(u.item.label);
                $('#to_inv_account_sec').val(u.item.value);
                return false;
            },select: function(e,u) {
                $(this).val(u.item.label);
                $('#to_inv_account_sec').val(u.item.value);
                return false;
            }
        });
        
        $("#search_inv_account").autocomplete({
            source: function( request, response ) {
                var url="";
                if($('#search_switch')[0].checked == true) {
                    url="<?php echo base_url().'Inventory/inventory_new_get_list/'.$code.'/c'; ?>";
                } else {
                    url="<?php echo base_url().'Inventory/inventory_new_get_list/'.$code.'/i'; ?>";
                }
                $.post(url, {
                    'term' : request.term
                }, function(d,s,x) {
                    var a=JSON.parse(d);
                    response(a);
                });
            },
            minLength: 2,
            focus: function(e,u) {
                $(this).val(u.item.label);
                $('#search_inv_account_sec').val(u.item.value);
                return false;
            },select: function(e,u) {
                $(this).val(u.item.label);
                $('#search_inv_account_sec').val(u.item.value);
                return false;
            }
        });

        $('#add_inventory').click(function(e) {
            e.preventDefault();
            $('#add_inventory_modal').modal('toggle');
        })
        
        $('#add_accounts').click(function(e) {
            e.preventDefault();
            $('#add_account_modal').modal('toggle');
        })
        
        $('#view_txns').click(function(e) {
            e.preventDefault();
            $('#view_txn_modal').modal('toggle');
        })

        $('#add_barcode').keyup(function(e) {
            e.preventDefault();
            if (e.keyCode == 13) {
                var id = $(this).attr('state');
                save_account(id);
            }
        });
        
        $('#account_save').click(function(e) {
            e.preventDefault();
            var id = $(this).attr('state');
            save_account(id);
        });

        function save_account(id){
            var url="";
            if( id == '0') {
                url='<?php echo base_url()."Inventory/save_inventory_new_account/".$code; ?>';
            } else {
                url='<?php echo base_url()."Inventory/save_inventory_new_account/".$code.'/'; ?>' + sel_inv_account;
            }
            $.post(url, {
                'n' : $('#add_account').val(),
                'b' : $('#add_barcode').val()
            }, function(d,s,x) {
                var a=JSON.parse(d), b="";
                inv_accounts=[];
                $("#add_account").val('');
                $("#add_barcode").val('');
                $(this).attr('state','0');
                inv_accounts=a;
                load_inv_accounts(a);
            });
        }

		$('#accounts_table').on('click','.account_edit', function(e) {
		    e.preventDefault();
		    sel_inv_account = $(this).prop('id');
		    $('#add_account').val(inv_accounts[$(this).attr('index')].iia_name);
            $('#add_barcode').val(inv_accounts[$(this).attr('index')].iia_barcode);
		    $('#account_save').attr('state','1');
		}).on('click','.account_delete', function(e) {
		    e.preventDefault();
		    $.post('<?php echo base_url()."Inventory/delete_inventory_new_account/".$code."/"; ?>' + $(this).prop('id'), function(d,s,x) {
		        var a=JSON.parse(d), b="";
                inv_accounts=[];
                $("#add_account").val();
                $("#add_barcode").val();
                $(this).attr('state','0');
                inv_accounts=a;
                load_inv_accounts(a);
		    })
		}).on('click','.account_star', function(e) {
		    e.preventDefault();
		    $.post('<?php echo base_url()."Inventory/star_inventory_new_account/".$code."/"; ?>' + $(this).prop('id'), function(d,s,x) {
		        var a=JSON.parse(d), b="";
                inv_accounts=[];
                $("#add_account").val();
                $("#add_barcode").val();
                inv_accounts=a;
                load_inv_accounts(a);
		    })
		});

		$('#main_category').on('click','tr', function(e) {
            e.preventDefault();
            if($(this).attr('type') == "category") {
                load_inv_list($(this).prop('id'));
            }
        })
        
        $('.back').click(function(e) {
            e.preventDefault();
            load_inv_list($(this).attr('category'));
        })
        
        $('.inv_home').click(function(e) {
            e.preventDefault();
            load_inv_list($(this).attr('category'));
        })
        
        $('#add_item').click(function(e) {
            e.preventDefault();
            add_to_order_list($('#prod').val(), $('#prod_qty').val(),$('#prod_sn').val());
        })
        
        $('#prod_qty').keyup(function(e) {
            if(e.keyCode == 13) {
                add_to_order_list($('#prod').val(), $('#prod_qty').val(),$('#prod_sn').val());
            }
        })

        $('#prod_sn').keyup(function(e) {
            if(e.keyCode == 13) {
                add_to_order_list($('#prod').val(), $('#prod_qty').val(),$('#prod_sn').val());
            }
        })
        
        $('#order_table').on('click','.edit_order_list', function(e) {
            e.preventDefault();
            inv_sel_rec=$(this).prop('id');
            inv_sel_flg=true
            $('#prod').val(inv_new_list[inv_sel_rec].p);
            $('#prod_qty').val(inv_new_list[inv_sel_rec].q);
            $('#prod_sn').val(inv_new_list[inv_sel_rec].sn);
            $('#prod').focus();
        })
        
        $('#order_table').on('click','.delete_order_list', function(e) {
            e.preventDefault();
            var x=$(this).prop('id');
            inv_new_list.splice(x,1);
            load_order_list(inv_new_list);
            reset_order_fields()
        })
        
        $('#save_order_list').click(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Inventory/save_inventory_new_records/".$code; ?>', {
                'f' : $('#from_inv_account_sec').val(),
                'f_t' : $('#from_switch')[0].checked,
                't' : $('#to_inv_account_sec').val(),
                't_t' : $('#to_switch')[0].checked,
                'd' : $('#i_txn_date').val(),
                'l' : inv_new_list,
                'from_name' : $('#from_inv_account').val(),
                'to_name' : $('#to_inv_account').val()
            }, function(d,s,x) {
                
            })
        })
        
        $('#search_inv_txns').click(function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Inventory/fetch_inventory_new_records/".$code; ?>', {
                'a_t' : $('#search_switch')[0].checked,
                'a' : $('#search_inv_account_sec').val(),
                'p' : $('#search_inv_product').val(),
                'f' : $('#search_inv_from').val(),
                't' : $('#search_inv_to').val()
            }, function(d,s,x) {
                var b="", a=JSON.parse(d), bal=0;
                $('#txns_table > tbody').empty();
                for(var i=0;i<a.length;i++) {
                    b+='<tr><td>';
                    if(a[i].from_type == "contact") {
                        b+=a[i].from_name;
                    }else{
                        b+=a[i].from_acc;
                    }
                    b+='</td><td>';
                    if(a[i].to_type == "contact") {
                        b+=a[i].to_name;
                    }else{
                        b+=a[i].to_acc;
                    }
                    b+='</td><td>' + a[i].dt + '</td><td>' + a[i].product + '</td><td>';

                    var xs = "";
                    if($('#search_switch')[0].checked == true) {
                        xs = "contact";
                    } else {
                        xs = "account";
                    }

                    if($('#search_inv_account_sec').val() == a[i].frm && xs == a[i].from_type) {
                        b+= '-('+a[i].qty+')';
                        bal-=parseInt(a[i].qty);
                    } else {
                        bal+=parseInt(a[i].qty);
                        b+=a[i].qty;
                    }
                    b+='</td></tr>';
                }
                $('#txns_table > tbody').append(b);
                $('#txn_search_total').empty(); $('#txn_search_total').append(bal);
            });
        })
        
        $('#main_category').on('click','.product_qty_accept', function(e) {
            e.preventDefault();
            var pid = $(this).prop('id');
            var qty = '[product="' + pid + '"]';
            $.post('<?php echo base_url()."Inventory/inventory_new_order_list_update/".$code; ?>', {
                'p' : pid,
                'q' : $(qty).val()
            }, function(d,s,x) {
                var ert = {message: "Qty Added.",timeout: 1000, }; 
                snackbarContainer.MaterialSnackbar.showSnackbar(ert); 
            }).fail(function(r) {
                var ert = {message: "Please try again.",timeout: 1000, }; 
                snackbarContainer.MaterialSnackbar.showSnackbar(ert);
            })
        })
        
        $('#order_item_table').on('click','.order_item_table_delete', function(e) {
            e.preventDefault();
            $.post('<?php echo base_url()."Inventory/inventory_new_delete_order_item/".$code; ?>', {
                'i' : $(this).prop('id')
            }, function(d,s,x) {
                var a=JSON.parse(d);
                var ert = {message: "Please wait.",timeout: 2000, }; 
                snackbarContainer.MaterialSnackbar.showSnackbar(ert);
                
                var b="";
                $('#order_item_table > tbody').empty();
                for(var i=0;i<a.length;i++) {
                    b+='<tr><td>' + a[i].ip_name + '</td><td>' + a[i].iino_qty + '</td><td>' + a[i].iino_date + '</td><td><button class="mdl-button mdl-js--button mdl-button--colored order_item_table_delete" id="' + a[i].iino_id + '"><i class="material-icons">delete</i></button></td></tr>';
                }
                $('#order_item_table > tbody').append(b);
            })
        })
        
        $('#view_order_list').click(function(e) {
            e.preventDefault();
            
            $.post('<?php echo base_url()."Inventory/inventory_new_fetch_order_list/".$code; ?>', function(d,s,x) {
                var a=JSON.parse(d);
                var ert = {message: "Please wait.",timeout: 2000, }; 
                snackbarContainer.MaterialSnackbar.showSnackbar(ert);
                
                var b="";
                $('#order_item_table > tbody').empty();
                for(var i=0;i<a.length;i++) {
                    b+='<tr><td>' + a[i].ip_product + '</td><td>' + a[i].iino_qty + '</td><td>' + a[i].iino_date + '</td><td><button class="mdl-button mdl-js--button mdl-button--colored order_item_table_delete" id="' + a[i].iino_id + '"><i class="material-icons">delete</i></button></td></tr>';
                }
                $('#order_item_table > tbody').append(b);
                
                setTimeout(function() {
                    $('#view_order_list_modal').modal('toggle');    
                }, 2000);
            })
        })
        
        $('#clear_order_list').click(function(e) {
            e.preventDefault();
            
            $.post('<?php echo base_url()."Inventory/inventory_new_clear_order_list/".$code; ?>', function(d,s,x) {
                var ert = {message: "Please wait.",timeout: 2000, }; 
                snackbarContainer.MaterialSnackbar.showSnackbar(ert);
                
                $('#order_item_table > tbody').empty();
                setTimeout(function() {
                    $('#view_order_list_modal').modal('toggle');    
                }, 2000);
            })
        })
        
        $('#fixed-header-drawer-exp').keyup(function(e) {
            $.post('<?php echo base_url()."Inventory/inventory_new_search_product_category_child/".$code; ?>', {
                'pn' : $(this).val()
            }, function(d,s,x) {
                var a=JSON.parse(d);
                display_inv_list_data(a);
            });
        });

        function add_to_order_list(p, q, sn) {
            if(inv_sel_flg==false) {
                inv_new_list.push({'p' : p, 'q' : q , 'sn' : sn});
            } else {
                inv_new_list[inv_sel_rec].p = p;
                inv_new_list[inv_sel_rec].q = q;
                inv_new_list[inv_sel_rec].sn = sn;
                inv_sel_rec=0;
                inv_sel_flg=false;
            }
            load_order_list(inv_new_list);
            reset_order_fields();
        }
        
        function load_order_list(a) {
            $('#order_table > tbody').empty();
            var b="";
            for(var i=0;i<a.length;i++) {
                b+='<tr><td>' + a[i].p + '</td><td>' + a[i].q + '</td><td>' + a[i].sn + '</td><td><button class="mdl-button mdl-js--button mdl-button--colored edit_order_list" id="' + i + '"><i class="material-icons">create</i></button><button class="mdl-button mdl-js--button mdl-button--colored delete_order_list" id="' + i + '"><i class="material-icons">delete</i></button></td></tr>';
            }
            $('#order_table > tbody').append(b);
        }
        
        function reset_order_fields() {
            if($('#prod_multiple_sn_check')[0].checked == true) {
                $('#prod_sn').val(null);
                $('#prod_sn').focus();
            }else{
                $('#prod').val(null);
                $('#prod_qty').val(null);
                $('#prod').focus();
            }
        }
        
        function load_inv_list(catid) {
            $.post('<?php echo base_url()."Inventory/inventory_new_get_product_category_child/".$code."/"; ?>' + catid,
            function(d,s,x){
                var a=JSON.parse(d);
                display_inv_list_data(a);
            });
        }
        
        function display_inv_list_data(a) {
            var b="";
            $('#main_category > tbody').empty();
            for(var i=0;i<a.category.length;i++) {
                b+='<tr id="' + a.category[i].iproc_id + '" type="category"><td colspan="7"><i class="material-icons">category</i> ' + a.category[i].iproc_name + '</td></tr>';
            }

            for(var i=0;i<a.product.length;i++) {
                b+='<tr id="' + a.product[i].id + '" type="product"><td>' + a.product[i].name + '</td><td>Limit: ';
                 // +  + 
                if (a.product[i].limit == '' || a.product[i].limit == null) {
                    b+= 0;
                }else{
                    b+= a.product[i].limit;
                }
                b+= '</td>';
                var m=a.product[i].stock;
                for(var j=0;j<m.length;j++) {
                    b+='<td>' + m[j].account + ': ' + m[j].bal + '</td>';
                }
                b+='<td><input type="text" id="" class="product_input" value="" product="' + a.product[i].id + '"><button class="mdl-button mdl-js--button mdl-button--colored mdl-button--raised product_qty_accept" prod_name="' + a.product[i].name + '" id="' + a.product[i].id + '"><i class="material-icons">add</i> Qty</button></td></tr>';
            }
            
            $('#main_category > tbody').append(b);
            $('.back').attr("category", a.parent);
        }
        
        function load_inv_accounts(a) {
            $('#accounts_table > tbody').empty();var b="";
            for(var i=0;i<a.length;i++) {
                b+='<tr><td>' + a[i].iia_name + '</td><td><button class="mdl-button mdl-js-button mdl-button--colored account_edit" id="' + a[i].iia_id +'" index="' + i + '"><i class="material-icons">create</i></button><button class="mdl-button mdl-js-button mdl-button--colored account_delete" id="' + a[i].iia_id +'" index="' + i + '"><i class="material-icons">delete</i></button><button class="mdl-button mdl-js-button mdl-button--colored account_star" id="' + a[i].iia_id +'" state="' + a[i].iia_star + '"><i class="material-icons">';
                if(a[i].iia_star=="1") {
                    // console.log("Here");
                    b+='star';
                } else {
                    b+='star_border';
                }
                b+='</i></button></td></tr>';
            }
            $('#accounts_table > tbody').append(b);
        }
        
        $('#download').click(function(e) {
		    e.preventDefault();
		    var dt1 = new Date();
		    
		    $('#order_item_table').tableExport({
                // Displays table headings (th or td elements) in the <thead>
                headings: true,                    
                // Displays table footers (th or td elements) in the <tfoot>    
                footers: true, 
                // Filetype(s) for the export
                formats: ["xls"],           
                // Filename for the downloaded file
                filename: 'Order List as on ' + dt.getDate() + '-' + (dt.getMonth() + 1) + '-' + dt.getFullYear(), 
                // Style buttons using bootstrap framework  
                bootstrap: true,                     
                // Position of the caption element relative to table
                position: "bottom",
                // (Number, Number[]), Row indices to exclude from the exported file(s)
                ignoreRows: null,       
                // (Number, Number[]), column indices to exclude from the exported file(s)              
                ignoreCols: null,                
                // Selector(s) to exclude cells from the exported file(s)       
                ignoreCSS: ".tableexport-ignore",  
                // Selector(s) to replace cells with an empty string in the exported file(s)       
                emptyCSS: ".tableexport-empty",   
                // Removes all leading/trailing newlines, spaces, and tabs from cell text in the exported file(s)     
                trimWhitespace: false
            });
		})
	});
</script>
</html>