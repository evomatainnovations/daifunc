<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Add Term</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<textarea id="p_name" name="p_name" class="mdl-textfield__input"> <?php if (isset($edit_doc)) {echo $edit_doc[0]->iextdt_term; }?> </textarea> <label class="mdl-textfield__label" for="p_name">Enter Terms</label>
					</div>
					<?php 
						if(isset($edit_doc)) {
							echo '<div style="text-align:right;"><a href="'.base_url().'/Enterprise/delete_document_terms/'.$document.'/'.$edit_doc[0]->iextdt_id.'/'.$code.'"<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent"> <i class="material-icons">delete</i> </button></a></div>';
						}
					?>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">List of already added terms</h2>
				</div>
				<div class="mdl-card__supporting-text mdl-grid" style="text-align: left;padding: 5px;">
					<?php for ($i=0; $i < count($doc) ; $i++) { 
						echo "<a href='".base_url()."Enterprise/edit_document_terms/".$document."/".$doc[$i]->iextdt_id."/".$code."'>";
						echo '<div class="ond-card-name mdl-cell mdl-cell--12-col" style="box-shadow: 1px 1px 5px #999;padding: 15px;color:#999;">';
						echo '<span class="mdl-list__item-primary-content"> <i class="material-icons mdl-list__item-icon">label</i> </span>';
						echo $doc[$i]->iextdt_term;
						echo "</div>";
						echo "</a>";
					} ?>
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
<script>
	$(document).ready(function() {
		$('#p_name').focus();

		$('#submit').click(function(e) {
			e.preventDefault();
			$.post('<?php if (isset($edit_doc)) { echo base_url()."Enterprise/update_document_terms/".$document."/".$did."/".$code; } else { echo base_url()."Enterprise/save_document_terms/".$document."/".$code; } ?>', {
				'name' : $('#p_name').val()
			}, function(data, status, xhr) {
				window.location = '<?php echo base_url()."Enterprise/document_terms/".$document."/".$code; ?>';
			}, 'text');
		});
	});
</script>
</html>