<main class="mdl-layout__content">
	<section class="mdl-layout__tab-panel is-active" id="scroll-tab-1">
		<div class="page-content">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col"></div>
				<div class="mdl-cell mdl-cell--4-col">
					<!-- <div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Batch</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;"> -->
								<!-- <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> -->
								<h6>Type the batch name to allot</h6>
								<ul id="myTags" class="mdl-textfield__input">
								</ul>
								<!-- </div>
							</div>			
						</div>
					</div> -->
				</div>
				<div class="mdl-cell mdl-cell--4-col"></div>
				<div class="mdl-cell mdl-cell--4-col"></div>
				<div class="mdl-cell mdl-cell--4-col">
					<h6>Select students you wish to allot to this batch</h6>
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%;">
						<thead>
							<tr>
								<th class="mdl-data-table__cell--non-numeric">Select</th>
								<th class="mdl-data-table__cell--non-numeric">Student</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if (count($customer) > 0) {
									for ($i=0; $i < count($customer) ; $i++) { 
										echo '<tr style="color: #999;font-weight: bold;">';
										echo '<td class="mdl-data-table__cell--non-numeric">';
										echo '<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="'.$customer[$i]->ic_id.'">';
										echo '<input type="checkbox" id="'.$customer[$i]->ic_id.'" class="mdl-switch__input" name="s_id[]">';
										echo '<span class="mdl-switch__label"></span>';
										echo '</label>';
										echo '</td>';
										echo '<td class="mdl-data-table__cell--non-numeric">'.$customer[$i]->ic_name.'</td>';
										echo '</tr>';
									}
									
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="mdl-cell mdl-cell--4-col"></div>

				<!-- <h3>Already alloted</h3>
				<hr>
				 -->
				


				<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
					<i class="material-icons">done</i>
				</button>
				
			</div>
		</div>
	</section>
	<section class="mdl-layout__tab-panel" id="scroll-tab-2">
		<div class="page-content">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--4-col"></div>
				<div class="mdl-cell mdl-cell--4-col">
					<h6>Select the batch name you wish to check allotment</h6>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="b_sel_batch" class="mdl-textfield__input">
						<option value="0" selected>Select Batch</option>
							<?php


								for ($k=0; $k < count($batch) ; $k++) { 
									echo '<option value="'.$batch[$k]->iextb_id.'">'.$batch[$k]->iextb_batch_name.'</option>';
								}
							?>
						</select>
						<label class="mdl-textfield__label" for="b_sel_batch">Batch</label>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--4-col"></div>
				
				<div class="mdl-cell mdl-cell--4-col"></div>
				<div class="mdl-cell mdl-cell--4-col" id="b_chips">
				<h5>List of students in selected Batch</h5><hr>
				</div>
				<div class="mdl-cell mdl-cell--4-col"></div>
			</div>
		</div>
	</section>
</main>
</div>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	
    	<?php
    		for ($i=0; $i < count($batch) ; $i++) { 
    			echo "tag_data.push('".$batch[$i]->iextb_batch_name."');";
    		}
    	?>
    	
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});
    });
</script>

<script>
	$(document).ready(function() {

		var batchid = 0;

		$('#b_sel_batch').change(function(e) {
			e.preventDefault();

			var eid = $(this).val();
			batchid = eid;
			$.post('<?php echo base_url()."education/show_alloted_batch"; ?>', {
				'bid' : eid
			}, function(data, status, xhr) {
				
				var abc = JSON.parse(data);
				$('#b_chips').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#b_chips').append('<span id="spn' + abc[i].ic_id +'" class="mdl-chip mdl-chip--deletable" style="margin:10px;"><span class="mdl-chip__text">' + abc[i].ic_name + '</span><button type="button" class="mdl-chip__action" id="' + abc[i].iextba_customer_id + '"><i class="material-icons">cancel</i></button></span>');
				}
				

			}, 'text');
			
		});


		$('#b_chips').on('click', '.mdl-chip__action', (function(e) {
			var studid = $(this).prop('id');
			var rmv = '#spn' + studid;

			$.post('<?php echo base_url()."education/remove_alloted_batch"; ?>', {
				'bid' : batchid,
				'sid' : studid
			}, function(data, status, xhr) {
				
				var abc = JSON.parse(data);
				$('#b_chips').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#b_chips').append('<span id="spn' + abc[i].ic_id +'" class="mdl-chip mdl-chip--deletable" style="margin:10px;"><span class="mdl-chip__text">' + abc[i].ic_name + '</span><button type="button" class="mdl-chip__action" id="' + abc[i].ic_id + '"><i class="material-icons">cancel</i></button></span>');
				}
				

			}, 'text');
			
			$(rmv).remove();
		}));

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var b_std = [];

			var chkinp = $("input[name^='s_id'");
			var a = 0;
			$("input[name^='s_id'").each(function(){
				console.log(chkinp);
				if(chkinp[a].checked) {
					b_std.push($(this).prop('id'));	
				}
				a++;
			});
			
			var batch_info = [];
			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					batch_info.push(tmpstr);
				}
			});
			

			<?php echo "$.post('".base_url()."education/save_alloted_batch', {'student' : b_std, 'batch' : batch_info }, function(data, status, xhr) { window.location = '".base_url()."education/batch_allot'}, 'text');";
			?>
		});
	});
</script>
</html>