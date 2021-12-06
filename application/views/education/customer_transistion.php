<main class="mdl-layout__content">
	<div class="mdl-grid" style="margin-bottom: 60px;">
		<div class="mdl-cell mdl-cell--3-col"></div>
		<div class="mdl-cell mdl-cell--6-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Select <?php echo $title_from; ?> properties that you want to transfer to <?php echo $title_to;?></h2>
				</div>
				<div class="mdl-card__supporting-text mdl-grid">
					<?php 
						for ($i=0; $i < count($from) ; $i++) { 
							echo '<div class="mdl-cell mdl-cell--12-col">';
							echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
							echo '<select id="f'.$from[$i]->ip_id.'" name="fromprp[]" class="mdl-textfield__input" style="color:#999;">';
							echo '<option value="none">Select</option>';
							for ($j=0; $j < count($to) ; $j++) { 
								echo '<option value="'.$to[$j]->ip_id.'">'.$to[$j]->ip_property.'</option>';
							}
							echo '<option value="create">Create Property</option>';
							echo '</select>';
							echo '<label class="mdl-textfield__label" for="s_name">Select '.$from[$i]->ip_property.' Property</label>';
							echo '</div>';
							echo '</div>';
						}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--3-col"></div>
		<!-- GENERAL DETAILS -->
		
	
	</div>
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
		<i class="material-icons">done</i>
	</button>
	
</main>
</div>
</body>
<script>
	$(document).ready(function() {
		$('#submit').click(function(e) {
			e.preventDefault();
			var from_prop = [];
			var to_prop = [];
			$("select[name^='fromprp'").each(function(){
				var abc = $(this).prop('id');

				abc = abc.substr(1, abc.length);
				from_prop.push(abc);

				to_prop.push($(this).val());

			});

			console.log(from_prop);
			console.log(to_prop);
			
			$.post("<?php echo base_url().'education/customer_transistion_save/'.$cid.'/'.$title_from.'/'.$title_to; ?>", {
					'from' : from_prop,
					'to' : to_prop
				}, function(data, status, xhr) {
					window.location = "<?php echo base_url().'education/enquiry'; ?>"
				}, "text");
			
		});
	});
</script>
</html>