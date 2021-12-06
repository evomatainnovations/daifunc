<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--12-col">
			<ul class="mdl-list">
				<?php 
					for ($i=0; $i < count($product) ; $i++) { 
						echo '<a href="'.base_url()."Customers/product_edit/".$product[$i]->ip_id.'"><li class="mdl-list__item"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">person</i>'.$product[$i]->ip_product.'</span></a>';
					}
				?>
			</ul>
		</div>
		<a href="<?php echo base_url().'Customers/products_add'; ?>">
		<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
			<i class="material-icons">add</i>
		</button>
	</div>
</main>
</div>
</body>
</html>