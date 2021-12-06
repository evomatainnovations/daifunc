<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title">
					<h2 class="mdl-card__title-text">Invite User</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="u_name" name="u_name" class="mdl-textfield__input" value="">
						<label class="mdl-textfield__label" for="u_name">Username</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="e_name" name="e_name" class="mdl-textfield__input" value="">
						<label class="mdl-textfield__label" for="e_name">Email</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<input type="text" id="p_name" name="p_name" class="mdl-textfield__input" value="">
						<label class="mdl-textfield__label" for="p_name">Password</label>
					</div>
					<div class="mdl-textfield mdl-js-textfield">
					    <input class="mdl-textfield__input" type="text" name="p_number" pattern="-?[0-9]*(\.[0-9]+)?" id="p_number" value="">
					    <label class="mdl-textfield__label" for="p_number">Phone number</label>
					    <span class="mdl-textfield__error">Input is not a number!</span>
					</div>
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						<select class="mdl-textfield__input" id="t_name" name="t_name">
							<option value="null">Select</option>
							<option value="admin">Admin</option>
							<option value="user">User</option>
							<option value="developer">Developer</option>
						</select>
						<label class="mdl-textfield__label" for="t_name">User Type</label>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--8-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Email</th>
						<th class="mdl-data-table__cell--non-numeric">Type</th>
					</tr>
				</thead>	
				<tbody>
					<?php
						for ($i=0; $i < count($users) ; $i++) { 
							
							if ($users[$i]->ia_general=='true') {
								echo '<tr id="'.$users[$i]->ia_id.'" class="click_customer">';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$users[$i]->ia_uname.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">User</td>';
								echo "</tr>";
							}elseif ($users[$i]->ia_developer=='true'){
								echo '<tr id="'.$users[$i]->ia_id.'" class="click_customer">';
								echo '<td class="mdl-data-table__cell--non-numeric">'.$users[$i]->ia_uname.'</td>';
								echo '<td class="mdl-data-table__cell--non-numeric">Developer</td>';
								echo "</tr>";
							}
							
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
	<div id="demo-snackbar-example" class="mdl-js-snackbar mdl-snackbar" style="z-index: 100000000000;">
		<div class="mdl-snackbar__text"></div>
		<button class="mdl-snackbar__action" type="button"></button>
	</div>
</div>
</body>
<script>
	var snackbarContainer = document.querySelector('#demo-snackbar-example');
	$(document).ready(function() {
		// $('.click_customer').click(function(e) {
		// 	e.preventDefault();

		// 	var cid = $(this).prop('id');

		// 	window.location = "<?php //echo base_url().'Portal/'; ?>"
		// });

		$('#submit').click(function(e) {
			e.preventDefault();

			$.post("<?php echo base_url().'Portal/invite_user/'; ?>", {
				'u_name' : $('#u_name').val(),
				'e_name' : $('#e_name').val(),
				'p_name' : $('#p_name').val(),
				'p_number' : $('#p_number').val(),
				't_name'  : $('#t_name').val()
			}, function(data, status, xhr) {
				if (data=='true') {
					var ert = {message: 'Successfully register.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else if (data=='exist'){
					var ert = {message: 'Registration already done.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else if(data == 'email'){
					var ert = {message: 'Please enter mail id.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else if(data == 'type'){
					var ert = {message: 'Please select type for user.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}else if(data == 'both'){
					var ert = {message: 'Please enter mail id and select type for user.',timeout: 4000,}; 
					snackbarContainer.MaterialSnackbar.showSnackbar(ert);
				}
			}, "text");
		});
	});
</script>

</html>