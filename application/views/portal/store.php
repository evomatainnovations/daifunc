<main class="mdl-layout__content">
	<div class="mdl-grid">
		<!-- GENERAL DETAILS -->
		<div class="mdl-cell mdl-cell--12-col">
			<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp" style="width: 100%;">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Name</th>
						<th class="mdl-data-table__cell--non-numeric">Modules</th>
						<th class="mdl-data-table__cell--non-numeric" style="text-align: right;">Action</th>
					</tr>
				</thead>
				<tbody id="store">
					<?php
						// for ($i=0; $i < count($store) ; $i++) { 
						// 	echo '<tr class="click_customer">';
						// 	echo '<td class="mdl-data-table__cell--non-numeric">'.$store[$i]->i_uname;
						// 	echo '<td class="mdl-data-table__cell--non-numeric">'.$store[$i]->im_name;
						// 	echo '<td class="mdl-data-table__cell--non-numeric" style="text-align: right;"><button class="mdl-button action" id="y'.$store[$i]->im_id.$store[$i]->i_uid.'"><i class="material-icons">done</i></button><button class="mdl-button action" id="n'.$store[$i]->im_id.$store[$i]->i_uid.'"><i class="material-icons">delete</i></button>';
						// 	echo "</tr>";
						// }
					?>
				</tbody>
			</table>

		</div>
		<a href="<?php echo base_url().'Portal/store_add'; ?>">
			<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
				<i class="material-icons">add</i>
			</button>
		</a>
	</div>
</main>
</div>
</body>
<script>
	var details_arr = [];
	<?php
			if (isset($store)) {
				for ($i=0; $i <count($store) ; $i++) { 
					echo "details_arr.push({'id' : ".$i.", 'uid' : ".$store[$i]->i_uid.", 'mid' : ".$store[$i]->im_id.", 'uname' : '".$store[$i]->i_uname."', 'mname' : '".$store[$i]->im_name."'});";	
				}		
			}
	?>
	$(document).ready(function() {
		load();
		$('#store').on('click','.action',function(e) {
			e.preventDefault();
			var cid = $(this).prop('id');
			var action = cid.slice(0,1);
			var mod_id = cid.slice(1,3);
			var u_id = cid.slice(3,cid.lenght);

			$.post("<?php echo base_url().'Portal/request_action'; ?>", {
				'action' : action, 'mod_id' : mod_id, 'u_id' : u_id
			}, function(data, status, xhr) {
				details_arr = [];
				var a = JSON.parse(data);
				for (var i = 0; i < a.store.length; i++) {
					details_arr.push({ id : i, uid : a.store[i].i_uid, mid : a.store[i].im_id, uname : a.store[i].i_uname, mname : a.store[i].im_name});
				}
				load();
			})
			// window.location = "<?php //echo base_url().'Portal/edit_customer/'; ?>"+ cid;
		});

		function load(){
			var out = '';
			for (var i = 0; i < details_arr.length; i++) {
				out+= '<tr class="click_customer">';
				out+= '<td class="mdl-data-table__cell--non-numeric">'+details_arr[i].uname;
				out+= '<td class="mdl-data-table__cell--non-numeric">'+details_arr[i].mname;
				out+= '<td class="mdl-data-table__cell--non-numeric" style="text-align: right;"><button class="mdl-button action" id="y'+details_arr[i].mid+details_arr[i].uid+'"><i class="material-icons">done</i></button><button class="mdl-button action" id="n'+details_arr[i].mid+details_arr[i].uid+'"><i class="material-icons">delete</i></button>';
				out+= "</tr>";	
			}
			$('#store').empty();
			$('#store').append(out);
			
		}
	});
</script>

</html>