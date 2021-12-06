<main class="mdl-layout__content">
	<!-- <div class="mdl-grid">
		<div class="mdl-cell--8-col"></div>
		<div class="mdl-cell--2-col">
			<button style="width: 100%;" id="day" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Day View</button>
		</div>
		<div class="mdl-cell--2-col">
			<button style="width: 100%;" id="month" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-js-ripple-effect mdl-button--accent">Month View</button>
		</div>
	</div> -->
	<div class="mdl-grid  mdl-card__title">
		<div class="mdl-cell mdl-cell--4-col"></div>
		<div class="mdl-cell mdl-cell--4-col">
			<!-- <div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expand" style="height: 50px;">
					<div class="mdl-cell--4-col"></div>
					<div class="mdl-cell--4-col"> -->
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="date-input">Select Date</label>
						</div>
			<!-- 		</div>
					<div class="mdl-cell--4-col"></div>
				</div>
			</div> -->
		</div>
		<div class="mdl-cell mdl-cell--4-col"></div>
	</div>
	<div class="mdl-grid record_detail_ert">
		
	</div>
	<a href="<?php echo base_url().'education/lecture_add'; ?>">
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent">
		<i class="material-icons">add</i>
	</button>
	</a>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {
		$('#date-input').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
		var dt = new Date()
		var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
		$('#date-input').val(s_dt);

		getdetails(s_dt);

		$('#date-input').change(function(e) {
			e.preventDefault();
			var dt = $('#date-input').val();
			getdetails(dt);
		});

		function getdetails(dt) {
			$.post('<?php echo base_url()."education/get_lectures/"; ?>' + dt,
				function(data, status, xhr){
				var abc = JSON.parse(data);
				var file = "";
				console.log(data);
				$('.record_detail_ert').empty();
				for (var i = 0; i < abc.length; i++) {

					var fdt = new Date(abc[i].iextls_from_date);
					var tdt = new Date(abc[i].iextls_to_date);
					
					file += '<div class="mdl-cell mdl-cell--2-col" style="text-align:left!important;"><a href="<?php echo base_url()."education/edit_lecture/"; ?>' + abc[i].iextls_id + '"><div class="mdl-card mdl-shadow--4dp"><div class="mdl-card__title mdl-card--expan" style="height:150px;"><h class="mdl-card__title-text"style="text-align:left!important;font-size:25px;">Timings:<br>' + fdt.getHours().toString() + ':' + fdt.getMinutes().toString() + '-<br>' + tdt.getHours().toString() + ':' + tdt.getMinutes().toString() + '</h></div><div class="mdl-card__supporting-text" style="text-align:left;">' + abc[i].iexts_name + '<br><br>' + abc[i].iextc_name + '<br><br>' + abc[i].ic_name + '</div></div></a></div>';
				}
				$('.record_detail_ert').append(file);

			}, "text");
		}
		

		

		$('.view-click').click(function(e) {
			e.preventDefault();

			
			var chk = $(this).prop('id');

			if(chk=="day") {
				$('#day').addClass('mdl-button--raised');
				$('#month').removeClass('mdl-button--raised');
			} else if (chk=="month") {
				$('#day').removeClass('mdl-button--raised');
				$('#month').addClass('mdl-button--raised');
			}

		});
	});
</script>

</html>