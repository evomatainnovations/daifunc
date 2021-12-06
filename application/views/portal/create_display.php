<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Display Details</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-grid">
								<div class="mdl-cell mdl-cell--12-col">
									<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input type="text" class="mdl-textfield__input" id="s_name" name="s_name">
										<label class="mdl-textfield__label" for="s_name">Enter Display Name</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mdl-cell mdl-cell--12-col">
					<div class="mdl-card mdl-shadow--4dp">
						<div class="mdl-card__title">
							<h2 class="mdl-card__title-text">Sections Details</h2>
						</div>
						<div class="mdl-card__supporting-text">
							<div class="mdl-grid" id="section">
							</div>
							<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;" id="add_section"> <i class="material-icons">add</i> Add Section</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Display Name</th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i=0; $i < count($dis) ; $i++) { 
							echo '<tr id="'.$dis[$i]->id_id.'" class="click_customer">';
							echo '<td class="mdl-data-table__cell--non-numeric">'.$dis[$i]->id_name.'</td>';
							echo "</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	
    	$('#myTags').tagit({
    		autocomplete : { delay: 0, minLenght: 5},
    		allowSpaces : true,
    		availableTags : tag_data
    	});
    });
</script>
<script>
	$(document).ready(function() {

		var sectionid = 0;
		$('#add_section').click(function(e) {
			e.preventDefault();

			$('#section').append('<div class="mdl-cell mdl-cell--12-col"> <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"> <textarea class="mdl-textfield__input" id="sh' + sectionid + '" name="section_header[]" rows="5"></textarea> <label class="mdl-textfield__label" for="sh' + sectionid + '">Enter Header</label></div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="shl' + sectionid + '"><input type="checkbox" name="section_loop[]" id="shl' + sectionid + '" class="mdl-switch__input" <span class="mdl-switch__label">Loop Section</span></label></div> </div>');
			sectionid++;
		})

		$('.click_customer').click(function(e) {
			e.preventDefault();

			var cid = $(this).prop('id');
			$(this).css('background-color', 'green');
			$(this).css('color', 'white');

			$.post("<?php echo base_url().'Portal/get_display_details/'; ?>" + cid,
				function(data, status, xhr) {
					var abc = JSON.parse(data);
					$('#s_name').val(abc[0].id_name);
					$('#s_header').val(abc[0].id_header);
					$('#s_mid').val(abc[0].id_mid);
					$('#s_bottom').val(abc[0].id_bottom);
				}, "text");
			
		});

		$('#submit').click(function(e) {
			e.preventDefault();

			var section = [];
			var section_l = [];

			$("input[name^='section_header'").each(function(){
				var pp = $(this).val();
				section.push(pp);
			});

			var a = 0;
			$("input[name^='section_loop'").each(function(){
				if($(this)[a].checked) {
					section_l.push('loop');
				} else {
					section_l.push('regular');
				}
				a++;				
			});

			$.post("<?php if(isset($edit_function)) { echo base_url().'Portal/update_display/'.$kid; } else { echo base_url().'Portal/save_display'; } ?>", {
				'name' : $('#s_name').val(),
				'section_loop' : section_loop,
				'section_header' : section_l,
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'Portal/create_display'; ?>"
			}, "text");
		});
	});
</script>

</html>