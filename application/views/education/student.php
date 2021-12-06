<main class="mdl-layout__content">
	<div class="mdl-grid" style="margin-bottom: 60px;" id="details">
		<!-- GENERAL DETAILS -->
			<?php 
				for ($i=0; $i < count($customer) ; $i++) { 
					echo '<div class="mdl-cell mdl-cell--2-col">';
					echo '<a href="'.base_url()."Education/student_edit/".$customer[$i]->ic_id.'"><div class="mdl-card mdl-shadow--4dp">';

					if($customer[$i]->icp_path) {
						echo '<div class="mdl-card__title mdl-card--expand" style="height:180px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url(\''.base_url().'assets/uploads/'.$oid.'/'.$customer[$i]->icp_path.'\');background-size: 100%;">';	
					} else {
						echo '<div class="mdl-card__title mdl-card--expand" style="height:180px;">';
					}
					
					echo '<h2 class="mdl-card__title-text">'.$customer[$i]->ic_name.'</h2>';
					echo '</div>';
					echo '</div></a>';
					echo '</div>';
				}
			?>
		
	</div>
	<a href="<?php echo base_url().'education/student_add'; ?>">
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
		<i class="material-icons">add</i>
	</button>
	</a>
	<hr>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Education/general_properties/Students'; ?>">
				<button style="width: 100%;" class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">General Properties</button>
			</a>
		</div>
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
</main>
</div>
</body>
<script>
	$(document).ready(function() {
		$('#fixed-header-drawer-exp').change(function(e) {
			e.preventDefault();

			$.post('<?php echo base_url()."Education/student_search/"; ?>', {
				'search' : $(this).val()
			}, function(data, status, xhr) {
				var abc = JSON.parse(data);

				$('#details').empty();
				var out = "";
				for (var i = 0; i < abc.customer.length; i++) {
					out+='<div class="mdl-cell mdl-cell--2-col">';
					out+='<a href="<?php echo base_url()."Education/student_edit/"; ?>' + abc.customer[i].ic_id + '"><div class="mdl-card mdl-shadow--4dp">';
					if(abc.customer[i].icp_path) {
						out+='<div class="mdl-card__title mdl-card--expand" style="height:180px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url(\'<?php echo base_url().'assets/uploads/'.$oid.'/'; ?>' + abc.customer[i].icp_path + '\');background-size: 100%;">';
					} else {
						out+='<div class="mdl-card__title mdl-card--expand" style="height:180px;">';
					}
					out+='<h2 class="mdl-card__title-text">' + abc.customer[i].ic_name + '</h2>';
					out+='</div>';
					out+='</div></a>';
					out+='</div>';
				}

				$('#details').append(out);
			})
		});
	});
</script>

</html>