<main class="mdl-layout__content">
	<div class="mdl-grid" style="margin-bottom: 60px;">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-grid">
			<div class="mdl-cell mdl-cell--12-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Select Modules to Export Data</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;" id="module_name">
						<tbody>
							<?php
								for ($i=0; $i < count($mod) ; $i++) { 
									echo '<tr>';
									echo '<td class="mdl-data-table__cell--non-numeric">';
									// echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
									echo '<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="'.$mod[$i]->mid.'">';
									echo '<input type="checkbox" id="'.$mod[$i]->mid.'" name="module_name[]" class="mdl-switch__input"';
									
									echo '>';
									echo '<span class="mdl-switch__label"></span>';
									echo '</label>';
									// echo '</div>';
									echo "</td>";
									echo '<td class="mdl-data-table__cell--non-numeric">'.$mod[$i]->mname.'</td>';
									echo "</tr>";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			</div>
			</div>
		</div>
	</div>
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
		<i class="material-icons">done</i>
	</button>
</main>
</div>
</body>
<script>
	$(document).ready(function(){
		
		$('#submit').click(function(e) {
			e.preventDefault();

// 			var group = $('#group_name').val();
// 			var property = $('#property_name').val();

// 			console.log(group);
// 			var customer = [];
// 			$("input[name^='customer_name'").each(function(){
// 				if($(this)[0].checked == true){
// 					var tmp = $(this).prop('id');
// 					tmp = tmp.substring(1, tmp.length);
// 					customer.push(tmp); 
// 				}
// 			});
// 			console.log(customer);
// 			var module = [];
// 			$("input[name^='module_name'").each(function(){
// 				if($(this)[0].checked == true){
// 					module.push($(this).prop('id')); 	
// 				}
// 			});
// 			console.log(module);

            window.location = "<?php echo base_url().'Account/download_files'; ?>";
			<?php 
				# echo '$.post("'.base_url().'Account/save_user/", { "group" : group, "customer" : customer, "module" : module, "property" : property }, function(data, status, xhr) { window.location = "'.base_url().'Account/add_user"; }, "text");';
			?>
		});

		
	});
</script>
</html>