<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--2-col"></div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Tip Details</h2>
				</div>
				<div class="mdl-card__supporting-text mdl-grid" style="text-align: left;">
					<div class="mdl-cell--4-col"></div>
					<div class="mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<textarea rows="5" id="c_name" name="c_name" class="mdl-textfield__input"><?php if(isset($edit_tip)) { echo $edit_tip[0]->iexttp_tip; } ?></textarea>
						<label class="mdl-textfield__label" for="c_name">Enter Tip</label>
					</div>
					</div>
					<div class="mdl-cell--4-col"></div>
					<div class="mdl-cell--4-col"></div>
					<div class="mdl-cell--4-col">
					<b>Tags for this tip</b>
					<div class="mdl-cell mdl-cell--12-col" style="text-align: center;margin: 0px;">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<ul id="myTags" class="mdl-textfield__input">
							<?php if (isset($edit_tag_tips)) {
									for ($j=0; $j < count($edit_tag_tips) ; $j++) { 
										$x = $edit_tag_tips[$j]->iexttt_tag_id;
									
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
					<div class="mdl-cell--4-col"></div>
					
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--2-col"></div>
		
		<?php 
			if(isset($edit_tip)) {
				echo '<div class="mdl-cell mdl-cell--2-col"></div>';
				echo '<div class="mdl-cell mdl-cell--8-col" >';
				echo '<a href="'.base_url().'education/tip_delete/'.$tid.'"><button class="mdl-button mdl-button-done mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" style="width: 100%;">Delete</button>';
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
		$('#c_name').focus();	

		$('#submit').click(function(e) {
			e.preventDefault();
			
			var customer_name = $('#c_name').val();
			var customer_info = [];

			$('#myTags > li').each(function(index) {
				var tmpstr = $(this).text();
				var len = tmpstr.length - 1;
				if(len > 0) {
					tmpstr = tmpstr.substring(0, len);
					customer_info.push(tmpstr);
				}
			});
			
			var stid = "";

			<?php if (isset($edit_tip)) {
					echo "$.post('".base_url()."education/update_tip/".$tid."', {'name' : customer_name, 'tags' : customer_info }, function(data, status, xhr) { window.location = '".base_url()."education/tips' }, 'text');";
				} else {
					echo "$.post('".base_url()."education/save_tip', {'name' : customer_name, 'tags' : customer_info }, function(data, status, xhr) { window.location = '".base_url()."education/tips'}, 'text');";
				}
			?>			
		});
	});
</script>
</html>