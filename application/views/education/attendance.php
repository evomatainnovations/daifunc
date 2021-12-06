<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--1-col"></div>
		<div class="mdl-cell mdl-cell--10-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title mdl-card--expan" style="height: 100px;text-align: left;">
					<h2 class="mdl-card__title-text">Select Date and Lecture / Exam</h2>
				</div>	
				<div  class="mdl-grid mdl-card__supporting-text">
					<div class="mdl-cell--5-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<input type="text" data-type="date" id="date-input" class="mdl-textfield__input">
							<label class="mdl-textfield__label" for="date-input">Select Date</label>
						</div>
					</div>
					<div class="mdl-cell--5-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="event" name="event" class="mdl-textfield__input">
								<option value="all">Select</option>
								
							</select>
							<label class="mdl-textfield__label" for="event">Select Event</label>
						</div>
					</div>
					
					<div class="mdl-cell--2-col" style="padding: 15px;text-align: center;width: 00%;">
						<span class="mdl-badge" data-badge="<?php echo $pending; ?>" id="pending_events"><b>Pending Events</b></span>
					</div>

				</div>
			</div>
		</div>
		<div class="mdl-cell--1-col"></div>
	</div>
	<div class="mdl-grid record_detail_ert">
	</div>
	<button class="lower-button mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
		<i class="material-icons">done</i>
	</button>
	
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		$('#date-input').bootstrapMaterialDatePicker({ weekStart : 0, time: false });

		var dt = new Date()
		var s_dt = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();
		$('#date-input').val(s_dt);

		$('#submit').click(function(e) {
			e.preventDefault();

			var std_att = [];
			var chkinp_att = $("input[name^='att'");
			var a = 0;
			$("input[name^='att'").each(function(){
				var aid = $(this).prop('id');
				var len = aid.length;
				aid = aid.substr(4,len);
				if(chkinp_att[a].checked) {
					std_att.push({ 'i' : aid , 'a' : 'true' });	
				} else {
					std_att.push({ 'i' : aid, 'a' : 'false' });	
				}
				a++;
			});

			var std_hmw = [];
			var chkinp_hmw = $("input[name^='hmw'");
			var b = 0;
			$("input[name^='hmw'").each(function(){
				var aid = $(this).prop('id');
				var len = aid.length;
				aid = aid.substr(4,len);
				if(chkinp_hmw[b].checked) {
					std_hmw.push({ 'i' : aid , 'h' : 'true' });	
				} else {
					std_hmw.push({ 'i' : aid, 'h' : 'false' });	
				}
				b++;
			});

			var std_pun = [];
			var chkinp_pun = $("input[name^='pun'");
			var c = 0;
			$("input[name^='pun'").each(function(){
				var aid = $(this).prop('id');
				var len = aid.length;
				aid = aid.substr(4,len);
				if(chkinp_pun[c].checked) {
					std_pun.push({ 'i' : aid , 'p' : 'true' });	
				} else {
					std_pun.push({ 'i' : aid, 'p' : 'false' });	
				}
				c++;
			});

			var std_pun_det = [];
			var d = 0;
			$("input[name^='pun_det'").each(function(){
				var aid = $(this).prop('id');
				var len = aid.length;
				aid = aid.substr(8,len);
				std_pun_det.push(aid);	
				d++;
			});

			var event_id = $('#event').val();
			var selection = event_id.substr(0,1);
			event_id = event_id.substr(1, event_id.length);


			if(selection == 'l') {
				var event_detail = "lecture";
			} else {
				var event_detail = "exam";
			}


			console.log(std_att);
			console.log(std_hmw);
			console.log(std_pun);

			$.post("<?php echo base_url().'education/save_attendance'; ?>", {
				'date' : $('#date-input').val(),
				'event' : event_detail,
				'event_id' : event_id,
				'attendance' : std_att,
				'homework' : std_hmw,
				'punishment' : std_pun
			}, function(data, status, xhr) {
				window.location = "<?php echo base_url().'education/attendance'; ?>";
			}, "text");			
		});

		$('#date-input').change(function(e) {
			e.preventDefault();

			$('#event').empty();
			$('#event').append('<option value="all">Select</option>');


			var dat = $('#date-input').val();
			var abc = $('#event').val();
			var event = abc.substr(0,1);
			if(event == "l") {
				event = "lecture";
			} else if(event == "e") {
				event = "exam";
			} else {
				event = "all";
			}

			var event_id = abc.substr(1, abc.length);
			getdata(dat, event, event_id);
		});

		var dt = $('#date-input').val();
		getdata(dt, "all", 0);

		$('#event').change(function(e) {
			e.preventDefault();

			var dat = $('#date-input').val();
			var abc = $('#event').val();
			var event = abc.substr(0,1);
			if(event == "l") {
				event = "lecture";
			} else if(event == "e") {
				event = "exam";
			} else {
				event = "all";
			}

			var event_id = abc.substr(1, abc.length);
			getdata(dat, event, event_id);
		});


		function getdata(date, event, id) {
			if(event=="all") {
				$.post('<?php echo base_url()."education/get_events_attendance/"; ?>' + date ,
				function(data, status, xhr) {
					console.log(data);

					var abc = JSON.parse(data);

					$('#event').empty();
					$('#event').append('<option value="all">Select</option>');
					var file = "";
						
					for (var i = 0; i < abc.lecture.length; i++) {
						file+='<option value="l' + abc.lecture[i].iextls_id + '">';
						if(abc.lecture[i].iextls_att_status=="false") {
							file+='(*)';
						}
						file+= 'Lecture: ' + abc.lecture[i].iexts_name +' - ' + abc.lecture[i].iextc_name + ' / ' + abc.lecture[i].iextt_name + ' Batch: ' + abc.lecture[i].iextb_batch_name + '</option>';
					}

					for (var i = 0; i < abc.exam.length; i++) {
						file += '<option value="e' + abc.exam[i].iextes_id + '">';
						if(abc.exam[i].iextes_att_status=="false") {
							file+='(*)';
						}
						
						file+= 'Exam:' + abc.exam[i].iexts_name + ' - ';
						if(abc.exam[i].iextes_type == "chapter") {
							file += abc.exam[i].iextc_name;
						} else {
							file += abc.exam[i].iextp_preliem_name;
						}
						file += 'Batch: ' + abc.exam[i].iextb_batch_name + '</option>';
					}

					$('#event').append(file);
				}, "text");
			} else {
				$.post('<?php echo base_url()."education/get_attendance/"; ?>' + date + '/' + event + '/' + id,
				function(data, status, xhr) {
					console.log(data);

					var abc = JSON.parse(data);

					$('.record_detail_ert').empty();
					for (var i = 0; i < abc.customer.length; i++) {
						var file = "";
						file +='<div class="mdl-cell mdl-cell--2-col"><div class="mdl-card mdl-shadow--4dp">';
						if(abc.customer[i].icp_path) {
							file+='<div class="mdl-card__title mdl-card--expand" style="height:180px;color:#fff;background : linear-gradient(rgba(20,20,20,.3), rgba(20,20,20, .3)), url(\'<?php echo base_url().'assets/uploads/'; ?>' + abc.oid + '/' + abc.customer[i].icp_path + '\');background-size: cover;background-repeat:no-repeat;">';	
						} else {
							file+='<div class="mdl-card__title mdl-card--expand" style="height:180px;">';
						}
					
						file+= '<h2 class="mdl-card__title-text">' + abc.customer[i].ic_name + '</h2>';
						file+= '</div>';
						file+= '<div class="mdl-card__actions mdl-card--border">';
						file+= '<div class="mdl-cell mdl-cell--12-col" style="margin:10px;"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="att_' + abc.customer[i].ic_id +'"><input type="checkbox" id="att_' + abc.customer[i].ic_id + '" class="mdl-switch__input" name="att[]"';
						
						if(abc.attendance[i]) {if(abc.attendance[i].ieea_status=="true") { file+= " checked"; } else { } }
						
						file+= '><span class="mdl-switch__label">Attendance</span></label></div>';					

						if(event=="lecture") {
							file+= '<div class="mdl-cell mdl-cell--12-col"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="hmw_' + abc.customer[i].ic_id + '"><input type="checkbox" id="hmw_' + abc.customer[i].ic_id + '" class="mdl-switch__input" name="hmw[]"';
							if(abc.homework[i]) {if(abc.homework[i].ieeh_status=="true") { file+= "checked"; } }
							file+= '><span class="mdl-switch__label">Homework</span></label></div>';

							file+= '<div class="mdl-cell mdl-cell--12-col"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="pun_' + abc.customer[i].ic_id + '"><input type="checkbox" id="pun_' + abc.customer[i].ic_id + '" class="mdl-switch__input" name="pun[]"';
							if(abc.punishment[i]) { if(abc.punishment[i].ieep_status=="true") { file+= "checked"; } }
							file+= '><span class="mdl-switch__label">Punishment</span></label></div>';

							file+= '<div class="mdl-cell mdl-cell--12-col"><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"><input type="text" name="pun_det[]" id="pun_det_' + abc.customer[i].ic_id + '" class="mdl-textfield__input" value="';
						
							if(abc.punishment[i]) {if(abc.punishment[i].ieep_details) { file+= abc.punishment[i].ieep_details; } }
							file+= '"><label class="mdl-textfield__label" for="pun_det_' + abc.customer[i].ic_id + '">Punishment Details</label></div></div>';
							
						}
						file+='<a href="<?php echo base_url().'education/get_monthly_attendance/'; ?>' + abc.customer[i].ic_id + '"><button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="submit">View Monthly</button>';
						file+= '</div></div>';
						file+= '</div>';

						$('.record_detail_ert').append(file);
					}


				}, "text");	
			}
			
		}
	});
</script>
</html>