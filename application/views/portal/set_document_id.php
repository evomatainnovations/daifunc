<main class="mdl-layout__content">
	<div class="mdl-grid"  id="add_section">
		<!-- GENERAL DETAILS -->
		<?php 
			for ($i=0; $i < count($doc_id) ; $i++) { 
				if ($doc_id[$i]->iumdi_variable == "true") {
					echo '<div class="mdl-cell mdl-cell--4-col"><div class="mdl-grid"><div class="mdl-cell mdl-cell--4-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="v'.$i.'">A Variable Value</label><input type="checkbox" id="v'.$i.'" name="v_name[]" class="mdl-textfield__input" checked/></div></div><div class="mdl-cell mdl-cell--8-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="'.$i.'">Enter Section</label><input type="text" id="'.$i.'" name="c_name[]" class="mdl-textfield__input" value="'.$doc_id[$i]->iumdi_doc_syntax.'" /></div></div></div></div>';
				} else if($doc_id[$i]->iumdi_variable == "false") {
					echo '<div class="mdl-cell mdl-cell--4-col"><div class="mdl-grid"><div class="mdl-cell mdl-cell--4-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="v'.$i.'">A Variable Value</label><input type="checkbox" id="v'.$i.'" name="v_name[]" class="mdl-textfield__input"/></div></div><div class="mdl-cell mdl-cell--8-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="'.$i.'">Enter Section</label><input type="text" id="'.$i.'" name="c_name[]" class="mdl-textfield__input" value="'.$doc_id[$i]->iumdi_doc_syntax.'"/></div></div></div></div>';
				}
			}
		?>		
	</div>
	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" id="add">Add Section</button>
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
		<i class="material-icons">done</i>
	</button>
</main>
</div>
</body>
<script>
	$(document).ready(function() {

		var prp_id = 0;
		$('#add').click(function(e) {
			e.preventDefault();
			$('#add_section').append('<div class="mdl-cell mdl-cell--4-col"><div class="mdl-grid"><div class="mdl-cell mdl-cell--4-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="v' + prp_id + '">A Variable Value</label><input type="checkbox" id="v' + prp_id + '" name="v_name[]" class="mdl-textfield__input" /></div></div><div class="mdl-cell mdl-cell--8-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><label class="" for="' + prp_id + '">Enter Section</label><input type="text" id="' + prp_id + '" name="c_name[]" class="mdl-textfield__input" /></div></div></div></div>');

			prp_id++;

		});

		$('#submit').click(function(e) {
			e.preventDefault();

			var doc_section = [];
			$("input[name^='c_name']").each(function(){
				doc_section.push($(this).val());
			});
			
			var doc_variable = [];
			var doc_check_id = 0;
			$("input[name^='v_name']").each(function(){
				
				if($("input[name^='v_name']")[doc_check_id].checked == true) {
					doc_variable.push("true");
				} else {
					doc_variable.push("false");
				}
				
				doc_check_id++;
			});
			
			$.post('<?php echo base_url()."Portal/update_document_id/".$cid."/".$mid; ?>', {
				"doc_section" : doc_section,
				"doc_variable" : doc_variable
			}, function(data, status, xhr) {
				if(status == "success") {
					window.location = "<?php echo base_url().'Portal/create_document_id'; ?>";
				}
			}, "text");
		});
	});
</script>

</html>