<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Product Details</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="p_name" name="p_name" class="mdl-textfield__input" value="<?php if(isset($edit_product)) { echo $edit_product[0]->ip_product; } ?>">
						<label class="mdl-textfield__label" for="p_name">Enter Product Name</label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Features</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div id="info_repeat" class="mdl-grid">
						<?php 
							if(isset($edit_features)) {
								for ($i=0; $i < count($edit_features) ; $i++) { 
									echo '<div class="mdl-cell mdl-cell--2-col"><p style="text-align:left;padding-top:16px;">'.($i + 1).'.</p></div><div class="mdl-cell mdl-cell--10-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="p_feature'.$i.'" name="p_feature[]" class="mdl-textfield__input" placeholder="Enter a feature" value="'.$edit_features[$i]->ipf_feature.'"></div></div>';
								}
							}
						?>
					</div>
					<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">';
						<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="add_prp">Add Feature</button>
					</div>			
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Tags</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<ul id="myTags" class="mdl-textfield__input">
							<?php if (isset($edit_preferences)) {
									for ($j=0; $j < count($edit_preferences) ; $j++) { 
										$x = $edit_preferences[$j]->ipft_tag_id;
									
										$y = 0;
										for ($ij=0; $ij < count($tags) ; $ij++) { 
											$m = $tags[$ij]->it_id;
											if($x==$m) {
												$y=$ij;
											}
										}
										echo "<li>".$tags[$y]->it_value."</li>";
									}
								}
							?>
						</ul>
						</div>
					</div>			
				</div>
			</div>
		</div>
		<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
			<i class="material-icons">done</i>
		</button>
	</div>
</main>
</div>
</body>
<script type="text/javascript">
    $(document).ready( function() {
    	var tag_data = [];
    	
    	<?php
    		for ($i=0; $i < count($tags) ; $i++) { 
    			echo "tag_data.push('".$tags[$i]->it_value."');";
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
		$('#p_name').focus();	

		var prp_count = 0;
		$('#add_prp').click(function(e) {
			e.preventDefault();
			var tmppfeature = 'p_feature'+prp_count;
			$('#info_repeat').append('<div class="mdl-cell mdl-cell--2-col"><p style="text-align:left;padding-top:16px;">' + (prp_count + 1) + '.</p></div><div class="mdl-cell mdl-cell--10-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" id="' + tmppfeature + '" name="p_feature[]" class="mdl-textfield__input" placeholder="Enter a feature"></div></div>');
			tmppfeature = "#" + tmppfeature;
			$(tmppfeature).focus();
			prp_count++;
		});

		$('#submit').click(function(e) {
			e.preventDefault();
			

			var pfeature = [];
			$("input[name^='p_feature'").each(function(){
				console.log($(this).val());
				pfeature.push($(this).val());
			});
			
			
			var product_name = $('#p_name').val();
			var product_tags = [];

			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					product_tags.push(tmpstr);
				}
			});
			
			<?php if (isset($edit_product)) {
					echo "$.post('".base_url()."Customers/update_products/".$pid."', {'name' : product_name, 'feature' : pfeature, 'tags' : product_tags }, function(data, status, xhr) {window.location = '".base_url()."Customers/products'}, 'text');";
				} else {
					echo "$.post('".base_url()."Customers/save_products', {'name' : product_name, 'feature' : pfeature, 'tags' : product_tags }, function(data, status, xhr) {window.location = '".base_url()."Customers/products'}, 'text');";
				}
			?>
		});
	});
</script>
</html>