<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col">
			<h2><?php if (isset($boq_list)) {
				echo $boq_list[0]->iextetboq_title;
			} ?></h2>
		</div>
		<div class="mdl-cell mdl-cell--12-col display_template" style="overflow: auto;">
			<?php
				echo '<table class="general_table">';
				$flg_id = 0;
				for ($i = 0; $i < count($table_arr); $i++) {
					for ($ij = 0; $ij < count($table_arr[$i]->row_data); $ij++) {
		            	if ($table_arr[$i]->row_data[$ij]->data == null) {
		            		$flg_id = $ij;
		            		break;
		            	}
	            	}
	            }
	            $remain_col = count($table_arr) - $flg_id;
	            for ($i = 0; $i < count($table_arr); $i++) {
	            	$flg = 0;
	                if ($table_arr[$i]->level == 1) {
	                    echo '<thead>';
	                    echo  '<tr>';
	                    $col_flg = 0;
	                    $th_flg = 0;
	                    for ($ij = 0; $ij < $flg_id; $ij++) {
	                    	echo '<th style="outline:none;min-width:200px;width:200px;word-break: break-all;background-color:#ccc;border:1px solid #000;" rowspan="2">'.$table_arr[$i]->row_data[$ij]->data.'</th>';
	                    	$col_flg++;
	                    }
                    	if (isset($quote_info)) {
                			for ($j=0; $j <count($quote_info) ; $j++) { 
                				for ($k=0; $k <count($quote_info[$j]) ; $k++) {
                					if (stripos($quote_info[$j][$k]->text, 'name') !== FALSE) {
	                					echo '<th style="outline:none;min-width:200px;width:200px;word-break: break-all;background-color:#ccc;border:1px solid #000;text-align:center;" colspan="'.$remain_col.'" >'.$quote_info[$j][$k]->val.'<br><button class="mdl-button mdl-button--colored re_details" id="'.$j.'"><i class="material-icons">remove_red_eye</i> view details</button></th>';
	                					break;
	                				}
                				}
                			}
                		}
	                    echo '</tr>';
	                    echo  '<tr>';
	                    for ($j=0; $j <count($quote_info) ; $j++) { 
            				for ($k=1; $k <count($quote_info[$j]) ; $k++) {
			                    for ($ij = $flg_id; $ij < count($table_arr[$i]->row_data); $ij++) {
					            	echo '<th style="outline:none;min-width:200px;width:200px;word-break: break-all;background-color:#ccc;border:1px solid #000;" >'.$table_arr[$i]->row_data[$ij]->data.'</th>';
				            	}
				            	break;
				            }
				        }
	                    echo '</tr>';

	                    echo '</thead>';
	                }else{
	                    echo '<tr>';
	                    for ($ij = 0; $ij < $flg_id; $ij++) {
	                    	echo '<td style="outline:none;min-width:200px;width:200px;word-break: break-all;border:1px solid #000;" >'.$table_arr[$i]->row_data[$ij]->data.'</td>';

	                    }
	                    for ($j=0; $j <count($quote_table) ; $j++) { 
		                    for ($ij = $flg_id; $ij < count($quote_table[$j][$i]->row_data); $ij++) {
		                    	echo '<td style="outline:none;min-width:200px;width:200px;word-break: break-all;border:1px solid #000;" >'.$quote_table[$j][$i]->row_data[$ij]->data.'</td>';
			            	}
				        }
	                    echo '</tr>';
	                }
	            }
	            echo '<tr><td style="border:1px solid #000;text-align:center;" colspan="'.$col_flg.'">Total</td>';
	            $flg_id = 0;
        		if (isset($quote_table)) {
        			if ($boq_list[0]->iextetboq_col_name != '' || $boq_list[0]->iextetboq_col_name != null) {
        				for ($j=0; $j <count($quote_table) ; $j++) { 
	        		 		for ($k=0; $k < 1 ; $k++) {
	        		 			for ($i=0; $i < count($quote_table[$j][$k]->row_data) ; $i++) {
	        		 				if ($quote_table[$j][$k]->row_data[$i]->data == $boq_list[0]->iextetboq_col_name) {
		        		 				$flg_id = $i;
		        		 			}	
	        		 			}
	        				}
	        			}

	        			for ($j=0; $j <count($quote_table) ; $j++) { 
	        				$t_amount = 0;
	        		 		for ($k=1; $k < count($quote_table[$j]) ; $k++) {
	        		 			for ($i=0; $i < count($quote_table[$j][$k]->row_data) ; $i++) { 
	        		 				if ($i == $flg_id) {
	        		 					$t_amount += $quote_table[$j][$k]->row_data[$i]->data;
	        		 				}
	        		 			}
	        				}
	        				echo '<td style="border:1px solid #000;text-align:center;" colspan="'.$remain_col.'">'.$boq_list[0]->iextetboq_col_name.' : '.$t_amount.'</td>';
	        			}	
        			}else{
        				for ($j=0; $j <count($quote_table) ; $j++) {
        					echo '<td style="border:1px solid #000;text-align:center;" colspan="'.$remain_col.'"></td>';
        				}
        			}
        		}
        		echo '</tr>';
	            echo '</table>';
			?>
		</div>
	</div>
</main>
<div class="modal fade" id="re_details" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Information Details</h3>
            </div>
            <div class="modal-body">
                <div class="mdl-grid details_display"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mdl-button" data-dismiss="modal"><i class="material-icons">close</i> Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var info_arr = [];
	var req_arr = [];
	var note_arr = [];
	<?php
		if (isset($quote_info)) {
			for ($j=0; $j <count($quote_info) ; $j++) { 
	            for ($k=0; $k <count($quote_info[$j]) ; $k++) {
	            	echo "info_arr.push({'id' : '".$j."' , 'text' : '".$quote_info[$j][$k]->text."' , 'val' : '".$quote_info[$j][$k]->val."' });";
				}
			}
	    }

	    if (isset($quote_req)) {
			for ($j=0; $j <count($quote_req) ; $j++) { 
	            for ($k=0; $k <count($quote_req[$j]) ; $k++) {
	            	for ($ij=0; $ij < count($doc_list) ; $ij++) {
	            		if (isset($quote_req[$j][$k]->upload_id)) {
	            			if ($quote_req[$j][$k]->upload_id == $doc_list[$ij]->icd_id) {
		            			echo "req_arr.push({'id' : '".$j."' , 'text' : '".$quote_req[$j][$k]->text."' , 'val' : '".$doc_list[$ij]->icd_file."' , 'doc_id' : '".$quote_req[$j][$k]->upload_id."' });";
		            		}
	            		}
	            	}
	            }
	        }
	    }
	    if (isset($quote_note)) {
	    	for ($i=0; $i < count($quote_note) ; $i++) {
	    		echo "note_arr.push({'id' : '".$quote_note[$i]['id']."' , 'note' : '".$quote_note[$i]['note']."' });";
	    	}
	    }
	?>
    $(document).ready( function() {
    	$('.re_details').click(function(e){
    		e.preventDefault();
    		var id = $(this).prop('id');
    		var out = '<table class="general_table">';
    		for (var i = 0; i < info_arr.length; i++) {
    			if(info_arr[i].id == id){
    				out += '<tr><td>'+info_arr[i].text+'</td><td>:</td><td>'+info_arr[i].val+'</td></tr>';
    			}
    		}
    		out += '</table>';
    		out += '<div class="mdl-cell mdl-cell--12-col"><h3>Note : </h3>';
    		for (var i = 0; i < note_arr.length; i++) {
    			if(note_arr[i].id == id){
    				if (note_arr[i].note != '') {
    					out += '<p>'+note_arr[i].note+'</p>';
    				}else{
    					out += '<p>N/A</p>';
    				}
    			}
    		}
    		out += '</div>';

    		out += '<div class="mdl-cell mdl-cell--12-col"><h3>Document Details : </h3></div>';
    		var flg = 0;
    		for (var i = 0; i < req_arr.length; i++) {
    			if(req_arr[i].id == id){
    				flg++;
    				out += '<div class="mdl-cell mdl-cell--12-col" style="display:flex;"><h4>'+flg+' ) '+req_arr[i].text+'</h4><span class="mdl-chip doc_file" style="margin-right: 10px;margin-bottom: 10px;margin-top: 10px;margin-left:50px;" id="'+req_arr[i].doc_id+'"><span class="mdl-chip__text">'+req_arr[i].val+'</span></span></div>';
    			}
    		}
    		$('.details_display').empty();
    		$('.details_display').append(out);
    		$('#re_details').modal('show');
    	});


    	$('.details_display').on('click','.doc_file',function (e) {
     		e.preventDefault();
     		var id = $(this).prop('id');
			window.location = '<?php echo base_url()."BOQ/upload_doc_download/".$code."/";?>'+id;
     	});
    });
</script>



