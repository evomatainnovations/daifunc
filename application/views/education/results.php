<style type="text/css">
	.ond-card-name {
		box-shadow: 1px 1px 2px #999!important;
		border-radius: 2px!important;
		/*width: 100%;*/
		padding: 10px;
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Select Batch and Subject</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
					 		<select id="batch" class="mdl-textfield__input">
					 			<option value="none">Select</option>
					 			<?php 
									for ($i=0; $i < count($batch) ; $i++) { 
										echo '<option value="'.$batch[$i]->iextb_id.'">'.$batch[$i]->iextb_batch_name.'</option>';
									}
								?>
					 		</select>
					 		<label class="mdl-textfield__label" for="batch">Select Batch</label>
					 	</div>
					</div>
				 	<div class="mdl-cell mdl-cell--12-col">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
							<select id="subject" class="mdl-textfield__input">
					 			<option value="none">Select</option>
					 			<?php 
									for ($i=0; $i < count($subject) ; $i++) { 
										echo '<option value="'.$subject[$i]->iexts_id.'">'.$subject[$i]->iexts_name.'</option>';
									}
								?>
					 		</select>
					 		<label class="mdl-textfield__label" for="subject">Select Subject</label>
					 	</div>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Select Students</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-grid" id="students">
					</div>				
				</div> 	
			</div>
		</div>
		<div class="mdl-cell mdl-cell--4-col">
			<div class="mdl-card mdl-shadow--4dp">
				<div class="mdl-card__title" style="height: 170px;">
					<h2 class="mdl-card__title-text">Select Chapter, Preliem or External Exams</h2>
				</div>
				<div class="mdl-card__supporting-text">
					<div class="mdl-cell--12-col">
						<div class="mdl-grid">
							<div class="mdl-cell--4-col">
								<button style="width: 100%;" id="chapter" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">Chapter</button>
							</div>
							<div class="mdl-cell--4-col">
								<button style="width: 100%;" id="preliem" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-js-ripple-effect mdl-button--accent">Preliem</button>
							</div>
							<div class="mdl-cell--4-col">
								<button style="width: 100%;" id="external" class="view-click mdl-button mdl-button-upside mdl-js-button mdl-js-ripple-effect mdl-button--accent">External</button>
							</div>
						</div>
					</div>
					<div class="mdl-cell--12-col" id="view-content" style="text-align: left;">

					</div>
				</div> 	
			</div>	
		</div>
	</div>
	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="submit">
		<i class="material-icons">done</i>
	</button>
</main>
</div>
</body>

<script type="text/javascript">
	$(document).ready(function() {

		var sel_view = "chapter";

		$('.view-click').click(function(e) {
			e.preventDefault();
			var chk = $(this).prop('id');
			if(chk=="chapter") {
				$('#chapter').addClass('mdl-button--raised');
				$('#preliem').removeClass('mdl-button--raised');
				$('#external').removeClass('mdl-button--raised');

				sel_view = "chapter";

				var sid = $('#subject').val();
				get_subject_related_details(sid, sel_view);
			} else if (chk=="preliem") {
				$('#chapter').removeClass('mdl-button--raised');
				$('#preliem').addClass('mdl-button--raised');
				$('#external').removeClass('mdl-button--raised');
				
				sel_view = "preliem";

				var sid = $('#subject').val();
				get_subject_related_details(sid, sel_view);
			} else if (chk=="external") {
				$('#chapter').removeClass('mdl-button--raised');
				$('#preliem').removeClass('mdl-button--raised');
				$('#external').addClass('mdl-button--raised');
				
				sel_view = "external";

				var sid = $('#subject').val();
				get_subject_related_details(sid, sel_view);
			}
		});

		function get_subject_related_details(subject, view) {
			$.post('<?php echo base_url()."Education/result_get_subject_details"; ?>', {
				'subject' : subject,
				'view' : view
			}, function (data, status, xhr) {
				var abc = JSON.parse(data);

				$('#view-content').empty();
				var file = '<div class="mdl-grid">';
				for (var i = 0; i < abc.content.length; i++) {
					file += '<div class="mdl-cell mdl-cell--3-col"><label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="b_con' + abc.content[i].id + '"><input type="checkbox" id="' + abc.content[i].id + '" name="b_content[]" class="mdl-switch__input"><span class="mdl-switch__label">' + abc.content[i].name +'</span></label></div>';
				}
				file+="</div>";

				$('#view-content').append(file);
			}, "text");
		}

		var student_id = 0;
		var event_id = 0;
		var event_type = '';

		$('#batch').change(function(e) {
			e.preventDefault();
			var bid = $(this).val();

			$.post('<?php echo base_url()."Education/result_get_student/" ?>' + bid, 
				function(data, status, xhr) {
					var abc = JSON.parse(data);
					$('#students').empty();
					for (var i = 0; i < abc.students.length; i++) {
						$('#students').append('<div class=" stud_data ond-card-name mdl-cell mdl-cell--4-col" id="' + abc.students[i].ic_id + '"><span class="mdl-list__item-primary-content"><i class="material-icons mdl-list__item-icon">person</i>' + abc.students[i].ic_name + '</span></div>');
					}
				}, "text");
		});

		$('#subject').change(function(e) {
			e.preventDefault();

			var sid = $(this).val();
			get_subject_related_details(sid, sel_view);
		})

		$('.mdl-grid').on('click','.stud_data',(function(e) {
			e.preventDefault();
			
			student_id = $(this).prop('id');
			$('#students > .ond-card-name').css('background-color', '#fff');
			$('#students > .ond-card-name').css('color', '#999');

			$(this).css('background-color', '#999');
			$(this).css('color', '#fff');
		}));

		$('#view-content > ')

		$('#submit').click(function(e) {
			e.preventDefault();

			var chkinp = $("input[name^='b_content'");
			var b_std = [];

			var a = 0;
			$("input[name^='b_content'").each(function(){
				console.log(chkinp);
				if(chkinp[a].checked) {
					b_std.push($(this).prop('id'));	
				}
				a++;
			});
			
			var std_url = b_std.join('~');

			window.location = "<?php echo base_url().'Education/result_generate_student/'; ?>" + student_id + '/' + sel_view + '/' + std_url;
		});
	})
</script>
</html>