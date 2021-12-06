<main class="mdl-layout__content">
	<div class="mdl-grid" style="margin-bottom: 60px;">
		<!-- GENERAL DETAILS -->
			<?php 
				for ($i=0; $i < count($customer) ; $i++) { 
					echo '<div class="mdl-cell mdl-cell--2-col">';
					echo '<a href="'.base_url()."education/enquiry_edit/".$customer[$i]->ic_id.'"><div class="mdl-card mdl-shadow--4dp">';
					echo '<div class="mdl-card__title mdl-card--expand" style="height:180px;">';
					echo '<h2 class="mdl-card__title-text">'.$customer[$i]->ic_name.'</h2>';
					echo '</div>';
					echo '</div></a>';
					echo '</div>';
				}
			?>
		
	</div>
	<a href="<?php echo base_url().'education/enquiry_add'; ?>">
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
		<i class="material-icons">add</i>
	</button>
	</a>

	<hr>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<a href="<?php echo base_url().'Education/general_properties/Enquiry'; ?>">
				<button style="width: 100%;" class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">General Properties</button>
			</a>
		</div>
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	
	
</main>
</div>
</body>
</html>