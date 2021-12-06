<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<h4>Write a property name that you want to preload when adding a <?php echo $thing; ?></h4>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input type="text" id="c_name" name="c_name" class="mdl-textfield__input" value="">
				<label class="mdl-textfield__label" for="c_name">Property Name</label>
			</div>
			<button class="mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="submit">Save Property</button>
		</div>
		<div class="mdl-cell mdl-cell--4-col"></div>
		
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<p><?php echo $thing; ?> Properties</p>
			<div id="b_chips">
				<?php 
					for ($i=0; $i < count($property) ; $i++) { 
						echo '<span id="spn'.$property[$i]->ip_id.'" class="mdl-chip mdl-chip--deletable" style="margin:10px;"><span class="mdl-chip__text">'.$property[$i]->ip_property.'</span><button type="button" class="mdl-chip__action" id="'.$property[$i]->ip_id.'"><i class="material-icons">cancel</i></button></span>';
					}
				?>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col"></div>

		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col" style="text-align: center;">
			
		</div>			
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
</div>
</div>
</body>
<script>
	$(document).ready(function() {
		$('#b_chips').on('click', '.mdl-chip__action', (function(e) {
			var studid = $(this).prop('id');
			var rmv = '#spn' + studid;

			$.post('<?php echo base_url()."education/remove_property/".$thing; ?>', {
				'pid' : studid
			}, function(data, status, xhr) {
				
				var abc = JSON.parse(data);
				$('#b_chips').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#b_chips').append('<span id="spn' + abc[i].ip_id +'" class="mdl-chip mdl-chip--deletable" style="margin:10px;"><span class="mdl-chip__text">' + abc[i].ip_property + '</span><button type="button" class="mdl-chip__action" id="' + abc[i].ip_id + '"><i class="material-icons">cancel</i></button></span>');
				}
				

			}, 'text');
			
			$(rmv).remove();
		}));

		$('#submit').click(function(e) {
			$.post('<?php echo base_url()."education/save_property/".$thing."/".$code; ?>', {
				'p_property' : $('#c_name').val()
			}, function(data, status, xhr) {
				
				var abc = JSON.parse(data);
				$('#b_chips').empty();
				for (var i = 0; i < abc.length; i++) {
					$('#b_chips').append('<span id="spn' + abc[i].ip_id +'" class="mdl-chip mdl-chip--deletable" style="margin:10px;"><span class="mdl-chip__text">' + abc[i].ip_property + '</span><button type="button" class="mdl-chip__action" id="' + abc[i].ip_id + '"><i class="material-icons">cancel</i></button></span>');
				}
			}, "text");
			
		});
	});
</script>
</html>