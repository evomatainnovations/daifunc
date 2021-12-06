<div class="mdl-grid" style="width: 100%;">
	<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
		<?php
			if (isset($doc) && count($doc) > 0 ) {
				$d_flg = 0;
				for ($i=0; $i < count($doc) ; $i++) { 
					if ($doc[$i]->icd_type == 'profile') {
						$d_flg++;
						echo '<div class="person_icon" style="border: 1px solid #ccc;border-radius: 50%;height: 120px;width: 80%;margin-left: 10%;text-align: center;background: url('.base_url().'assets/uploads/'.$oid.'/'.$doc[$i]->icd_timestamp.');background-size:100%;"></div>';
					}
				}
				if ($d_flg == 0) {
					echo '<div class="person_icon" style="border: 1px solid #ccc;border-radius: 50%;height: 120px;width: 80%;margin-left: 10%;text-align: center;"><i class="material-icons" style="color: #ccc;font-size: 8em;">person</i></div>';
				}
			}else{
				echo '<div class="person_icon" style="border: 1px solid #ccc;border-radius: 50%;height: 120px;width: 80%;margin-left: 10%;text-align: center;"><i class="material-icons" style="color: #ccc;font-size: 8em;">person</i></div>';
			}
		?>
	</div>
	<div class="mdl-cell mdl-cell--8-col">
		<h2><?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_name; }?></h2>
		<h4><?php if(isset($edit_cust)) { echo $edit_cust[0]->ic_section; }?></h4>
	</div>
</div>
<div class="mdl-grid">
	<div class="panel-group" id="accordion" style="width: 100%;margin-left: 10px;">
		<div class="panel panel-default cust_details">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#cust_details">Details</a>
                </h4>
            </div>
            <div id="cust_details" class="panel-collapse collapse">
                <div class="panel-body">
            		<?php
                        if (isset($cust_details)) {
                            if (count($cust_details) > 0 ) {
                                echo '<div style="display: flex;"><div style="width: 10%;margin-left: 5px;"><i class="material-icons" style="margin: 0px;">location_city</i></div><div style="width: 20%;"><h4 style="margin: 0px;"> Address</h4></div><div style="width: 70%;text-align: center;">';
                                    for ($i=0; $i < count($cust_details) ; $i++) {
                                        for ($ij=0; $ij < count($address_prop) ; $ij++) {
                                            if ($cust_details[$i]->icbd_property == $address_prop[$ij]->ip_id ) {
                                                echo '<p style="text-align:left;">'.$cust_details[$i]->icbd_value.'</p>';
                                            }
                                        }
                                    }
                                echo '</div></div><hr>';   
                            }
                        }
                        if (isset($cust_details)) {
                            if (count($cust_details) > 0 ) {
                                echo '<div style="display: flex;"><div style="width: 10%;margin-left: 5px;"><i class="material-icons" style="margin: 0px;">phone</i></div><div style="width: 20%;"><h4 style="margin: 0px;"> Phone No.</h4></div><div style="width: 70%;text-align: center;">';
                                    for ($i=0; $i < count($cust_details) ; $i++) {
                                        for ($ij=0; $ij < count($phone_prop) ; $ij++) {
                                            if ($cust_details[$i]->icbd_property == $phone_prop[$ij]->ip_id ) {
                                                echo '<p style="text-align:left;">'.$cust_details[$i]->icbd_value.'</p>';
                                            }
                                        }
                                    }
                                echo '</div></div><hr>';   
                            }
                        }
                        if (isset($cust_details)) {
                            if (count($cust_details) > 0 ) {
                                echo '<div style="display: flex;"><div style="width: 10%;margin-left: 5px;"><i class="material-icons" style="margin: 0px;">alternate_email</i></div><div style="width: 20%;"><h4 style="margin: 0px;"> Email</h4></div><div style="width: 70%;text-align: center;">';
                                    for ($i=0; $i < count($cust_details) ; $i++) {
                                        for ($ij=0; $ij < count($email_prop) ; $ij++) {
                                            if ($cust_details[$i]->icbd_property == $email_prop[$ij]->ip_id ) {
                                                echo '<p style="text-align:left;">'.$cust_details[$i]->icbd_value.'</p>';
                                            }
                                        }
                                    }
                                echo '</div></div><hr>';   
                            }
                        }
                        if (isset($cust_details)) {
                            if (count($cust_details) > 0 ) {
                                echo '<div style="width: 100%;"><h4 style="margin: 0px;margin-bottom : 10px;"> Other Details</h4></div>';
                                    for ($i=0; $i < count($cust_details) ; $i++) {
                                        for ($ij=0; $ij < count($custom_prop) ; $ij++) {
                                            if ($cust_details[$i]->icbd_property == $custom_prop[$ij]->ip_id ) {
                                                echo '<div style="width: 100%;display:flex;"><p style="text-align:left;width:20%;">'.$custom_prop[$ij]->ip_property.'</p><p style="text-align:center;width:10%;"> : </p><p style="text-align:left;width:70%;">'.$cust_details[$i]->icbd_value.'</p></div>';
                                            }
                                        }
                                    }
                            }
                        }
                        if (isset($parent_cust)) {
                            if (count($parent_cust) > 0 ) {
                                echo '<hr>';
                                echo '<h4>Parent Contact</h4>';
                                for ($i = 0; $i < count($parent_cust); $i++) {
                                    echo '<div style="display:flex;"><h5 style="width:50%;font-weight:bold;text-align:center;">'.$parent_cust[$i]->rel.'</h5>';
                                    echo '<button class="mdl-button another_contact" style="width:50%;" id="'.$parent_cust[$i]->cid.'">'.$parent_cust[$i]->cname.'</button></div>';
                                }
                            }
                        }
                        if (isset($child_cust)) {
                            if (count($child_cust) > 0 ) {
                                echo '<hr>';
                                echo '<h4>Child Contact</h4>';
                                for ($i = 0; $i < count($child_cust); $i++) {
                                    echo '<div style="display:flex;"><h5 style="width:50%;font-weight:bold;text-align:center;">'.$child_cust[$i]->rel.'</h5>';
                                    echo '<button class="mdl-button another_contact" style="width:50%;" id="'.$child_cust[$i]->cid.'">'.$child_cust[$i]->cname.'</button></div>';
                                }
                            }
                        }
            		?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#activity">Activity</a>
                </h4>
            </div>
            <div id="activity" class="panel-collapse collapse">
                <div class="panel-body"><table id="activity_table" class="mdl-data-table mdl-js-data-table" style="width: 100%;"></table></div>
            </div>
        </div>
        <div class="panel panel-default invoice" style="display: none;">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#invoice">Invoice</a>
                </h4>
            </div>
            <div id="invoice" class="panel-collapse collapse">
                <div class="panel-body"><table id="invoice_table" class="mdl-data-table mdl-js-data-table" style="width: 100%;"></table></div>
            </div>
        </div>
        <div class="panel panel-default inventory" style="display: none;">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#inventory">Inventory</a>
                </h4>
            </div>
            <div id="inventory" class="panel-collapse collapse">
                <div class="panel-body"><table id="inventory_table" class="mdl-data-table mdl-js-data-table" style="width: 100%;"></table></div>
            </div>
        </div>
        <div class="panel panel-default amc" style="display: none;">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#amc">Subscription</a>
                </h4>
            </div>
            <div id="amc" class="panel-collapse collapse">
                <div class="panel-body"><table id="amc_table" class="mdl-data-table mdl-js-data-table" style="width: 100%;"></table></div>
            </div>
        </div>
        <div class="panel panel-default purchase" style="display: none;">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#purchase">Purchase</a>
                </h4>
            </div>
            <div id="purchase" class="panel-collapse collapse">
                <div class="panel-body"><table id="purchase_table" class="mdl-data-table mdl-js-data-table" style="width: 100%;"></table></div>
            </div>
        </div>
        <div class="panel panel-default purchase" style="display: none;">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#proposal">Proposal</a>
                </h4>
            </div>
            <div id="proposal" class="panel-collapse collapse">
                <div class="panel-body"><table id="proposal_table" class="mdl-data-table mdl-js-data-table" style="width: 100%;"></table></div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#doc">Documents Details</a>
                </h4>
            </div>
            <div id="doc" class="panel-collapse collapse">
                <div class="panel-body"><div class="mdl-grid" id="doc_table" style="height: 40vh;overflow: auto;"></div></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var activity_arr = [],quotation_arr= [],amc_arr = [],purchase_arr =[], inventory_arr = [],invoice_arr = [],doc_arr = [],pic_arr = [],proposal_arr = [];
    <?php
            if (isset($mod) && count($mod) > 0) {
                for ($i=0; $i <count($mod) ; $i++) {
                    if ($mod[$i]->mname == 'Invoice' && $mod[$i]->status == 'active') {
                        echo "$('.invoice').css('display','block');";    
                    }
                    if ($mod[$i]->mname == 'Inventory' && $mod[$i]->status == 'active') {
                        echo "$('.inventory').css('display','block');";    
                    }
                    if ($mod[$i]->mname == 'Maintenance' && $mod[$i]->status == 'active') {
                        echo "$('.amc').css('display','block');";    
                    }
                    if ($mod[$i]->mname == 'Purchase' && $mod[$i]->status == 'active') {
                        echo "$('.purchase').css('display','block');";    
                    }
                    if ($mod[$i]->mname == 'Proposal' && $mod[$i]->status == 'active') {
                        echo "$('.proposal').css('display','block');";    
                    }
                }
            }
            if (isset($activity) && count($activity) > 0) {
                for ($i=0; $i <count($activity) ; $i++) { 
                    echo "activity_arr.push({'id' : ".$activity[$i]->iua_id.", 'title': '".$activity[$i]->iua_title."', 'date' : '".$activity[$i]->iua_date."', 'status' : '".$activity[$i]->iua_status."'});";
                }
            }

            if (isset($proposal) && count($proposal) > 0) {
                for ($i=0; $i <count($proposal) ; $i++) { 
                    echo "proposal_arr.push({'id' : ".$proposal[$i]->iextepro_id.", 'title': '".$proposal[$i]->iextepro_txn_id."', 'date' : '".$proposal[$i]->iextepro_txn_date."', 'status' : '".$proposal[$i]->iextepro_status."'});";
                }
            }

            if (isset($invoice) && count($invoice) > 0) {
                for ($i=0; $i <count($invoice) ; $i++) { 
                    echo "invoice_arr.push({'id' : ".$invoice[$i]->iextein_id.", 'title' : '".$invoice[$i]->iextein_txn_id."', 'date' : '".$invoice[$i]->iextein_txn_date."', 'status' : '".$invoice[$i]->iextein_status."'});";    
                }
            }

            if (isset($inventory) && count($inventory) > 0) {
                for ($i=0; $i <count($inventory) ; $i++) { 
                    echo "inventory_arr.push({'id' : ".$inventory[$i]->iextei_id.", 'title' : '".$inventory[$i]->iextei_txn_id."', 'date' : '".$inventory[$i]->iextei_txn_date."', 'status' : '".$inventory[$i]->iextei_status."'});";  
                }
            }

            if (isset($purchase) && count($purchase) > 0) {
                for ($i=0; $i <count($purchase) ; $i++) { 
                    echo "purchase_arr.push({'id' : ".$purchase[$i]->iextep_id.", 'title' : '".$purchase[$i]->iextep_txn_id."', 'date' : '".$purchase[$i]->iextep_txn_date."', 'status' : '".$purchase[$i]->iextep_status."'});";   
                }
            }

            if (isset($amc) && count($amc) > 0) {
                for ($i=0; $i <count($amc) ; $i++) { 
                    echo "amc_arr.push({'id' : ".$amc[$i]->iextamc_id.", 'title' : '".$amc[$i]->iextamc_txn_id."', 'date' : '".$amc[$i]->iextamc_txn_date."', 'status' : '".$amc[$i]->iextamc_status."'});";    
                }
            }
            if (isset($doc)) {
                for ($i=0; $i <count($doc) ; $i++) { 
                    echo "doc_arr.push({'id' : ".$doc[$i]->icd_id.", 'cid' : ".$doc[$i]->icd_cid.", 'file' : '".$doc[$i]->icd_file."','owner' : ".$doc[$i]->icd_owner.", 'file_id' : '".$doc[$i]->icd_timestamp."'});";
                }
            }
    ?>
    $(document).ready( function() {

        display_details();

        $('#customer_forward').click(function(e){
            e.preventDefault();
            $.post('<?php echo base_url()."Enterprise/leads_convert/".$cid."/".$code; ?>'
            ,function(d, s,x) {
                window.location = '<?php echo base_url()."Enterprise/customers/0/".$code; ?>';
            }, "text");
        });

        $('#c_edit').click(function(e){
            e.preventDefault();
            window.location = '<?php echo base_url()."Enterprise/customer_edit/".$code."/".$cid; ?>';
        });

        $('#doc_table').on('click','.document',function(e){
            e.preventDefault();
            var c_id = $(this).prop('id');
            window.location = "<?php echo base_url()."Account/doc_download/".$code."/"; ?>"+ doc_arr[c_id].file_id ;
        });

        $('#invoice_table').on('click','.invoice_edit',function(e){
            e.preventDefault();
            var c_id = $(this).prop('id');
            window.location = "<?php echo base_url()."Enterprise/cust_redirect/invoice/".$code."/"; ?>"+ c_id ;
        });

        $('.inventory_edit').click(function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            window.location = "<?php echo base_url()."Enterprise/cust_redirect/inventory/".$code."/"; ?>"+ id ;
        });

         $('.purchase_edit').click(function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            window.location = "<?php echo base_url()."Enterprise/cust_redirect/purchase/".$code."/"; ?>"+ id ;
        });

         $('.quotation_edit').click(function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            window.location = "<?php echo base_url()."Enterprise/cust_redirect/quotation/".$code."/"; ?>"+ id ;
        });

        $('.amc_edit').click(function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            window.location = "<?php echo base_url()."Enterprise/cust_redirect/amc/".$code."/"; ?>"+ id ;
        });

        $('.proposal_edit').click(function (e) {
            e.preventDefault();
            var id = $(this).prop('id');
            window.location = "<?php echo base_url()."Enterprise/cust_redirect/proposal/".$code."/"; ?>"+ id ;
        });
    });

    function display_details(){
        var out = '';

        if (activity_arr.length > 0) {
            out += '<thead><th class="mdl-data-table__cell--non-numeric">Title</th><th class="mdl-data-table__cell--non-numeric">Date</th><th class="mdl-data-table__cell--non-numeric">Status</th></thead><tbody>';
            for (var i = 0; i < activity_arr.length; i++) {
                out +='<tr class="activity_edit" id="'+activity_arr[i].id+'">';
                out +='<td class="mdl-data-table__cell--non-numeric">'+activity_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+activity_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric">'+activity_arr[i].status+'</td>';
            }
            out+='</tbody>';
            $('#activity_table').empty();
            $('#activity_table').append(out);
        }else{
            out += '<thead><th class="mdl-data-table__cell--non-numeric" style="text-align:center;"><h3>No records found !!</h3></th></thead>';
            $('#activity_table').empty();
            $('#activity_table').append(out);
        }var out = '';

        if (invoice_arr.length > 0) {
            out += '<thead><th class="mdl-data-table__cell--non-numeric">Title</th><th class="mdl-data-table__cell--non-numeric">Date</th><th class="mdl-data-table__cell--non-numeric">Status</th></thead><tbody>';
            for (var i = 0; i < invoice_arr.length; i++) {
                out +='<tr class="invoice_edit" id="'+invoice_arr[i].id+'">';
                out +='<td class="mdl-data-table__cell--non-numeric">'+invoice_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+invoice_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric">'+invoice_arr[i].status+'</td>';
            }
            out+='</tbody>';
            $('#invoice_table').empty();
            $('#invoice_table').append(out);
        }else{
            out += '<thead><th class="mdl-data-table__cell--non-numeric" style="text-align:center;"><h3>No records found !!</h3></th></thead>';
            $('#invoice_table').empty();
            $('#invoice_table').append(out);
        }var out = '';

        if (inventory_arr.length > 0) {
            out += '<thead><th class="mdl-data-table__cell--non-numeric">Title</th><th class="mdl-data-table__cell--non-numeric">Date</th><th class="mdl-data-table__cell--non-numeric">Status</th></thead><tbody>';
            for (var i = 0; i < inventory_arr.length; i++) {
                out +='<tr class="inventory_edit" id="'+inventory_arr[i].id+'">';
                out +='<td class="mdl-data-table__cell--non-numeric">'+inventory_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+inventory_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric">'+inventory_arr[i].status+'</td>';
            }
            out+='</tbody>';
            $('#inventory_table').empty();
            $('#inventory_table').append(out);
        }else{
            out += '<thead><th class="mdl-data-table__cell--non-numeric" style="text-align:center;"><h3>No records found !!</h3></th></thead>';
            $('#inventory_table').empty();
            $('#inventory_table').append(out);
        }var out = '';

        if (purchase_arr.length > 0) {
            out += '<thead><th class="mdl-data-table__cell--non-numeric">Title</th><th class="mdl-data-table__cell--non-numeric">Date</th><th class="mdl-data-table__cell--non-numeric">Status</th></thead><tbody>';
            for (var i = 0; i < purchase_arr.length; i++) {
                out +='<tr class="purchase_edit" id="'+purchase_arr[i].id+'">';
                out +='<td class="mdl-data-table__cell--non-numeric">'+purchase_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+purchase_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric">'+purchase_arr[i].status+'</td>';
            }
            out+='</tbody>';
            $('#purchase_table').empty();
            $('#purchase_table').append(out);
        }else{
            out += '<thead><th class="mdl-data-table__cell--non-numeric" style="text-align:center;"><h3>No records found !!</h3></th></thead>';
            $('#purchase_table').empty();
            $('#purchase_table').append(out);
        }var out = '';
        
        if (amc_arr.length > 0) {
            out += '<thead><th class="mdl-data-table__cell--non-numeric">Title</th><th class="mdl-data-table__cell--non-numeric">Date</th><th class="mdl-data-table__cell--non-numeric">Status</th></thead><tbody>';
            for (var i = 0; i < amc_arr.length; i++) {
                out +='<tr class="amc_edit" id="'+amc_arr[i].id+'">';
                out +='<td class="mdl-data-table__cell--non-numeric">'+amc_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+amc_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric">'+amc_arr[i].status+'</td>';
            }
            out+='</tbody>';
            $('#amc_table').empty();
            $('#amc_table').append(out);
        }else{
            out += '<thead><th class="mdl-data-table__cell--non-numeric" style="text-align:center;"><h3>No records found !!</h3></th></thead>';
            $('#amc_table').empty();
            $('#amc_table').append(out);
        }var out = '';

        if (proposal_arr.length > 0) {
            out += '<thead><th class="mdl-data-table__cell--non-numeric">Title</th><th class="mdl-data-table__cell--non-numeric">Date</th><th class="mdl-data-table__cell--non-numeric">Status</th></thead><tbody>';
            for (var i = 0; i < proposal_arr.length; i++) {
                out +='<tr class="proposal_edit" id="'+proposal_arr[i].id+'">';
                out +='<td class="mdl-data-table__cell--non-numeric">'+proposal_arr[i].title+'</td><td class="mdl-data-table__cell--non-numeric">'+proposal_arr[i].date+'</td><td class="mdl-data-table__cell--non-numeric">'+proposal_arr[i].status+'</td>';
            }
            out+='</tbody>';
            $('#proposal_table').empty();
            $('#proposal_table').append(out);
        }else{
            out += '<thead><th class="mdl-data-table__cell--non-numeric" style="text-align:center;"><h3>No records found !!</h3></th></thead>';
            $('#proposal_table').empty();
            $('#proposal_table').append(out);
        }var out = '';

        if (doc_arr.length > 0) {
            for (var i = 0; i < doc_arr.length; i++) {
                path = "<?php echo base_url().'assets/uploads/'.$oid.'/';?>"+doc_arr[i].file_id;

                out += '<div class="mdl-cell mdl-cell--4-col document" id="'+i+'"><a href="#sign_up" id="'+i+'"><div class="mdl-card__title mdl-card--expand" style="background: linear-gradient(0deg,rgba(0,0,0,0.5),rgba(200, 15, 15, 0.3)),url('+path+');background-size: cover;width: 256px;background-repeat: no-repeat;height: 150px;"><h2 class="mdl-card__title-text">'+doc_arr[i].file+'</h2></div></a></div>';
            }
            $('#doc_table').append(out);
        }else{
            out += '<thead><th class="mdl-data-table__cell--non-numeric" style="text-align:center;"><h3>No records found !!</h3></th></thead>';
            $('#doc_table').empty();
            $('#doc_table').append(out);
        }var out = '';
    }
</script>