<style type="text/css">
	@media only screen and (max-width: 760px) {
		.general_table {
			display: block;
        	overflow: auto;
		}
	}
</style>
<main class="mdl-layout__content">
	<div class="mdl-grid">
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--4dp general_table" style="width: 100%;">
			<thead>
				<tr>
					<th class="mdl-data-table__cell--non-numeric">Campaign Name</th>
					<th class="mdl-data-table__cell--non-numeric">Date</th>
					<th style="text-align: center;">Status</th>
					<!-- <th  >Action</th> -->
				</tr>
			</thead>
			<tbody id="details"></tbody>
		</table>
	</div>

	<button class="lower-button mdl-button mdl-button-done mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--accent" id="add">
		<i class="material-icons">add</i>
	</button>
</main>
</div>
</body>

<script type="text/javascript">
	var camp_arr = [];
	var status_arr = [];
	<?php
			if (isset($brod_list)) {
				for ($i=0; $i <count($brod_list) ; $i++) { 
					echo "camp_arr.push({'id' : '".$brod_list[$i]->iebrod_id."', 'name' : '".$brod_list[$i]->iebrod_name."', 'date' : '".$brod_list[$i]->iebrod_date."'});";
				}
			}
			if (isset($status_list)) {
				for ($i=0; $i <count($status_list) ; $i++) { 
					echo "status_arr.push({'id' : '".$status_list[$i]->iebrodc_brod_id."','status' : '".$status_list[$i]->iebrodc_status."'});";
				}
			}
	?>

	$(document).ready(function() {
		display_list();
		$('#details').on('click', '.tbl_view', (function(e) {
			e.preventDefault();
			var tid = $(this).prop('id');
			window.location = "<?php echo base_url().'Broadcast/edit_broadcast/'.$code.'/'; ?>"+tid;
		}));

		$('#add').click(function (e) {
			e.preventDefault();
			window.location = "<?php echo base_url().'Broadcast/add_broadcast/'.$code.'/'; ?>";
		});

		 var a_flg = 'false';
        
        $("#act_mail").change(function(){
            if($(this).prop("checked") == true){
                a_flg = 'true';
            }else{
                a_flg = 'false';
            }
        });

         $('#submit').click(function(e) {
            e.preventDefault();
            if($('#search_modal').css('display') != 'none'){
                var note = $('#notes_text').html();
                $('#ATags > li').each(function(index) {
                    var tmpstr = $(this).text();
                    var len = tmpstr.length - 1;
                    if(len > 0) {
                        tmpstr = tmpstr.substring(0, len);
                        activity_tags.push(tmpstr);
                    }
                });
                var date = $('.s_date').val();
                var e_date = $('.e_date').val();
                $.post('<?php echo base_url()."Home/notification_activity_update/".$code."/subscription/"; ?>'+amc_id, {
                    'a_title' : $('#a_title').val(),'a_date' : date,'a_place' : $('#a_place').val(),'a_person' : person_array,'a_to_do' : todo_array,'a_note' : $('#notes_text').val() ,'a_tags' : activity_tags ,'note' : note,'a_func_short' : $('#m_shortcuts').val(),'a_mail' : a_flg ,'e_date' : e_date,'a_cat' : $('#a_cat').val()
                }, function(data, status, xhr) {
                        location.reload();
                }, 'text');
            }
        });
	});

	function display_list() {
		$('#details').empty();
		var out = "";
		for (var i = 0; i < camp_arr.length; i++) {
			out+='<tr style="color: #e60000;font-weight: bold;" class="tbl_view" id="' + camp_arr[i].id + '">';
			out+='<td class="mdl-data-table__cell--non-numeric">' + camp_arr[i].name + '</td>';
			out+='<td class="mdl-data-table__cell--non-numeric">' + camp_arr[i].date + '</td>';
			out+='<td style="text-align: center;">';
			var send=0;var fail =0;var view = 0;var total = 0;var pending = 0;
			for (var j = 0; j < status_arr.length; j++) {
				if(status_arr[j].id == camp_arr[i].id){
					total = Number(total) + 1;
					if (status_arr[j].status == 'true') {
						send = Number(send) + 1;
					}else if (status_arr[j].status == 'false'){
						fail = Number(fail) + 1;
					}else{
						pending = Number(pending) + 1;
					}
				}
			}
			out+='<button class="mdl-button mdl-button--colored " style="margin-left:10px;">Total '+total+'</button>';
			out+='<button class="mdl-button mdl-button--colored " style="margin-left:10px;">Pending '+pending+'</button>';
			out+='<button class="mdl-button mdl-button--colored " style="margin-left:10px;">Deliverd '+send+'</button>';
			out+='<button class="mdl-button mdl-button--colored" style="margin-left:10px;">Fail '+fail+'</button>';
			out+='<button class="mdl-button mdl-button--colored " style="margin-left:10px;">View '+view+'</button>';
			out+='</td>';
			out+='</tr>';
		}
		$('#details').append(out);		
	}
</script>
</html>