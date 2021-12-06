<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Teacher Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<label>Type Subjects that the teacher conducts</label>
						<ul id="myTags" class="mdl-textfield__input">
							<?php if (isset($edit_teacher_subjects)) {
									for ($j=0; $j < count($edit_teacher_subjects) ; $j++) { 
										$x = $edit_teacher_subjects[$j]->iextts_s_id;
										$y = 0;
										for ($ij=0; $ij < count($subject) ; $ij++) { 
											$m = $subject[$ij]->iexts_id;
											if($x==$m) {
												$y=$ij;
											}
										}
										echo "<li>".$subject[$y]->iexts_name."</li>";
									}
								}
							?>
						</ul>
						<!-- <select id="s_name" name="s_name" class="mdl-textfield__input"> -->
							<?php 
								// for ($i=0; $i < count($subject) ; $i++) { 
								// 	echo '<option value="'.$subject[$i]->iexts_id.'" ';
								// 	if(isset($edit_teacher)) {
								// 		if($subject[$i]->iexts_id == $edit_teacher[0]->iextt_subject) {
								// 			echo "selected";
								// 		}
								// 	}
								// 	echo '>'.$subject[$i]->iexts_name.'</option>';
								// }
							?>
						<!-- </select> -->
						<!-- <label class="mdl-textfield__label" for="s_name">Select Subject</label> -->
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="<?php if(isset($edit_teacher)) { echo $edit_teacher[0]->ic_name; } ?>">
						<label class="mdl-textfield__label" for="c_name">Enter Teacher Name</label>
					</div>
				</div>				
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Salary Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
		            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select id="salary" name="salary" class="mdl-textfield__input">
							<?php

								echo '<option value="fixed" ';
								if(isset($edit_teacher)) {
									if($edit_teacher[0]->iextt_salary_type == "fixed") {
										echo "selected";
									}
								}
								echo '>Fixed</option>';

								echo '<option value="hourly" ';
								if(isset($edit_teacher)) {
									if($edit_teacher[0]->iextt_salary_type == "hourly") {
										echo "selected";
									}
								}
								echo '>hourly</option>';
							?>
						</select>
						<label class="mdl-textfield__label" for="salary">Salary Type</label>
					</div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="amount" name="amount" class="mdl-textfield__input" value="<?php if(isset($edit_teacher)) { echo $edit_teacher[0]->iextt_amount; } ?>">
						<label class="mdl-textfield__label" for="max_hr">Amount</label>
					</div>
				</div>				
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Basic Information</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div id="info_repeat" class="mdl-grid">
						<?php 
							for ($i=0; $i < count($property) ; $i++) { 
								$prop = $property[$i]->ip_property;
								$pid = $property[$i]->ip_id;
								$val = "";

								if(isset($edit_basic_details)) {
									for ($ij=0; $ij < count($edit_basic_details) ; $ij++) { 
										$cpid = $edit_basic_details[$ij]->icbd_property;
										
										if ($cpid==$pid) {
											$val = $edit_basic_details[$ij]->icbd_value;
										}
									}
								}

								echo '<div class="mdl-cell mdl-cell--6-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="c_val'.$pid.'" name="c_val[]" class="mdl-textfield__input" value="'.$val.'"><label class="mdl-textfield__label" for="c_val'.$pid.'">'.$prop.'</label></div></div>';
							}
						?>
					</div>
					<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">';
						<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="add_prp">Add Property</button>
					</div>			
				</div>
			</div>
		</div>
		</div>
		<?php 
			if(isset($edit_teacher)) {
				echo '<div class="mdl-cell mdl-cell--2-col"></div>';
				echo '<div class="mdl-cell mdl-cell--8-col" >';
				echo '<a href="'.base_url().'education/teacher_delete/'.$sid.'"><button class="mdl-button mdl-button-done mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Delete</button>';
				echo '</div>';
				echo '<div class="mdl-cell mdl-cell--2-col"></div>';
			}
		?>
		
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</div>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	
    	<?php
    		for ($i=0; $i < count($subject) ; $i++) { 
    			echo "tag_data.push('".$subject[$i]->iexts_name."');";
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

		var prp_count = 0;
		$('#add_prp').click(function(e) {
			e.preventDefault();
			var tmpcprp = 'c_n_val'+prp_count;
			$('#info_repeat').append('<div class="mdl-cell mdl-cell--6-col"><input type="text" name="c_n_prp[]" class="mdl-textfield__input" placeholder="Property"><input type="text" name="c_n_val[]" class="mdl-textfield__input" placeholder="Value"></div>');
			tmpcprp = "#" + tmpcprp;
			$(tmpcprp).focus();
			prp_count++;
		});


		$('#submit').click(function(e) {
			e.preventDefault();

			var c_new_prp = [];
			var c_new_val = [];
			$("input[name^='c_n_val'").each(function(){
				console.log($(this).val());
				c_new_val.push($(this).val());
			});

			$("input[name^='c_n_prp'").each(function(){
				console.log($(this).val());
				c_new_prp.push($(this).val());
			});

			var c_new_data = [];
			c_new_data.push({'n_p' : c_new_prp, 'n_v' : c_new_val});

			var c_value = [];
			$("input[name^='c_val'").each(function(){
				var pp = $(this).prop('id');
				var l = pp.length;
				pp = pp.substr(5,l);	
				c_value.push({'p': $(this).val(), 'v' : pp });
			});

			var teacher = $('#c_name').val();
			var subject = [];

			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					subject.push(tmpstr);
				}
			});
			
			var salary = $('#salary').val();
			var amount = $('#amount').val();

			<?php if (isset($edit_teacher)) {
				echo "$.post('".base_url()."education/teacher_update/".$sid."', {'subject' : subject, 'teacher' : teacher, 'salary': salary, 'amount': amount, 'new_property' : c_new_data, 'value' : c_value }, function(data, status, xhr) { window.location = '".base_url()."education/teachers' }, 'text');";
				} else {
					echo "$.post('".base_url()."education/teacher_save', {'subject' : subject, 'teacher' : teacher, 'salary': salary, 'amount': amount, 'new_property' : c_new_data, 'value' : c_value }, function(data, status, xhr) { window.location = '".base_url()."education/teachers'}, 'text');";
				}
			?>			
		});
	});
</script>
</html>